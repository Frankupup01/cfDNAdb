<?php
session_start();

$DS = DIRECTORY_SEPARATOR;
require dirname(__DIR__) . "{$DS}app{$DS}Db.class.php";
require dirname(__DIR__) . "{$DS}app{$DS}Func.php";

header('Content-Type: application/json; charset=utf-8');

$category = trim($_POST['category'] ?? '');
$column   = trim($_POST['column'] ?? '');
$value    = trim($_POST['value'] ?? '');

if ($category === '' || $column === '' || $value === '') {
    echo json_encode([
        "success" => false,
        "message" => "参数缺失（需要 category, column, value）"
    ]);
    exit;
}

// 允许查询的列白名单，防止 SQL 注入
$allowedColumns = [
    'Source' => 'Source',
    'Clinical_value' => 'Clinical_value',
    'Disease' => 'Disease',
];

if (!array_key_exists($column, $allowedColumns)) {
    echo json_encode([
        "success" => false,
        "message" => "不支持的 column 值"
    ]);
    exit;
}

$dbColumn = $allowedColumns[$column];

try {

    // --- 核心修改点：加入获取相同ID数量及拼接 biomarker_ID 的子查询 ---
    $fieldStr = "
        ID,
        biomarker_ID,
        Category,
        marker_type,
        features,
        Source,
        Disease,
        Clinical_value,
        (SELECT COUNT(*) FROM all_data AS t2 WHERE t2.ID = all_data.ID) AS related_count,
        (SELECT GROUP_CONCAT(biomarker_ID) FROM all_data AS t2 WHERE t2.ID = all_data.ID) AS related_bids
    ";

    $map = [];
    $map[] = ['Category', '=', $category];
    $map[] = [$dbColumn, '=', $value];

    $result = Db::table('all_data')
        ->where($map)
        ->field($fieldStr)
        ->select();

    // 备用方案：如果你的 Db 框架不支持上面那种带子查询的 field 字符串，导致报错，
    // 请注释掉上面 $result = Db::table... 的代码，改用下面这段原生的 PDO 方式执行：
    /*
    $sql = "SELECT {$fieldStr} FROM all_data WHERE Category = ? AND {$dbColumn} = ?";
    $stmt = Db::$pdo->prepare($sql);
    $stmt->execute([$category, $value]);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    */

    if ($result === false) {
        echo json_encode([
            "success" => false,
            "message" => "数据库查询失败"
        ]);
        exit;
    }

    // 词云只需要 id，用于统计
    $stat = [];
    foreach ($result as $r) {
        $stat[] = ['id' => $r['ID'] ?? null];
    }

    echo json_encode([
        "success" => true,
        "data" => [
            "raw"  => $result,   // 下方详情表（现已包含 related_count 和 related_bids）
            "stat" => $stat      // 右侧统计（词云和计数）
        ]
    ]);
    exit;

} catch (Exception $e) {
    echo json_encode([
        "success" => false,
        "message" => "后端异常: " . $e->getMessage()
    ]);
    exit;
}