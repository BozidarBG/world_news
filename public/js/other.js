var loginForm=document.getElementById('login-form');
var registerForm=document.getElementById('register-form');

var loginBtns=document.getElementsByClassName('login-event');
var registerBtns=document.getElementsByClassName('register-event');



for(var i=0; i<loginBtns.length; i++){
    loginBtns[i].addEventListener('click', function(){
        //if register div is not hidden, hide it
        if(!registerForm.classList.contains('hidden-form')){
            registerForm.classList.add('hidden-form');
        }
        //toggle class hidden-form from login div
        if(loginForm.classList.contains('hidden-form')){
            loginForm.classList.remove('hidden-form');
        }else{
            loginForm.classList.add('hidden-form');
        }
    });
}

for(i=0; i<registerBtns.length; i++) {
    registerBtns[i].addEventListener('click', function () {
        //if login div is not hidden, hide it
        if (!loginForm.classList.contains('hidden-form')) {
            loginForm.classList.add('hidden-form');
        }
        //toggle class hidden-form from register div
        if (registerForm.classList.contains('hidden-form')) {
            registerForm.classList.remove('hidden-form');
        } else {
            registerForm.classList.add('hidden-form');
        }

    });
}


