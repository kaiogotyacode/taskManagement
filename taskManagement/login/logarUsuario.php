<?php
   

    include("../conexao.php");

    $email = $_POST["email"];
    $senha = $_POST["senha"];



    $query = "SELECT * FROM Usuarios where email = '$email' and senha = '$senha' ";
    $resp = $conn->query($query);

    if($resp->num_rows > 0){
        
        $row = $resp->fetch_assoc();

        session_start();

        $_SESSION["s_idUsuario"] = $row['idUsuario'];
        $_SESSION["s_nome"] = $row['nome'];
        $_SESSION["s_email"] = $row['email'];
        $_SESSION["s_senha"] = $row['senha'];    
        
        $queryCheckAdmin = "SELECT * FROM usuarios U INNER JOIN administradores A ON U.idUsuario = A.idUsuario AND U.idUsuario = " . $_SESSION["s_idUsuario"];

        $respCheckAdmin =  $conn->query($queryCheckAdmin);

        if($respCheckAdmin->num_rows > 0){
            $_SESSION["s_admin"] = 1;
        }else{
            $_SESSION["s_admin"] = 0;
        }

        print "<script> window.location.href='../application/home.php' </script>";
    }else{
        print "<script> alert('Indivíduo não encontrado!') </script>";        
        print "<script> window.location.href='../index.php' </script>";
    }
    
    $conn->close();
    
    

?>