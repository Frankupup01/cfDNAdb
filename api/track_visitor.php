<?php
// api/track_visitor.php
error_reporting(0);

try {
    $DS = DIRECTORY_SEPARATOR;
    require dirname(__DIR__) . "{$DS}app{$DS}Db.class.php";
    Db::connect();
    $pdo = Db::$pdo;

    // 🌟 核心升级 1：最强 IP 穿透获取（兼容 Cloudflare, Nginx, 宝塔反代）
    $ip = '';
    if (isset($_SERVER['HTTP_CF_CONNECTING_IP'])) {
        $ip = $_SERVER['HTTP_CF_CONNECTING_IP']; // Cloudflare 专属
    } elseif (isset($_SERVER['HTTP_X_REAL_IP'])) {
        $ip = $_SERVER['HTTP_X_REAL_IP']; // Nginx 常用
    } elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ips = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
        $ip = trim($ips[0]);
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }

    if ($ip === '127.0.0.1' || $ip === '::1') $ip = '8.8.8.8';

    if (!filter_var($ip, FILTER_VALIDATE_IP)) {
        exit;
    }

    $stmt = $pdo->prepare("SELECT id FROM visitor_logs WHERE ip = ?");
    $stmt->execute([$ip]);
    $exists = $stmt->fetch();

    if ($exists) {
        $pdo->prepare("UPDATE visitor_logs SET visit_count = visit_count + 1, last_visit = CURRENT_TIMESTAMP WHERE ip = ?")->execute([$ip]);
    } else {
        $ctx = stream_context_create([
            'http' => ['timeout' => 3]
        ]);

        $api_url = "https://get.geojs.io/v1/ip/geo/{$ip}.json";
        $response = @file_get_contents($api_url, false, $ctx);

        if ($response) {
            $geo = json_decode($response, true);

            if (isset($geo['latitude']) && isset($geo['longitude'])) {
                $country = strip_tags((string)$geo['country']);

                // 🌟 核心升级 2：更智能的地区降级策略
                // 如果没有 city，就找 region (省/州)，如果连 region 都没有，就不显示 Unknown，直接留空
                $city = '';
                if (!empty($geo['city'])) {
                    $city = $geo['city'];
                } elseif (!empty($geo['region'])) {
                    $city = $geo['region'];
                }
                $city = strip_tags((string)$city);

                $lon = (float)$geo['longitude'];
                $lat = (float)$geo['latitude'];

                $stmt = $pdo->prepare("INSERT INTO visitor_logs (ip, country, city, lon, lat) VALUES (?, ?, ?, ?, ?)");
                $stmt->execute([$ip, $country, $city, $lon, $lat]);
            }
        }
    }
} catch (Exception $e) {
    // 静默处理
}
?>