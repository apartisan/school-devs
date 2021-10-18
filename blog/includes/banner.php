<?php if (isset($_SESSION['utilizator']['username'])) { ?>
	<div class="logged_in_info">
		<span>Bine ai venit <?php echo $_SESSION['utilizator']['username'] ?></span>
		|
		<span><a href="logout.php">Deconectare</a></span>
	</div>
<?php }else{ ?>




<div class="banner">
	<div class="welcome_msg">
		<h1>Inspiratia zilei</h1>
		<p> 
		    Daca nu lupti pentru visele tale <br> 
		    atunci altcineva te va angaja sa <br> 
		    lupti pentru visele lui! <br>
			<span>~ Dhirubhai Ambani</span>
		</p>
		<a href="register.php" class="btn">Vino alaturi de noi!</a>
	</div>
	<div class="login_div">

		<form action="<?php echo BASE_URL . 'index.php'; ?>" method="post" >
				<h2>Login</h2>
				<div style="width: 60%; margin: 0px auto;">
					<?php include(ROOT_PATH . '/includes/errors.php') ?>
				</div>
				<input type="text" name="username" value="<?php echo $utilizator; ?>" placeholder="Utilizator">
				<input type="password" name="password"  placeholder="Parola"> 
				<button class="btn" type="submit" name="login_btn">Intra in cont</button>
			</form>
	</div>
</div>


<?php } ?>
<!--
<form action="index.php" method="post" >
			<h2>Login</h2>
			<input type="text" name="username" placeholder="Utilizator">
			<input type="password" name="password"  placeholder="Parola"> 
			<button class="btn" type="submit" name="login_btn">Intra in cont</button>
		</form>
-->

