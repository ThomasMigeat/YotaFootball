<?php
	require_once('./config/configuration.php');
	
	if(isset($_GET['id']) AND $_GET['id'] > 0) {
		$getid = intval($_GET['id']);
		$requser = $bdd->prepare('SELECT * FROM membre WHERE id = ?');
		$requser->execute(array($getid));
		$userinfo = $requser->fetch();
	}
	
	/* NB ROWS USERS */	
    $connection = mysqli_connect("localhost", "root", "", BDD_DBNAME) or die("Erreur de connection: ".mysqli_error($connection)); 
    $query = "SELECT * FROM membre"; 
    $result = mysqli_query($connection, $query); 
    if ($result){$rowUser = mysqli_num_rows($result); mysqli_free_result($result);}  
    mysqli_close($connection);
	
	 $connection = mysqli_connect("localhost", "root", "", BDD_DBNAME) or die("Erreur de connection: ".mysqli_error($connection)); 
    $query = "SELECT * FROM membre WHERE type = 'admin'"; 
    $result = mysqli_query($connection, $query); 
    if ($result){$rowAdmin = mysqli_num_rows($result); mysqli_free_result($result);}  
    mysqli_close($connection);
	
	/* NB ROWS Photos */
    $connection = mysqli_connect("localhost", "root", "", BDD_DBNAME) or die("Erreur de connection: ".mysqli_error($connection)); 
    $query = "SELECT * FROM photo"; 
    $result = mysqli_query($connection, $query); 
    if ($result){$rowimage = mysqli_num_rows($result); mysqli_free_result($result);}  
    mysqli_close($connection);
	
	/* NB ROWS Photos */
    $connection = mysqli_connect("localhost", "root", "", BDD_DBNAME) or die("Erreur de connection: ".mysqli_error($connection)); 
    $query = "SELECT * FROM photo Where catId=1"; 
    $result = mysqli_query($connection, $query); 
    if ($result){$rowK = mysqli_num_rows($result);mysqli_free_result($result);}  
    mysqli_close($connection);
	
	/* NB ROWS Photos */
    $connection = mysqli_connect("localhost", "root", "", BDD_DBNAME); 
    $query = "SELECT * FROM photo Where catId=2"; 
    $result = mysqli_query($connection, $query); 
    if ($result){$rowV = mysqli_num_rows($result);mysqli_free_result($result);}  
    mysqli_close($connection);

	/* NB ROWS Photos */
    $connection = mysqli_connect("localhost", "root", "", BDD_DBNAME) or die("Erreur de connection: ".mysqli_error($connection)); 
    $query = "SELECT * FROM photo  Where catId=3"; 
    $result = mysqli_query($connection, $query); 
    if ($result){$rowD = mysqli_num_rows($result); mysqli_free_result($result);}  
    mysqli_close($connection);
?>

	<h4 class="font-weight-bold">LES STATISTIQUES YOTA FOOTBALL: </h4><br/>

	<p class="text-dark"><i class="fa fa-camera" aria-hidden="true"></i>Nombre d'images totale: <?php echo $rowimage; ?></p>
	<p class="text-secondary"><i class="fa fa-picture-o" aria-hidden="true"></i>Nombre d'images dans STATS: <?php echo $rowK; ?></p>
	<p class="text-primary"><i class="fa fa-picture-o" aria-hidden="true"></i>Nombre d'images dans LIGUE 1: <?php echo $rowV; ?></p>
	<p class="text-success"><i class="fa fa-picture-o" aria-hidden="true"></i>Nombre d'images dans YOTA-NEWS: <?php echo $rowD; ?></p>
	
	
	<div class="col-12 col-sm-12 col-lg-12 d-inline-block float-left pic">
		<p class="font-weight-bold text-center"><i class="fa fa-users" aria-hidden="true"></i>Nombre d'utilisateurs: <?php echo $rowUser." (dont ".$rowAdmin." administrateurs)" ;?></p>
		<div class="container">
			<div class="row"> 
				<div class="table-responsive">
					<table class="table table-bordered table-hover text-center">
						<thead class="bd-warning">
							<tr class="bg-danger">
								<th class="text-white">ID</th>
								<th class="text-white">NOM</th>
								<th class="text-white">ADRESSE MAIL</th>
								<th class="text-white">TYPE DE COMPTE</th>
							</tr>
						</thead>
					
						<tbody>
							<?php
								for($i=0; $i <= $rowUser-1; $i++){
									$getUser = $bdd->prepare('SELECT * FROM membre WHERE id ='.$i);
									$getUser->execute(array($i));
									$getUser = $getUser->fetch();
								?>
									<tr>
										<td><?php echo $getUser['id']; ?></td>
										<td><a href="<?php 
											if($getUser['pseudo'] != $localUser['pseudo']){echo "profil.php?id=".$getUser['id'];}else{echo PATH_PROFIL;}?>">
										<?php echo $getUser['pseudo'];?></a></td>
										<td><?php echo $getUser['mail']; ?></td>
										<td><?php if($getUser['type'] == 'admin'){echo "ADMIN/USER";}else{echo "USER";}?></td>
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
	