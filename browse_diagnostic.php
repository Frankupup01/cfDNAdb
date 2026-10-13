<?php include "./Template/base.php"; ?>

<?php include './Template/header.php'; ?>
    <style>
        /* === 基础样式 === */
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
            --accent-color: #1abc9c;
            --light-color: #ecf0f1;
            --dark-color: #2c3e50;
            --text-color: #333;
            --border-color: #ddd;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #f8f9fa;
            color: var(--text-color);
        }

        .container {
            width: 90%;
            max-width: 1400px;
            margin: 0 auto;
            padding: 20px;
        }

        /* === 导航栏样式 === */
        header {
            background-color: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: bold;
            color: var(--primary-color);
            margin-right: 40px;
        }

        .logo span {
            color: var(--accent-color);
        }

        .nav-left {
            display: flex;
            align-items: center;
            flex: 1;
        }

        .nav-links {
            display: flex;
            list-style: none;
        }

        .nav-links li {
            margin-right: 30px;
        }

        .nav-links a {
            text-decoration: none;
            color: var(--dark-color);
            font-weight: 500;
            transition: color 0.3s;
            padding: 8px 12px;
            border-radius: 4px;
        }

        .nav-links a:hover {
            color: var(--secondary-color);
            background-color: var(--light-color);
        }

        .nav-links a.active {
            color: var(--accent-color);
            background-color: var(--light-color);
        }

        /* === 筛选面板样式 === */
        .filters-panel {
            background: white;
            border-radius: 10px;
            padding: 25px;
            margin: 20px 0;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .filter-section {
            margin-bottom: 25px;
            padding-bottom: 20px;
            border-bottom: 1px solid var(--border-color);
        }

        .filter-section:last-child {
            border-bottom: none;
            margin-bottom: 0;
        }

        .filter-title {
            font-weight: 600;
            margin-bottom: 15px;
            color: var(--primary-color);
            font-size: 1.1rem;
        }

        .filter-options {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }

        .filter-option {
            display: flex;
            align-items: center;
            cursor: pointer;
            padding: 8px 12px;
            border-radius: 6px;
            transition: background-color 0.3s;
        }

        .filter-option:hover {
            background-color: var(--light-color);
        }

        .filter-option input[type="checkbox"] {
            margin-right: 8px;
            width: 16px;
            height: 16px;
            cursor: pointer;
        }

        .filter-option label {
            cursor: pointer;
            user-select: none;
        }

        .filter-actions {
            display: flex;
            justify-content: flex-end;
            gap: 15px;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid var(--border-color);
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s;
        }

        .btn-primary {
            background-color: var(--accent-color);
            color: white;
        }

        .btn-primary:hover {
            background-color: #16a085;
        }

        .btn-secondary {
            background-color: var(--light-color);
            color: var(--dark-color);
        }

        .btn-secondary:hover {
            background-color: #dde4e6;
        }

        /* === 数据表格样式 === */
        .data-section {
            background: white;
            border-radius: 10px;
            padding: 25px;
            margin: 20px 0;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .section-title {
            font-size: 1.3rem;
            color: var(--primary-color);
            font-weight: 600;
        }

        .results-count {
            color: #666;
            font-size: 0.9rem;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        .data-table th,
        .data-table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid var(--border-color);
        }

        .data-table th {
            background-color: var(--light-color);
            font-weight: 600;
            color: var(--primary-color);
            cursor: pointer;
            user-select: none;
        }

        .data-table th:hover {
            background-color: #dde4e6;
        }

        .data-table tbody tr:hover {
            background-color: #f8f9fa;
        }

        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 20px;
            gap: 10px;
        }

        .pagination button {
            padding: 8px 15px;
            border: 1px solid var(--border-color);
            background: white;
            cursor: pointer;
            border-radius: 4px;
            transition: all 0.3s;
        }

        .pagination button:hover:not(:disabled) {
            background-color: var(--light-color);
        }

        .pagination button.active {
            background-color: var(--secondary-color);
            color: white;
            border-color: var(--secondary-color);
        }

        .pagination button:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        /* === 响应式设计 === */
        @media (max-width: 768px) {
            .filter-options {
                flex-direction: column;
                gap: 10px;
            }

            .section-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }

            .data-table {
                font-size: 0.9rem;
            }

            .data-table th,
            .data-table td {
                padding: 8px 10px;
            }
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
    </style>
</head>
<body>

<!-- 主要内容 -->
<div class="container">




        <!-- 数据表格 -->
        <div class="data-section">
            <div class="section-header">
                <div class="section-title">Diagnostic biomarkers</div>
            </div>

            <table id="biomarkersTable"  style="width:100%">
                <thead>
                <tr>
                    <th>Serial Number</th>
                    <th>Category</th>
                    <th>Marker type</th>
                    <th>Source</th>
                    <th>Disease</th>
                    <th>Features</th>
                </tr>
                </thead>
            </table>

            <div class="pagination" id="pagination">
                <!-- 分页将通过JavaScript动态生成 -->
            </div>
        </div>
    </div>

    <script>

        function getQueryParam(name) {
            const params = new URLSearchParams(window.location.search);
            return params.get(name);
        }


        $(document).ready(function () {

            // 初始化 DataTable — 初始就显示全部数据
            let table = $('#biomarkersTable').DataTable({
                processing: true,
                serverSide: true,
                searching: false,
                ajax: {
                    url: "./api/search_biomarkers.php",
                    type: "POST",
                    data: function (d) {
                        const clinicalFromUrl = getQueryParam('Clinical_value');
                        let statusValues = getSelectedValues('marker-status');
                        if (clinicalFromUrl) {
                            statusValues = clinicalFromUrl.split(',');
                        }

                        d.types = getSelectedValues('marker-type');
                        d.status = statusValues;
                        d.biofluid = getSelectedValues('biofluid');
                    }
                },
                columns: [
                    {
                        data: 'biomarker_ID',
                        orderable: true,
                        render: function (data, type, row) {
                            return '<a href="detail_browse.php?id=' + encodeURIComponent(row['biomarker_ID']) + '" target="_blank">' + data + '</a>';
                        }
                    },
                    { data: "Category", orderable: false },
                    { data: "marker_type" },
                    { data: "Source", orderable: false },
                    { data: "Disease", orderable: false },
                    { data: "features", orderable: false },
                ]
            });

            // 点击 Apply Filters 刷新 DataTable
            window.applyFilters = function () {
                table.ajax.reload();
            };

            // 清空筛选
            window.clearFilters = function () {
                $("input[type=checkbox]").prop("checked", false);
                table.ajax.reload();
            };

            // 获取多选框值
            function getSelectedValues(name) {
                return $(`input[name='${name}']:checked`).map(function () {
                    return this.value;
                }).get();
            }
        });
    </script>

<!--include footer-->
<?php
include "./Template/footer.php";
?>

</body>
</html>