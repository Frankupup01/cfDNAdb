<?php include "./Template/base.php"; ?>
<?php include './Template/header.php'; ?>

<style>
    :root {
        --primary: #3498db;
        --success: #10b981;
        --warning: #f59e0b;
        --danger: #ef4444;
        --bg-subtle: #f8fafc;
        --border-color: #e2e8f0;
        --text-main: #1e293b;
        --text-muted: #64748b;
    }


    .db-download-container {
        /* ★ 核心修改：强制打破父级容器限制 */
        width: 90vw;
        max-width: 1300px; /* 设定的最大宽度上限 */

        /* 绝对居中法则：left 必须是 50%，配合 translateX(-50%) */
        position: relative;
        left: 50%;
        transform: translateX(-50%);

        margin-top: 40px;
        margin-bottom: 40px;
        padding: 30px;
        background: #ffffff;
        border-radius: 20px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
    }

    /* 顶部导航与搜索 */
    .db-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 30px;
        border-bottom: 1px solid var(--border-color);
        padding-bottom: 20px;
    }

    .db-title h2 { font-size: 1.75rem; color: var(--text-main); display: flex; align-items: center; gap: 12px; }

    /* 分组标题 */
    .section-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--text-main);
        margin: 30px 0 15px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .dot { width: 8px; height: 8px; border-radius: 50%; }
    .dot-prod { background: var(--danger); box-shadow: 0 0 8px var(--danger); }
    .dot-test { background: var(--success); }

    /* 下载列表容器 */
    .download-grid {
        display: grid;
        grid-template-columns: 1fr; /* ★ 强制单列，不再并排 */
        gap: 15px;
    }

    .download-card {
        display: flex;
        align-items: center;
        padding: 20px 25px;
        background: var(--bg-subtle);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        transition: all 0.2s ease;
    }

    .download-card:hover {
        background: #fff;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        border-color: var(--primary);
    }

    .file-icon {
        width: 48px;
        height: 48px;
        background: #fff;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin-right: 18px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }

    .file-content { flex: 1; }
    .file-header { display: flex; align-items: center; gap: 10px; margin-bottom: 4px; }
    .file-name { font-weight: 600; color: var(--text-main); }

    /* 状态标签 */
    .badge {
        font-size: 0.75rem;
        padding: 2px 8px;
        border-radius: 4px;
        font-weight: 500;
    }
    .badge-new { background: #dcfce7; color: #166534; }
    .badge-zip { background: #f1f5f9; color: #475569; }

    .file-meta {
        font-size: 0.85rem;
        color: var(--text-muted);
        display: flex;
        gap: 15px;
    }

    /* 下载按钮 */
    .btn-download {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 10px 20px;
        background: var(--primary);
        color: white;
        border-radius: 8px;
        font-weight: 500;
        text-decoration: none;
        transition: opacity 0.2s;
    }
    .btn-download:hover { opacity: 0.9; color: white; }

    /* 底部警告 */
    .warning-banner {
        margin-top: 40px;
        padding: 15px 20px;
        background: #fff7ed;
        border-left: 4px solid var(--warning);
        border-radius: 8px;
        color: #9a3412;
        font-size: 0.9rem;
    }

    @media (max-width: 768px) {
        .db-header { flex-direction: column; gap: 15px; }
        .search-box { width: 100%; }
        .download-card { flex-wrap: wrap; }
        .btn-download { width: 100%; justify-content: center; margin-top: 15px; }
    }

    /* 页面整体最小高度 100% */
    html, body {
        height: 100%;
        margin: 0;
        display: flex;
        flex-direction: column;
    }

    /* 主内容区域，占据剩余空间 */
    #mainContain,
    .container {
        flex: 1 0 auto;
    }

    /* footer 永远贴底 */
    footer, .footer {
        margin-top: auto;
    }
</style>

<div class="db-download-container">
    <div class="db-header" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px; margin-bottom: 20px;">
        <div class="db-title">
            <h2>cfDNAdb Download</h2>
            <p style="color: #6c757d; font-size: 0.9rem; margin-top: 5px;">System (last update: 2026-04-15 10:30)</p>
        </div>
    </div>

    <div class="section-title" style="margin-bottom: 15px; font-weight: bold; font-size: 1.1rem;">
        <span class="dot dot-prod" style="color: #1abc9c;"></span> Categorized Data (CSV)
    </div>

    <div class="download-grid">

        <div class="download-card" data-name="cfdnadb_full_dataset.csv">
            <div class="file-icon" style="font-size: 2rem; margin-right: 15px;">📊</div>
            <div class="file-content">
                <div class="file-header">
                    <span class="file-name" style="font-weight: bold; font-size: 1.1rem;">cfDNAdb_Dataset.csv</span>
                </div>
                <div class="file-desc" style="font-size: 0.85rem; color: #6c757d; margin: 5px 0;">
                    Complete collection containing all 24 annotation fields.
                </div>
                <div class="file-meta" style="font-size: 0.85rem; color: #adb5bd; display: flex; gap: 15px;">
                    <span> 3.3 MB</span>
                    <span>📅 2026-04-15</span>
                </div>
            </div>
            <a href="./download/cfDNAdb_Full_Dataset.csv" class="btn-download" download>Download</a>
        </div>

        <div class="download-card" data-name="cfdnadb_clinical_core.csv">
            <div class="file-icon" style="font-size: 2rem; margin-right: 15px;">📊</div>
            <div class="file-content">
                <div class="file-header">
                    <span class="file-name" style="font-weight: bold; font-size: 1.1rem;">cfDNAdb_Clinical value.csv</span>
                </div>
                <div class="file-desc" style="font-size: 0.85rem; color: #6c757d; margin: 5px 0;">
                    Essential clinical data: Markers, Cancer entity/Subtype, and Clinical Values.
                </div>
                <div class="file-meta" style="font-size: 0.85rem; color: #adb5bd; display: flex; gap: 15px;">
                    <span> 330 KB</span>
                    <span>📅 2025-11-20</span>
                </div>
            </div>
            <a href="./download/cfDNAdb_Clinical_Core.csv" class="btn-download" download>Download</a>
        </div>

        <div class="download-card" data-name="cfdnadb_cohort_population.csv">
            <div class="file-icon" style="font-size: 2rem; margin-right: 15px;">📊</div>
            <div class="file-content">
                <div class="file-header">
                    <span class="file-name" style="font-weight: bold; font-size: 1.1rem;">cfDNAdb_Population.csv</span>
                </div>
                <div class="file-desc" style="font-size: 0.85rem; color: #6c757d; margin: 5px 0;">
                    Demographics: Sample sources, patient characteristics, and countries.
                </div>
                <div class="file-meta" style="font-size: 0.85rem; color: #adb5bd; display: flex; gap: 15px;">
                    <span> 387 KB</span>
                    <span>📅 2026-01-12</span>
                </div>
            </div>
            <a href="./download/cfDNAdb_Cohort_Population.csv" class="btn-download" download>Download</a>
        </div>

        <div class="download-card" data-name="cfdnadb_evidence_results.csv">
            <div class="file-icon" style="font-size: 2rem; margin-right: 15px;">📊</div>
            <div class="file-content">
                <div class="file-header">
                    <span class="file-name" style="font-weight: bold; font-size: 1.1rem;">cfDNAdb_Experiment.csv</span>
                </div>
                <div class="file-desc" style="font-size: 0.85rem; color: #6c757d; margin: 5px 0;">
                    Research data: Experimental methods, statistics, and conclusions.
                </div>
                <div class="file-meta" style="font-size: 0.85rem; color: #adb5bd; display: flex; gap: 15px;">
                    <span> 2.2 MB</span>
                    <span>📅 2026-03-25</span>
                </div>
            </div>
            <a href="./download/cfDNAdb_Evidence_Results.csv" class="btn-download" download>Download</a>
        </div>

    </div>

    <div class="warning-banner" style="background-color: #fff3cd; color: #856404; padding: 15px; border-radius: 8px; border-left: 5px solid #ffeeba; margin-top: 30px;">
        <strong> Note：</strong> If you encounter any problems when downloading the database content, please contact us.
    </div>
</div>

<?php include "./Template/footer.php"; ?>


</body>
</html>
