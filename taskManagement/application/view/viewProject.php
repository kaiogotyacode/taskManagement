<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Project</title>
    <link rel="stylesheet" href="../../assets/css/reset.css">
    <link rel="stylesheet" href="../../assets/css/style.css">
    <script src="../../assets/js/script.js"></script>
    <link rel="stylesheet" href="../../../node_modules/bootstrap/dist/css/bootstrap.css">
</head>

<body>
    <?php
    session_start();
    include('../../conexao.php');

    if (!empty($_REQUEST["idProjeto"])) {
        $_SESSION["s_idProjeto"]  =  $_REQUEST["idProjeto"];
    }

    $queryViewProject = "SELECT * FROM Projetos WHERE idProjeto = " . $_SESSION['s_idProjeto'];
    $retornoViewProject = $conn->query($queryViewProject);

    $objProjeto = $retornoViewProject->fetch_assoc();

    $nome = $objProjeto['nome'];
    $descricao = $objProjeto['descricao'];
    $dataInicio = $objProjeto['dataInicio'];
    $dataTermino = $objProjeto['dataTermino'];

    ?>
    <nav>
        <div onclick="window.location.href='./../home.php'" class="divTitulo">
            <img src="../../assets/images/calendarIcon.png" height="50" width="50" />
            <h1 class="tituloNav">Task Management</h1>
        </div>

        <div style="<?php if ($_SESSION['s_admin'] == 1) {
                        print "background-color: #f39c12;";
                    } else {
                        print "background-color: #3498db;";
                    } ?>" class="userStatus" onclick="logout(1);">

            <img class="adm" height="50" width="50" src="../../assets/images/userIcon.png" />

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
                    <img class="management-img-adjust" height="50" width="50" src="../../assets/images/projectsIcon.png" />
                    <label class="management-label"> Projeto: </label>
                    <input class="form-control management-adjust" name="mngNomeProjeto" id="mngNomeProjeto" disabled value="<?php print $nome; ?>" placeholder="Digite um nome..." type="text" />
                </div>

                <div class="management-row">
                    <img class="management-img-adjust" height="50" width="50" src="../../assets/images/descricaoIcon.png" />
                    <label class="management-label"> Descrição: </label>
                    <textarea class="form-control management-adjust" name="mngDescricao" id="mngDescricao" disabled placeholder="Digite um nome..." type="text"> <?php print $descricao; ?> </textarea>
                </div>

                <div class="management-row">
                    <img class="management-img-adjust" height="50" width="50" src="../../assets/images/dateIcon.png" />
                    <label class="management-label"> Data Início: </label>
                    <input class="form-control management-adjust-data" name="mngDataInicio" id="mngDataInicio" disabled value="<?php print $dataInicio; ?>" type="date" />
                </div>

                <div class="management-row">
                    <img class="management-img-adjust" height="50" width="50" src="../../assets/images/dateIconConcluded.png" />
                    <label class="management-label"> Data Término: </label>
                    <input class="form-control management-adjust-data" name="mngDataTermino" id="mngDataTermino" disabled value="<?php print $dataTermino; ?>" type="date" />
                </div>

            </div>
        </form>
    </div>

    <?php
    if ($_REQUEST['isResponsable'] == 1) {
        print "
                    <div class='responsible-management'>
                        <button class='btn-gerenciar' onclick='openModalManageTask()'>Gerenciar Tarefas</button>
                    </div>
            ";
    }
    ?>

    <!-- Modal  -->
    <div id="fade">
        &nbsp;
    </div>
    <div id="modalNewTask">

        <div class="exitModalNewTask" onclick="exitModalNewTask()">
            <img src="../../assets/images/exitIcon.png" height="50" width="50" />
        </div>

        <div class="modalHeader">
            <p> Nova Tarefa </p>
        </div>
        <div class="modalBody newProjectContainer">
            <form method="POST" action="newTask.php?isResponsable=<?php print $_REQUEST["isResponsable"];?>" onsubmit="return validarNewTask()">
                <div class="row">

                    <div class="col-12">
                        <label style="color: #fff;font-family: geomatrix" for="NPNome">Selecione um membro da equipe: </label>
                        <select name="sltRespTarefa" class="form-select" id="sltRespTarefa">
                            <option value="0" selected>[Selecione uma opção]</option>

                            <?php
                            $queryUsuarios = "CALL sp_selectUsuarios(" . $_SESSION['s_idProjeto'] . ")";
                            $retornoUsuarios = $conn->query($queryUsuarios);

                            if ($retornoUsuarios && $retornoUsuarios->num_rows > 0) {
                                while ($rowUsuarios = $retornoUsuarios->fetch_assoc()) {
                                    print "<option value='" . $rowUsuarios['idUsuario'] . "'> " . $rowUsuarios['nome'] . "</option>";
                                }
                            }

                            ?>

                        </select>
                    </div>

                    <div class="col-12">
                        <label style="color: #000;font-family: geomatrix" for="NTDescricao">Descrição da Tarefa: </label>
                        <textarea class="form-control" name="NTDescricao" id="NTDescricao" type="text" placeholder="Digite a descrição..."> </textarea>
                    </div>

                    <div class="col-12">
                        <label style="color: #000;font-family: geomatrix" for="NTDataTermino">Data de Término: </label>
                        <input class="form-control" name="NTDataTermino" id="NTDataTermino" type="date" />
                    </div>

                    <div class="align-submit-button">
                        <input type="submit" class="btn-newTask" value="Cadastrar" onclick="return false()" />
                    </div>

                </div>
            </form>
        </div>
    </div>


    <div class="management-responsavel">
        <p> Responsáveis </p>

        <div class="management-responsavel-content fundoResponsaveis">
            <?php
            $conn->close();
            $conn = new mysqli(HOST, USER, PASS, DB);

            $queryResponsavel = "SELECT * FROM usuarios U INNER JOIN usuarios_projetos UP ON U.idUsuario =  UP.codUsuario WHERE UP.usuproj_isActive = 1 AND UP.isResponsable = 1 and UP.codProjeto = " . $_SESSION['s_idProjeto'];

            $retornoResponsavel = $conn->query($queryResponsavel);
            if ($retornoResponsavel->num_rows > 0) {
                while ($rowResponsavel = $retornoResponsavel->fetch_assoc()) {
                    print " 
                    <div class='management-responsavel-option'>
                        <p> " . $rowResponsavel['nome'] . " </p>                      
                    </div>
                    ";
                }
            }
            ?>
        </div>
    </div>

    <div class="management-responsavel">
        <p> Integrantes </p>

        <div class="management-responsavel-content fundoIntegrantes">
            <?php

            $conn->close();
            $conn = new mysqli(HOST, USER, PASS, DB);

            $queryIntegrante = "SELECT * FROM usuarios U INNER JOIN usuarios_projetos UP ON U.idUsuario =  UP.codUsuario WHERE UP.usuproj_isActive = 1 AND UP.isResponsable = 0 and UP.codProjeto = " . $_SESSION['s_idProjeto'];


            $retornoIntegrante = $conn->query($queryIntegrante);

            if ($retornoIntegrante->num_rows > 0) {

                while ($rowIntegrante = $retornoIntegrante->fetch_assoc()) {
                    print " 
                        <div class='management-responsavel-option'>
                            <p> " . $rowIntegrante['nome'] . " </p>                            
                        </div>
                        ";
                }
            }
            ?>
        </div>

    </div>

    <div class="management-responsavel">
        <p> Minhas Tarefas </p>

        <div class="management-responsavel-content fundoMinhasTarefas">
            <?php

            $conn->close();
            $conn = new mysqli(HOST, USER, PASS, DB);

            $queryTarefas = "CALL sp_MinhasTarefas(" . $_SESSION['s_idUsuario'] . "," . $_SESSION['s_idProjeto'] . ")";


            $retornoTarefas = $conn->query($queryTarefas);

            if ($retornoTarefas->num_rows > 0) {

                while ($rowTarefa = $retornoTarefas->fetch_assoc()) {
                    print " 
                        <div class='management-responsavel-option tarefa-option' onclick=\"window.location.href='./viewTask.php?idTarefa=".$rowTarefa['idTarefa']."&isYours=1'\">
                            <div class='tarefa-usuario'>
                                ".$rowTarefa['Usuário']."
                            </div>
                            <div class='tarefa-descricao'>
                                ". $rowTarefa['Tarefa']."    
                            </div>
                            <div class='statusTarefa'> 
                            ". $rowTarefa['Status']."    
                            </div>                        
                        </div>
                        ";
                }
            }
            ?>
        </div>

    </div>

    <?php
    if ($_REQUEST['isResponsable'] == 1) {
        print "
            <div class='management-responsavel'>
            <p> Tarefas da Equipe </p>

            <div class='management-responsavel-content fundoTarefasEquipe'>";
        $conn->close();        
        $conn = new mysqli(HOST, USER, PASS, DB);        
        $queryTarefasEquipe = "CALL sp_VerTarefasEquipe(". $_SESSION['s_idProjeto'].")";        
        $retornoTarefasEquipe = $conn->query($queryTarefasEquipe);

        if ($retornoTarefasEquipe->num_rows > 0) {
                        while ($rowTarefaEquipe = $retornoTarefasEquipe->fetch_assoc()) {
                print "     <div class='management-responsavel-option tarefa-option' onclick=\"window.location.href='./viewTask.php?idTarefa=".$rowTarefaEquipe['idTarefa']."&isYours=0'\">
                                <div class='tarefa-usuario'>
                                    ".$rowTarefaEquipe['Usuário']."
                                </div>
                                <div class='tarefa-descricao'>
                                    ". $rowTarefaEquipe['Tarefa']."    
                                </div>
                                <div class='statusTarefaEquipe'> 
                                ". $rowTarefaEquipe['Status']."    
                                 </div> 
                            </div>                      
                            ";
            }
        }
        "                
            </div>
        </div>
        ";
    }
    ?>



</body>

</html>