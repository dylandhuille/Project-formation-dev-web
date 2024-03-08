// Déclaration des variables
let zipcode = document.getElementById('zipcode');
let city = document.getElementById('city');

// Déclration d'un event keyUp sur le champs
zipcode.onkeyup = function(){
    
    // Récupération du contenu du champs
    let search = zipcode.value;
    //console.log(search);

    // On fait le traitement uniquement si il y a 5 caractères entrés
    if(search.length == 5){

        // Déclaration d'un objet formData
        let myForm = new FormData();
        myForm.append('zipcodeAjax', search);
        myForm.append('ajax', true);
        let options = {
            method: 'POST',
            body: myForm
        }   
        // Appel ajax au fichier passé en premier paramètre. Le second paramètre est l'objet déclaré précédemment.
        fetch('/controllers/adSubmissionForm-controller.php', options)
        // Quand le contrôleur à traité le résultat, on stocke la chaine retournée dans 'response' 
        .then(function(response){
            // La chaine est alors json encodé pour être interprété en javascript
            return response.json();
        })
        // Quand la chaine à fini d'étre encodée on place le json dans 'cities'
        .then(function(cities){
            let options = '';

            // On boucle sur le tableau cities et on génère toutes les futures options du select
            cities.forEach(function(city){
                options = options + '<option value="'+city.id+'">'+city.city+'</option>';
            })

            // On injecte dans le DOM les options au bon endroit.
            city.innerHTML = options;
        })

    }
    
}