<?php
session_start();
require_once dirname(__FILE__) . '/../model/User.php';
//on vérifie si la méthode $_POST existe
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // email : nettoyage et validation
    $email = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));
    //  on vérifie si email n'est pas vide
    if (!empty($email)) {
        $testEmail = filter_var($email, FILTER_VALIDATE_EMAIL);
        // vérifie le format
        if (!$testEmail) {
            $error["email"] = "L'adresse email n'est pas au bon format!!";
        }
    } else {
        $error["email"] = "L'adresse mail est obligatoire!!";
    }
    // password : nettoyage et validation
    $passwordPost = isset($_POST['password']) ? $_POST['password'] : '';
    $user = User::getByEmail($email);

    //on compare le mot de passe en basse et le mot de passe envoyer en post
    if ($user) {
        // password_verify permet de vérifier si le mot de passe en base de données (haché) correspond a celui passer en post
        $isPasswordOk =  password_verify($passwordPost, $user->password);
        if ($isPasswordOk) {
            //on connecte le user
            $_SESSION['user'] = $user;
            header('location: /controllers/research-ctrl.php');
            //si le mot de passe est invalide  message non précit pour éviter de donner des indications aux éventuels pirates
        } else {
            $erreur = 'Adresse e-mail ou mot de passe invalide';
        }
        //si l'email est invalide message non précit pour éviter de donner des indications aux éventuels pirates
    } else {
        $erreur = 'Adresse e-mail ou mot de passe invalide ou compte désactivé ';
    }
}
// appel header
include_once(dirname(__FILE__) . '/../views/templates/header.php');
// appel vue registrationForm
include_once(dirname(__FILE__) . '/../views/signIn.php');
// appel footer
include_once(dirname(__FILE__) . '/../views/templates/footer.php');
