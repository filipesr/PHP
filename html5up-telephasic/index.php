<!DOCTYPE HTML>
<!--
	Telephasic 1.1 by HTML5 UP
	html5up.net | @n33co
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
	<head>
		<title>Cor e Arte Películas</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<link href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,600" rel="stylesheet" type="text/css" />
		<!--[if lte IE 8]><script src="js/html5shiv.js"></script><![endif]-->
		<script src="js/jquery.min.js"></script>
		<script src="js/jquery.dropotron.min.js"></script>
		<script src="js/skel.min.js"></script>
		<script src="js/skel-panels.min.js"></script>
		<script src="js/init.js"></script>
		<noscript>
			<link rel="stylesheet" href="css/skel-noscript.css" />
			<link rel="stylesheet" href="css/style.css" />
			<link rel="stylesheet" href="css/style-n1.css" />
		</noscript>
	</head>
	<body class="homepage">

		<!-- Header Wrapper -->
			<div id="header-wrapper">
						
				<!-- Header -->
					<div id="header" class="container">
						
						<!-- Logo -->
							<h1 id="logo"><a href="#"> Portifólio... </a></h1>
						
						<!-- Nav -->
						
							<nav id="nav">
								<ul>
									<!--<li>
										<a href="">Dropdown</a>
										<ul>
											<li><a href="#">Lorem ipsum dolor</a></li>
											<li><a href="#">Magna phasellus</a></li>
											<li><a href="#">Etiam dolore nisl</a></li>
											<li>
												<span>Phasellus consequat</span>
												<ul>
													<li><a href="#">Lorem ipsum dolor</a></li>
													<li><a href="#">Phasellus consequat</a></li>
													<li><a href="#">Magna phasellus</a></li>
													<li><a href="#">Etiam dolore nisl</a></li>
												</ul>
											</li>
											<li><a href="#">Veroeros feugiat</a></li>
										</ul>
									</li>
									<li><a href="left-sidebar.html">Left Sidebar</a></li>-->
									<li><a href="http://www.coreartepeliculas.com.br">Ir para a loja...</a></li>
									<li class="break"><a href="#CONTATO">Contato</a></li>
								</ul>
							</nav>
						

					</div>

				<!-- Hero -->
					<section id="hero" class="container">
						<header>
							<h2>Portifólio de produtos<br />
							<a href="http://www.coreartepeliculas.com.br/">Cor e Arte Películas</a></h2>
						</header>
						<p>Aqui você encontra todo o nosso material de trabalho.</p>
						<ul class="actions">
							<li><a href="#PORTIFOLIO" class="button">Abrir portifólio</a></li>
						</ul>
					</section>

			</div>

			<a name="PORTIFOLIO"></a>
		<!-- Features 1 -->
<?php
// Configuration
require_once(dirname(dirname(__FILE__)).'/config.php');
//1� passo - Conecta ao servidor MySQL
if (!($id = mysql_connect(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD))) {
  echo "N&atilde;o foi poss&iacute;vel estabelecer uma conex�o com o gerenciador MySQL. Favor Contactar o Administrador.";
  exit;
}
//2� passo - Seleciona o Banco de Dados
if (!($con = mysql_select_db(DB_DATABASE, $id))) {
  echo "N&atilde;o foi poss&iacute;vel estabelecer uma conex�o com o banco MySQL. Favor Contactar o Administrador.";
  exit;
}
/*
select p.model
	 , cd.name 
  from product p
 inner join product_to_category pc 
		 on p.product_id = pc.product_id
 inner join category_description cd 
		 on pc.category_id = cd.category_id
 where     p.status = 1
	   and pc.category_id <> 91
 group by p.model
		, cd.name 
 order by cd.name
		, p.model
*/

$sql = "select p.model
			 , cd.name 
		  from product p
		 inner join product_to_category pc 
				 on p.product_id = pc.product_id
		 inner join category_description cd 
				 on pc.category_id = cd.category_id
		 where     p.status = 1
			   and pc.category_id <> 91
		 group by p.model
				, cd.name 
		 order by cd.name
				, p.model";
		 
// Database 
$db = @mysql_query($sql, $id);
$cat = '';
$i = 1;
while ($imgRow = mysql_fetch_array($db)) {
	if($imgRow[0]){
		if($cat <> $imgRow[1]){
			if($cat <> ''){
?>
					</div>
				</div>
			</div>
<?php
			} else if($i ++ % 3 == 0){
				$i = 1;
?>
					</div>
				</div>
			</div>
<?php
			}
			$cat = $imgRow[1];
?>
			<div id="promo-wrapper">
				<section id="promo">
					<h2><?php echo utf8_encode ( $imgRow[1] ) ?></h2>
				</section>
			</div>
			<div class="wrapper">
				<div class="container">
					<div class="row">
<?php
		}
?>
						<section class="4u feature">
							<header>
								<h1><a href="http://www.coreartepeliculas.com.br/<?php echo $imgRow[0] ?>" class="button"><?php echo utf8_encode ( $imgRow[1] ) ?> » <?php echo $imgRow[0] ?></a></h1>
							</header>
							<div class="image-wrapper first">
								<a href="http://www.coreartepeliculas.com.br/<?php echo $imgRow[0];?>" class="image full first"><img src="http://www.coreartepeliculas.com.br/image/data/produtos/<?php echo $imgRow[0] ?>.jpg" alt="" /></a>
							</div>
						</section>
<?php
}}
 ?>
					</div>
				</div>
			</div>
		<!-- Footer Wrapper -->
			<a name="CONTATO"></a>
			<div id="promo-wrapper">
				<section id="promo">
						<h2>Contato</h2>
						<span>Agora que conhece nossos produtos, acesse nossa loja e divírta-se!!</span>
					<div class="row no-collapse-1">
						<ul class="divided icons 4u">
							<!--<li class="fa fa-twitter"><a href="#"><span class="extra">twitter.com/</span>untitled</a></li>-->
							<li class="fa fa-facebook"><a href="https://www.facebook.com/corearteadesivos"><span class="extra">fb.com/</span>corearteadesivos</a></li>
						</ul>
						<ul class="divided icons 4u">
							<li><a href="mailto:contato@coreartepeliculas.com.brSubject=Portifólio" class="button">contato@coreartepeliculas.com.br</a></li>
							<!--<li class="fa fa-dribbble"><a href="#"><span class="extra">dribbble.com/</span>untitled</a></li>-->
						</ul>
						<!--<ul class="divided icons 6u">
							<li class="fa fa-linkedin"><a href="#"><span class="extra">linkedin.com/</span>untitled</a></li>
							<li class="fa fa-youtube"><a href="#"><span class="extra">youtube.com/</span>untitled</a></li>
							<li class="fa fa-pinterest"><a href="#"><span class="extra">pinterest.com/</span>untitled</a></li>
						</ul>-->
					</div>
				</section>
			
			</div>

	</body>
</html>