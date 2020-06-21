<?php
	require_once('./config/configuration.php');
	include('views/header.php');
	
	if(isset($_SESSION['id']) != ""){
		if($getLocation[4] == "admin.php" AND $_SESSION['id'] == $localId AND !$isUser){
			
			$connect = mysqli_connect("localhost", "root", "", BDD_DBNAME) or die("Connection Error: " . mysqli_error($connect));
	
			if(isset($_POST['formNewPic'])){
				if((filter_var($_POST["newPic"], FILTER_VALIDATE_URL))){	
					$erreur = "Photo de profil modifié avec succès.";
					mysqli_query($connect, "UPDATE membre set photoprofil='".$_POST["newPic"]."' WHERE id='".$localId."'");
					echo "<meta http-equiv='refresh' content='0'>";
				}
				else{
					$erreur = "Veuillez entrer une adresse URL valide.";
				}
			}	
			
			if(isset($_POST['formNewName'])) {
				$pseudo = htmlspecialchars($_POST['newPseudonyme']);
				$reqpseudo = $bdd->prepare("SELECT * FROM membre WHERE pseudo =?");
				$reqpseudo->execute(array($pseudo));
				$pseudoexist = $reqpseudo->rowCount();
				
				if($pseudoexist == 0){
					$result = mysqli_query($connect, "SELECT * from membre WHERE id='" .$localId. "'");
					$row = mysqli_fetch_array($result);

					if ($_POST["oldPseudonyme"] == $localName) {		
						if ($_POST["newPseudonyme"] !== $localName) {
							$erreur = "Pseudo modifié avec succès";
							mysqli_query($connect, "UPDATE membre set pseudo='".$_POST["newPseudonyme"]."' WHERE id='".$localId."'");
							echo "<meta http-equiv='refresh' content='0'>";
						}
						else{
							$erreur = "Le nouveau pseudo ne doit pas être le même.";
						}
					}
				}
				else {
					$erreur = "Ce pseudo est déjà utilisé.";
				}		
			}	
				
			if(isset($_POST['formNewMail'])) {
				$mail = htmlspecialchars($_POST['newEmail']);
				$reqmail = $bdd->prepare("SELECT * FROM membre WHERE mail =?");
				$reqmail->execute(array($mail));
				$mailexist = $reqmail->rowCount();

				if($mailexist == 0){
					$result = mysqli_query($connect, "SELECT * from membre WHERE id='".$localId."'");
					$row = mysqli_fetch_array($result);

					if ($_POST["newEmail"] !== $localMail) {
						$erreur = "Adresse mail modifiée avec succès";
						mysqli_query($connect, "UPDATE membre set mail='".$_POST["newEmail"]."' WHERE id='".$localId."'");
						echo "<meta http-equiv='refresh' content='0'>";
					}
					else{
						$erreur = "La nouvelle adresse mail ne peut être la même.";
					}
				}
				else {
					$erreur = "Cette adresse mail est déja utilisée.";
				}		
			}
			
			if(isset($_POST['formNewPwd'])) {
				$pwd = htmlspecialchars($_POST['newPwd']);
				$reqpwd = $bdd->prepare("SELECT * FROM membre WHERE motdepasse =?");
				$reqpwd->execute(array($pwd));
				$pwdexist = $reqpwd->rowCount();

				if($localUser["motdepasse"]==sha1($_POST["oldPwd"])){
					$result = mysqli_query($connect, "SELECT * from membre WHERE id='".$localUser["id"]."'");
					$row = mysqli_fetch_array($result);

					if (sha1($_POST["newPwd"]) !== $localUser["motdepasse"]) {
						mysqli_query($connect, "UPDATE membre set motdepasse='".sha1( $_POST["newPwd"] )."' WHERE id='".$localUser["id"] . "'");
						$erreur = "Mot de passe Change";
					}
					else{
						$erreur = "Le nouveau mot de passe ne peut être le même.";
					}
				}
				else {
					$erreur = "Mot de passe incorrecte.";
				}		
			}	
		
?>

		<div class="w-100" style="margin-top: 100px !important;">		
			<div class="align-items-center bg-light card d-flex justify-content-center m-4 p-4 " data-animate-top>
				<div id="edit-back" class="position-absolute w-100 h-100"></div>
								
				<div class="content mb-2">
				  <div class="content__container text-center"> 
					<ul class="content__container__list" style="margin-left: -40px !important;">
					  <li>Bienvenue!</li>
					  <li>환영합니다!</li> 
					  <li>Welcome!</li>
					  <li>أهلا و سهلا</li>
					</ul>
				  </div>
				</div>

				<img id="profilId" style="height:250px;width:350px;" src="<?php echo $userPdp; ?>" alt="" class="img-fluid">
				<div id="editPic" class="text-center">
					<a id="edit-closePic" class="close-button float-right text-danger">&#10006;</a>
					<form method="POST" action="" id="editPdp">
						<label for="editMyPic">Ma nouvelle photo de profil</label>
						<input type="text" required name="newPic" class="form-control mx-auto w-75" id="editMyPic" placeholder="L'URL (Sur Internet) de mon image">
						<!--Sur internet carf plus pratique-->
						<input type="submit" class="font-weight-bold w98btn" name="formNewPic" value=" MODIFIER" />
					</form>
				</div>
				
				<div id="edit-profilName" class="bg-light position-absolute row p-5" style="background-color:red; ">
					<div class=" text-center">
						<a id="edit-closeName" class="close-button float-right text-danger">&#10006;</a>
						<h3>Modifier mon Pseudo </h2>
						<form method="POST" action="" id="editName">
							<input type="text" required name="oldPseudonyme" class="form-control mx-auto w-75" id="editMyName" maxlength="32" value="<?php echo $localName;?>" readonly>
							<br/>
							<input type="text" required name="newPseudonyme" class="form-control mx-auto w-75" id="editMyName" maxlength="32" placeholder="Mon nouveau Pseudonyme">
							<p id="disp_pseudo"></p>
							<br/>
							<input type="submit" class="font-weight-bold w98btn"  name="formNewName" value=" MODIFIER" />
						</form>
					</div>
				</div>
				
				<div id="edit-profilMail" class="bg-light col-md-6 mx-auto position-absolute row p-5" style="background-color:red; ">
					<div class=" text-center">
						<a id="edit-closeMail" class="close-button float-right text-danger">&#10006;</a>
						<h3>Modifier mon adresse mail</h2>
						<form method="POST" action="" id="editMail">
							
							<input type="email" required name="newEmail" class="form-control mx-auto w-75" id="editMyEmail" maxlength="40" placeholder="Ma nouvelle adresse mail">
							<label for="editMyEmailcf">Confirmer l'adresse</label>
							<input autocomplete="off" type="mail" name="newEmail_confirmation" class="form-control mx-auto w-75" id="editMyEmailcf" maxlength="40" placeholder="Confirmer mon adresse mail">           

							<p id="disp_mail"></p>
							<br/>

							<input type="submit" class="font-weight-bold w98btn"  name="formNewMail" value=" MODIFIER" />
						</form>
					</div>
				</div>
							
				<div id="edit-profilPwd" class="bg-light mx-auto position-absolute row p-5" style="background-color:red; ">
					<div class=" text-center">
						<a id="edit-closePwd" class="close-button float-right text-danger">&#10006;</a>
						<h3>Modifier mon mot de passe</h3>
						<form method="POST" action="" id="editPwd">
							
							<input type="password" required name="oldPwd" class="form-control mx-auto w-75" id="myOldPwd" maxlength="40" placeholder="Mon mot de passe actuel">
							
							<label for="editMyPwd">Mon nouveau mot de passe</label>
							<input type="password" required name="newPwd" class="form-control mx-auto w-75" id="editMyPwd" maxlength="40" placeholder="Mon nouveau mot de passe">
							
							<div id="message">
								<p>Pour être sûr votre mot de passe doit contenir au moins :</p>
								<p id="length" class="invalid">8 caractères.</p>
								<p id="letter" class="invalid">Une minuscule.</p>
								<p id="capital" class="invalid">Une majuscule.</p>
								<p id="number" class="invalid">Un nombre.</p><br>
							</div>
							
							<label for="editMyPwdcf">Confirmer le mot de passe</label>
							<input type="password" required name="newPwd_confirmation" class="form-control mx-auto w-75" id="editMyPwdcf" maxlength="40" placeholder="Confirmer mon mot de passe">           
							
							<p id="disp_pwd"></p>
				  
							<br/>

							<input type="submit" class="font-weight-bold w98btn"  name="formNewPwd" value=" MODIFIER" />												

						</form>
					</div>
				</div>

				<h1><?php echo $userName.' [ADMIN]';?></h1>
				
				<br/>
				
				<ul class="font-weight-bold list-unstyled text-center">
					<li class="editTxt"><i class="fa fa-edit"></i><a id="edit-pic">Modifier ma photo de profil</a></li>
					<li class="editTxt"><i class="fa fa-edit"></i><a id="edit-name">Modifier mon pseudo</a></li>
					<li class="editTxt"><i class="fa fa-edit"></i><a id="edit-mail">Modifier mon adresse mail</a></li>
					<li class="editTxt"><i class="fa fa-edit"></i><a id="edit-pwd">Modifier mon mot de passe</a></li>
					<br/>
					<?php if(isset($erreur)) {echo '<span style="color: #f00;">'.$erreur."</span>";}?>
					<h5><i class="fa fa-sign-out"></i><a href="views/disconnect.php">Me déconnecter</a></h5>
				</ul>
			</div>

			<div class="align-items-center bg-light card d-flex justify-content-center m-4 p-4 " data-animate-top>
				<a href="portfolio.php" class="text-center text-dark text-decoration-none">
					<h4>MON PORTEFOLIO</h4>
					<h6>
						Gerer l'ensemble des images des utilisateurs et mettre des images
					</h6>
					<div style="display:inline-block; cursor:pointer;">
					<?php
						$files = scandir(PATH_GALERIE);
						/* NB ROWS */
						$connection = mysqli_connect("localhost", "root", "", BDD_DBNAME) or die("Erreur de connection: ".mysqli_error($connection));
						$query = "SELECT * FROM photo"; 
						$result = mysqli_query($connection, $query); 
						if ($result) {$row = mysqli_num_rows($result) +1; mysqli_free_result($result);}  
						mysqli_close($connection);
					
						for($i=0; $i <= $row; $i++){$table[$i]=$files[$i];}	
						$picToDisp = 2;
						
						for($x=0; $x <= $row; $x++){
							$requete = $bdd->query('SELECT * FROM photo Where nomFich="'.$table[$x].'" AND userId='.$localUser["id"].'');
							if($myPictures = $requete->fetch()){
								if($picToDisp > 0){
									$image = "assets/images/gallery/".$table[$x];
									
									echo '																			
										<img class="col-md-3 img-fluid mb-3" style="display: inline-block; height:300px;" src="'.$image.'" alt="'.$myPictures['description'].'">
									';
								}	
								$picToDisp--;		
							}			
						}			
						
					?>
					<img style="display: inline-block; height:300px;" src="assets/images/upload.jpg" alt="" class="col-md-3 img-fluid">
											
					</div>
				</a>
			</div>
					
			<div class="align-items-center bg-light card d-flex justify-content-center m-4 p-4 " data-animate-top>
				<?php include('views/stats.php'); ?>
			</div>
		</div>
		
		<?php
				}
				else{include('views/404.php');}
			}
			else{include('views/404.php');}
		?>
		
		<?php include('views/footer.php'); ?>
		
		<script>
			document.getElementById('edit-pic').onclick = function(){
				document.getElementById("editPic").style.display = 'block';
			}
			
			document.getElementById('edit-closePic').onclick = function() {
				document.getElementById("editMyPic").value = null;
				document.getElementById('profilId').src = <?php echo '"'.$userPdp.'"';?>;
				document.getElementById("editPic").style.display = 'none';	
			}
			
			$("#editPic").bind('input', function(){
				document.getElementById('profilId').src = document.getElementById('editMyPic').value;
			}); 

			function editOn(theBack, theCard){
				document.getElementById(theBack).style.display = 'block';
				document.getElementById(theCard).style.display = 'block';
			}
			
			function editOff(theBack, theCard, formName){
				document.getElementById(theBack).style.display = 'none';
				document.getElementById(theCard).style.display = 'none';
				document.getElementById(formName).reset();
			}
			
			document.getElementById('edit-name').onclick = function() {editOn("edit-back","edit-profilName");}
			document.getElementById('edit-closeName').onclick = function() {editOff("edit-back","edit-profilName","editName");}
			document.getElementById('edit-mail').onclick = function() {editOn("edit-back","edit-profilMail");}
			document.getElementById('edit-closeMail').onclick = function() {editOff("edit-back","edit-profilMail","editMail");}
			document.getElementById('edit-pwd').onclick = function() {editOn("edit-back","edit-profilPwd");}
			document.getElementById('edit-closePwd').onclick = function() {editOff("edit-back","edit-profilPwd","editPwd");}

			function print_error(errorId, errorStr) {
				document.getElementById(errorId).style.color = "red";
				document.getElementById(errorId).innerHTML = errorStr;
			}

			document.getElementById("editMyEmail").onfocus = function() {document.getElementById('disp_mail').innerHTML = null;}  
			document.getElementById("editMyEmailcf").onblur = function() {
				if(document.getElementById("editMyEmail").value != document.getElementById("editMyEmailcf").value && document.getElementById("editMyEmailcf").length != 0){
					print_error('disp_mail',"Les adresses ne correspondent pas.");
				} 
			}
			
			$('#editMail').submit(function(e){ 
				if(document.getElementById("editMyEmail").value != document.getElementById("editMyEmailcf").value && document.getElementById("editMyEmailcf").length != 0){
					e.preventDefault();
				} 
			});
			
			document.getElementById("editMyPwd").onfocus = function() {document.getElementById('disp_pwd').innerHTML = null; document.getElementById("message").style.display = "block";}  
			document.getElementById("editMyPwd").onblur = function() {
				document.getElementById("message").style.display = "none";
				if(document.getElementById("editMyPwd").length !=0 && document.getElementById("editMyPwd").value.match(/[a-z]/g) && document.getElementById("editMyPwd").value.match(/[A-Z]/g) && document.getElementById("editMyPwd").value.match(/[0-9]/g) && (document.getElementById("editMyPwd").value.length >= 8))  {
					document.getElementById('disp_pwd').innerHTML = null;
				}
				else {print_error('disp_pwd',"Votre mot de passe n'est pas assez sécurisé.");}
				
			}
			
			document.getElementById("editMyPwdcf").onfocus = function() {document.getElementById('disp_mdpcf').innerHTML = null;}  
			document.getElementById("editMyPwdcf").onblur = function() {
				if(document.getElementById("editMyPwd").value != document.getElementById("editMyPwdcf").value && document.getElementById("editMyPwdcf").length != 0){
					print_error('disp_pwd',"Les mots de passe ne correspondent pas.");
				} 
			}
			
			document.getElementById("editMyPwd").onkeyup = function() {
				if(document.getElementById("editMyPwd").value.match(/[a-z]/g)) {
				  document.getElementById("letter").classList.remove("invalid");
				  document.getElementById("letter").classList.add("valid");
				} 
				else {
					document.getElementById("letter").classList.remove("valid");
					document.getElementById("letter").classList.add("invalid");
				}
		 
				if(document.getElementById("editMyPwd").value.match(/[A-Z]/g)) {
					document.getElementById("capital").classList.remove("invalid");
					document.getElementById("capital").classList.add("valid");
				} 
				else {
					document.getElementById("capital").classList.remove("valid");
					document.getElementById("capital").classList.add("invalid");
				}
		 
				if(document.getElementById("editMyPwd").value.match(/[0-9]/g)) {
					document.getElementById("number").classList.remove("invalid");
					document.getElementById("number").classList.add("valid");
				} 
				else {
					document.getElementById("number").classList.remove("valid");
					document.getElementById("number").classList.add("invalid");
				}

				if(document.getElementById("editMyPwd").value.length >= 8) {
					document.getElementById("length").classList.remove("invalid");
					document.getElementById("length").classList.add("valid");
				} 
				else {
					document.getElementById("length").classList.remove("valid");
					document.getElementById("length").classList.add("invalid");
				}
			}
			
			$('#editPwd').submit(function(e){ 
				if(document.getElementById("editMyPwd").value != document.getElementById("editMyPwdcf").value && document.getElementById("editMyPwdcf").length != 0){
					e.preventDefault();
				} 
			});
		</script>
   </body>
</html>
