<?php

echo "<link rel='stylesheet' href='./style.css'>";
date_default_timezone_set("Asia/Oral");
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
    <link rel="stylesheet" href="./style.css">
    <link rel="canonical" href="https://domain.com/" />
    <link rel="shortcut icon" href="../images/Ellipse 1.png" type="image/x-icon" />
    <link rel="shortcut icon" href="../images/Ellipse 1.png" type="image/jpg" />
    <title>Aksay Squad</title>
</head>
<body>
        <header class="header" style="backdrop-filter: none">
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
            
            <!-- <div class="bg-vector-right">
            <svg width="245" height="418" viewBox="0 0 245 418" fill="none" xmlns="http://www.w3.org/2000/svg">
            <g filter="url(#filter0_d_28_10)">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M426.485 182.756C426.949 241.702 366.568 279.076 320.566 316.044C286.939 343.066 246.192 350.05 204.488 361.157C150.164 375.625 86.4386 427.138 44.7437 389.503C2.49461 351.369 45.6869 281.866 54.362 225.652C59.6978 191.076 71.4912 161.729 84.8836 129.398C108.031 73.5178 102.629 -7.807 159.586 -28.3698C216.647 -48.9697 270.887 7.47374 318.431 45.0826C366.013 82.7214 426.008 122.139 426.485 182.756Z" fill="#FFE601"/>
            </g>
            <defs>
            <filter id="filter0_d_28_10" x="0.500977" y="-57.7644" width="439.987" height="475.762" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
            <feFlood flood-opacity="0" result="BackgroundImageFix"/>
            <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
            <feOffset dx="-6" dy="-5"/>
            <feGaussianBlur stdDeviation="10"/>
            <feComposite in2="hardAlpha" operator="out"/>
            <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.25 0"/>
            <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_28_10"/>
            <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_28_10" result="shape"/>
            </filter>
            </defs>
            </svg>
            </div>
            <div class="bg-vector-left">
            <svg width="452" height="534" viewBox="0 0 452 534" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g filter="url(#filter0_d_27_6)">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M102.611 18.8461C144.247 37.4109 162.488 83.3888 195.488 114.579C223.901 141.435 255.875 161.074 282.921 189.27C327.799 236.055 414.388 270.5 406.261 334.309C398.482 395.389 306.05 401.283 252.007 431.99C211.963 454.742 176.395 490.257 130.147 491.193C86.0551 492.086 53.9498 452.286 12.6854 436.835C-29.0743 421.197 -78.7568 428.171 -113.184 400.075C-151.479 368.824 -186.594 323.936 -185.644 274.981C-184.699 226.268 -129.339 197.976 -108.408 153.89C-85.0003 104.587 -102.503 31.9794 -56.2063 2.35115C-10.6882 -26.7786 53.0715 -3.24321 102.611 18.8461Z" fill="#FFE601"/>
                </g>
                <defs>
                <filter id="filter0_d_27_6" x="-185.663" y="-11.2277" width="637.458" height="544.435" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                <feOffset dx="25" dy="22"/>
                <feGaussianBlur stdDeviation="10"/>
                <feComposite in2="hardAlpha" operator="out"/>
                <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.25 0"/>
                <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_27_6"/>
                <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_27_6" result="shape"/>
                </filter>
                </defs>
                </svg>
            </div> -->
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

    <section>

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
            <input type="text" id="search" value="<?php echo isset($_POST['keyword']) ? $_POST['keyword'] : '' ?>" name="keyword"  placeholder="Поиск"/>
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

            <label id="ebcaptchatext" style="color:#fff;"></label>
            <input type="text" class="text__box" id="ebcaptchainput"/>

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
				<h2 style="color:fff;">Результат:</h2>
				<hr />
				<?php
					require 'conn.php';
					$query = mysqli_query($conn, "SELECT * FROM `quotes` WHERE `title` LIKE '%$keyword%' ORDER BY `title`") or die(mysqli_error());
					while($fetch = mysqli_fetch_array($query)){
				?>
				<div class="note">
                    <div class="title">
                    <form action="delete.php" method="post">
                            <input type="hidden" required name="id" value="<?php echo $note['id'] ?>">
                            <button class="close"></button>
                        </form>
					<a href="#"><?php echo $fetch['title']?></a>
                    </div>
                     <div class="description">
                     <?php echo substr($fetch['description'], 0, 100)?>...
                     </div>   
					
                    <small class="date-time"><?php echo date('d/m/Y H:i', strtotime($fetch['create_date'])) ?></small>
				</div>
				<hr />
				<?php
					}
				?>
			</div>
			<?php
				}
			?>
            
        
                <?php 
                    foreach ($notes as $note): ?>   
                    <div class="note" style="margin-bottom: 10px;
                    margin-top: 10px;">       
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
                        <small class="date-time"><?php echo date('d/m/Y H:i', strtotime($note['create_date'])) ?></small>
                        
                    </div>
                    
                <?php endforeach; ?>
                
                </div>

        </div> 
                
    
    
    </section>  
    </div> 
</article>        
<aside class="aside" style="position: sticky; top: 0;">

    <div class="aside-inner" id="aside" style="position: sticky;
        top: 0;">
    <div class="daily-quote">
        <h1>Цитата дня</h1>

            <p id="quotes"></p>
            <p id="author"></p>
       
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
<script src="./js/main.js"></script>
</html>
