<?php
$pageSelected = "discussion";
session_start();

//se co à la bdd
try {
    $bdd = new PDO('mysql:host=localhost;dbname=discussion;charset=utf8', 'root', '');
} catch (Exception $e) {
    echo "Erreur:" . $e->getMessage();
}

if (isset($_POST['submit'])) {

    //VARIABLE
    $message = htmlspecialchars($_POST['message']);
    $id_utilisateur = $_SESSION['id_utilisateur'];

    //si le message n'est pas vide et envoyé
    if (!empty($message)) {
        //si la session existe
        if (isset($_SESSION['connect']) == 1) {

            //puis préparer la requête d'insertion
            $req = $bdd->prepare("INSERT INTO messages(message, id_utilisateur, date) VALUES(:message, :id_utilisateur, CURTIME())");
            $data = ['message' => $message,
                'id_utilisateur' => $id_utilisateur];

            //exécution de la requête préparée
            $req->execute($data);
            header('location:discussion.php');


        }

    } else echo "Vous n'avez pas saisie de message.";

}

//et l'afficher
$query = $bdd->query("SELECT messages.*, utilisateurs.*, DATE_FORMAT(date, '%d/%m/%Y') as new_date
                    FROM messages
                    INNER JOIN utilisateurs ON messages.id_utilisateur = utilisateurs.id
                    ORDER BY messages.id;");
$fetchAll = $query->fetchAll();

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/css/page.css">
    <link rel="stylesheet" href="styles/css/fa.css">
    <title>Discussion</title>
</head>
<body>
<header>
    <?php include 'header.php' ?>
</header>
<main>
    <div class="block">
        <div class="block-form">
            <?php foreach ($fetchAll as $data) { ?>
                <div class="commentairediscu">
                    <i> <?= $data['login'] ?> </i> le <?= $data['new_date'] ?> : <?= $data['message'] ?>
                </div>
            <?php } ?>
           <form action="" method="post" class="form-text">
               <label for="message">Message : </label>
               <textarea type="text" name="message" id="message" rows="5" ></textarea><br/><br/>
                <br/><br/>
                <input class="button" type="submit" name="submit" value="Poster">
            </form>
        </div>
    </div>
</main>
<footer>
    <?php include 'footer.php' ?>
</footer>
</body>
</html>