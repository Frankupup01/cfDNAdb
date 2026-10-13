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
    /* 疾病筛选器标题栏布局 */
    .filter-title-disease {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    /* 展开/收起按钮样式 */
    .btn-toggle-disease {
        background: none;
        border: none;
        color: #0d6efd; /* 蓝色链接色 */
        font-size: 0.85em;
        cursor: pointer;
        text-decoration: none;
    }
    .btn-toggle-disease:hover {
        text-decoration: underline;
    }

    /* 修改容器，预留出底部按钮的空间 */
    .disease-filter-container {
        position: relative;
        height: 40px;
        background-color: #fff;
    }

    /* 选项区域默认样式：限制高度，隐藏超出的部分 */
    .disease-options-wrapper {
        max-height: 40px;
        overflow: hidden;
        transition: box-shadow 0.2s, max-height 0.3s ease; /* 添加平滑动画 */
        background-color: #fff;
        padding-top: 5px;
        position: relative;
    }

    /* 按钮的父级，定位在右下角 */
    .disease-toggle-footer {
        position: absolute;
        bottom: -5px;
        right: 0;
        background: #fff; /* 白底，盖住后面的文字和边线 */
        padding-left: 15px;
        padding-bottom: 2px;
    }

    .btn-toggle-disease {
        background: none;
        border: none;
        color: #0d6efd;
        font-size: 0.85em;
        cursor: pointer;
        text-decoration: none;
        padding: 0 5px;
    }

    .btn-toggle-disease:hover {
        text-decoration: underline;
    }

    /* --- 浮窗状态样式 --- */
    .disease-options-wrapper.is-floating {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        max-height: 350px; /* 浮窗展开最大高度 */
        overflow-y: auto;
        z-index: 1000;
        border: 1px solid #ccc;
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        border-radius: 6px;
        padding: 35px 15px 15px 15px; /* 顶部留出空间放关闭按钮 */
        background-color: #fff;
    }

    /* 缩小状态（临时缩起） */
    .disease-options-wrapper.is-minimized {
        max-height: 45px !important;
        overflow: hidden !important;
        padding-top: 10px !important;
    }

    /* ★ 新增：浮窗右上角的控制按钮组 */
    .floating-controls {
        display: none;
        position: absolute;
        top: 5px;
        right: 10px;
        z-index: 1001;
    }

    .disease-options-wrapper.is-floating .floating-controls {
        display: flex;
        gap: 8px;
        align-items: center;
    }

    .floating-btn {
        background: none;
        border: none;
        cursor: pointer;
        color: #6c757d;
        border-radius: 4px;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 24px;
        height: 24px;
        transition: all 0.2s;
    }

    .floating-btn:hover {
        background-color: #e9ecef;
        color: #212529;
    }

    .floating-btn.btn-close:hover {
        background-color: #fee2e2;
        color: #dc2626;
    }

    /* --- 隐形遮罩层 --- */
    .disease-overlay {
        display: none;
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        z-index: 999; /* 低于浮窗(1000)，高于页面其他元素 */
    }

    .disease-overlay.is-active {
        display: block;
    }
</style>

<body>

<div class="container">
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
            <div class="filter-title">2. Filter by category:</div>
            <div class="filter-options">
                <div class="filter-option">
                    <input type="checkbox" id="type-cfDNA" name="marker-category" value="cfDNA">
                    <label for="type-cfDNA">Linear cfDNA</label>
                </div>
                <div class="filter-option">
                    <input type="checkbox" id="type-ctDNA" name="marker-category" value="ctDNA">
                    <label for="type-ctDNA">ctDNA</label>
                </div>
                <div class="filter-option">
                    <input type="checkbox" id="type-eccDNA" name="marker-category" value="eccDNA">
                    <label for="type-eccDNA">eccDNA</label>
                </div>
                <div class="filter-option">
                    <input type="checkbox" id="type-ecDNA" name="marker-category" value="ecDNA">
                    <label for="type-ecDNA">ecDNA</label>
                </div>
            </div>
        </div>

        <div class="filter-section">
            <div class="filter-title">3. Filter by marker clinical value:</div>
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
                    <input type="checkbox" id="status-Monitoring" name="marker-status" value="Monitoring">
                    <label for="status-Monitoring">Monitoring</label>
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
        <div class="filter-section">
            <div class="filter-title filter-title-disease">
                <span>4. Filter by cancer entity/subtype:</span>
            </div>

            <div class="disease-filter-container">
                <div class="filter-options disease-options-wrapper" id="diseaseOptionsWrapper">

                    <div class="floating-controls">
                        <button type="button" class="floating-btn btn-minimize" onclick="toggleMinimizeFloating(event)" title="Minimize/Expand">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h13a.5.5 0 0 1 0 1h-13A.5.5 0 0 1 1 8zm7-8a.5.5 0 0 1 .5.5v13a.5.5 0 0 1-1 0v-13A.5.5 0 0 1 8 0z"/>
                            </svg>
                        </button>
                        <button type="button" class="floating-btn btn-close" onclick="closeDiseaseFloating(event)" title="Close">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                            </svg>
                        </button>
                    </div>

                    <div class="filter-option">
                        <input type="checkbox" id="type-Adenocarcinoma" name="disease" value="Adenocarcinoma">
                        <label for="type-Adenocarcinoma">Adenocarcinoma</label>
                    </div>
                    <div class="filter-option">
                        <input type="checkbox" id="type-Adrenocortical cancer" name="disease" value="Adrenocortical cancer">
                        <label for="type-Adrenocortical cancer">Adrenocortical cancer</label>
                    </div>
                    <div class="filter-option">
                        <input type="checkbox" id="type-Advanced urothelial cancer" name="disease" value="Advanced urothelial cancer">
                        <label for="type-Advanced urothelial cancer">Advanced urothelial cancer</label>
                    </div>
                    <div class="filter-option">
                        <input type="checkbox" id="type-Alk-rearranged lung cancer" name="disease" value="Alk-rearranged lung cancer">
                        <label for="type-Alk-rearranged lung cancer">Alk-rearranged lung cancer</label>
                    </div>
                    <div class="filter-option">
                        <input type="checkbox" id="type-Ampullary cancer" name="disease" value="Ampullary cancer">
                        <label for="type-Ampullary cancer">Ampullary cancer</label>
                    </div>
                    <div class="filter-option">
                        <input type="checkbox" id="type-Anal squamous cell cancer" name="disease" value="Anal squamous cell cancer">
                        <label for="type-Anal squamous cell cancer">Anal squamous cell cancer</label>
                    </div>
                    <div class="filter-option">
                        <input type="checkbox" id="type-Anaplastic thyroid cancer" name="disease" value="Anaplastic thyroid cancer">
                        <label for="type-Anaplastic thyroid cancer">Anaplastic thyroid cancer</label>
                    </div>
                    <div class="filter-option">
                        <input type="checkbox" id="type-Appendiceal cancer" name="disease" value="Appendiceal cancer">
                        <label for="type-Appendiceal cancer">Appendiceal cancer</label>
                    </div>
                    <div class="filter-option">
                        <input type="checkbox" id="type-B rapidly accelerated fibrosarcoma" name="disease" value="B rapidly accelerated fibrosarcoma">
                        <label for="type-B rapidly accelerated fibrosarcoma">B rapidly accelerated fibrosarcoma</label>
                    </div>
                    <div class="filter-option">
                        <input type="checkbox" id="type-B virus-related hepatocellular carcinoma" name="disease" value="B virus-related hepatocellular carcinoma">
                        <label for="type-B virus-related hepatocellular carcinoma">B virus-related hepatocellular carcinoma</label>
                    </div>
                    <div class="filter-option">
                        <input type="checkbox" id="type-Barrett’s oesophagus, be" name="disease" value="Barrett’s oesophagus, be">
                        <label for="type-Barrett’s oesophagus, be">Barrett’s oesophagus, be</label>
                    </div>
                    <div class="filter-option">
                        <input type="checkbox" id="type-Biliary tract cancer" name="disease" value="Biliary tract cancer">
                        <label for="type-Biliary tract cancer">Biliary tract cancer</label>
                    </div>
                    <div class="filter-option">
                        <input type="checkbox" id="type-Biliopancreatic cancer" name="disease" value="Biliopancreatic cancer">
                        <label for="type-Biliopancreatic cancer">Biliopancreatic cancer</label>
                    </div>
                    <div class="filter-option">
                        <input type="checkbox" id="type-Bladder cancer" name="disease" value="Bladder cancer">
                        <label for="type-Bladder cancer">Bladder cancer</label>
                    </div>
                    <div class="filter-option">
                        <input type="checkbox" id="type-Bone sarcoma&soft-tissue sarcoma" name="disease" value="Bone sarcoma&soft-tissue sarcoma">
                        <label for="type-Bone sarcoma&soft-tissue sarcoma">Bone sarcoma&soft-tissue sarcoma</label>
                    </div>
                    <div class="filter-option">
                        <input type="checkbox" id="type-Brain cancer" name="disease" value="Brain cancer">
                        <label for="type-Brain cancer">Brain cancer</label>
                    </div>
                    <div class="filter-option">
                        <input type="checkbox" id="type-Breast cancer" name="disease" value="Breast cancer">
                        <label for="type-Breast cancer">Breast cancer</label>
                    </div>
                    <div class="filter-option">
                        <input type="checkbox" id="type-Castration-resistant prostate cancer" name="disease" value="Castration-resistant prostate cancer">
                        <label for="type-Castration-resistant prostate cancer">Castration-resistant prostate cancer</label>
                    </div>
                    <div class="filter-option">
                        <input type="checkbox" id="type-Cervical cancer" name="disease" value="Cervical cancer">
                        <label for="type-Cervical cancer">Cervical cancer</label>
                    </div>
                    <div class="filter-option">
                        <input type="checkbox" id="type-Childhood solid tumors" name="disease" value="Childhood solid tumors">
                        <label for="type-Childhood solid tumors">Childhood solid tumors</label>
                    </div>
                    <div class="filter-option">
                        <input type="checkbox" id="type-Cholangiocarcinoma" name="disease" value="Cholangiocarcinoma">
                        <label for="type-Cholangiocarcinoma">Cholangiocarcinoma</label>
                    </div>
                    <div class="filter-option">
                        <input type="checkbox" id="type-Chordoma" name="disease" value="Chordoma">
                        <label for="type-Chordoma">Chordoma</label>
                    </div>
                    <div class="filter-option">
                        <input type="checkbox" id="type-Clear cell renal cell carcinoma" name="disease" value="Clear cell renal cell carcinoma">
                        <label for="type-Clear cell renal cell carcinoma">Clear cell renal cell carcinoma</label>
                    </div>
                    <div class="filter-option">
                        <input type="checkbox" id="type-Cns lymphomas" name="disease" value="Cns lymphomas">
                        <label for="type-Cns lymphomas">Cns lymphomas</label>
                    </div>
                    <div class="filter-option">
                        <input type="checkbox" id="type-Colon cancer" name="disease" value="Colon cancer">
                        <label for="type-Colon cancer">Colon cancer</label>
                    </div>
                    <div class="filter-option">
                        <input type="checkbox" id="type-Colorectal cancer" name="disease" value="Colorectal cancer">
                        <label for="type-Colorectal cancer">Colorectal cancer</label>
                    </div>
                    <div class="filter-option">
                        <input type="checkbox" id="type-Colorectal liver metastasis" name="disease" value="Colorectal liver metastasis">
                        <label for="type-Colorectal liver metastasis">Colorectal liver metastasis</label>
                    </div>
                    <div class="filter-option">
                        <input type="checkbox" id="type-Cutaneous melanoma" name="disease" value="Cutaneous melanoma">
                        <label for="type-Cutaneous melanoma">Cutaneous melanoma</label>
                    </div>
                    <div class="filter-option">
                        <input type="checkbox" id="type-Hepatocellular carcinoma" name="disease" value="Hepatocellular carcinoma">
                        <label for="type-Hepatocellular carcinoma">Hepatocellular carcinoma</label>
                    </div>
                    <div class="filter-option">
                        <input type="checkbox" id="type-Desmoid fibromatosis" name="disease" value="Desmoid fibromatosis">
                        <label for="type-Desmoid fibromatosis">Desmoid fibromatosis</label>
                    </div>
                    <div class="filter-option">
                        <input type="checkbox" id="type-Diffuse large b cell lymphoma" name="disease" value="Diffuse large b cell lymphoma">
                        <label for="type-Diffuse large b cell lymphoma">Diffuse large b cell lymphoma</label>
                    </div>
                    <div class="filter-option">
                        <input type="checkbox" id="type-Distal common bile duct cancer" name="disease" value="Distal common bile duct cancer">
                        <label for="type-Distal common bile duct cancer">Distal common bile duct cancer</label>
                    </div>
                    <div class="filter-option">
                        <input type="checkbox" id="type-Endometrial cancer" name="disease" value="Endometrial cancer">
                        <label for="type-Endometrial cancer">Endometrial cancer</label>
                    </div>
                    <div class="filter-option">
                        <input type="checkbox" id="type-Epithelial ovarian cancer" name="disease" value="Epithelial ovarian cancer">
                        <label for="type-Epithelial ovarian cancer">Epithelial ovarian cancer</label>
                    </div>
                    <div class="filter-option">
                        <input type="checkbox" id="type-Esophageal squamous cell carcinoma" name="disease" value="Esophageal squamous cell carcinoma">
                        <label for="type-Esophageal squamous cell carcinoma">Esophageal squamous cell carcinoma</label>
                    </div>
                    <div class="filter-option">
                        <input type="checkbox" id="type-Extranodal natural killer/t cell lymphoma" name="disease" value="Extranodal natural killer/t cell lymphoma">
                        <label for="type-Extranodal natural killer/t cell lymphoma">Extranodal natural killer/t cell lymphoma</label>
                    </div>
                    <div class="filter-option">
                        <input type="checkbox" id="type-Follicular lymphoma" name="disease" value="Follicular lymphoma">
                        <label for="type-Follicular lymphoma">Follicular lymphoma</label>
                    </div>
                    <div class="filter-option">
                        <input type="checkbox" id="type-Gall bladder carcinoma" name="disease" value="Gall bladder carcinoma">
                        <label for="type-Gall bladder carcinoma">Gall bladder carcinoma</label>
                    </div>
                    <div class="filter-option">
                        <input type="checkbox" id="type-Gastric cancer" name="disease" value="Gastric cancer">
                        <label for="type-Gastric cancer">Gastric cancer</label>
                    </div>
                    <div class="filter-option">
                        <input type="checkbox" id="type-Gastroenteropancreatic neuroendocrine carcinomas" name="disease" value="Gastroenteropancreatic neuroendocrine carcinomas">
                        <label for="type-Gastroenteropancreatic neuroendocrine carcinomas">Gastroenteropancreatic neuroendocrine carcinomas</label>
                    </div>
                    <div class="filter-option">
                        <input type="checkbox" id="type-Gastroesophageal adenocarcinoma" name="disease" value="Gastroesophageal adenocarcinoma">
                        <label for="type-Gastroesophageal adenocarcinoma">Gastroesophageal adenocarcinoma</label>
                    </div>
                    <div class="filter-option">
                        <input type="checkbox" id="type-Gastrointestinal cancer" name="disease" value="Gastrointestinal cancer">
                        <label for="type-Gastrointestinal cancer">Gastrointestinal cancer</label>
                    </div>
                    <div class="filter-option">
                        <input type="checkbox" id="type-Gastrointestinal stromal tumors" name="disease" value="Gastrointestinal stromal tumors">
                        <label for="type-Gastrointestinal stromal tumors">Gastrointestinal stromal tumors</label>
                    </div>
                    <div class="filter-option">
                        <input type="checkbox" id="type-Glioblastoma" name="disease" value="Glioblastoma">
                        <label for="type-Glioblastoma">Glioblastoma</label>
                    </div>
                    <div class="filter-option">
                        <input type="checkbox" id="type-Head and neck cancer" name="disease" value="Head and neck cancer">
                        <label for="type-Head and neck cancer">Head and neck cancer</label>
                    </div>
                    <div class="filter-option">
                        <input type="checkbox" id="type-Head and neck squamous cell carcinoma" name="disease" value="Head and neck squamous cell carcinoma">
                        <label for="type-Head and neck squamous cell carcinoma">Head and neck squamous cell carcinoma</label>
                    </div>
                    <div class="filter-option">
                        <input type="checkbox" id="type-Hepatobiliary cancer" name="disease" value="Hepatobiliary cancer">
                        <label for="type-Hepatobiliary cancer">Hepatobiliary cancer</label>
                    </div>
                    <div class="filter-option">
                        <input type="checkbox" id="type-High grade serous ovarian carcinoma" name="disease" value="High grade serous ovarian carcinoma">
                        <label for="type-High grade serous ovarian carcinoma">High grade serous ovarian carcinoma</label>
                    </div>
                    <div class="filter-option">
                        <input type="checkbox" id="type-High risk serrated lesions and serrated adenocarcinoma" name="disease" value="High risk serrated lesions and serrated adenocarcinoma">
                        <label for="type-High risk serrated lesions and serrated adenocarcinoma">High risk serrated lesions and serrated adenocarcinoma</label>
                    </div>
                    <div class="filter-option">
                        <input type="checkbox" id="type-Hpv oropharyngeal squamous cell carcinoma" name="disease" value="Hpv oropharyngeal squamous cell carcinoma">
                        <label for="type-Hpv oropharyngeal squamous cell carcinoma">Hpv oropharynge squamous cell carcinoma</label>
                    </div>
                    <div class="filter-option">
                        <input type="checkbox" id="type-Intraductal papillary mucinous neoplasm" name="disease" value="Intraductal papillary mucinous neoplasm">
                        <label for="type-Intraductal papillary mucinous neoplasm">Intraductal papillary mucinous neoplasm</label>
                    </div>
                    <div class="filter-option">
                        <input type="checkbox" id="type-Large b-cell lymphoma" name="disease" value="Large b-cell lymphoma">
                        <label for="type-Large b-cell lymphoma">Large b-cell lymphoma</label>
                    </div>
                    <div class="filter-option">
                        <input type="checkbox" id="type-Laryngeal squamous cell carcinoma" name="disease" value="Laryngeal squamous cell carcinoma">
                        <label for="type-Laryngeal squamous cell carcinoma">Laryngeal squamous cell carcinoma</label>
                    </div>
                    <div class="filter-option">
                        <input type="checkbox" id="type-Leptomeningeal metastases" name="disease" value="Leptomeningeal metastases">
                        <label for="type-Leptomeningeal metastases">Leptomeningeal metastases</label>
                    </div>
                    <div class="filter-option">
                        <input type="checkbox" id="type-Liver cancer" name="disease" value="Liver cancer">
                        <label for="type-Liver cancer">Liver cancer</label>
                    </div>
                    <div class="filter-option">
                        <input type="checkbox" id="type-Locally advanced rectal cancer" name="disease" value="Locally advanced rectal cancer">
                        <label for="type-Locally advanced rectal cancer">Locally advanced rectal cancer</label>
                    </div>
                    <div class="filter-option">
                        <input type="checkbox" id="type-Lung adenocarcinoma" name="disease" value="Lung adenocarcinoma">
                        <label for="type-Lung adenocarcinoma">Lung adenocarcinoma</label>
                    </div>
                    <div class="filter-option">
                        <input type="checkbox" id="type-Lung cancer" name="disease" value="Lung cancer">
                        <label for="type-Lung cancer">Lung cancer</label>
                    </div>
                    <div class="filter-option">
                        <input type="checkbox" id="type-Malignant peripheral nerve sheath tumor" name="disease" value="Malignant peripheral nerve sheath tumor">
                        <label for="type-Malignant peripheral nerve sheath tumor">Malignant peripheral nerve sheath tumor</label>
                    </div>
                    <div class="filter-option">
                        <input type="checkbox" id="type-Mantle cell lymphoma" name="disease" value="Mantle cell lymphoma">
                        <label for="type-Mantle cell lymphoma">Mantle cell lymphoma</label>
                    </div>
                    <div class="filter-option">
                        <input type="checkbox" id="type-Medullary thyroid carcinoma" name="disease" value="Medullary thyroid carcinoma">
                        <label for="type-Medullary thyroid carcinoma">Medullary thyroid carcinoma</label>
                    </div>
                    <div class="filter-option">
                        <input type="checkbox" id="type-Melanoma" name="disease" value="Melanoma">
                        <label for="type-Melanoma">Melanoma</label>
                    </div>
                    <div class="filter-option">
                        <input type="checkbox" id="type-Metastatic brain tumor" name="disease" value="Metastatic brain tumor">
                        <label for="type-Metastatic brain tumor">Metastatic brain tumor</label>
                    </div>
                    <div class="filter-option">
                        <input type="checkbox" id="type-Metastatic castration resistance prostate cancer" name="disease" value="Metastatic castration resistance prostate cancer">
                        <label for="type-Metastatic castration resistance prostate cancer">Metastatic castration resistance prostate cancer</label>
                    </div>
                    <div class="filter-option">
                        <input type="checkbox" id="type-Metastatic colorectal cancer" name="disease" value="Metastatic colorectal cancer">
                        <label for="type-Metastatic colorectal cancer">Metastatic colorectal cancer</label>
                    </div>
                    <div class="filter-option">
                        <input type="checkbox" id="type-Metastatic melanoma" name="disease" value="Metastatic melanoma">
                        <label for="type-Metastatic melanoma">Metastatic melanoma</label>
                    </div>
                    <div class="filter-option">
                        <input type="checkbox" id="type-Metastatic prostate cancer" name="disease" value="Metastatic prostate cancer">
                        <label for="type-Metastatic prostate cancer">Metastatic prostate cancer</label>
                    </div>
                    <div class="filter-option">
                        <input type="checkbox" id="type-Metastatic uveal melanoma" name="disease" value="Metastatic uveal melanoma">
                        <label for="type-Metastatic uveal melanoma">Metastatic uveal melanoma</label>
                    </div>
                    <div class="filter-option">
                        <input type="checkbox" id="type-Monitoring muscle-invasive bladder cancer" name="disease" value="Monitoring muscle-invasive bladder cancer">
                        <label for="type-Monitoring muscle-invasive bladder cancer">Monitoring muscle-invasive bladder cancer</label>
                    </div>
                    <div class="filter-option">
                        <input type="checkbox" id="type-Multiple myeloma" name="disease" value="Multiple myeloma">
                        <label for="type-Multiple myeloma">Multiple myeloma</label>
                    </div>
                    <div class="filter-option">
                        <input type="checkbox" id="type-Muscle-invasive bladder cancer" name="disease" value="Muscle-invasive bladder cancer">
                        <label for="type-Muscle-invasive bladder cancer">Muscle-invasive bladder cancer</label>
                    </div>
                    <div class="filter-option">
                        <input type="checkbox" id="type-Muti cancer" name="disease" value="Muti cancer">
                        <label for="type-Muti cancer">Muti cancer</label>
                    </div>
                    <div class="filter-option">
                        <input type="checkbox" id="type-Myelodysplastic syndromes" name="disease" value="Myelodysplastic syndromes">
                        <label for="type-Myelodysplastic syndromes">Myelodysplastic syndromes</label>
                    </div>
                    <div class="filter-option">
                        <input type="checkbox" id="type-Nasopharyngeal carcinoma" name="disease" value="Nasopharyngeal carcinoma">
                        <label for="type-Nasopharyngeal carcinoma">Nasopharyngeal carcinoma</label>
                    </div>
                    <div class="filter-option">
                        <input type="checkbox" id="type-Neck squamous cell carcinoma" name="disease" value="Neck squamous cell carcinoma">
                        <label for="type-Neck squamous cell carcinoma">Neck squamous cell carcinoma</label>
                    </div>
                    <div class="filter-option">
                        <input type="checkbox" id="type-Nephroblastomatosis" name="disease" value="Nephroblastomatosis">
                        <label for="type-Nephroblastomatosis">Nephroblastomatosis</label>
                    </div>
                    <div class="filter-option">
                        <input type="checkbox" id="type-Nervous system germ cell tumors" name="disease" value="Nervous system germ cell tumors">
                        <label for="type-Nervous system germ cell tumors">Nervous system germ cell tumors</label>
                    </div>
                    <div class="filter-option">
                        <input type="checkbox" id="type-Neuroendocrine neoplasia" name="disease" value="Neuroendocrine neoplasia">
                        <label for="type-Neuroendocrine neoplasia">Neuroendocrine neoplasia</label>
                    </div>
                    <div class="filter-option">
                        <input type="checkbox" id="type-Non-small cell lung cancer" name="disease" value="Non-small cell lung cancer">
                        <label for="type-Non-small cell lung cancer">Non-small cell lung cancer</label>
                    </div>
                    <div class="filter-option">
                        <input type="checkbox" id="type-Oesophageal squamous cell carcinoma" name="disease" value="Oesophageal squamous cell carcinoma">
                        <label for="type-Oesophageal squamous cell carcinoma">Oesophageal squamous cell carcinoma</label>
                    </div>
                    <div class="filter-option">
                        <input type="checkbox" id="type-Oral cavity squamous cell carcinoma" name="disease" value="Oral cavity squamous cell carcinoma">
                        <label for="type-Oral cavity squamous cell carcinoma">Oral cavity squamous cell carcinoma</label>
                    </div>
                    <div class="filter-option">
                        <input type="checkbox" id="type-Oropharyngeal squamous cell carcinoma" name="disease" value="Oropharyngeal squamous cell carcinoma">
                        <label for="type-Oropharyngeal squamous cell carcinoma">Oropharyngeal squamous cell carcinoma</label>
                    </div>
                    <div class="filter-option">
                        <input type="checkbox" id="type-Ovarian cancer" name="disease" value="Ovarian cancer">
                        <label for="type-Ovarian cancer">Ovarian cancer</label>
                    </div>
                    <div class="filter-option">
                        <input type="checkbox" id="type-Pan cancer" name="disease" value="Pan cancer">
                        <label for="type-Pan cancer">Pan cancer</label>
                    </div>
                    <div class="filter-option">
                        <input type="checkbox" id="type-Pancreatic adenocarcinoma" name="disease" value="Pancreatic adenocarcinoma">
                        <label for="type-Pancreatic adenocarcinoma">Pancreatic adenocarcinoma</label>
                    </div>
                    <div class="filter-option">
                        <input type="checkbox" id="type-Papillary thyroid carcinoma" name="disease" value="Papillary thyroid carcinoma">
                        <label for="type-Papillary thyroid carcinoma">Papillary thyroid carcinoma</label>
                    </div>
                    <div class="filter-option">
                        <input type="checkbox" id="type-Precancerous colorectal" name="disease" value="Precancerous colorectal">
                        <label for="type-Precancerous colorectal">Precancerous colorectal</label>
                    </div>
                    <div class="filter-option">
                        <input type="checkbox" id="type-Prostate cancer" name="disease" value="Prostate cancer">
                        <label for="type-Prostate cancer">Prostate cancer</label>
                    </div>
                    <div class="filter-option">
                        <input type="checkbox" id="type-Pten hamartoma tumor syndrome" name="disease" value="Pten hamartoma tumor syndrome">
                        <label for="type-Pten hamartoma tumor syndrome">Pten hamartoma tumor syndrome</label>
                    </div>
                    <div class="filter-option">
                        <input type="checkbox" id="type-Rectal cancer" name="disease" value="Rectal cancer">
                        <label for="type-Rectal cancer">Rectal cancer</label>
                    </div>
                    <div class="filter-option">
                        <input type="checkbox" id="type-Renal cell carcinoma" name="disease" value="Renal cell carcinoma">
                        <label for="type-Renal cell carcinoma">Renal cell carcinoma</label>
                    </div>
                    <div class="filter-option">
                        <input type="checkbox" id="type-Renal cancer" name="disease" value="Renal cancer">
                        <label for="type-Renal cancer">Renal cancer</label>
                    </div>
                    <div class="filter-option">
                        <input type="checkbox" id="type-Small cell lung cancer" name="disease" value="Small cell lung cancer">
                        <label for="type-Small cell lung cancer">Small cell lung cancer</label>
                    </div>
                    <div class="filter-option">
                        <input type="checkbox" id="type-Soft tissue sarcoma" name="disease" value="Soft tissue sarcoma">
                        <label for="type-Soft tissue sarcoma">Soft tissue sarcoma</label>
                    </div>
                    <div class="filter-option">
                        <input type="checkbox" id="type-Solid tumour" name="disease" value="Solid tumour">
                        <label for="type-Solid tumour">Solid tumour</label>
                    </div>
                    <div class="filter-option">
                        <input type="checkbox" id="type-Squamous cell carcinoma of the head and neck" name="disease" value="Squamous cell carcinoma of the head and neck">
                        <label for="type-Squamous cell carcinoma of the head and neck">Squamous cell carcinoma of the head and neck</label>
                    </div>
                    <div class="filter-option">
                        <input type="checkbox" id="type-Thyroid cancer" name="disease" value="Thyroid cancer">
                        <label for="type-Thyroid cancer">Thyroid cancer</label>
                    </div>
                    <div class="filter-option">
                        <input type="checkbox" id="type-Triple negative breast cancer" name="disease" value="Triple negative breast cancer">
                        <label for="type-Triple negative breast cancer">Triple negative breast cancer</label>
                    </div>
                    <div class="filter-option">
                        <input type="checkbox" id="type-Upper tract urothelial carcinoma" name="disease" value="Upper tract urothelial carcinoma">
                        <label for="type-Upper tract urothelial carcinoma">Upper tract urothelial carcinoma</label>
                    </div>
                    <div class="filter-option">
                        <input type="checkbox" id="type-Urothelial cancer" name="disease" value="Urothelial cancer">
                        <label for="type-Urothelial cancer">Urothelial cancer</label>
                    </div>
                    <div class="filter-option">
                        <input type="checkbox" id="type-Uveal melanoma" name="disease" value="Uveal melanoma">
                        <label for="type-Uveal melanoma">Uveal melanoma</label>
                    </div>
                </div>
                <div class="disease-toggle-footer">
                    <button type="button" class="btn-toggle-disease" id="toggleDiseaseBtn" onclick="toggleDiseaseFloating(event)">
                        More ▾
                    </button>
                </div>
                <div class="disease-overlay" id="diseaseOverlay" onclick="closeDiseaseFloating()"></div>
            </div>

        </div>

        <div class="filter-section">
            <div class="filter-title">5. Filter by source:</div>
            <div class="filter-options">
                <div class="filter-option">
                    <input type="checkbox" id="biofluid-Peripheral_blood" name="biofluid" value="Peripheral blood">
                    <label for="biofluid-Peripheral_blood">Peripheral blood</label>
                </div>
                <div class="filter-option">
                    <input type="checkbox" id="biofluid-Serum" name="biofluid" value="Serum">
                    <label for="biofluid-Serum">Serum</label>
                </div>
                <div class="filter-option">
                    <input type="checkbox" id="biofluid-plasma" name="biofluid" value="Plasma">
                    <label for="biofluid-plasma">Plasma</label>
                </div>
                <div class="filter-option">
                    <input type="checkbox" id="biofluid-saliva" name="biofluid" value="Saliva">
                    <label for="biofluid-saliva">Saliva</label>
                </div>
                <div class="filter-option">
                    <input type="checkbox" id="biofluid-urine" name="biofluid" value="Urine">
                    <label for="biofluid-urine">Urine</label>
                </div>
                <div class="filter-option">
                    <input type="checkbox" id="biofluid-Urine_supernatant" name="biofluid" value="Urine supernatant">
                    <label for="biofluid-Urine_supernatant">Urine supernatant</label>
                </div>
                <div class="filter-option">
                    <input type="checkbox" id="biofluid-Urine_sediments" name="biofluid" value="Urine sediments">
                    <label for="biofluid-Urine_sediments">Urine sediments</label>
                </div>
                <div class="filter-option">
                    <input type="checkbox" id="biofluid-Mid-stream_Urine" name="biofluid" value="Mid-stream Urine">
                    <label for="biofluid-Mid-stream_Urine">Mid-stream Urine</label>
                </div>
                <div class="filter-option">
                    <input type="checkbox" id="biofluid-body_fluid" name="biofluid" value="body fluid">
                    <label for="biofluid-body_fluid">Body Fluid</label>
                </div>
                <div class="filter-option">
                    <input type="checkbox" id="biofluid-Bile" name="biofluid" value="Bile">
                    <label for="biofluid-Bile">Bile</label>
                </div>
                <div class="filter-option">
                    <input type="checkbox" id="biofluid-Ascites" name="biofluid" value="Ascites">
                    <label for="biofluid-Ascites">Ascites</label>
                </div>
                <div class="filter-option">
                    <input type="checkbox" id="biofluid-Peritoneal_Fluid" name="biofluid" value="Peritoneal Fluid">
                    <label for="biofluid-Peritoneal_Fluid">Peritoneal Fluid</label>
                </div>
                <div class="filter-option">
                    <input type="checkbox" id="biofluid-cerebrospinal_fluid" name="biofluid" value="cerebrospinal fluid">
                    <label for="biofluid-cerebrospinal_fluid">Cerebrospinal fluid</label>
                </div>
                <div class="filter-option">
                    <input type="checkbox" id="biofluid-Urothelial Tumours" name="biofluid" value="Urothelial Tumours">
                    <label for="biofluid-Urothelial_Tumours">Urothelial Tumours</label>
                </div>
                <div class="filter-option">
                    <input type="checkbox" id="biofluid-Others" name="biofluid" value="Others">
                    <label for="biofluid-Others">Others</label>
                </div>

            </div>
        </div>

        <div class="filter-actions">
            <button class="btn btn-secondary" onclick="clearFilters()">Clear All</button>
            <button class="btn btn-primary" onclick="applyFilters()">Apply Filters</button>
        </div>
    </div>

    <div class="data-section">
        <div class="section-header">
            <div class="section-title">Biomarkers</div>
        </div>

        <table id="biomarkersTable"  style="width:100%">
            <thead>
            <tr>
                <th>Serial Number</th>
                <th>Category</th>
                <th>Marker Type</th>
                <th>Source</th>
                <th>Cancer entity/Subtype</th>
                <th>Clinical Value</th>
                <th>Features</th>
            </tr>
            </thead>
        </table>

        <div class="pagination" id="pagination">
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {

        // 初始化 DataTable
        let table = $('#biomarkersTable').DataTable({
            processing: true,
            serverSide: true,
            searching: true,

            // ==========================================
            // 修改：将 l(长度选项) 和 B(按钮) 放在同一个左侧列，f(搜索)放右侧
            // 使用 d-flex 让它们并排且垂直居中对齐
            // ==========================================
            dom: '<"row mb-2"<"col-md-8 d-flex align-items-center"lB><"col-md-4 text-right"f>>rtip',
            buttons: [
                {
                    extend: 'csv',
                    text: 'Download CSV',
                    // className 改为 btn-secondary (灰色)，并加了一点左边距 (ml-3) 隔开 "Show entries"
                    className: 'btn btn-secondary'
                },
                {
                    extend: 'excel',
                    text: 'Download Excel',
                    className: 'btn btn-secondary'
                }
            ],
            // ==========================================

            ajax: {
                url: "./api/search_biomarkers.php",
                type: "POST",
                data: function (d) {
                    d.types = getSelectedValues('marker-type');
                    d.status = getSelectedValues('marker-status');
                    d.biofluid = getSelectedValues('biofluid');
                    d.disease = getSelectedValues('disease');
                    d.category = getSelectedValues('marker-category');
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
                { data: "marker_type",orderable: false },
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

    function openDiseaseFloating() {
        const wrapper = document.getElementById('diseaseOptionsWrapper');
        const overlay = document.getElementById('diseaseOverlay');
        const btn = document.getElementById('toggleDiseaseBtn');

        // ★ 新增逻辑：在展开前，确保移除可能存在的临时缩小状态
        wrapper.classList.remove('is-minimized');

        wrapper.classList.add('is-floating');
        overlay.classList.add('is-active');
        btn.innerHTML = 'Close ▴';
    }

    function closeDiseaseFloating(event) {
        if(event) {
            event.stopPropagation();
        }

        const wrapper = document.getElementById('diseaseOptionsWrapper');
        const overlay = document.getElementById('diseaseOverlay');
        const btn = document.getElementById('toggleDiseaseBtn');

        if(wrapper) {
            wrapper.classList.remove('is-floating');
            wrapper.classList.remove('is-minimized'); // 关闭时彻底清除临时状态
            wrapper.scrollTop = 0;
        }
        if(overlay) overlay.classList.remove('is-active');
        if(btn) btn.innerHTML = 'More ▾';
    }

    // ★ 新增：控制浮窗临时缩小/复原的函数
    function toggleMinimizeFloating(event) {
        if(event) {
            event.stopPropagation();
        }

        const wrapper = document.getElementById('diseaseOptionsWrapper');

        if (wrapper.classList.contains('is-minimized')) {
            // 复原：移除缩小状态
            wrapper.classList.remove('is-minimized');
        } else {
            // 缩小：添加缩小状态，并让其滚动回顶部
            wrapper.classList.add('is-minimized');
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

<?php
include "./Template/footer.php";
?>

</body>
</html>