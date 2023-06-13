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

$queryManagement = "SELECT * FROM Projetos WHERE idProjeto = " . $_SESSION['s_idProjeto'];
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
        <p> <?php print $nome; ?> </p>
        <form action="atualizarProjeto.php" method="POST" onsubmit="return validarAlteracao()">
            <div class="project-management-content">
                <div class="management-row">
                    <img class="management-img-adjust" height="50" width="50" src="../assets/images/projectsIcon.png" />
                    <label class="management-label"> Projeto: </label>
                    <input class="form-control management-adjust" disabled value="<?php print $nome; ?>" placeholder="Digite um nome..." type="text" />
                </div>

                <div class="management-row">
                    <img class="management-img-adjust" height="50" width="50" src="../assets/images/descricaoIcon.png" />
                    <label class="management-label"> Descrição: </label>
                    <textarea class="form-control management-adjust" disabled placeholder="Digite um nome..." type="text"> <?php print $descricao; ?> </textarea>
                </div>

                <div class="management-row">
                    <img class="management-img-adjust" height="50" width="50" src="../assets/images/dateIcon.png" />
                    <label class="management-label"> Data Início: </label>
                    <input class="form-control management-adjust-data" disabled value="<?php print $dataInicio; ?>" type="date" />
                </div>

                <div class="management-row">
                    <img class="management-img-adjust" height="50" width="50" src="../assets/images/dateIconConcluded.png" />
                    <label class="management-label"> Data Término: </label>
                    <input class="form-control management-adjust-data" disabled value="<?php print $dataTermino; ?>" type="date" />
                </div>

                <div class="btn-content-management">
                    <button class="btn btn-danger" type="button" onclick="return excluirProjeto(<?php print $_SESSION['s_idProjeto'] ?>)">Excluir</button>
                    <button class="btn btn-primary" type="button" onclick="return alterarProjeto(<?php print $_SESSION['s_idProjeto'] ?>)">Alterar</button>
                </div>
            </div>
        </form>


    </div>


</body>

</html>