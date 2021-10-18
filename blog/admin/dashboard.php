<?php  include('../config.php'); ?>
	<?php include(ROOT_PATH . '/admin/includes/admin_functions.php'); ?>
    <?php $utilizatori = getUtilizatori();?>
	<?php include(ROOT_PATH . '/admin/includes/head_section.php'); ?>
	<title>Admin | Dashboard</title>
</head>
<body>
	<div class="header">
		<div class="logo">
			<a href="<?php echo BASE_URL .'admin/dashboard.php' ?>">
				<h1>Blog - Admin</h1>
			</a>
		</div>
		<?php if (isset($_SESSION['utilizator'])): ?>
			<div class="user-info">
				<span><?php echo $_SESSION['utilizator']['username'] ?></span> &nbsp; &nbsp; 
				<a href="<?php echo BASE_URL . '/logout.php'; ?>" class="logout-btn">Deconectare</a>
			</div>
		<?php endif ?>
	</div>
	<div class="container dashboard">
		<h1>Bine ai venit</h1>
		<div class="stats">
			<a href="users.php" class="first">
				<span><?php echo count($utilizatori) ?></span> <br>
				<span>Utilizatori noi inregistrati</span>
			</a>
			<a href="posts.php">
				<span>43</span> <br>
				<span>Postari publicate</span>
			</a>
			<a>
				<span>43</span> <br>
				<span>Comentarii publicate</span>
			</a>
		</div>
		<br><br><br>
		<div class="buttons">
			<a href="users.php">Adauga utilizatori</a>
			<a href="posts.php">Adauga postari</a>
		</div>
	</div>
</body>
</html>