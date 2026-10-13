<?php
header('Content-Type: application/json; charset=utf-8');

$DS = DIRECTORY_SEPARATOR;
// 引入你现成的数据库类
require dirname(__DIR__) . "{$DS}app{$DS}Db.class.php";

// 检查是否传了列名过来
if (!isset($_POST['column'])) {
    echo json_encode(['error' => 'Missing column parameter']);
    exit;
}

$column = $_POST['column'];


$allowedColumns = ['Source', 'Disease', 'Clinical_value', 'Category'];
if (!in_array($column, $allowedColumns)) {
    echo json_encode(['error' => 'Invalid column name requested']);
    exit;
}

try {
    // 初始化 PDO
    Db::connect();
    $pdo = Db::$pdo;

    // 使用 DISTINCT 查出该列所有去重后的唯一值，并按字母排序
    $sql = "SELECT DISTINCT `$column` FROM all_data WHERE `$column` IS NOT NULL AND `$column` != '' ORDER BY `$column` ASC";
    $stmt = $pdo->query($sql);

    // FETCH_COLUMN 会直接把那一列的数据提取成一个一维数组（例如：['Blood', 'Plasma', 'Urine']）
    $results = $stmt->fetchAll(PDO::FETCH_COLUMN);

    echo json_encode($results, JSON_UNESCAPED_UNICODE);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
?>