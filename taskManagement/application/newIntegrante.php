<?php
    session_start();
    include('../conexao.php');

    $idUsuario = $_POST["sltIntegrante"];
    $idProjeto = $_SESSION['s_idProjeto'];



    $queryVerificaIntegrante = "SELECT * FROM usuarios U INNER JOIN usuarios_projetos UP ON U.idUsuario = UP.codUsuario WHERE U.idUsuario = ". $idUsuario. " AND UP.codProjeto = ". $idProjeto;

    $returnVerifica = $conn->query($queryVerificaIntegrante);

    if($returnVerifica->num_rows > 0){
        #true
        $queryAtualizaIntegrante =  "UPDATE usuarios_projetos SET usuproj_isActive = 1, isResponsable = 0 WHERE codUsuario = ". $idUsuario ." AND codProjeto = ". $idProjeto;
        $retorno1 = $conn->query($queryAtualizaIntegrante);

        if($retorno1)
            print "<script> alert('Integrante atualizado com sucesso!') </script>";
            else
            print "<script> alert('Falha ao atualizar integrante') </script>";
        }else{
            #false
            $queryNewIntegrante =  "CALL sp_VinculaUsuarioProjeto(".$idUsuario.",". $idProjeto.", 0)";
            $retorno2 = $conn->query($queryNewIntegrante);
        if($retorno2)
            print "<script> alert('Integrante cadastrado com sucesso!') </script>";
        else
            print "<script> alert('Falha ao cadastrar Integrante!') </script>";
    }
		

    print "<script> window.location.href='../application/management.php' </script>";
    $conn->close();
?>
