<?php 
    include('../conexao.php');

    $nome = $_POST["nome"];
    $email = $_POST["email"];
    $senha = $_POST["senha"];

    $sql = "INSERT INTO USUARIOS (NOME,EMAIL,SENHA) VALUES ('$nome','$email', '$senha')";

    $res = $conn->query($sql);

    if($res){
        print   "<script>
                    alert('Usuário $nome cadastrado com sucesso!');
                    window.location.href='../index.php';
                </script>";
    }else{
        print   "<script>
                    alert('Falha ao cadastrar usuário!') 
                    window.location.href='../index.php';
                </script>";        
    }

    $conn->close();

?>