<?php include "./Template/base.php"; ?>
<?php include './Template/header.php'; ?>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .search-page-container {
            max-width: 1325px;
            margin: 40px auto;
            padding: 0 20px;
        }

        /* 搜索面板通用样式 */
        .search-panel {
            background: #ffffff;
            border-radius: 10px;
            padding: 30px;
            margin-bottom: 40px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            border: 1px solid #dee2e6;
        }

        .panel-title {
            font-size: 1.5rem;
            color: #2c3e50; /* 恢复为原来的深色 */
            font-weight: bold;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 10px;
            border-bottom: 2px solid #e9ecef;
            padding-bottom: 15px;
        }

        .search-note {
            background-color: #f8f9fa; /* 恢复原本的浅灰底色 */
            border-left: 4px solid #2980b9; /* 恢复原本的低调边框色 */
            color: #495057; /* 恢复深灰字体 */
            padding: 12px 16px;
            font-size: 0.95rem;
            margin-bottom: 25px;
            border-radius: 0 6px 6px 0;
            display: flex;
            align-items: flex-start;
            line-height: 1.5;
        }

        .search-note strong {
            color: #343a40;
            margin-right: 5px;
        }

        /* === 步骤容器 === */
        .step-container {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 25px;
            flex-wrap: wrap; /* 适配窄屏幕 */
        }

        .step-box {
            flex: 1; /* 三个模块平分宽度 */
            min-width: 250px;
            background: #f8f9fa;
            padding: 25px 20px 20px 20px;
            border-radius: 8px;
            border: 1px solid #dee2e6;
            position: relative;
            display: flex;
            flex-direction: column;
        }

        /* ★ 修改：保留胶囊形状，恢复深灰黑背景，取消全部大写 */
        .step-badge {
            position: absolute;
            top: -16px;
            left: 20px;
            background: #2c3e50; /* 恢复深灰黑色 */
            color: white;
            padding: 4px 16px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
            box-shadow: 0 4px 10px rgba(44, 62, 80, 0.2); /* 修改为深色柔和阴影 */
            border: 3px solid #ffffff;
        }

        .step-title {
            font-weight: 600;
            color: #212529;
            margin-bottom: 15px;
            margin-top: 8px;
            font-size: 1.1rem;
        }

        /* === 标签框样式（现在横跨全宽） === */
        .full-width-tags-container {
            margin-bottom: 30px;
            background: #ffffff;
        }

        .results-box {
            border: 1px solid #ced4da;
            border-radius: 6px;
            background-color: #fcfcfc;
            min-height: 160px;
            max-height: 250px; /* 增加一点最大高度 */
            overflow-y: auto;
            padding: 15px;
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            align-content: flex-start;
        }

        .value-tag {
            background-color: #ffffff;
            border: 1px solid #ced4da;
            color: #495057;
            padding: 6px 14px;
            border-radius: 16px;
            font-size: 14px;
            cursor: pointer;
            user-select: none;
            transition: all 0.2s ease;
        }

        .value-tag:hover {
            border-color: #0d6efd;
            color: #0d6efd;
            background-color: #f0f7ff;
        }

        .value-tag.selected {
            background-color: #3498db;
            border-color: #0d6efd;
            color: white;
            box-shadow: 0 2px 6px rgba(13, 110, 253, 0.3);
        }

        /* === 按钮样式 === */
        .btn-search {
            background-color: #3498db;
            color: white;
            padding: 10px 30px;
            font-size: 1.1rem;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: 0.3s;
            font-weight: 500;
        }

        .btn-search:hover {
            background-color: #0b5ed7;
            box-shadow: 0 4px 10px rgba(13, 110, 253, 0.2);
        }

    </style>

    <div class="search-page-container">

        <div class="search-panel">
            <div class="panel-title">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 16 16"><path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/></svg>
                cfDNAdb Database Search
            </div>

            <div class="search-note">
                <div>
                    <strong>Note:</strong> Follow the 3 steps below. In Step 3, you can either select a value from the dropdown or click a tag in the box below. <b>Double-click</b> a tag for an instant search.
                </div>
            </div>

            <div class="step-container">
                <div class="step-box">
                    <div class="step-badge">Step 1</div>
                    <div class="step-title">Marker Type</div>
                    <select id="step1" class="form-select">
                        <option value="" disabled selected>-- Choose Type --</option>
                        <option value="Single">Single</option>
                        <option value="Panel">Panel</option>
                    </select>
                </div>

                <div class="step-box">
                    <div class="step-badge">Step 2</div>
                    <div class="step-title">Filter Field</div>
                    <select id="step2" class="form-select" disabled>
                        <option value="" disabled selected>-- Choose Field --</option>
                        <option value="Disease">Cancer entity/Subtype</option>
                        <option value="Category">Category</option>
                        <option value="Source">Source</option>
                        <option value="Clinical_value">Clinical Value</option>
                    </select>
                </div>

                <div class="step-box">
                    <div class="step-badge">Step 3</div>
                    <div class="step-title">Select Value</div>
                    <select id="step3_select" class="form-select" disabled>
                        <option value="" disabled selected>-- Waiting for Step 1 and Step 2 --</option>
                    </select>
                </div>
            </div>

            <div class="full-width-tags-container">
                <div style="font-size: 0.95rem; font-weight: 500; color: #495057; margin-bottom: 10px;">
                    Or quick select from the tags below (Double-click to search):
                </div>

                <div id="step3_box" class="results-box">
                    <div class="text-muted text-center w-100 mt-5" style="font-size: 1rem;">Please select Step 1 & 2 first</div>
                </div>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 15px;">
                <button type="button" id="btnLoadExample" class="btn btn-outline-secondary" style="border-radius: 6px; padding: 10px 20px; font-weight: 500;">Load Example</button>
                <button type="button" id="btnReset" class="btn btn-outline-danger" style="border-radius: 6px; padding: 10px 20px; font-weight: 500;">Reset</button>
                <button type="button" id="btnSearch" class="btn-search">Search <i class="bi bi-arrow-right"></i></button>
            </div>
        </div>

    </div>

    <script>
        $(document).ready(function() {

            // ==========================================
            // 核心功能 1：前置步骤级联逻辑
            // ==========================================

            // Step 1 改变时 -> 解锁并重置 Step 2
            $('#step1').change(function() {
                if($(this).val() !== "") {
                    $('#step2').prop('disabled', false).val('');
                    resetStep3();
                }
            });

            // Step 2 改变时 -> 触发 AJAX 加载 Step 3
            $('#step2').change(function() {
                let selectedField = $(this).val();
                let selectedType = $('#step1').val();

                if(selectedField !== "") {
                    loadStep3Data(selectedField, selectedType);
                }
            });

            function resetStep3() {
                $('#step3_select').html('<option value="" disabled selected>-- Waiting for Step 2 --</option>').prop('disabled', true);
                $('#step3_box').html('<div class="text-muted text-center w-100 mt-5" style="font-size: 1rem;">Please select Step 1 & 2 first</div>');
            }

            // ==========================================
            // 核心功能 2：加载 Step 3 数据 (支持自动选中)
            // ==========================================
            function loadStep3Data(field, type, autoSelectValue = null) {
                let select = $('#step3_select');
                let box = $('#step3_box');

                select.prop('disabled', false).html('<option value="" disabled selected>Loading...</option>');
                box.html('<div class="text-muted text-center w-100 mt-5">Loading data from database...</div>');

                $.ajax({
                    url: './api/get_distinct_values.php',
                    type: 'POST',
                    data: { column: field, type: type },
                    dataType: 'json',
                    success: function(res) {
                        if (res.error) {
                            select.html('<option value="" disabled selected>-- Error loading --</option>');
                            box.html(`<div class="text-danger w-100 text-center mt-5">Error: ${res.error}</div>`);
                            return;
                        }

                        let options = '<option value="" disabled selected>-- Select a value --</option>';
                        box.empty();
                        let hasData = false;

                        res.forEach(item => {
                            if (item && String(item).trim() !== '') {
                                hasData = true;
                                let isSelected = (item === autoSelectValue);

                                // 生成下拉框 Option
                                options += `<option value="${item}" ${isSelected ? 'selected' : ''}>${item}</option>`;

                                // 生成标签框 Tag
                                let tag = $(`<div class="value-tag ${isSelected ? 'selected' : ''}">${item}</div>`);
                                box.append(tag);
                            }
                        });

                        if (!hasData) {
                            select.html('<option value="" disabled selected>-- No data --</option>');
                            box.html('<div class="text-muted w-100 text-center mt-5">No data available</div>');
                        } else {
                            select.html(options);

                            // 如果有自动选中的值，滚动标签框到对应位置
                            if (autoSelectValue) {
                                select.val(autoSelectValue);
                                let targetTag = box.find('.value-tag.selected');
                                if (targetTag.length) {
                                    box.scrollTop(box.scrollTop() + targetTag.position().top - box.height()/2 + targetTag.height()/2);
                                }
                            }
                        }
                    },
                    error: function() {
                        select.html('<option value="" disabled selected>-- Connection Error --</option>');
                        box.html('<div class="text-danger w-100 text-center mt-5">Failed to connect to API</div>');
                    }
                });
            }

            // ==========================================
            // 核心功能 3：下拉框与标签框的【双向同步】
            // ==========================================

            // 当用户在下拉框中选择时 -> 同步高亮标签框中的对应标签
            $('#step3_select').change(function() {
                let selectedVal = $(this).val();
                let box = $('#step3_box');

                box.find('.value-tag').removeClass('selected');

                if(selectedVal) {
                    // 使用 filter 严格匹配文本内容
                    let targetTag = box.find('.value-tag').filter(function() {
                        return $(this).text() === selectedVal;
                    });

                    if(targetTag.length) {
                        targetTag.addClass('selected');
                        // 自动滚动到标签位置
                        box.scrollTop(box.scrollTop() + targetTag.position().top - box.height()/2 + targetTag.height()/2);
                    }
                }
            });

            // 当用户在标签框中单击时 -> 同步改变下拉框的值
            $('#step3_box').on('click', '.value-tag', function() {
                $('#step3_box .value-tag').removeClass('selected');
                $(this).addClass('selected');

                let selectedVal = $(this).text();
                $('#step3_select').val(selectedVal);
            });

            // 当用户在标签框中【双击】时 -> 直接执行搜索
            $('#step3_box').on('dblclick', '.value-tag', function() {
                $('#step3_box .value-tag').removeClass('selected');
                $(this).addClass('selected');

                let selectedVal = $(this).text();
                $('#step3_select').val(selectedVal);

                executeSearch();
            });

            // ==========================================
            // 核心功能 4：操作按钮逻辑
            // ==========================================

            function executeSearch() {
                let type = $('#step1').val();
                let field = $('#step2').val();
                let value = $('#step3_select').val();

                if(!type || !field || !value) {
                    alert("Please complete all 3 steps (Type -> Field -> Value) before searching.");
                    return;
                }

                let targetUrl = `result_search.php?type=${encodeURIComponent(type)}&field=${encodeURIComponent(field)}&val=${encodeURIComponent(value)}`;
                window.open(targetUrl, '_blank');
            }

            // 搜索按钮
            $('#btnSearch').click(function() {
                executeSearch();
            });

            // 示例加载按钮
            $('#btnLoadExample').click(function() {
                $('#step1').val('Single');
                $('#step2').prop('disabled', false).val('Category');

                // 触发 AJAX 并告知自动选中 "cfDNA"
                loadStep3Data('Category', 'Single', 'cfDNA');
            });

            // 重置按钮
            $('#btnReset').click(function() {
                $('#step1').val('');
                $('#step2').val('').prop('disabled', true);
                resetStep3();
            });

        });
    </script>

<?php include "./Template/footer.php"; ?>