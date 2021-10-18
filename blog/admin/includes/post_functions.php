<?php 
// variabilele postarii
$id_postare = 0;
$editeazaPostare = false;
$publicat = 0;
$titlu = "";
$slug_postare = "";
$continut = "";
$imagine = "";
$subiect_postare = "";

/* - - - - - - - - - - 
-  actiunile de postare
- - - - - - - - - - -*/
// data utilizatorul apasa pe butonul de creare postare
if (isset($_POST['create_post'])) { creeazaPostare($_POST); }
// daca utilizatorul apasa pe butonul de Editare 
if (isset($_GET['edit-post'])) {
	$editeazaPostare = true;
	$id_postare = $_GET['edit-post'];
	editeazaPostare($id_postare);
}
// daca utilizatorul apasa butonul de actualizare
if (isset($_POST['update_post'])) {
	actualizeazaPostare($_POST);
}
// daca se apasa pe butonul de stergere 
if (isset($_GET['delete-post'])) {
	$id_postare = $_GET['delete-post'];
	stergePostare($id_postare);
}
    // daca utilizatorul  apasa pe butonul de publicare 
    if (isset($_GET['publish']) || isset($_GET['unpublish'])) {
        $message = "";
        if (isset($_GET['publish'])) {
            $message = "Postarea publicata cu succes";
            $id_postare = $_GET['publish'];
        } else if (isset($_GET['unpublish'])) {
            $message = "Postarea nu mai este publica";
            $id_postare = $_GET['unpublish'];
        }
        comutaPostarePublicata($id_postare, $message);
    }


/* - - - - - - - - - - 
-  Functii postare
- - - - - - - - - - -*/
// Preia toate inregistrarile din BD 
function getToatePostarile()
{
	global $conn;
	
	// Administratorii pot vedea toate postarile 
	// Autorii pot vedea doar postarile lor
	if ($_SESSION['utilizator']['rol'] == "Admin") {
		$sql = "SELECT * FROM postari";
	} elseif ($_SESSION['utilizator']['rol'] == "Autor") {
		$user_id = $_SESSION['utilizator']['id'];
		$sql = "SELECT * FROM postari WHERE id_utilizator=$id_utilizator";
	}
	$result = mysqli_query($conn, $sql);
	$postari = mysqli_fetch_all($result, MYSQLI_ASSOC);

	$postari_finale = array();
	foreach ($postari as $postare) {
		$postare['autor'] = getAutorPostareDupaID($postare['id_utilizator']);
		array_push($postari_finale, $postare);
	}
	return $postari_finale;
}
// preia autorul / username de la postare 
function getAutorPostareDupaID($id_utilizator)
{
	global $conn;
	$sql = "SELECT username FROM utilizatori WHERE id=$id_utilizator";
	$result = mysqli_query($conn, $sql);
	if ($result) {
		// returneaza username
		return mysqli_fetch_assoc($result)['username'];
	} else {
		return null;
	}
}


/* - - - - - - - - - - 
-  continuare functii postare
- - - - - - - - - - -*/
function creeazaPostare($request_values)
	{
		global $conn, $errors, $titlu, $imagine, $id_subiect, $continut, $publicat;
		$titlu = esc($request_values['title']);
		$continut = htmlentities(esc($request_values['body']));
		if (isset($request_values['topic_id'])) {
			$id_subiect = esc($request_values['topic_id']);
		}
		if (isset($request_values['publish'])) {
			$publicat = esc($request_values['publish']);
		}
		// creeaza slug: 
		$slug_postare = executaSlug($titlu);
		// valideaza formular 
		if (empty($titlu)) { array_push($errors, "Este necesar titlul postarii"); }
		if (empty($continut)) { array_push($errors, "Nu ai pus continut"); }
		if (empty($id_subiect)) { array_push($errors, "Trebuie sa setezi subiectul postarii"); }
		// preia numele imaginii
	  	$imagine = $_FILES['featured_image']['name'];
	  	if (empty($imagine)) { array_push($errors, "Este necesara o imagine"); }
	  	// folderul unde se salveaza imaginea
	  	$target = "../static/images/" . basename($imagine);
	  	if (!move_uploaded_file($_FILES['featured_image']['tmp_name'], $target)) {
	  		array_push($errors, "Eroare de incarcare. Verificati setarile serverului ");
	  	}
		// Asigura ca nici o postare nu este salvata de doua ori  
		$query_verifica_postare = "SELECT * FROM postari WHERE slug='$slug_postare' LIMIT 1";
		$result = mysqli_query($conn, $query_verifica_postare);

		if (mysqli_num_rows($result) > 0) { // daca exista postari
			array_push($errors, " Deja exista o postare cu acest titlu.");
		}
		// creeaza postare daca nu sunt erori in formular
		if (count($errors) == 0) {
			$query = "INSERT INTO postari (id_utilizator, titlu, slug, imagine, continut, publicat, creat_la, actualizat_la) VALUES(1, '$titlu', '$slug_postare', '$imagine', '$continut', $publicat, now(), now())";
			if(mysqli_query($conn, $query)){ // daca postarea a fost creata cu succes
				$id_postare_indeserata = mysqli_insert_id($conn);
				// creeaza relatii intre postare si subiect 
				$sql = "INSERT INTO postari_subiecte (id_postare, id_subiect) VALUES($id_postare_inserata, $id_subiect)";
				mysqli_query($conn, $sql);

				$_SESSION['message'] = "Postarea a fost creata cu succes";
				header('location: posts.php');
				exit(0);
			}
		}
	}

	/* * * * * * * * * * * * * * * * * * * * *
	* - Preia ID-ul postarii ca parametru 
	* - Preia postarea din baza de date 
	* - seteaza campurile formularului pentru editare
	* * * * * * * * * * * * * * * * * * * * * */
	function editeazaPostare($role_id)
	{
		global $conn, $titlu, $slug_postare, $continut, $publicat, $editeazaPostare, $id_postare;
		$sql = "SELECT * FROM postari WHERE id=$role_id LIMIT 1";
		$result = mysqli_query($conn, $sql);
		$postare = mysqli_fetch_assoc($result);
		// seteaza valorile din formular pentru a fi actualizate 
		$titlu = $postare['titlu'];
		$continut = $postare['continut'];
		$publicat = $post['publicat'];
	}

	function actualizeazaPostare($request_values)
	{
		global $conn, $errors, $id_postare, $titlu, $imagine, $id_subiect, $continut, $publicat;

		$titlu = esc($request_values['title']);
		$continut = esc($request_values['body']);
		$id_postare = esc($request_values['post_id']);
		if (isset($request_values['topic_id'])) {
			$id_subiect = esc($request_values['topic_id']);
		}
		// creeaza  slug
		$slug_postare = executaSlug($titlu);

		if (empty($titlu)) { array_push($errors, "Este nevoie de titlu"); }
		if (empty($continut)) { array_push($errors, "Nu ai pus continut"); }
		// daca s-a adaugat o alta imagine 
		if (isset($_POST['featured_image'])) {
			// preia numele imaginii
		  	$imagine = $_FILES['featured_image']['name'];
		  	// folderul de salvare
		  	$target = "../static/images/" . basename($imagine);
		  	if (!move_uploaded_file($_FILES['featured_image']['tmp_name'], $target)) {
		  		array_push($errors, "Eroare de incarcare. Verificati setarile serverului");
		  	}
		}

		// inregistreaza subiectul daca nu sunt erori in formular 
		if (count($errors) == 0) {
			$query = "UPDATE postari SET titlu='$titlu', slug='$slug_postare', vizualizari=0, imagine='$imagine', continut='$continut', publicat=$publicat, actualizat_la=now() WHERE id=$id_postare";
			// ataseaza subiectul la postare in tabela postari_subiecte 
			if(mysqli_query($conn, $query)){ // daca postarea a fost creata cu succes 
				if (isset($topic_id)) {
					$id_postare_inserata = mysqli_insert_id($conn);
					// creeaza relatia dintre postare si subiect 
					$sql = "INSERT INTO postari_subiecte (id_postare, id_subiect) VALUES($id_postare_inserata, $id_subiect)";
					mysqli_query($conn, $sql);
					$_SESSION['message'] = "Postarea a fost creata cu succes";
					header('location: posts.php');
					exit(0);
				}
			}
			$_SESSION['message'] = "Postare actualizata cu succes";
			header('location: posts.php');
			exit(0);
		}
	}
	// sterge postare
	function stergePostare($id_postare)
	{
		global $conn;
		$sql = "DELETE FROM postari WHERE id=$id_postare";
		if (mysqli_query($conn, $sql)) {
			$_SESSION['message'] = "Postarea a fost stearsa cu succes";
			header("location: posts.php");
			exit(0);
		}
	}


function comutaPostarePublicata($id_postare, $message)
{
	global $conn;
	$sql = "UPDATE postari SET publicat = !publicat WHERE id=$id_postare";
	
	if (mysqli_query($conn, $sql)) {
		$_SESSION['message'] = $message;
		header("location: posts.php");
		exit(0);
	}
}

?>