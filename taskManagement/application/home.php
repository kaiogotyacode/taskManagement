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
                    } ?>" class="userStatus" onclick="logout();">

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

    <div class="">

        <div class="adm-projects">
            <p>Gerenciamento de Projetos</p>
            <div class="adm-projects-content">
                <?php
                $queryAdmListProjetos = "SELECT * FROM projetos;";
                $retornoAdmListProj = $conn->query($queryAdmListProjetos);

                if ($retornoAdmListProj->num_rows > 0) {
                    while ($rowAdm = $retornoAdmListProj->fetch_assoc()) {
                        print "
                                <div class='adm-project-option' onclick=\"alert('" . $rowAdm['idProjeto'] . "')\">
                                <p> " . $rowAdm['nome'] . "</p>
                                <div style='background-color: #535c68' class='adm-project-management'>
                                    <p>Management</p>
                                </div>
                                </div>
                        ";
                    }
                }
                ?>

                <div class="adm-project-addProject">
                    <button id="AddNewProject" class="btn-newProject"> Adicionar Projeto </button>

                    <!-- Modal  -->
                    <div id="fade">
                        &nbsp;
                    </div>
                    <div id="modalNewProject">

                        <div class="exitModalNewProject" onclick="exitModalNewProject()">
                            <img src="../assets/images/exitIcon.png" height="50" width="50" />
                        </div>

                        <div class="modalHeader">
                            <p> Novo Projeto </p>
                        </div>
                        <div class="modalBody newProjectContainer">
                            <form method="POST" action="newProject.php" onsubmit="return validarNewProject()">
                                <div class="row">
                                    <div class="col-12">
                                        <label style="color: #fff;font-family: geomatrix" for="NPNome">Nome: </label>
                                        <input class="form-control" name="NPNome" id="NPNome" type="text" placeholder="Digite o nome..." />
                                    </div>

                                    <div class="col-12">
                                        <label style="color: #fff;font-family: geomatrix" for="NPDescricao">Descrição: </label>
                                        <textarea class="form-control" name="NPDescricao" id="NPDescricao" type="text" placeholder="Digite a descrição..."></textarea>
                                    </div>

                                    <div class="col-12">
                                        <label style="color: #fff;font-family: geomatrix" for="NPDataInicio">Data Início: </label>
                                        <input class="form-control" name="NPDataInicio" id="NPDataInicio" type="date" />
                                    </div>

                                    <div class="col-12">
                                        <label style="color: #fff;font-family: geomatrix" for="NPDataInicio">Data Término: </label>
                                        <input class="form-control" name="NPDataTermino" id="NPDataTermino" type="date" />
                                    </div>

                                    <div class="align-submit-button">
                                        <input type="submit" class="btn-newProject" value="Cadastrar" onclick="return false()" />
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Modal  -->
                </div>

            </div>
        </div>


        <?php
        if ($_SESSION['s_admin'] == 1) {
            print "<script> hideContent(); </script>";
        } else {
            print "<script> hideFromUser(); </script>";
        }
        ?>
        <div class="my-projects">
            <h2> Meus Projetos </h2>
            <div class="my-projects-content">

                <?php

                $queryMyProjects  = "CALL sp_meusProjetos(" . $_SESSION['s_idUsuario'] . "); ";
                $retorno = $conn->query($queryMyProjects);

                if ($retorno->num_rows > 0) {

                    while ($row = $retorno->fetch_assoc()) {
                        print "
                        <div class='project-option' onclick=\"alert('" . $row['idProjeto'] . "')\">
                            <p> " . $row['Projeto'] . " </p>
                            <div style='";
                        if ($row['Responsável'] == 1) {
                            print "background-color: #22a6b3";
                        } else {
                            print "background-color: #7ed6df";
                        }
                        print "' class='my-project-isResponsable'>
                                ";
                        if ($row['Responsável'] == 1) {
                            print "  <p> Responsável </p> ";
                        } else {
                            print "  <p> Integrante </p>";
                        }
                        print "
                            </div>
                        </div>                            
                        ";
                    }
                }
                ?>

            </div>
        </div>

    </div>

</body>

</html>