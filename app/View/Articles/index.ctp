<header>
    <div class="header-container">
    <a class="logo" href="index.html">
        <img
        class="logo-img"
        src="https://image.hoken-room.jp/asset/header_logo.svg"
        />
    </a>
    </div>
</header>
<div class="wrapper">
    <h1 style="font-size: 20px; display: inline">記事一覧</h1>
    <div class="item-box">
    <div style="margin: 10px">
        <div id="sortable">
            <?php foreach ($articles as $article): ?>
                <div class="item text-item">
                    <p style="margin: 0px">
                    <?php 
                        echo $this->Html->link($article['Article']['title'], '/articles/view/'.$article['Article']['id'])
                    ?>
                    </p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    </div>
</div>
<footer>
    <div class="footer-container">
    <ul class="footer-menu">
        <li>会社概要<span>|</span></li>
        <li>利用規約<span>|</span></li>
        <li>プライバシーポリシー</li>
    </ul>
    <p class="copyright">Copyright© Wizleap Inc. engineers.</p>
    </div>
</footer>