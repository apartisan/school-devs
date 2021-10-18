<?php 
/* * * * * * * * * * * * * * *
* Returneaza toate postarile publicate
* * * * * * * * * * * * * * */
function getPostariPublicate() {
	// foloseste obiectul global $conn in functie
	global $conn;
	$sql = "SELECT * FROM postari WHERE publicat=true";
	$result = mysqli_query($conn, $sql);

	// preia toate postarile intr-o lista (array) asociativa numita $postari
	$postari = mysqli_fetch_all($result, MYSQLI_ASSOC);

	$postari_finale = array();
	foreach ($postari as $postare) {
		$postare['subiect'] = getPostareSubiect($postare['id']); 
		array_push($postari_finale, $postare);
	}
	return $postari_finale;


}

/**********************
 * 
 * Functie ce primeste un ID postare si
 * Returneaza subiectul postarii
 */

function getPostareSubiect($id_postare){
	global $conn;
	$sql = "SELECT * FROM subiecte WHERE id=
			(SELECT id_subiect FROM postari_subiecte WHERE id_postare=$id_postare) LIMIT 1";
	$result = mysqli_query($conn, $sql);
	$subiect = mysqli_fetch_assoc($result);
	return $subiect;
}

/* * * * * * * * * * * * * * * *
* Returneaza toate postarile dintr-un anumit subiect
* * * * * * * * * * * * * * * * */
function getPostariPublicateDupaSubiect($id_subiect) {
	global $conn;
	$sql = "SELECT * FROM postari ps 
			WHERE ps.id IN 
			(SELECT pt.id_postare FROM postari_subiecte pt 
				WHERE pt.id_subiect=$id_subiect GROUP BY pt.id_postare
				HAVING COUNT(1) = 1)";
	$result = mysqli_query($conn, $sql);
	// preia toate postarile ca o lista asociativa numita $postari
	$postari = mysqli_fetch_all($result, MYSQLI_ASSOC);

	$postari_finale= array();
	foreach ($postari as $postare) {
		$postare['subiect'] = getPostareSubiect($postare['id']); 
		array_push($postari_finale, $postare);
	}
	return $postari_finale;
}
/* * * * * * * * * * * * * * * *
* Returnează numele subiectului după ID-ul subiectului
* * * * * * * * * * * * * * * * */
function getNumeSubiectDupaID($id)
{
	global $conn;
	$sql = "SELECT nume FROM subiecte WHERE id=$id";
	$result = mysqli_query($conn, $sql);
	$subiect = mysqli_fetch_assoc($result);
	return $subiect['nume'];
}

/* * * * * * * * * * * * * * *
* Returneaza o singura postare
* * * * * * * * * * * * * * */
function getPostare($slug){
	global $conn;
	// Returneaza  slug-ul postarii
	$slug_postare = $_GET['slug_postare'];
	$sql = "SELECT * FROM postari WHERE slug='$slug_postare' AND publicat=true";
	$result = mysqli_query($conn, $sql);

	// preia rezultatele interogarii ca o lista (array) asociativa
	$postare = mysqli_fetch_assoc($result);
	if ($postare) {
		// preia subiectul de care apartine aceasta postare 
		$postare['subiect'] = getPostareSubiect($postare['id']);
	}
	return $postare;
}
/* * * * * * * * * * * *
* Returneaza toate subiectele
* * * * * * * * * * * * */
function getToateSubiectele()
{
	global $conn;
	$sql = "SELECT * FROM subiecte";
	$result = mysqli_query($conn, $sql);
	$subiecte = mysqli_fetch_all($result, MYSQLI_ASSOC);
	return $subiecte;
}



?>