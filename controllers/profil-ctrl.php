<?php
session_start();
$user = $_SESSION['user'];
//  appel fichier
require_once(dirname(__FILE__) . '/../utils/regex.php');
// appel de la fonction pour upload des phto sur le server
require_once(dirname(__FILE__).'/../utils/uploadPicture.php');
require_once(dirname(__FILE__).'/../model/profil.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //photo de profil
    $uniqueName = uploadPicture('profile_picture');
    // pseudonyme : nettoyage et validation
    $pseudonyme = trim(filter_input(INPUT_POST, 'pseudonyme', FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES));
    //   on vérifie si pseudo n'est pas vide
    if (!empty($pseudonyme)) {
        $testRegex = preg_match('/' . REGEX_NO_NUMBER . '/', $pseudonyme);
        // vérifie le format
        if (!$testRegex) {
            $error["pseudonyme"] = "Le pseudo n'est pas au bon format!!";
        } else {
            // verifie si la chaine de caractaire est conforme en longeur
            if (strlen($pseudonyme) <= 1 || strlen($pseudonyme) >= 70) {
                $error["pseudonyme"] = "La longueur de chaine n'est pas bonne";
            }
        }
    } else { // rempli le tableau d'erreur
        $error["pseudonyme"] = "Vous devez entrer un pseudonyme!!";
    }

    // biography : nettoyage et validation
    $biography = trim(filter_input(INPUT_POST, 'biography', FILTER_SANITIZE_STRING));

    // various_info : nettoyage et validation
    $various_info = trim(filter_input(INPUT_POST, 'various_info', FILTER_SANITIZE_STRING));

    // lifestyle : nettoyage et validation
   $lifestyle = trim(filter_input(INPUT_POST, '$lifestyle', FILTER_SANITIZE_STRING));

   // personnality : nettoyage et validation
   $personnality = trim(filter_input(INPUT_POST, 'personnality', FILTER_SANITIZE_STRING));

   // center_of_interest : nettoyage et validation
   $center_of_interest = trim(filter_input(INPUT_POST, 'center_of_interest', FILTER_SANITIZE_STRING));
  
    /*****************************************si pas d'error***********************************************************************/
    if (empty($error)) {
        //on passe les infos du profil pour hydrater l'objet Profil
        //paramétres de la fonction
        $profil = new profil(
            $id = NULL,
            $pseudonyme,
            $biography,
            $various_info,
            $profile_picture = $uniqueName,
            $lifestyle,
            $personnality,
            $center_of_interest,
            $deleted_at = NULL,
            // clés étrangéres
            $id_property =  $user->id
        );
         // appel de la méthode create de l'objet profil qui remplie la base de données
         $response = $profil->create();
         if ($response !== true) {
             $customMessage = $response;
         } else {
             $customMessage = 'Le profil à bien éte enregistré !!!';
         }
     }
    }
// appel header
include(dirname(__FILE__) . '/../views/templates/header.php');
if ($_SERVER["REQUEST_METHOD"] != "POST" || !empty($error)) {
    
}include(dirname(__FILE__) . '/../views/profil.php');
// appel footer
include(dirname(__FILE__) . '/../views/templates/footer.php');
