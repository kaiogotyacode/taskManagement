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