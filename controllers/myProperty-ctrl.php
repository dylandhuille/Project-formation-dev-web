<?php
session_start();
$user = $_SESSION['user'];
var_dump($user);
// appel fichiers 
require_once(dirname(__FILE__) . '/../utils/regex.php');
require_once(dirname(__FILE__) . '/../model/Property.php');
require_once(dirname(__FILE__) . '/../model/profil.php');
// On charge le modèle qui nous servira à interroger la base de données des ville
require_once(dirname(__FILE__).'/../model/City.php');
// appel de la fonction pour upload des photo sur le server
require_once(dirname(__FILE__).'/../utils/uploadPicture.php');

//recuperation des information du bien
var_dump($property_old = property::read($user->id));
var_dump($profil_old = profil::read($user->id));

if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['disabledProperty'] == 'true' ) {
    Property::Delete($user->id);
    header('location: /../controllers/signOut-ctrl.php');
}

//remplissage des champ avec les données en base
$type_of_property = $property_old->type_of_property;
$price = $property_old->price;
$living_area = $property_old->living_area;
$land_area = $property_old->land_area;
$number_of_rooms = $property_old->number_of_rooms;
$various_info = $property_old->various_info;
$description_equipment = $property_old->description_equipment;
$number_of_remaining_places = $property_old->number_of_remaining_places;
$registered_at = $property_old->registered_at;
$id_city =  $property_old->id_city;
$picture = $property_old->picture;
//chaine de caractaire vers tableau
$arrayPictureProperty = explode(';',$picture);
$linkPicture0 = '/public/assets/img/picturesProperty/'.$arrayPictureProperty[0].'_resampled.jpg';
$linkPicture1 = '/public/assets/img/picturesProperty/'.$arrayPictureProperty[1].'_resampled.jpg';
$linkPicture2 = '/../public/assets/img/picturesProperty/'.$arrayPictureProperty[2].'_resampled.jpg';


var_dump($linkPicture0);
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


/***************maj property et ou profil ************************************************************/
// on vérifie si la méthode $_POST existe
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    /**********pour property******************/
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
    //var_dump($error);
    //var_dump($property);
    /**********fin property******************/














 /*****************************************si pas d'erreur***********************************************************************/

 if (empty($error)) {
    //on passe les infos du user pour hydrater l'property
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
        $deleted_at  = NULL,
        $moderated_at = NULL,
        $id_user = $user->id,
        $id_city,
        $picture); 
        
//$id = $user->id, $pseudonym, $firstname, $lastname, $email, $password, $deleted_at  = NULL, $registered_at = NULL, $id_role = 1, $confirmation_token = NULL


    // appel de la méthode update de l'objet user qui remplie la base de données
    $response = $property->update($property);

    if ($response !== true) {
        $customMessage = $response;
    } else {
        $customMessage = 'Vous avez bien éte enregistré !!!';
        include_once(dirname(__FILE__) . '/../controllers/update-signUp-ctrl.php');
    }
}
}
// appel header
include_once(dirname(__FILE__) . '/../views/templates/header.php');
// appel vue update-signUp
include_once(dirname(__FILE__) . '/../views/myProperty.php');
// appel footer
include_once(dirname(__FILE__) . '/../views/templates/footer.php');
