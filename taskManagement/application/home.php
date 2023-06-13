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
    <div class="divTitulo">
        <img src="../assets/images/calendarIcon.png" height="50" width="50" /> 
        <h1 class="tituloNav">Task Management</h1>
    </div>

  <div style="<?php if($_SESSION['s_admin'] == 1){print "background-color: #f39c12;";}else{print "background-color: #3498db;";} ?>" class="userStatus">

  <img class="adm" height="50" width="50" src="../assets/images/userIcon.png"/>

  <?php
    if($_SESSION['s_admin'] == 1){
        print $_SESSION["s_nome"];
        print "<br> ADM ";
    }else{
        print $_SESSION["s_nome"];      
        print "<br> USER ";
    }
?>
  </div>   

</nav>



<!-- Criar Interface para USUARIO ADMIN  -->
<!-- Criar Interface para USUARIO COMUM  -->

<!-- Final da Tarefa: Adicionar um verificador de SESSIONS para que então, seja exibido o conteúdo  -->

</body>
</html>