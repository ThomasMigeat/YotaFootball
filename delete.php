<?php
	$connection = mysqli_connect("localhost", "root", "", 'bdd') or die("Erreur de connection: ".mysqli_error($connection));
	$id = $_GET['id'];
	$del = mysqli_query($connection,"delete from photo where photoId = '$id'");

	if($del){mysqli_close($connection); header("location:./portfolio.php"); exit;}
	else{echo "Une erreur est survenue..."; }
?>