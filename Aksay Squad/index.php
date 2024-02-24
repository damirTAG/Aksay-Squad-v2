<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
date_default_timezone_set("Asia/Almaty");

$scriptStartTime = microtime(true);

/** @var Connection $connection */
$connection = require_once 'pdo.php';
// Read quotes from database


$currentNote = [
    'id' => '',
    'title' => '',
    'description' => ''
];
if (isset($_GET['id'])) {
    $currentNote = $connection->getNoteById($_GET['id']);
}
$currentAudio = [
    'id' => '',
    'title' => '',
    'file_name' => ''
];
if (isset($_GET['id'])) {
    $currentAudio = $connection->getAudioById($_GET['id']);
}

// Pagination & Search
$notesPerPage = 17;
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$totalQuotesCount = $connection->getTotalQuotesCount();
$totalPages = ceil($totalQuotesCount / $notesPerPage);
$offset = ($currentPage - 1) * $notesPerPage;

$searchQuery = isset($_GET['search']) ? $_GET['search'] : '';

if (!empty($searchQuery)) {
    $totalResultsCount = $connection->getTotalResultsCount($searchQuery);
    $totalPages = ceil($totalResultsCount / $notesPerPage);

    if ($totalResultsCount > 0) {
        $notes = $connection->searchQuotesPaginated($searchQuery, $notesPerPage, $offset);
    } else {
        echo "<script>console.log('No results found')</script>";
    }
} else {
    $totalQuotesCount = $connection->getTotalQuotesCount();
    $totalPages = ceil($totalQuotesCount / $notesPerPage);
    $notes = $connection->getNotesPaginated($notesPerPage, $offset);
}

// function getQuoteOfTheDay($connection) {
//     $sql = "SELECT description AS 'Quote of the Day', title FROM quotes ORDER BY RAND() LIMIT 1;";
//     $stmt = $connection->pdo->prepare($sql);
//     $stmt->execute();

//     $result = $stmt->fetch(PDO::FETCH_ASSOC);

//     if ($result) {
//         return $result;
//     } else {
//         return "No quotes available.";
//     }
// }

// $quoteOfTheDay = getQuoteOfTheDay($connection);

// if ($quoteOfTheDay !== "No quotes available.") {
//     $description = $quoteOfTheDay['Quote of the Day'];
//     $author = $quoteOfTheDay['title'];
// } else {
//     $description = "No quotes available.";
//     $author = 'No quote author available';
// }

function getFormattedDate($date) {
    $today = strtotime(date('Y-m-d'));
    $dateToCheck = strtotime(date('Y-m-d', strtotime($date)));

    if ($today == $dateToCheck) {
        return 'сегодня в ' . date('H:i', strtotime($date));
    } elseif ($today - $dateToCheck == 86400) {
        return 'вчера в ' . date('H:i', strtotime($date));
    } else {
        setlocale(LC_TIME, 'ru_RU.UTF-8');

        $russianMonths = array(
            'января', 'февраля', 'марта', 'апреля', 'мая', 'июня',
            'июля', 'августа', 'сентября', 'октября', 'ноября', 'декабря'
        );

        
        return strftime('%e ', strtotime($date)) . $russianMonths[date('n', strtotime($date)) - 1] . strftime(' %Y в %H:%M', strtotime($date));
    }
}
$scriptEndTime = microtime(true);
$scriptExecutionTime = $scriptEndTime - $scriptStartTime;

$usedMemory = memory_get_usage(true) / (1024 * 1024);

// mysqli_query($connection, "SET CHARACTER SET 'utf8'");
?>

<!DOCTYPE html>
<!--
Pet Project 
Author: github.com/damirTAG
for more information: github.com/damirTAG/Aksay-Squad-v2
-->
<html lang="ru">

<head>
    <meta charset="UTF-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="цитаты, база воспоминаний, о сайте, feedback" />
    <meta name="keywords" content="цитаты, база воспоминаний, о сайте, feedback" />
    <!-- <meta name="robots" content="index, follow" /> -->
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"
    integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ="
    crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./style.css">
    <link rel="stylesheet" href="label.css">
    <link rel="canonical" href="https://aksaysquad.infinityfreeapp.com" />
    <link rel="shortcut icon" href="./images/Ellipse 1.png" type="image/x-icon" />
    <link rel="shortcut icon" href="./images/Ellipse 1.png" type="image/jpg" />
    <style>
    @media only screen and (max-width: 500px) {
        .quote .note {
            width: 100%;
        }
        .quote .quote-h1 {
            height: 60px;
        }
    }
    /* Add this CSS to your stylesheet */
    .like-button.clicked ion-icon {
        color: yellow;
        animation: like-animation 0.5s;
    }

    .dislike-button.clicked ion-icon {
        color: white;
        animation: dislike-animation 0.5s;
    }

    @keyframes like-animation {
        0% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.2);
        }
        100% {
            transform: scale(1);
        }
    }

    @keyframes dislike-animation {
        0% {
            transform: scale(1);
        }
        50% {
            transform: scale(0.8);
        }
        100% {
            transform: scale(1);
        }
    }

    /* search */
    .search-form {
        width: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .search-input {
        background-color: #16171b;
        padding: 8px;
        border-radius: 5px 0 0 5px;
        border: none;
        width: 100%;
    }

    .search-button {
        padding: 8px 15px;
        border: none;
        background: #ffe601;
        color: #292929;
        border-radius: 0 5px 5px 0;
        cursor: pointer;
    }
  </style>   
    <title>Aksay Squad</title>
</head>

<body id="index">
<div class='wrapper'>
    <div id='snow-container'>
    </div>
        <div class="container">
            <div id="topBtn" title="вверх" onclick="slowScroll('#index'); topFunction()">
                <ion-icon title="вверх" name="arrow-up"></ion-icon>
            </div>
        </div>
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
                                                    <b id='author-phone'>Вадим</b>
                                                    <br />
                                                    <span id='quote-text-phone'>бля встретимся же как нибудь армат, я тебе кириешку в жопу засуну</span>
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
                    <!-- <button onclick="toggleFocusMode()" class="focus-button">
                        <ion-icon name="moon-outline"></ion-icon>
                        <span>Включить фокус-режим</span>
                    </button> -->
                    <form class="rowhide new-note" action="create" id="subForm" method="post" style="margin-top: 0;"><p style="color:#fff;">Защита от ботов:</p>
                        <div class="captcha">
                            <label id="ebcaptchatext" style="color:#fff;"></label>
                            <input type="text" placeholder="Ответ" maxlength="2" class="text__box" id="ebcaptchainput" />
                        </div>
                        <input type="hidden" name="id" value="<?php echo $currentNote['id'] ?>">
                        <input type="text" name="title" placeholder="Автор" maxlength="50" required autocomplete="off" value="<?php echo $currentNote['title'] ?>">
                        <textarea name="description" cols="30" rows="4" placeholder="Цитата" required maxlength="600" wrap="soft"><?php echo $currentNote['description'] ?></textarea>
                        <br>
                        <!-- и помните Марат подслушает!    -->
                        <button type="submit" name=“Submit” style="margin-top:20px;">

                            <?php if ($currentNote['id']) : ?>
                                Обновить
                            <?php else : ?>
                                Отправить
                            <?php endif ?>
                        </button>
                    </form>
                    <!-- no more audio quotes until it will be popular -->
                    <div class="quote-h1" style="width: auto; position: relative; margin-bottom: 0; margin-top: 10px;">
                        <form id="searchForm" action="" method="GET" class="search-form">
                            <input type="text" placeholder="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : 'Поиск...'; ?>" name="search" class="search-input" id="searchInput">
                            <button type="submit" class="search-button"><i class="fa fa-search"></i></button>
                        </form>
                    </div>
                    
                    <?php 
                    if(isset($notes) && is_array($notes) && count($notes) > 0) {
                        foreach ($notes as $note) : ?>
                        

                        <div class="rowhide note" id="rowhide" style="margin-bottom: 10px; margin-top: 10px;" id="<?php echo $note['id'] ?>">
                            <div class="title">
                                <form>
                                    <input type="hidden" required name="id">
                                    <button class="close"></button>
                                </form>
                                <a href="quote?id=<?php echo $note['id'] ?>">
                                    <?php echo htmlspecialchars($note['title']) ?>
                                </a>
                            </div>
                            <div class="description">
                                <?php echo htmlspecialchars($note['description']) ?>
                            </div>
                            <br>
                            <div class="user_action" style="display: flex; flex-wrap: wrap;">
                                <!-- Like button -->
                                <button class="like-button" style="color: #fff; background: transparent; border: none; cursor: pointer; font-size: 21px" onclick="refreshPage()" data-id="<?php echo $note['id'] ?>" data-action="like"><ion-icon name="thumbs-up"></ion-icon></button>
                                <span class="like-count"><?php echo $note['likes'] ?></span>
                                
                                <!-- Dislike button -->
                                <button class="dislike-button" style="color: #fff; background: transparent; border: none; cursor: pointer; font-size: 21px" onclick="refreshPage()" data-id="<?php echo $note['id'] ?>" data-action="dislike"><ion-icon name="thumbs-down"></ion-icon></button>
                                <span class="dislike-count"><?php echo $note['dislikes'] ?></span>
                                <div class="share" style="margin-left: 10px">
                                    <div class="share-button" style="display: flex;align-items: center;justify-content: space-between;flex-wrap: wrap;flex-direction: row; align-items:center;">        
                                        <a title="Поделиться в телеграмм" target="_blank" href="https://t.me/share/url?url=https://aksaysquad.infinityfreeapp.com/quote?id=<?php echo $note['id']?>" style="font-size: 21px;"><ion-icon name="share-social-outline"></ion-icon></a>    
                                            
                                    </div>
                                </div>
                            </div>
                            <small class="date-time">
    <?php echo getFormattedDate($note['create_date']); ?> |  
    <?php 
        if ($note['updated_at'] !== null) {
            echo "Обновлено " . getFormattedDate($note['updated_at']) . " by ". $note['updated_by'];
        } else {
            echo "Не обновлялось";
        }
    ?>
</small>

                            <!--<div class="ajax-vote"> 
                                <p style="font-size:11px;">*ваша оценка:</p>  
                                <div class="vot_mp2" title="Ваша оценка" data-vote_id="<?php echo $note['id'] ?>">
                                </div>
                            </div>-->

                            
                        </div>
                    
                    <?php endforeach; 
                } else {
                    ?>
                      <div class="not-found" style='display: flex; background-color: #202125; margin-top: 10px; padding: 10px'>
                        <p style='color: #fff;'>Ничего не нашлось | </p><h3 style='color: #fff; margin-left: 7px'><?php echo htmlspecialchars($searchQuery); ?></h3>
                    </div>
                <?php } ?>      

                </div>
                <style>
                        /* pagination style */
                        .pagination {
                            margin-top: 20px;
                            display: flex;
                            list-style: none;
                            justify-content: center;
                            flex-wrap: wrap;
                        }

                        .pagination a {
                            color: #fff;
                            padding: 8px 16px;
                            text-decoration: none;
                            background-color: #333;
                            border-radius: 5px;
                            margin: 0 4px 8px 0;
                            transition: background-color 0.3s;
                        }

                        .pagination a.active {
                            background-color: yellow;
                            color: #333;
                        }

                        .pagination a:hover {
                            background-color: #555;
                        }
                    </style>

                    <div class="pagination">
                        <?php if ($currentPage > 1 && $totalPages > 0) : ?>
                            <?php if (!empty($searchQuery)) : ?>
                                <a href="?page=1&search=<?php echo urlencode($searchQuery); ?>">&laquo; First</a>
                            <?php else : ?>
                                <a href="?page=1">&laquo; First</a>
                            <?php endif; ?>
                        <?php endif; ?>

                        <?php for ($page = 1; $page <= $totalPages; $page++) : ?>
                            <?php if (!empty($searchQuery)) : ?>
                                <a href="?page=<?php echo $page; ?>&search=<?php echo urlencode($searchQuery); ?>" <?php if ($page == $currentPage) echo 'class="active"'; ?>><?php echo $page; ?></a>
                            <?php else : ?>
                                <a href="?page=<?php echo $page; ?>" <?php if ($page == $currentPage) echo 'class="active"'; ?>><?php echo $page; ?></a>
                            <?php endif; ?>
                        <?php endfor; ?>

                        <?php if ($currentPage < $totalPages && $totalPages > 0) : ?>
                            <?php if (!empty($searchQuery)) : ?>
                                <a href="?page=<?php echo $totalPages; ?>&search=<?php echo urlencode($searchQuery); ?>">Last &raquo;</a>
                            <?php else : ?>
                                <a href="?page=<?php echo $totalPages; ?>">Last &raquo;</a>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
            </div>





            </div>
        </article>
        <aside class="aside" id="rightdiv" style="position: sticky; top: 10%;">



            <div class="aside-inner">
                <div class="daily-quote">
                    <h1>цитата дня</h1>
                    <div class="d-quote-inner">
                        <ion-icon name="chatbox-ellipses-outline"></ion-icon>
                        <p>
                            <b id='author'>Вадим</b>
                            <br />
                            <span id='quote-text'>бля встретимся же как нибудь армат, я тебе кириешку в жопу засуну</span>
                        </p>
                    </div>



                </div>
                <div class="social-media-btn">
                    <button>
                        <a target="_blank" href="https://github.com/damirTAG/Aksay-Squad-v2">GitHub</a>
                    </button>
                </div>
                
                <div class="discord-widget">
                    <h1>discord</h1>
                    <iframe src="https://discord.com/widget?id=731124657603739719&theme=dark" width="280" height="290" allowtransparency="true" frameborder="0" sandbox="allow-popups allow-popups-to-escape-sandbox allow-same-origin allow-scripts"></iframe>
                </div>
            </div>




        </aside>
                                                
        </div>
    
    <!-- damir was here -->
    
    </div>
</body>
<script src="./js/jquery.js"></script>
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
<script src="https://kit.fontawesome.com/977ab4e732.js" crossorigin="anonymous"></script>
<script src="./js/main.js"></script>
<script crossorigin="anonymous">
function fetchRandomQuote() {
    fetch('fetch_quote.php')
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                console.error(data.error);
            } else {
                document.getElementById('quote-text-phone').textContent = data.quote['Quote of the Day'];
                document.getElementById('author-phone').textContent = data.quote.title;
                document.getElementById('quote-text').textContent = data.quote['Quote of the Day'];
                document.getElementById('author').textContent = data.quote.title;
            }
        })
        .catch(error => console.error('Fetch error:', error));
}

function refreshQuoteDaily() {
    const now = new Date();

    const timeUntilMidnight = new Date(
        now.getFullYear(),
        now.getMonth(),
        now.getDate() + 1, 
        0, 0, 0, 0
    ) - now;

    setTimeout(() => {
        fetchRandomQuote();
        setInterval(fetchRandomQuote, 24 * 60 * 60 * 1000);
    }, timeUntilMidnight);
}

refreshQuoteDaily();
</script>
<!-- снежок (хоть на сайте будет, а то в алмате нету) -->
<script src="./js/snowfall.js"></script>
</html>
<?php
echo "<!-- Время выполнения скрипта: {$scriptExecutionTime} секунд -->";
echo "<!-- Затрачено оперативной памяти: {$usedMemory} MB -->";
?>