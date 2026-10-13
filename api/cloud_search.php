<?php
session_start();
$DS = DIRECTORY_SEPARATOR;
require dirname(__DIR__) . "{$DS}app{$DS}Db.class.php";
require dirname(__DIR__) . "{$DS}app{$DS}Func.php";

// 接收参数
$keyword = $_POST['keyword'] ?? '';
$draw = $_POST['draw'] ?? 1;
$row = $_POST['start'] ?? 0;
$rowperpage = $_POST['length'] ?? 10;
$columnIndex = $_POST['order'][0]['column'] ?? 0;
$columnName = $_POST['columns'][$columnIndex]['data'] ?? 'ID';
$columnSortOrder = $_POST['order'][0]['dir'] ?? 'asc';
$searchValue = $_POST['search']['value'] ?? '';

$keywordQuery = "%$keyword%";
$searchQuery = "%$searchValue%";

// ---------- 总记录数 ----------
$totalRecords = Db::table('all_data')->count();

// ---------- 过滤条件 ----------
$whereKeyword = function ($query) use ($keywordQuery) {
    $query->whereOr([
        ['biomarker_ID', 'like', $keywordQuery],
        ['ID', 'like', $keywordQuery],
        ['Category', 'like', $keywordQuery],
        ['marker_type', 'like', $keywordQuery],
        ['Source', 'like', $keywordQuery],
        ['Disease', 'like', $keywordQuery],
        ['Clinical_value', 'like', $keywordQuery],
        ['Country', 'like', $keywordQuery],
    ]);
};
$whereSearch = function ($query) use ($searchQuery) {
    $query->whereOr([
        ['biomarker_ID', 'like', $searchQuery],
        ['ID', 'like', $searchQuery],
        ['Category', 'like', $searchQuery],
        ['marker_type', 'like', $searchQuery],
        ['Source', 'like', $searchQuery],
        ['Disease', 'like', $searchQuery],
        ['Clinical_value', 'like', $searchQuery],
        ['Country', 'like', $searchQuery],
    ]);
};

// ---------- 符合条件记录数 ----------
$totalRecordwithFilter = Db::table('all_data')
    ->where($whereKeyword)
    ->where($whereSearch)
    ->count();

// ---------- 查询结果 ----------
$result = Db::table('all_data')
    ->where($whereKeyword)
    ->where($whereSearch)
    ->field('biomarker_ID, ID, Category, marker_type, Source, Disease, Clinical_value, Country')
    ->order($columnName . ' ' . $columnSortOrder)
    ->limit($row, $rowperpage)
    ->select();

// ---------- 返回 JSON ----------
$response = [
    "draw" => intval($draw),
    "iTotalRecords" => $totalRecords,
    "iTotalDisplayRecords" => $totalRecordwithFilter,
    "aaData" => $result
];

echo json_encode($response, JSON_UNESCAPED_UNICODE);
