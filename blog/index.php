<!-- Prima incluziune ar trebui sa fie config.php -->
<?php require_once('config.php') ?>
<?php require_once( ROOT_PATH . '/includes/functions.php') ?>
<?php require_once( ROOT_PATH . '/includes/registration_login.php') ?>

<!-- Preia toate postarile din baza de date -->
<?php $postari = getPostariPublicate(); ?>

<?php require_once( ROOT_PATH . '/includes/header.php') ?>

	<title>Blog | Acasa </title>
</head>
<body>
	<!-- container - cuprinde intreaga pagina -->
	<div class="container">
		<!-- bara de navigare -->   
		<?php include( ROOT_PATH . '/includes/navbar.php') ?>
		<!-- // bara de navigare -->

        <!-- banner -->
		<?php include( ROOT_PATH . '/includes/banner.php') ?>
		<!-- // banner -->
        
        <!-- Continutul paginii -->
		<div class="content">
			<h2 class="content-title">Articole Recente</h2>
			<hr>
			<!-- Urmeaza sa punem mai mult continut imediat ... -->

            <?php foreach ($postari as $postare): ?>
                <div class="post" style="margin-left: 0px;">
                    <img src="<?php echo BASE_URL . 'static/images/' . $postare['imagine']; ?>" class="post_image" alt="">
								
				<!-- Am adaugat acest IF... -->
				<?php if (isset($postare['subiect']['nume'])): ?>
							<a 
								href="<?php echo BASE_URL . 'filtered_posts.php?subiect=' . $postare['subiect']['id'] ?>"
								class="btn category">
								<?php echo $postare['subiect']['nume'] ?>
							</a>
						<?php endif ?>


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
		<!-- // Continutul paginii -->

		<!-- Subsol -->
		<?php include( ROOT_PATH . '/includes/footer.php') ?>
		<!-- // Subsol -->
