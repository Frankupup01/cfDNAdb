<?php
session_start();
$DS = DIRECTORY_SEPARATOR;
require dirname(__DIR__) . "{$DS}app{$DS}Db.class.php";
require dirname(__DIR__) . "{$DS}app{$DS}Func.php";

// 1. 接收前端 DataTable 发来的基础搜索条件
$search_type = $_POST['search_type'] ?? '';
$search_field = $_POST['search_field'] ?? '';
$search_val = $_POST['search_val'] ?? '';

// 2. 组装固定的查询条件 ($map)
$map = [];

// Step 1: Marker Type 过滤 (假设列名叫 marker_type)
if (!empty($search_type)) {
    $map[] = ['marker_type', '=', $search_type];
}

// Step 2 & 3: 动态字段过滤 (验证字段名以防止 SQL 注入)
$allowedFields = ['Source', 'Disease', 'Clinical_value', 'Category']; // 白名单
if (!empty($search_field) && in_array($search_field, $allowedFields) && !empty($search_val)) {
    // 因为这几个字段的数据可能像你之前说的那样是拆分好的，直接用精确匹配或 LIKE 均可，这里用 = 保证精准
    $map[] = [$search_field, '=', $search_val];
}

// 3. DataTables 请求参数
$draw = intval($_POST['draw']);
$row = intval($_POST['start']);
$rowperpage = intval($_POST['length']);

// 排序处理
$order_sql = "";
if (isset($_POST['order']) && count($_POST['order'])) {
    $columnIndex = intval($_POST['order'][0]['column']);
    $columnName = $_POST['columns'][$columnIndex]['data'];
    $columnSortOrder = $_POST['order'][0]['dir'] === 'asc' ? 'ASC' : 'DESC';

    // 防止排序字段注入
    $validOrderColumns = ['biomarker_ID', 'ID', 'Category', 'marker_type', 'Source', 'Disease', 'Clinical_value', 'features'];
    if (in_array($columnName, $validOrderColumns)) {
        $order_sql = "ORDER BY $columnName $columnSortOrder";
    }
}

// 全局搜索框处理
$searchValue = $_POST['search']['value'] ?? '';
$where_sql = "";
$params = [];

// 组装 WHERE 语句
$where_clauses = [];

// 将前面的 $map 条件转为原生的 SQL WHERE 语句
foreach ($map as $condition) {
    $field = $condition[0];
    $operator = $condition[1];
    $val = $condition[2];

    $where_clauses[] = "$field $operator ?";
    $params[] = $val;
}

// 处理右上角 DataTables 自己的全局搜索框
if (!empty($searchValue)) {
    $searchColumns = ['biomarker_ID', 'Category', 'marker_type', 'Source', 'Disease', 'Clinical_value', 'features'];
    $likeClauses = [];
    foreach ($searchColumns as $col) {
        $likeClauses[] = "$col LIKE ?";
        $params[] = '%' . $searchValue . '%';
    }
    // 把所有的 LIKE 用 OR 连起来，外层套括号
    $where_clauses[] = "(" . implode(" OR ", $likeClauses) . ")";
}

if (!empty($where_clauses)) {
    $where_sql = "WHERE " . implode(" AND ", $where_clauses);
}

// 4. 查询数据库 (改用原生 PDO 以便更灵活控制参数)
Db::connect();

// 总记录数 (只受 $map 影响)
$total_map_clauses = [];
$total_params = [];
foreach ($map as $condition) {
    $total_map_clauses[] = "{$condition[0]} {$condition[1]} ?";
    $total_params[] = $condition[2];
}
$total_where = empty($total_map_clauses) ? "" : "WHERE " . implode(" AND ", $total_map_clauses);
$total_sql = "SELECT COUNT(*) FROM all_data $total_where";
$stmt = Db::$pdo->prepare($total_sql);
$stmt->execute($total_params);
$totalRecords = $stmt->fetchColumn();

// 过滤后记录数 (受 $map + 全局搜索 影响)
$filtered_sql = "SELECT COUNT(*) FROM all_data $where_sql";
$stmt = Db::$pdo->prepare($filtered_sql);
$stmt->execute($params);
$totalRecordwithFilter = $stmt->fetchColumn();

// 真实数据
$data_sql = "SELECT biomarker_ID, Category, marker_type, Source, Disease, Clinical_value, features
             FROM all_data 
             $where_sql 
             $order_sql 
             LIMIT $rowperpage OFFSET $row";
$stmt = Db::$pdo->prepare($data_sql);
$stmt->execute($params);
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

// 5. 返回 JSON 给 DataTables
$response = array(
    "draw" => $draw,
    "iTotalRecords" => $totalRecords, // 总数
    "iTotalDisplayRecords" => $totalRecordwithFilter, // 过滤后总数
    "aaData" => $result // 实际展示的数据
);

echo json_encode($response, JSON_UNESCAPED_UNICODE);
?>