<?php
session_start();

$DS = DIRECTORY_SEPARATOR;
require dirname(__DIR__)."{$DS}app{$DS}Db.class.php";
require dirname(__DIR__)."{$DS}app{$DS}Func.php";

/*
前端传入：
- category     （一级节点，对应 all_data.Category）
- sub_type     （二级节点：Source / Clinical value / Disease）
- keyword      （三级节点的具体值）
*/

$category    = $_POST['category'] ?? '';
$subType     = $_POST['sub_type'] ?? '';
$keyword     = $_POST['keyword'] ?? '';

if ($category === '' || $subType === '' || $keyword === '') {
    echo json_encode([
        "status" => "error",
        "msg" => "参数缺失"
    ]);
    exit;
}


// ===== 二级名称到数据库列名的映射 =====
// Source → Source
// Clinical value → Clinical_value
// Disease → Disease
$columnMap = [
    "Source"         => "Source",
    "Clinical value" => "Clinical_value",
    "Disease"        => "Disease"
];

if (!array_key_exists($subType, $columnMap)) {
    echo json_encode([
        "status" => "error",
        "msg" => "未知 sub_type"
    ]);
    exit;
}

$dbColumn = $columnMap[$subType];


// ===== 组合 where 条件 =====
$map = [];
$map[] = ['Category', '=', $category];
$map[] = [$dbColumn, '=', $keyword];


// ===== 查询 all_data 数据 ====
$result = Db::table('all_data')
    ->where($map)
    ->field('id,' . $dbColumn)
    ->select();

// 若无数据
if (!$result || count($result) === 0) {
    echo json_encode([
        "status" => "ok",
        "ids" => [],
        "stat" => []
    ]);
    exit;
}


// ===== 统计 keyword 次数 =====
$countMap = [];
foreach ($result as $row) {
    $value = $row[$dbColumn];
    if (!isset($countMap[$value])) {
        $countMap[$value] = 0;
    }
    $countMap[$value]++;
}


// ===== 结果返回 =====
echo json_encode([
    "status" => "ok",
    "ids" => array_column($result, "id"),
    "stat" => $countMap  // 给前端用于绘图
]);
