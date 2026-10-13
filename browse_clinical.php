<?php include "./Template/base.php"; ?>

<?php include './Template/header.php'; ?>
<style>


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

<body>

<!-- 主要内容 -->
<div class="container">
    <!-- 筛选面板 -->
    <div class="filters-panel">
        <div class="filter-section">
            <div class="filter-title">1. Filter by marker type:</div>
            <div class="filter-options">
                <div class="filter-option">
                    <input type="checkbox" id="type-single" name="marker-type" value="Single">
                    <label for="type-single">Single</label>
                </div>
                <div class="filter-option">
                    <input type="checkbox" id="type-panel" name="marker-type" value="Panel">
                    <label for="type-panel">Panel</label>
                </div>
            </div>
        </div>

        <div class="filter-section">
            <div class="filter-title">2. Filter by marker clinical value:</div>
            <div class="filter-options">
                <div class="filter-option">
                    <input type="checkbox" id="status-Prognostic" name="marker-status" value="Prognostic">
                    <label for="status-Prognostic">Prognostic</label>
                </div>
                <div class="filter-option">
                    <input type="checkbox" id="status-Diagnostic" name="marker-status" value="Diagnostic">
                    <label for="status-Diagnostic">Diagnostic</label>
                </div>
                <div class="filter-option">
                    <input type="checkbox" id="status-Predictive" name="marker-status" value="Predictive">
                    <label for="status-Predictive">Predictive</label>
                </div>
                <div class="filter-option">
                    <input type="checkbox" id="status-Minitoring" name="marker-status" value="Minitoring">
                    <label for="status-Minitoring">Minitoring</label>
                </div>
                <div class="filter-option">
                    <input type="checkbox" id="status-Response" name="marker-status" value="Response">
                    <label for="status-Response">Response</label>
                </div>
                <div class="filter-option">
                    <input type="checkbox" id="status-Safety" name="marker-status" value="Safety">
                    <label for="status-Safety">Safety</label>
                </div>
            </div>
        </div>


        <div class="filter-actions">
            <button class="btn btn-secondary" onclick="clearFilters()">Clear All</button>
            <button class="btn btn-primary" onclick="applyFilters()">Apply Filters</button>
        </div>
    </div>

    <!-- 数据表格 -->
    <div class="data-section">
        <div class="section-header">
            <div class="section-title">Biomarkers</div>
        </div>

        <table id="biomarkersTable"  style="width:100%">
            <thead>
            <tr>
                <th>Serial Number</th>
                <th>Category</th>
                <th>Marker type</th>
                <th>Source</th>
                <th>Disease</th>
                <th>Clinical Value</th>
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
    $(document).ready(function () {

        // 初始化 DataTable
        let table = $('#biomarkersTable').DataTable({
            processing: true,
            serverSide: true,
            searching: false,
            ajax: {
                url: "./api/search_biomarkers.php",
                type: "POST",
                data: function (d) {
                    d.types = getSelectedValues('marker-type');
                    d.status = getSelectedValues('marker-status');
                    d.biofluid = getSelectedValues('biofluid');
                    d.disease = getSelectedValues('disease');
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
                { data: "Clinical_value", orderable: false },
                { data: "features", orderable: false },
            ]
        });

        // ========== 全局弹窗函数 (已优化：限定高度、支持滚动、标签式排版) ==========
        window.showRelatedSerials = function(event, bidsString) {
            // 阻止事件冒泡
            event.stopPropagation();

            // 移除已存在的浮窗
            $('.custom-related-popover').remove();

            let linksHtml = '';
            let bidsArray = String(bidsString).split(',');
            let validCount = 0;

            // 遍历生成小标签样式的超链接
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

            // 创建新的浮窗 HTML
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

            // 获取点击按钮的位置
            let btn = $(event.target);
            let offset = btn.offset();

            $('body').append(popover);

            // 设置浮窗位置并增加动画
            popover.css({
                top: offset.top + btn.outerHeight() + 8 + 'px',
                left: offset.left + 'px'
            }).fadeIn(200);

            // 浮窗内部点击不触发关闭事件
            popover.on('click', function(e) {
                e.stopPropagation();
            });

            // 鼠标悬停标签时的简单交互效果
            popover.find('a').hover(
                function() { $(this).css({ 'background-color': '#cce5ff', 'text-decoration': 'none' }); },
                function() { $(this).css({ 'background-color': '#f0f7ff' }); }
            );
        };

        // 点击页面其他任何地方时，带淡出动画关闭浮窗
        $(document).on('click', function() {
            $('.custom-related-popover').fadeOut(150, function() {
                $(this).remove();
            });
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

    function toggleDiseaseFloating(event) {
        // 阻止事件冒泡，防止点击按钮时立即触发了 document 的点击事件
        if(event) {
            event.stopPropagation();
        }

        const wrapper = document.getElementById('diseaseOptionsWrapper');

        if (wrapper.classList.contains('is-floating')) {
            closeDiseaseFloating();
        } else {
            openDiseaseFloating();
        }
    }

    // 专门处理展开
    function openDiseaseFloating() {
        const wrapper = document.getElementById('diseaseOptionsWrapper');
        const overlay = document.getElementById('diseaseOverlay');
        const btn = document.getElementById('toggleDiseaseBtn');

        wrapper.classList.add('is-floating');
        overlay.classList.add('is-active');
        btn.innerHTML = 'Close ▴';
    }

    // 专门处理收起
    function closeDiseaseFloating() {
        const wrapper = document.getElementById('diseaseOptionsWrapper');
        const overlay = document.getElementById('diseaseOverlay');
        const btn = document.getElementById('toggleDiseaseBtn');

        if(wrapper && wrapper.classList.contains('is-floating')) {
            wrapper.classList.remove('is-floating');
            if(overlay) overlay.classList.remove('is-active');
            if(btn) btn.innerHTML = 'More ▾';
            wrapper.scrollTop = 0;
        }
    }

    // 监听浮窗内部的点击，防止点击选项时浮窗意外关闭
    document.addEventListener('DOMContentLoaded', function() {
        const wrapper = document.getElementById('diseaseOptionsWrapper');
        if(wrapper) {
            wrapper.addEventListener('click', function(event) {
                event.stopPropagation();
            });
        }
    });
</script>

<!--include footer-->
<?php
include "./Template/footer.php";
?>

</body>
</html>