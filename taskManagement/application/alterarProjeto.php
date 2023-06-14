<?php
    include('../conexao.php');
    session_start();

    $nome = $_POST["mngNomeProjeto"];
    $descricao = $_POST["mngDescricao"];
    $dataInicio = $_POST["mngDataInicio"];
    $dataTermino = $_POST["mngDataTermino"];
 
    $queryUpdate = "CALL sp_AlterarProjeto ('$nome', '$descricao', '$dataInicio', '$dataTermino', ". $_SESSION["s_idProjeto"] ." )";

    $retorno = $conn->query($queryUpdate);

    if($retorno){
        print "<script> alert('Projeto alterado com sucesso!') </script> ";
    }else{
        print "<script> alert('Falha ao alterar projeto!') </script> ";
    }

    print "<script>  window.location.href='../application/management.php?idProjeto=". $_SESSION["s_idProjeto"] ."'  </script>";
    $conn->close();
    
?>