<?php
//reflechir a un pattern pour le pseudo
//reflechir a un pattern pour le mot de passe
// pour les noms / prenoms
define('PATTERN_NAME',"^[A-Za-z-éèêëàâäôöûüç' ]+$");
// pour les adresses
define('PATTERN_ADDRESS',"^[0-9]{0,6}[A-Za-z0-9-éèêëàâäôöûüç' \.,&#;]+$");
// pour les numéros de téléphone
define('PATTERN_PHONE',"^(\+33|0|0033)[1-9]((-|\/|\.| )?\d{2}){4}$");
// pour des nombres
define('PATTERN_NUMBER',"^[0-9]+$");
// pour les emails
define('PATTERN_EMAIL',"[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+.[a-zA-Z.]{2,15}");