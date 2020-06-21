
<?php
	require_once('./config/configuration.php');
	
	if(isset($_GET['id']) AND !empty($_GET['id'])){
		$get_id = htmlspecialchars($_GET['id']);
		
		$article = $bdd->prepare('SELECT * FROM articles WHERE id = ?');
		$article->execute(array($get_id));
		
		if($article->rowCount() == 1){
			$article = $article->fetch();
			$id = $article['id'];
			$titre = $article['titre'];
			$contenu = $article['contenu'];
			
			$likes = $bdd->prepare('SELECT id FROM likes WHERE id_article = ?');
			$likes->execute(array($id));
			$likes->$likes->rowCount();
			
			$dislikes = $bdd->prepare('SELECT id FROM dislikes WHERE id_article = ?');
			$dislikes->execute(array($id));
			$dislikes->$likes->rowCount();
			
			
		}else{
			die('Cet article n\'existe pas!');
		}
	}else{
		die('Erreur');
	}
	
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />


<title>Youtube Like & Dislike System</title>
</head>
<body>

	<h1 <?= $titre ?></h1>
	<p <?= $contenu ?></p>

	<a href="like_dislike.php?t=1&id<?=$id ?>">like</a> <?= $likes ?>
	<a href="like_dislike.php?t=2&id<?=$id ?>">dislikes</a> <?= $dislikes ?>


</body>
</html>


