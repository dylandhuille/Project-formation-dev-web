<?php
// fonction qui gère l'enregistrement d'image sur le serveur
function uploadPicture($formFrontName)
{
    // chemain pour stoker les images
    $upload_dir = dirname(__FILE__) . '/../public/assets/img/picturesProperty';
        // on charge le fichier de config pour les images
    include_once(dirname(__FILE__) . '/../config/config.php');

    //On va donc changer le nom du fichier pour qu’il soit unique avant de l’uploader.
    $uniqueName = uniqid('', true);

    if ($_FILES[$formFrontName] && $_FILES[$formFrontName]['error'] == 0) {

        try {

            if ($_FILES[$formFrontName]['size'] > LIMIT_WEIGHT) {
                throw new Exception('Poids dépassé');
            }

            if (!in_array($_FILES[$formFrontName]['type'], SUPPORTED_FORMAT)) {
                throw new Exception('Format non autorisé');
            }

            $originalImage = $upload_dir . '/'.$uniqueName.'_original.jpg';
            if (!move_uploaded_file($_FILES[$formFrontName]['tmp_name'], $originalImage)) {
                throw new Exception('Problème lors de l\'enregistrement');
            }

            $src_width = getimagesize($originalImage)[0];
            $src_height = getimagesize($originalImage)[1];
            $dst_width = 400;
            $dst_height = $dst_width * $src_height / $src_width;
            $ressourceDestination = imagecreatetruecolor($dst_width, $dst_height);
            $ressourceOriginal = imagecreatefromjpeg($originalImage);

            // Redimensionne
            imagecopyresampled($ressourceDestination, $ressourceOriginal, 0, 0, 0, 0, $dst_width, $dst_height, $src_width, $src_height);

            // Sauvegarde l'image redimensionnée
            $resampledDestination = $upload_dir . '/'.$uniqueName.'_resampled.jpg';
            imagejpeg($ressourceDestination, $resampledDestination, 75);

            // Recadre
            $ressourceOriginal = imagecreatefromjpeg($resampledDestination);
            $ressourceCropped = imagecrop($ressourceOriginal, ['x' => 0, 'y' => 0, 'width' => 400, 'height' => 400]);

            // Sauvegarde l'image recadrée
            $croppedDestination = $upload_dir . '/'.$uniqueName.'_cropped.jpg';
            imagejpeg($ressourceCropped, $croppedDestination, 75);
        } catch (\Exception $ex) {
            var_dump($ex);
            return $ex;
        }
    }
    return $uniqueName;
}
