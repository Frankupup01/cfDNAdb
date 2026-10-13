<?php include "./Template/base.php"; ?>
<?php include './Template/header.php'; ?>

<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <title>Basic Search</title>

    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .search-container {
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        .header-box {
            background-color: #e9ecef;
            color: #343a40;
            padding: 10px 15px;
            border-radius: 6px;
            margin-bottom: 15px;
            font-size: 1.25rem;
            font-weight: bold;
        }
        .search-container h3 {
            margin: 0;
        }

        /* zTree 高度限制 */
        #treeContainer {
            max-height: 350px;
            overflow-y: auto;
            border: 1px solid #ddd;
            border-radius: 6px;
            padding: 10px;
        }

        .ztree li span.button.switch { margin-right: 5px; }

        /* ------------------ zTree 图标改成灰色（最终版本） ------------------ */

        /* 恢复 zTree 图标（不被 bootstrap 重置） */
        .ztree li span.button {
            background-repeat: no-repeat !important;
            background-image: url("./bootstrap5/bootstrap-3.4.1-dist/zTree_v3-master/css/zTreeStyle/img/zTreeStandard.png") !important;
        }

        /* 让全部图标变成灰色 */
        .ztree li span.button {
            filter: grayscale(100%) brightness(0.6);
        }

        /* 调整间距 */
        .ztree li span.button.switch {
            margin-right: 5px;
        }
        /* 让按钮区域右对齐 */
        .button-area {
            text-align: right;
            margin-top: 15px;
        }

        /* Reset：白底黑字（Bootstrap btn-outline-dark 风格） */
        #btnReset {
            background: #fff;
            color: #000;
            border: 1px solid #000;
        }

        /* Hover 效果 */
        #btnReset:hover {
            background: #f0f0f0;
        }

        /* Submit：黑底白字 */
        #btnSubmit {
            background: #000;
            color: #fff;
            border: 1px solid #000;
        }

        #btnSubmit:hover {
            background: #333;
        }
        .detail-search-title {
            padding: 10px 80px;
            font-size: 22px;
            font-weight: bold;
            color: #0362a4;
        }
        .detail-divider {
            border: none;
            border-top: 2px solid #ccc;
            margin: 15px 80px; /* 左右和上下的间距 */
        }
        .cutoff-note {
            text-align: right;
            font-size: 12px;
            color: gray;
            margin-bottom: -5px;
            margin-right: 80px;
        }
        table.dataTable th,
        table.dataTable td {
            text-align: center !important;
            vertical-align: middle;
        }

        /* 表头标题不换行 */
        table.dataTable thead th {
            white-space: nowrap;
        }

        /* 防止按钮或内容撑高表头 */
        table.dataTable {
            width: 100% !important;
        }

        #detailList tbody td {
            border-top: none !important;
            border-bottom: none !important;
        }

        /* 2. 表头（列名）下方的横线变成黑色 (#000)，厚度 2px */
        table.dataTable thead th,
        table.dataTable thead td {
            border-bottom: 2px solid #000 !important;
        }

        /* 3. 表格最底端的收尾横线变成黑色 (#000) */
        table.dataTable.no-footer {
            border-bottom: 2px solid #000 !important;
        }
        #detailList {
            border-bottom: 2px solid #000 !important;
        }

        #detailList tbody tr:hover,
        .table-hover tbody tr:hover {
            background-color: #ffffff !important;
        }

        .dataTables_length {
            margin-right: 15px;
            margin-top: 5px;
        }

        .dataTables_length select {
            border-radius: 4px;
            padding: 4px 8px;
            border: 1px solid #ccc;
        }

        /* 图表说明文字样式 */
        .chart-note {
            background-color: #f0f7ff;
            border-left: 4px solid #0d6efd;
            color: #495057;
            padding: 12px 16px;
            font-size: 0.95rem;
            margin-bottom: 15px;
            border-radius: 0 6px 6px 0;
            line-height: 1.5;
        }
        .chart-note strong {
            color: #0b5ed7;
        }

    </style>
</head>

<body>

<hr class="detail-divider">

<div class="container mt-5">

    <div class="search-container bg-white" id="box-dimension">
        <div class="header-box"><h3>Hierarchical Browse</h3></div>

        <div id="treeContainer">
            <ul id="searchTree" class="ztree"></ul>
        </div>

        <div class="button-area">
            <button class="btn" id="btnReset">Reset</button>
            <button class="btn" id="btnSubmit">Submit</button>
        </div>
    </div>

    <div class="search-container bg-white" id="box-table" style="display: none;">
        <div class="header-box"><h3>Browse Result</h3></div>

        <div class="table-responsive">
            <table class="table table-striped table-hover" id="result-table">
                <thead><tr></tr></thead>
                <tbody></tbody>
            </table>
        </div>
    </div>

</div>

<script>
    let ztreeObj = null;
    let initialNodes = null;

    // ========== 1. 树结构数据 ==========
    const treeData = [
        // --- 1. cfDNA ---
        { id: 1, pId: 0, name: "cfDNA", open: true },

// cfDNA Source
        { id: 11, pId: 1, name: "Source", open: false },
        { id: 1000, pId: 11, name: "Peripheral blood" },
        { id: 1001, pId: 11, name: "Plasma" },
        { id: 1002, pId: 11, name: "Saliva" },
        { id: 1003, pId: 11, name: "Serum" },
        { id: 1004, pId: 11, name: "Blood" },
        { id: 1005, pId: 11, name: "Cerebrospinal fluid" },
        { id: 1006, pId: 11, name: "Others" },
        { id: 1007, pId: 11, name: "Urine" },
        { id: 1008, pId: 11, name: "Body fluid" },
        { id: 1009, pId: 11, name: "Urine supernatant" },
        { id: 1010, pId: 11, name: "Urine sediments" },
        { id: 1011, pId: 11, name: "Intraoperative pleural-lavage" },
        { id: 1012, pId: 11, name: "Uterine aspirates" },
        { id: 1013, pId: 11, name: "Seminal plasma" },
        { id: 1014, pId: 11, name: "Bile" },
        { id: 1015, pId: 11, name: "Peritoneal fluid" },
        { id: 1016, pId: 11, name: "Aqueous humor" },

// cfDNA Clinical value
        { id: 12, pId: 1, name: "Clinical value", open: false },
        { id: 1021, pId: 12, name: "Prognostic" },
        { id: 1022, pId: 12, name: "Diagnostic" },
        { id: 1023, pId: 12, name: "Predictive" },
        { id: 1024, pId: 12, name: "Safety" },
        { id: 1025, pId: 12, name: "Monitoring" },
        { id: 1026, pId: 12, name: "Response" },

// cfDNA Disease
        { id: 13, pId: 1, name: "Disease", open: false },
        { id: 1030, pId: 13, name: "Gastric cancer" },
        { id: 1031, pId: 13, name: "Hepatocellular carcinoma" },
        { id: 1032, pId: 13, name: "High grade ovarian carcinoma" },
        { id: 1033, pId: 13, name: "Metastatic prostate cancer" },
        { id: 1034, pId: 13, name: "Pten hamartoma tumor syndrome" },
        { id: 1035, pId: 13, name: "Medullary thyroid carcinoma" },
        { id: 1036, pId: 13, name: "Colorectal cancer" },
        { id: 1037, pId: 13, name: "High risk serrated lesions and serrated adenocarci" },
        { id: 1038, pId: 13, name: "Serrated adenocarcinoma" },
        { id: 1039, pId: 13, name: "Upper tract urothelial carcinoma" },
        { id: 1040, pId: 13, name: "Her2-positive breast cancer" },
        { id: 1041, pId: 13, name: "Breast cancer" },
        { id: 1042, pId: 13, name: "High grade serous ovarian carcinoma" },
        { id: 1043, pId: 13, name: "Pediatric cancer" },
        { id: 1044, pId: 13, name: "Non-small-cell lung cancer" },
        { id: 1045, pId: 13, name: "Colorectal neoplasm" },
        { id: 1046, pId: 13, name: "Endometrial cancer" },
        { id: 1047, pId: 13, name: "Biliary tract cancer" },
        { id: 1048, pId: 13, name: "Papillary thyroid cancer" },
        { id: 1049, pId: 13, name: "Ampullary cancer" },
        { id: 1050, pId: 13, name: "Prostate cancer" },
        { id: 1051, pId: 13, name: "Follicular lymphoma" },
        { id: 1052, pId: 13, name: "Esophageal cancer" },
        { id: 1053, pId: 13, name: "Ovarian cancer" },
        { id: 1054, pId: 13, name: "Soft tissue sarcoma" },
        { id: 1055, pId: 13, name: "Leptomeningeal metastases" },
        { id: 1056, pId: 13, name: "Melanoma" },
        { id: 1057, pId: 13, name: "Metastatic castration resistance prostate cancer" },
        { id: 1058, pId: 13, name: "Pancreatic adenocarcinoma" },
        { id: 1059, pId: 13, name: "Metastatic breast cancer" },
        { id: 1060, pId: 13, name: "Oral squamous cell carcinoma" },
        { id: 1061, pId: 13, name: "Precancerous colorectal" },
        { id: 1062, pId: 13, name: "Metastatic colorectal cancer" },
        { id: 1063, pId: 13, name: "Lung cancer" },
        { id: 1064, pId: 13, name: "Pancreatic cancer" },
        { id: 1065, pId: 13, name: "Esophageal squamous cell carcinoma" },
        { id: 1066, pId: 13, name: "Head and neck squamous cell carcinoma" },
        { id: 1067, pId: 13, name: "Renal cell carcinoma" },
        { id: 1068, pId: 13, name: "Pancreatic ductal adenocarcinoma" },
        { id: 1069, pId: 13, name: "Colorectal carcinoma" },
        { id: 1070, pId: 13, name: "B virus-related hepatocellular carcinoma" },
        { id: 1071, pId: 13, name: "Clear cell renal cell carcinoma" },
        { id: 1072, pId: 13, name: "Metastatic melanoma" },
        { id: 1073, pId: 13, name: "Triple negative breast cancer" },
        { id: 1074, pId: 13, name: "Rectal cancer" },
        { id: 1075, pId: 13, name: "Oesophageal squamous cell carcinoma" },
        { id: 1076, pId: 13, name: "Brain tumors" },
        { id: 1077, pId: 13, name: "Plasma" },
        { id: 1078, pId: 13, name: "Serous ovarian cancer" },
        { id: 1079, pId: 13, name: "Pancreatic cystic neoplasms" },
        { id: 1080, pId: 13, name: "Locally advanced rectal cancer" },
        { id: 1081, pId: 13, name: "Anaplastic thyroid cancer" },
        { id: 1082, pId: 13, name: "Cervical cancer" },
        { id: 1083, pId: 13, name: "Ovarian carcinoma" },
        { id: 1084, pId: 13, name: "Cancer" },
        { id: 1085, pId: 13, name: "Papillary thyroid carcinoma" },
        { id: 1086, pId: 13, name: "Nasopharyngeal carcinoma" },
        { id: 1087, pId: 13, name: "Liver cancer" },
        { id: 1088, pId: 13, name: "Brain cancer" },
        { id: 1089, pId: 13, name: "Adrenocortical carcinoma" },
        { id: 1090, pId: 13, name: "Muscle-invasive bladder cancer" },
        { id: 1091, pId: 13, name: "Muti cancer" },
        { id: 1092, pId: 13, name: "Thyroid cancer" },
        { id: 1093, pId: 13, name: "Gastrointestinal tract malignancy" },
        { id: 1094, pId: 13, name: "Castration-resistant prostate cancer" },
        { id: 1095, pId: 13, name: "Epithelial ovarian cancer" },
        { id: 1096, pId: 13, name: "Pan cancer" },
        { id: 1097, pId: 13, name: "Metastatic colorectal carcinoma" },
        { id: 1098, pId: 13, name: "Bladder cancer" },
        { id: 1099, pId: 13, name: "Renal cancer" },
        { id: 1100, pId: 13, name: "Epithelial ovarian carcinoma" },
        { id: 1101, pId: 13, name: "Lung squamous cell carcinoma" },
        { id: 1102, pId: 13, name: "Squamous cell head-neck cancer" },
        { id: 1103, pId: 13, name: "Head and neck cancer" },
        { id: 1104, pId: 13, name: "Thymic carcinoma" },
        { id: 1105, pId: 13, name: "Neck squamous cell carcinoma" },
        { id: 1106, pId: 13, name: "Desmoid tumors" },
        { id: 1107, pId: 13, name: "Others" },
        { id: 1108, pId: 13, name: "Hepatitis c virus-associated hepatocellular carcin" },
        { id: 1109, pId: 13, name: "Non-small cell lung carcinoma" },
        { id: 1110, pId: 13, name: "Oropharyngeal cancer(hpv+)" },
        { id: 1111, pId: 13, name: "Esophageal adenocarcinoma" },
        { id: 1112, pId: 13, name: "Biliopancreatic cancer" },
        { id: 1113, pId: 13, name: "Parathyroid carcinoma" },
        { id: 1114, pId: 13, name: "Esophageal carcinoma" },
        { id: 1115, pId: 13, name: "Distal common bile duct cancer" },
        { id: 1116, pId: 13, name: "Oral cancer" },
        { id: 1117, pId: 13, name: "Nephroblastomatosis" },
        { id: 1118, pId: 13, name: "Hpv oropharyngeal squamous cell carcinoma" },
        { id: 1119, pId: 13, name: "Myelodysplastic syndromes" },
        { id: 1120, pId: 13, name: "Small cell lung cancer" },
        { id: 1121, pId: 13, name: "Laryngeal squamous cell carcinoma" },
        { id: 1122, pId: 13, name: "Malignant peripheral nerve sheath tumor" },
        { id: 1123, pId: 13, name: "Pulmonary large-cell neuroendocrine carcinoma" },
        { id: 1124, pId: 13, name: "Breast cancers of the luminal b subtype" },
        { id: 1125, pId: 13, name: "Alk-rearranged lung cancer" },
        { id: 1126, pId: 13, name: "Intraductal papillary mucinous neoplasm" },
        { id: 1127, pId: 13, name: "High grade serous ovarian cancer" },
        { id: 1128, pId: 13, name: "Hepatobiliary cancer" },
        { id: 1129, pId: 13, name: "Oral cavity squamous cell carcinoma" },
        { id: 1130, pId: 13, name: "Uterine cancer" },
        { id: 1131, pId: 13, name: "Urothelial bladder cancer" },
        { id: 1132, pId: 13, name: "Gall bladder carcinoma" },
        { id: 1133, pId: 13, name: "Doxorubicin-based chemotherapy followed by trastuz" },
        { id: 1134, pId: 13, name: "Neuroendocrine neoplasia" },
        { id: 1135, pId: 13, name: "Adenocarcinoma" },
        { id: 1136, pId: 13, name: "Urothelial cancer" },
        { id: 1137, pId: 13, name: "Gallbladder cancer" },
        { id: 1138, pId: 13, name: "Uveal melanoma" },
        { id: 1139, pId: 13, name: "Oropharyngeal squamous cell carcinoma" },
        { id: 1140, pId: 13, name: "Colon cancer" },
        { id: 1141, pId: 13, name: "Glioblastoma" },
        { id: 1142, pId: 13, name: "Bone sarcoma" },
        { id: 1143, pId: 13, name: "Soft-tissue sarcoma" },
        { id: 1144, pId: 13, name: "High risk serrated polyps" },
        { id: 1145, pId: 13, name: "High-risk hyperplastic polyps" },
        { id: 1146, pId: 13, name: "Childhood solid tumors" },
        { id: 1147, pId: 13, name: "Gynaecological cancer" },
        { id: 1148, pId: 13, name: "Solid tumor" },
        { id: 1149, pId: 13, name: "Retinoblastoma" },

        // --- 2. ctDNA ---
        { id: 2, pId: 0, name: "ctDNA", open: true },

// ctDNA Source
        { id: 21, pId: 2, name: "Source", open: false },
        { id: 1147, pId: 21, name: "Plasma" },
        { id: 1148, pId: 21, name: "Serum" },
        { id: 1149, pId: 21, name: "Blood" },
        { id: 1150, pId: 21, name: "Peripheral blood" },
        { id: 1151, pId: 21, name: "Cerebrospinal fluid" },
        { id: 1152, pId: 21, name: "Peritoneal lavage fluid" },
        { id: 1153, pId: 21, name: "Ascites" },
        { id: 1154, pId: 21, name: "Urine" },

// ctDNA Clinical value
        { id: 22, pId: 2, name: "Clinical value", open: false },
        { id: 1168, pId: 22, name: "Prognostic" },
        { id: 1169, pId: 22, name: "Monitoring" },
        { id: 1170, pId: 22, name: "Diagnostic" },
        { id: 1171, pId: 22, name: "Predictive" },
        { id: 1172, pId: 22, name: "Response" },
        { id: 1173, pId: 22, name: "Safety" },

// ctDNA Disease
        { id: 23, pId: 2, name: "Disease", open: false },
        { id: 1175, pId: 23, name: "Breast cancer" },
        { id: 1176, pId: 23, name: "Metastatic castration resistance prostate cancer" },
        { id: 1177, pId: 23, name: "Non-small-cell lung cancer" },
        { id: 1178, pId: 23, name: "Uveal melanoma" },
        { id: 1179, pId: 23, name: "Hepatocellular carcinoma" },
        { id: 1180, pId: 23, name: "Upper urinary tract urothelial carcinoma" },
        { id: 1181, pId: 23, name: "Neuroblastoma" },
        { id: 1182, pId: 23, name: "Peripheral t-cell lymphoma" },
        { id: 1183, pId: 23, name: "Multiple myeloma" },
        { id: 1184, pId: 23, name: "Soft tissue sarcoma" },
        { id: 1185, pId: 23, name: "Pancreatic adenocarcinoma" },
        { id: 1186, pId: 23, name: "Cholangiocarcinoma" },
        { id: 1187, pId: 23, name: "Leiomyosarcoma" },
        { id: 1188, pId: 23, name: "Pancreatic cancer" },
        { id: 1189, pId: 23, name: "Unilateral retinoblastoma" },
        { id: 1190, pId: 23, name: "Gastric cancer" },
        { id: 1191, pId: 23, name: "Upper tract urothelial carcinoma" },
        { id: 1192, pId: 23, name: "Pancreatic ductal adenocarcinoma" },
        { id: 1193, pId: 23, name: "Liver cancer" },
        { id: 1194, pId: 23, name: "Chordoma" },
        { id: 1195, pId: 23, name: "Metastatic colorectal cancer" },
        { id: 1196, pId: 23, name: "Peritoneal carcinomatosis" },
        { id: 1197, pId: 23, name: "Colorectal cancer" },
        { id: 1198, pId: 23, name: "Melanoma" },
        { id: 1199, pId: 23, name: "Renal cell carcinoma" },
        { id: 1200, pId: 23, name: "Gastroesophageal cancer" },
        { id: 1201, pId: 23, name: "Triple negative breast cancer" },
        { id: 1202, pId: 23, name: "Prostate cancer" },
        { id: 1203, pId: 23, name: "Anal squamous cell carcinoma" },
        { id: 1204, pId: 23, name: "Hpv oropharyngeal squamous cell carcinoma" },
        { id: 1205, pId: 23, name: "Epithelial ovarian cancer" },
        { id: 1206, pId: 23, name: "Urothelial cancer" },
        { id: 1207, pId: 23, name: "Lung adenocarcinoma" },
        { id: 1208, pId: 23, name: "Lung cancer" },
        { id: 1209, pId: 23, name: "Head and neck cancer" },
        { id: 1210, pId: 23, name: "Pan cancer" },
        { id: 1211, pId: 23, name: "Small cell lung cancer" },
        { id: 1212, pId: 23, name: "Urothelial bladder carcinoma" },
        { id: 1213, pId: 23, name: "Castration-resistant prostate cancer" },
        { id: 1214, pId: 23, name: "Papillary thyroid carcinoma" },
        { id: 1215, pId: 23, name: "Ovarian cancer" },
        { id: 1216, pId: 23, name: "Mantle cell lymphoma" },
        { id: 1217, pId: 23, name: "Desmoid fibromatosis" },
        { id: 1218, pId: 23, name: "Thyroid nodules" },
        { id: 1219, pId: 23, name: "Gastroenteropancreatic neuroendocrine carcinomas" },
        { id: 1220, pId: 23, name: "Gastroesophageal adenocarcinoma" },
        { id: 1221, pId: 23, name: "Endometrial cancer" },
        { id: 1222, pId: 23, name: "Urothelial carcinoma" },
        { id: 1223, pId: 23, name: "Biliary tract cancer" },
        { id: 1224, pId: 23, name: "Colon cancer" },
        { id: 1225, pId: 23, name: "Endometrial carcinoma" },
        { id: 1226, pId: 23, name: "Papillary thyroid cancer" },
        { id: 1227, pId: 23, name: "Cervical cancer" },
        { id: 1228, pId: 23, name: "Gastrointestinal cancer" },
        { id: 1229, pId: 23, name: "Gastrointestinal stromal tumors" },
        { id: 1230, pId: 23, name: "Follicular lymphoma" },
        { id: 1231, pId: 23, name: "Osteosarcoma" },
        { id: 1232, pId: 23, name: "Lymphoma" },
        { id: 1233, pId: 23, name: "Nervous system germ cell tumors" },
        { id: 1234, pId: 23, name: "Basal-like breast cancer" },
        { id: 1235, pId: 23, name: "Esophageal squamous cell carcinoma" },
        { id: 1236, pId: 23, name: "Esophageal adenocarcinoma" },
        { id: 1237, pId: 23, name: "Esophageal squamous cell cancer" },
        { id: 1238, pId: 23, name: "Brain cancer" },
        { id: 1239, pId: 23, name: "Glioblastoma multiforme" },
        { id: 1240, pId: 23, name: "Head and neck squamous cell carcinoma" },
        { id: 1241, pId: 23, name: "Cns lymphomas" },
        { id: 1242, pId: 23, name: "Leptomeningeal metastases" },
        { id: 1243, pId: 23, name: "Metastatic uveal melanoma" },
        { id: 1244, pId: 23, name: "B rapidly accelerated fibrosarcoma" },
        { id: 1245, pId: 23, name: "Oropharyngeal squamous cell carcinoma" },
        { id: 1246, pId: 23, name: "Glioblastoma" },
        { id: 1247, pId: 23, name: "Esophagogastric cancer" },
        { id: 1248, pId: 23, name: "Muscle-invasive bladder cancer" },
        { id: 1249, pId: 23, name: "Metastatic brain tumor" },
        { id: 1250, pId: 23, name: "Glioma" },
        { id: 1251, pId: 23, name: "Appendiceal cancer" },
        { id: 1252, pId: 23, name: "Non-muscle-invasive bladder cancer" },
        { id: 1253, pId: 23, name: "Colorectal liver metastases" },
        { id: 1254, pId: 23, name: "Luminal b breast cancer" },
        { id: 1255, pId: 23, name: "Esophageal cancer" },
        { id: 1256, pId: 23, name: "Human papilloma virus (hpv)-associated oropharynge" },
        { id: 1257, pId: 23, name: "Neck squamous cell carcinoma" },
        { id: 1258, pId: 23, name: "Muscle-invasive urothelial carcinoma" },
        { id: 1259, pId: 23, name: "Solid tumor leptomeningeal metastasis" },
        { id: 1260, pId: 23, name: "Cutaneous melanoma" },
        { id: 1261, pId: 23, name: "Nasopharyngeal carcinoma" },
        { id: 1262, pId: 23, name: "Colorectal liver" },
        { id: 1263, pId: 23, name: "Diffuse large b cell lymphoma" },
        { id: 1264, pId: 23, name: "Squamous cell carcinoma of the head and neck" },
        { id: 1265, pId: 23, name: "Large b-cell lymphoma" },
        { id: 1266, pId: 23, name: "Wilms tumor" },
        { id: 1267, pId: 23, name: "High grade serous ovarian cancer" },
        { id: 1268, pId: 23, name: "Plhiv with advanced non-squamous non-small-cell lu" },
        { id: 1269, pId: 23, name: "Myeloma" },
        { id: 1270, pId: 23, name: "Pancreato-biliary cancer" },
        { id: 1271, pId: 23, name: "Gallbladder cancer" },
        { id: 1272, pId: 23, name: "Pheochromocytomas" },
        { id: 1273, pId: 23, name: "Paragangliomas" },

        // --- 3. eccDNA ---
        { id: 3, pId: 0, name: "eccDNA", open: true },

// eccDNA Source
        { id: 31, pId: 3, name: "Source", open: false },
        { id: 1278, pId: 31, name: "Lung cancer tissue" },
        { id: 1279, pId: 31, name: "Urothelial tumours" },
        { id: 1280, pId: 31, name: "Plasma" },
        { id: 1281, pId: 31, name: "Breast cancer" },
        { id: 1282, pId: 31, name: "Cerebrospinal fluid" },
        { id: 1283, pId: 31, name: "Mid-stream urine" },
        { id: 1284, pId: 31, name: "Serum" },
        { id: 1285, pId: 31, name: "Bile" },
        { id: 1286, pId: 31, name: "Others" },
        { id: 1287, pId: 31, name: "Breast cancer tissue" },
        { id: 1288, pId: 31, name: "Lymph node metastasis tissue" },
        { id: 1289, pId: 31, name: "Cell line" },

// eccDNA Clinical value
        { id: 32, pId: 3, name: "Clinical value", open: false },
        { id: 1290, pId: 32, name: "Diagnostic" },
        { id: 1291, pId: 32, name: "Predictive" },
        { id: 1292, pId: 32, name: "Prognostic" },
        { id: 1293, pId: 32, name: "Diagnostic/Prognostic" },

// eccDNA Disease
        { id: 33, pId: 3, name: "Disease", open: false },
        { id: 1294, pId: 33, name: "Non-small-cell lung cancer" },
        { id: 1295, pId: 33, name: "Advanced urothelial cancer" },
        { id: 1296, pId: 33, name: "Colorectal cancer" },
        { id: 1297, pId: 33, name: "Hepatocellular carcinoma" },
        { id: 1298, pId: 33, name: "Lung adenocarcinoma" },
        { id: 1299, pId: 33, name: "Breast cancer" },
        { id: 1300, pId: 33, name: "Medulloblastoma" },
        { id: 1301, pId: 33, name: "Clear cell renal cell carcinoma" },
        { id: 1302, pId: 33, name: "Lung cancer" },
        { id: 1303, pId: 33, name: "Prostate cancer" },
        { id: 1304, pId: 33, name: "Newly diagnosed multiple myeloma" },
        { id: 1305, pId: 33, name: "Pancreatic cancer" },
        { id: 1306, pId: 33, name: "Malignant biliary strictures" },
        { id: 1307, pId: 33, name: "Others" },
        { id: 1308, pId: 33, name: "Hypopharyngeal squamous cell carcinoma" },

        // --- 4. ecDNA ---
        { id: 4, pId: 0, name: "ecDNA", open: true },

// ecDNA Source
        { id: 41, pId: 4, name: "Source", open: false },
        { id: 1309, pId: 41, name: "Others" },

// ecDNA Clinical value
        { id: 42, pId: 4, name: "Clinical value", open: false },
        { id: 1310, pId: 42, name: "Prognostic" },
        { id: 1311, pId: 42, name: "Monitoring" },
        { id: 1312, pId: 42, name: "Predictive" },
        { id: 1313, pId: 42, name: "Response" },
        { id: 1314, pId: 42, name: "Diagnostic" },

// ecDNA Disease
        { id: 43, pId: 4, name: "Disease", open: false },
        { id: 1317, pId: 43, name: "Metastatic cutaneous melanoma" },
        { id: 1318, pId: 43, name: "Gastrointestinal cancer" },
        { id: 1319, pId: 43, name: "Colorectal cancer" },
        { id: 1320, pId: 43, name: "Gastric cancer" },
        { id: 1321, pId: 43, name: "Prostate cancer" },
        { id: 1322, pId: 43, name: "Esophageal squamous cell carcinoma" },
        { id: 1323, pId: 43, name: "Nasopharyngeal carcinoma" },
        { id: 1315, pId: 43, name: "Hepatocellular carcinoma (hcc)" },
        { id: 1316, pId: 43, name: "High-risk medulloblastoma" },
        { id: 1324, pId: 43, name: "Barrett’s oesophagus" },
        { id: 1325, pId: 43, name: "Glioblastoma" }
    ];

    let level1_category = null;   // eg. cfDNA
    let level2_field = null;      // eg. Source
    let level3_value = null;      // eg. Aqueous Humor

    // ========== 提取父节点链 (全局作用域) ==========
    function getNodePath(node) {
        let path = [];
        let p = node;
        while (p) {
            path.unshift(p);
            p = p.getParentNode();
        }
        return path;
    }

    // ========== 点击树节点的回调 (单击) ==========
    function onTreeClick(event, treeId, treeNode) {
        const path = getNodePath(treeNode);

        if (path.length !== 3) {
            $("#current-field").text("请点击左侧树的三级节点");
            level1_category = level2_field = level3_value = null;
            return;
        }

        level1_category = path[0].name;
        level2_field    = path[1].name;
        level3_value    = path[2].name;

        $("#current-field").text(`${level1_category} → ${level2_field} → ${level3_value}`);
    }

    // ========== 双击树节点的回调 (新增) ==========
    function onTreeDblClick(event, treeId, treeNode) {
        const path = getNodePath(treeNode);

        // 如果双击的不是第三级节点，直接忽略，不执行搜索
        if (path.length !== 3) {
            return;
        }

        // 模拟点击 Submit 按钮
        $("#btnSubmit").click();
    }

    // ========== zTree 配置 ==========
    const setting = {
        data: { simpleData: { enable: true } },
        callback: {
            onClick: onTreeClick,
            onDblClick: onTreeDblClick // <-- 注册双击事件
        }
    };

    // ========== 初始化与事件绑定 ==========
    $(document).ready(function () {

        // 1. 初始化树
        $.fn.zTree.init($("#searchTree"), setting, treeData);

        // 2. Submit 按钮事件
        $("#btnSubmit").click(function () {
            if (!level1_category || !level2_field || !level3_value) {
                alert("Please select the third-level nodes of ztree first!");
                return;
            }

            // 2nd layer → database column
            let matchCol = "";
            if (level2_field === "Source") matchCol = "Source";
            else if (level2_field === "Clinical value") matchCol = "Clinical_value";
            else if (level2_field === "Disease") matchCol = "Disease";
            else {
                alert("未知字段：" + level2_field);
                return;
            }

            $.ajax({
                url: "./api/search_backend.php",
                type: "POST",
                data: {
                    category: level1_category,
                    column: matchCol,
                    value: level3_value
                },
                success: function(res) {
                    if (!res.success) {
                        alert("查询失败：" + res.message);
                        return;
                    }
                    // res.data.raw → 明细表
                    // res.data.stat → id 列表用于统计
                    renderStatGraph(res.data.stat, res.data.raw);
                }
            });
        });

        // 3. Reset 按钮事件
        $("#btnReset").click(function () {
            level1_category = null;
            level2_field    = null;
            level3_value    = null;

            $("#current-field").text("");

            $("#box-table").hide();
            $("#box-table").html(`
                <div class="header-box"><h3>3. 搜索结果</h3></div>
                <div class="table-responsive">
                    <table class="table table-striped table-hover" id="result-table">
                        <thead><tr></tr></thead>
                        <tbody></tbody>
                    </table>
                </div>
            `);

            const treeObj = $.fn.zTree.getZTreeObj("searchTree");
            treeObj.expandAll(false);
            const roots = treeObj.getNodes();
            roots.forEach(node => {
                treeObj.expandNode(node, true, false);
            });

            $("#current-field").text("");
            $("#box-table").hide();
        });

        // 4. 点击空白处关闭浮窗
        $(document).on('click', function() {
            $('.custom-related-popover').fadeOut(150, function() {
                $(this).remove();
            });
        });

    }); // <--- document.ready 在这里结束

    // ========== 显示统计结果的核心逻辑 (放在全局) ==========
    function renderStatGraph(statList, detailList) {
        $("#box-table").show();

        // ======== 1. 统计 value 的次数及聚合关联的 biomarker_ID ========
        const countMap = {};

        detailList.forEach(r => {
            let val = r.ID;
            if (!val || String(val).trim() === "") val = "(空)";
            val = String(val).trim();

            if (!countMap[val]) {
                countMap[val] = { count: 0, bids: [] };
            }

            countMap[val].count += 1;

            if (r.biomarker_ID) {
                countMap[val].bids.push(r.biomarker_ID);
            }
        });

        // ======== 2. 转数组并排序 ========
        const entries = Object.entries(countMap).map(([value, data]) => ({
            value: value,
            count: data.count,
            bidsString: data.bids.join(',')
        }));

        entries.sort((a, b) => b.count - a.count);

        // 拼接基础 HTML: 详细结果表在上，统计模块在下
        $("#box-table").html(`
            <h4>Browse Result</h4>
            <table id="detailList" class="table" style="width:100%;">
                <thead>
                    <tr>
                        <th>Serial Number</th>
                        <th>Category</th>
                        <th>Marker Type</th>
                        <th>Source</th>
                        <th>Disease</th>
                        <th>Clinical Value</th>
                        <th>Features</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>

            <hr class="mt-4 mb-4">

            <h4>Biomarker statistical results</h4>
            <div class="chart-note">
                <strong>Note:</strong> This word cloud visualizes the frequency of related biomarkers. Larger words indicate a higher number of occurrences. Click on any word to view its related detailed biomarker serial numbers.
            </div>
            <div class="row">
                <div class="col-md-8">
                    <div id="wordCloudArea"
                        style="height:430px;border:1px solid #eee;padding:10px;
                        position:relative;overflow:hidden;background:#fafafa; border-radius:6px;">
                    </div>
                </div>
                <div class="col-md-4">
                    <table id="countTable" class="table table-bordered table-hover">
                        <thead><tr><th>ID</th><th>Count</th></tr></thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        `);

        // ======== 3. 渲染主表明细 ========
        let detailHtml = "";
        detailList.forEach(row => {
            let count = row.related_count ? row.related_count : 1;
            let bidsString = row.related_bids ? row.related_bids : row.biomarker_ID;
            let safeBidsString = bidsString.replace(/'/g, "\\'");

            detailHtml += `
                <tr>
                    <td>
                        <a href="detail_browse.php?id=${encodeURIComponent(row.biomarker_ID)}" target="_blank">
                            ${row.biomarker_ID}
                        </a>
                    </td>
                    <td>${row.Category}</td>
                    <td>${row.marker_type}</td>
                    <td>${row.Source}</td>
                    <td>${row.Disease}</td>
                    <td>${row.Clinical_value}</td>
                    <td>${row.features}</td>
                </tr>
            `;
        });
        $("#detailList tbody").html(detailHtml);

        // --- 修改点：显式关闭 autoWidth，通过百分比强行控制并锁定各列宽度 ---
        $('#detailList').DataTable({
            pageLength: 10,
            lengthChange: true,
            lengthMenu: [10, 25, 50, 100],
            autoWidth: false, // 必须关闭自动宽度计算，指定宽度才会完全生效
            dom: '<"row mb-2"<"col-md-8 d-flex align-items-center"lB><"col-md-4 text-right"f>>rtip',
            buttons: [
                {
                    extend: 'csv',
                    text: 'Download CSV',
                    className: 'btn btn-secondary'
                },
                {
                    extend: 'excel',
                    text: 'Download Excel',
                    className: 'btn btn-secondary'
                }
            ],
            columnDefs: [
                { targets: 0, orderable: true,  width: "10%" },  // Serial Number 加长
                { targets: 1, orderable: false, width: "10%" },  // Category
                { targets: 2, orderable: false, width: "12%" },  // Marker Type 加长
                { targets: 3, orderable: false, width: "12%" },  // Source 加长
                { targets: 4, orderable: false, width: "22%" },  // Disease 显著加长
                { targets: 5, orderable: false, width: "13%" },  // Clinical Value
                { targets: 6, orderable: false, width: "21%" }   // Features 限制、压缩至 14%
            ]
        });

        // ======== 4. 渲染词云 ========
        const $cloud = $("#wordCloudArea");
        $cloud.empty();

        const areaWidth = $cloud.width() || 600;
        const areaHeight = $cloud.height() || 400;
        const centerX = areaWidth / 2;
        const centerY = areaHeight / 2;

        let scale = 1.0;
        if (entries.length > 150) scale = 0.5;
        else if (entries.length > 100) scale = 0.65;
        else if (entries.length > 50) scale = 0.85;

        const placed = [];

        function isOverlap(newBox) {
            for (let i = 0; i < placed.length; i++) {
                const oldBox = placed[i];
                if (!(newBox.right < oldBox.left || newBox.left > oldBox.right || newBox.bottom < oldBox.top || newBox.top > oldBox.bottom)) {
                    return true;
                }
            }
            return false;
        }

        function findPositionOnSpiral(w, h) {
            let angle = 0, radius = 0;
            const angleStep = 0.1, radiusStep = 0.5;
            const maxAttempts = 10000;

            for (let attempt = 0; attempt < maxAttempts; attempt++) {
                const x = centerX + radius * Math.cos(angle) - w / 2;
                const y = centerY + radius * Math.sin(angle) - h / 2;
                const currentBox = { left: x, right: x + w, top: y, bottom: y + h };

                if (!isOverlap(currentBox)) return currentBox;
                angle += angleStep; radius = radiusStep * angle;
            }
            return { left: -999, top: -999, right: -999, bottom: -999 };
        }

        function scaleFont(cnt) {
            const counts = entries.map(e => e.count);
            const minCount = Math.min(...counts);
            const maxCount = Math.max(...counts);
            const minFont = 16, maxFont = 46;
            if (minCount === maxCount) return (minFont + maxFont) / 2;
            return Math.round(minFont + (cnt - minCount) * (maxFont - minCount) / (maxCount - minCount));
        }

        entries.forEach(e => {
            const fontSize = scaleFont(e.count);
            const color = `hsl(${Math.random() * 360}, 70%, 40%)`;

            const $span = $(`<span>${e.value}</span>`).css({
                position: "absolute",
                fontSize: (fontSize * scale) + "px",
                whiteSpace: "nowrap",
                color: color,
                cursor: "pointer",
                fontWeight: "bold",
                lineHeight: "1"
            });

            $span.css({ left: -2000, top: -2000 });
            $cloud.append($span);

            const w = $span.outerWidth() + 2;
            const h = $span.outerHeight() + 2;
            const box = findPositionOnSpiral(w, h);

            if (box.left !== -999) {
                placed.push(box);
                $span.css({ left: box.left + "px", top: box.top + "px" });

                let bidsString = e.bidsString ? e.bidsString : "";
                let safeCloudBids = bidsString.replace(/'/g, "\\'");

                $span.on("click", (event) => {
                    if(safeCloudBids !== "") {
                        window.showRelatedSerials(event, safeCloudBids);
                    } else {
                        alert(`"${e.value}" 出现了 ${e.count} 次`);
                    }
                });
            } else {
                $span.hide();
            }
        });

        // ======== 5. 渲染小表 countTable ========
        let tableBody = "";
        entries.forEach(e => {
            tableBody += `
                <tr>
                    <td><span>${e.value}</span></td>
                    <td>${e.count}</td>
                </tr>`;
        });
        $("#countTable tbody").html(tableBody);

        if ($.fn.DataTable.isDataTable('#countTable')) {
            $('#countTable').DataTable().destroy();
        }

        $('#countTable').DataTable({
            order: [[1, "desc"]],
            pageLength: 5,
            lengthChange: false,
            searching: false,
            dom: '<"row mb-2"<"col-sm-12 text-right"B>>rtip',
            buttons: [
                {
                    extend: 'csv',
                    text: 'Download CSV',
                    className: 'btn btn-secondary'
                },
                {
                    extend: 'excel',
                    text: 'Download Excel',
                    className: 'btn btn-secondary'
                }
            ]
        });
    }

    // ========== 全局浮窗函数 ==========
    window.showRelatedSerials = function(event, bidsString) {
        event.stopPropagation();
        $('.custom-related-popover').remove();

        let linksHtml = '';
        let bidsArray = String(bidsString).split(',');
        let validCount = 0;

        bidsArray.forEach(function(bId) {
            let cleanId = bId.trim();
            if (cleanId !== '') {
                validCount++;
                linksHtml += `<a href="detail_browse.php?id=${encodeURIComponent(cleanId)}" target="_blank"
                                 style="display: inline-block; padding: 4px 10px; margin: 0 6px 8px 0;
                                        background-color: #f0f7ff; border: 1px solid #cce5ff;
                                        border-radius: 14px; color: #0056b3; text-decoration: none;
                                        font-size: 12px; font-weight: 500; transition: all 0.2s;">
                                ${cleanId}
                              </a>`;
            }
        });

        if (linksHtml === '') {
            linksHtml = '<div style="color:#999; font-size: 12px; padding: 10px 0;">No related data</div>';
        }

        let popover = $(`
            <div class="custom-related-popover" style="position: absolute; background: #fff; border: 1px solid #eaeaea; padding: 14px 16px 6px 16px; border-radius: 8px; box-shadow: 0 10px 25px rgba(0,0,0,0.15); z-index: 9999; width: 320px; display: none;">
                <div style="font-size: 13px; font-weight: bold; color: #333; margin-bottom: 12px; border-bottom: 1px solid #eee; padding-bottom: 8px; display: flex; justify-content: space-between; align-items: center;">
                    <span>Related Serials <span style="color:#17a2b8;">(${validCount})</span></span>
                    <span style="color: #999; cursor: pointer; font-size: 18px; line-height: 1;" onclick="$('.custom-related-popover').remove();">&times;</span>
                </div>
                <div style="max-height: 200px; overflow-y: auto; padding-right: 4px;">
                    ${linksHtml}
                </div>
            </div>
        `);

        let btn = $(event.target);
        let offset = btn.offset();

        $('body').append(popover);

        popover.css({
            top: offset.top + btn.outerHeight() + 8 + 'px',
            left: offset.left + 'px'
        }).fadeIn(200);

        popover.on('click', function(e) {
            e.stopPropagation();
        });

        popover.find('a').hover(
            function() { $(this).css({ 'background-color': '#cce5ff', 'text-decoration': 'none' }); },
            function() { $(this).css({ 'background-color': '#f0f7ff' }); }
        );
    };
</script>

<?php
include "./Template/footer.php";
?>

</body>
</html>