<?php
include_once ('header.php');
// Créer une connexion à la base de données "contact"
include_once ('inc/db.php');
// Contrôler les champs obligatoires "nom, prenom, email"
$fields = array(
	'lastname' => array(
		'type' => 'text',
		'name' => 'nom',
		'label' => 'Nom',
		'size' => '20',
		'required' => true
	),
	'firstname'  => array(
		'type' => 'text',
		'name' => 'prenom',
		'label' => 'Prénom',
		'size' => '20',
		'required' => true
	),
	'email'      => array(
		'type' => 'email',
		'name' => 'email',
		'label' => 'E-mail',
		'size' => '40',
		'required' => true
	),
	'adress'      => array(
		'type' => 'text',
		'name' => 'adresse',
		'label' => 'Adresse',
		'size' => '60',
		'required' => false
	),
	'zip'      => array(
		'type' => 'text',
		'name' => 'cp',
		'label' => 'Code Postal',
		'size' => '10',
		'required' => false
	),
	'city'      => array(
		'type' => 'text',
		'name' => 'ville',
		'label' => 'Ville',
		'size' => '10',
		'required' => false
	),
	'phone'      => array(
		'type' => 'text',
		'name' => 'phone',
		'label' => 'Téléphone',
		'size' => '20',
		'required' => false
	),
);

// j'initialise mes variables de récupération de donnée
foreach($fields as $key => $array){
	$$key='';
}
// Réceptionner les données du formulaire
if(!empty($_POST)){
	// j'initialise un tableau signifiant si une erreur a été detectée
	$error= false;
	// j'initialise un tableau récapitulant les champs en erreur
	$errors=array();
	foreach($fields as $key => $array){
		if ($array['required'] && empty($_POST[$array['name']])) {
			$error= true;
			$errors[$key]= "Ce champs est obligatoire";
		}
		elseif(!empty($_POST[$array['name']])){
			$$key=strip_tags($_POST[$array['name']]);
		}
	}
	// Créer une requête d'insertion PDO avec les données du formulaire
	if(!$error){
		$stmt=$db->prepare("INSERT INTO contact (lastname,firstname,email,adress,city,zip,phone) VALUES (:lastname,:firstname,:email,:adress,:city,:zip,:phone)");
		foreach($fields as $key => $array){
			$stmt ->bindValue($key,$$key,PDO::PARAM_STR);
		}
		$stmt->execute();
		$new_insert=$db->lastInsertId();

		header ('location:contacts.php');
		exit();
	}
}
// Créer un fichier contacts.php qui va afficher la liste des contacts dans un table html
?>
		<h1>Formulaire de Contact</h1>
		<form action="form_contact.php" method="POST">
			<?php
				// on génère les champs du formulaire
				foreach($fields as $key => $array){ ?>
					<?=$array['label']?><span id="required"><?=$required = $array['required']? '*' : '';?></span> : <input type="<?=$array['type']?>" size="<?=$array['size']?>" name="<?=$array['name']?>" value="<?=$$key?>">
					<p><?=isset($errors[$key])?$errors[$key]:'';?></p>
				<?php
			}
			?>
			<p>Tous les champs marqués d'une * sont obligatoires</p>
			<input type="submit" value="Envoyer">
		</form>
<?php
include_once ('footer.php');
