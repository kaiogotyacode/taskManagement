<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link rel="stylesheet" href="../assets/css/reset.css">
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



<div class="container">    

<?php 

    $contador = 0;

    if($_SESSION['s_admin'] == 0){
        print "";
    }
?>
    <div class="my-projects">
        <h2> Meus Projetos </h2>
        <div class="my-projects-content">

            <?php 
                include ('../conexao.php');

                $queryMyProjects  = "CALL sp_meusProjetos(". $_SESSION['s_idUsuario'] ."); ";
                $retorno = $conn->query($queryMyProjects);

                if($retorno->num_rows > 0){

                    while($row = $retorno->fetch_assoc()){
                        print "
                        <div class='project-option' onclick=\"alert('".$row['idProjeto']."')\">
                            <p> ".$row['Projeto']." </p>
                            <div style='";
                        if($row['Responsável'] == 1 ){print "background-color: #22a6b3";}else{print "background-color: #7ed6df";}
                        print "' class='my-project-isResponsable'>
                                ";
                                    if($row['Responsável'] == 1 ){
                                        print "  <p> Responsável </p> ";
                                    }else{
                                        print "  <p> Integrante </p>";                                        
                                    }
                                print "
                            </div>
                        </div>                            
                        ";
                    }                        
                }else{

                        print "<script> alert('Ñ tem projeto!!') </script> ";
                }

            ?>          

        </div>
    </div>


</div>

</body>
</html>