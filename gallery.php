<?php include('views/header.php'); ?>
		<script src="https://use.fontawesome.com/fe459689b4.js"></script>
		<section style="width: 90% !important;" class="bg-light page mx-auto"  >
		
			<form action="gallery.php" method="post" class="button-group d-block filters-button-group text-center">
				<button class="bg-dark button c-pointer font-weight-bold text-white" type="submit" name="all">TOUTES</button>
				<button class="bg-secondary button c-pointer font-weight-bold text-white" type="submit" name="stats">STATS</button>
				<button class="bg-primary button c-pointer font-weight-bold text-white" type="submit" name="ligue1">LIGUE 1</button>
				<button class="bg-success button c-pointer font-weight-bold text-white" type="submit" name="yotafootball">YOTA-NEWS</button>
			</form>

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
					for($x=0; $x <=$row; $x++){
						
						$requete = $bdd->query('SELECT * FROM photo Where nomFich="'.$table[$x].'"');
						
						if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['all'])){
							$requete = $bdd->query('SELECT * FROM photo Where nomFich="'.$table[$x].'"');
						}
						
						if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['stats'])){
							$requete = $bdd->query('SELECT * FROM photo Where nomFich="'.$table[$x].'" AND catId = 1');
						}
						if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['ligue1'])){
							$requete = $bdd->query('SELECT * FROM photo Where nomFich="'.$table[$x].'" AND catId = 2');
						}
						if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['yotafootball'])){
							$requete = $bdd->query('SELECT * FROM photo Where nomFich="'.$table[$x].'" AND catId = 3');
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
						
						if($myPictures['isShown'] == 1){
							echo '
								<div class="col-12 col-sm-6 col-lg-4 d-inline-block float-left pic">
									<div class="image-holder">
										<div class="image-shadow"></div>																				
										<img class="img-fluid" src="'.$image.'" alt="'.$myPictures['description'].'" onClick="zoomer(\''.$pictureTitle.'\',this.alt,this.src)"> 
									</div>                    
							
									<div>
										<div class="image-info">
											<p class="font-weight-bold">'.$fileName.' 
												<button class="jul" id="vert"><i class="fa fa-thumbs-up fa-lg" aria-hidden="true"></i></button>
												<button class="jul" id="rouge"><i class="fa fa-thumbs-down fa-lg" aria-hidden="true"></i></button>


											</p>
											<p class="pic-desc" style="">'.$myPictures['description'].'</p>
											
											<p class="'.$color.' font-weight-bold pic-category text-center text-white col-md-8">'.$category.'</p>
											<div class="pic-user">
												<img class="img-fluid" style="height:45px; width: 45px;" src="'.$pictureOwner['photoprofil'].'">
											</div>
											<p class="font-weight-bold" style="overflow-wrap: break-word !important;">'?>
											<?php echo $pictureOwner['pseudo']; if($pictureOwner['type'] == "admin"){echo "[ADMIN]";}?><?php echo '</p>
										</div>
									</div>     
								</div>';
							}
						}
					}
				?>
				<!-- <a href="like_dislike.php?t=1&id<?=$id ?>">like</a> <?= $likes ?>-->
				<!--<a href="like_dislike.php?t=2&id<?=$id ?>">dislikes</a> <?= $dislikes ?>-->
			</div>
		</section>

		<div id="picZoom" class="position-fixed h-100 w-100 text-center zoom" style="z-index: 45 !important;">
			<p id="picZoomTitle" style="color:#fff"></p>
			<img class="zoom-content" style="border: 10px #fff solid;" id="imgToDisp">
			<p id="picZoomDesc" style="color:#fff"></p>
			<p id="picZoomInfo" style="color:#fff"></p>
		</div>

		<?php include('views/footer.php'); ?>
		
		<script>
			if ( window.history.replaceState ) {window.history.replaceState( null, null, window.location.href );}


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
			
			
			$(document).ready(function(){
				$(".like").click(function(){
					$(this).toggleClass("heart");
				});
			});
			
			var btn1 = document.querySelector('#vert');
			var btn2 = document.querySelector('#rouge');

				btn1.addEventListener('click', function() {
				if (btn2.classList.contains('rouge')) {
					btn2.classList.remove('rouge');
					} 
				this.classList.toggle('vert');
				});

				btn2.addEventListener('click', function() {
				if (btn1.classList.contains('vert')) {
					btn1.classList.remove('vert');
					} 
				this.classList.toggle('rouge'); 
		});


			
		</script>		
	


    </body>
</html>
