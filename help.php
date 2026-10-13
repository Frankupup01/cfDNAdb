<?php include "./Template/base.php"; ?>

<?php include './Template/header.php'; ?>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* 🔴 核心修复 1：精细控制右侧内容区的各级标题及正文大小，建立完美层级 */
        .bd-content h2 {
            font-size: 23px;
            font-weight: bold;
            margin-top: 30px;
            margin-bottom: 15px;
            border-bottom: 1px solid #eee;
            padding-bottom: 5px;
        }

        .bd-content h3 {
            font-size: 18px;
            font-weight: bold;
            margin-top: 25px;
            margin-bottom: 12px;
        }

        .bd-content h4 {
            font-size: 16px;
            font-weight: bold;
            margin-top: 20px;
            margin-bottom: 10px;
        }

        /* 🔴 核心修复 2：正文文本双端对齐、引入英文字典连字符断字、统一字体大小 15px */
        .bd-content p {
            font-size: 15px;
            text-align: justify;
            text-justify: inter-word;
            hyphens: auto;
            -webkit-hyphens: auto;
            line-height: 1.6;
            margin-bottom: 15px;
        }

        /* 🔴 核心修复 3：左侧导航按钮强制不换行，超出部分隐藏并显示省略号，绝不突出版面 */
        .bd-sidebar .btn {
            white-space: nowrap !important;
            overflow: hidden !important;
            text-overflow: ellipsis !important;
            display: block; /* 保证 text-overflow 生效 */
            font-size: clamp(12px, 1vw, 14px); /* 字体自适应缩放 */
        }

        /* 确保超链接的颜色和行为正常 */
        .bd-content a {
            color: #0d6efd;
            text-decoration: underline;
            word-break: break-all; /* 防止超长 URL 撑破页面 */
        }

        .bd-content a:hover {
            color: #0a58ca;
        }
    </style>

    <div class="min-vh-100" style="width: 70%;margin-left: 180px;margin-top: 20px;padding-left: 110px;">
        <br>
        <div class="row flex-xl-nowrap">
            <div class="col-lg-4 bd-sidebar">
                <nav class="bd-links" style="background-color: #FFFFFF; position: sticky; top: 70px; height: calc(100vh - 100px); overflow-y: auto; padding: 15px; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.05);">
                    <div class="row" style="background-color: #FFFFFF; margin-top: -15px; margin-bottom: 20px" >
                        <div class="col-lg-12">
                            <table class="mt-4 w-100" style="table-layout: fixed;">
                                <thead>
                                <tr>
                                    <th>
                                        <div class="alert alert-secondary d-flex justify-content-center align-items-center m-0" role="alert" style="background-color: #ecf0f1; min-height: 60px; padding: 10px;">
                                            <span class="font-weight-bold text-center" style="color: #2c3e50; font-size: clamp(18px, 2vw, 24px); white-space: nowrap;">Help Navigation</span>
                                        </div>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr><td><a class="btn border px-3 py-1 text-start w-100" href="#1-what-information-is-avaiable-in-cfDNAdb" title="1 What information is avaiable in cfDNAdb?">1  What information is avaiable in cfDNAdb?</a></td></tr>
                                <tr><td><a class="btn border px-3 py-1 text-start w-100" href="#2-how-to-use-the-cfDNAdb" title="2 How to use the cfDNAdb?">2 How to use the cfDNAdb?</a></td></tr>
                                <tr><td><a class="btn border px-3 py-1 text-start w-100" href="#21-browse" title="2.1 Browse">2.1  Browse</a></td></tr>
                                <tr><td><a class="btn border px-3 py-1 text-start w-100" href="#211-Browse-filter" title="2.1.1 Browse by filters">2.1.1  Browse by filters</a></td></tr>
                                <tr><td><a class="btn border px-3 py-1 text-start w-100" href="#212-Tree-filter" title="2.1.2 Browse by tree">2.1.2  Browse by tree</a></td></tr>
                                <tr><td><a class="btn border px-3 py-1 text-start w-100" href="#22-search" title="2.2 Search">2.2  Search</a></td></tr>
                                <tr><td><a class="btn border px-3 py-1 text-start w-100" href="#3-Download" title="3 Download">3 Download</a></td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </nav>
            </div>

            <div class="col-lg-8 bd-content" lang="en">

                <h2 id="1-what-information-is-avaiable-in-cfDNAdb">1. What information is available in cfDNAdb?</h2>
                <p>The detection of cell-free DNA (cfDNA) in body fluids enables independent, non-invasive monitoring of disease progression and therapeutic efficacy. When integrated with diverse molecular signatures, cfDNA captures the evolutionary dynamics of various disease stages, significantly enhancing the precision of liquid biopsy for diagnosis and prognostic assessment. However, the field has lacked a systematic platform that integrates and analyzes clinically validated cfDNA biomarkers. To address this, we developed cfDNAdb, a specialized database that categorizes high-confidence cfDNA biomarkers across various cancer stages by manually extracting cfDNA biomarker information scattered across vast amounts of literature, thereby providing a robust resource for accurate diagnostic and prognostic discovery. By integrating previously fragmented data, cfDNAdb overcomes limitations in data reusability and minimizes biological noise, providing a robust foundation for the rapid translation of liquid biopsy into precision clinical practice. Based on expert manual curation, the platform systematically archives 3,651 cfDNA biomarkers across six clinical scenarios, 29 body fluid types, and 189 cancer subtypes, complemented by comprehensive annotations and external database integration. </p>

                <h2 id="2-how-to-use-the-cfDNAdb">2. How to use the cfDNAdb?</h2>

                <h3 id="21-browse">2.1 Browse</h3>
                <p>Browsing is divided into two types: one is Browse filter, and the other is Tree filter.</p>

                <h4 id="211-Browse-filter">2.1.1 Browse by Filters</h4>
                <p>Users can search for cfDNA by clicking on the small square box.</p>
                <p><img alt="browse" src="./picture/filter.png" width="900"/></p>
                <p><img alt="sample" src="./picture/filter2.png" width="900" /></p>
                <p><b>URL: <a href="https://lcbb.swjtu.edu.cn/cfDNAdb/browse_all.php" target="_blank">https://lcbb.swjtu.edu.cn/cfDNAdb/browse_all.php</a></b></p>

                <h4 id="212-Tree-filter">2.1.2 Browse by tree</h4>
                <p>This is the tree filter. Users can click on different types of cfDNA to perform hierarchical filtering for search.</p>
                <p><img alt="sample" src="./picture/tree.png" width="900" /></p>
                <p><img alt="sample" src="./picture/tree_result.png" width="900" /></p>
                <p><img alt="sample" src="./picture/tree_result2.png" width="900" /></p>
                <p><b>URL: <a href="https://lcbb.swjtu.edu.cn/cfDNAdb/search_basic.php" target="_blank">https://lcbb.swjtu.edu.cn/cfDNAdb/search_basic.php</a></b></p>

                <p>The cfDNAdb database browse detail.</p>
                <p><img alt="sample" src="./picture/detail.png" width="900" /></p>
                <p><b>URL: <a href="https://lcbb.swjtu.edu.cn/cfDNAdb/detail_browse.php?id=CFD00001" target="_blank">https://lcbb.swjtu.edu.cn/cfDNAdb/detail_browse.php?id=CFD00001</a></b></p>

                <h3 id="22-search">2.2 Search</h3>
                <p>The cfDNAdb database has search functions, namely Step-by-Step Search.</p>
                <p><img alt="Step by step Search" src="./picture/search.png" width="900"/></p>
                <p><b>URL: <a href="https://lcbb.swjtu.edu.cn/cfDNAdb/search.php" target="_blank">https://lcbb.swjtu.edu.cn/cfDNAdb/search.php</a></b></p>

                <h2 id="3-Download">3. Download</h2>
                <p>Users can download the data of this database by clicking the Download button on the right.</p>
                <p><img alt="browse" src="./picture/download.png" width="900"/></p>
                <p><b>URL: <a href="https://lcbb.swjtu.edu.cn/cfDNAdb/Download.php" target="_blank">https://lcbb.swjtu.edu.cn/cfDNAdb/Download.php</a></b></p>

            </div>
        </div>
    </div>

<?php
include "./Template/footer.php";
?>