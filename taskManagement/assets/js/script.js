function validarCadastro (){
    var nome = document.getElementById("nome").value;
    var email = document.getElementById("email").value;
    var senha = document.getElementById("senha").value;
    var confirmaSenha = document.getElementById("confirmarSenha").value;

    if(nome  != "" && email != "" && senha != "" && confirmaSenha != "" && senha == confirmaSenha){
        return true;
    }else{        
        alert('Ops! Verifique os dados digitados e tente novamente!');
        return false;
    }
}

function validarLogin() {
    var email = document.getElementById("email").value;
    var senha = document.getElementById("senha").value;

    if(email == ""  || senha == ""){
        alert('Verifique os campos e tente novamente!');
        return false;
    }
    
    return true;
}

function hideContent(){
    window.addEventListener("load", ()=>{
        var myProjects = document.getElementsByClassName("my-projects")[0];
        myProjects.style.cssText += 'display: none;';
    });

}