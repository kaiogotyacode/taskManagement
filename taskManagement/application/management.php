<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link rel="stylesheet" href="../assets/css/reset.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <script src="../assets/js/script.js"></script>
    <link rel="stylesheet" href="../../node_modules/bootstrap/dist/css/bootstrap.css">
</head>
<?php
session_start();
include('../conexao.php');

$_SESSION["s_idProjeto"]  =  $_REQUEST["idProjeto"];

$queryManagement = "SELECT * FROM Projetos WHERE idProjeto = ". $_SESSION['s_idProjeto'];
$retornoManagement = $conn->query($queryManagement);

$objProjeto = $retornoManagement->fetch_assoc();

$nome = $objProjeto['nome'];
$descricao = $objProjeto['descricao'];
$dataInicio = $objProjeto['dataInicio'];
$dataTermino = $objProjeto['dataTermino'];

?>

<body>

    <nav>
        <div class="divTitulo">
            <img src="../assets/images/calendarIcon.png" height="50" width="50" />
            <h1 class="tituloNav">Task Management</h1>
        </div>

        <div style="<?php if ($_SESSION['s_admin'] == 1) {
                        print "background-color: #f39c12;";
                    } else {
                        print "background-color: #3498db;";
                    } ?>" class="userStatus" onclick="logoutGerenciamento();">

            <img class="adm" height="50" width="50" src="../assets/images/userIcon.png" />

            <?php
            if ($_SESSION['s_admin'] == 1) {
                print $_SESSION["s_nome"];
                print "<br> ADM ";
            } else {
                print $_SESSION["s_nome"];
                print "<br> USER ";
            }
            ?>
        </div>

    </nav>

    <div class="project-management">
        <p><?php print $nome; ?></p>
        <div class="project-management-content">

        </div>

    </div>


</body>

</html>