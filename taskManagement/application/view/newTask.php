<?php
    session_start();
    include('../../conexao.php');

    $idUsuario = $_POST["sltRespTarefa"];
    $idProjeto = $_SESSION["s_idProjeto"];
    $descricao = $_POST["NTDescricao"];
    $dataTermino = $_POST["NTDataTermino"];

    $queryNewTask = "CALL sp_NovaTarefa ($idProjeto,$idUsuario,'$descricao', CURDATE(), '$dataTermino', 1 )";
    $retornoNewTask = $conn->query($queryNewTask);

    if($retornoNewTask){
        print "<script> window.location.href='../home.php' </script>";
        print "<script>  alert('Tarefa adicionada com sucesso!') </script>";
    }else{
        print "<script> window.location.href='../home.php' </script>";
        print "<script>  alert('Erro ao adicionar tarefa!') </script>";
    }

    $conn->close();

?>