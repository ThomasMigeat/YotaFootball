<?php 
	require_once('./config/configuration.php');	
	
	if(isset($_POST['forminscription'])) {
		$pseudo = htmlspecialchars($_POST['pseudonyme']);
		$mail = htmlspecialchars($_POST['email']);	
		$mdp = sha1($_POST['password']);
		$type="user";	
		$pdp="https://i.giphy.com/media/gzROsII7swwrm/giphy.webp";	
		
		if(!empty($_POST['pseudonyme']) AND !empty($_POST['email']) AND !empty($_POST['password'])) {
			$reqpseudo = $bdd->prepare("SELECT * FROM membre WHERE pseudo = ?");
			$reqpseudo->execute(array($pseudo));
			$pseudoexist = $reqpseudo->rowCount();
			if($pseudoexist == 0){
				if(filter_var($mail, FILTER_VALIDATE_EMAIL)) {
					$reqmail = $bdd->prepare("SELECT * FROM membre WHERE mail = ?");
					$reqmail->execute(array($mail));
					$mailexist = $reqmail->rowCount();
					if($mailexist == 0) {
						$insertmbr = $bdd->prepare("INSERT INTO membre(pseudo, mail, motdepasse,type,photoprofil) VALUES(?, ?, ?, ?, ?)");
						$insertmbr->execute(array($pseudo, $mail, $mdp, $type, $pdp));				
					}
					else{$erreur = "Adresse mail déjà utilisée!";}
				}
			}
			else {$erreur = "Ce pseudo est déja utilisé!";}
		}
		$valide = "Super, bienvenue dans l'univers Minterest !";
	}
	
	include('views/header.php');	
?>


		<div class="container-log w-100" style="background-image: linear-gradient(black, black), url(assets/images/index.gif);">
			<h1 class="font-weight-bold text-center text-white">M'INSCRIRE A MINTEREST</h1>

			<div class="log mx-auto text-center w-80">
				<h3>Informations personnelles</h3>
				
				<form method="POST" action="" id="createUser">
					<div>
						<label for="regInputName">Pseudo</label>
						<input type="text" required name="pseudonyme" class="form-control mx-auto w-75" id="regInputName" maxlength="32" placeholder="Mon Pseudonyme">
						<p id="disp_pseudo"></p>
					</div>
				   
					<div>
						<label for="loginInputEmail">Adresse mail</label>
						<input type="email" required name="email" class="form-control mx-auto w-75" id="regInputEmail" placeholder="Mon mail">
						<p id="disp_mail"></p>
					</div>
				  
					<div>
						<label for="regInputPassword">Mot de passe</label>
						<input type="password" required name="password" class="form-control mx-auto w-75" id="regInputPassword" maxlength="40" placeholder="Mot de passe">           
						<p id="disp_mdp"></p>
					</div>
				  
					<div id="message">
						<p>Pour être sûr votre mot de passe doit contenir au moins :</p>
						<p id="length" class="invalid">8 caractères.</p>
						<p id="letter" class="invalid">Une minuscule.</p>
						<p id="capital" class="invalid">Une majuscule.</p>
						<p id="number" class="invalid">Un nombre.</p><br>
					</div>
					
					<div>
						<label for="regInputPasswordcf">Confirmer le mot de passe</label>
						<input type="password" name="password_confirmation" class="form-control mx-auto w-75" id="regInputPasswordcf" maxlength="40" placeholder="Confirmer mon mot de passe">           
						<p id="disp_mdpcf"></p>
					</div> 
				  
					<div>
						<input type="checkbox" name="conditions" id="conditions"/>
						J'accepte les conditions générales.
						<p id="disp_cond"></p>
					</div>

					<?php 
						if(isset($erreur)) {echo '<span style="color:red;">'.$erreur."</span>";}
						if(isset($valide)) {echo '<span  style="color:green;">'.$valide."</span>";}
					?>
			
					<br/>

					<input type="submit" class="font-weight-bold w98btn"  name="forminscription" value=" M'INSCRIRE" />
				</form>
				<hr class="w-75">
				<a href="login.php">Déjà membre?</a>
			</div>
		</div>
		
		<?php include('views/footer.php'); ?>
		
		<script>					
			function print_error(errorId, errorStr) {
				document.getElementById(errorId).style.color = "red";
				document.getElementById(errorId).innerHTML = errorStr;
			}
		  
			document.getElementById('regInputEmail').onfocus = function() {document.getElementById('disp_mail').innerHTML = null;}  
			document.getElementById('regInputEmail').onblur = function() {
				if(!document.getElementById("regInputEmail").value.match(/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/)){
				  print_error('disp_mail',"Adresse mail invalide.");
				}
			}
    
			document.getElementById("regInputPassword").onfocus = function() {document.getElementById('disp_mdp').innerHTML = null; document.getElementById("message").style.display = "block";}  
			document.getElementById("regInputPassword").onblur = function() {
				document.getElementById("message").style.display = "none";
				if(document.getElementById("regInputPassword").length !=0 && document.getElementById("regInputPassword").value.match(/[a-z]/g) && document.getElementById("regInputPassword").value.match(/[A-Z]/g) && document.getElementById("regInputPassword").value.match(/[0-9]/g) && (document.getElementById("regInputPassword").value.length >= 8))  {
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