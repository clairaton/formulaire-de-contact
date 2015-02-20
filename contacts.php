<?php
include_once ('header.php');
include_once ('inc/db.php');
// On crée une requête pour récupérer les contacts
$stmt= $db->query('SELECT lastname, firstname, email, adress, zip, city, phone FROM contact');
$contacts=$stmt->fetchAll();
?>
<!doctype html>
<html>
	<head>
		<meta charset="utf8">
		<title>Contact</title>
	</head>
	<body>
		<h1>Liste des contacts</h1>
		<table border="1" cellpadding="10">
			<thead>
				<tr>
					<th>Nom</th>
					<th>Prenom</th>
					<th>Email</th>
					<th>Adresse</th>
					<th>CP</th>
					<th>Ville</th>
					<th>Phone</th>
				</tr>
			</thead>

			<tbody>
			<?php
				// on crée une ligne pour chaque contact
				foreach($contacts as $contact){ ?>
				<tr>
				<?php // on crée un cellule pour chaque donnée
				foreach($contact as $data){
						echo "<td>$data</td>";
					}?>
				</tr>
				<?php }

			?>
			</tbody>
		</table>
		<a href="form_contact.php">retour formulaire de contact</a>
<?php
include_once ('footer.php');