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
    <meta name="robots" content="index, follow" />
    <script src="./voting_mp/voting.js" type="text/javascript"></script>
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
                            <a href="/" class="logo" style="text-decoration: none; cursor: pointer">
                            <img src="./images/logo.webp" alt="logoas" style="width: 50px; height:50px;">     
                            <h1 style="font-weight: 400;font-size: 21px;line-height: 26px;">/aksaysquad</h1>                       
                            </a>                            
                        </div>
                    <nav class="nav">
                        
                        <div class="openMenu"><ion-icon name="menu-outline"></ion-icon></div>
                        <div class="burger-menu">
                            <div class="nav-links">
                                <a href="#">Главная</a>
                                <a href="./poll">Опросы</a>
                                <a href="./data">База воспоминаний</a>
                                <a href="#">О сайте/Медиа</a>
                                <div class="closeMenu"><ion-icon name="close-outline"></ion-icon></div>
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

<article>
<div class="container">

    

    <div class="quote" style="display: flex;
    flex-wrap: wrap;
    flex-direction: column;
    align-content: center;
    justify-content: center;">
<div class="quote-h1">
        <h1>Оставить 
            цитату            
        </h1>
        <div class="search-bar">
            <form method="POST" action="index.php" style="margin: 0;">
            <input type="text" id="search" autocomplete="off" style="color:#fff;" value="<?php echo isset($_POST['keyword']) ? $_POST['keyword'] : '' ?>" name="keyword"  placeholder="Поиск"/>
            <button class="search-btn" name="search"><ion-icon name="search"></ion-icon></button>
            </form>
        </div> 
</div>
        <br>
              
  
                
    
    <form class="new-note" action="create.php" id="subForm" method="post">
    <input type="hidden" name="id" value="<?php echo $currentNote['id'] ?>">
    <input type="text" name="title" placeholder="Автор" maxlength="50" required autocomplete="off"
        value="<?php echo $currentNote['title'] ?>">
    <textarea name="description" cols="30" rows="4"
            placeholder="Цитата" required maxlength="600"><?php echo $currentNote['description'] ?></textarea>
            <p style="color:#fff;">Защита от ботов:</p>
            <div class="captcha">       
            <label id="ebcaptchatext" style="color:#fff;"></label>
            <input type="text" placeholder="Ответ" maxlength="2" class="text__box" id="ebcaptchainput"/>
            </div>
            

    <button type="submit" style="margin-top:20px;">
        
        <?php if ($currentNote['id']): ?>
            Обновить
        <?php else: ?>
            Отправить
        <?php endif ?>
    </button>
    </form>
    <?php
				if(ISSET($_POST['search'])){
					$keyword = $_POST['keyword'];
			?>
			<div>
				<h2 style="color:#fff;">Результат:</h2>
				<hr  />
				<?php
					require 'conn.php';
					$query = mysqli_query($conn, "SELECT * FROM `quotes` WHERE `title` LIKE '%$keyword%' ORDER BY `title`") or die(mysqli_error());
					while($fetch = mysqli_fetch_array($query)){
				?>
                
           
				<div class="note">
                    <div class="title">
                    <form action="delete.php" method="post">
                            <input type="hidden" required name="id" value="<?php echo $fetch['id'] ?>">
                            <button class="close"></button>
                        </form>
					<a href="?id=<?php echo $fetch['id'] ?>"><?php echo $fetch['title']?></a>
                    </div>
                     <div class="description">
                     <?php echo substr($fetch['description'], 0, 100)?>...
                     </div>   
                     <div class="vot_mp2" data-vote_id="<?php echo $fetch['id'] ?>"></div>
                    <small class="date-time"><?php echo date('d/m/Y H:i', strtotime($fetch['create_date'])) ?></small>
				</div>
				<hr  />
				<?php
					}
				?>
			</div>
			<?php
				}
			?>
                 
             

                <?php 
                    foreach ($notes as $note): ?>
                    
                
                    <div class="note" style="margin-bottom: 10px; margin-top: 10px;">       
                        <div class="title">
                        <form action="delete.php" method="post">
                            <input type="hidden" required name="id" value="<?php echo $note['id'] ?>">
                            <button class="close"></button>
                        </form>
                            <a href="?id=<?php echo $note['id'] ?>">
                                <?php echo $note['title'] ?>
                            </a>
                        </div>
                        <div class="description">
                            <?php echo $note['description'] ?>
                        </div>
                        <br>
                        <div class="ajax-vote">
                            <!-- <p style="font-size:11px;">*ваша оценка:</p>  -->
                            <div class="vot_mp2" title="Ваша оценка" data-vote_id="<?php echo $note['id'] ?>">
                            </div>
                        </div>
                        
                        <small class="date-time"><?php echo date('d/m/Y H:i', strtotime($note['create_date'])) ?></small>   
                                                               
                    </div>   
                                    
                <?php endforeach; ?> 
                
                             
                </div>   
                             
        </div> 
              
    
    
      
    
    </div> 
</article>        
<aside class="aside" style="position: sticky; top: 0;">
                        

                        
    <div class="aside-inner" id="aside" style="position: sticky;
        top: 0;">
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
        <a href="">
            <button>Social media</button></a>
    </div>
    <div class="discord-widget">
        <h1>discord</h1>
        <iframe src="https://discord.com/widget?id=731124657603739719&theme=dark" width="280" height="290" allowtransparency="true" frameborder="0" sandbox="allow-popups allow-popups-to-escape-sandbox allow-same-origin allow-scripts"></iframe>
    </div>
    </div>
    
    

    
</aside>

</body>
<script src="./js/jquery.js"></script>
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
<script src="https://kit.fontawesome.com/977ab4e732.js" crossorigin="anonymous"></script>
<script src="./js/main.js"></script>
</html>