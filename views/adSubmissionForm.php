<!--corp du site-->
<h1 class="text-success text-center">Colocation</h1>
<?=$customMessage ?? ''?>
<div class="container-fluid">
    <div class="row ">
        <div class="col-sm-12 col-lg-4">
            <!-- enctype="multipart/form-data" for the pictures-->
            <form class="d-grid gap-2 " enctype="multipart/form-data" action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post" id="myForm">
              
            <div class="form-group">
                    <label for="type_of_property">Type de bien</label>
                    <!-- type_of_property -->
                    <select 
                        name="type_of_property" 
                        id="type_of_property" 
                        class="form-control" 
                        autocomplete="" 
                        placeholder="Type de bien" 
                        required
                    >
                        <option value="">Type de bien</option>
                        <option value="0">Maison</option>
                        <option value="1">Appartement</option>
                </div>
                <!--**********************ajax***************************************************-->
                    <div class="form-group">
                        <label for="city">Ville</label>
                        <!-- city -->
                        <span class="input-group-text">Code postal</span>
                        <input 
                        class="form-control form-control-lg"
                        type="text"
                        placeholder="Entrez un code postal"
                        name="zipcode" 
                        id="zipcode"
                        value="<?= htmlentities($price ?? '') ?>">
                        <select class="form-select form-select-lg" name="city" id="city">
                            <option selected>Ville...</option>
                            <option value=""></option>
                        </select>
                    </div>
                <!--**********************fin ajax***************************************************-->

                <div class="form-group">
                    <label for="price">Prix</label>
                    <!-- price -->
                    <input 
                        type="number" 
                        name="price" 
                        id="price" 
                        class="form-control <?= isset($error['price']) ? 'errorField' : '' ?>" 
                        autocomplete="" 
                        value="<?= htmlentities($price ?? '') ?>" 
                        minlength="" 
                        maxlength=""
                        placeholder="Prix" 
                        required
                    >
                </div>
                <div class="form-group">
                    <label for="living_area">Surface habitable en m²</label>
                    <!-- living_area -->
                    <input 
                        type="number" 
                        name="living_area" 
                        id="living_area" 
                        class="form-control <?= isset($error['living_area']) ? 'errorField' : '' ?>" 
                        autocomplete="" 
                        value="<?= htmlentities($living_area ?? '') ?>" 
                        minlength="" 
                        maxlength="" 
                        placeholder="Surface habitable" 
                        required
                    >
                </div>
                <div class="form-group">
                    <label for="land_area">Surface du terrain en m²</label>
                    <!-- land_area -->
                    <input 
                        type="number" 
                        name="land_area" 
                        id="land_area" 
                        class="form-control <?= isset($error['land_area']) ? 'errorField' : '' ?>" 
                        autocomplete="" 
                        value="<?= htmlentities($land_area ?? '') ?>" 
                        minlength="" 
                        maxlength="" 
                        placeholder="Surface du terrain" 
                        required
                    >
                </div>
                <div class="form-group">
                    <label for="number_of_rooms"> Nombres de pièces</label>
                    <!-- number_of_rooms -->
                    <input 
                        type="number" 
                        name="number_of_rooms" 
                        id="number_of_rooms" 
                        class="form-control <?= isset($error['number_of_rooms']) ? 'errorField' : '' ?>" 
                        autocomplete="" 
                        value="<?= htmlentities($number_of_rooms ?? '') ?>" 
                        minlength="" 
                        maxlength="" 
                        placeholder="Nombres de pièces"
                        required
                    >
                </div>
                
                <div class="form-group">
                    <label for="various_info">Infos divers</label>
                    <!-- various_info -->
                    <textarea 
                        name="various_info" 
                        id="various_info" 
                        class="form-control <?= isset($error['various_info']) ? 'errorField' : '' ?>" 
                        autocomplete="" 
                        minlength="" 
                        maxlength="" 
                        placeholder="Info divers" 
                        required
                    ><?= htmlentities($various_info ?? '') ?>
                    </textarea>
                </div>
                <div class="form-group">
                    <label for="description_equipment">Descriptions / équipements</label>
                    <!-- description_equipment -->
                    <textarea 
                        name="description_equipment" 
                        id="description_equipment" 
                        class="form-control <?= isset($error['description_equipment']) ? 'errorField' : '' ?>" 
                        autocomplete="" 
                        minlength="" 
                        maxlength="" 
                        placeholder="Déscriptions / équipements" 
                        required
                    ><?= htmlentities($description_equipment ?? '') ?>
                    </textarea>
                    

                </div>
                <div class="form-group">
                    <label for="number_of_remaining_places"> Nombre de place(s) disponible(s)</label>
                    <!-- number_of_remaining_places -->
                    <input 
                        type="number" 
                        name="number_of_remaining_places" 
                        id="number_of_remaining_places" 
                        class="form-control <?= isset($error['number_of_remaining_places']) ? 'errorField' : '' ?>" 
                        autocomplete="" 
                        value="<?= htmlentities($number_of_remaining_places ?? '') ?>" 
                        minlength="" 
                        maxlength="" 
                        placeholder="Nombre de place(s) disponible(s)" 
                        required
                    >
                </div>
                <div class="form-group">
                    <!-- picture0 -->
                    <label for="picture0">Photos</label>
                    <input 
                        type="file"
                        name="picture0"
                        id="picture0" 
                        class="form-control"
                        autocomplete=""
                        value=""
                        minlength=""
                        maxlength=""
                        placeholder="picture"
                        accept="picture/png, picture/jpeg"                 
                    >
                </div>
                <div class="form-group">
                    <!-- picture1 -->
                    <label for="picture1">Photos</label>
                    <input 
                        type="file"
                        name="picture1"
                        id="picture1" 
                        class="form-control"
                        autocomplete=""
                        value=""
                        minlength=""
                        maxlength=""
                        placeholder="picture"
                        accept="picture/png, picture/jpeg"
                    >
                </div>
                <div class="form-group">
                    <!-- picture2 -->
                    <label for="picture2">Photos</label>
                    <input 
                        type="file"
                        name="picture2"
                        id="picture2" 
                        class="form-control"
                        autocomplete=""
                        value=""
                        minlength=""
                        maxlength=""
                        placeholder="picture"
                        accept="picture/png, picture/jpeg"
                    >
                </div>
                <h2>Profils:</h2>
                <input type="submit" class="btn btn-success btn-default" id="valid-adSubmissionForm"></input>
            </form>
        </div>
    </div>
</div>
<script src="/public/assets/js/city.js"></script>
