<?php
require dirname(__DIR__) . "/app/Db.class.php";
require dirname(__DIR__) . "/app/Func.php";

Db::connect();
header("Content-Type: application/json; charset=utf-8");

/* ===============================
 * 1. 读取 JSON
 * =============================== */
$input = json_decode(file_get_contents("php://input"), true);

if (!$input) {
    echo json_encode(["data" => []]);
    exit;
}

$biomarkerType = $input['biomarkerType'] ?? null;
$conditions    = $input['conditions'] ?? [];

/* ===============================
 * 2. WHERE 容器
 * =============================== */
$where  = [];
$params = [];

/* ===============================
 * 3. Biomarker Type（→ Clinical_value）
 * =============================== */
if (!empty($biomarkerType)) {
    $where[]  = "Clinical_value = ?";
    $params[] = $biomarkerType;
}

/* ===============================
 * 4. Search Conditions
 * =============================== */
$fieldMap = [
    "Disease"    => "Disease",
    "MarkerType" => "marker_type",
    "Features"   => "features",
    "Source"     => "Source",
    "Country"    => "Country",
    "Year"       => "Date"
];

$usedFields = [];

foreach ($conditions as $cond) {

    $field    = $cond['field']    ?? '';
    $operator = $cond['operator'] ?? '';
    $values   = $cond['values']   ?? [];

    if (!$field || !isset($fieldMap[$field]) || empty($values)) {
        continue;
    }

    /* 后端兜底：field 只能一次 */
    if (in_array($field, $usedFields, true)) {
        continue;
    }
    $usedFields[] = $field;

    $column = $fieldMap[$field];

    /* ========= equals：合并成一个值 ========= */
    if ($operator === 'equals') {

        $value = trim(implode(' ', $values));
        $where[]  = "$column = ?";
        $params[] = $value;
        continue;
    }

    /* ========= contains / not：多值 OR ========= */
    $sub = [];

    foreach ($values as $val) {

        if ($operator === 'contains') {


            $likeVal = str_replace('*', '%', $val);


            if (strpos($likeVal, '%') === false) {
                $likeVal = '%' . $likeVal . '%';
            }

            $sub[]    = "$column LIKE ?";
            $params[] = $likeVal;
        }

        if ($operator === 'not') {
            $sub[]    = "$column != ?";
            $params[] = $val;
        }
    }

    if (!empty($sub)) {
        $where[] = "(" . implode(" OR ", $sub) . ")";
    }
}

/* ===============================
 * 5. SQL
 * =============================== */
$whereSql = empty($where) ? "" : "WHERE " . implode(" AND ", $where);

$sql = "
    SELECT
        biomarker_ID   AS BiomarkerID,
        ID,
        Category,
        marker_type    AS MarkerType,
        Source,
        Disease,
        Clinical_value AS ClinicalValue,
        features       AS Features,
        Date
    FROM all_data
    $whereSql
    ORDER BY biomarker_ID
    LIMIT 500
";

$stmt = Db::$pdo->prepare($sql);
$stmt->execute($params);
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

/* ===============================
 * 6. 输出
 * =============================== */
echo json_encode([
    "data" => $data
], JSON_UNESCAPED_UNICODE);