<?php include "./Template/base.php"; ?>
<?php include './Template/header.php'; ?>
<style>

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    html, body {
        height: 100%;
        margin: 0;
        display: flex;
        flex-direction: column;
    }

    #mainContain,
    .container {
        flex: 1 0 auto;
    }

    footer, .footer {
        margin-top: auto;
    }


    .quick-search {
        width: 100%;
        padding: 20px 80px;
        text-align: center;
    }
    .quick-search input {
        width: 60%;
        padding: 10px 15px;
        font-size: 16px;
        border: 1px solid #ccc;
        border-radius: 6px;
    }


    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 15px;
        padding: 0 80px 30px;
    }
    .stats-card {
        background: #f8f9fa;
        border-radius: 10px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        padding: 20px;
        text-align: center;
        font-size: 20px;
        font-weight: bold;
        color: #0362a4;
    }


    .search-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        padding: 20px 80px;
    }

    .search-thumb {
        display: flex;
        align-items: center;
        justify-content: flex-start;
        border-radius: 10px;
        overflow: hidden;
        cursor: pointer;
        transition: all 0.3s;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        background: #f0f0f0;
    }
    .search-thumb img {
        width: 50%;
        height: 200px;
        object-fit: cover;
        transition: filter 0.3s;
    }
    .search-thumb h2 {
        flex: 1;
        margin: 0;
        padding: 0 15px;
        font-size: 25px;
        color: #0362a4;
        font-weight: bold;
    }
    .search-thumb:hover img {
        filter: brightness(0.7);
    }

    .search-card {
        display: none;
    }

    /* 弹窗遮罩层 */
    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.5);
        display: none;
        justify-content: center;
        align-items: center;
        z-index: 1000;
    }

    .modal-content {
        position: relative;
        background: white;
        width: 95%; /* 从80%增加到95% */
        max-width: 1400px; /* 添加最大宽度限制 */
        height: 85%; /* 稍微调整高度以保持比例 */
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0,0,0,0.3); /* 添加阴影增强视觉效果 */
    }


    .modal-close {
        position: absolute;      /* 相对于 modal-content 定位 */
        top: 15px;               /* 离浮窗顶部 10px，可调整 */
        right: 15px;             /* 离浮窗右侧 10px，可调整 */
        font-size: 28px;
        font-weight: bold;
        color: white;
        cursor: pointer;
        z-index: 1001;
    }

    .modal-close:hover {
        color: #ff4d4f;
    }

    .quick-search {
        width: 100%;
        padding: 20px 80px;
        text-align: center;
        position: relative;
    }
    .quick-search .search-wrapper {
        position: relative;
        display: inline-block;
        width: 60%;
    }
    .quick-search input {
        width: 100%;
        padding: 10px 50px 10px 15px;
        font-size: 16px;
        border: 1px solid #ccc;
        border-radius: 6px;
    }
    .quick-search button {
        position: absolute;
        right: 5px;
        top: 50%;
        transform: translateY(-50%);
        padding: 6px 15px;
        font-size: 14px;
        background: #fff;   /* 白色背景 */
        color: #000;        /* 黑色字体 */
        border: 1px solid #ccc;
        border-radius: 6px;
        cursor: pointer;
        display: none; /* 默认隐藏 */
    }
    .quick-search button:hover {
        background: #f5f5f5;
    }
    .quick-suggestions {
        margin-top: 10px;
        font-size: 14px;
        color: #555;
    }
    .quick-suggestions span {
        color: #0362a4;
        cursor: pointer;
        margin-right: 10px;
    }

    /* 统计区域 */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 0; /* 去掉间距 */
        padding: 0 80px 30px;
        text-align: center;
        font-size: 18px;
        color: #0362a4;
    }
    .stats-card {
        padding: 10px;
        font-weight: normal; /* 取消加粗 */
        border-right: 1px solid #ddd; /* 分隔竖线 */
    }
    .stats-card:last-child {
        border-right: none; /* 最后一个不加竖线 */
    }
    .stats-card svg {
        width: 28px;
        height: 28px;
        margin-bottom: 5px;
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
    .advanced-divider {
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
    .cl-search-title {
        padding: 10px 80px;
    }
    .advanced-card {
        background: #f8f9fc;
        border: 1px solid #e2e6f0;
        border-radius: 8px;
        padding: 18px 20px;
        margin-bottom: 20px;
    }

    /* 标签标题 */
    .section-label {
        font-weight: 600;
        margin-right: 12px;
    }

    /* ===== Biomarker 标签 ===== */
    .biomarker-tag-group {
        display: inline-flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 8px;
    }

    .biomarker-tag {
        padding: 4px 10px;
        font-size: 16px;
        border-radius: 12px;
        background: #ffffff;
        border: 1px solid #cfd6e4;
        color: #344767;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .biomarker-tag:hover {
        background: #e9ecef;
    }

    /* 选中状态 */
    .biomarker-tag.active {
        background: #5e72e4;
        color: #fff;
        border-color: #5e72e4;
    }

    /* ===== Help ===== */
    .advanced-search-help {
        margin-top: 12px;
        font-size: 13px;
        color: #555;
    }

    .advanced-search-help ul {
        padding-left: 18px;
        margin-bottom: 0;
    }

    .advanced-search-help code {
        background: #eef1f7;
        padding: 1px 4px;
        border-radius: 4px;
    }

    /* ===== Block 2: 灰色逻辑区 ===== */
    .condition-card {
        background: #f2f3f5;
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 16px;
    }

    /* 统一 header */
    .box-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-weight: 600;
        margin-bottom: 10px;
    }

    /* 条件行 */
    .condition-row {
        display: flex;
        gap: 8px;
        align-items: center;
        margin-bottom: 8px;
    }

    .condition-row select,
    .condition-row input {
        font-size: 13px;
    }
    .search-action-bar {
        margin-top: 16px;
        display: flex;
        justify-content: flex-start;
        gap: 10px;
    }

    .search-action-bar .btn {
        margin: 0 6px;
        min-width: 120px;
    }

</style>

<div class="detail-search-title">
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
    </svg>
    Detail Search
</div>
<hr class="detail-divider">
<!-- 主搜索区域 -->
<div class="search-grid">
    <!-- Disease -->
    <div>
        <div class="search-thumb" data-target="Disease">
            <img src="./public/image/search/Disease.png" alt="Disease">
            <h2>Disease</h2>
        </div>
        <div class="search-card" id="Disease">
            <iframe src="./iframe/iframe_disease.php"></iframe>
        </div>
    </div>

    <!--Source -->
    <div>
        <div class="search-thumb" data-target="Source">
            <img src="./public/image/search/Source.png" alt="Source">
            <h2>Source</h2>
        </div>
        <div class="search-card" id="Source">
            <iframe src="./iframe/iframe_source.php"></iframe>
        </div>
    </div>

    <!-- Category -->
    <div>
        <div class="search-thumb" data-target="Category">
            <img src="./public/image/search/Category.png" alt="Category">
            <h2>Category</h2>
        </div>
        <div class="search-card" id="Category">
            <iframe src="./iframe/iframe_category.php"></iframe>
        </div>
    </div>

    <!-- Country -->
    <div>
        <div class="search-thumb" data-target="Country">
            <img src="./public/image/search/world.png" alt="Country">
            <h2>Country</h2>
        </div>
        <div class="search-card" id="Country">
            <iframe src="./iframe/iframe_country.php"></iframe>
        </div>
    </div>

</div>
<br>

<!-- 弹窗区域 -->
<div class="modal-overlay" id="searchModal">
    <span class="modal-close" id="modalClose">&times;</span>
    <div class="modal-content">
        <div class="modal-body" id="modalBody"></div>
    </div>
</div>


<div class="detail-search-title">
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
         fill="currentColor" class="bi bi-funnel" viewBox="0 0 16 16">
        <path d="M1.5 1.5A.5.5 0 0 1 2 1h12a.5.5 0 0 1 .4.8L10 8.333V13.5a.5.5 0 0 1-.8.4l-2-1.5a.5.5 0 0 1-.2-.4V8.333L1.6 1.8a.5.5 0 0 1-.1-.3z"/>
    </svg>
    Classified Search
</div>
<hr class="advanced-divider">
<div class="cl-search-title">
    <div class="advanced-card">

        <!-- Biomarker type (标签式) -->
        <div class="biomarker-type-box">
            <span class="section-label">Biomarker Type :</span>

            <div class="biomarker-tag-group">
                <span class="biomarker-tag" data-type="Diagnostic">Diagnostic</span>
                <span class="biomarker-tag" data-type="Monitoring">Monitoring</span>
                <span class="biomarker-tag" data-type="Predictive">Predictive</span>
                <span class="biomarker-tag" data-type="Prognostic">Prognostic</span>
                <span class="biomarker-tag" data-type="Response">Response</span>
                <span class="biomarker-tag" data-type="Safety">Safety</span>
            </div>
        </div>

        <!-- Help text -->
        <div class="advanced-search-help">
            <p><strong>Classified Search</strong> provides a powerful interface for searching the database.
                You can build up queries that support a wide range of conditions and predicates.</p>

            <ul>
                <li> First of all, you need to select a <strong>BIOMAKRER TYPE TAG </strong>and then proceed with the following operations.</li>
                <li>Multiple terms are treated as <strong>OR</strong> by default.</li>
                <li>Use <code>*</code> for wildcard matching (e.g. <code>*cancer</code>, <code>*methylation*</code>).</li>
                <li>Use quotes for exact matching (e.g. <code>"Gastric cancer"</code>).</li>
            </ul>
        </div>

    </div>


    <!-- ===== Block 2: Conditions + Display Fields（灰色背景）===== -->
    <div class="condition-card">

        <!-- Search Conditions -->
        <div class="search-condition-box">
            <div class="box-header">
                <span>Search Conditions</span>
                <button class="btn btn-sm btn-success" id="addConditionBtn">
                    + Add Search Condition
                </button>
            </div>

            <div id="conditionContainer"></div>
        </div>



        <hr>
        <div class="search-action-bar">
            <button class="btn btn-primary" id="runSearchBtn">Search</button>
            <button class="btn btn-outline-secondary" id="loadExampleBtn">Load example</button>
            <button class="btn btn-outline-danger" id="clearAllBtn">Clear</button>
        </div>

    </div>

    <div id="resultArea" class="mt-4 d-none">
        <table id="resultTable" class="display table table-bordered table-striped" style="width:100%">
            <thead>
            <tr>
                <th>Serial Number</th>
                <th>Biomarker ID</th>
                <th>Category</th>
                <th>Marker type</th>
                <th>Source</th>
                <th>Disease</th>
                <th>Clinical Value</th>
                <th>Features</th>
                <th>Year</th>
            </tr>
            </thead>
        </table>
    </div>

</div>


<script type="text/template" id="condition-template">
    <div class="condition-row">

        <!-- Field -->
        <select class="form-select field-select">
            <option value="" selected disabled>Select field</option>
            <option value="Disease">Disease</option>
            <option value="MarkerType">Marker type</option>
            <option value="Features">Features</option>
            <option value="Source">Source</option>
            <option value="Country">Country</option>
            <option value="Year">Year</option>
        </select>

        <!-- Operator -->
        <select class="form-select operator-select">
            <option value="contains">contains</option>
            <option value="equals">equals</option>
            <option value="not">not</option>
        </select>

        <!-- Value -->
        <input type="text" class="form-control value-input" placeholder="Enter value">

        <!-- Marker type 专用 -->
        <select class="form-select marker-type-select d-none">
            <option value="">Select type</option>
            <option value="Single">Single</option>
            <option value="Panel">Panel</option>
        </select>

        <button class="btn btn-sm btn-danger remove-condition">×</button>
    </div>
</script>

<script >
    let resultTable = null;
    let selectedBiomarkerType = null;

    /* Biomarker 标签 */
    $('.biomarker-tag').on('click', function () {
        $('.biomarker-tag').removeClass('active');
        $(this).addClass('active');
        selectedBiomarkerType = $(this).data('type');
    });

    /* Add condition */
    $('#addConditionBtn').on('click', function () {
        if (!requireBiomarkerType()) return;

        let tpl = $('#condition-template').html();
        $('#conditionContainer').append(tpl);

        updateFieldSelectOptions();
    });


    /* Add display field */
    $('#addDisplayFieldBtn').on('click', function () {
        if (!requireBiomarkerType()) return;

    });

    /* Remove condition */
    $(document).on('click', '.remove-condition', function () {
        $(this).closest('.condition-row').remove();

        updateFieldSelectOptions();
    });
    /* 切换 Marker type 显示逻辑 */
    $(document).on('change', '.field-select', function () {
        const row = $(this).closest('.condition-row');
        const field = $(this).val();

        if (field === 'MarkerType') {
            row.find('.operator-select, .value-input').addClass('d-none');
            row.find('.marker-type-select').removeClass('d-none');
        } else {
            row.find('.operator-select, .value-input').removeClass('d-none');
            row.find('.marker-type-select').addClass('d-none');
        }

        updateFieldSelectOptions();
    });
    function requireBiomarkerType() {
        if (!selectedBiomarkerType) {
            alert('Please select a Biomarker type tag first.');
            return false;
        }
        return true;
    }
    function updateFieldSelectOptions() {
        // 收集所有已选 field
        let usedFields = [];

        $('.field-select').each(function () {
            const val = $(this).val();
            if (val) usedFields.push(val);
        });

        // 遍历每一个 field-select
        $('.field-select').each(function () {
            const currentSelect = $(this);
            const currentVal = currentSelect.val();

            currentSelect.find('option').each(function () {
                const optionVal = $(this).val();

                // 如果该 option 已被其他 select 使用，则禁用
                if (usedFields.includes(optionVal) && optionVal !== currentVal) {
                    $(this).prop('disabled', true);
                } else {
                    $(this).prop('disabled', false);
                }
            });
        });
    }
    $(document).on('change', '.operator-select', function () {
        const row = $(this).closest('.condition-row');
        const operator = $(this).val();
        const input = row.find('.value-input');

        if (operator === 'equals') {
            input.attr('placeholder', 'Enter a single value');
            input.data('single', true);
        } else {
            input.attr('placeholder', 'Enter value');
            input.data('single', false);
        }
    });
    $(document).on('input', '.value-input', function () {
        const isSingle = $(this).data('single');
        if (!isSingle) return;

        const val = $(this).val();

        // 检测空格或英文逗号
        if (/[,\s]+/.test(val.trim())) {
            alert('The "equals" operator only allows a single value.');
            $(this).val(val.split(/[,\s]+/)[0]); // 自动保留第一个
        }
    });
    $('#runSearchBtn').on('click', function () {

        if (!requireBiomarkerType()) return;

        let conditions = [];
        let valid = true;

        $('.condition-row').each(function () {
            const field = $(this).find('.field-select').val();
            if (!field) return; // 没选 field 的行直接忽略

            if (field === 'MarkerType') {
                const typeVal = $(this).find('.marker-type-select').val();
                if (!typeVal) valid = false;

                conditions.push({
                    field: 'MarkerType',
                    operator: 'equals',
                    values: [typeVal]
                });
            } else {
                const operator = $(this).find('.operator-select').val();
                const rawVal = $(this).find('.value-input').val();

                if (!operator || !rawVal) valid = false;

                const values = parseValues(rawVal);

                conditions.push({
                    field: field,
                    operator: operator,
                    values: values
                });
            }
        });

        if (!valid || conditions.length === 0) {
            alert('Please complete all added search conditions.');
            return;
        }

        /* 进入 AJAX 搜索 */
        runAjaxSearch(conditions);
    });

    function runAjaxSearch(conditions) {
        $.ajax({
            url: 'api/search_class.php',
            type: 'POST',
            dataType: 'json',
            contentType: 'application/json',
            data: JSON.stringify({
                biomarkerType: selectedBiomarkerType,
                conditions: conditions
            }),
            success: function (res) {
                renderResultTable(res.data);
            },
            error: function () {
                alert('Search failed.');
            }
        });
    }

    $('#loadExampleBtn').on('click', function () {

        /*  清空现有条件 */
        $('#conditionContainer').empty();

        /*  选中 Biomarker Type = Diagnostic */
        $('.biomarker-tag').removeClass('active');
        $('.biomarker-tag[data-type="Diagnostic"]')
            .addClass('active')
            .trigger('click');

        /* 工具函数：添加一条 condition 并返回 row */
        function addCondition() {
            let tpl = $('#condition-template').html();
            $('#conditionContainer').append(tpl);
            let row = $('#conditionContainer .condition-row').last();
            updateFieldSelectOptions();
            return row;
        }

        /*  Marker type = Panel */
        let row1 = addCondition();
        row1.find('.field-select')
            .val('MarkerType')
            .trigger('change');

        row1.find('.marker-type-select')
            .val('Panel');

        /*  Disease = equals Lung Cancer */
        let row2 = addCondition();
        row2.find('.field-select')
            .val('Disease')
            .trigger('change');

        row2.find('.operator-select')
            .val('contains')
            .trigger('change');

        row2.find('.value-input')
            .val('Gastric cancer,Colorectal cancer');

        /* ️ Source = contains Plasma,Blood */
        let row3 = addCondition();
        row3.find('.field-select')
            .val('Source')
            .trigger('change');

        row3.find('.operator-select')
            .val('equals')
            .trigger('change');

        row3.find('.value-input')
            .val('Plasma');

        /*  Year = contains 2022 2023 2024 */
        let row4 = addCondition();
        row4.find('.field-select')
            .val('Year')
            .trigger('change');

        row4.find('.operator-select')
            .val('contains')
            .trigger('change');

        row4.find('.value-input')
            .val('2022 2023 2024');

    });



    function parseValues(raw) {
        raw = raw.trim();
        if (!raw) return [];

        // 如果包含逗号 → 只按逗号
        if (raw.includes(',')) {
            return raw
                .split(',')
                .map(v => v.trim())
                .filter(v => v);
        }

        // 否则 → 按空格
        return raw
            .split(/\s+/)
            .map(v => v.trim())
            .filter(v => v);
    }

    function renderResultTable(data) {

        $('#resultArea').removeClass('d-none');

        if (!resultTable) {
            resultTable = $('#resultTable').DataTable({
                data: data,
                pageLength: 10,
                lengthMenu: [10, 20, 30, 50],
                searching: true,
                ordering: true,
                columnDefs: [
                    {
                        targets: '_all',          // 所有列
                        className: 'text-center'
                    }
                ],
                columns: [
                    { data: 'BiomarkerID', title: 'Biomarker ID',
                        orderable: true,
                        render: function (data, type, row) {
                            return '<a href="detail_browse.php?id=' + encodeURIComponent(row['BiomarkerID']) + '" target="_blank">' + data + '</a>';
                        }},
                    { data: 'ID', title: 'ID', orderable: true, },
                    { data: 'Category', title: 'Category', orderable: false,  },
                    { data: 'MarkerType', title: 'Marker type' , orderable: false, },
                    { data: 'Source', title: 'Source', orderable: false,  },
                    { data: 'Disease', title: 'Disease', orderable: false,  },
                    { data: 'ClinicalValue', title: 'Clinical Value', orderable: false,  },
                    { data: 'Features', title: 'Features', orderable: false,  },
                    { data: 'Date', title: 'Year', orderable:true, },
                ]
            });
        } else {
            resultTable.clear();
            resultTable.rows.add(data);
            resultTable.draw();
        }
    }
</script>

<script>
    document.querySelectorAll('.search-thumb').forEach(thumb => {
        thumb.addEventListener('click', () => {
            const targetId = thumb.dataset.target;
            const modal = document.getElementById('searchModal');
            const modalBody = document.getElementById('modalBody');

            modalBody.innerHTML = ''; // 清空

            if (targetId === 'tissue') {
                // 左右两个 iframe
                modalBody.innerHTML = `
                    <div style="display:flex; gap:10px; width:100%; height:100%;">
                        <iframe src="iframe/iframe_t.php" style="flex:1; height:100%; border:none;"></iframe>
                        <iframe src="iframe/iframe_c.php" style="flex:1; height:100%; border:none;"></iframe>
                    </div>
                `;
            } else {
                // 普通单 iframe
                const iframe = document.querySelector(`#${targetId} iframe`);
                modalBody.innerHTML = `<iframe src="${iframe.src}" style="width:100%; height:100%; border:none;"></iframe>`;
            }

            modal.style.display = 'flex';
        });
    });

    // 关闭 modal
    document.getElementById('modalClose').addEventListener('click', () => {
        document.getElementById('searchModal').style.display = 'none';
        document.getElementById('modalBody').innerHTML = '';
    });

    document.getElementById('searchModal').addEventListener('click', (e) => {
        if (e.target === e.currentTarget) {
            e.currentTarget.style.display = 'none';
            document.getElementById('modalBody').innerHTML = '';
        }
    });


</script>



<?php
include "./Template/footer.php";
?>
