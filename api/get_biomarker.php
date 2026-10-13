<?php
header('Content-Type: application/json; charset=utf-8');
session_start();

$DS = DIRECTORY_SEPARATOR;

// 引入文件
require dirname(__DIR__) . "{$DS}app{$DS}Db.class.php";
require dirname(__DIR__) . "{$DS}app{$DS}Func.php";

// 1. 检查参数
if (!isset($_POST['id'])) {
    echo json_encode(['error' => 'Missing id']);
    exit;
}

$bio_id = trim($_POST['id']);

try {
    // 构建带有子查询的字段选择
    // 这与 search_biomarkers.php 中的逻辑一致，用于在前端生成浮窗
    $fieldStr = "
        *,
        (SELECT COUNT(*) FROM all_data AS t2 WHERE t2.ID = all_data.ID) AS related_count,
        (SELECT GROUP_CONCAT(biomarker_ID) FROM all_data AS t2 WHERE t2.ID = all_data.ID) AS related_bids
    ";

    $row = Db::table('all_data')
        ->where([ ['biomarker_ID', '=', $bio_id] ])
        ->field($fieldStr)
        ->find();

    // 备用方案：如果你的 Db 框架不支持上面那种带子查询的 field 字符串导致报错，
    // 请注释掉上面 $row = Db::table... 的代码，改用下面这段原生的 PDO 方式执行：
    /*
    $sql = "SELECT *,
            (SELECT COUNT(*) FROM all_data AS t2 WHERE t2.ID = all_data.ID) AS related_count,
            (SELECT GROUP_CONCAT(biomarker_ID) FROM all_data AS t2 WHERE t2.ID = all_data.ID) AS related_bids
            FROM all_data WHERE biomarker_ID = ?";
    $stmt = Db::$pdo->prepare($sql);
    $stmt->execute([$bio_id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    */

    if ($row) {
        echo json_encode($row, JSON_UNESCAPED_UNICODE);
    } else {
        echo json_encode(['error' => 'No record found']);
    }

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
?>