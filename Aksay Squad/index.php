<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
date_default_timezone_set("Asia/Almaty");

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


$notesPerPage = 10;
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

// Quote of the day
function get_quote_of_the_day($connection, $totalQuotesCount) {
    mt_srand(date('dmY'));
    $displayno = mt_rand(1, $totalQuotesCount);

    $statement = $connection->pdo->prepare("SELECT description, title FROM quotes LIMIT :displayno, 1");
    $statement->bindParam(':displayno', $displayno, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetch(PDO::FETCH_ASSOC);
}

$quoteData = get_quote_of_the_day($connection, $totalQuotesCount);
// echo "Quote of the day: " . $quoteData['description'] . " - " . $quoteData['title'];


function getFormattedDate($date) {
    $today = strtotime(date('Y-m-d'));
    $dateToCheck = strtotime(date('Y-m-d', strtotime($date)));

    if ($today - $dateToCheck == 86400) { // 86400 секунд в одном дне
        return 'Вчера в ' . date('H:i', strtotime($date));
    } else {
        setlocale(LC_TIME, 'ru_RU.UTF-8'); // Устанавливаем локаль на русский

        $englishMonths = array(
            'January', 'February', 'March', 'April', 'May', 'June',
            'July', 'August', 'September', 'October', 'November', 'December'
        );

        $russianMonths = array(
            'Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь',
            'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'
        );

        // Форматируем дату с учётом локали и переводим месяц на русский
        return strftime('%e ', strtotime($date)) . $russianMonths[date('n', strtotime($date)) - 1] . strftime(' %Y в %H:%M', strtotime($date));
    }
}

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
    <meta name="description" content="AKSAY SQUAD OFFICIAL SITE" />
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
        background: #FFD700;
        color: #292929;
        border-radius: 0 5px 5px 0;
        cursor: pointer;
    }
  </style>   
    <title>Aksay Squad</title>
</head>

<body id="index">
<div class='wrapper'>
    <div id="snow-container"></div>
    <div class="container">
        
        <div id="topBtn" title="вверх" onclick="slowScroll('#index'); topFunction()">
            <ion-icon title="вверх" name="arrow-up"></ion-icon>
        </div>
    </div>

    <?php require_once 'templates/header.php'; ?>

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
                
                <br>




                <form class="rowhide new-note" action="create.php" id="subForm" method="post" style="margin-top: 0;">
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
                <div class="quote-h1" style="width: auto; position: relative; margin-bottom: 0; margin-top: 10px;">
                    <form action="index.php" method="GET" class="search-form">
                        <input type="text" placeholder="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : 'Поиск...'; ?>" name="search" class="search-input">
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
                                    <a href="quote.php?id=<?php echo $note['id'] ?>">
                                        <?php echo $note['title'] ?>
                                    </a>
                                </div>
                                <div class="description">
                                    <?php echo $note['description'] ?>
                                </div>
                                <br>
                                <div class="user_action" style="display: flex; flex-wrap: wrap;">
                                    <!-- Like button -->
                                    <button class="like-button" style="color: #fff; background: transparent; border: none;" onclick="refreshPage()" data-id="<?php echo $note['id'] ?>" data-action="like"><ion-icon name="thumbs-up"></ion-icon></button>
                                    <span class="like-count"><?php echo $note['likes'] ?></span>
                                    
                                    <!-- Dislike button -->
                                    <button class="dislike-button" style="color: #fff; background: transparent; border: none;" onclick="refreshPage()" data-id="<?php echo $note['id'] ?>" data-action="dislike"><ion-icon name="thumbs-down"></ion-icon></button>
                                    <span class="dislike-count"><?php echo $note['dislikes'] ?></span>
                                    <div class="share" >
                                        <div class="share-button" style="display: flex;align-items: center;justify-content: space-between;flex-wrap: wrap;flex-direction: row; align-items:center;">        
                                            <a title="Поделиться в телеграмм" target="_blank" href="https://t.me/share/url?url=https://aksaysquad.infinityfreeapp.com/quote.php?id=<?php echo $note['id']?>"><ion-icon name="share-social-outline"></ion-icon></a>    
                                                
                                        </div>
                                    </div>
                                </div>
                                <small class="date-time"><?php echo getFormattedDate($note['create_date']); ?></small>
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

        </div>
        




        </div>
    </article>
    <aside class="aside" id="rightdiv" style="position: sticky; top: 10%;">



        <div class="aside-inner">
            <div class="daily-quote">
                <h1>цитата дня</h1>
                <div class="d-quote-inner">
                    <ion-icon name="chatbox-ellipses-outline"></ion-icon>
                    <p><b><?php echo $quoteData['title'] ?></b><?php echo $quoteData['description'] ?></p>
                </div>



            </div>
            <div class="social-media-btn">
                <button>
                    <a target="_blank" href="https://github.com/damirTAG">GitHub</a>
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
    
</body>
<script src="./js/jquery.js"></script>
<script>
//кнопка отступа
// const textarea = document.getElementById('quote-textarea');

// const btn = document.getElementById('enter-btn');


// btn.addEventListener('click', function handleClick() {
//   textarea.value += ' <br /> ';
// });
// end кнопка отступа

// likes and dislikes


$(document).ready(function() {
    // Animation for like button
    $(".like-button").click(function() {
        var $likeButton = $(this);
        var $likeCount = $likeButton.siblings('.like-count');
        var quoteId = $likeButton.data('id');

        $.ajax({
            url: 'update_likes.php',
            type: 'POST',
            data: { id: quoteId, action: 'like' },
            success: function(response) {
                $likeCount.text(response);

                // Add animation class for the like button
                $likeButton.addClass("clicked");
                setTimeout(function() {
                    $likeButton.removeClass("clicked");
                }, 500);
            }
        });
    });

    // Animation for dislike button
    $(".dislike-button").click(function() {
        var $dislikeButton = $(this);
        var $dislikeCount = $dislikeButton.siblings('.dislike-count');
        var quoteId = $dislikeButton.data('id');

        $.ajax({
            url: 'update_likes.php',
            type: 'POST',
            data: { id: quoteId, action: 'dislike' },
            success: function(response) {
                $dislikeCount.text(response);

                // Add animation class for the dislike button
                $dislikeButton.addClass("clicked");
                setTimeout(function() {
                    $dislikeButton.removeClass("clicked");
                }, 500);
            }
        });
    });
});

function refreshPage() {
    setTimeout(function() {
        location.reload(); // Reload the current page
    }, 500); // Delay in milliseconds (1.6 seconds)
}

</script>
<!--web push notification
<script>
    
</script>
//end web push notification-->
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
<script src="https://kit.fontawesome.com/977ab4e732.js" crossorigin="anonymous"></script>
<script src="./js/main.js"></script>
<script src="./js/snowfall.js"></script>
</html>