<?php
	$file = "quoteToday.txt";

	$quoteArray = file("quoteData.txt");

	$qrnd = rand(0,sizeof($quoteArray)-1);

	$quote = "$quoteArray[$qrnd]";
	
	$fh = fopen($file, "w");
	fputs($fh, $quote);
	fclose($fh);

?>