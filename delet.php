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
        die();
    }

    $sql = 'DELETE FROM liste WHERE `id` = :id;';

    //on prepare la requete
    $query = $db->prepare($sql);

    //on accroche les parametre (id)
    $query->bindValue(':id', $id, PDO::PARAM_INT);

    //on execute la requete
    $query->execute();

    $_SESSION['erreur'] = "Produit supprimer";
    header('Location: index.php');

} else {
    $_SESSION['erreur'] = "URL Invalide";
    header('Location: index.php');
}
