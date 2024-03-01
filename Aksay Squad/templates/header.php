<header class="header">
            <div class="container">
                <div class="header-inner">
                    <div class="logo">
                        <a href="./" onclick="slowScroll('#index');" class="logo" style="text-decoration: none; cursor: pointer">
                            <img src="./images/logo.webp" alt="logoas" style="width: 50px; height:50px;">
                            <h1 style="font-weight: 400;font-size: 21px;line-height: 26px;">/aksaysquad</h1>
                        </a>
                    </div>
                    <nav class="nav">
                        <!-- burger list hides when pc -->
                        <div class="header_burger">
                            <div class="burger-menu">
                                <div class="nav-links pc">
                                    <a href="./">Главная</a>
                                    <!-- <a href="./music">Музыка</a> -->
                                    
                                    <a href="./data">База воспоминаний</a>
                                    <a href="./abmd">О сайте/Медиа</a>
                                </div>
                            </div>
                            <span class="btn-adaptive"></span>
                            <div class="burger_list">
                                <div class="burger-menu">
                                    <div class="nav-links">
                                        <a href="./">Главная</a>
                                        <!-- <a href="./music">Музыка</a> -->
                                        
                                        <a href="./data">База воспоминаний</a>
                                        <a href="./abmd">О сайте/Медиа</a>
                                    </div>
                                </div>
                                <aside class="aside">
                                    <div class="aside-inner" id="aside">
                                        <div class="daily-quote">
                                            <h1>цитата дня</h1>
                                            <div class="d-quote-inner">
                                                <ion-icon name="chatbox-ellipses-outline"></ion-icon>
                                                <p>
                                                    <b id='author-phone'><?php echo $quoteData['title'] ?></b>
                                                    <br />
                                                    <span id='quote-text-phone'><?php echo $quoteData['description'] ?></span>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="social-media-btn">
                                                <a href="./abmd">
                                                    <button>
                                                    <a target="_blank" href="https://github.com/damirTAG/Aksay-Squad-v2">GitHub</a>
                                                    </button>
                                                </a>
                                            </div>
                                    
                                        <div class="discord-widget">
                                            <h1>discord</h1>
                                            <iframe src="https://discord.com/widget?id=731124657603739719&theme=dark" width="280" height="290" allowtransparency="true" frameborder="0" sandbox="allow-popups allow-popups-to-escape-sandbox allow-same-origin allow-scripts"></iframe>
                                        </div>
                                    </div>
                                </aside>
                            </div>
                        </div>


                    </nav>
                </div>
            </div>
        </header>