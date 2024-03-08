<?php
//Très simplement, les traits correspondent à un mécanisme nous permettant de réutiliser des méthodes dans des classes indépendantes, repoussant ainsi les limites de l’héritage traditionnel.
trait sendMail
{
    //fonction qui prend en paramétre d'entree un id un email et un token (stoker dans la base de donnée)
    function sendMailConfirm($id, $email, $token)
    {
        //recupére le chemain de l'url pour la validation du compte
        $host = 'http://' . $_SERVER['HTTP_HOST'];
        //sujet du mail
        $subject = 'Activation de votre compte';
        $message = '
        <html>
        <p>
        Félicitation, vous êtes a un clic de la validation de votre compte en cliquant sur ce lien:
        <a href="' . $host . '/controllers/confirmSignUp-ctrl.php?id=' . $id . '&token=' . $token . '">
        ' . $host . '/controllers/confirmSignUp-ctrl.php?id=' . $id . '&token=' . $token . '
        </a></p>
        </html>
        ';
        // Pour envoyer un mail HTML, l'en-tête Content-type doit être défini
        $headers[] = 'MIME-Version: 1.0';
        $headers[] = 'Content-type: text/html; charset=UTF-8';
        //envoi un email en format html en utf-8 pour les caractères accentué
        mail($email, $subject, $message, implode("\r\n", $headers));
    }
}
