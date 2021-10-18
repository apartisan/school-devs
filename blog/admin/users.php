<?php  include('../config.php'); ?>
<?php  include(ROOT_PATH . '/admin/includes/admin_functions.php'); ?>
<?php 
	// Preia toti administratorii din baza de date
	$administratori = getAdministratori();
	$roluri = ['Admin', 'Autor'];				
?>
<?php include(ROOT_PATH . '/admin/includes/head_section.php'); ?>
	<title>Admin | Gestioneaza utilizatori</title>
</head>
<body>
	<!-- admin navbar -->
	<?php include(ROOT_PATH . '/admin/includes/navbar.php') ?>
	<div class="container content">
		<!-- Meniul din stanga -->
		<?php include(ROOT_PATH . '/admin/includes/menu.php') ?>
		<!-- Formular din mijloc - pentru a crea si edita  -->
		<div class="action">
			<h1 class="page-title">Creeaza/Editeaza Administrator Utilizator</h1>

			<form method="post" action="<?php echo BASE_URL . 'admin/users.php'; ?>" >

				<!-- erori de validare a formularului -->
				<?php include(ROOT_PATH . '/includes/errors.php') ?>

				<!-- Daca editeaza utilizatorul curent, este nevoie pentru ID pentru a identifica utilizatorul -->
				<?php if ($editeazaUtilizatorul === true): ?>
					<input type="hidden" name="admin_id" value="<?php echo $admin_id; ?>">
				<?php endif ?>

				<input type="text" name="username" value="<?php echo $username; ?>" placeholder="Utilizator">
				<input type="email" name="email" value="<?php echo $email ?>" placeholder="Email">
				<input type="password" name="password" placeholder="Parola">
				<input type="password" name="passwordConfirmation" placeholder="Confirmare parola">
				<select name="role">
					<option value="" selected disabled>Atribuie rol</option>
					<?php foreach ($roluri as $key => $rol): ?>
						<option value="<?php echo $rol; ?>"><?php echo $rol; ?></option>
					<?php endforeach ?>
				</select>

				<!-- daca editeaza utilizatorul curent,  afiseaza butonul de actualizare in loc de cel de  creare -->
				<?php if ($editeazaUtilizatorul === true): ?> 
					<button type="submit" class="btn" name="update_admin">ACTUALIZARE</button>
				<?php else: ?>
					<button type="submit" class="btn" name="create_admin">Salvare utilizator</button>
				<?php endif ?>
			</form>
		</div>
		<!-- // Formularul din mijloc  - pentru a crea si edita -->

		<!-- Afiseaza inregistrarile din baza de date-->
		<div class="table-div">
			<!-- Afiseaza mesajele de notificare -->
			<?php include(ROOT_PATH . '/includes/messages.php') ?>

			<?php if (empty($administratori)): ?>
				<h1>Nu sunt administratori in baza de date</h1>
			<?php else: ?>
				<table class="table">
					<thead>
						<th>Nr.</th>
						<th>Admin</th>
						<th>Rol</th>
						<th colspan="2">Actiune</th>
					</thead>
					<tbody>
					<?php foreach ($administratori as $key => $admin): ?>
						<tr>
							<td><?php echo $key + 1; ?></td>
							<td>
								<?php echo $admin['username']; ?>, &nbsp;
								<?php echo $admin['email']; ?>	
							</td>
							<td><?php echo $admin['rol']; ?></td>
							<td>
								<a class="fa fa-pencil btn edit"
									href="users.php?edit-admin=<?php echo $admin['id'] ?>">
								</a>
							</td>
							<td>
								<a class="fa fa-trash btn delete" 
								    href="users.php?delete-admin=<?php echo $admin['id'] ?>">
								</a>
							</td>
						</tr>
					<?php endforeach ?>
					</tbody>
				</table>
			<?php endif ?>
		</div>
		<!-- // Afiseaza inregistrarile din baza de date -->
	</div>
</body>
</html>