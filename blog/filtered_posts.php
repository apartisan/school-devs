<?php include('config.php'); ?>
<?php include('includes/functions.php'); ?>
<?php include('includes/header.php'); ?>
<?php 
	// Ia postarile dintr-un anumit subiect 
	if (isset($_GET['subiect'])) {
		$id_subiect = $_GET['subiect'];
		$postari = getPostariPublicateDupaSubiect($id_subiect);
	}
?>
	<title>Blog | Acasa </title>
</head>
<body>
<div class="container">
<!-- Navbar -->
	<?php include( ROOT_PATH . '/includes/navbar.php'); ?>
<!-- // Navbar -->
<!-- content -->
<div class="content">
	<h2 class="content-title">
		Articole din <u><?php echo getNumeSubiectDupaID($id_subiect); ?></u>
	</h2>
	<hr>
	<?php foreach ($postari as $postare): ?>
		<div class="post" style="margin-left: 0px;">
			<img src="<?php echo BASE_URL . '/static/images/' . $postare['imagine']; ?>" class="post_image" alt="">
			<a href="single_post.php?slug_postare=<?php echo $postare['slug']; ?>">
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
</div>
<!-- // content -->
</div>
<!-- // container -->

<!-- Footer -->
	<?php include( ROOT_PATH . '/includes/footer.php'); ?>
<!-- // Footer -->
