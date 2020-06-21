<?php
	$connection = mysqli_connect("localhost", "root", "", 'bdd') or die("Erreur de connection: ".mysqli_error($connection));
	$id = $_GET['id'];
	$appear = mysqli_query($connection,"update photo set isShown=1 where photoId = '$id'");
		
	if($appear){mysqli_close($connection); header("location:./portfolio.php"); exit;}
	else{echo "Une erreur est survenue..."; }
?>