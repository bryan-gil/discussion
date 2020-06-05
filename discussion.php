<?php
session_start();

  //se co à la bdd
  try {
    $bdd = new PDO('mysql:host=localhost;dbname=discussion;charset=utf8', 'root', '');
}catch(Exception $e){
    echo "Erreur:" . $e->getMessage();
}

if($_SESSION['connect'] != 1){
    header('location:connexion.php');
}
if(isset($_POST['submit'])){

    //VARIABLE
    $message = htmlspecialchars($_POST['message']);
    $id_utilisateur = $_SESSION['id_utilisateur'];

    //si le message n'est pas vide et envoyé
    if(!empty($message)){
        //si la session existe
        if(isset($_SESSION['connect']) == 1){

            //puis préparer la requête d'insertion
            $req = $bdd->prepare("INSERT INTO messages(message, id_utilisateur, date) VALUES(:message, :id_utilisateur, CURTIME())");

            $data = ['message' => $message,
                    'id_utilisateur' => $id_utilisateur];
        
            //exécution de la requête préparée
            $req->execute($data);

            
        }

    }else echo "Vous n'avez pas saisie de message.";

}

//et l'afficher
$query = $bdd->query('SELECT * FROM messages');
$fetchAll = $query->fetchAll();

foreach($fetchAll as $data){
    echo $data['message']."<br />";
}

?>




<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Discussion</title>
</head>
<body>
    <form action="#" method="post">
    <label for="message">Entrez votre message:</label>
        <input type="text" name="message">
        <br /><br />
        <input type="submit" name="submit" alue="Poster">
    </form>
</body>
</html>