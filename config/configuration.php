<?php
	session_start();
	
	const BDD_HOST = 'localhost';
	const BDD_DBNAME = 'bdd';
	const BDD_USER = 'root';
	const BDD_MDP = '';

	$bdd = new PDO("mysql:host=".BDD_HOST.";dbname=".BDD_DBNAME, BDD_USER, BDD_MDP);
	
	define('PATH_ASSETS','./assets/');
	define('PATH_CSS', PATH_ASSETS.'css/');
	define('PATH_FONTS', PATH_ASSETS.'fonts/');
	define('PATH_IMAGES', PATH_ASSETS.'images/');
	define("PATH_GALERIE",PATH_IMAGES.'gallery/');
	define('PATH_SCRIPTS', PATH_ASSETS.'js/');
	define('PATH_VIEWS','./views/');

	define('PATH_ICON', PATH_IMAGES.'icon.png');
	define('PATH_ICON_FOOTER', PATH_IMAGES.'icon_footer.webp');
	
	/*Obtenir le moment de connexion de l'utilisateur*/
	$date = new DateTime(null, new DateTimeZone(date_default_timezone_get()));
	define('CURRENT_TIME', $date->getTimestamp());
	
	/*Savoir si un utilisateur est admin ou pas*/
	if(isset($_SESSION['id']) != ""){

		$isItOneUser = $bdd->prepare('SELECT * FROM membre WHERE id ='.$_SESSION['id']);
		$isItOneUser->execute(array($_SESSION['id']));
		$isItOneUser = $isItOneUser->fetch(); 
		$userType = $isItOneUser['type'];
			
		if($userType == "user"){$isUser = 1;}
		else{$isUser = 0;}
					
		if($isUser){define('PATH_PROFIL',"profil.php?id=".$_SESSION['id']);}
		else{define('PATH_PROFIL',"admin.php?id=".$_SESSION['id']);}
		
		$userName = $isItOneUser['pseudo'];
		$userMail = $isItOneUser['mail'];
		$userPdp = $isItOneUser['photoprofil'];
		
		/*Obtenir le temps de connexion de l'utilisateur*/
		$userConnection = $isItOneUser['loginTime'];
		$timeOfLog = new DateTime($userConnection); 
		$timeOfLog =  $timeOfLog->getTimestamp();
		$currentTime = CURRENT_TIME - $timeOfLog;
		function dispTime ($theTime){
			if($theTime >= 3600){
					$theTime -= 3600;
					return date('H:i:s',$theTime);
			}
			else{
				return date('i:s',$theTime);
			}
		}

		/*Récuperer les infos du profil que l'on visite*/
		$getLocation =  explode("/", $_SERVER['SCRIPT_FILENAME']);
		$getLocalUser = explode("=",$_SERVER['REQUEST_URI']);
		
		if($getLocation[4] == "admin.php" || $getLocation[4] == "profil.php"){
			$getLocalId = $getLocalUser[1];	
			$localUser = $bdd->prepare('SELECT * FROM membre WHERE id='.$getLocalId);
			$localUser->execute(array($getLocalId));
			$localUser = $localUser->fetch();
			$localName = $localUser['pseudo'];
			$localId = $localUser['id'];
			$localMail = $localUser['mail'];
			$localMdp = $localUser['motdepasse'];
			$localPdp= $localUser['photoprofil'];		
			$localType= $localUser['type'];		
		}
	}
	else{$isUser = 0;}
	
	$url = explode("/", $_SERVER['SCRIPT_FILENAME']);
	
	/* url[4] -> "nomDeLaPage.php" */
	if(isset($_SESSION['id']) == ""){
		if($url[4] == "admin.php") define('TITRE_ONGLET', "YOTA Football | 404");
	}
	if(isset($_SESSION['id']) == ""){
		if($url[4] == "profil.php") define('TITRE_ONGLET', "YOTA Football | 404");
	}

	/*PARTIE 404*/
	if(isset($_SESSION['id'])){
		if(!$isUser) {
			if($getLocation[4] == "admin.php"){
				if($_SESSION['id'] == $localId){
					define('TITRE_ONGLET', "YOTA Football | ".$localName." [ADMIN] ".dispTime($currentTime)."");
				}
				/*Nous n'afficherons aucun pseudo ou durée de connexion 
				sur les pages 404 pour rendre l'IHM plus ergonomique*/
				else{define('TITRE_ONGLET', "YOTA Football | 404");}
			}
			if ($getLocation[4] == "profil.php"){
				if($localName == $isItOneUser['pseudo']){define('TITRE_ONGLET', "YOTA Football | 404");}
				/*Nous n'afficherons aucun pseudo ou durée de connexion 
				sur les pages visualisation de profil pour rendre l'IHM plus ergonomique*/
				else if($getLocalId == $localId){define('TITRE_ONGLET', "YOTA Football | Profil de ".$localName);}
				else{define('TITRE_ONGLET', "YOTA Football | 404");}
			}
			if($getLocation[4] == "index.php") define('TITRE_ONGLET', "YOTA Football | Home [".$userName." [ADMIN] ".dispTime($currentTime)."]");
			if($getLocation[4] == "gallery.php") define('TITRE_ONGLET', "YOTA Football | La Galerie [".$userName." [ADMIN] ".dispTime($currentTime)."]");
			if($getLocation[4] == "history.php") define('TITRE_ONGLET', "YOTA Football | Epope - Histoire [".$userName." [ADMIN] ".dispTime($currentTime)."]");
			if($getLocation[4] == "history2.php") define('TITRE_ONGLET', "YOTA Football |OL - Histoire [".$userName." [ADMIN] ".dispTime($currentTime)."]"); 
			if($getLocation[4] == "login.php") define('TITRE_ONGLET', "YOTA Football | Connexion [".$userName." [ADMIN] ".dispTime($currentTime)."]");
			if($getLocation[4] == "portfolio.php") define('TITRE_ONGLET', "YOTA Football | Mon portfolio [".$userName." [ADMIN] ".dispTime($currentTime)."]");
			if($getLocation[4] == "registration.php") define('TITRE_ONGLET', "YOTA Football | Inscription [".$userName." [ADMIN] ".dispTime($currentTime)."]");
		}
		else {
			if($getLocation[4] == "profil.php"){
				if($_SESSION['id'] == $localId){
					define('TITRE_ONGLET', "YOTA Football | ".$localName." ".dispTime($currentTime)."");
				}
				else{define('TITRE_ONGLET', "YOTA Football | 404");}
			}
			if ($getLocation[4] == "admin.php"){define('TITRE_ONGLET', "YOTA Football | 404");}
			if($getLocation[4] == "index.php") define('TITRE_ONGLET', "YOTA Football | Home [".$userName." ".dispTime($currentTime)."]");
			if($getLocation[4] == "gallery.php") define('TITRE_ONGLET', "YOTA Football | La Galerie [".$userName." ".dispTime($currentTime)."]");
			if($getLocation[4] == "history.php") define('TITRE_ONGLET', "YOTA Football | Epope - Histoire [".$userName." ".dispTime($currentTime)."]");
			if($getLocation[4] == "history2.php") define('TITRE_ONGLET', "YOTA Football | OL - Histoire [".$userName." ".dispTime($currentTime)."]"); 
			if($getLocation[4] == "login.php") define('TITRE_ONGLET', "YOTA Football | Connexion [".$userName." ".dispTime($currentTime)."]");
			if($getLocation[4] == "portfolio.php") define('TITRE_ONGLET', "YOTA Football | Mon portfolio [".$userName." ".dispTime($currentTime)."]");
			if($getLocation[4] == "registration.php") define('TITRE_ONGLET', "YOTA Football | Inscription [".$userName." ".dispTime($currentTime)."]");		
		}
	}
	else{
		if($url[4] == "index.php") define('TITRE_ONGLET', "YOTA Football | Home");
		if($url[4] == "gallery.php") define('TITRE_ONGLET', "YOTA Football | La Galerie");
		if($url[4] == "history.php") define('TITRE_ONGLET', "YOTA Football | Epope - Histoire");
		if($url[4] == "history2.php") define('TITRE_ONGLET', "YOTA Football | OL - Histoire"); 
		if($url[4] == "login.php") define('TITRE_ONGLET', "YOTA Football | Connexion");
		if($url[4] == "portfolio.php") define('TITRE_ONGLET', "YOTA Football | Mon portfolio");
		if($url[4] == "registration.php") define('TITRE_ONGLET', "YOTA Football | Inscription");
	}
					
	/*Afficher dans la navbar du site le nombre d'image que possède l'utilisateur*/
	if(isset($_SESSION['id']) != ""){
		$connection = mysqli_connect("localhost", "root", "", BDD_DBNAME) or die("Erreur de connection: ".mysqli_error($connection));
		$nbImageUser = 'SELECT * FROM photo WHERE userID ='.$_SESSION['id'].'';  
		$result = mysqli_query($connection, $nbImageUser);
		if ($result){$nbImage = mysqli_num_rows($result); mysqli_free_result($result);}  
		mysqli_close($connection);
	}
	?>