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
    <meta property="og:title" content="Цитата из Aksay Squad website" />
    <meta property="og:type" content="чекайте цитату <?php echo $currentNote['title'] ?>а" />
    <meta property="og:url" content="https://aksaysquad.infinityfreeapp.com/quote.php?id=<?php echo $currentNote['id'] ?>" />
    <!-- <meta name="robots" content="index, follow" /> -->
    <!-- <script src="./voting_mp/voting.js" type="text/javascript"></script> -->
    <link rel="stylesheet" href="style.css">
    <link rel="canonical" href="https://aksaysquad.infinityfreeapp.com" />
    <link rel="shortcut icon" href="./images/Ellipse 1.png" type="image/x-icon" />
    <link rel="shortcut icon" href="./images/Ellipse 1.png" type="image/jpg" />
    <!-- <link href="./voting_mp/voting.css" rel="stylesheet" type="text/css" /> -->
    <style>
        .header{
            position: relative;
        }
        .quote .note{
            width: auto;
        }
        h1{
            color:#fff;
        }
        .quote-text{
            border-radius: 10px;
            background: #202125;
            padding: 10px;
        }
        .footer{
            position: fixed;
            bottom: 0;
            width: 100%;
            
        }
    </style>
    <title>Цитата #<?php echo $currentNote['id'] ?></title>
    
</head>

<body id="index">
    <div class="container">
        <div id="topBtn" title="вверх" onclick="slowScroll('#index'); topFunction()">
            <ion-icon title="вверх" name="arrow-up"></ion-icon>
        </div>
    </div>
    <!-- хедер -->
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
                        </div>
                    </div>


                </nav>
            </div>
        </div>
    </header>
    <!-- /хедер -->
    <!-- цитата -->

                <div class="container">
                <div class="quote-text">
                    <h1>Цитата номер <?php echo $currentNote['id'] ?></h1>
                </div>
                 <div class="quote">
                    <div class="note" style="margin-bottom: 10px; margin-top: 10px;">
                        <div class="title">
                            <form>
                                <input type="hidden" required name="id" value="<?php echo $currentNote['id'] ?>">
                                <button class="close"></button>
                            </form>
                            <a>
                                <?php echo $currentNote['title'] ?>
                            </a>
                        </div>
                        <div class="description">
                        <?php echo $currentNote['description'] ?>
                        </div>
                        <br>
                        <div class="share" style="display: flex;">
                            <div style="display: flex; align-items: center;" class="share-button">        
                                <a target="_blank" href="https://t.me/share/url?url=https://aksaysquad.infinityfreeapp.com/quote.php?id=<?php echo $currentNote['id'] ?>&text=">поделиться</a>        
                            </div>
                        </div>
                         <!--<div class="ajax-vote">
                            < <p style="font-size:11px;">*ваша оценка:</p>
                            <div class="vot_mp2" title="Ваша оценка" data-vote_id="<?php echo $note['id'] ?>">
                            </div>
                        </div> -->
 
                        <small class="date-time"><?php echo date('d/m/Y H:i', strtotime($currentNote['create_date'])) ?></small>
                       
                    </div>

                    </div>
                  
                
                </div>
                    
                    
                <!-- цитата -->
                    <!-- damir was here -->
                     <!-- подвал -->
        <footer class="footer" id="footer">
            <div class="container">
                <div class="footer-inner">
                    <div class="footer-title marquee">
                        <ul class="footer-flip-anime">
                            <li>Расход.</li>
                            <li><span id="year"></span></li>
                            <li>/aksaysquad®</li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>
        <!-- /подвал -->
</body>
<script src="./js/jquery.js"></script>
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
<script src="https://kit.fontawesome.com/977ab4e732.js" crossorigin="anonymous"></script>
<script src="./js/main.js"></script>

</html>