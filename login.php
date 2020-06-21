<?php 
	require_once('./config/configuration.php');
	
	if(isset($_POST['formconnexion'])) {
		$mailconnect = htmlspecialchars($_POST['mailconnect']);
		$mdpconnect = sha1($_POST['mdpconnect']);
		if(!empty($mailconnect) AND !empty($mdpconnect)) {
			$requser = $bdd->prepare("SELECT * FROM membre WHERE (mail = '$mailconnect' OR pseudo='$mailconnect') AND motdepasse = '$mdpconnect' ");
			$requser->execute(array($mailconnect, $mdpconnect));
			$exist = $requser->rowCount();
			if($exist == 1) {
				$userinfo = $requser->fetch();
				$_SESSION['id'] = $userinfo['id'];
				$_SESSION['pseudo'] = $userinfo['pseudo'];
				$_SESSION['mail'] = $userinfo['mail'];
				$connect = mysqli_connect("localhost", "root", "", BDD_DBNAME) or die("Connection Error: " . mysqli_error($connect));
				mysqli_query($connect, "UPDATE membre set loginTime='".date('Y-m-d H:i:s', CURRENT_TIME)."' WHERE id='".$userinfo['id']."'");
				
				if($userinfo['type'] == "user"){
					header("Location: profil.php?id=".$_SESSION['id']);
				}
				else{
					header("Location: admin.php?id=".$_SESSION['id']);
				}
				die();
			} 
			else {
				$erreur = "Mot de passe et/ou mail incorrectes";
			}
		} 
		else {
			$erreur = "Tous les champs doivent être complétés !";
		}
	}
	include('views/header.php');
?>

		<div class="container-log w-100" style="background-image: linear-gradient(#000, #000), url(assets/images/index.gif);">
			<h1 class="font-weight-bold text-center text-white">S'IDENTIFIER</h1>

			<div class="d-inline-block log logscreen mb-5 float-left text-center">
				<h3>ENTRER DANS LE CLUB</h3>
				<p>
					En créant un compte, vous pourrez profiter de fonctionnalités telles que la confection d'un portfolio ou l'ajout d'image.
				</p>
				<a class="font-weight-bold text-dark text-decoration-none w98btn" href="registration.php">CREER UN COMPTE</a>
			</div>
					 
			<div class="log logscreen d-inline-block text-center">
				<h3>ME CONNECTER</h3>
				<form method="POST" action="">
					<label for="loginInputEmail">Adresse mail ou Pseudo:</label>
					<input type="text" class="form-control mx-auto w-75" name="mailconnect" placeholder="Mail/Pseudo">
					<p id="lmail"></p>
						
					<label for="loginInputPassword">Mot de passe</label>
					<input type="password" class="form-control mx-auto w-75" maxlength="40" name="mdpconnect" placeholder="Mot de passe">           
					<p id="mdp"></p>
					
					<?php if(isset($erreur)) {echo '<span style="color: #f00;">'.$erreur."</span>";}	?>
					<br/>
					<br/>

					<input class="font-weight-bold w98btn" type="submit" name="formconnexion" value="SE CONNECTER" />
				</form>
			</div> 
		</div>
		
		<?php include('views/footer.php'); ?>
		
		<script>					
			function print_error(errorId, errorStr) {
				document.getElementById(errorId).style.color = "red";
				document.getElementById(errorId).innerHTML = errorStr;
			}
		  
			document.getElementById('regInputName').onfocus = function() {document.getElementById('disp_pseudo').innerHTML = null;}  
			document.getElementById('regInputName').onblur = function() {
				if(document.getElementById("regInputName").value == 0){print_error('disp_pseudo',"Veuillez saisir votre pseudonyme.");}
			}
    
			document.getElementById('regInputEmail').onfocus = function() {document.getElementById('disp_mail').innerHTML = null;}  
			document.getElementById('regInputEmail').onblur = function() {
				if(document.getElementById("regInputEmail").value == 0){print_error('disp_mail',"Veuillez saisir votre e-mail.");}
				else if(!document.getElementById("regInputEmail").value.match(/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/)){
				  print_error('disp_mail',"Adresse mail invalide.");
				}
			}
    
			document.getElementById("regInputPassword").onfocus = function() {document.getElementById('disp_mdp').innerHTML = null; document.getElementById("message").style.display = "block";}  
			document.getElementById("regInputPassword").onblur = function() {
				document.getElementById("message").style.display = "none";
				if(document.getElementById("regInputPassword").value == 0)  {
					print_error('disp_mdp',"Veuillez saisir un mot de passe.");
				}
				else if(document.getElementById("regInputPassword").length !=0 && document.getElementById("regInputPassword").value.match(/[a-z]/g) && document.getElementById("regInputPassword").value.match(/[A-Z]/g) && document.getElementById("regInputPassword").value.match(/[0-9]/g) && (document.getElementById("regInputPassword").value.length >= 8))  {
					document.getElementById('disp_mdp').innerHTML = null;
				}
				else {print_error('disp_mdp',"Votre mot de passe n'est pas assez sécurisé.");}
				
			}
    
			document.getElementById("regInputPasswordcf").onfocus = function() {document.getElementById('disp_mdpcf').innerHTML = null;}  
			document.getElementById("regInputPasswordcf").onblur = function() {
				if(document.getElementById("regInputPassword").value != document.getElementById("regInputPasswordcf").value && document.getElementById("regInputPasswordcf").length != 0){
					print_error('disp_mdpcf',"Les mots de passe ne correspondent pas.");
				} 
			}
    
			document.getElementById("regInputPassword").onkeyup = function() {
				if(document.getElementById("regInputPassword").value.match(/[a-z]/g)) {
				  document.getElementById("letter").classList.remove("invalid");
				  document.getElementById("letter").classList.add("valid");
				} 
				else {
					document.getElementById("letter").classList.remove("valid");
					document.getElementById("letter").classList.add("invalid");
				}
		 
				if(document.getElementById("regInputPassword").value.match(/[A-Z]/g)) {
					document.getElementById("capital").classList.remove("invalid");
					document.getElementById("capital").classList.add("valid");
				} 
				else {
					document.getElementById("capital").classList.remove("valid");
					document.getElementById("capital").classList.add("invalid");
				}
		 
				if(document.getElementById("regInputPassword").value.match(/[0-9]/g)) {
					document.getElementById("number").classList.remove("invalid");
					document.getElementById("number").classList.add("valid");
				} 
				else {
					document.getElementById("number").classList.remove("valid");
					document.getElementById("number").classList.add("invalid");
				}

				if(document.getElementById("regInputPassword").value.length >= 8) {
					document.getElementById("length").classList.remove("invalid");
					document.getElementById("length").classList.add("valid");
				} 
				else {
					document.getElementById("length").classList.remove("valid");
					document.getElementById("length").classList.add("invalid");
				}
			}
			
			if(document.getElementById("regInputPassword").length != 0 && document.getElementById("regInputPassword").value != document.getElementById("regInputPasswordcf").value)  {
				document.getElementById("disp_mdpcf").style.color = "red";
				document.getElementById("disp_mdpcf").innerHTML = 'Les mots de passe ne correspondent pas.';
			}
		
			$('#createUser').submit(function(e){ 
				if(document.getElementById("regInputName").value == 0){print_error('disp_pseudo',"Veuillez saisir votre Pseudonyme."); e.preventDefault();}
				if(document.getElementById("regInputEmail").value == 0){print_error('disp_mail',"Veuillez saisir votre e-mail."); e.preventDefault();}
				
				if(document.getElementById("regInputPassword").value == 0){print_error('disp_mdp',"Veuillez saisir un mot de passe."); e.preventDefault();}      
				else if(!document.getElementById("regInputPassword").value.match(/[a-z]/g) || !document.getElementById("regInputPassword").value.match(/[A-Z]/g)|| !document.getElementById("regInputPassword").value.match(/[0-9]/g) || (document.getElementById("regInputPassword").value.length < 8))  {
					print_error('disp_mdp',"Votre mot de passe n'est pas assez sécurisé."); e.preventDefault();
				}
				
				if(document.getElementById("regInputPassword").value != document.getElementById("regInputPasswordcf").value && document.getElementById("regInputPasswordcf").length != 0){print_error('disp_mdp',"Les mots de passe ne correspondent pas."); e.preventDefault();}
				if(document.getElementById("regInputPasswordcf").value == 0 && document.getElementById("regInputPassword").value != document.getElementById("regInputPasswordcf").value){print_error('disp_mdpcf','Les mots de passe ne correspondent pas.'); e.preventDefault();}
			 
				if(document.getElementById("regInputPasswordcf").value == 0)  {
					document.getElementById("disp_mdpcf").style.color = "red";
					document.getElementById("disp_mdpcf").innerHTML = 'Veuillez saisir le mot de passe.';
					e.preventDefault();
				}
			  
				if(!document.getElementById("regInputEmail").value.match(/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/)){
					print_error('disp_mail',"Adresse mail invalide.");
					e.preventDefault();
				}
				
				if (document.getElementById("conditions").checked == false){	
					print_error('disp_cond',"Veuillez accepter les conditions générales.");
					e.preventDefault();
				}
				
			});	
		</script>
    </body>
</html>