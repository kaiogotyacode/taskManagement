<?php 
    include('../conexao.php');


    $queryExcluir = "UPDATE Projetos SET projeto_isActive = 0 WHERE idProjeto  = ". $_REQUEST["idProjeto"];
    $resultado = $conn->query($queryExcluir);

    if($resultado)
        print "<script> alert('Projeto excluido com sucesso! '); window.location.href='../application/home.php'; </script>";
    else    
        print "<script> alert('Ocorreu um problema ao excluir o projeto! '); window.location.href='../application/home.php'; </script>";

    $conn->close();

?>