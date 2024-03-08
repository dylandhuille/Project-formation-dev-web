<?=var_dump($_POST)?>
<ul>
    <?php if ($_POST['pseudo']) { ?>
        <li><strong>pseudo : </strong><?= $_POST['pseudo'] ?></li>
    <?php } ?>

    <?php if ($_POST['biographie']) { ?>
        <li><strong>biographie : </strong><?= $_POST['biographie'] ?></li>
    <?php } ?>

    <?php if ($_POST['infoDivers']) { ?>
        <li><strong>infoDivers : </strong><?= $_POST['infoDivers'] ?></li>
    <?php } ?>
    <!-- code a verif -->
    <?php if ($_POST['profilPhoto']) { ?>
        <li><strong>profilPhoto : </strong><?= $_POST['profilPhoto'] ?></li>
    <?php } ?>
</ul>