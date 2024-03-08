<!--fin navbar responsive-->
<!--corp du site-->
<h1 class="text-success text-center">Colocation</h1>
<div class="container-fluid">
    <div class="row ">
        <div class="col-sm-12 col-lg-7">
            <img class="img-fluid" src="<?= '/../../public/assets/img/illustrationAccueil.jpg' ?>" alt="illustration page d'accueil">
        </div>
        <div class="col-sm-12 col-lg-4">
            <form class="d-grid gap-2" action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post" id="signUpForm">
                <?= $customMessage ?? '' ?>
                <div class="form-group">
                    <!-- lastname -->
                    <label for="lastname">Nom *</label>
                    <input type="text" name="lastname" id="lastname" placeholder="Entrez votre nom" class="form-control <?= isset($error['lastname']) ? 'errorField' : '' ?>" autocomplete="family-name" value="<?= $user->lastname ?? '' ?>" minlength="2" maxlength="70" required pattern="<?= REGEX_NO_NUMBER ?>">
                    <div class="error"><?= $error['lastname'] ?? '' ?></div>
                </div>
                <div class="form-group">
                    <label for="firstname">Prénom *</label>
                    <!-- firstname -->
                    <input type="text" name="firstname" id="firstname" value="<?= $user->firstname ?? '' ?>" minlength="2" maxlength="70" placeholder="Entrez votre prénom" class="form-control <?= isset($error['firstname']) ? 'errorField' : '' ?>" autocomplete="given-name" pattern="<?= REGEX_NO_NUMBER ?>" required>
                    <div class="error"><?= $error['firstname'] ?? '' ?></div>
                </div>
                <div class="form-group">
                    <label for="pseudonym">pseudonym *</label>
                    <!-- pseudonym -->
                    <input type="text" name="pseudonym" id="pseudonym" class="form-control <?= isset($error['pseudonym']) ? 'errorField' : '' ?>" autocomplete="nickname" value="<?= $user->pseudonym ?? '' ?>" minlength="2" maxlength="70" placeholder="Entrez votre pseudonym" required pattern="<?= REGEX_NO_NUMBER ?>">
                </div>
                <div class="form-group">
                    <label for="email">Adresse e-mail *</label>
                    <!-- email -->
                    <input type="email" name="email" id="email" value="<?= htmlentities($email ?? '') ?>" class="form-control <?= isset($error['email']) ? 'errorField' : '' ?>" placeholder="Votre E-mail" autocomplete="email" required>
                    <div class="error"><?= $error['email'] ?? '' ?></div>
                </div>
                <div class="mb-3">
                    <label for="password1" class="form-label">Mot de passe *</label>
                    <input type="password" name="password1" class="form-control" id="password1" required>
                    <div class='text-danger' id='errPass1'><?= $errorsArray['password'] ?? '' ?></div>
                </div>
                <div class="mb-3">
                    <label for="password2" class="form-label">Entrez à nouveau *</label>
                    <input type="password" name="password2" class="form-control" id="password2" required>
                    <div class='text-danger' id='errPass2'><?= $errorsArray['password'] ?? '' ?></div>
                </div>
                <input type="submit" class="btn btn-success btn-default" id="validForm"></input>
                <input id="disabledUser" name="disabledUser" type="hidden" value="false">
            </form>
            <form class="d-grid gap-2" action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post" id="disabledForm">
                <input id="disabledUser" name="disabledUser" type="hidden" value="true">
                <button type="submit" value="Submit" class="btn btn-danger btn-default" id="disabledBtn">Désactivé le compte </button>
            </form>
        </div>
    </div>
</div>
<!--verifie que les 2 mots de passes sont identiques-->
<script src="/public/assets/js/checkPass.js"></script>