<!--include base-->
<?php
include "./Template/base.php";
?>
<!--include header-->
<?php include './Template/header.php';
?>

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    .btn-secondary {
        color: #fff !important;
        font-size: 15px !important;
        background-color: #8cb0e6 !important;
        border: none !important;
        margin-left: 10px !important;
        margin-top: -5px !important;
        margin-bottom: 10px !important;
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
<div class="container-fluid d-flex justify-content-center" style="width:100%;">
    <div class="row w-100">
        <div class="col-12 col-lg-11 mx-auto">
            <div class="card shadow-sm" id="card_browser_tc"  style="margin: 20px auto; text-align: center; max-width: 1300px;">
                <div class="card-header d-flex align-items-center justify-content-center"
                     style="height: 60px; color: #0362a4; font-size: 1.2rem; font-weight: bold;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                         viewBox="0 0 24 24" class="me-2">
                        <g fill="none">
                            <circle cx="12" cy="12" r="9.25" stroke="#0284c7" stroke-width="1.5"/>
                            <path stroke="#0284c7" stroke-linecap="round" stroke-width="1.5" d="M12 12.438v-5"/>
                            <circle cx="1.25" cy="1.25" r="1.25" fill="#0284c7"
                                    transform="matrix(1 0 0 -1 10.75 17.063)"/>
                        </g>
                    </svg>
                    Search Result
                </div>
                <div class="card-body">
                    <!--DataTables pos-->
                    <table id="tc_sample" class="table table-hover table-bordered" style="width: 100%;max-width: 100%; overflow-x: auto; table-layout: auto;">
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
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    // 注册自定义排序函数：GEOStudy（如 GSE123456 -> 123456）
    jQuery.extend(jQuery.fn.dataTable.ext.type.order, {
        "geo-id-pre": function (data) {
            if (!data) return 0;
            const match = data.match(/\d+/);
            return match ? parseInt(match[0], 10) : 0;
        }
    });

    // 解析 URL 参数
    const params = new URLSearchParams(window.location.search);
    const search_type = params.get("type");   // Step 1: e.g., Single or Panel
    const search_field = params.get("field"); // Step 2: e.g., Source, Disease, etc.
    const search_val = params.get("val");     // Step 3: e.g., Blood, Lung Cancer, etc.

    // 可选：在页面上显示当前的搜索条件
    if(search_type && search_field && search_val) {
        console.log(`Searching for: Type=${search_type}, ${search_field}=${search_val}`);
    }

    // 初始化 DataTable
    $('#tc_sample').DataTable({
        processing: true,
        serverSide: true,
        serverMethod: 'post',
        searching: true, // 开启全局搜索框

        // 统一使用你的高颜值排版
        dom: '<"row mb-2"<"col-md-8 d-flex align-items-center"lB><"col-md-4 text-right"f>>rtip',
        buttons: [
            { extend: 'csv', text: 'Download CSV', className: 'btn btn-secondary' },
            { extend: 'excel', text: 'Download Excel', className: 'btn btn-secondary' }
        ],
        lengthMenu: [10, 25, 50, 100],
        pageLength: 25,

        ajax: {
            url: './api/result_search.php',
            type: 'POST',
            data: function (d) {
                // 把 URL 解析出来的参数传递给后端
                d.search_type = search_type;
                d.search_field = search_field;
                d.search_val = search_val;
                return d;
            },
        },
        order: [[0, 'asc']],  // 默认按 biomarker_ID 升序排序
        columns: [
            {
                data: 'biomarker_ID',
                orderable: true,
                render: function (data, type, row) {
                    return '<a href="detail_browse.php?id=' + encodeURIComponent(row['biomarker_ID']) + '" target="_blank">' + data + '</a>';
                }
            },
            { data: 'Category', orderable: false },
            { data: 'marker_type', orderable: false },
            { data: 'Source', orderable: false },
            { data: 'Disease', orderable: false },
            { data: 'Clinical_value', orderable: false },
            { data: 'features', orderable: false },
        ]
    });
</script>







<?php
include "./Template/footer.php";
?>
