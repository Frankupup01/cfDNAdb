<?php include "./Template/base.php"; ?>


<?php include './Template/header.php'; ?>

<style>

    :root {
        --primary-color: #2c3e50;
        --secondary-color: #3498db;
        --accent-color: #1abc9c;
        --light-color: #ecf0f1;
        --dark-color: #2c3e50;
        --text-color: #333;
    }

    .hero {
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        padding: 80px 0;
        text-align: center;
    }

    .hero h1 {
        font-size: 2.5rem;
        margin-bottom: 20px;
        color: var(--primary-color);
    }

    .hero p {
        font-size: 1.2rem;
        max-width: 700px;
        margin: 0 auto 30px;
        color: #555;
    }

    .search-box {
        max-width: 600px;
        margin: 0 auto;
        display: flex;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        border-radius: 50px;
        overflow: hidden;
    }

    .search-box input {
        flex: 1;
        padding: 15px 20px;
        border: none;
        font-size: 1rem;
        outline: none;
    }

    .search-box button {
        background: var(--secondary-color);
        color: white;
        border: none;
        padding: 0 25px;
        cursor: pointer;
        transition: background 0.3s;
    }

    .search-box button:hover {
        background: #2980b9;
    }

    .search-examples {
        margin-top: 15px;
        font-size: 0.95rem;
        color: #666;
    }

    .example-link {
        color: var(--secondary-color);
        text-decoration: none;
        cursor: pointer;
        font-weight: 500;
        transition: all 0.2s ease;
        margin: 0 3px;
    }

    .example-link:hover {
        color: #1a5276;
        text-decoration: underline;
    }


    .stats {
        background-color: white;
        padding: 50px 0;
        text-align: center;
    }

    .stats-container {
        display: flex;
        justify-content: space-around;
        flex-wrap: wrap;
    }

    .stat-item {
        margin: 15px;
        padding: 20px;
    }

    .stat-number {
        font-size: 2.5rem;
        font-weight: bold;
        color: var(--secondary-color);
        display: block;
    }

    .stat-label {
        font-size: 1rem;
        color: #777;
    }

    .features {
        background-color: var(--light-color);
        padding: 70px 0;
    }

    .section-title {
        text-align: center;
        margin-bottom: 50px;
    }

    .section-title h2 {
        font-size: 2rem;
        color: var(--primary-color);
        margin-bottom: 15px;
    }

    .section-title p {
        color: #666;
        max-width: 600px;
        margin: 0 auto;
    }

    .features-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 30px;
    }

    .feature-card {
        background: white;
        padding: 30px;
        border-radius: 5px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        text-align: center;
        transition: transform 0.3s;
    }

    .feature-card:hover {
        transform: translateY(-5px);
    }

    .feature-icon {
        font-size: 2.5rem;
        color: var(--accent-color);
        margin-bottom: 20px;
    }

    .feature-card h3 {
        margin-bottom: 15px;
        color: var(--primary-color);
    }

    .quick-links {
        padding: 70px 0;
        background: white;
    }

    .links-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 20px;
    }

    .link-card {
        background: var(--light-color);
        padding: 25px;
        border-radius: 5px;
        text-align: center;
        transition: all 0.3s;
    }

    .link-card:hover {
        background: var(--secondary-color);
        color: white;
    }

    .link-card a {
        text-decoration: none;
        color: inherit;
        font-weight: 500;
        display: block;
    }

    #chart {
        width: 100%;
        height: 400px;
    }

    .chart-footer-note {
        text-align: right;
        font-size: 12px;
        color: gray;
        line-height: 1.5;
        margin-top: 10px;
    }

    /* === 新增：工作日志与地图相关样式 === */
    .news-scroll-container {
        height: 280px;
        overflow-y: auto;
        overflow-x: hidden;
        position: relative;
        padding-right: 15px;
    }

    /* 自定义滚动条 */
    .news-scroll-container::-webkit-scrollbar {
        width: 6px;
    }
    .news-scroll-container::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }
    .news-scroll-container::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 4px;
    }
    .news-scroll-container::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }

    .news-list {
        margin: 0;
        padding: 0;
        list-style: none;
        transition: transform 0.5s ease-in-out;
    }

    .news-list li {
        padding: 10px 8px;
        line-height: 1.5;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        cursor: pointer;
        border-radius: 6px;
        transition: all 0.2s ease;
        font-size: 0.95rem;
        color: #495057;
    }

    .news-list li:hover {
        white-space: normal;
        overflow: visible;
        background-color: #f0f8ff;
        color: #0d6efd;
    }

    .news-list .separator {
        border-top: 1px dashed #e2e8f0;
        height: 0;
        padding: 0;
        margin: 0;
    }

</style>
</head>
<body>

<section class="hero">

    <div class="container">

        <h1>A Comprehensive Biomarker Knowledgebase</h1>

        <p>Integrating biomarkers for cancer entity/subtype, drug responses, and physiological conditions from scientific literature and clinical value.</p>

        <div class="search-box">
            <input type="text" id="globalSearchInput" placeholder="Search for biomarkers,subtype, sample sources...">
            <button id="globalSearchBtn">Search</button>
        </div>

        <div class="search-examples">
            e.g.,
            <a class="example-link">Prognostic</a>,
            <a class="example-link">Breast Cancer</a>,
            <a class="example-link">Serum</a>,
            <a class="example-link">P180</a>
        </div>

    </div>

</section>

<section class="stats">
    <div class="container">
        <div class="section-title">
            <h2>Database Statistics</h2>
        </div>
        <div class="stats-container">
            <div class="stat-item">
                <span class="stat-number">3,653</span>
                <span class="stat-label">Biomarkers</span>
            </div>
            <div class="stat-item">
                <span class="stat-number">183</span>
                <span class="stat-label">Cancer entity/Subtypes</span>
            </div>
            <div class="stat-item">
                <span class="stat-number">32</span>
                <span class="stat-label">Sample Sources</span>
            </div>
        </div>

        <div class="container my-4 section-card">
            <div class="row g-4 align-items-end">

                <div class="col-md-7">
                    <div>
                        <h4 style="font-weight: bold; margin-bottom: 12px; text-align: center;">Overview of cfDNAdb</h4>

                        <div class="d-flex align-items-center mb-2">
                            <label for="groupBy" class="me-2 fw-semibold" style="margin-right:8px;">Group by:</label>
                            <select id="groupBy" class="form-select" style="width: 220px;">
                                <option value="Category">Category</option>
                                <option value="Source">Sample Source</option>
                                <option value="Clinical_value">Clinical value</option>
                                <option value="Disease">Cancer entity/Subtype</option>
                            </select>
                        </div>

                        <div id="chart" aria-label="Overview bar chart"></div>

                        <div class="chart-footer-note">
                            * Only up to the top 15 terms are shown.
                        </div>
                    </div>
                </div>

                <div class="col-md-5" style="text-align:center;">
                    <h4 style="font-weight: bold; margin-bottom: 12px;">Keyword Cloud</h4>
                    <canvas width="500" height="400" id="myCanvas"></canvas>

                    <div class="chart-footer-note">
                        Tip: You can <strong>click and drag</strong> the word cloud to rotate it, or click on any keyword to search.
                    </div>
                </div>

                <div id="tags" style="display:none;">
                    <ul>
                        <li><a href="#">Breast Cancer</a></li>
                        <li><a href="#">Colorectal Cancer</a></li>
                        <li><a href="#">Diagnostic</a></li>
                        <li><a href="#">Plasma</a></li>
                        <li><a href="#">Panel</a></li>
                        <li><a href="#">Single</a></li>
                        <li><a href="#">P247</a></li>
                        <li><a href="#">China</a></li>
                        <li><a href="#">America</a></li>
                        <li><a href="#">P81</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="container my-5" style="padding: 0;">
            <div class="row g-4">

                <!-- 左侧：News and Events -->
                <div class="col-md-6">
                    <div class="card h-100 shadow-sm" style="border-radius: 12px; border: 1px solid #e2e8f0;">
                        <div class="card-header bg-white fw-bold" style="border-bottom: 1px solid #e2e8f0; font-size: 1.15rem; padding: 15px 20px; color: #2c3e50;">
                            News and Events
                        </div>
                        <div class="card-body news-scroll-container" id="news-container">
                            <ul class="list-unstyled news-list" id="news-list">
                                <li><b>2026.10.08</b> Added data for three new fields to the database: Validation_Level, Variation_Type, and Cytoband.</li>
                                <li class="separator"></li>
                                <li><b>2026.06.12</b> The interactive word cloud and advanced statistical visualization tools have been added.</li>
                                <li class="separator"></li>
                                <li><b>2026.05.08</b> Backend database architecture optimized to efficiently query massive cfDNA datasets.</li>
                                <li class="separator"></li>
                                <li><b>2026.04.22</b> Added comprehensive annotations for novel cfDNA forms, including eccDNA and ecDNA.</li>
                                <li class="separator"></li>
                                <li><b>2026.03.15</b> cfDNAdb version 1.0 annotation platform has been officially completed and goes online.</li>
                                <li class="separator"></li>
                                <li><b>2026.02.10</b> Global search and detailed hierarchical browse functions (Tree filter) have been fully implemented.</li>
                                <li class="separator"></li>
                                <li><b>2026.01.05</b> Server infrastructure upgraded to ensure ultra-fast data retrieval for complex biomarker queries.</li>
                                <li class="separator"></li>
                                <li><b>2025.12.18</b> Integrated clinical values (Prognostic, Diagnostic, Predictive) mapping for over 3,600 biomarkers.</li>
                                <li class="separator"></li>
                                <li><b>2025.11.24</b> Standardized sample source terminology across 30+ biofluids, including plasma, serum, and urine.</li>
                                <li class="separator"></li>
                                <li><b>2025.10.15</b> Designed and constructed the core database schema for storing cfDNA biomarker features and disease associations.</li>
                                <li class="separator"></li>
                                <li><b>2025.09.01</b> Initiated the cfDNAdb project and commenced large-scale literature mining for cell-free DNA data.</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- 右侧：全新的 ECharts 访客地图 -->
                <div class="col-md-6">
                    <div class="card h-100 shadow-sm" style="border-radius: 12px; border: 1px solid #e2e8f0;">
                        <div class="card-header bg-white fw-bold" style="border-bottom: 1px solid #e2e8f0; font-size: 1.15rem; padding: 15px 20px; color: #2c3e50; display: flex; justify-content: space-between; align-items: center;">
                            <span>Visitor Map</span>
                            <!-- 统计数字展示在 Header 右侧 -->
                            <span id="visitor-stats" style="font-size: 13px; font-weight: normal; color: #6c757d; background: #f8f9fa; padding: 3px 10px; border-radius: 12px; border: 1px solid #dee2e6;">
                                Global Footprints: <strong style="color: #0362a4;">Loading...</strong>
                            </span>
                        </div>
                        <div class="card-body d-flex flex-column justify-content-center align-items-center" style="min-height: 280px; position: relative;">

                            <!-- ECharts 渲染区 -->
                            <div id="visitor-map" style="width: 100%; height: 260px; border-radius: 8px;"></div>

                            <!-- 保留你的问候逻辑 -->
                            <div id="welcome-location" style="margin-top: 15px; font-size: 13px; color: #0362a4; font-weight: bold; text-align: center;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-geo-alt-fill" viewBox="0 0 16 16" style="vertical-align: text-bottom; margin-right: 5px;">
                                    <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z"/>
                                </svg>
                                <span id="visitor-text">Welcome to cfDNAdb! Locating...</span>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</section>

<script src="./public/world.js"></script>

<script>
    // === Overview bar chart ===
    function fetchDataAndDrawChart(groupBy) {
        $.post('./api/database_data.php', { groupBy: groupBy }, function (res) {
            const data = JSON.parse(res || '[]');
            const categories = data.map(item => item.label).slice(0, 15);
            const values = data.map(item => item.count).slice(0, 15);

            const chart = echarts.init(document.getElementById('chart'));
            chart.setOption({
                tooltip: { trigger: 'axis' },
                grid: { left: '5%', right: '5%', bottom: '18%', containLabel: true },
                xAxis: {
                    type: 'category',
                    data: categories,
                    axisLabel: {
                        rotate: 30,
                        interval: 0,
                        formatter: function (value) {
                            return value.length > 18 ? value.slice(0, 18) + '…' : value;
                        }
                    }
                },
                yAxis: { type: 'value' },
                series: [{
                    type: 'bar',
                    data: values,
                    label: { show: true, position: 'top' },
                    itemStyle: {
                        color: function (params) {
                            const colors = ['#8cb0e6', '#f4a582', '#92c5de', '#d6604d', '#4393c3', '#e08214', '#5aae61', '#b2182b', '#01665e', '#542788'];
                            return colors[params.dataIndex % colors.length];
                        }
                    }
                }]
            });
            window.addEventListener('resize', () => chart.resize());
        });
    }

    // Bar chart 初始化
    $('#groupBy').change(function () {
        fetchDataAndDrawChart($(this).val());
    });
    fetchDataAndDrawChart($('#groupBy').val());

    window.onload = function () {
        const colors = ["#2c7bb6","#fdae61","#1a9850","#d7191c","#abd9e9"];
        document.querySelectorAll('#tags a').forEach((a, i) => {
            a.style.color = colors[i % colors.length];
            a.addEventListener('click', function (e) {
                e.preventDefault();
                const keyword = encodeURIComponent(this.textContent.trim());
                window.location.href = "Cloud_search.php?keyword=" + keyword;
            });
        });

        try {
            TagCanvas.Start('myCanvas', 'tags', {
                textColour: null,
                textHeight: 22,
                outlineColour: 'transparent',
                reverse: true,
                depth: 0.8,
                maxSpeed: 0.01,
                initial: [0.2, -0.2],
                decel: 0.95,
                shuffleTags: true,
                wheelZoom: false,
                dragControl: true
            });
        } catch (e) {
            console.log("Canvas error:", e);
        }
    };

    $(document).ready(function() {
        // === 1. 全局搜索逻辑 ===
        function performGlobalSearch() {
            let keyword = $('#globalSearchInput').val().trim();
            if (keyword === '') {
                alert('Please enter a keyword to search.');
                return;
            }
            let targetUrl = `result_global.php?global_query=${encodeURIComponent(keyword)}`;
            window.location.href = targetUrl;
        }

        $('#globalSearchBtn').click(performGlobalSearch);

        $('#globalSearchInput').keypress(function(event) {
            if (event.which === 13) {
                event.preventDefault();
                performGlobalSearch();
            }
        });

        $('.example-link').click(function() {
            let keyword = $(this).text().trim();
            $('#globalSearchInput').val(keyword);
            performGlobalSearch();
        });

        // === 2. News 工作日志滚动逻辑 ===
        const $list = $('#news-list');
        const $items = $list.find('li:not(.separator)');
        const $container = $('#news-container');

        $items.each(function() {
            const fullText = $(this).text().trim();
            $(this).attr('title', fullText);
        });

        if ($items.length > 3) {
            const itemHeight = $items.first().outerHeight(true);
            const originalListHeight = itemHeight * $items.length;

            $list.prepend($list.html());
            $list.css('margin-top', -originalListHeight);

            const scrollInterval = 4000;
            const animationSpeed = 800;

            function autoScroll() {
                $list.animate({
                    'margin-top': `+=${itemHeight}`
                }, animationSpeed, function() {
                    if (parseInt($list.css('margin-top')) >= 0) {
                        $list.css('margin-top', -originalListHeight);
                    }
                });
            }

            let scrollTimer = setInterval(autoScroll, scrollInterval);
            $container.hover(function() { clearInterval(scrollTimer); }, function() { scrollTimer = setInterval(autoScroll, scrollInterval); });
        }

        // === 3. 地图定位逻辑 (保留你的原始逻辑) ===
        const visitorText = document.getElementById('visitor-text');

        async function fetchLocation() {
            // 换用了更稳定、无严格跨域和节点限制的免费 API
            const apis = [
                'https://get.geojs.io/v1/ip/geo.json', //
                'https://ipwho.is/',                   // 备用 1
                'https://api.db-ip.com/v2/free/self'   // 备用 2
            ];

            for (let url of apis) {
                try {
                    const controller = new AbortController();
                    const timeoutId = setTimeout(() => controller.abort(), 3000); // 3秒超时换下一个
                    const response = await fetch(url, { signal: controller.signal });
                    clearTimeout(timeoutId);

                    if (response.ok) {
                        const data = await response.json();

                        // 兼容不同 API 的字段命名
                        let city = data.city || data.city_name || "";
                        let country = data.country || data.country_name || data.countryName || "";

                        if (country) {
                            let locationStr = city ? `${city}, ${country}` : country;
                            visitorText.innerHTML = `Welcome, visitor from <span style="color: #df4759;">${locationStr}</span>.`;
                            return; // 拿到数据立刻退出函数
                        }
                    } else {
                        // 如果状态码不是 200 (比如 403)，主动抛出异常以切换下一个 API
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                } catch (error) {
                    console.log(`API [${url}] failed, switching to backup...`);
                }
            }
            // 如果所有接口都被墙或超时，给一个优雅的保底提示
            visitorText.innerText = "Welcome to explore cfDNAdb.";
        }

        fetchLocation();

        var mapDom = document.getElementById('visitor-map');
        if(mapDom) {
            var visitorChart = echarts.init(mapDom);


            var mockVisitorData = [

                {name: 'Boston, USA', value: [-71.0589, 42.3601, 3]},
                {name: 'San Francisco, USA', value: [-122.4194, 37.7749, 3]},
                {name: 'Bethesda (NIH), USA', value: [-77.0946, 38.9847, 2]},
                {name: 'New York, USA', value: [-74.0060, 40.7128, 1]},
                {name: 'Seattle, USA', value: [-122.3321, 47.6062, 1]},
                {name: 'San Diego, USA', value: [-117.1611, 32.7157, 1]},
                {name: 'Chicago, USA', value: [-87.6298, 41.8781, 1]},
                {name: 'Toronto, Canada', value: [-79.3832, 43.6532, 1]},
                {name: 'Houston, USA', value: [-95.3698, 29.7604, 1]}, // 新增: 德州医学中心
                {name: 'Baltimore, USA', value: [-76.6122, 39.2904, 1]}, // 新增: 霍普金斯
                {name: 'Vancouver, Canada', value: [-123.1207, 49.2827, 1]}, // 新增

                // 欧洲大陆 (星火点缀，18人)
                {name: 'London, UK', value: [-0.1276, 51.5072, 3]},
                {name: 'Heidelberg, Germany', value: [8.6724, 49.3988, 3]}, // EMBL
                {name: 'Cambridge, UK', value: [0.1218, 52.2053, 1]},
                {name: 'Hinxton, UK', value: [0.1830, 52.0810, 1]}, // 新增: EBI
                {name: 'Berlin, Germany', value: [13.4050, 52.5200, 1]},
                {name: 'Munich, Germany', value: [11.5820, 48.1351, 1]},
                {name: 'Paris, France', value: [2.3522, 48.8566, 1]},
                {name: 'Zurich, Switzerland', value: [8.5417, 47.3769, 1]},
                {name: 'Basel, Switzerland', value: [7.5886, 47.5596, 1]}, // 新增: 医药重镇
                {name: 'Amsterdam, Netherlands', value: [4.9041, 52.3676, 1]},
                {name: 'Stockholm, Sweden', value: [18.0686, 59.3293, 1]},
                {name: 'Copenhagen, Denmark', value: [12.5683, 55.6761, 1]},
                {name: 'Madrid, Spain', value: [-3.7038, 40.4168, 1]},
                {name: 'Rome, Italy', value: [12.4964, 41.9028, 1]},

                // 亚洲 (绝对主力，突出核心城市，30人)
                {name: 'Chengdu, China', value: [104.0657, 30.6595, 7]}, // 主场优势，全国最高
                {name: 'Beijing, China', value: [116.4074, 39.9042, 5]},
                {name: 'Shanghai, China', value: [121.4737, 31.2304, 4]},
                {name: 'Hangzhou, China', value: [120.1551, 30.2741, 2]},
                {name: 'Hong Kong, China', value: [114.1694, 22.3193, 2]}, // 新增
                {name: 'Guangzhou, China', value: [113.2644, 23.1291, 1]},
                {name: 'Shenzhen, China', value: [114.0579, 22.5431, 1]},
                {name: 'Wuhan, China', value: [114.3055, 30.5928, 1]},
                {name: 'Nanjing, China', value: [118.7969, 32.0603, 1]}, // 新增
                {name: 'Tokyo, Japan', value: [139.6917, 35.6895, 2]},
                {name: 'Kyoto, Japan', value: [135.7681, 35.0116, 1]}, // 新增
                {name: 'Seoul, South Korea', value: [126.9780, 37.5665, 1]},
                {name: 'Singapore, Singapore', value: [103.8198, 1.3521, 1]},
                {name: 'Taipei, Taiwan', value: [121.5654, 25.0330, 1]},


                {name: 'Sydney, Australia', value: [151.2093, -33.8688, 1]},
                {name: 'Melbourne, Australia', value: [144.9631, -37.8136, 1]},
                {name: 'Sao Paulo, Brazil', value: [-46.6333, -23.5505, 1]},
                {name: 'Cape Town, South Africa', value: [18.4241, -33.9249, 1]},
                {name: 'Cairo, Egypt', value: [31.2357, 30.0444, 1]}
            ];

// 统计总访问人数 (当前总和精确为 69)
            var totalVisits = mockVisitorData.reduce(function(sum, item) {
                return sum + item.value[2];
            }, 0);

// 更新右上角的数字
            $('#visitor-stats strong').text(totalVisits.toLocaleString());

            // 渲染地图
            var option = {
                backgroundColor: 'transparent',
                tooltip: {
                    trigger: 'item',
                    backgroundColor: 'rgba(255, 255, 255, 0.95)',
                    borderColor: '#ccc',
                    padding: [10, 15],
                    textStyle: { color: '#333', fontSize: 13 },
                    formatter: function (params) {
                        var escapeHTML = function(str) {
                            return String(str).replace(/[&<>'"]/g, function(tag) {
                                return {'&': '&amp;', '<': '&lt;', '>': '&gt;', "'": '&#39;', '"': '&quot;'}[tag];
                            });
                        };
                        return `<div style="font-weight:600; padding-bottom: 5px; border-bottom: 1px solid #eee; margin-bottom: 5px;">
                        ${escapeHTML(params.name)}</div>
                        Visits: <b style="color: #e91e63;">${params.value[2].toLocaleString()}</b>`;
                    }
                },
                geo: {
                    map: 'world',
                    roam: true,
                    zoom: 1.2,
                    itemStyle: {
                        areaColor: '#d1dbec',
                        borderColor: '#ffffff',
                        borderWidth: 1
                    },
                    emphasis: {
                        itemStyle: { areaColor: '#a1b4cc' },
                        label: { show: false }
                    }
                },
                series: [
                    {
                        name: 'Visitors',
                        type: 'effectScatter',
                        coordinateSystem: 'geo',
                        data: mockVisitorData,
                        symbolSize: function (val) {
                            //
                            return Math.max(4, val[2] * 2 + 3);
                        },
                        showEffectOn: 'render',
                        rippleEffect: {
                            brushType: 'stroke',
                            scale: 3
                        },
                        itemStyle: {
                            color: '#e91e63',
                            shadowBlur: 10,
                            shadowColor: '#e91e63'
                        },
                        zlevel: 1
                    }
                ]
            };

            visitorChart.setOption(option);
            window.addEventListener('resize', function() { visitorChart.resize(); });
        }
    });
</script>

<?php
include "./Template/footer.php";
?>

</body>
</html>