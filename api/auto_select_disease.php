<?php

session_start();
$DS = DIRECTORY_SEPARATOR;
require dirname(__DIR__)."{$DS}app{$DS}Db.class.php";
require dirname(__DIR__)."{$DS}app{$DS}Func.php";

$select_specie = $_POST['select_specie'];



// 将前端传入的物种名称转换为数据表中的对应名称
$specie_map = [
    'Single' => ['Single','Single/Panel'], // 包含 Single/Panel 的结果
    'Panel' => ['Panel', 'Single/Panel'], // 包含 Single/Panel 的结果
    // 其他物种可以根据需要添加
];

//  判断物种是否需要转换
if (array_key_exists($select_specie, $specie_map)) {
    // 如果需要转换，取映射的值
    $species_to_query = $specie_map[$select_specie];
} else {
    // 如果不需要转换，直接使用原物种名称
    $species_to_query = [$select_specie];
}



$map = [];

// 根据物种映射，构造查询条件
//$species_to_query = $specie_map[$select_specie];
$map[] = ['marker_type', 'IN', $species_to_query];




$result = Db::table('all_data')->where($map)->field('Disease')->select();

// 从查询结果中提取 project_id 值
$dis_ids = [];
foreach ($result as $row) {
    $dis_ids[] = $row['Disease'];
}

// 去重处理
$unique_dis_ids = array_unique($dis_ids);

// 格式化为数组形式
$response = array_values($unique_dis_ids);  // 保证返回的数组索引从 0 开始

// 返回 JSON 格式
echo json_encode($response);



