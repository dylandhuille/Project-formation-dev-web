<?php

// appel header
include(dirname(__FILE__) . '/../views/templates/header.php');
// // appel vue registrationForm
// include(dirname(__FILE__).'/../views/registrationForm.php');
if ($_SERVER["REQUEST_METHOD"] != "POST" || !empty($error)) {
    include(dirname(__FILE__) . '/../views/moderation.php');
} else {
    include(dirname(__FILE__) . '/../views/display/display-moderation.php');
}
// appel footer
include(dirname(__FILE__) . '/../views/templates/footer.php');
?>