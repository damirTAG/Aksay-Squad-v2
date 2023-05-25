<?php
date_default_timezone_set("Asia/Oral");
date_default_timezone_set("Asia/Almaty");

/** @var Connection $connection */
$connection = require_once 'pdo.php';
// Read notes from database
$notes = $connection->getNotes();

$currentNote = [
    'id' => '',
    'title' => '',
    'description' => ''
];
if (isset($_GET['id'])) {
    $currentNote = $connection->getNoteById($_GET['id']);
}

?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="AKSAY SQUAD OFFICIAL SITE" />
    <meta name="keywords" content="цитаты, база воспоминаний, о сайте, feedback" />
    <!-- <meta name="robots" content="index, follow" /> -->
    <script src="./voting_mp/voting.js" type="text/javascript"></script>
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"
    integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ="
    crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./style.css">
    <link rel="canonical" href="https://aksaysquad.infinityfreeapp.com" />
    <link rel="shortcut icon" href="./images/Ellipse 1.png" type="image/x-icon" />
    <link rel="shortcut icon" href="./images/Ellipse 1.png" type="image/jpg" />
    <link href="./voting_mp/voting.css" rel="stylesheet" type="text/css" />
    <title>Aksay Squad</title>
</head>

<body id="index">
    <div class="container">
        <div id="topBtn" title="вверх" onclick="slowScroll('#index'); topFunction()">
            <ion-icon title="вверх" name="arrow-up"></ion-icon>
        </div>
    </div>
    <header class="header">
        <div class="container">
            <div class="header-inner">
                <div class="logo">
                    <a href="#index" onclick="slowScroll('#index');" class="logo" style="text-decoration: none; cursor: pointer">
                        <img src="./images/logo.webp" alt="logoas" style="width: 50px; height:50px;">
                        <h1 style="font-weight: 400;font-size: 21px;line-height: 26px;">/aksaysquad</h1>
                    </a>
                </div>
                <nav class="nav">
                    <!-- burger list hides when pc -->
                    <div class="header_burger">
                        <div class="burger-menu">
                            <div class="nav-links pc">
                                <a href="#index">Главная</a>
                                <!-- <a href="./music">Музыка</a> -->
                                <a href="./poll">Опросы</a>
                                <a href="./data">База воспоминаний</a>
                                <a href="./abmd">О сайте/Медиа</a>
                            </div>
                        </div>
                        <span class="btn-adaptive"></span>
                        <div class="burger_list">
                            <div class="burger-menu">
                                <div class="nav-links">
                                    <a href="#index">Главная</a>
                                    <!-- <a href="./music">Музыка</a> -->
                                    <a href="./poll">Опросы</a>
                                    <a href="./data">База воспоминаний</a>
                                    <a href="./abmd">О сайте/Медиа</a>
                                </div>
                            </div>
                            <aside class="aside">
                                <div class="aside-inner" id="aside">
                                    <div class="daily-quote">
                                        <h1>Цитата дня</h1>
                                        <div class="d-quote-inner">
                                            <ion-icon name="chatbox-ellipses-outline"></ion-icon>
                                            <?php
                                            $file = "quoteToday.txt";
                                            $fh = fopen($file, "r");
                                            $string = fread($fh, filesize($file));
                                            fclose($fh);
                                            echo "<p>$string</p>";
                                            ?>
                                        </div>
                                    </div>
                                    <div class="social-media-btn">
                                        <a href="./abmd">
                                            <button>Social media</button>
                                        </a>
                                    </div>
                                    
                                    <div class="discord-widget">
                                        <h1>discord</h1>
                                        <!-- <iframe src="https://discord.com/widget?id=731124657603739719&theme=dark" width="280" height="290" allowtransparency="true" frameborder="0" sandbox="allow-popups allow-popups-to-escape-sandbox allow-same-origin allow-scripts"></iframe> -->
                                    </div>
                                </div>
                            </aside>
                        </div>
                    </div>


                </nav>
            </div>
        </div>
    </header>
    <!-- велком -->
    <section class="welcome">

        <div class="container">
            <div class="welcome-inner">
                <div class="w-text">
                    <h1>ДОБРО ПОЖАЛОВАТЬ НА ИНФОРМАЦИОННО-ЦИТАТНЫЙ
                        САЙТ НАШЕГО СКВАДА</h1>
                </div>
            </div>
        </div>

    </section>
    

    <article id="leftdiv">
        <div class>
            <div class="quote" style="display: flex;
                flex-wrap: wrap;
                flex-direction: column;
                align-content: center;
                justify-content: center;">
                <div class="quote-h1" style="width: auto;">
                    <h1>Оставить
                        цитату
                    </h1>
                    <div class="search-error" style="display: flex; flex-wrap: wrap;">
                        <div class="search-error-inner" style="display: flex;">
                        <p>
                            поиск временно не работает
                        </p>           
                        
                        </div>
                        
                    </div>
                    <!-- <div class="search-bar">
                        <form method="POST" action="index.php" style="margin: 0;">
                            <input type="text" id="search" autocomplete="off" style="color:#fff;" value="<?php echo isset($_POST['keyword']) ? $_POST['keyword'] : '' ?>" name="keyword" placeholder="Поиск" />
                            <button class="search-btn" name="search"><ion-icon name="search"></ion-icon></button>
                        </form>
                    </div> -->
                </div>
                <br>




                <form class="new-note" action="create.php" id="subForm" method="post">
                    <input type="hidden" name="id" value="<?php echo $currentNote['id'] ?>">
                    <input type="text" name="title" placeholder="Автор" maxlength="50" required autocomplete="off" value="<?php echo $currentNote['title'] ?>">
                    <textarea id="quote-textarea" name="description" cols="30" rows="4" placeholder="Цитата" required maxlength="600"><?php echo $currentNote['description'] ?></textarea>
                    <br>
                    <!-- и помните Марат подслушает!    -->
                    <p style="color:#fff;">Защита от ботов:</p>
                    <div class="captcha">
                        <label id="ebcaptchatext" style="color:#fff;"></label>
                        <input type="text" placeholder="Ответ" maxlength="2" class="text__box" id="ebcaptchainput" />
                    </div>
                    <button type="submit" name=“Submit” style="margin-top:20px;">

                        <?php if ($currentNote['id']) : ?>
                            Обновить
                        <?php else : ?>
                            Отправить
                        <?php endif ?>
                    </button>
                </form>
                <!-- COPY THIS BEGINING -->
                <!-- upload audio file here -->
                <form class="new-note" action="upload.php" method="post" enctype="multipart/form-data" style="margin-top: 20px">
                <h1 style="font-size: 18px; font-weight: 500; margin-bottom: 20px;">Отправить аудио-цитату:</h1>
                <!-- <input style="margin-bottom: 20px;" type="text" name="audio-title" placeholder="Автор или название" maxlength="40" required autocomplete="off"> -->
                    <input style="margin-bottom: 20px; padding: 10px; height: auto;" type="file" name="file" required>
                    <button type="submit" name="submit">Отправить</button>
                </form>
                <!-- /upload audio file here-->
                
                <!-- show audio quotes -->
                <?php
                foreach ($notes as $note) : ?>
                    

                    <div class="note" style="margin-bottom: 10px; margin-top: 10px;" id="<?php echo $note['id'] ?>">
                        <div class="title">
                            <form action="delete.php" method="post">
                                <input type="hidden" required name="id" value="<?php echo $note['id'] ?>">
                                <button class="close"></button>
                            </form>
                            <a href="quote.php?id=<?php echo $note['id'] ?>">
                                <?php echo $note['title'] ?>
                            </a>
                        </div>
                        <div class="description">
                            <?php echo $note['description'] ?>
                        </div>
                        <br>
                        <div class="share" >
                            <div class="share-button" style="display: flex;align-items: center;justify-content: space-between;flex-wrap: wrap;flex-direction: row; align-items:center;">        
                                <a title="поделиться" target="_blank" href="https://t.me/share/url?url=https://aksaysquad.infinityfreeapp.com/quote.php?id=<?php echo $note['id']?>"><ion-icon name="share-social-outline"></ion-icon></a>    
                                <small class="date-time"><?php echo date('d/m/Y H:i', strtotime($note['create_date'])) ?></small>    
                            </div>
                        </div>
                         <!--<div class="ajax-vote"> 
                            <p style="font-size:11px;">*ваша оценка:</p>  
                            <div class="vot_mp2" title="Ваша оценка" data-vote_id="<?php echo $note['id'] ?>">
                            </div>
                        </div>-->

                        
                    </div>
                
                <?php endforeach; ?>
                        

            </div>

        </div>





        </div>
    </article>
    <aside class="aside" id="rightdiv" style="position: sticky; top: 10%;">



        <div class="aside-inner">
            <div class="daily-quote">
                <h1>Цитата дня</h1>
                <div class="d-quote-inner">
                    <ion-icon name="chatbox-ellipses-outline"></ion-icon>
                    <?php

                    $file = "quoteToday.txt";

                    $fh = fopen($file, "r");
                    $string = fread($fh, filesize($file));
                    fclose($fh);

                    echo "<p>$string</p>";


                    ?>
                </div>



            </div>
            <div class="social-media-btn">
                <a href="./abmd">
                    <button>Social media</button>
                </a>
            </div>
            
            <div class="discord-widget">
                <h1>discord</h1>
                <!-- <iframe src="https://discord.com/widget?id=731124657603739719&theme=dark" width="280" height="290" allowtransparency="true" frameborder="0" sandbox="allow-popups allow-popups-to-escape-sandbox allow-same-origin allow-scripts"></iframe> -->
            </div>
        </div>




    </aside>
                                            
    </div>
    
    <!-- damir was here -->
</body>
<script src="./js/jquery.js"></script>
<!--web push notification-->
<script>
    pushNotify();
            function pushNotify() {
            	if (!("Notification" in window)) {
            		// checking if the user's browser supports web push Notification
            		alert("Web browser does not support desktop notification");
            	} else if (Notification.permission === "granted") {
            		console.log("Permission to show web push notifications granted.");
            		// if notification permissions is granted,
            		// then create a Notification object
            		createNotification();
            	} else if (Notification.permission !== "denied") {
            		alert("Going to ask for permission to show web push notification");
            		// User should give explicit permission
            		Notification.requestPermission().then((permission) => {
            			// If the user accepts, let's create a notification
            			createNotification();
            		});
            	}
            	// User has not granted to show web push notifications via Browser
            	// Let's honor his decision and not keep pestering anymore
            }

            function createNotification() {
            	var notification = new Notification('Web Push Notification', {
            		icon: 'https://aksaysquad.infinityfreeapp.com/images/Ellipse%201.png',
            		body: 'Новая цитата!',
            	});
            	// url that needs to be opened on clicking the notification
            	// finally everything boils down to click and visits right
            	notification.onclick = function() {
            		window.open('https://aksaysquad.infinityfreeapp.com/');
            	};
            }
</script>
<!--//end web push notification-->

<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
<script src="https://kit.fontawesome.com/977ab4e732.js" crossorigin="anonymous"></script>
<script src="./js/main.js"></script>

</html>