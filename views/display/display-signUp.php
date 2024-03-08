<h3 class="text-center">Bonjour Mr <?= $lastname ?> <?= $firstname ?></h3>
<ul>
    <?php if ($lastname) { ?>
        <li><strong>Nom : </strong><?= $lastname ?></li>
    <?php } ?>
    <?php
    if($firstname) {?>
            <li><strong>prenom : </strong><?=$firstname?></li>
        <?php }?>
        <?php
    if($pseudonym) {?>
            <li><strong>Pseudo : </strong><?=$pseudonym?></li>
        <?php }?>
    <?php
    if ($email) { ?>
        <li><strong>Email : </strong><?= $email ?></li>
    <?php } ?>

    <?php if ($_POST['password1']) { ?>
        <li><strong>Password : </strong><?= $_POST['password1'] ?></li>
    <?php } ?>
</ul>