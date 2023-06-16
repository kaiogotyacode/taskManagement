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

if(!empty($_REQUEST["idProjeto"])){
    $_SESSION["s_idProjeto"]  =  $_REQUEST["idProjeto"];
}

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
        <div onclick="window.location.href='./home.php'" class="divTitulo">
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
        <form action="alterarProjeto.php" method="POST" onsubmit="return validarAlteracao()">
            <div class="project-management-content">
                <div class="management-row">
                    <img class="management-img-adjust" height="50" width="50" src="../assets/images/projectsIcon.png" />
                    <label class="management-label"> Projeto: </label>
                    <input class="form-control management-adjust" name="mngNomeProjeto" id="mngNomeProjeto" disabled value="<?php print $nome; ?>" placeholder="Digite um nome..." type="text" />
                </div>

                <div class="management-row">
                    <img class="management-img-adjust" height="50" width="50" src="../assets/images/descricaoIcon.png" />
                    <label class="management-label"> Descrição: </label>
                    <textarea class="form-control management-adjust" name="mngDescricao" id="mngDescricao" disabled placeholder="Digite um nome..." type="text"> <?php print $descricao; ?> </textarea>
                </div>

                <div class="management-row">
                    <img class="management-img-adjust" height="50" width="50" src="../assets/images/dateIcon.png" />
                    <label class="management-label"> Data Início: </label>
                    <input class="form-control management-adjust-data" name="mngDataInicio" id="mngDataInicio" disabled value="<?php print $dataInicio; ?>" type="date" />
                </div>

                <div class="management-row">
                    <img class="management-img-adjust" height="50" width="50" src="../assets/images/dateIconConcluded.png" />
                    <label class="management-label"> Data Término: </label>
                    <input class="form-control management-adjust-data" name="mngDataTermino" id="mngDataTermino" disabled value="<?php print $dataTermino; ?>" type="date" />
                </div>

                <div class="btn-content-management">
                    <button class="btn btn-danger" type="button" onclick="return excluirProjeto(<?php print $_SESSION['s_idProjeto'] ?>)">Excluir</button>
                    <button class="btn btn-primary" id="btnAlteraProjeto" type="submit" onclick="return alterarProjeto(<?php print $_SESSION['s_idProjeto'] ?>)">Alterar</button>
                </div>
            </div>
        </form>
    </div>


    <div class="management-responsavel">
        <p> Responsáveis </p>

        <div class="management-responsavel-content">


        <?php 
            $queryResponsavel = "SELECT * FROM usuarios U INNER JOIN usuarios_projetos UP ON U.idUsuario =  UP.codUsuario WHERE UP.usuproj_isActive = 1 AND UP.isResponsable = 1 and UP.codProjeto = ". $_SESSION['s_idProjeto'];

            $retornoResponsavel = $conn->query($queryResponsavel);
            if($retornoResponsavel->num_rows >0){
                while($rowResponsavel = $retornoResponsavel->fetch_assoc()){
                    print " 
                    <div class='management-responsavel-option'>
                        <p> ". $rowResponsavel['nome'] ." </p>
                        <div class='mng-excluir-membro' onclick=\"excluirUsuarioProjeto(". $rowResponsavel['idUsuario']. ",". $rowResponsavel['codProjeto'] .")\">
                            <img src='../assets/images/binIcon.png' height='50' width='50' />
                        </div>
                    </div>
                    ";
                }
            }

        ?>
           

            <div class="btnAddMember-content">
                <button id="AddNewResponsavel" onclick="return openModalNewResponsavel()" class="btnAddMember"> Adicionar Responsável </button>
            </div>

            <div class="adm-management-addResponsavel">

                <div id="modalNewResponsavel">                    
                    <div class="exitModalNewResponsavel" onclick="exitModalNewResponsavel()">
                        <img src="../assets/images/exitIcon.png" height="50" width="50" />
                    </div>

                    <div class="modalHeader">
                        <p> Novo Responsável </p>
                    </div>
                    <div class="modalBody newResponsavelContainer">
                        <form method="POST" action="newResponsavel.php" onsubmit="return validarNewResponsavel()">
                            <div class="row">

                                <div class="col-12">
                                    <label style="color: #fff;font-family: geomatrix" for="NPNome">Selecione um novo responsável: </label>
                                    <select class="form-select" id="sltResponsavel">
                                        <option value="0" selected>[Selecione uma opção]</option>

                                        <?php
                                            $queryUsuariosNaoVinculados = "CALL sp_UsuariosNaoVinculados(". $_SESSION['s_idProjeto'] .")";
                                            $retornoUsuariosNaoVinculados = $conn->query($queryUsuariosNaoVinculados);

                                            if($retornoUsuariosNaoVinculados && $retornoUsuariosNaoVinculados->num_rows > 0){
                                                while($rowUsuarios = $retornoUsuariosNaoVinculados->fetch_assoc()){
                                                    print "<option value='".$rowUsuarios['idUsuario']."'> ". $rowUsuarios['nome'] ."</option>";
                                                }
                                            }
                                        ?>
                                        
                                    </select>
                                </div>

                                <div class="align-submit-button">
                                    <input type="submit" class="btn-newResponsavel" value="Cadastrar" onclick="return false()" />
                                </div>

                            </div>
                        </form>
                    </div>
                </div>


                <div id="fade">
                    &nbsp;
                </div>

            </div>


        </div>

    </div>



</body>

</html>