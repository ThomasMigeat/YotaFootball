<?php
	require_once('./config/configuration.php');
	$tabEmoji = array("","", "", "", "", "","", "", "", "", "", "️", "⚽","YOTA");
?>

<html lang="fr">
	
	<head>
		<title><?php echo TITRE_ONGLET; ?></title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="icon" type="image/png" href="<?php echo PATH_ICON ?>" alt="YOTA Football © The Official Website">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
		<link rel="stylesheet" type="text/css" href="<?php echo PATH_CSS ?>mint.css">
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
		<script src="assets/js/script.js"></script>
	</head>
	
	<body class="m-0 p-0 vh-100">

		<a id="back-top" class="bg-danger d-inline-block font-bold position-fixed text-center text-white" onClick="backToTop()">TOP</a>
		
		<nav id="nav" class="fixed-top navbar navbar-expand-lg navbar-light">
			<a class="navbar-brand" href="index.php">
				<img src="<?php echo PATH_ICON; ?>" height="30" alt="YOTA Football © The Official Website">
			</a>
			
			<a class="font-bold navbar-brand" href="index.php"><span class="reflection">Y O T A</span></a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="mr-auto navbar-nav">
					<li class=" nav-item">
                        <a class="<?php if($url[4] == "index.php") echo "active font-bold"; ?> nav-link w98btn" style="padding-left: 50px !important" href="index.php" >ACCEUIL</a>
                    </li>

					<li class="nav-item">
                        <a class="<?php if($url[4] == "gallery.php") echo "active font-bold"; ?> nav-link w95btn" style="padding-left: 50px !important" href="gallery.php">GALERIE D'IMAGES</a>
                    </li>
					
					<li class="nav-item dropdown">
                        <a class="<?php if($url[4] == "history.php") echo "active font-bold"; ?>  dropdown-toggle nav-link wbtn" id="navbarDropdownMenuLink-5" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">L'HISTOIRE</a>
						<div class="dropdown-menu dropdown-purple" aria-labelledby="navbarDropdownMenuLink-5">
                            <a class="dropdown-item" href="history.php">Epopée des Verts 1976</a>
                            <a class="dropdown-item" href="history2.php">Suprématie Lyonnaise 2000-2007</a>
                        </div>
                    </li>
                </ul>

                <ul class="navbar-nav ml-auto nav-flex-icons">
					<li class=" nav-item ">
                       
							<?php 
								if(isset($_SESSION['id']) == ""){
									?>
									 <a class="dropdown-toggle nav-link wbtn" id="navbarDropdownMenuLink-4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user text-primary"></i></i>Mon compte</a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink-4">
									<a class="dropdown-item" href="login.php">Se connecter</a>
									<a class="dropdown-item" href="registration.php">S'inscrire</a>
							<?php
								} else{
									?>
									 <a class="dropdown-toggle nav-link wbtn" id="navbarDropdownMenuLink-4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user text-primary"></i></i><?php echo htmlspecialchars($_SESSION['pseudo']);?></a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink-4">
									<a class="dropdown-item" href="<?php echo PATH_PROFIL; ?>">Mon profil</a>
									<a class="dropdown-item" href="portfolio.php"><i class="fa fa-camera text-danger"></i> Mon portfolio (<?php echo $nbImage;?>)</a>
									<a class="dropdown-item" href="views/disconnect.php"><i class="fa fa-sign-out"></i>Me déconnecter</a>
							<?php
								}
							?>
						</div>
                    </li>
					
                </ul>
            </div>
        </nav>
		
		<div class="emojis">
			<div class="emoji"><?php $rand_keys = array_rand($tabEmoji, 2); echo $tabEmoji[$rand_keys[0]];?></div>
			<div class="emoji"><?php $rand_keys = array_rand($tabEmoji, 2); echo $tabEmoji[$rand_keys[0]];?></div>
			<div class="emoji"><?php $rand_keys = array_rand($tabEmoji, 2); echo $tabEmoji[$rand_keys[0]];?></div>
			<div class="emoji"><?php $rand_keys = array_rand($tabEmoji, 2); echo $tabEmoji[$rand_keys[0]];?></div>
			<div class="emoji"><?php $rand_keys = array_rand($tabEmoji, 2); echo $tabEmoji[$rand_keys[0]];?></div>
			<div class="emoji"><?php $rand_keys = array_rand($tabEmoji, 2); echo $tabEmoji[$rand_keys[0]];?></div>
			<div class="emoji"><?php $rand_keys = array_rand($tabEmoji, 2); echo $tabEmoji[$rand_keys[0]];?></div>
			<div class="emoji"><?php $rand_keys = array_rand($tabEmoji, 2); echo $tabEmoji[$rand_keys[0]];?></div>
			<div class="emoji"><?php $rand_keys = array_rand($tabEmoji, 2); echo $tabEmoji[$rand_keys[0]];?></div>
			<div class="emoji"><?php $rand_keys = array_rand($tabEmoji, 2); echo $tabEmoji[$rand_keys[0]];?></div>
			<div class="emoji"><?php $rand_keys = array_rand($tabEmoji, 2); echo $tabEmoji[$rand_keys[0]];?></div>
		</div>
