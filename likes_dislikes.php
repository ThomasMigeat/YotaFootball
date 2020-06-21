<?php
	require_once('./config/configuration.php');

	if(isset($_GET['t'],$_GET['photoId']) AND !empty($_GET['t']) AND !empty($_GET['id'])){
	$getid = (int) $_GET['id'];
	$gett = (int) $_GET['t']

	$sessionid = 4;
	
	$check =$bdd->prepare('SELECT photoId FROM photo WHERE photoId=?');
	$check->execute(array($getid));
	
	if($check->rowCount() == 1){
		if($gett ==1 ){
			$check_like = $bdd->prepare('SELECT likes FROM photo WHERE photoId = ? AND userId = ?');
			$check_like->execute(array($getid,$sessionid));
			
			$del = $bdd->prepare('DELETE dislikes FROM photo WHERE photoId = ? AND userId = ?');
			$del->execute(array($getid,$sessionid));

			if(check_like->rowCount()==1){
				$del = $bdd->prepare('DELETE likes FROM photo WHERE photoId = ? AND userId = ?');
				$del->execute(array($getid,$sessionid));
			}else{
				$ins=$bdd->prepare('INSERT likes INTO photo (photoId, userId) VALUES (?,?)');
				$ins->execute(array($getid, $sessionid));
			}
			
			
			
		}elseif($gett == 2){
			$check_dislike = $bdd->prepare('SELECT dislikes FROM photo  WHERE photoId = ? AND userId = ?');
			$check_dislike->execute(array($getid,$sessionid));
			
			$del = $bdd->prepare('DELETE likes FROM  photo WHERE photoId = ? AND userId = ?');
			$del->execute(array($getid,$sessionid));

			if(check_dislike->rowCount()==1){
				$del = $bdd->prepare('DELETE dislikes FROM photo WHERE photoId = ? AND userId = ?');
				$del->execute(array($getid,$sessionid));
			}else{
				$ins=$bdd->prepare('INSERT dislikes INTO photo (photoId, userId) VALUES (?,?)');
				$ins->execute(array($getid, $sessionid));
			}
			
		}
		header('Location: '.$_SERVER['HTTP_REFERER']);
	}else{
		exit('erreur Fatal');
	}
	
	
			$likes = $bdd->prepare('SELECT likes FROM photo WHERE photoId = ?');
			$likes->execute(array($photoId));
			$likes->$likes->rowCount();
			
			$dislikes = $bdd->prepare('SELECT dislikes FROM photo WHERE photoId = ?');
			$dislikes->execute(array($photoId));
			$dislikes->$likes->rowCount();
	
}