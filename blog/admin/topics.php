<?php  include('../config.php'); ?>
<?php  include(ROOT_PATH . '/admin/includes/admin_functions.php'); ?>
<?php include(ROOT_PATH . '/admin/includes/head_section.php'); ?>
<!-- Preia toate subiectele din BD -->
<?php $subiecte = getToateSubiectele();	?>
	<title>Admin | Gestioneaza subiectele</title>
</head>
<body>
	<!-- admin navbar -->
	<?php include(ROOT_PATH . '/admin/includes/navbar.php') ?>
	<div class="container content">
		<!-- meniu lateral -->
		<?php include(ROOT_PATH . '/admin/includes/menu.php') ?>

		<!-- Formularul din centru pentru a edita si crea -->
		<div class="action">
			<h1 class="page-title">Creeaza/editeaza Subiecte </h1>
			<form method="post" action="<?php echo BASE_URL . 'admin/topics.php'; ?>" >
				<!-- valideaza erorile din formular  -->
				<?php include(ROOT_PATH . '/includes/errors.php') ?>
				<!-- Daca editeaza subiectul este nevoie de ID pentru a-l identifica-->
				<?php if ($editeazaSubiectul === true): ?>
					<input type="hidden" name="topic_id" value="<?php echo $id_subiect; ?>">
				<?php endif ?>
				<input type="text" name="topic_name" value="<?php echo $nume_subiect; ?>" placeholder="Subiect">
				<!-- Daca editeaza subiectul, arata butonul de actualizare, in loc de Creeaza -->
				<?php if ($editeazaSubiectul === true): ?> 
					<button type="submit" class="btn" name="update_topic">ACTUALIZARE</button>
				<?php else: ?>
					<button type="submit" class="btn" name="create_topic">Salveaza subiect</button>
				<?php endif ?>
			</form>
		</div>
		<!-- // Formularul din centru pentru a edita si crea -->

		<!-- Arata inregistrarile din BD -->
		<div class="table-div">
			<!-- Afiseaza mesajele de notificare  -->
			<?php include(ROOT_PATH . '/includes/messages.php') ?>
			<?php if (empty($subiecte)): ?>
				<h1>Nici un subiect in baza de date</h1>
			<?php else: ?>
				<table class="table">
					<thead>
						<th>Nr.</th>
						<th>Nume Subiect</th>
						<th colspan="2">Actiuni</th>
					</thead>
					<tbody>
					<?php foreach ($subiecte as $key => $subiect): ?>
						<tr>
							<td><?php echo $key + 1; ?></td>
							<td><?php echo $subiect['nume']; ?></td>
							<td>
								<a class="fa fa-pencil btn edit"
									href="topics.php?edit-topic=<?php echo $subiect['id'] ?>">
								</a>
							</td>
							<td>
								<a class="fa fa-trash btn delete"								
									href="topics.php?delete-topic=<?php echo $subiect['id'] ?>">
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