<?php  include('config.php'); ?>
<?php  include('includes/functions.php'); ?>
<?php 
	if (isset($_GET['slug_postare'])) {
		$postare = getPostare($_GET['slug_postare']);
	}
	$subiecte = getToateSubiectele();
?>
<?php include('includes/header.php'); ?>
<title> <?php echo $postare['titlu'] ?> | Blog</title>
</head>
<body>
<div class="container">
	<!-- Navbar -->
		<?php include( ROOT_PATH . '/includes/navbar.php'); ?>
	<!-- // Navbar -->
	
	<div class="content" >
		<!-- Page wrapper -->
		<div class="post-wrapper">
			<!-- div pentru intreaga postare-->
			<div class="full-post-div">
			<?php if ($postare['publicat'] == false): ?>
				<h2 class="post-title">Ne pare rau... Aceasta postare nu a fost publicata inca</h2>
			<?php else: ?>
				<h2 class="post-title"><?php echo $postare['titlu']; ?></h2>
				<div class="post-body-div">
					<?php echo html_entity_decode($postare['continut']); ?>
				</div>
			<?php endif ?>
			</div>
			<!-- // div pentru intreaga postare -->
			
			<!-- sectiunea de comentarii -->
			<!--  va urma aici ...  -->
		</div>
		<!-- // Page wrapper -->

		<!-- post sidebar -->
		<div class="post-sidebar">
			<div class="card">
				<div class="card-header">
					<h2>Subiecte</h2>
				</div>
				<div class="card-content">
					<?php foreach ($subiecte as $subiect): ?>
						<a 
							href="<?php echo BASE_URL . 'filtered_posts.php?subiect=' . $subiect['id'] ?>">
							<?php echo $subiect['nume']; ?>
						</a> 
					<?php endforeach ?>
				</div>
			</div>
		</div>
		<!-- // post sidebar -->
	</div>
</div>
<!-- // content -->

<?php include( ROOT_PATH . '/includes/footer.php'); ?>