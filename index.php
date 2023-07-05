<?php
date_default_timezone_set("Asia/Oral");
date_default_timezone_set("Asia/Almaty");

/** @var Connection $connection */
$connection = require_once 'pdo.php';
// Read notes from database
$notes = $connection->getNotes();
$audios = $connection->getAudio();
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
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
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
    <link rel="stylesheet" href="label.css">
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
                                <a href="./data">База воспоминаний</a>
                                <a href="./abmd">О сайте/Медиа</a>
                                <a href="./reg">Логин</a>
                            </div>
                        </div>
                        <span class="btn-adaptive"></span>
                        <div class="burger_list">
                            <div class="burger-menu">
                                <div class="nav-links">
                                    <a href="#index">Главная</a>                                 
                                    <a href="./data">База воспоминаний</a>
                                    <a href="./abmd">О сайте/Медиа</a>
                                    <a href="./reg">Логин</a>
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
                <div class="quote-h1" style="width: auto; position: relative;">
                
                    <form id="app-cover">
                    <div id="select-box">
                        <input type="checkbox" id="options-view-button">
                        <div id="select-button" class="brd">
                        <div id="selected-value">
                            <span>Выберите тип цитаты</span>
                        </div>
                        <div id="chevrons">
                            <i class="fas fa-chevron-up"></i>
                            <i class="fas fa-chevron-down"></i>
                        </div>
                        </div>
                        <div id="options">
                        <div class="option" id="spanQuote">
                            <input class="s-c top" type="radio" name="platform" value="Цитаты">
                            <input class="s-c bottom" type="radio" name="platform" value="Цитаты">
                            
                            <span id="spanQuote" class="label">Цитаты</span>
                            <span class="opt-val">Цитаты</span>
                        </div>
                        <div class="option" id="spanAudio">
                            <input class="s-c top" type="radio" name="platform" value="Аудио-цитаты">
                            <input class="s-c bottom" type="radio" name="platform" value="Аудио-цитаты">
                            
                            <span id="spanAudio" class="label">Аудио-цитаты</span>
                            <span class="opt-val">Аудио-цитаты</span>
                        </div>
                        
                        <div id="option-bg"></div>
                        </div>
                    </div>
                    </form>   
                </div>
                <br>




                <form class="rowhide new-note" action="create.php" id="subForm" method="post">
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
                <form class="audio new-note" id="audio" action="upload.php" method="POST" enctype="multipart/form-data" style="margin-top: 20px">
                    <h1 style="font-size: 18px; font-weight: 500; margin-bottom: 20px; color: #fff;">Отправить аудио-цитату:</h1>
                    <input style="margin-bottom: 20px;" type="text" name="name" id = "name" placeholder="Автор или название" maxlength="40" required autocomplete="off"> 
                    <input style="margin-bottom: 20px; padding: 10px; height: auto;" type="file" name="file" required>
                    <button type="submit" name="submit">Отправить</button>
                </form>
                <!-- /upload audio file here-->
                
                <!-- show audio quotes -->
                
                <?php
                        require 'dbConfig.php';
                        date_default_timezone_set("Asia/Almaty");
                        $query = $db->query("SELECT * FROM audios WHERE status = 1 ORDER BY uploaded_on DESC");
                        
                        if($query->num_rows > 0){
                            while($row = $query->fetch_assoc()){
                                $imageThumbURL = 'uploads/thumb/'.$row["file_name"];
                                $imageURL = 'uploads/'.$row["file_name"];
                        ?>
                        <div class="audio note" id="audioQ" style="margin-bottom: 10px; margin-top: 10px;">
                        <div class="title">
                                <input type="hidden" required name="id">
                                <button style="cursor: pointer; margin-bottom: 0; margin-right: 9px;" class="close"></button>
                            <a href="audio.php?id=<?php echo $row['id'] ?>">
                            
                                <?php echo $row['names'] ?>
                                
                            </a>
                        </div>
                        <audio controls>
                            <source src="<?php echo $imageURL; ?>" type="audio/mpeg">
                        </audio>
                        
                        <br>
                        <div class="share" >
                            <div class="share-button" style="display: flex;align-items: center;justify-content: space-between;flex-wrap: wrap;flex-direction: row; align-items:center;">        
                                <a target="_blank" href="audio.php?id=<?php echo $row ['id'] ?>"><ion-icon name="share-social-outline"></ion-icon></a>    
                                <small class="date-time"><?php echo date('d/m/Y', strtotime($row['uploaded_on'])) ?></small>    
                            </div>
                        </div>
                        
                        
                        </div>
                        <?php }
                        } ?>
                        
                 <!--/show audio quotes -->
                <?php
                foreach ($notes as $note) : ?>
                    

                    <div class="rowhide note" id="rowhide" style="margin-bottom: 10px; margin-top: 10px;" id="<?php echo $note['id'] ?>">
                        <div class="title">
                            <form>
                                <input type="hidden" required name="id">
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
                                <a title="Поделиться в телеграмм" target="_blank" href="https://t.me/share/url?url=https://aksaysquad.infinityfreeapp.com/quote.php?id=<?php echo $note['id']?>"><ion-icon name="share-social-outline"></ion-icon></a>    
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
                    <img src="" alt="">
                    <button>GitHub</button>
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
    
</script>
<!--//end web push notification-->

<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
<script src="https://kit.fontawesome.com/977ab4e732.js" crossorigin="anonymous"></script>
<script src="./js/main.js"></script>

</html>