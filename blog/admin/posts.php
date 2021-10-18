<?php  include('../config.php'); ?>
<?php  include(ROOT_PATH . '/admin/includes/admin_functions.php'); ?>
<?php  include(ROOT_PATH . '/admin/includes/post_functions.php'); ?>
<?php include(ROOT_PATH . '/admin/includes/head_section.php'); ?>

<!-- Get all admin posts from DB -->
<?php $postari = getToatePostarile(); ?>
	<title>Admin | Gestioneaza Postarile </title>
</head>
<body>
	<!-- admin navbar -->
	<?php include(ROOT_PATH . '/admin/includes/navbar.php') ?>

	<div class="container content">
		<!-- Meniu lateral -->
		<?php include(ROOT_PATH . '/admin/includes/menu.php') ?>

		<!-- Afiseaza inregistrarile din BD -->
		<div class="table-div"  style="width: 80%;">
			<!-- Afiseaza mesajele de notificare  -->
			<?php include(ROOT_PATH . '/includes/messages.php') ?>

			<?php if (empty($postari)): ?>
				<h1 style="text-align: center; margin-top: 20px;">Nici o postare in baza de date</h1>
			<?php else: ?>
				<table class="table">
						<thead>
						<th>Nr.</th>
						<th>Titlu</th>
						<th>Autor</th>
						<th>Vizualizari</th>
						<!-- Doar Administratorii pot publica postari -->
						<?php if ($_SESSION['utilizator']['rol'] == "Admin"): ?>
							<th><small>Publica</small></th>
						<?php endif ?>
						<th><small>Editeaza</small></th>
						<th><small>Sterge</small></th>
					</thead>
					<tbody>
					<?php foreach ($postari as $key => $postare): ?>
						<tr>
							<td><?php echo $key + 1; ?></td>
							<td><?php echo $postare['autor']; ?></td>
							<td>
								<a 	target="_blank"
								href="<?php echo BASE_URL . 'single_post.php?slug_postare=' . $postare['slug'] ?>">
									<?php echo $postare['titlu']; ?>	
								</a>
							</td>
							<td><?php echo $postare['vizualizari']; ?></td>
							
							<!-- Doar administratorii pot publica/depublica postari -->
							<?php if ($_SESSION['utilizator']['rol'] == "Admin" ): ?>
								<td>
								<?php if ($postare['publicat'] == true): ?>
									<a class="fa fa-check btn unpublish"
										href="posts.php?unpublish=<?php echo $postare['id'] ?>">
									</a>
								<?php else: ?>
									<a class="fa fa-times btn publish"
										href="posts.php?publish=<?php echo $postare['id'] ?>">
									</a>
								<?php endif ?>
								</td>
							<?php endif ?>

							<td>
								<a class="fa fa-pencil btn edit"
									href="create_post.php?edit-post=<?php echo $postare['id'] ?>">
								</a>
							</td>
							<td>
								<a  class="fa fa-trash btn delete" 
									href="create_post.php?delete-post=<?php echo $postare['id'] ?>">
								</a>
							</td>
						</tr>
					<?php endforeach ?>
					</tbody>
				</table>
			<?php endif ?>
		</div>
		<!-- // Display records from DB -->
	</div>
</body>
</html>