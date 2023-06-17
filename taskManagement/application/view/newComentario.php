<?php
    session_start();
    include('../../conexao.php');

    $idTarefa = $_SESSION['s_idTarefa'];
    $mensagem = $_POST['NCMensagem'];

    $queryNewComentario  = "call sp_AdicionarComentario($idTarefa, '$mensagem')";
    $retornoNewComentario = $conn->query($queryNewComentario);

    if($retornoNewComentario){
        print "<script> alert('Comentário realizado com sucesso!') </script>";
    }else{
        print "<script> alert('Falha ao inserir comentário!') </script>";       
    }
    print "<script> window.location.href='./viewTask.php?idTarefa=$idTarefa&isYours=1' </script>";

    $conn->close();
?>