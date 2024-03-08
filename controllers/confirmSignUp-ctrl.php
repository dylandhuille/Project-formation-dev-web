<?php
session_start();
require_once(dirname(__FILE__) . '/../model/User.php');

$isRegistered = false;

// Nettoyer l'id passé en $_GET dans l'url
$id = intval(trim(filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT)));

// Nettoyage du token passé en $_GET dans l'url
$tokenGet = trim(filter_input(INPUT_GET, 'token', FILTER_SANITIZE_STRING));

// Récupération du compte user en base de données
$user = User::get($id);
//Comparer le token en GET avec le token en base
if ($user && $tokenGet == $user->confirmation_token) {
    $result = User::validateSignUp($id);
    if ($result) {
        $_SESSION['user'] = $user;
        $isRegistered = true;
    }
}
include_once(dirname(__FILE__) . '/../views/templates/header.php');
include_once(dirname(__FILE__) . '/../views/signUpConfirm.php');
include_once(dirname(__FILE__) . '/../views/templates/footer.php');
