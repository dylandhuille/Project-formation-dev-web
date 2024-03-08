<?= var_dump($_POST) ?>
<ul>
    <?php if ($_POST['type_of_property']) { ?>
        <li><strong>type_of_property : </strong><?= $_POST['type_of_property'] ?></li>
    <?php } ?>
    <?php if ($_POST['locations']) { ?>
        <li><strong>locations : </strong><?= $_POST['locations'] ?></li>
    <?php } ?>

    <?php if ($_POST['price']) { ?>
        <li><strong>price : </strong><?= $_POST['price'] ?></li>
    <?php } ?>

    <?php if ($_POST['living_area']) { ?>
        <li><strong>living_aera : </strong><?= $_POST['living_area'] ?></li>
    <?php } ?>

    <?php if ($_POST['land_area']) { ?>
        <li><strong>land_area : </strong><?= $_POST['land_area'] ?></li>
    <?php } ?>

    <?php if ($_POST['number_of_rooms']) { ?>
        <li><strong>number_of_rooms : </strong><?= $_POST['number_of_rooms'] ?></li>
    <?php } ?>

    <?php if ($_POST['various_info']) { ?>
        <li><strong>various_info : </strong><?= $_POST['various_info'] ?></li>
    <?php } ?>

    <?php if ($_POST['description_equipment']) { ?>
        <li><strong>description_equipment : </strong><?= $_POST['description_equipment'] ?></li>
    <?php } ?>

    <?php if ($_POST['number_of_remaining_places']) { ?>
        <li><strong>number_of_remaining_places : </strong><?= $_POST['number_of_remaining_places'] ?></li>
    <?php } ?>

    <?php if ($_POST['image0']) { ?>
        <li><strong>image0 : </strong><?= $_POST['image0'] ?></li>
    <?php } ?>

    <?php if ($_POST['image1']) { ?>
        <li><strong>image1 : </strong><?= $_POST['image1'] ?></li>
    <?php } ?>

    <?php if ($_POST['image2']) { ?>
        <li><strong>image2 : </strong><?= $_POST['image2'] ?></li>
    <?php } ?>
</ul>
