<?php
require dirname(__DIR__) . "/app/Db.class.php";
require dirname(__DIR__) . "/app/Func.php";
Db::connect();
header("Content-Type: application/json; charset=utf-8");


$draw = intval($_POST['draw'] ?? 1);
$start = intval($_POST['start'] ?? 0);
$length = intval($_POST['length'] ?? 10);


$types = $_POST['types'] ?? [];
$status = $_POST['status'] ?? [];
$biofluid = $_POST['biofluid'] ?? [];
$disease = $_POST['disease'] ?? [];
$category = $_POST['category'] ?? [];





$where = [];
$params = [];


$searchValue = $_POST['search']['value'] ?? '';
if (!empty($searchValue)) {
    // 你想要搜索的所有列名
    $searchableColumns = [
        'biomarker_ID',
        'Category',
        'marker_type',
        'Source',
        'Disease',
        'Clinical_value',
        'features'
    ];

    $likeClauses = [];
    foreach ($searchableColumns as $col) {
        $likeClauses[] = "$col LIKE ?";
        // 为每个列绑定带 % 的模糊搜索参数
        $params[] = '%' . $searchValue . '%';
    }

    // 把所有 OR 条件用括号括起来，作为一个整体加入 WHERE
    $where[] = "(" . implode(" OR ", $likeClauses) . ")";
}
/* ========================================================= */


/* 1. Marker Type → marker_type */
if (!empty($types)) {
    $placeholders = implode(",", array_fill(0, count($types), "?"));
    $where[] = "marker_type IN ($placeholders)";
    $params = array_merge($params, $types);
}

/* 2. Clinical Value → Clinical_value */
if (!empty($status)) {
    $placeholders = implode(",", array_fill(0, count($status), "?"));
    $where[] = "Clinical_value IN ($placeholders)";
    $params = array_merge($params, $status);
}

/* 3. Source → Source */
if (!empty($biofluid)) {
    $placeholders = implode(",", array_fill(0, count($biofluid), "?"));
    $where[] = "Source IN ($placeholders)";
    $params = array_merge($params, $biofluid);
}

if (!empty($disease)) {
    $placeholders = implode(",", array_fill(0, count($disease), "?"));
    $where[] = "Disease IN ($placeholders)";
    $params = array_merge($params, $disease);
}
if (!empty($category)) {
    $placeholders = implode(",", array_fill(0, count($category), "?"));
    $where[] = "Category IN ($placeholders)";
    $params = array_merge($params, $category);
}

$where_sql = empty($where) ? "" : "WHERE " . implode(" AND ", $where);




/* 查询总数 */
$total_sql = "SELECT COUNT(*) FROM all_data";
$total_records = Db::$pdo->query($total_sql)->fetchColumn();


/* 查询过滤后总数 */
$filtered_sql = "SELECT COUNT(*) FROM all_data $where_sql";
$stmt = Db::$pdo->prepare($filtered_sql);
$stmt->execute($params);
$filtered_records = $stmt->fetchColumn();

// --- 新增：处理排序参数 ---
// --- 新增：处理排序参数 ---
$columns = ['biomarker_ID', 'ID', 'Category', 'marker_type', 'Source', 'Disease', 'Clinical_value', 'features'];
$inner_order_sql = "";
$outer_order_sql = "";
if (isset($_POST['order']) && count($_POST['order'])) {
    $col_index = intval($_POST['order'][0]['column']); // 哪一列排序
    $col_dir = $_POST['order'][0]['dir'] === 'asc' ? 'ASC' : 'DESC'; // 升序还是降序

    // 安全检查，确保排序列名在白名单内
    if (isset($columns[$col_index])) {
        $order_field = $columns[$col_index];
        $inner_order_sql = "ORDER BY $order_field $col_dir";
        // ★ 核心修复：外层查询加上 a. 前缀，防止 biomarker_ID 字段冲突报错
        $outer_order_sql = "ORDER BY a.$order_field $col_dir";
    }
}

/* =========================================================
   优化后的查询真实数据：延迟关联 (Delayed Join)
   ========================================================= */
$data_sql = "
    SELECT 
        a.biomarker_ID,
        a.ID,
        a.Category,
        a.marker_type,
        a.Source,
        a.Disease,
        a.Clinical_value,
        a.features,
        (SELECT COUNT(*) FROM all_data AS t2 WHERE t2.ID = a.ID) AS related_count,
        (SELECT GROUP_CONCAT(biomarker_ID) FROM all_data AS t2 WHERE t2.ID = a.ID) AS related_bids
    FROM (
        -- 第一步：只查询出当前页所需的 10 个主键 ID，极速翻页
        SELECT biomarker_ID 
        FROM all_data
        $where_sql
        $inner_order_sql
        LIMIT $length OFFSET $start
    ) AS p
    -- 第二步：用找出的 10 个 ID 去关联原表
    JOIN all_data AS a ON a.biomarker_ID = p.biomarker_ID
    $outer_order_sql
";

$stmt = Db::$pdo->prepare($data_sql);
$stmt->execute($params);
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);



echo json_encode([
    "draw" => $draw,
    "recordsTotal" => $total_records,
    "recordsFiltered" => $filtered_records,
    "data" => $data
], JSON_UNESCAPED_UNICODE);