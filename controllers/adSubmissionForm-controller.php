<?php
session_start();
$user = $_SESSION['user'];
// // appel des fichiers 
require_once(dirname(__FILE__) . '/../utils/regex.php');
require_once(dirname(__FILE__) . '/../model/Property.php');
// On charge le modèle qui nous servira à interroger la base de données des ville
require_once(dirname(__FILE__).'/../model/City.php');
// appel de la fonction pour upload des photo sur le server
require_once(dirname(__FILE__).'/../utils/uploadPicture.php');

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



// on vérifie si la méthode $_POST existe
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    /*********************************************type_of_property*******************************************************************/
    // type_of_property : nettoyage et validation
        $type_of_property = intval(trim(filter_input(INPUT_POST, 'type_of_property', FILTER_SANITIZE_NUMBER_INT)));
        //  on vérifie si type_of_property n'est pas vide
        if (!empty($type_of_property)) {
            $testType_of_property = filter_var($type_of_property, FILTER_VALIDATE_INT);
            if (!$testType_of_property) {
                $error["type_of_property"] = "Le nombre n'est pas valide";
            }
        }
    /*********************************************price*******************************************************************/

    // price : nettoyage et validation
    $price = intval(trim(filter_input(INPUT_POST, 'price', FILTER_SANITIZE_NUMBER_INT)));
    // on vérifie si price n'est pas vide
    if (!empty($price)) {
        $testprice = filter_var($price, FILTER_VALIDATE_INT);
        if (!$testprice) {
            $error["price"] = "Le nombre n'est pas valide";
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
    /*********************************************living_area*******************************************************************/

    // living_area : nettoyage et validation
    $living_area = intval(trim(filter_input(INPUT_POST, 'living_area', FILTER_SANITIZE_NUMBER_INT)));
    //  on vérifie si living_area n'est pas vide
    if (!empty($living_area)) {
        $testlivingSpace = filter_var($living_area, FILTER_VALIDATE_INT);
        if (!$testlivingSpace) {
            $error["living_area"] = "Le nombre n'est pas valide";
        }
    }
    /*********************************************land_area*******************************************************************/

    // land_area : nettoyage et validation
    $land_area = intval(trim(filter_input(INPUT_POST, 'land_area', FILTER_SANITIZE_NUMBER_INT)));
    //  on vérifie si land_area n'est pas vide
    if (!empty($land_area)) {
        $testlandSurface = filter_var($land_area, FILTER_VALIDATE_INT);
        if (!$testlandSurface) {
            $error["land_area"] = "Le nombre n'est pas valide";
        }
    }
    /*********************************************number_of_rooms*******************************************************************/

    // number_of_rooms : nettoyage et validation
    $number_of_rooms = intval(trim(filter_input(INPUT_POST, 'number_of_rooms', FILTER_SANITIZE_NUMBER_INT)));
    //   on vérifie si number_of_rooms n'est pas vide
    if (!empty($number_of_rooms)) {
        $testnumber_of_rooms = filter_var($number_of_rooms, FILTER_VALIDATE_INT);
        if (!$testnumber_of_rooms) {
            $error["number_of_rooms"] = "Le nombre n'est pas valide";
        }
    }
    /*********************************************various_info*******************************************************************/

    // various_info : nettoyage et validation
    $various_info = trim(filter_input(INPUT_POST, 'various_info', FILTER_SANITIZE_STRING));
    /*********************************************description_equipment*******************************************************************/

    // description_equipment : nettoyage et validation
    $description_equipment = trim(filter_input(INPUT_POST, 'description_equipment', FILTER_SANITIZE_STRING));

    /*********************************************number_of_remaining_places*******************************************************************/

    // number_of_remaining_places : nettoyage et validation
    $number_of_remaining_places = intval(trim(filter_input(INPUT_POST, 'number_of_remaining_places', FILTER_SANITIZE_NUMBER_INT)));
    //  on vérifie si number_of_remaining_places n'est pas vide
    if (!empty($number_of_remaining_places)) {
        $testnumber_of_remaining_places = filter_var($number_of_remaining_places, FILTER_VALIDATE_INT);
        if (!$testnumber_of_remaining_places) {
            $error["number_of_remaining_places"] = "Le nombre n'est pas valide";
        }
    }
    /*********************************************picture*******************************************************************/
    // picture0
    $uniqueName[0] = uploadPicture('picture0');
    // picture1
    $uniqueName[1] = uploadPicture('picture1');
    // picture2
    $uniqueName[2] =uploadPicture('picture2');
    var_dump($uniqueName);
    //converti un tableau en une chaine son contraire explode
    $picture = implode(";",$uniqueName);
    var_dump($picture);
    /*****************************************si pas d'error***********************************************************************/
    //var_dump($error);
    if (empty($error)) {
        //on passe les infos du bien pour hydrater l'objet Property
        $valiDate = date('Y-m-d H:i:s');
        $property = new Property(
            $id = NULL,
            $type_of_property,
            $price,
            $living_area,
            $land_area,
            $number_of_rooms,
            $various_info,
            $description_equipment,
            $number_of_remaining_places,
            $registered_at = $valiDate,
            $deleted_at = NULL,
            $moderated_at = NULL,
            $id_user = $user->id,
            //debug
            $id_city,
            $picture
        );
        // appel de la méthode create de l'objet property qui remplie la base de données
        $response = $property->create();
        if ($response !== true) {
            $customMessage = $response;
        } else {
        
            $customMessage = 'L\'annonce à bien éte enregistré !!!';
            //redirection vers la page de profile
            header('Location: /../controllers/profil-ctrl.php');
            Exit();
        }
    }
}
// appel du fichier header
include_once(dirname(__FILE__) . '/../views/templates/header.php');
// appel du fichier vue registrationForm
if ($_SERVER["REQUEST_METHOD"] != "POST" || !empty($error)) {
}
    include_once(dirname(__FILE__) . '/../views/adSubmissionForm.php');
// appel du fichier footer
include_once(dirname(__FILE__) . '/../views/templates/footer.php');
