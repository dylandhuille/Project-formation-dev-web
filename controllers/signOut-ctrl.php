<?php
//pointer vers cette page pour ce deconnecter
session_start();

unset($_SESSION['user']);

header('location: /../controllers/index-ctrl.php');
exit;
