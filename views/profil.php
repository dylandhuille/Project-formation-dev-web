    <!--corp du site-->
    <h1 class="text-success text-center">Colocation</h1>
    <?=$customMessage ?? ''?>
    <div class="container-fluid">
        <div class="row ">
            <div class="col-sm-12 col-lg-4">
                <!-- enctype="multipart/form-data" for the images https://www.php.net/manual/fr/features.file-upload.post-method.php -->
                <form enctype="multipart/form-data" class=" d-grid gap-2 "action="<?=htmlspecialchars($_SERVER['PHP_SELF'])?>"method="post" id="form-profil"> 
                <!--**********************Photo de profil***************************************************-->
                <div class="form-group">
                    <label for="profile_picture">Photo de profil *</label>
                        <input 
                            type="file"
                            name="profile_picture"
                            id="profile_picture" 
                            class="form-control"
                            autocomplete=""
                            value=""
                            minlength=""
                            maxlength=""
                            placeholder="Photo de profil"
                            required
                            class="form-control" 
                            accept="picture/png, image/jpeg"
                        >
                </div>
                    <!--**********************pseudonyme***************************************************-->
                    <div class=" form-group">
                    <label for="pseudonyme">pseudonyme *</label>
                        <input 
                            type="text"
                            name="pseudonyme"
                            id="pseudonyme" 
                            class="form-control"
                            autocomplete=""
                            value=""
                            minlength=""
                            maxlength=""
                            placeholder="pseudonyme"
                            required
                        >
                    </div>
                    <!--**********************Biographie***************************************************-->
                    <div class="form-group">
                        <label for="biography">Biographie *</label>
                        <textarea 
                            type=""
                            name="biography"
                            id="biography" 
                            class="form-control"
                            autocomplete=""
                            value=""
                            minlength=""
                            maxlength=""
                            placeholder="Biographie"
                            required
                        >
                        </textarea>
                    </div>
                    <!--**********************Infos divers***************************************************-->
                    <div class="form-group">
                        <label for="various_info">Infos divers *</label>
                        <textarea 
                            type=""
                            name="various_info"
                            id="various_info" 
                            class="form-control"
                            autocomplete=""
                            value=""
                            minlength=""
                            maxlength=""
                            placeholder="Info divers"
                            required
                        >     
                        </textarea>
                    </div>
                    <!--**********************Mode de vie***************************************************-->
                    <div class="form-group">
                        <label for="lifestyle">Mode de vie *</label>
                        <textarea 
                            type=""
                            name="lifestyle"
                            id="lifestyle" 
                            class="form-control"
                            autocomplete=""
                            value=""
                            minlength=""
                            maxlength=""
                            placeholder="Mode de vie"
                            required
                        >     
                        </textarea>
                    </div>
                    <!--**********************Personnalité***************************************************-->
                    <div class="form-group">
                        <label for="personnality">Personnalité *</label>
                        <textarea 
                            type=""
                            name="personnality"
                            id="personnality" 
                            class="form-control"
                            autocomplete=""
                            value=""
                            minlength=""
                            maxlength=""
                            placeholder="Personnalité"
                            required
                        >     
                        </textarea>
                    </div>
                    <!--**********************Centre d'intérêts***************************************************-->
                    <div class="form-group">
                        <label for="center_of_interest">Centre d'intérêts *</label>
                        <textarea 
                            type=""
                            name="center_of_interest"
                            id="center_of_interest" 
                            class="form-control"
                            autocomplete=""
                            value=""
                            minlength=""
                            maxlength=""
                            placeholder="Centre d'intérêts"
                            required
                        >     
                        </textarea>
                    </div>
                    <input type="submit" class="btn btn-success btn-default" id="validForm-profil"></input> 
                </div>           
                </form>
            </div>
        </div>
    </div>
    <!--fin corp du site-->