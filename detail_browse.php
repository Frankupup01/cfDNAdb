<?php include "./Template/base.php"; ?>

<?php include './Template/header.php'; ?>

    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f6f8;
            color: #333;
            margin: 0;
        }

        .main-container {
            max-width: 1300px;
            margin: 0 auto;
        }

        /* 顶部标题区 */
        .title-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            margin-top: 20px;
        }

        .page-title {
            font-size: 24px;
            margin: 0;
            color: #2c3e50;
            display: flex;
            align-items: center;
        }

        .highlight {
            color: #3498db;
        }

        /* 评分徽章及悬浮窗 */
        .evidence-badge {
            position: relative;
            background-color: #2c3e50;
            color: #fff;
            font-size: 14px;
            padding: 5px 14px;
            border-radius: 20px;
            margin-left: 15px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            cursor: help;
        }

        .evidence-badge span {
            font-size: 14px !important;
        }

        .evidence-badge .tooltip-text {
            visibility: hidden;
            width: 280px;
            background-color: #1e293b;
            color: #f8fafc;
            text-align: left;
            border-radius: 8px;
            padding: 12px;
            position: absolute;
            z-index: 999;
            top: 130%;
            left: 50%;
            transform: translateX(-50%);
            opacity: 0;
            transition: opacity 0.3s;
            font-size: 12px;
            line-height: 1.5;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }

        .evidence-badge .tooltip-text::after {
            content: "";
            position: absolute;
            bottom: 100%;
            left: 50%;
            margin-left: -6px;
            border-width: 6px;
            border-style: solid;
            border-color: transparent transparent #1e293b transparent;
        }

        .evidence-badge:hover .tooltip-text {
            visibility: visible;
            opacity: 1;
        }

        .tooltip-text ul {
            margin: 5px 0 0 0;
            padding-left: 15px;
        }
        .tooltip-text li {
            margin-bottom: 4px;
        }

        /* 动作按钮样式 */
        .action-btns {
            display: flex;
            gap: 10px;
        }
        .action-btn {
            background: #fff;
            border: 1px solid #cbd5e1;
            padding: 6px 15px;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 600;
            color: #475569;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .action-btn:hover {
            border-color: #3498db;
            color: #3498db;
            background: #f0f7ff;
        }

        /* ★ 新增：PPI 图片缩放操作按钮样式 */
        .zoom-btn {
            background: rgba(255, 255, 255, 0.95);
            border: 1px solid #cbd5e1;
            width: 32px;
            height: 32px;
            border-radius: 4px;
            font-size: 18px;
            font-weight: bold;
            color: #475569;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .zoom-btn:hover {
            background: #3498db;
            color: #fff;
            border-color: #3498db;
        }

        .download-img-btn {
            position: absolute;
            top: 15px;
            right: 15px;
            background: rgba(255, 255, 255, 0.95);
            border: 1px solid #cbd5e1;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            color: #475569;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 5px;
            transition: all 0.2s;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            z-index: 10;
        }

        .download-img-btn:hover {
            background: #3498db;
            color: #fff;
            border-color: #3498db;
        }

        .info-section {
            background: #fff;
            border: 1px solid #e1e4e8;
            border-radius: 6px;
            margin-bottom: 25px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            overflow: hidden;
        }

        .section-header {
            background-color: #34495e;
            padding: 12px 20px;
            border-bottom: 1px solid #dfe2e5;
        }

        .section-header h3 {
            margin: 0;
            font-size: 16px;
            font-weight: 600;
            color: #ffffff;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .info-row {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            padding: 6px 0;
            border-bottom: 1px solid #e5e7eb;
        }

        .info-label {
            min-width: 200px;
            font-size: 15px;
            font-weight: 600;
            background: #2980b9;
            color: white;
            padding: 8px 12px;
            border-radius: 6px;
            margin-right: 18px;
            text-align: center;
        }

        .info-value {
            font-size: 15px;
            color: #2c3e50;
        }

        .row-split {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
        }

        .row-split .info-row {
            width: 48%;
        }

        @media (max-width: 768px) {
            .row-split .info-row {
                width: 100%;
            }
        }

        .external-db-btn {
            display: flex;
            align-items: stretch;
            text-decoration: none !important;
            border: 1px solid #2980b9;
            border-radius: 8px;
            overflow: hidden;
            transition: all 0.2s ease;
            background: #fff;
            margin-bottom: 5px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .external-db-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(41, 128, 185, 0.3);
        }

        .db-label {
            background-color: #2980b9;
            color: #ffffff;
            padding: 10px 18px;
            font-size: 15px;
            font-weight: 600;
            display: flex;
            align-items: center;
            border-right: 1px solid rgba(255,255,255,0.2);
        }

        .db-id {
            background-color: #ffffff;
            color: #2980b9;
            padding: 10px 18px;
            font-size: 15px;
            font-weight: 600;
            display: flex;
            align-items: center;
            min-width: 80px;
            justify-content: center;
        }

        .external-db-btn:hover .db-id {
            background-color: #f0f7ff;
        }

        /* 打印样式 */
        @media print {
            header, footer, .action-btns, .download-img-btn, .zoom-btn, .custom-related-popover {
                display: none !important;
            }
            body {
                background: #fff !important;
            }
            .main-container {
                width: 100% !important;
                max-width: none !important;
            }
            .info-section {
                box-shadow: none !important;
                border: 1px solid #000 !important;
            }
        }

    </style>

    <div class="main-container">
        <!-- 顶部标题与导出功能区 -->
        <div class="title-header">
            <h1 class="page-title">
                Biomarker Entry: <span class="highlight" style="margin-left: 8px;"></span>

                <span class="evidence-badge" id="val-evidence-score">
                    <span class="tooltip-text">
                        <b>Scoring Criteria:</b>
                        <ul>
                            <li>★ Database Included</li>
                            <li>★ Peer-reviewed (PubMed)</li>
                            <li>★ Cohort size &ge; 30</li>
                            <li>★ Clinical value & stage proof</li>
                            <li>★ Experimental & stat validation</li>
                        </ul>
                    </span>
                    <!-- 动态插入评分星星 -->
                </span>
            </h1>
            <div class="action-btns">
                <button class="action-btn" onclick="exportCitation()" title="Export citation for EndNote/Mendeley">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-quote" viewBox="0 0 16 16"><path d="M12 12a1 1 0 0 0 1-1V8.558a1 1 0 0 0-1-1h-1.388c0-.351.021-.703.062-1.054.062-.372.166-.703.31-.992.145-.29.331-.517.559-.683.227-.186.516-.279.868-.279V3c-.579 0-1.085.124-1.52.372a3.3 3.3 0 0 0-1.085.992 4.9 4.9 0 0 0-.62 1.458A7.7 7.7 0 0 0 9 7.558V11a1 1 0 0 0 1 1zM3 12a1 1 0 0 0 1-1V8.558a1 1 0 0 0-1-1H1.612c0-.351.021-.703.062-1.054.062-.372.166-.703.31-.992.145-.29.331-.517.559-.683.227-.186.516-.279.868-.279V3c-.579 0-1.085.124-1.52.372a3.3 3.3 0 0 0-1.085.992 4.9 4.9 0 0 0-.62 1.458A7.7 7.7 0 0 0 0 7.558V11a1 1 0 0 0 1 1z"/></svg> Cite
                </button>
                <button class="action-btn" onclick="window.print()" title="Download page as PDF report">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-pdf" viewBox="0 0 16 16"><path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2M9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5z"/><path d="M4.603 14.087a.8.8 0 0 1-.438-.42c-.195-.388-.13-.776.08-1.102.198-.307.526-.568.897-.787a7.7 7.7 0 0 1 1.482-.645 20 20 0 0 0 1.062-2.227 7.3 7.3 0 0 1-.43-1.295c-.086-.4-.119-.796-.046-1.136.075-.354.274-.672.65-.823.192-.077.4-.12.602-.077a.7.7 0 0 1 .477.365c.088.164.12.356.127.538.007.188-.012.396-.047.614-.084.51-.27 1.134-.52 1.794a11 11 0 0 0 .98 1.686 5.8 5.8 0 0 1 1.334.05c.364.066.734.195.96.465.12.144.193.32.2.518.007.192-.047.382-.138.563a1.04 1.04 0 0 1-.354.416.86.86 0 0 1-.51.138c-.331-.014-.654-.196-.933-.417a5.7 5.7 0 0 1-.911-.95 11.6 11.6 0 0 0-1.997.406 11.3 11.3 0 0 1-1.02 1.51c-.292.35-.609.656-.927.787a.8.8 0 0 1-.58.029m1.379-1.901q-.25.115-.459.246c-.328.22-.506.467-.545.738-.039.271.06.438.15.534.115.098.238.083.336.035.097-.052.19-.163.264-.324.088-.192.145-.4.18-.6.032-.18.045-.36.031-.506a6.8 6.8 0 0 0-.354-1.266 22 22 0 0 0 1.049-2.235c-.198.3-.396.6-.583.893m.468-4.475c-.066.305-.098.6-.098.887 0 .285.03.57.088.85a7 7 0 0 0 .615-1.57c.05-.18.087-.354.108-.518.021-.164.025-.316.012-.45a.3.3 0 0 0-.056-.164.3.3 0 0 0-.13-.083.3.3 0 0 0-.214-.017.3.3 0 0 0-.158.077c-.078.066-.145.148-.2.247a3.5 3.5 0 0 0-.18.397c-.055.152-.105.32-.15.503z"/></svg> PDF
                </button>
            </div>
        </div>

        <div class="info-section">
            <div class="section-header">
                <h3>
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-book" viewBox="0 0 16 16">
                        <path d="M1 2.828c.885-.37 2.154-.769 3.388-.893 1.33-.134 2.458.063 3.112.752v9.746c-.935-.53-2.12-.603-3.213-.493-1.18.12-2.37.461-3.287.811zm7.5-.141c.654-.689 1.782-.886 3.112-.752 1.234.124 2.503.523 3.388.893v9.923c-.918-.35-2.107-.692-3.287-.81-1.094-.111-2.278-.039-3.213.492zM8 1.783C7.015.936 5.587.81 4.287.94c-1.514.153-3.042.672-3.994 1.105A.5.5 0 0 0 0 2.5v11a.5.5 0 0 0 .707.455c.882-.4 2.303-.881 3.68-1.02 1.409-.142 2.59.087 3.223.877a.5.5 0 0 0 .78 0c.633-.79 1.814-1.019 3.222-.877 1.378.139 2.8.62 3.681 1.02A.5.5 0 0 0 16 13.5v-11a.5.5 0 0 0-.293-.455c-.952-.433-2.48-.952-3.994-1.105C10.413.809 8.985.936 8 1.783"/>
                    </svg>Details
                </h3>
            </div>

            <div class="section-content" style="padding: 0 20px;">
                <div class="row-split">
                    <div class="info-row">
                        <div class="info-label">CFDNAdb ID</div>
                        <div class="info-value" id="val-markerdb_id"></div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Category</div>
                        <div class="info-value" id="val-category"></div>
                    </div>
                </div>

                <div class="row-split">
                    <div class="info-row">
                        <div class="info-label">Sequence Variant</div>
                        <div class="info-value" id="val-sequence_change"></div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Source</div>
                        <div class="info-value" id="val-source"></div>
                    </div>
                </div>

                <div class="row-split">
                    <div class="info-row">
                        <div class="info-label">Cancer entity/Subtype</div>
                        <div class="info-value" id="val-disease"></div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Clinical Value</div>
                        <div class="info-value" id="val-clinical_value"></div>
                    </div>
                </div>

                <div class="row-split">
                    <div class="info-row">
                        <div class="info-label">Stage</div>
                        <div class="info-value" id="val-stage"></div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Treatment</div>
                        <div class="info-value" id="val-treatment"></div>
                    </div>
                </div>

                <div class="row-split">
                    <div class="info-row">
                        <div class="info-label">Genomic Sequence</div>
                        <div class="info-value" id="val-genomic_sequence"></div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Study Cohort</div>
                        <div class="info-value" id="val-study_cohort"></div>
                    </div>
                </div>

                <div class="row-split">
                    <div class="info-row">
                        <div class="info-label">Gender</div>
                        <div class="info-value" id="val-gender"></div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Mean Age(Range)</div>
                        <div class="info-value" id="val-mean_age"></div>
                    </div>
                </div>

                <div class="row-split">
                    <div class="info-row">
                        <div class="info-label">Country</div>
                        <div class="info-value" id="val-country"></div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Year</div>
                        <div class="info-value" id="val-year"></div>
                    </div>
                </div>

                <div class="row-split">
                    <div class="info-row">
                        <div class="info-label">Participants Quantity</div>
                        <div class="info-value" id="val-participants"></div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">PubMed</div>
                        <!-- 这里将被注入 PubMed 按钮 -->
                        <div class="info-value" id="val-pubmed" style="flex: 1;"></div>
                    </div>
                </div>

                <div class="info-row">
                    <div class="info-label">Biomarker Profile</div>
                    <div class="info-value" id="val-id"></div>
                </div>

                <div class="info-row" style="align-items: center;">
                    <div class="info-label">Features</div>
                    <div class="info-value" style="flex: 1; display: flex; align-items: center; gap: 30px; flex-wrap: wrap;">
                        <div id="val-features" style="white-space: pre-wrap; word-break: break-word; margin: 0;"></div>
                        <div id="features-links" style="display: flex; flex-wrap: wrap; gap: 10px; align-items: center;"></div>
                    </div>
                </div>

                <!-- PPI Network (设置 position: relative 以容纳下载按钮) -->
                <div class="info-row" id="row-string-network" style="display: none; align-items: flex-start;">
                    <div class="info-label" style="margin-top: 10px;">PPI Network</div>
                    <div class="info-value" id="val-string-network" style="position: relative; flex: 1; background: #fff; border: 1px solid #e1e4e8; border-radius: 8px; overflow: hidden; padding: 15px; text-align: center;">
                    </div>
                </div>

                <div class="info-row">
                    <div class="info-label">Description</div>
                    <div class="info-value" id="val-description"></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Statistics</div>
                    <div class="info-value" id="val-statistics"></div>
                </div>
                <div class="row-split">
                    <div class="info-row">
                        <div class="info-label">Experiment</div>
                        <div class="info-value" id="val-experiment"></div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Validation Level</div>
                        <div class="info-value" id="val-validation_Level"></div>
                    </div>
                </div>
                <div class="row-split">
                    <div class="info-row">
                        <div class="info-label">Variation Type</div>
                        <div class="info-value" id="val-variation_Type"></div>
                    </div>
                    <div class="info-row">

                        <div class="info-label">Cytoband</div>
                        <div class="info-value" id="val-cytoband" style="flex: 1;"></div>
                    </div>
                </div>
                <div class="info-row">
                    <div class="info-label">Conclusion</div>
                    <div class="info-value" id="val-conclusion"></div>
                </div>
                <div class="info-row" style="border-bottom: none;">
                    <div class="info-label">Remark</div>
                    <div class="info-value" id="val-remark"></div>
                </div>

            </div>
        </div>
    </div>

    <script>
        let globalMarkerData = {};

        // ★ 全局用于控制缩放和平移的变量
        let ppiZoom = 1;
        let ppiTranslateX = 0;
        let ppiTranslateY = 0;
        let ppiIsDragging = false;
        let ppiStartX = 0;
        let ppiStartY = 0;

        function getQueryParam(name) {
            const url = new URL(window.location.href);
            return url.searchParams.get(name);
        }

        function isValid(val) {
            return val && val !== '-' && String(val).toUpperCase() !== 'NA' && String(val).toUpperCase() !== 'N/A' && val !== 'None';
        }

        function exportCitation() {
            if (!globalMarkerData.biomarker_ID) {
                alert("Data is loading, please wait.");
                return;
            }
            let text = `TY  - DATA\n`;
            text += `T1  - cfDNAdb Biomarker: ${globalMarkerData.ID}\n`;
            text += `A1  - cfDNAdb Database\n`;
            text += `Y1  - ${new Date().getFullYear()}\n`;
            text += `KW  - ${globalMarkerData.Disease}\n`;
            text += `KW  - ${globalMarkerData.Category}\n`;
            text += `UR  - ${window.location.href}\n`;
            text += `ER  - \n`;

            let blob = new Blob([text], {type: "text/plain;charset=utf-8"});
            let link = document.createElement("a");
            link.href = URL.createObjectURL(blob);
            link.download = `cfDNAdb_Citation_${globalMarkerData.biomarker_ID}.ris`;
            link.click();
        }

        // ★ 高清图片下载核心逻辑
        window.downloadStringImage = function(imageUrl, fileName) {
            event.preventDefault();
            // 改变按钮文字提示正在下载
            let btn = $(event.currentTarget);
            let originalHtml = btn.html();
            btn.html('Downloading...');

            fetch(imageUrl)
                .then(response => response.blob())
                .then(blob => {
                    let url = window.URL.createObjectURL(blob);
                    let a = document.createElement('a');
                    a.href = url;
                    a.download = fileName;
                    document.body.appendChild(a);
                    a.click();
                    a.remove();
                    window.URL.revokeObjectURL(url);
                    btn.html(originalHtml);
                })
                .catch(err => {
                    // 如果跨域被拦截，降级为新标签页打开
                    window.open(imageUrl, '_blank');
                    btn.html(originalHtml);
                });
        };

        // ★ 缩放与平移更新函数
        window.zoomPpiImage = function(step) {
            ppiZoom += step;
            if(ppiZoom < 0.3) ppiZoom = 0.3; // 最小缩放比例
            if(ppiZoom > 5) ppiZoom = 5;     // 最大缩放比例
            updatePpiTransform();
        };

        window.resetPpiZoom = function() {
            ppiZoom = 1;
            ppiTranslateX = 0;
            ppiTranslateY = 0;
            updatePpiTransform();
        };

        function updatePpiTransform() {
            $('#ppi-network-img').css('transform', `translate(${ppiTranslateX}px, ${ppiTranslateY}px) scale(${ppiZoom})`);
        }

        // ★ 绑定滚轮缩放事件
        $(document).on('wheel', '#ppi-img-container', function(e) {
            e.preventDefault();
            if (e.originalEvent.deltaY < 0) {
                zoomPpiImage(0.1);
            } else {
                zoomPpiImage(-0.1);
            }
        });

        // ★ 绑定鼠标拖拽平移事件
        $(document).on('mousedown', '#ppi-img-container', function(e) {
            ppiIsDragging = true;
            ppiStartX = e.clientX - ppiTranslateX;
            ppiStartY = e.clientY - ppiTranslateY;
            $(this).css('cursor', 'grabbing');
        });

        $(document).on('mousemove', '#ppi-img-container', function(e) {
            if (!ppiIsDragging) return;
            ppiTranslateX = e.clientX - ppiStartX;
            ppiTranslateY = e.clientY - ppiStartY;
            updatePpiTransform();
        });

        $(document).on('mouseup mouseleave', '#ppi-img-container', function() {
            ppiIsDragging = false;
            $(this).css('cursor', 'grab');
        });

        function renderExternalButton(label, val, urlPrefix) {
            if (!isValid(val)) return '';
            let ids = String(val).split(',').map(id => id.trim());
            let html = '';
            ids.forEach(id => {
                let finalUrl = id.includes('http') ? id : urlPrefix + encodeURIComponent(id);
                html += `
        <a href="${finalUrl}" target="_blank" class="external-db-btn">
            <span class="db-label">${label}</span>
            <span class="db-id">${id.includes('http') ? 'Link' : id}</span>
        </a>`;
            });
            return html;
        }

        $(document).ready(function () {
            let id = getQueryParam("id");
            if (!id) {
                alert("No ID provided!");
                return;
            }
            $(".page-title .highlight").text(id);

            $.ajax({
                url: "./api/get_biomarker.php",
                type: "POST",
                data: { id: id },
                dataType: "json",
                success: function (data) {
                    if (!data || data.error) {
                        alert("No record found");
                        return;
                    }

                    globalMarkerData = data;

                    // --- 评分逻辑 ---
                    let score = 1;
                    if (isValid(data.Pubmed_id)) score++;
                    if (isValid(data.participants_quantity)) {
                        let pqMatch = String(data.participants_quantity).match(/\d+/);
                        if ((pqMatch && parseInt(pqMatch[0]) >= 30) || isValid(data.study_cohort)) score++;
                    }
                    if (isValid(data.Clinical_value) && (isValid(data.Stage) || isValid(data.Treatment))) score++;
                    if (isValid(data.experiment) && isValid(data.Statictics)) score++;

                    let starsHtml = '';
                    for(let i=1; i<=5; i++) {
                        starsHtml += i <= score ? '<span style="color:#f1c40f;">★</span>' : '<span style="color:#7f8c8d;">☆</span>';
                    }
                    let badgeHtml = `
                    <span>Evidence Level: </span>${starsHtml}
                    <span class="tooltip-text">
                        <b>Scoring Criteria:</b>
                        <ul>
                            <li>★ Database Included</li>
                            <li>★ Peer-reviewed (PubMed)</li>
                            <li>★ Cohort size &ge; 30</li>
                            <li>★ Clinical value & stage proof</li>
                            <li>★ Experimental & stat validation</li>
                        </ul>
                    </span>
                `;
                    $("#val-evidence-score").html(badgeHtml);

                    // --- 填入文字数据 ---
                    let count = data.related_count ? parseInt(data.related_count) : 1;
                    let bidsString = data.related_bids ? data.related_bids : data.biomarker_ID;
                    let safeBidsString = String(bidsString).replace(/'/g, "\\'");

                    $("#val-markerdb_id").text(data.biomarker_ID);

                    let biomarkerIdHtml = "";
                    if (count <= 1) {
                        biomarkerIdHtml = `<span style="margin-right: 5px;">Single Biomarker:</span><span style="font-weight: 600;">${data.ID}</span>`;
                    } else {
                        biomarkerIdHtml = `<span style="margin-right: 5px;">Combination Biomarker:</span><span style="font-weight: 600;">${data.ID}</span><span>, this <span style="font-weight: 600;">${data.ID}</span> combination consists of <button class="btn btn-sm btn-info" title="Click to view all biomarkers in this combination" style="padding: 1px 7px; font-size: 11px; font-weight: bold; cursor: pointer; border-radius: 12px; border: none; background-color: #17a2b8; color: white; vertical-align: middle; margin: 0 4px;" onclick="window.showRelatedSerials(event, '${safeBidsString}')">${count}</button> biomarkers (click the number to view).</span>`;
                    }

                    $("#val-id").html(biomarkerIdHtml);
                    $("#val-category").text(data.Category);
                    $("#val-features").html(data.features);
                    $("#val-sequence_change").text(data.Sequence_change);
                    $("#val-source").text(data.Source);
                    $("#val-disease").text(data.Disease);
                    $("#val-treatment").text(data.Treatment);
                    $("#val-stage").text(data.Stage);
                    $("#val-description").text(data.Discription);
                    $("#val-clinical_value").text(data.Clinical_value);
                    $("#val-genomic_sequence").text(data.Genomic_sequence);
                    $("#val-statistics").text(data.Statictics);
                    $("#val-participants").text(data.participants_quantity);
                    $("#val-study_cohort").text(data.study_cohort);
                    $("#val-gender").text(data.Gender);
                    $("#val-mean_age").text(data.Mean_age);
                    $("#val-experiment").text(data.experiment);
                    $("#val-conclusion").text(data.Conclution);
                    $("#val-country").text(data.Country);
                    $("#val-year").text(data.Date);
                    $("#val-remark").text(data.Remark);
                    $("#val-variation_Type").text(data.Variation_Type);
                    $("#val-validation_Level").text(data.Validation_Level);
                    if (isValid(data.Cytoband) && data.Cytoband !== 'NA') {
                        // 构建 UCSC 跳转链接 (基于 hg38 参考基因组)
                        let ucscUrl = `https://genome.ucsc.edu/cgi-bin/hgTracks?db=hg38&position=${encodeURIComponent(data.Cytoband)}`;

                        // 使用与 PubMed、GeneCards 完全相同的按钮 DOM 结构
                        let cytobandHtml = `
        <div style="display: flex; gap: 10px; flex-wrap: wrap;">
            <a href="${ucscUrl}" target="_blank" class="external-db-btn">
                <span class="db-label">UCSC</span>
                <span class="db-id">${data.Cytoband}</span>
            </a>
        </div>
    `;

                        $("#val-cytoband").html(cytobandHtml);
                    } else {
                        $("#val-cytoband").text(data.Cytoband);
                    }
                    let pubmedBtnHtml = renderExternalButton("PubMed", data.Pubmed_id, "https://pubmed.ncbi.nlm.nih.gov/");
                    $("#val-pubmed").html(`<div style="display: flex; gap: 10px; flex-wrap: wrap;">${pubmedBtnHtml}</div>`);

                    let buttonsHtml = "";
                    buttonsHtml += renderExternalButton("GeneCards", data.Gene_Card, "https://www.genecards.org/cgi-bin/carddisp.pl?gene=");
                    buttonsHtml += renderExternalButton("OncoKB", data.Oncokb, "https://www.oncokb.org/gene/");
                    buttonsHtml += renderExternalButton("PDB", data.PDB, "https://www.rcsb.org/structure/");
                    buttonsHtml += renderExternalButton("UniProt", data.Uniport, "https://www.uniprot.org/uniprotkb/");
                    buttonsHtml += renderExternalButton("Ensembl", data.ensembl_link, "https://www.ensembl.org/id/");
                    buttonsHtml += renderExternalButton("GO", data.GO, "https://www.ebi.ac.uk/QuickGO/term/");
                    buttonsHtml += renderExternalButton("Noncode", data.Noncode, "http://www.noncode.org/show_gene.php?id=");
                    $("#features-links").html(buttonsHtml);

                    // --- ★ 亮点：STRING 极速缩放拖拽面板与高清下载 ---
                    if (isValid(data.String)) {
                        let stringIds = String(data.String).split(',').map(id => encodeURIComponent(id.trim())).join('%0d');

                        //  核心修复：三个链接全部加上了 &add_nodes=10 ，并修复了官方跳转链接

                        // 下载用的 1500px 高分辨率极清版本
                        let downloadImageUrl = `https://string-db.org/api/highres_image/network?identifiers=${stringIds}&species=9606&resolution=1500&add_nodes=10`;
                        // 页面显示的轻量级版本
                        let stringImageUrl = `https://string-db.org/api/highres_image/network?identifiers=${stringIds}&species=9606&add_nodes=10`;
                        // 官方交互页面
                        let stringInteractiveUrl = `https://string-db.org/network?identifiers=${stringIds}&species=9606&add_nodes=10`;

                        let networkHtml = `
            <!-- 左上角缩放控制按钮 -->
            <div style="position: absolute; top: 15px; left: 15px; display: flex; gap: 8px; z-index: 10;">
                <button class="zoom-btn" onclick="zoomPpiImage(0.2)" title="Zoom In">➕</button>
                <button class="zoom-btn" onclick="zoomPpiImage(-0.2)" title="Zoom Out">➖</button>
                <button class="zoom-btn" onclick="resetPpiZoom()" title="Reset Zoom">↺</button>
            </div>

            <!-- 右上角高清下载按钮 -->
            <button class="download-img-btn" onclick="downloadStringImage('${downloadImageUrl}', 'PPI_Network_${data.biomarker_ID}.png')">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16"><path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/><path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"/></svg>
                Download Image
            </button>

            <!-- 图片交互容器 -->
            <div id="ppi-img-container" style="width: 100%; height: 400px; overflow: hidden; background: #fafafa; border-radius: 8px; margin-top: 5px; position: relative; cursor: grab;">

                <!-- 预埋的错误提示框（默认隐藏 display:none） -->
                <div id="string-error-msg" style="display: none; justify-content: center; align-items: center; height: 100%; padding: 20px; text-align: center; color: #e74c3c; font-weight: 500; background: #fff3f3; flex-direction: column;">
                    <span style="font-size: 24px; margin-bottom: 10px;">️</span>
                    <span>STRING database could not generate a network for this identifier directly.</span>
                    <span style="font-size: 13px; color: #7f8c8d; margin-top: 5px;">Please use the interactive link below to search it manually.</span>
                </div>

                <!-- 核心修复：onerror 触发时隐藏自己，显示错误提示框 -->
                <img id="ppi-network-img" src="${stringImageUrl}"
                     onerror="this.style.display='none'; document.getElementById('string-error-msg').style.display='flex';"
                     style="width: 100%; height: 100%; object-fit: contain; transform-origin: center center; transition: transform 0.1s ease-out; pointer-events: none;" alt="PPI Network">
            </div>

            <!-- 底部官方交互页面安全链接 -->
            <a href="${stringInteractiveUrl}" target="_blank" title="Click to view interactive network on STRING database" style="display: block; text-decoration: none; margin-top: 15px;">
                <div style="font-size: 13px; color: #7f8c8d; font-weight: 500; display: inline-block; background: #f0f7ff; padding: 6px 12px; border-radius: 20px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-link-45deg" viewBox="0 0 16 16" style="vertical-align: text-bottom; margin-right: 4px;"><path d="M4.715 6.542 3.343 7.914a3 3 0 1 0 4.243 4.243l1.828-1.829A3 3 0 0 0 8.586 5.5L8 6.086a1.002 1.002 0 0 0-.154.199 2 2 0 0 1 .861 3.337L6.88 11.45a2 2 0 1 1-2.83-2.83l.793-.792a4.018 4.018 0 0 1-.128-1.287z"/><path d="M6.586 4.672A3 3 0 0 0 7.414 9.5l.775-.776a2 2 0 0 1-.896-3.346L9.12 3.55a2 2 0 1 1 2.83 2.83l-.793.792c.112.42.155.855.128 1.287l1.372-1.372a3 3 0 1 0-4.243-4.243z"/></svg>
                    Data provided by STRING database. Click here to view the fully interactive network.
                </div>
            </a>`;
                        $("#val-string-network").html(networkHtml);
                        $("#row-string-network").show();
                    }
                }
            });
        });

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
                    linksHtml += `<a href="detail_browse.php?id=${encodeURIComponent(cleanId)}" target="_blank" style="display: inline-block; padding: 4px 10px; margin: 0 6px 8px 0; background-color: #f0f7ff; border: 1px solid #cce5ff; border-radius: 14px; color: #0056b3; text-decoration: none; font-size: 12px; font-weight: 500; transition: all 0.2s;">${cleanId}</a>`;
                }
            });
            if (linksHtml === '') linksHtml = '<div style="color:#999; font-size: 12px; padding: 10px 0;">No related data</div>';
            let popover = $(`<div class="custom-related-popover" style="position: absolute; background: #fff; border: 1px solid #eaeaea; padding: 14px 16px 6px 16px; border-radius: 8px; box-shadow: 0 10px 25px rgba(0,0,0,0.15); z-index: 9999; width: 320px; display: none;"><div style="font-size: 13px; font-weight: bold; color: #333; margin-bottom: 12px; border-bottom: 1px solid #eee; padding-bottom: 8px; display: flex; justify-content: space-between; align-items: center;"><span>Related Serials <span style="color:#17a2b8;">(${validCount})</span></span><span style="color: #999; cursor: pointer; font-size: 18px; line-height: 1;" onclick="$('.custom-related-popover').remove();">&times;</span></div><div style="max-height: 200px; overflow-y: auto; padding-right: 4px;">${linksHtml}</div></div>`);
            let btn = $(event.target);
            let offset = btn.offset();
            $('body').append(popover);
            popover.css({top: offset.top + btn.outerHeight() + 8 + 'px', left: offset.left + 'px'}).fadeIn(200);
            popover.on('click', function(e) { e.stopPropagation(); });
            popover.find('a').hover(
                function() { $(this).css({ 'background-color': '#cce5ff', 'text-decoration': 'none' }); },
                function() { $(this).css({ 'background-color': '#f0f7ff' }); }
            );
        };

        $(document).on('click', function() {
            $('.custom-related-popover').fadeOut(150, function() { $(this).remove(); });
        });
    </script>

<?php include "./Template/footer.php"; ?>