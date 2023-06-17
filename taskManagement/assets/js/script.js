function validarCadastro() {
    var nome = document.getElementById("nome").value;
    var email = document.getElementById("email").value;
    var senha = document.getElementById("senha").value;
    var confirmaSenha = document.getElementById("confirmarSenha").value;

    if (nome != "" && email != "" && senha != "" && confirmaSenha != "" && senha == confirmaSenha) {
        return true;
    } else {
        alert('Ops! Verifique os dados digitados e tente novamente!');
        return false;
    }
}

function validarLogin() {
    var email = document.getElementById("email").value;
    var senha = document.getElementById("senha").value;

    if (email == "" || senha == "") {
        alert('Verifique os campos e tente novamente!');
        return false;
    }

    return true;
}

function hideFromUser() {
    window.addEventListener("load", () => {
        var myProjects = document.getElementsByClassName("adm-projects")[0];
        myProjects.style.cssText += 'display: none;';
    });
}

function logout(verify = 0) {


    if (confirm("Você deseja fazer logout?")) {
        if(verify == 0){
            window.location.href = '../index.php';
        } else{
            window.location.href = '../../index.php';
        }
    } else {
        return false;
    }
}

function logoutGerenciamento() {

    if (confirm("Você deseja fazer logout?")) {
        window.location.href = '../index.php';

    } else {
        return false;

    }
}

window.addEventListener("load", () => {

    var btnNewProject = document.getElementById("AddNewProject");
    btnNewProject.addEventListener("click", () => {
        var modal = document.getElementById("modalNewProject");
        var fade = document.getElementById("fade");


        modal.style.cssText += 'opacity: 1; pointer-events: all;';
        fade.style.cssText += 'opacity: 1; pointer-events: all;';

    });

   
});

function openModalNewResponsavel() {
     
        var modal = document.getElementById("modalNewResponsavel");
        var fade = document.getElementById("fade");    
    
        modal.style.cssText += 'opacity: 1; pointer-events: all;';
        fade.style.cssText += 'opacity: 1; pointer-events: all;';    
  
}

function openModalNewIntegrante() {
     
    var modal = document.getElementById("modalNewIntegrante");
    var fade = document.getElementById("fade");    

    modal.style.cssText += 'opacity: 1; pointer-events: all;';
    fade.style.cssText += 'opacity: 1; pointer-events: all;';    

}

function openModalManageTask() {
     
    var modal = document.getElementById("modalNewTask");
    var fade = document.getElementById("fade");    

    modal.style.cssText += 'opacity: 1; pointer-events: all;';
    fade.style.cssText += 'opacity: 1; pointer-events: all;';    

}

function openModalNewComentario() {
     
    var modal = document.getElementById("modalNewComentario");
    var fade = document.getElementById("fade");    

    modal.style.cssText += 'opacity: 1; pointer-events: all;';
    fade.style.cssText += 'opacity: 1; pointer-events: all;';    

}


function exitModalNewProject() {
    var modal = document.getElementById("modalNewProject");
    var fade = document.getElementById("fade");


    modal.style.cssText += 'opacity: 0; pointer-events: none;';
    fade.style.cssText += 'opacity: 0; pointer-events: none;';
}

function exitModalNewResponsavel() {
    var modal = document.getElementById("modalNewResponsavel");
    var fade = document.getElementById("fade");


    modal.style.cssText += 'opacity: 0; pointer-events: none;';
    fade.style.cssText += 'opacity: 0; pointer-events: none;';
}

function exitModalNewIntegrante() {
    var modal = document.getElementById("modalNewIntegrante");
    var fade = document.getElementById("fade");


    modal.style.cssText += 'opacity: 0; pointer-events: none;';
    fade.style.cssText += 'opacity: 0; pointer-events: none;';
}

function exitModalNewTask() {
    var modal = document.getElementById("modalNewTask");
    var fade = document.getElementById("fade");


    modal.style.cssText += 'opacity: 0; pointer-events: none;';
    fade.style.cssText += 'opacity: 0; pointer-events: none;';
}

function exitModalNewComentario() {
    var modal = document.getElementById("modalNewComentario");
    var fade = document.getElementById("fade");


    modal.style.cssText += 'opacity: 0; pointer-events: none;';
    fade.style.cssText += 'opacity: 0; pointer-events: none;';
}



function validarNewProject() {
    var NPNome = document.getElementById("NPNome");
    var NPDescricao = document.getElementById("NPDescricao");
    var NPDataInicio = document.getElementById("NPDataInicio");
    var NPDataTermino = document.getElementById("NPDataTermino");

    if (NPNome.value.length == 0) {
        alert('Verifique o nome do projeto e tente novamente! ');
        NPNome.focus();

        return false;
    } else
        if (NPDescricao.value.length == 0) {
            alert('Verifique a descrição do projeto e tente novamente! ');
            NPDescricao.focus();

            return false;
        } else
            if (NPDataInicio.value.length != 10) {
                alert('Verifique a data de início do projeto tente novamente! ');
                NPDataInicio.focus();

                return false;
            } else
                if (NPDataTermino.value.length != 10) {
                    alert('Verifique a data de término do projeto tente novamente! ');
                    NPDataTermino.focus();

                    return false;
                }

    return true;
}


function validarNewTask(){
    var usuario = document.querySelector("#sltRespTarefa").value;
    var descricao = document.querySelector("#NTDescricao").value;
    var dataTermino = document.querySelector("#NTDataTermino").value;

    if(usuario.length == 0 || descricao.length == 0 || dataTermino.length != 10){
        alert('Verifique os campos e tente novamente!');
        return false;
    }

    return true;
}


function alterarProjeto() {

    var btnAlteraProjeto = document.querySelector("#btnAlteraProjeto");


    if (btnAlteraProjeto.innerHTML == 'Alterar') {
        alert("Campos liberados para alteração!");

        btnAlteraProjeto.innerHTML = 'Confirmar';

        document.querySelectorAll("#mngNomeProjeto , #mngDescricao ,  #mngDataInicio , #mngDataTermino").forEach(e => e.removeAttribute("disabled"));

        return false;
    } if (btnAlteraProjeto.innerHTML == 'Confirmar') {
        return true;
    }



}

function excluirProjeto(idProjeto) {
    if (confirm("Você realmente deseja excluir o projeto? ")) {
        window.location.href = "../../taskManagement/application/excluirProjeto.php?idProjeto=" + idProjeto;
    }
}


function excluirUsuarioProjeto(idUsuario, idProjeto){
    if (confirm("Você realmente deseja remover o usuário desse projeto?")) {
        window.location.href = "../../taskManagement/application/excluirUsuarioProjeto.php?idProjeto=" + idProjeto +"&idUsuario="+ idUsuario;
    }
}

function validarNewResponsavel(){
    var selectedUser = document.querySelector('#sltResponsavel');

    if(selectedUser.value != 0)
        return true;    

    alert('Selecione um responsável!');
    return false;
}

function validarNewIntegrante(){
    var selectedUser = document.querySelector('#sltIntegrante');

    if(selectedUser.value != 0)
        return true;    

    alert('Selecione um integrante!');
    return false;
}
