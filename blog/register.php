<?php  include('config.php'); ?>
<!-- Codul pentru gestionarea inregistrarii si autentificarii -->
<?php  include('includes/registration_login.php'); ?>

<?php include('includes/header.php'); ?>

<title>Blog | Inregistrare </title>
</head>
<body>
<div class="container">
	<!-- Navbar -->
		<?php include( ROOT_PATH . '/includes/navbar.php'); ?>
	<!-- // Navbar -->

	<div style="width: 40%; margin: 20px auto;">
		<form method="post" action="register.php" >
			<h2>Înregistreaza-te pe Blog</h2>
			<?php include(ROOT_PATH . '/includes/errors.php') ?>
			<input  type="text" name="username" value="<?php echo $username; ?>"  placeholder="Utilizator">
			<input type="email" name="email" value="<?php echo $email ?>" placeholder="Email">
			<input type="password" name="password_1" placeholder="Parola">
			<input type="password" name="password_2" placeholder="Confirmare parola">
			<button type="submit" class="btn" name="inreg_utilizator">Înregistreaza-te</button>
			<p>
				Esti deja membru? <a href="login.php">Logheaza-te</a>
			</p>
		</form>
	</div>
</div>
<!-- // container -->
<!-- Footer -->
	<?php include( ROOT_PATH . '/includes/footer.php'); ?>
<!-- // Footer -->