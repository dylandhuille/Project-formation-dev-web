let checkPass = ( event ) => {

    if(password1.value!=password2.value){
        event.preventDefault();
        errPass1.innerHTML = 'Les 2 mots de passe sont différents';
        errPass2.innerHTML = 'Les 2 mots de passe sont différents';
    } 
}


signUpForm.addEventListener('submit', checkPass);