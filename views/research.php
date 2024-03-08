<!--corp du site-->
<h1 class="text-success text-center">Colocation</h1>
<?=$customMessage ?? ''?>
    <div class="container-fluid">
        <div class="row ">
            <div class="col-sm-12 col-lg-4">
                <div class="col-sm-12 col-lm-4">
                <form class="d-grid gap-2" action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post" id="signUpForm">
                        <div class="form-group">
                            <label for="keyword">Mot(s) clé(s)</label>
                                <!-- keyword -->
                            <input 
                                type="text"
                                name="keyword"
                                id="keyword" 
                                class="form-control"
                                autocomplete=""
                                value="<?=htmlentities($keyword ?? '') ?>"
                                class="form-control <?=isset($error['keyword']) ? 'errorField' : ''?>"
                                value=""
                                minlength=""
                                maxlength=""
                                placeholder="Mot(s) clé(s)"
                                type="text" 
                                class="form-control" 
                                id="keyword" 
                                placeholder="Mot(s) clé(s)"
                            ><div class="error"><?= $error['keyword'] ?? '' ?></div>
                        </div>

                <!--**********************ajax***************************************************-->
                <div class="form-group">
                        <label for="city">Ville</label>
                        <!-- city -->
                        <span class="input-group-text">Code postal</span>
                        <input class="form-control form-control-lg" type="text" placeholder="Entrez un code postal" name="zipcode" id="zipcode">
                        <select class="form-select form-select-lg" name="city" id="city">
                            <option selected>Ville...</option>
                            <option value=""></option>
                        </select>
                    </div>
                <!--**********************fin ajax***************************************************-->
                    <div class="form-group">
                            <label for="price">Prix</label>
                            <!-- price prix min / max -->
                            <input 
                                type="number"
                                name="priceMin"
                                class="form-control" 
                                id="priceMin"
                                value="<?=htmlentities($priceMin ?? '') ?>"
                                class="form-control <?=isset($error['priceMin']) ? 'errorField' : ''?>" 
                                placeholder="Prix Min"
                                min="0"
                                max="1000"
                            ><div class="error"><?= $error['priceMin'] ?? '' ?></div>
                            <input 
                                type="number"
                                name="priceMax"
                                class="form-control" 
                                id="priceMax" 
                                value="<?=htmlentities($priceMax ?? '') ?>"
                                class="form-control <?=isset($error['priceMax']) ? 'errorField' : ''?>"
                                placeholder="Prix Max"
                                min="0"
                                max="1000"
                            ><div class="error"><?= $error['priceMax'] ?? '' ?></div>
                        </div>
                        <!-- filtrer -->
                        <div class="form-group">
                            <label for="filtrer">Trier du:</label>
                            <!--price order -->
                            <select name="filtrer" id="filtrer">
                                <option value="0">Du moins au plus chers</option>
                                <option value="1">Du plus au moins chers</option>
                            </select>
                        </div>
                        <div class="d-grid gap-2 col-6 mx-auto">
                            <button type="submit" class="btn btn-success btn-default" type="button">Rechercher</button>
                        </div>
                    </form>
                    <!-- faux code -->
                    <div id=resultat0>
                        <h2>Résultats de la recherche: </h2>
                        <p>prix: ????€</p>
                        <img class="img-fluid rounded" src="https://picsum.photos/200/200" alt="" srcset="">
                        <p>ville: Paris</p>
                        <p>une partie de la Déscription</p>
                        <p>Aujourd'hui, 13:53</p>
                        <!--ici les resultat de la recherche-->
                    </div>
                    <div id=resultat1>
                        <p>prix: ????€</p>
                        <img class="img-fluid rounded" src="https://picsum.photos/200/200" alt="" srcset="">
                        <p>ville: Paris</p>
                        <p>Aujourd'hui, 13:53</p>
                        <p> une partie de la Déscription</p>
                        <!--ici les resultat de la recherche-->
                    </div>
                    <!-- fin faux code -->
                </div>
            </div>
        </div>
    </div>
    <script src="/public/assets/js/city.js"></script>
