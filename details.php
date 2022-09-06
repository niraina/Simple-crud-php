<?php
//on demmare une session
session_start();

//Est ce que l'id existe et n'est pas vide dans l'URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    require_once('connect.php');

    //on nettoie l'id envoyé
    $id = strip_tags($_GET['id']);

    $sql = 'SELECT * FROM liste WHERE `id` = :id;';

    //on prepare la requete
    $query = $db->prepare($sql);

    //on accroche les parametre (id)
    $query->bindValue(':id', $id, PDO::PARAM_INT);

    //on execute la requete
    $query->execute();

    //on recupere le produit
    $produit = $query->fetch();

    //on verifie si le produit existe
    if (!$produit) {
        $_SESSION['erreur'] = "Cette id n'existe pas";
        header('Location: index.php');
    }
} else {
    $_SESSION['erreur'] = "URL Invalide";
    header('Location: index.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="	https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
</head>

<body>
    <main class="container">
        <div class="row">
            <div class="col-12">
                <h1>Details du produit <?= $produit['produit']; ?></h1>
                <p>ID : <?= $produit['id']; ?></p>
                <p>Quantitée : <?= $produit['nombre']; ?></p>
                <p>Prix : <?= $produit['prix']; ?> Ar</p>
            </div>
        </div>
    </main>

</body>

</html>