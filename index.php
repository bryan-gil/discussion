<?php
$pageSelected = "index";
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="styles/css/page.css">
    <link rel="stylesheet" href="styles/css/fa.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index</title>
</head>
<body id="index" class="<?= isset($_SESSION['id']) && $admin['id'] == $_SESSION['id'] ? "is-admin" : ""; ?>">
<header>
    <?php include 'header.php'; ?>
</header>
<main>
    <div class="main-photo">
        <img src="styles/image/beans-coffee-cup-mug-34079.jpg" alt="background" width="1400px" height="700px">
        <div class="caption"> <p> Discutez avec nos graines au plus prêt de la nature </p></div>
    </div>
</main>
<footer>
    <?php include 'footer.php'; ?>
</footer>
</body>
</html>