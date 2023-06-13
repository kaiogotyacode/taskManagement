<?php
include("../conexao.php");

$nome =  $_POST["NPNome"];
$descricao =  $_POST["NPDescricao"];
$dataInicio =  $_POST["NPDataInicio"];
$dataTermino =  $_POST["NPDataTermino"];

$query = "CALL sp_CadProjeto ('$nome', '$descricao', '$dataInicio', '$dataTermino',  1) ";
$retorno = $conn->query($query);

if ($retorno) {
    print "<script> 
                alert('Projeto cadastrado com sucesso!');
                window.location.href='home.php';
               </script>";
} else {
    print "<script> 
        alert('Erro ao cadastrar novo projeto!');
        window.location.href='home.php';
       </script>";
}

$conn->close();
