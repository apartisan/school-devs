<!DOCTYPE html>
<html>
<head>
	<!-- Fonturi google -->
	<link href="https://fonts.googleapis.com/css?family=Averia+Serif+Libre|Noto+Serif|Tangerine" rel="stylesheet">
	<!-- Stilizare -->
	<link rel="stylesheet" href="static/css/main.css">
	<meta charset="UTF-8">
	<title>Blog | Acasa </title>
</head>
<body>
	<!-- container - cuprinde intreaga pagina -->
	<div class="container">
		<!-- bara de navigare -->
		<div class="navbar">
			<div class="logo_div">
				<a href="index.php"><h1>Blog</h1></a>
			</div>
			<ul>
			  <li><a class="active" href="index.php">Acasa</a></li>
			  <li><a href="#news">Noutati</a></li>
			  <li><a href="#contact">Contact</a></li>
			  <li><a href="#about">Despre</a></li>
			</ul>
		</div>
		<!-- // bara de navigare -->

		<!-- Continutul paginii -->
		<div class="content">
			<h2 class="content-title">Articole Recente</h2>
			<hr>
			<!-- Urmeaza sa punem mai mult continut imediat ... -->
		</div>
		<!-- // Continutul paginii -->

		<!-- Subsol -->
		<div class="footer">
			<p>Blogul meu &copy; <?php echo date('Y'); ?></p>
		</div>
		<!-- // Subsol -->

	</div>
	<!-- // container -->
</body>
</html>





<?php foreach ($postari as $postare): ?>
                <div class="post" style="margin-left: 0px;">
                    <img src="<?php echo BASE_URL . 'static/images/' . $postare['imagine']; ?>" class="post_image" alt="">
                    <a href="single_post.php?slug-postare=<?php echo $postare['slug']; ?>">
                        <div class="post_info">
                            <h3><?php echo $postare['titlu'] ?></h3>
                            <div class="info">
                                <span><?php echo date("F j, Y ", strtotime($postare["creat_la"])); ?></span>
                                <span class="read_more">Citeste mai mult...</span>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endforeach ?>


<?php require_once('includes/header.php') ?>
	<title>Blog | Acasa </title>
	</head>
<body>
	<!-- container - cuprinde intreaga pagina -->
	<div class="container">
		<!-- bara de navigare -->
		<?php include('includes/navbar.php') ?>

		<!-- Page content -->
		<div class="content">
			<h2 class="content-title">Articole recente</h2>
			<hr>
			<!-- Urmeaza sa punem mai mult continut imediat ... -->
		</div>
	<!-- // Continutul paginii -->

		<!-- Subsol -->
		<?php include('includes/footer.php') ?>