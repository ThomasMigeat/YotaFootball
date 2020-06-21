<?php
	require_once('./config/configuration.php');	
	include('views/header.php');
	
	if(isset($_POST['formajout'])) {
   
		$nomFich = htmlspecialchars($_POST['nomFich']);
		$description = htmlspecialchars($_POST['description']);
		$nomCat = htmlspecialchars($_POST['nomCat']);
		$userId = htmlspecialchars($_SESSION['id']);

		if(!empty($_POST['nomFich']) AND !empty($_POST['description']) AND !empty($_POST['nomCat'])) {		 
			$reqNomFich = $bdd->prepare("SELECT * FROM photo WHERE nomFich = ?");
			$reqNomFich->execute(array($nomFich));
			$nomFichexist = $reqNomFich->rowCount();      
			if($nomFichexist == 0){
				if($nomCat='STATS'){$catId=1;}
				if($nomCat='LIGUE 1'){$catId=2;}
				if($nomCat='YOTA-NEWS'){$catId=3;}
				
				$insertPic = $bdd->prepare("INSERT INTO photo(photoId, nomFich, description,catId,userId,isShown) VALUES(?, ?, ?,?,?,?)");
				$insertPic->execute(array( "", $nomFich,$description,$catId,$userId,'1'));
				echo '<script>alert("Votre image a bien été ajoutée !")</script>';  	
			}
			else {echo '<script>alert("Cette image existe déjà !")</script>'; }
		} 
		else {
			$erreur = "Tous les champs doivent être complétés !";
		}
	}

	if(isset($_POST['modDes'])) {
					
		$descript = htmlspecialchars($_POST['descript']);
		$id= htmlspecialchars($_POST['iddes']);
		$editDes = $bdd->prepare("UPDATE photo set description='$descript' where photoId='".$id."' ");
			$editDes->execute(array( "", "",$descript,"","",""));
						 	echo '<script>alert("Votre description a bien été modifiée !")</script>'; 
	}	
	
	if(isset($_POST['modId'])) {
					
		$type = htmlspecialchars($_POST['nomCat']);
		if($type=="STATS")
		{
			$catId='1';
		}
		if($type=="LIGUE 1")
		{
			$catId='2';
		}
		if($type=="YOTA-NEWS")
		{
		$catId='3';
		}
			$id= htmlspecialchars($_POST['idty']);
			$editDes = $bdd->prepare("UPDATE photo set catId='$catId' where photoId='".$id."' ");
			$editDes->execute(array( "", "","",$type,"",""));
		 	echo '<script>alert("La catégorie a bien été modifiée !")</script>';  
	}	

	


	if(isset($_SESSION['id']) != ""){
?>

		<section style="width: 90% !important;" class="bg-light page mx-auto" >
			<a class="float-left font-weight-bold" href="<?php echo PATH_PROFIL ?>"><i class="fa fa-arrow-left"></i>Mon compte</a><br>
			<h1 class="font-weight-bold text-center">ACTUALITES</h1>
			<div class="row">
						
				<?php
					$files = scandir(PATH_GALERIE);

					/* NB ROWS */
					$connection = mysqli_connect("localhost", "root", "", BDD_DBNAME) or die("Erreur de connection: ".mysqli_error($connection));
					$query = "SELECT * FROM photo"; 
					$result = mysqli_query($connection, $query); 
					if ($result) {$row = mysqli_num_rows($result) +1; mysqli_free_result($result);}  
					mysqli_close($connection);
			
					for($i=0;$i<=$row;$i++){$table[$i]=$files[$i];}
				 
					for($x=0;$x<=$row;$x++){
						if( $userType != 'user' && $_SESSION['isShown']= '1' ){
							$requete = $bdd->query('SELECT * FROM photo Where nomFich="'.$table[$x].'"');
						}
						else{
							$requete = $bdd->query('SELECT * FROM photo Where nomFich="'.$table[$x].'" AND userId='.$_SESSION['id'].'');
						}
						
						if($myPictures = $requete->fetch()){
						$image = "assets/images/gallery/".$table[$x];
						$array_titre = explode('.',$table[$x]);
						$pictureOwner = $bdd->prepare('SELECT * FROM membre WHERE id ='.$myPictures['userId']);
						$pictureOwner->execute(array($myPictures['userId']));
						$pictureOwner = $pictureOwner->fetch(); 
						if($pictureOwner['type'] == "admin"){
							$pseudoOwner = $pictureOwner['pseudo']." [ADMIN]";
						}
						else{
							$pseudoOwner = $pictureOwner['pseudo'];
						}
						
						$pictureTitle = ucfirst($array_titre[0]).' posté par '.$pseudoOwner.".";
						$fileName = explode(".",$myPictures['nomFich']);
						$fileName = ucfirst($fileName[0]);
						
						if($myPictures['catId'] == 1) {$category = "STATS"; $color = "bg-secondary";}
						if($myPictures['catId'] == 2) {$category = "LIGUE 1"; $color = "bg-primary";}
						if($myPictures['catId'] == 3) {$category = "YOTA-NEWS"; $color = "bg-success";}
						
						
		
						echo '
							<div class="col-12 col-sm-6 col-lg-4 d-inline-block float-left pic">
								<div class="image-holder">
									<div class="image-shadow"></div>																				
									<img class="img-fluid" src="'.$image.'" alt="'.$myPictures['description'].'" onClick="zoomer(\''.$pictureTitle.'\',this.alt,this.src)"> 
								</div>                    
						
								<div>
									<div class="image-info">
										<p class="font-weight-bold">'.$fileName.'
											<span class="float-right pin"><i class="fa fa-heart" aria-hidden="true"></i>'.rand(4,4096).'</span>
										</p>
										<p class="pic-desc" style="height:45px; width: 60px;">'.$myPictures['description'].'</p>
										
										<p class="'.$color.' font-weight-bold pic-category text-center text-white col-md-8">'.$category.'</p>
										<div class="pic-user">
											<img class="img-fluid" style="height:45px; width: 60px;" src="'.$pictureOwner['photoprofil'].'">
										</div>
										<p class="font-weight-bold" style="overflow-wrap: break-word !important;">'?>
										<?php echo $pictureOwner['pseudo']; if($pictureOwner['type'] == "admin"){echo "[ADMIN]";}?><?php echo '</p>
									</div>
								</div>     
							</div>';
						}
					}
				?>
					
				<div class="col-12 col-sm-6 col-lg-4 d-inline-block float-left pic">
					<div class="image-holder">
						<div class="image-shadow"></div>
						<img class="img-fluid" src="assets/images/upload.jpg" alt="'.$resultat['description'].'" onClick="zoomer(\''.$titre.'\',this.alt,this.src)"> 
					</div>                    
					
					<div class="image-info">
						<form method="POST" action="" id="addMyPic">
							<label class="font-weight-bold" for="nomFich">Selectionnez une image:</label>
							<input id="fileUpload" onchange="checkSize()" class="col-md-11" type="file" id="nomFich" name="nomFich" required accept="image/jpg, image/jpeg, image/png" enctype="multipart/form-data"/>
							<br/><br/>
							<label for="description" class="font-weight-bold" style="color: #000;">Description:</label>
							<textarea required class="col-md-12 mb-3" id="description" name="description" maxlength="250" placeholder="Description de l'image" rows="8" style="resize: none;"></textarea>
										
							<div class="bg-dark font-weight-bold pic-category text-center text-white col-md-12">
								<label for="salutation">Categorie:</label><br/>
								<select required id="nomCat" name="nomCat">
									<option value="">- Aucun -</option>
									<option>STATS</option>
									<option>LIGUE 1</option>
									<option>YOTA-NEWS</option>
								</select>
							</div>
							 
							<br/>
							
							<p id="disp_add" class="font-weight-bold text-center"></p>
							<input type="submit" class="col-md-12 mx-auto w98btn" name="formajout" value="AJOUTER MA PHOTO!" />
						</form>
					</div>
				</div>  

				<div class="col-12 col-sm-12 col-lg-12 d-inline-block float-left pic">
					<h5 class="font-weight-bold text-center"><i class="fa fa-edit" aria-hidden="true"></i>GÉRER MES IMAGES</h5>
					<div class="container">
						<div class="row"> 
							<div class="table-responsive">
								<table class="table table-bordered table-hover text-center">
									<thead class="bd-warning">
										<tr class="bg-dark">
											<?php if($userType != 'user'){echo '<th class="text-white">ID</th>';}?>
											<th class="text-white">TITRE</th>
											<th class="text-white">CATÉGORIE</th>
											<th class="text-white">DESCRIPTION</th>
											<th class="text-white">ÉTAT DANS LA GALERIE</th>
											<th class="text-white">ACTION</th>
										</tr>
									</thead>
									<tbody>
										<?php
											$db = mysqli_connect("localhost", "root", "", BDD_DBNAME) or die("Erreur de connection: ".mysqli_error($db));
											if( $userType != 'user'){$records = mysqli_query($db,'SELECT * FROM photo');}
											else{$records = mysqli_query($db,'SELECT * FROM photo Where userId='.$_SESSION['id'].'');}

											while($data = mysqli_fetch_array($records)){
										?>
												<tr>
													<?php if($userType != 'user'){echo '<td>'.$data['photoId'].'</td>';} ?>
													<td><?php echo $data['nomFich']; ?></td>
													<td>
														<form method="POST">
															<label for="salutation">Categorie:</label><br/>
															<select required id="" name="nomCat">
																<option value="">- <?php if($data['catId'] == 1){echo "STATS";}if($data['catId'] == 2){echo "LIGUE 1";}if($data['catId'] == 3){echo "YOTA-NEWS";}?> -</option>
																<option>STATS</option>
																<option>LIGUE 1</option>
																<option>YOTA-NEWS</option>
																  <input type="hidden" id="idty" name="idty" value="<?php echo $data['photoId']?>">
																<input class="font-weight-bold wbtn" type="submit" name="modId" value="Modifier"/>
															</select>
															
														</form>
													</td>
														
													<td>
														<form method="POST">

															<textarea required class="col-md-12 mb-3" id="descript" name="descript" maxlength="250" placeholder="<?php echo $data['description']?>" rows="4" col="2" style="resize: none;"></textarea>
															  <input type="hidden" id="iddes" name="iddes" value="<?php echo $data['photoId']?>">
															<input class="font-weight-bold wbtn" type="submit" name="modDes" value="Modifier"/>
														</form>
													</td>

												
													<td>										
													
													<?php if($data['isShown'] == 1){?>
													
														<a class="w95btn" href="hide.php?id=<?php echo $data['photoId']; ?>"> <?php echo "Visible";?></a>
							 
													<?php }
														else{?>	
														<a class="w95btn" href="show.php?id=<?php echo $data['photoId']; ?>"><?php echo "Caché";?></a>
													<?php 
														} ?>
													</td>
													<td><a class="w95btn" href="delete.php?id=<?php echo $data['photoId']; ?>">Effacer</a></td>
												</tr>	
										<?php
											}
										?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
		</section>

		<div id="picZoom" class="position-fixed h-100 w-100 text-center zoom" style="z-index: 45 !important;">
			<p id="picZoomTitle" style="color:#fff"></p>
			<img class="zoom-content" style="border: 10px #fff solid;" id="imgToDisp">
			<p id="picZoomDesc" style="color:#fff"></p>
			<p id="picZoomInfo" style="color:#fff"></p>
		</div>
		<?php 
			}
			else{include('views/404.php');}
		?>
	
		<?php include('views/footer.php'); ?>
		
		<script>
			$('#addMyPic').submit(function(e){ 
				var oFile = document.getElementById("fileUpload").files[0]; 
				if (oFile.size >= 10240000000){
					e.preventDefault();
				} 
			});
							
			function checkSize() {
				var oFile = document.getElementById("fileUpload").files[0]; 
					if (oFile.size >= 10240000000) /* Car 100ko = 102 400octets*/{
					document.getElementById('disp_add').style.color = "#f00;";
					document.getElementById('disp_add').innerHTML = "Le fichier doit être inférieur à 100ko !";
				}
			}
			
			var zoom = document.getElementById('picZoom');
			var zoomDesc = document.getElementById("picZoomDesc");
			var zoomInfo = document.getElementById("picZoomInfo");
			var zoomTitre = document.getElementById("picZoomTitle");
			var zoomImg = document.getElementById("imgToDisp");

			function zoomer (titre, description, source){
				zoom.style.display = "block";
				zoomDesc.innerHTML = description;
				zoomTitre.innerHTML = titre;
				zoomImg.src = source;
				zoomImg.alt = titre;
			}

			zoom.onclick = function() {
				imgToDisp.className += " out";
				setTimeout(function() {
				   zoom.style.display = "none";
				   imgToDisp.className = "zoom-content";
				}, 300); 
			}
		</script>

    </body>
</html>
