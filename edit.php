<?php
//on demmare une session
session_start();

if ($_POST) {
    if (
        isset($_POST['id']) && !empty($_POST['id'])
        && isset($_POST['produit']) && !empty($_POST['produit'])
        && isset($_POST['prix']) && !empty($_POST['prix'])
        && isset($_POST['nombre']) && !empty($_POST['nombre'])
    ) {
        require_once('connect.php');

        //on nettoie  les données envoyer
        $id = strip_tags($_POST['id']);
        $produit = strip_tags($_POST['produit']);
        $prix = strip_tags($_POST['prix']);
        $nombre = strip_tags($_POST['nombre']);

        $sql = 'UPDATE liste SET `produit` =:produit, `prix` =:prix, `nombre` =:nombre 
        WHERE `id` = :id;';

        $query = $db->prepare($sql);

        $query->bindValue(':id', $id, PDO::PARAM_INT);
        $query->bindValue(':produit', $produit, PDO::PARAM_STR);
        $query->bindValue(':prix', $prix, PDO::PARAM_STR);
        $query->bindValue(':nombre', $nombre, PDO::PARAM_INT);

        $query->execute();

        $_SESSION['message'] = "Update Success !!!";
        require_once('close.php');
        header('Location: index.php');
    } else {
        $_SESSION['erreur'] = "Certain champ n'est pas valide";
    }
}

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
                <?php
                if (!empty($_SESSION['erreur'])) {
                    echo '<div class="alert alert-danger" role="alert">
                        ' . $_SESSION['erreur'] . '
                        </div>';

                    $_SESSION['erreur'] = '';
                }
                ?>
                <h1>Modifier un produit</h1>
                <form method="post">
                    <input type="hidden" name="id" value="<?= $produit['id']; ?>" />
                    <div class="form-group">
                        <label for="produit">Produit</label>
                        <input type="text" id="produit" name="produit" class="form-control" value="<?= $produit['produit']; ?>" />
                    </div>
                    <div class="form-group">
                        <label for="prix">Prix</label>
                        <input type="text" id="prix" name="prix" class="form-control" value="<?= $produit['prix']; ?>" />
                    </div>
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="number" id="nombre" name="nombre" class="form-control" value="<?= $produit['nombre']; ?>" />
                    </div>

                    <button type="submit" class="btn btn-primary mt-2">Update</button>
                </form>
            </div>
        </div>
    </main>

</body>

</html>