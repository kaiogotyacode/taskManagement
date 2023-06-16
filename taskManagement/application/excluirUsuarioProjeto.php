<?php
    include('../conexao.php');

    $queryRemoveUsuarioProjeto = "CALL sp_RemoveUsuarioProjeto (".$_REQUEST['idUsuario']." , ".$_REQUEST['idProjeto']." )";
    $retorno = $conn->query($queryRemoveUsuarioProjeto);
    if($retorno){
        print "<script> window.location.href='../application/management.php' </script>";
        print "<script> alert('Usuário removido com sucesso!') </script>";
    }else{
        print "<script> window.location.href='../application/management.php' </script>";
        print "<script> alert('Falha ao remover usuário!') </script>";        
    }


    $conn->close();

?>