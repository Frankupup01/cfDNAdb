<?php
session_start();
$DS = DIRECTORY_SEPARATOR;
require dirname(__DIR__) . "{$DS}app{$DS}Db.class.php";
require dirname(__DIR__) . "{$DS}app{$DS}Func.php";

// ======= DataTables 固定参数 =======
$draw = $_POST['draw'] ?? 1;
$row = $_POST['start'] ?? 0;
$rowperpage = $_POST['length'] ?? 10;

// 排序
$columnIndex = $_POST['order'][0]['column'] ?? 0;
$columnName = $_POST['columns'][$columnIndex]['data'] ?? 'ID';
$columnSortOrder = $_POST['order'][0]['dir'] ?? 'asc';

// ======= 自定义参数 (前端传过来的) =======
$type = $_POST['type'] ?? '';
$keyword = $_POST['keyword'] ?? '';
$keywordLike = "%{$keyword}%";

// 允许搜索的字段（避免 SQL 注入）
$allowedColumns = [
    'ID', 'Disease', 'Category', 'marker_type', 'Source',
    'Clinical_value', 'Country', 'biomarker_ID', 'features'
];

if (!in_array($type, $allowedColumns)) {
    echo json_encode([
        "draw" => intval($draw),
        "iTotalRecords" => 0,
        "iTotalDisplayRecords" => 0,
        "aaData" => []
    ]);
    exit;
}

$table = "all_data";

// ======= 统计总数（不带搜索条件） =======
$totalRecords = Db::table($table)->count();

// ======= 搜索条件 =======
$map = [];
$map[] = [$type, '=', $keyword];

// ======= 搜索后的总数 =======
$totalRecordwithFilter = Db::table($table)
    ->where($map)
    ->count();

// ======= 获取分页数据 =======
$result = Db::table($table)
    ->where($map)
    ->field("biomarker_ID, ID, Category, marker_type, features, Source, Disease, Clinical_value, Country")
    ->order("{$columnName} {$columnSortOrder}")
    ->limit($row, $rowperpage)
    ->select();

// ======= 返回 JSON =======
echo json_encode([
    "draw" => intval($draw),
    "iTotalRecords" => $totalRecords,
    "iTotalDisplayRecords" => $totalRecordwithFilter,
    "aaData" => $result
], JSON_UNESCAPED_UNICODE);
