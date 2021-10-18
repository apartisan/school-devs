<?php 
// Variabile Admin utilizator
$admin_id = 0;
$editeazaUtilizatorul = false;
$username = "";
$rol = "";
$email = "";
// variabile generale
$errors = [];

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

/*******************************
 * 
 * 
 * 
 * 
 * Adaugate ulterior
 * 
 */
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
	$sql = "SELECT * FROM utilizatori WHERE rol IS NOT NULL";
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
?>