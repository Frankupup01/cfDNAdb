<?php
// api/get_visitor_map.php
error_reporting(0);
header('Content-Type: application/json; charset=utf-8');

try {
    $DS = DIRECTORY_SEPARATOR;
    require dirname(__DIR__) . "{$DS}app{$DS}Db.class.php";
    Db::connect();
    $pdo = Db::$pdo;

    // 查询所有有经纬度的数据
    $sql = "SELECT country, city, lon, lat, visit_count FROM visitor_logs WHERE lon IS NOT NULL AND lat IS NOT NULL";
    $visitors = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

    // ECharts Scatter 散点图要求的格式： [经度, 纬度, 额外信息(如次数), 城市名]
    $mapData = [];
    foreach ($visitors as $v) {
        $mapData[] = [
            'name' => $v['city'] . ', ' . $v['country'],
            'value' => [ (float)$v['lon'], (float)$v['lat'], (int)$v['visit_count'] ]
        ];
    }

    echo json_encode(["success" => true, "data" => $mapData, "total_ips" => count($visitors)]);
} catch (Exception $e) {
    echo json_encode(["success" => false, "error" => $e->getMessage()]);
}
?>
