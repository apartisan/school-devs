<?php  include('../config.php'); ?>
<?php  include(ROOT_PATH . '/admin/includes/admin_functions.php'); ?>
<?php  include(ROOT_PATH . '/admin/includes/post_functions.php'); ?>
<?php include(ROOT_PATH . '/admin/includes/head_section.php'); ?>
<!-- Preia toate subiectele -->
<?php $subiecte = getToateSubiectele();	?>
	<title>Admin | Creeaza postare</title>
</head>
<body>
	<!-- admin navbar -->
	<?php include(ROOT_PATH . '/admin/includes/navbar.php') ?>

	<div class="container content">
		<!-- meniu lateral -->
		<?php include(ROOT_PATH . '/admin/includes/menu.php') ?>

		<!-- formularul de mijloc - pentru a crea si edita  -->
		<div class="action create-post-div">
			<h1 class="page-title">Creeaza / Editeaza postare</h1>
			<form method="post" enctype="multipart/form-data" action="<?php echo BASE_URL . 'admin/create_post.php'; ?>" >
				<!-- valideaza erorile din formular -->
				<?php include(ROOT_PATH . '/includes/errors.php') ?>

				<!-- if editing post, the id is required to identify that post -->
				<?php if ($editeazaPostare === true): ?>
					<input type="hidden" name="post_id" value="<?php echo $id_postare; ?>">
				<?php endif ?>

				<input type="text" name="title" value="<?php echo $titlu; ?>" placeholder="Titlu">
				<label style="float: left; margin: 5px auto 5px;">Imagine</label>
				<input type="file" name="featured_image" >
				<textarea name="body" id="body" cols="30" rows="10"><?php echo $continut; ?></textarea>
				<select name="topic_id">
					<option value="" selected disabled>Alege subiect</option>
					<?php foreach ($subiecte as $subiect): ?>
						<option value="<?php echo $subiect['id']; ?>">
							<?php echo $subiect['nume']; ?>
						</option>
					<?php endforeach ?>
				</select>
				
				<!-- Doar administratorii pot vedea campul de Publicare -->
				<?php if ($_SESSION['utilizator']['rol'] == "Admin"): ?>
					<!-- afiseaza o caseta de bifat in caz ca postul este publicat sau nu  -->
					<?php if ($publicat == true): ?>
						<label for="publish">
							Publica
							<input type="checkbox" value="1" name="publish" checked="checked">&nbsp;
						</label>
					<?php else: ?>
						<label for="publish">
							Publica
							<input type="checkbox" value="1" name="publish">&nbsp;
						</label>
					<?php endif ?>
				<?php endif ?>
				
				<!-- Daca editeaza postarea, afiseaza butonul de actualizare   -->
				<?php if ($editeazaPostare === true): ?> 
					<button type="submit" class="btn" name="update_post">ACTUALIZEAZA</button>
				<?php else: ?>
					<button type="submit" class="btn" name="create_post">Salveaza postare</button>
				<?php endif ?>

			</form>
		</div>
		<!-- // formularul de mijloc - pentru a crea si edita -->
	</div>
</body>
</html>

<script>
	CKEDITOR.replace('body');
</script>