<?php
session_start();
$DS = DIRECTORY_SEPARATOR;
require dirname(__DIR__) . "{$DS}app{$DS}Db.class.php";
require dirname(__DIR__) . "{$DS}app{$DS}Func.php";

// 1. 接收前端发来的所有搜索参数 (包括基础搜索和全局搜索)
$search_type = $_POST['search_type'] ?? '';
$search_field = $_POST['search_field'] ?? '';
$search_val = $_POST['search_val'] ?? '';
$global_query = $_POST['global_query'] ?? ''; // 新增：接收全局搜索参数

$where_clauses = [];
$params = [];

// --- A. 处理基础搜索 (Basic Search) ---
if (!empty($search_type)) {
    $where_clauses[] = "marker_type = ?";
    $params[] = $search_type;
}

$allowedFields = ['Source', 'Disease', 'Clinical_value', 'Category']; // 白名单
if (!empty($search_field) && in_array($search_field, $allowedFields) && !empty($search_val)) {
    $where_clauses[] = "$search_field = ?";
    $params[] = $search_val;
}

// --- B. 处理全局模糊搜索 (Global Search) ---
if (!empty($global_query)) {
    // 几乎包含所有文本列的白名单
    $globalSearchCols = ['biomarker_ID', 'ID', 'Category', 'marker_type', 'Source', 'Disease', 'Clinical_value', 'features', 'Treatment', 'Stage', 'Country', 'Genomic_sequence', 'Discription'];
    $globalLikes = [];

    foreach ($globalSearchCols as $col) {
        $globalLikes[] = "$col LIKE ?";
        $params[] = '%' . $global_query . '%';
    }
    // 把所有的 LIKE 用 OR 连起来，外层套括号
    $where_clauses[] = "(" . implode(" OR ", $globalLikes) . ")";
}

// 保存此时的基础条件和参数，用于统计原始数据总量 (iTotalRecords)
$base_where_sql = empty($where_clauses) ? "" : "WHERE " . implode(" AND ", $where_clauses);
$base_params = $params;


// 2. DataTables 请求参数 (分页)
$draw = intval($_POST['draw']);
$row = intval($_POST['start']);
$rowperpage = intval($_POST['length']);

// 3. 排序处理
$order_sql = "";
if (isset($_POST['order']) && count($_POST['order'])) {
    $columnIndex = intval($_POST['order'][0]['column']);
    $columnName = $_POST['columns'][$columnIndex]['data'];
    $columnSortOrder = $_POST['order'][0]['dir'] === 'asc' ? 'ASC' : 'DESC';

    // 防止排序字段注入
    $validOrderColumns = ['biomarker_ID', 'ID', 'Category', 'marker_type', 'Source', 'Disease', 'Clinical_value', 'features'];
    if (in_array($columnName, $validOrderColumns)) {
        $order_sql = "ORDER BY `$columnName` $columnSortOrder";
    }
}

// --- C. 处理右上角 DataTables 自己的二次搜索框 ---
$searchValue = $_POST['search']['value'] ?? '';
if (!empty($searchValue)) {
    $dtSearchCols = ['biomarker_ID', 'Category', 'marker_type', 'Source', 'Disease', 'Clinical_value', 'features'];
    $dtLikes = [];
    foreach ($dtSearchCols as $col) {
        $dtLikes[] = "$col LIKE ?";
        $params[] = '%' . $searchValue . '%';
    }
    // 叠加在前面的条件上
    $where_clauses[] = "(" . implode(" OR ", $dtLikes) . ")";
}

// 最终的完整 WHERE 条件 (用于实际查数据和计算过滤后总数)
$final_where_sql = empty($where_clauses) ? "" : "WHERE " . implode(" AND ", $where_clauses);


// 4. 查询数据库
Db::connect();

// 总记录数 (受 基础搜索 或 全局搜索 影响)
$total_sql = "SELECT COUNT(*) FROM all_data $base_where_sql";
$stmt = Db::$pdo->prepare($total_sql);
$stmt->execute($base_params);
$totalRecords = $stmt->fetchColumn();

// 过滤后记录数 (受 基础+全局+二次搜索框 共同影响)
$filtered_sql = "SELECT COUNT(*) FROM all_data $final_where_sql";
$stmt = Db::$pdo->prepare($filtered_sql);
$stmt->execute($params);
$totalRecordwithFilter = $stmt->fetchColumn();

// 真实数据
$data_sql = "SELECT biomarker_ID, Category, marker_type, Source, Disease, Clinical_value, features
             FROM all_data 
             $final_where_sql 
             $order_sql 
             LIMIT $rowperpage OFFSET $row";
$stmt = Db::$pdo->prepare($data_sql);
$stmt->execute($params);
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

// 5. 返回 JSON 给 DataTables
$response = array(
    "draw" => $draw,
    "iTotalRecords" => intval($totalRecords), // 总数
    "iTotalDisplayRecords" => intval($totalRecordwithFilter), // 过滤后总数
    "aaData" => $result // 实际展示的数据
);

echo json_encode($response, JSON_UNESCAPED_UNICODE);
?>