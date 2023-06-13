<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<?php
    session_start(); 
?>
<body>

<nav>
  &nbsp;
</nav>

<?php
    if($_SESSION['s_admin'] == 1){
        print "  <h1 class='display-2'>Seja bem-vindo Admin:  ".$_SESSION["s_nome"]  ." </h1>";
    }else{
        print "  <h1 class='display-2'>Seja bem-vindo Usuário: ". $_SESSION["s_nome"]  ." </h1>";        
    }
?>

<!-- Criar Interface para USUARIO ADMIN  -->
<!-- Criar Interface para USUARIO COMUM  -->

<!-- Final da Tarefa: Adicionar um verificador de SESSIONS para que então, seja exibido o conteúdo  -->

</body>
</html>