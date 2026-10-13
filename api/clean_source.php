<?php
// ==========================================
// 1. 数据库连接配置
// ==========================================
$dbFile = dirname(__DIR__) . '/db/cfDNA.db';

try {
    $pdo = new PDO("sqlite:" . $dbFile);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("数据库连接失败: " . $e->getMessage());
}

$tableName = 'all_data';
$targetColumn = 'Source';

try {
    echo "开始标准化清洗 {$tableName} 表的 {$targetColumn} 列...<br>";

    $pdo->beginTransaction();

    // 查出所有 Source 不为空的数据
    $stmt = $pdo->query("SELECT rowid, `$targetColumn` FROM `$tableName` WHERE `$targetColumn` IS NOT NULL AND `$targetColumn` != ''");
    $rows = $stmt->fetchAll();

    $updateCount = 0;
    $updateStmt = $pdo->prepare("UPDATE `$tableName` SET `$targetColumn` = ? WHERE rowid = ?");

    foreach ($rows as $row) {
        $rowid = $row['rowid'];
        $originalValue = $row[$targetColumn];

        // 核心清洗魔法：
        // 1. trim() 去除首尾的隐形空格
        // 2. strtolower() 全部转为小写
        // 3. ucfirst() 将首字母转为大写
        // 结果示例: "Peripheral Blood " -> "Peripheral blood"
        $cleanValue = ucfirst(strtolower(trim($originalValue)));

        // 如果清洗后的值和原来的不一样，说明它是脏数据，执行更新
        if ($cleanValue !== $originalValue) {
            $updateStmt->execute([$cleanValue, $rowid]);
            $updateCount++;
        }
    }

    $pdo->commit();

    echo "<h3 style='color:green;'>Source 列标准化清洗成功！</h3>";
    echo "共修复了 <b>{$updateCount}</b> 条包含空格或大小写不统一的脏数据。<br>";

} catch (Exception $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    die("<h3 style='color:red;'>错误：数据已回滚！</h3>" . $e->getMessage());
}
?>