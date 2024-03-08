<?php
session_start();
$user = $_SESSION['user'];
// appel registrationForm
require(dirname(__FILE__) . '/../utils/regex.php');
// On charge le modèle qui nous servira à interroger la base de données des ville
require_once(dirname(__FILE__).'/../model/City.php');

/**********************ajax*************************************************** */
// Récupération et nettoyage du paramètre 'ajaxCP' permettant d'identifiant la requête Ajax
//si $ajax = true le formulaire du zipcode a reçu 5 chiffres
$ajax = filter_input(INPUT_POST, 'ajax', FILTER_VALIDATE_BOOLEAN);
// Traitement ajax uniquement!!!
if( $_SERVER['REQUEST_METHOD'] == 'POST' && $ajax){
    // Récupération et nettoyage du champs de formulaire 'ville_code_postal'
    $zipcodeAjax = trim(filter_input(INPUT_POST,'zipcodeAjax', FILTER_SANITIZE_STRING));
    // Appel à la méthode qui retourne un tableau d'objets {ville_id, ville_nom_reel}
    $cities = City::getByZip($zipcodeAjax);
    // On json le résultat pour pourvoir le traiter comme un objet en javascript
    echo(json_encode($cities));
    // On arrête tout traitement ici die, ou exit ;)
    exit;
}
/**********************fin ajax*************************************************** */

// on verifie si la methode $_POST existe
if ($_SERVER["REQUEST_METHOD"] == "POST") {

// keyword : nettoyage et validation
$keyword = trim(filter_input(INPUT_POST, 'keyword', FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES));
// ce champ peut etre vide
if (!empty($keyword)) {
    $testRegex = preg_match('/' . REGEX_NO_NUMBER . '/', $keyword);
    // verifie le format
    if (!$testRegex) {
        $error["keyword"] = "Le(s) mot(s) clé(s) format erroné!!";
    } else {
        // verifie si la chaine de caractaire est conforme en longeur
        if (strlen($keyword) <= 1 || strlen($keyword) >= 70) {
            $error["keyword"] = "La longueur de chaine n'est pas bonne";
        }
    }
}
    /*********************************************city*******************************************************************/

    // city : nettoyage et validation
    $id_city = intval(trim(filter_input(INPUT_POST, 'city', FILTER_SANITIZE_NUMBER_INT)));
    // on vérifie si id_city n'est pas vide
    if (!empty($id_city)) {
        $testCity = filter_var($id_city, FILTER_VALIDATE_INT);
        if (!$testCity) {
            $error["id_city"] = "Le nombre n'est pas valide";
        }
    }

 // priceMin : nettoyage et validation
 $priceMin = trim(filter_input(INPUT_POST, 'priceMin', FILTER_SANITIZE_NUMBER_INT));
 //  vérifie si priceMin n'est pas vide
 if (!empty($priceMin)) {
     $testpriceMin = filter_var($priceMin, FILTER_VALIDATE_INT);
     if (!$testpriceMin) {
         $error["priceMin"] = "Le nombre n'est pas valide";
     }
 }
  // priceMax : nettoyage et validation
  $priceMax = trim(filter_input(INPUT_POST, 'priceMax', FILTER_SANITIZE_NUMBER_INT));
  // vérifie si priceMax n'est pas vide
  if (!empty($priceMax)) {
      $testpriceMax = filter_var($priceMax, FILTER_VALIDATE_INT);
      if (!$testpriceMax) {
          $error["priceMax"] = "Le nombre n'est pas valide";
      }
  }
}
// appel header
include_once(dirname(__FILE__) . '/../views/templates/header.php');
// // appel vue registrationForm
if ($_SERVER["REQUEST_METHOD"] != "POST" || !empty($error)) {
}
    include_once(dirname(__FILE__) . '/../views/research.php');
// appel footer
include_once(dirname(__FILE__) . '/../views/templates/footer.php');
