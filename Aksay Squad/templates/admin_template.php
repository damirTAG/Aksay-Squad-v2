<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>WELCOME TO</title>

    <script>
        function updateTitle() {
            var titles = ["AKSAY", "SQUAD", "ADMIN", "PANEL"];
            var currentIndex = 0;

            setInterval(function () {
                document.title = titles[currentIndex];
                currentIndex = (currentIndex + 1) % titles.length;
            }, 1500);
        }
        window.onload = function () {
            updateTitle();
        };
    </script>

    <style>
        <?php require_once 'admin_style.css'; ?>
    </style>
</head>
<body>
    <div class="container">
        <h2>Welcome to the Admin Dashboard of AS Website!</h2>
        <form action="admin.php" method="GET" class="search-form">
            <input type="text" placeholder="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : 'Search...'; ?>" name="search" class="search-input">
            <button type="submit" class="search-button">Search</button>
        </form>
        <?php
            echo "<h3>Add New Quote</h3>";
            echo "<form class='form' method='post' action=''>";
            echo "<label for='title'>Title:</label>";
            echo "<input type='text' id='title' name='title' required /><br />";
            
            echo "<label for='description'>Description:</label>";
            echo "<textarea id='description' name='description' required></textarea><br />";

            echo "<button type='submit' name='add_quote'>Add Quote</button>";
            echo "</form>";
            echo "<hr />";

            // Display all quotes with update and delete options
            echo "<h3>All Quotes</h3>";
            foreach ($quotes as $quote) {
                echo "<div>";
                echo "<h3>QUOTE WITH ID: {$quote['id']}</h3>";
                echo "<h3>CREATED AT: <code>{$quote['create_date']}</code></h3>";
                echo "<h3>";

                if ($quote['updated_at'] !== null) {
                    echo "UPDATED AT: <code>{$quote['updated_at']}</code>";
                } else {
                    echo "NOT UPDATED";
                }

                echo "</h3>";
                echo "<form method='post' action=''>";
                echo "<input type='hidden' name='quote_id' value='{$quote['id']}'>";
                echo "<label for='title'>Title:</label>";
                echo "<input type='text' id='title' name='title' value='{$quote['title']}' required><br />";
                
                echo "<label for='description'>Description:</label>";
                echo "<textarea id='description' name='description' required>{$quote['description']}</textarea><br />";

                echo "<button type='submit' name='update_quote'>Update</button>";
                echo "<button type='submit' name='delete_quote'>Delete</button>";
                echo "</form>";
                echo "<hr />";
                echo "</div>";
            }

            echo "<a href='admin.php?action=logout'>Logout</a>";
        ?>
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
</body>
</html>
