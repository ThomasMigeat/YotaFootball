<?php
	require_once('./config/configuration.php');
?>
		<footer class="font-small footer-area footer--light page-footer pt-3 text-white ">
			<div class="container text-center">
				<div class="row">
					<div class="col-md-4 col-sm-4">
						<div class="footer-widget">
							<div class="widget-about">
								<img src="<?php echo PATH_ICON_FOOTER; ?>" alt="" class="img-fluid">
								<p>Énigme du jour:<br/>축구는 스포츠 일까?</p>
								<ul class="list-unstyled m-0 p-0 reseaux text-center text-danger">
									<li class="d-inline-block"><a class="d-inline-block youtube" href="https://www.youtube.com/channel/UCheg0yI7kaMCNGx-S2feplQ"><i class="fa fa-youtube"></i></a></li>
									<li class="d-inline-block"><a class="d-inline-block instagram" href="https://www.instagram.com/yotafootball/?hl=fr"><i class="fa fa-instagram"></i></a></li>
									<li class="d-inline-block"><a class="d-inline-block twitter" href="https://twitter.com/YotaaFootball"><i class="fa fa-twitter"></i></a></li> 
								</ul><br/>
							</div>
						</div>
					</div>

					<div class="col-md-4 col-sm-4">
						<br/>
						<h4 class="footer-widget-title">LE SITE</h4>
						<ul class="list-unstyled text-danger">
							<li><br/>
								<a href="gallery.php">La Gallerie d'image</a>
							</li>
							<li><br/>
								<a href="history.php">L'épopée des Verts 1976</a>
							</li><br/>
							<li>
								<a href="history2.php">La Suprématie Lyonnais 2000</a>
							</li><br/>
						</ul>
					</div>
					
					<div class="col-md-4 col-sm-4">
						<br/>
						<h4 class="footer-widget-title">ESPACE UTILISATEUR</h4>
						<ul class="list-unstyled text-danger">
							<li><br/>
							<?php 
								if(isset($_SESSION['id']) == ""){
									?>
									<a href="login.php">Mon compte</a>
							<?php
								} else{
									?>
									<a href="<?php echo PATH_PROFIL; ?>">Mon profil</a>
							<?php
								}
							?>
								
							</li><br/>
							<li><br/>
								<a href="portfolio.php">Mon portefolio</a>
							</li>
						</ul>
					</div>
					
					<div class="container"> <hr></div>
			  </div>
			</div>

			<div class="footer-copyright py-3 text-center">
				YOTA Football ©, 2020.<br> By MIGEAT Thomas.
			</div>
		</footer>