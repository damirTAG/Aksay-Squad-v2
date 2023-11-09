<?php 
date_default_timezone_set("Asia/Oral");
date_default_timezone_set("Asia/Almaty");
echo "<link rel='stylesheet' href='./css/style.css'>";
echo "<link rel='stylesheet' href='../style.css'>";
echo "<link rel='stylesheet' href='./css/lightbox.css'>";
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
    <link rel="stylesheet" href="./css/style.css" />
    <link rel="stylesheet" href="../style.css">
    <link rel="canonical" href="https://aksaysquad.infinityfreeapp.com" />
    <link rel="shortcut icon" href="../images/Ellipse 1.png" type="image/x-icon" />
    <link rel="shortcut icon" href="../images/Ellipse 1.png" type="image/jpg" />
    <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css"
    />  
    <title>Aksay Squad</title>
</head>
<body>
    <!-- хедер -->
    <header class="header">
            <div class="container">
                <div class="header-inner">
                    <div class="logo">
                        <a href="/" class="logo" style="text-decoration: none; cursor: pointer">
                            <img src="../images/logo.webp" alt="logoas" style="width: 50px; height: 50px" />
                            <h1 style="font-weight: 400; font-size: 21px; line-height: 26px">/aksaysquad</h1>
                        </a>
                    </div>
                    <nav class="nav">
                        <div class="header_burger">
                            <span class="btn-adaptive"></span>
                            <div class="burger_list"></div>
                        </div>
                        <div class="openMenu"><ion-icon name="menu-outline"></ion-icon></div>
                        <div class="burger-menu">
                            <div class="nav-links">
                                <a href="../index.php">Главная</a>
                                <a href="../poll">Опросы</a>
                                <a href="../data">База воспоминаний</a>
                                <a href="#">О сайте/Медиа</a>

                                <div class="closeMenu"><ion-icon name="close-outline"></ion-icon></div>
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
        </header>
        <!-- /хедер -->
        <!-- welcome page -->
        <div class="welcome">
            <div class="welcome-inner">
                <div class="container">
                    some text
                </div>
            </div>
        </div>
        <!-- /welcome page -->
        <div class="memesupload">
            <div class="container">
            <div class="memes-inner">
                <!-- форма отправки -->
                <div class="form">
                    <div class="form-inner">
                    <form action="upload.php" method="post" enctype="multipart/form-data">
                    <h1>Select File to Upload:</h1>
                    <input type="file" name="file">
                    <input type="submit" name="submit" value="Upload">
                    </form>
                    </div>
                </div>
        <!-- /форма отправки -->
        <!-- мемы секшн -->
            <div class="gallery">
            <?php
                require 'dbConfig.php';

                $query = $db->query("SELECT * FROM images WHERE status = 1 ORDER BY uploaded_on DESC");
                
                if($query->num_rows > 0){
                    while($row = $query->fetch_assoc()){
                        $imageThumbURL = 'uploads/thumb/'.$row["file_name"];
                        $imageURL = 'uploads/'.$row["file_name"];
                ?>
                    <a href="<?php echo $imageURL; ?>" data-lightbox="memes" target="_blank" data-title="<?php echo $row["title"]; ?>" >
                        <img src="<?php echo $imageURL; ?>" alt="" />
                    </a>
                <?php }
                } ?>
            </div>
        <!-- /мемы секшн -->
            </div>
        </div>
            </div>
            

        
</body>
<script src="/js/jquery.js" type="text/javascript"></script>
<script src="/js/lightbox-plus-jquery.js" type="text/javascript"></script>
<script src="/js/main.js" type="text/javascript"></script>
</html>

