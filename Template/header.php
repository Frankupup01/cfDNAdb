<style>
    /* 1. 让整个 nav 变成 Flex 容器，并强制不换行 */
    nav {
        display: flex;
        align-items: center;        /* 垂直居中 */
        justify-content: space-between; /* 左右两端对齐 */
        height: 60px;
        flex-wrap: nowrap;          /* 强制所有内容保持在一行 */
        gap: 15px;                  /* 左右两部分在极度拥挤时的最小安全距离 */
    }

    /* 2. 左侧 Logo 和菜单项 */
    .nav-left {
        display: flex;
        align-items: center;
        /* 使用 clamp() 实现动态间距：视口宽时是30px，窄时自动缩至15px */
        gap: clamp(15px, 2vw, 30px);
        flex-shrink: 0;             /* 尽量保证导航菜单不被过度挤压变形 */
    }

    /* 3. 菜单列表 */
    .nav-links {
        display: flex;
        align-items: center;
        gap: clamp(10px, 1.5vw, 20px); /* 菜单项之间的动态间距 */
        margin: 0;
        padding: 0;
        list-style: none;
        height: 100%;
    }

    /* ★ 核心修复 1：禁止菜单项文字换行，解决 Browse ▾ 断行问题 */
    .nav-links li, .nav-links li a {
        white-space: nowrap;
    }

    /* 4. 右侧搜索栏整体 */
    .nav-search {
        display: flex;
        align-items: center;
        gap: 5px;
        flex-shrink: 1;             /* 允许右侧搜索栏在空间不足时被压缩 */
        min-width: 0;               /* 防止 Flex 子元素撑爆父级 */
    }

    /* 搜索下拉框 */
    .search-type {
        flex-shrink: 0;             /* 保证下拉框文字完整，不被压缩 */
    }

    .search-type select {
        max-width: 150px;           /* 限制下拉框最大宽度，防止选项太长占空间 */
    }

    /* ★ 核心修复 2：让搜索输入框变成弹性的，屏幕小就自动变短 */
    .search-input {
        flex: 1 1 auto;             /* 允许弹性伸缩 */
        min-width: 60px;            /* 压缩的极限宽度（不能缩到没影） */
        width: 100%;                /* 默认占满剩余空间 */
    }

    /* 搜索按钮 */
    .search-button {
        flex-shrink: 0;             /* 保证按钮不被压缩 */
        white-space: nowrap;        /* 保证按钮上的字不换行 */
    }

    /* --- 响应式微调 (当屏幕实在太小，比如手机/极端缩小窗口时) --- */
    @media (max-width: 992px) {
        .nav-links {
            font-size: 14px; /* 字体稍微缩排一点，腾出空间 */
        }
        .search-type select, .search-input, .search-button {
            padding: 4px 8px; /* 减小内边距，腾出空间 */
            font-size: 13px;
        }
    }
</style>

<header>
    <div class="container">
        <nav>
            <div class="nav-left">
                <a href="./index.php" class="logo" style="text-decoration: none; color: inherit;">cfDNA<span>db</span></a>

                <ul class="nav-links">

                    <li class="dropdown">
                        <a href="./index.php">Home</a>
                    </li>

                    <li class="dropdown">
                        <a href="#">Browse ▾</a>
                        <div class="dropdown-content">
                            <a href="./browse_all.php">Browse by Filters</a>
                            <a href="./search_basic.php">Browse by Tree</a>
                        </div>
                    </li>

                    <li class="dropdown">
                        <a href="./search.php">Search</a>
                    </li>

                    <li class="dropdown">
                        <a href="./Download.php">Download </a>
                    </li>

                    <li class="dropdown">
                        <a href="./help.php">About</a>
                    </li>
                </ul>
            </div>

            <!-- 右侧搜索栏 -->
            <div class="nav-search">
                <div class="search-type">
                    <select class="search-select" id="searchType">
                        <option value="ID">Biomarker ID</option>
                        <option value="Disease">Cancer entity</option>
                        <option value="Category">Category</option>
                        <option value="marker_type">Marker type</option>
                        <option value="Source">Source</option>
                        <option value="Clinical_value">Clinical Value</option>
                        <option value="Country">Country</option>
                    </select>
                </div>
                <input type="text" class="search-input" id="searchInput" placeholder="Search...">
                <button class="search-button" onclick="performSearch()">
                    search
                </button>
            </div>
        </nav>
    </div>
</header>

<script>

        function performSearch() {
        let type = $("#searchType").val();
        let keyword = $("#searchInput").val().trim();

        if (!keyword) {
        alert("Please enter a keyword.");
        return;
    }

        //  查询前先 AJAX 测试是否存在
        $.post("./api/quick_search.php", {
        type: type,
        keyword: keyword,
        start: 0,
        length: 1,
        draw: 1
    }, function (res) {
        try {
        res = JSON.parse(res);
    } catch (e) {
        alert("Search failed.");
        return;
    }

        if (res.iTotalRecords === 0 || res.iTotalDisplayRecords === 0) {
        //  没有结果 → 弹窗
        alert("The content you are looking for does not exist. Please select another TAB bar or search for other content.");
    } else {
        //  有结果 → 跳转
        let url = "quick_search.php?type=" + encodeURIComponent(type)
        + "&keyword=" + encodeURIComponent(keyword);
        window.location.href = url;
    }
    });
    }


    //提示词
    const placeholderMap = {
        "ID": "e.g. P79",
        "Disease": "e.g. Breast Cancer",
        "Category": "e.g. cfDNA",
        "marker_type": "e.g. Single",
        "Source": "e.g. Plasma",
        "Clinical_value": "e.g. Prognostic",
        "Country": "e.g. China"
    };

    // 监听下拉菜单 change
    $("#searchType").on("change", function () {
        let type = $(this).val();
        $("#searchInput").attr("placeholder", placeholderMap[type] || "Search...");
    });
</script>
