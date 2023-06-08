<?php
    include("../conexao.php");

    $email = $_POST["email"];
    $senha = $_POST["senha"];

    $query = "SELECT * FROM Usuarios where email = '$email' and senha = '$senha' ";
    $resp = $conn->query($query);

    if($resp->num_rows > 0){
        print "<script> alert('Encontrou o indivíduo') </script>";        
    }else{
        print "<script> alert('Indivíduo não encontrado!') </script>";        
    }
    
    $conn->close();
    
    print "<script> window.location.href='../index.php' </script>";
    

?>