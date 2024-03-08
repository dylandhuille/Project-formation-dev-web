<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="/public/assets/css/style.css">
    <title>Colocation</title>
</head>

<body>
    <!--navbar responsive-->
    <nav class="navbar navbar-expand-md navbar-dark bg-success sticky-top fs-3">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="/controllers/research-ctrl.php">Rechercher</a>
                    </li>
                   
                    <?php
                    if (empty($_SESSION['user'])) {
                    ?>
                    <?php } else { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="../../controllers/update-signUp-ctrl.php">Modifier mon Compte</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../../controllers/adSubmissionForm-controller.php">Déposer une annonce</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../../controllers/myProperty-ctrl.php">Mes annonces</a>
                        </li>
                    <?php } ?>
                </ul>
            <div class="d-flex justify-content-end navbar-text">
                <?php
                if (empty($_SESSION['user'])) {
                ?>
                    <a href="/controllers/signUp-ctrl.php">Inscription</a>
                    /
                    <a href="/controllers/signIn-ctrl.php">Connexion</a>
                <?php } else { ?>
                    <?= $_SESSION['user']->firstname ?> <?= $_SESSION['user']->lastname ?>&nbsp;
                    <a href="/controllers/signOut-ctrl.php">Déconnexion</a>
                <?php } ?>
 </div>
            </div>
        </div>
    </nav>
    <!--fin navbar responsive-->