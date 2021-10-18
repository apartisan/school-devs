<?php 
	// declarare variabile
	$username = "";
	$email    = "";
	$errors = array(); 

	// Inregistrare utilizator
	if (isset($_POST['inreg_utilizator'])) {
		// primeste toate valorile scrie in formular 
		$username = esc($_POST['username']);
		$email = esc($_POST['email']);
		$password_1 = esc($_POST['password_1']);
		$password_2 = esc($_POST['password_2']);

		// validarea formularului:  ne asiguram ca formularul este corect completat
		if (empty($username)) {  array_push($errors, "Uhmm...Avem nevoie de numele de utilizator"); }
		if (empty($email)) { array_push($errors, "Oops.. Email-ul lipseste"); }
		if (empty($password_1)) { array_push($errors, "Ai uitat parola"); }
		if ($password_1 != $password_2) { array_push($errors, "Cele doua parole nu se potrivesc");}

		// Ne asiguram ca un utilizator nu se poate inregistra de doua ori
		// email-ul si numele de utilizator trebuie sa fie unice 
		$user_check_query = "SELECT * FROM utilizatori WHERE username='$username' 
								OR email='$email' LIMIT 1";

		$result = mysqli_query($conn, $user_check_query);
		$utilizator = mysqli_fetch_assoc($result);

		if ($utilizator) { // daca utilizatorul exista
			if ($utilizator['username'] === $username) {
			  array_push($errors, "Numele de utilizator deja exista");
			}
			if ($utilizator['email'] === $email) {
			  array_push($errors, "Email-ul deja exista");
			}
		}
		//  inregistreaza utilizator daca nu sunt erori in formular
		if (count($errors) == 0) {
			$password = md5($password_1);//cripteaza parola inainte de a o salva in baza de date
			$query = "INSERT INTO utilizatori (username, email, password, creat_la, actualizat_la) 
					  VALUES('$username', '$email', '$password', now(), now())";
			mysqli_query($conn, $query);

			// preia ID-ul utilizatorului creat 
			$id_utilizator_inreg = mysqli_insert_id($conn); 

			// pune utilizatorul conectat in sesiune
			$_SESSION['utilizator'] = getUtilizatorDupaID($id_utilizator_inreg);

			// daca utilizatorul este administrator, redirectioneaza catre zona de administrare
			if ( in_array($_SESSION['utilizator']['rol'], ["Admin", "Autor"])) {
				$_SESSION['mesaj'] = "Esti logat";
				// redirectioneaza catre zona de administrare
				header('location: ' . BASE_URL . 'admin/dashboard.php');
				exit(0);
			} else {
				$_SESSION['mesaj'] = "Esti logat";
				// redirectioneaza la zona publica
				header('location: index.php');				
				exit(0);
			}
		}
	}

	// Logheaza utilizatorul
	if (isset($_POST['login_btn'])) {
		$username = esc($_POST['username']);
		$password = esc($_POST['password']);

		if (empty($username)) { array_push($errors, "Este nevoie de numele de utilizator"); }
		if (empty($password)) { array_push($errors, "Nu ai pus parola"); }
		if (empty($errors)) {
			$password = md5($password); // cripteaza parola 
			$sql = "SELECT * FROM utilizatori WHERE username='$username' and password='$password' LIMIT 1";

			$result = mysqli_query($conn, $sql);
			if (mysqli_num_rows($result) > 0) {
				// preia id-ul utilizatorului logat
				$id_utiliz_logat = mysqli_fetch_assoc($result)['id']; 

				//  pune utilizatorul logat in sesiune 
				$_SESSION['utilizator'] = getUtilizatorDupaID($id_utiliz_logat); 

				// daca este Admin, redirectioneaza in zona de administrare
				if ( in_array($_SESSION['utilizator']['rol'], ["Admin", "Autor"])) {
					$_SESSION['mesaj'] = "Esti logat";
					// redirectioneaza la zona de administrare
					header('location: ' . BASE_URL . '/admin/dashboard.php');
					exit(0);
				} else {
					$_SESSION['mesaj'] = "Esti logat";
					// redirectioneaza la zona publica
					header('location: index.php');				
					exit(0);
				}
			} else {
				array_push($errors, 'Utilizatorul sau parola sunt gresite');
			}
		}
	}
	// scapam de valorile din formular
	function esc(String $value)
	{	
		// aducem in functie obiectul global de conectare la baza de date
		global $conn;

		$val = trim($value); // elimina spatiul gol
		$val = mysqli_real_escape_string($conn, $value);

		return $val;
	}
	// obtine informatii despre utilizator dupa ID-ul acestuia
	function getUtilizatorDupaID($id)
	{
		global $conn;
		$sql = "SELECT * FROM utilizatori WHERE id=$id LIMIT 1";

		$result = mysqli_query($conn, $sql);
		$utilizator = mysqli_fetch_assoc($result);

		
		return $utilizator; 
	}
?>