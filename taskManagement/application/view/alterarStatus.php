<?php
    session_start();
    include('../../conexao.php');


    $queryAlteraStatus = "CALL sp_AlterarSituacaoTarefa (". $_REQUEST['idTarefa'] .", ". $_REQUEST['status'] ." ) ";
    $retornoAlteraStatus = $conn->query($queryAlteraStatus);

    if($retornoAlteraStatus){
        print "<script> alert('Tarefa alterada com sucesso!') </script>";
        print "<script> window.location.href='./viewTask.php?idTarefa=".$_REQUEST['idTarefa']."&isYours=1' </script>";
    }else{
        print "<script> alert('Falha ao alterar Tarefa!') </script>";
        print "<script> window.location.href='./viewTask.php?idTarefa=".$_REQUEST['idTarefa']."&isYours=1' </script>";
    }


    $conn->close();
?>