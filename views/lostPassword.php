<!--fin navbar responsive-->
<!--corp du site-->
<h1 class="text-success text-center">Colocation</h1>
<div class="container-fluid">
    <div class="row ">
        <div class="col-sm-12 col-lg-7">
            <img class="img-fluid" src="<?= '/../../public/assets/img/illustrationAccueil.jpg' ?>" alt="illustration page d'accueil">
        </div>
        <div class="col-sm-12 col-lg-4">

            <form class="d-grid gap-2" action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post" id="formUser">

                <div class="form-group">
                    <!--$erreur = Adresse e-mail ou mot de passe invalide-->
                    <div><?= $erreur ?? '' ?></div>
                    <label for="email">Adresse e-mail *</label>
                    <!-- email -->
                    <input type="email" name="email" id="email" value="<?= htmlentities($email ?? '') ?>" class="form-control <?= isset($error['email']) ? 'errorField' : '' ?>" placeholder="Votre E-mail" autocomplete="email" required>
                    <div class="error"><?= $error['email'] ?? '' ?></div>
                </div>
                <input type="submit" class="btn btn-success btn-default" id="validForm-connexion"></input>
            </form>
        </div>
    </div>
</div>