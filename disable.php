<?php
//on demmare une session
session_start();

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

    $actif = ($produit['actif'] == 0 ) ? 1 : 0;

    $sql = 'UPDATE liste SET actif=:actif WHERE `id` = :id;';

    //on prepare la requete
    $query = $db->prepare($sql);

    //on accroche les parametres
    $query->bindValue(':id', $id, PDO::PARAM_INT);
    $query->bindValue(':actif', $actif, PDO::PARAM_INT);


    //on execute la requete
    $query->execute();
    header('Location: index.php');


} else {
    $_SESSION['erreur'] = "URL Invalide";
    header('Location: index.php');
}

?>