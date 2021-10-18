<?php 
// Variabile Admin utilizator
$admin_id = 0;
$editeazaUtilizatorul = false;
$username = "";
$rol = "";
$email = "";
// variabile generale
$errors = [];

// Variabilele subiectelor
$id_subiect = 0;
$editeazaSubiectul = false;
$nume_subiect = "";




/* - - - - - - - - - - 
-  Actiunile administratorilor 
- - - - - - - - - - -*/
//  daca utilizatorul apasa butonul de creare admin 
if (isset($_POST['create_admin'])) {
	creeazaAdmin($_POST);
}
// Daca apasa pe editare amin 
if (isset($_GET['edit-admin'])) {
	$editeazaUtilizatorul = true;
	$admin_id = $_GET['edit-admin'];
	editeazaAdmin($admin_id);
}
// daca apasa pe actualizare admin
if (isset($_POST['update_admin'])) {
	actualizeazaAdmin($_POST);
}
// Daca apasa pe stergere admin 
if (isset($_GET['delete-admin'])) {
	$admin_id = $_GET['delete-admin'];
	stergeAdmin($admin_id);
}


/* - - - - - - - - - - 
-  Actiuni subiect
- - - - - - - - - - -*/
//Daca utilizatorul apasa pe butonul de creare subiect
if (isset($_POST['create_topic'])) { creeazaSubiect($_POST); }
// Daca utilizatorul apasa pe butonul de editare 
if (isset($_GET['edit-topic'])) {
	$editeazaSubiectul = true;
	$id_subiect = $_GET['edit-topic'];
	editeazaSubiect($id_subiect);
}
// Daca utilizatorul apasa pe butonul de actualizare 
if (isset($_POST['update_topic'])) {
	actualizeazaSubiect($_POST);
}
// if user clicks the Delete topic button
if (isset($_GET['delete-topic'])) {
	$id_subiect = $_GET['delete-topic'];
	stergeSubiect($id_subiect);
}



/* - - - - - - - - - - - -
-  functii administrare
- - - - - - - - - - - - -*/
/* * * * * * * * * * * * * * * * * * * * * * *
* - Primeste date din formular
* - Creaza noi utilizatori de administrare
* - Returneaza toti utilizatorii admin dupa rol
* * * * * * * * * * * * * * * * * * * * * * */
function creeazaAdmin($request_values){
	global $conn, $errors, $role, $username, $email;
	$username = esc($request_values['username']);
	$email = esc($request_values['email']);
	$password = esc($request_values['password']);
	$passwordConfirmation = esc($request_values['passwordConfirmation']);

	if(isset($request_values['role'])){
		$rol = esc($request_values['role']);
	}
	// validare formular: se asigura ca formularul este completat corect
	if (empty($username)) { array_push($errors, "Este nevoie de nume de utilizator"); }
	if (empty($email)) { array_push($errors, "Oops.. nu ai scris emailul"); }
	if (empty($rol)) { array_push($errors, "Este necesar un rol pentru utilizatori");}
	if (empty($password)) { array_push($errors, "Ai uitat sa pui parola"); }
	if ($password != $passwordConfirmation) { array_push($errors, "Parolele nu se potrivesc"); }
	// Asigura ca se introduce de mai multe ori un nume de utilizator 
	// Email-ul si utilizatorii ar trebui sa fie unici
	$verif_utiliz_query = "SELECT * FROM utilizatori WHERE username='$username' 
							OR email='$email' LIMIT 1";
	$result = mysqli_query($conn, $verif_utiliz_query);
	$utilizator = mysqli_fetch_assoc($result);
	if ($utilizator) { // daca exista
		if ($user['username'] === $username) {
		  array_push($errors, "Utilizatorul deja exista");
		}

		if ($user['email'] === $email) {
		  array_push($errors, "Email-ul deja exista");
		}
	}
	// inregistreaza utilizator daca nu sunt erori
	if (count($errors) == 0) {
		$password = md5($password);//cripteaza parola
		$query = "INSERT INTO utilizatori (username, email, rol, password, creat_la, actualizat_la) 
				  VALUES('$username', '$email', '$rol', '$password', now(), now())";
		mysqli_query($conn, $query);

		$_SESSION['message'] = "Utilizatorul admin a fost creat cu succes";
		header('location: users.php');
		exit(0);
	}
}
/* * * * * * * * * * * * * * * * * * * * *
* - ia parametrul ID-ul adminului
* - Preia administratorul din BD
* - seteaza campurile active de la formular pentru editare
* * * * * * * * * * * * * * * * * * * * * */
function editeazaAdmin($admin_id)
{
	global $conn, $username, $rol, $editeazaUtilizatorul, $admin_id, $email;

	$sql = "SELECT * FROM utilizatori WHERE id=$admin_id LIMIT 1";
	$result = mysqli_query($conn, $sql);
	$admin = mysqli_fetch_assoc($result);

	// seteaza valorile formularului ($username and $email)pentru a fi actualizate
	$username = $admin['username'];
	$email = $admin['email'];
}

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * 
* - Primeste cererea de administrator din formular si actualizeaza BD
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
function actualizeazaAdmin($request_values){
	global $conn, $errors, $rol, $username, $isEditingUser, $admin_id, $email;
	// preia ID-ul administratorului pentru actualizare
	$admin_id = $request_values['admin_id'];
	// seteaza starea de editare la fals
	$editeazaUtilizatorul = false;


	$username = esc($request_values['username']);
	$email = esc($request_values['email']);
	$password = esc($request_values['password']);
	$passwordConfirmation = esc($request_values['passwordConfirmation']);
	if(isset($request_values['role'])){
		$rol = $request_values['role'];
	}
	// inregistreaza utilizator daca nu sunt erori in formular
	if (count($errors) == 0) {
		$password = md5($password);

		$query = "UPDATE utilizatori SET username='$username', email='$email', rol='$rol', password='$password' WHERE id=$admin_id";
		mysqli_query($conn, $query);

		$_SESSION['message'] = "Utilizatorul a fost actualizat cu succes";
		header('location: users.php');
		exit(0);
	}
}
// sterge utilizatorul
function stergeAdmin($admin_id) {
	global $conn;
	$sql = "DELETE FROM utilizatori WHERE id=$admin_id";
	if (mysqli_query($conn, $sql)) {
		$_SESSION['message'] = "Utilizatorul a fost sters";
		header("location: users.php");
		exit(0);
	}
}











/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * 
* -  Returneaza toti utilizatorii administrator si rolurile corespunzatoare
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
function getAdministratori(){
	global $conn, $roluri;
	$sql = "SELECT * FROM utilizatori ";
	$result = mysqli_query($conn, $sql);
	$utilizatori = mysqli_fetch_all($result, MYSQLI_ASSOC);

	return $utilizatori;
}


function getUtilizatori(){
	global $conn;
	$sql = "SELECT * FROM utilizatori WHERE rol IS NULL";
	$result = mysqli_query($conn, $sql);
	$utilizatori = mysqli_fetch_all($result, MYSQLI_ASSOC);

	return $utilizatori;
}


/* * * * * * * * * * * * * * * * * * * * *
* - Scapa de valoarea trimisa din formular, astfel incat sa impiedice injectia SQL
* * * * * * * * * * * * * * * * * * * * * */
function esc(String $value){
	global $conn;
	$val = trim($value); 
	$val = mysqli_real_escape_string($conn, $value);
	return $val;
}
// Primeste un sir de tipul "Ana are mere"
// si returneaza "ana-are-mere"
function executaSlug(String $string){
	$string = strtolower($string);
	$slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $string);
	return $slug;
}




/* - - - - - - - - - - 
-  Functii subiecte
- - - - - - - - - - -*/
// Preia toate subiectele din BD 
function getToateSubiectele() {
	global $conn;
	$sql = "SELECT * FROM subiecte";
	$result = mysqli_query($conn, $sql);
	$subiecte = mysqli_fetch_all($result, MYSQLI_ASSOC);
	return $subiecte;
}
function creeazaSubiect($request_values){
	global $conn, $errors, $nume_subiect;
	$nume_subiect = esc($request_values['topic_name']);
	// creeaza slug: daca subiectul este " Sfaturi Prietenesti", returneaza "sfaturi-prietenesti"  ca slug
	$slug_subiect = executaSlug($nume_subiect);
	// valideaza formularul
	if (empty($nume_subiect)) { 
		array_push($errors, "Este nevoie de numele subiectului"); 
	}
	// Ne asiguram ca nici un subiect nu este salvat de doua ori.
	$query_verifica_subiect = "SELECT * FROM subiecte WHERE slug='$slug_subiect' LIMIT 1";
	$result = mysqli_query($conn, $query_verifica_subiect);
	if (mysqli_num_rows($result) > 0) { // daca exista subiect
		array_push($errors, "Subiectul deja exista");
	}
	// inregistreaza subiectul daca nu sunt erori in formular 
	if (count($errors) == 0) {
		$query = "INSERT INTO subiecte (nume, slug) 
				  VALUES('$nume_subiect', '$slug_subiect')";
		mysqli_query($conn, $query);

		$_SESSION['message'] = "Subiectul a fost creat cu succes";
		header('location: topics.php');
		exit(0);
	}
}
/* * * * * * * * * * * * * * * * * * * * *
* - Preia ID-ul subiectului ca parametru 
* - Preia subiectul din BD 
* - seteaza campurile formularului pentru editare
* * * * * * * * * * * * * * * * * * * * * */
function editeazaSubiect($id_subiect) {
	global $conn, $nume_subiect, $editeazaSubiectul, $id_subiect;
	$sql = "SELECT * FROM subiecte WHERE id=$id_subiect LIMIT 1";
	$result = mysqli_query($conn, $sql);
	$subiect = mysqli_fetch_assoc($result);
	// seteaza valorile formularului ($nume_subiect) pentru a fi actualizate
	$nume_subiect = $topic['nume'];
}
function actualizeazaSubiect($request_values) {
	global $conn, $errors, $nume_subiect, $id_subiect;
	$nume_subiect = esc($request_values['topic_name']);
	$id_subiect = esc($request_values['topic_id']);
	// creeaza slug: daca subiectul este " Sfaturi Prietenesti", returneaza "sfaturi-prietenesti"  
	$slug_subiect = executaSlug($nume_subiect);
	// valideaza formularul
	if (empty($nume_subiect)) { 
		array_push($errors, "Numele subiectului este necesar"); 
	}
	// actualizeaza subiectul daca nu sunt erori in formular
	if (count($errors) == 0) {
		$query = "UPDATE subiecte SET nume='$nume_subiect', slug='$slug_subiect' WHERE id=$id_subiect";
		mysqli_query($conn, $query);

		$_SESSION['message'] = "Subiectul a fost actualizat";
		header('location: topics.php');
		exit(0);
	}
}
// sterge subiect
function stergeSubiect($id_subiect) {
	global $conn;
	$sql = "DELETE FROM subiecte WHERE id=$id_subiect";
	if (mysqli_query($conn, $sql)) {
		$_SESSION['message'] = "Subiectul a fost sters cu succes";
		header("location: topics.php");
		exit(0);
	}
}

?>