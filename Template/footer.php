<style>
    /* === 页脚专属样式 === */
    footer {
        background-color: #2c3e50; /* 深色背景，可根据你的主题调整 */
        color: #ecf0f1;
        padding: 50px 0 20px 0;
        margin-top: auto; /* 保证页脚沉底 */
    }

    /* 保持与你上方主体内容一样的宽度和边距 */
    footer .container {
        max-width: 1325px;
        margin: 0 auto;
        padding: 0 20px;
    }

    .footer-content {
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap; /* 适配窄屏幕自动折行 */
        gap: 30px;
        margin-bottom: 30px;
    }

    .footer-column {
        flex: 1;
        min-width: 200px;
    }

    .footer-column h3,
    .footer-column h4 {
        color: #ffffff;
        font-size: 1.2rem;
        margin-bottom: 20px;
        font-weight: 600;
        margin-top: 0;
    }

    /* ★ 核心修复：去除 ul 的默认内边距，解决“空两格”无法对齐的问题 */
    .footer-column ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .footer-column ul li {
        margin-bottom: 12px;
    }

    .footer-column a {
        color: #bdc3c7;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .footer-column a:hover {
        color: #3498db;
    }

    .footer-column p {
        color: #bdc3c7;
        margin-bottom: 8px;
        line-height: 1.6;
        font-size: 0.95rem;
    }

    .copyright {
        text-align: center;
        padding-top: 25px;
        border-top: 1px solid #34495e;
        color: #7f8c8d;
        font-size: 0.9rem;
    }
</style>

<footer>
    <div class="container">
        <div class="footer-content">
            <div class="footer-column">
                <h3>cfDNAdb</h3>
                <p>A comprehensive biomarker knowledgebase for research and clinical applications.</p>
            </div>

            <div class="footer-column">
                <h3>Quick Links</h3>
                <ul>
                    <li><a href="./index.php">Home</a></li>
                    <li><a href="./browse_all.php">Browse</a></li>
                    <li><a href="./download.php">Download</a></li>
                    <li><a href="./help.php">Manual</a></li>
                </ul>
            </div>

            <div class="footer-column">
                <h3>Contact</h3>
                <ul>
                    <li><a href="./About.php">About Us</a></li>
                </ul>
            </div>

            <div class="footer-column">
                <p>School of Life Science and Engineering</p>
                <p>Southwest Jiaotong University</p>
                <p>Chengdu, Sichuan, China</p>
                <p class="email-link">Email: <a href="mailto:zhiyunguo@swjtu.edu.cn">zhiyunguo@swjtu.edu.cn</a></p>
                <p>Phone: 028-87603202</p>
                <p>Fax: 028-87603202</p>
            </div>
        </div>

        <div class="copyright">
            <p>&copy; 2026 lcbb. All rights reserved.</p>
        </div>
    </div>
</footer>