<?php
//on demmare une session
session_start();

require_once('connect.php');

$sql = 'SELECT * FROM liste';

//on prepare la requete
$query = $db->prepare($sql);

//on execute la requete
$query->execute();

//on stock le resultat dans un tableau

$result = $query->fetchAll(PDO::FETCH_ASSOC);

require_once('close.php');


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
                <?php
                if (!empty($_SESSION['message'])) {
                    echo '<div class="alert alert-success" role="alert">
                        ' . $_SESSION['message'] . '
                        </div>';

                    $_SESSION['message'] = '';
                }
                ?>
                <h1>List des produits</h1>
                <table class="table">
                    <thead>
                        <th>ID</th>
                        <th>Produit</th>
                        <th>Prix</th>
                        <th>Nombre</th>
                        <th>Actif</th>
                        <th>Actions</th>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($result as $product) {
                        ?>
                            <tr>
                                <td><?= $product['id']; ?></td>
                                <td><?= $product['produit']; ?></td>
                                <td><?= $product['prix']; ?></td>
                                <td><?= $product['nombre']; ?></td>
                                <td><?= $product['actif']; ?></td>
                                <td>
                                    <a href="disable.php?id=<?= $product['id']; ?>">A/D</a>
                                    <a href="details.php?id=<?= $product['id']; ?>">Voir</a>
                                    <a href="edit.php?id=<?= $product['id']; ?>">Editer</a>
                                    <a href="delet.php?id=<?= $product['id']; ?>">Supprimer</a>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
                <a href="add.php" class="btn btn-primary mt-2">Ajouter</a>
            </div>
        </div>
    </main>

</body>

</html>