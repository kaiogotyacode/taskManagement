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

function hideFromUser(){
    window.addEventListener("load", ()=> {
        var myProjects = document.getElementsByClassName("adm-projects")[0];
        myProjects.style.cssText += 'display: none;';
    });
}

function logout(){

    if(confirm("Você deseja fazer logout?"))
        window.location.href = "../index.php";
    else
        return false;   
    

}

window.addEventListener("load", ()=>{
    
    var btnNewProject = document.getElementById("AddNewProject");
    btnNewProject.addEventListener("click", ()=>{
        var modal = document.getElementById("modalNewProject");
        var fade = document.getElementById("fade");

        
        modal.style.cssText += 'opacity: 1; pointer-events: all;';
        fade.style.cssText += 'opacity: 1; pointer-events: all;';
        
    });
});


function exitModalNewProject(){
    var modal = document.getElementById("modalNewProject");
    var fade = document.getElementById("fade");

    
    modal.style.cssText += 'opacity: 0; pointer-events: none;';
    fade.style.cssText += 'opacity: 0; pointer-events: none;';
}


function validarNewProject(){
    var NPNome = document.getElementById("NPNome");
    var NPDescricao= document.getElementById("NPDescricao");
    var NPDataInicio= document.getElementById("NPDataInicio");
    var NPDataTermino= document.getElementById("NPDataTermino");

    if(NPNome.value.length == 0){        
        alert('Verifique o nome do projeto e tente novamente! ');
        NPNome.focus();

        return false;
    }else
    if(NPDescricao.value.length == 0){        
        alert('Verifique a descrição do projeto e tente novamente! ');
        NPDescricao.focus();
        
        return false;
    }else
    if(NPDataInicio.value.length != 10){        
        alert('Verifique a data de início do projeto tente novamente! ');
        NPDataInicio.focus();
        
        return false;
    }else
    if(NPDataTermino.value.length != 10){        
        alert('Verifique a data de término do projeto tente novamente! ');
        NPDataTermino.focus();
        
        return false;
    }

    return true;
}