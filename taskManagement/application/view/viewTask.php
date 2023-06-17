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

    if (!empty($_REQUEST["idTarefa"])) {
        $_SESSION["s_idTarefa"]  =  $_REQUEST["idTarefa"];
    }

    $queryViewTask = "  SELECT U.nome 'nomeUsuario', T.descricao 'Descricao', T.dataInicio 'dataInicio', T.dataTermino 'dataTermino', 
                        CASE 
                        WHEN T.`Status` = 1 THEN 'Em Andamento'
                        WHEN T.`Status` = 2 THEN 'Em Alerta'
                        WHEN T.`Status` = 3 THEN 'Finalizado'
                        ELSE '-'
                            END AS 'Status'
                        FROM usuarios U INNER JOIN usuarios_projetos UP ON U.idUsuario = UP.codUsuario
                                        INNER JOIN projetos P ON P.idProjeto = UP.codProjeto 
                                        INNER JOIN tarefas T ON P.idProjeto = T.codProjeto AND T.codUsuario = U.idUsuario
                        WHERE idTarefa = " . $_SESSION['s_idTarefa'];

    $retornoViewTask= $conn->query($queryViewTask);

    $objTarefa = $retornoViewTask->fetch_assoc();

    $nomeUsuario = $objTarefa['nomeUsuario'];
    $descricao = $objTarefa['Descricao'];
    $dataInicio = $objTarefa['dataInicio'];
    $dataTermino = $objTarefa['dataTermino'];
    $status = $objTarefa['Status'];

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
        <p> Tarefa </p>       
            <div class="project-management-content">
                <div class="management-row">
                    <img class="management-img-adjust" height="50" width="50" src="../../assets/images/userIcon.png" />
                    <label class="management-label"> Responsável: </label>
                    <input class="form-control management-adjust" name="mngNomeUsuario" id="mngNomeUsuario" disabled value="<?php print $nomeUsuario; ?>" type="text" />
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
                
                <div class="management-row">
                    <img class="management-img-adjust" height="50" width="50" src="../../assets/images/statusIcon.png" />
                    <label class="management-label"> Situação: </label>
                    <input class="form-control management-adjust" style="width: fit-content;text-align: center;" name="mngNomeUsuario" id="mngNomeUsuario" disabled value="<?php print $status; ?>" type="text" />
                </div>
    
    </div>

    <div class="management-responsavel">
        <p> Comentários </p>

        <div class="management-responsavel-content">
            <?php
            $queryComentario = "SELECT * FROM Comentarios where codTarefa = ".$_SESSION['s_idTarefa']; 

            $retornoComentario = $conn->query($queryComentario);
            if ($retornoComentario->num_rows > 0) {
                while ($rowComentario = $retornoComentario->fetch_assoc()) {
                    print " 
                    <div class='management-responsavel-option'>
                        <textarea disabled class='form-control'> " . $rowComentario['texto'] . " </textarea>
                        <div class='comentario-hora'>
                            ". $rowComentario['dataHora'] ."
                        </div>                        
                    </div>
                    ";
                }
            }

            ?>


            <div class="btnAddMember-content">
                <button id="AddNewResponsavel" onclick="return openModalNewComentario()" class="btnAddMember"> Adicionar Responsável </button>
            </div>

            <div class="adm-management-addResponsavel">

                <div id="modalNewComentario">
                    <div class="exitModalNewResponsavel" onclick="exitModalNewComentario()">
                        <img src="../../assets/images/exitIcon.png" height="50" width="50" />
                    </div>

                    <div class="modalHeader">
                        <p> Novo Comentário </p>
                    </div>
                    <div class="modalBody newResponsavelContainer">
                        <form method="POST" action="../application/newResponsavel.php?" onsubmit="return validarNewResponsavel()">
                            <div class="row">

                                <div class="col-12">
                                    <label style="color: #fff;font-family: geomatrix" for="NPNome">Selecione um novo responsável: </label>
                                    <select name="sltResponsavel" class="form-select" id="sltResponsavel">
                                        <option value="0" selected>[Selecione uma opção]</option>

                                        <?php
                                            $queryUsuariosNaoVinculados = "CALL sp_UsuariosNaoVinculados(" . $_SESSION['s_idProjeto'] . ")";
                                            $retornoUsuariosNaoVinculados = $conn->query($queryUsuariosNaoVinculados);

                                            if ($retornoUsuariosNaoVinculados && $retornoUsuariosNaoVinculados->num_rows > 0) {
                                                while ($rowUsuarios = $retornoUsuariosNaoVinculados->fetch_assoc()) {
                                                    print "<option value='" . $rowUsuarios['idUsuario'] . "'> " . $rowUsuarios['nome'] . "</option>";
                                                }
                                            }

                                        ?>

                                    </select>
                                </div>

                                <div class="align-submit-button">
                                    <input type="submit" class="btn-newResponsavel" value="Cadastrar" />
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

    <div class="management-responsavel">

        <p>  Alterar Status </p>

        <div class="management-responsavel-content status-content">
           <button class='btn btn-success status-option'> Em Andamento </button>
           <button class='btn btn-warning status-option'> Em Alerta </button>
           <button class='btn btn-danger status-option'> Finalizado </button>
        </div>

    </div>


</body>

</html>