<?php
    session_start();
    include('../conexao.php');

    $idUsuario = $_POST["sltResponsavel"];
    $idProjeto = $_SESSION['s_idProjeto'];



    $queryVerificaResponsavel = "SELECT * FROM usuarios U INNER JOIN usuarios_projetos UP ON U.idUsuario = UP.codUsuario WHERE U.idUsuario = ". $idUsuario. " AND UP.codProjeto = ". $idProjeto;

    $returnVerifica = $conn->query($queryVerificaResponsavel);

    if($returnVerifica->num_rows > 0){
        #true
        $queryAtualizaResponsavel =  "UPDATE usuarios_projetos SET usuproj_isActive = 1,  isResponsable = 1 WHERE codUsuario = ". $idUsuario ." AND codProjeto = ". $idProjeto;
        $retorno1 = $conn->query($queryAtualizaResponsavel);

        if($retorno1)
            print "<script> alert('Responsável atualizado com sucesso!') </script>";
            else
            print "<script> alert('Falha ao atualizar responsável') </script>";
        }else{
            #false
            $queryNewResponsavel =  "CALL sp_VinculaUsuarioProjeto(".$idUsuario.",". $idProjeto.", 1)";
            $retorno2 = $conn->query($queryNewResponsavel);
        if($retorno2)
            print "<script> alert('Responsável cadastrado com sucesso!') </script>";
        else
            print "<script> alert('Falha ao cadastrar responsável!') </script>";
    }
		

    print "<script> window.location.href='../application/management.php' </script>";
    $conn->close();
?>
