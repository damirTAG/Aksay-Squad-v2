<?php
	if(ISSET($_POST['search'])){
		$keyword = $_POST['keyword'];
?>
<div>
	<h2 style="color: #fff;">Результат</h2>
	<hr style="border-top:2px dotted #fff"/>
	<?php
		require 'conn.php';
		$query = mysqli_query($conn, "SELECT * FROM `quotes` WHERE `title` LIKE '%$keyword%' ORDER BY `title`") or die(mysqli_error());
		while($fetch = mysqli_fetch_array($query)){
	?>
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
            <div class="vot_mp2" data-vote_id="<?php echo $note['id'] ?>"></div>
            <small class="date-time"><?php echo date('d/m/Y H:i', strtotime($note['create_date'])) ?></small>
            
        </div>
	<?php
		}
	?>
</div>
<?php
	}
?>