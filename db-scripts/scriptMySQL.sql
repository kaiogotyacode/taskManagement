USE dbTaskManagement;

/*1 - CRIANDO UMA PROCEDURE PARA CADASTRAR ADMINISTRADOR */
DELIMITER //
	CREATE PROCEDURE sp_CadAdmin (
		IN p_nome VARCHAR(255),
		IN p_email VARCHAR(255),
		IN p_senha VARCHAR(255)
	)
	BEGIN
		INSERT INTO usuarios (nome, email, senha) VALUES (p_nome, p_email, p_senha);
		INSERT INTO administradores (idUsuario) VALUES  (LAST_INSERT_ID());
	END //
DELIMITER ;






/*2 - CRIANDO UMA PROCEDURE PARA CADASTRAR USUÁRIO */
DELIMITER //
	CREATE PROCEDURE sp_CadUser (
		IN p_nome VARCHAR(255),
		IN p_email VARCHAR(255),
		IN p_senha VARCHAR(255)
	)
	BEGIN
		INSERT INTO usuarios (nome, email, senha) VALUES (p_nome, p_email, p_senha);
	END //
DELIMITER ;





/*	3 - Inserindo um ADMINISTRADOR VIA PROCEDURE - Criar o usuário Kaio como ADM */
CALL sp_CadAdmin ('Kaio Maciel','kaioreis1153@hotmail.com','kaio12345');




/* 4 -
	Criar o usuário Joaquim como Usuário Comum
	Criar o usuário Antonia como Usuário Comum
	Criar o usuário Vilma como Usuário Comum
*/




CALL sp_CadUser('Joaquim', 'joaquimcarneiro@hotmail.com', 'joakino2023' );
CALL sp_CadUser('Antonia', 'antoniapereira@hotmail.com', 'toninha0606' );
CALL sp_CadUser('Vilma', 'vila@yahoo.com', 'vilma@sandrola' );





/*CRIANDO A PROCEDURE -> CADASTRO DE PROJETO*/
DELIMITER //
	CREATE PROCEDURE sp_CadProjeto (
		IN p_nome VARCHAR(255),
		IN p_descricao VARCHAR(255),
		IN p_dataInicio DATE,
		IN p_dataTermino DATE,
		IN p_isActive BOOL
	)
	BEGIN
		INSERT INTO projetos (nome,descricao,dataInicio,dataTermino,projeto_isActive) VALUES (p_nome,p_descricao,p_dataInicio,p_dataTermino,p_isActive);
	END //
DELIMITER ;


/*	5 - O ADM (Kaio) criará 3 projetos: "CINEMA" ,  "VÔLEI"  ,  "FESTA JUNINA"*/
CALL sp_CadProjeto ('Cinema', 'O projeto reunirá um grupo de amigos para ir ao cinema numa data específica.', CURDATE() , '2023-06-13', 1 );
CALL sp_CadProjeto ('Vôlei', 'Um grande evento de vôlei está por vir! ', CURDATE() , '2023-06-30', 1 );
CALL sp_CadProjeto ('Festa Junina', 'Em comemoração ao dia de São João, teremos a nossa Festa Junina!', CURDATE() , '2023-06-13', 1 );




/*	HOME -> "MY PROJECTS" : Exibir projetos vinculados ao usuário.	*/
	SELECT P.nome 'Projeto', U.nome 'Usuário', UP.isResponsable 'Responsável'  
	FROM USUARIOS U 
	INNER JOIN usuarios_projetos UP ON U.idUsuario = UP.codUsuario 
	INNER JOIN projetos P ON P.idProjeto = UP.codProjeto WHERE U.idUsuario = 2;








/*	CRIAR O VÍNCULO DE USUÁRIO NO PROJETO [RESPONSÁVEL/INTEGRANTE] */
/* helper: CodUsuario, codProjeto, isResponsable[bool]*/
DELIMITER //
	CREATE PROCEDURE sp_VinculaUsuarioProjeto(
		IN p_codUsuario INT, 
		IN p_codProjeto INT, 
		IN p_isResponsable BOOL	
	)
	BEGIN
		INSERT INTO usuarios_projetos  (codUsuario, codProjeto, isResponsable, 	usuproj_isActive) VALUES (p_codUsuario,p_codProjeto,p_isResponsable, 1);		
	END //
DELIMITER ;



/*Joaquim participa do CINEMA como RESPONSÁVEL*/
CALL sp_VinculaUsuarioProjeto (2,1,1);

/*Antonia participa do VÔLEI como RESPONSÁVEL*/
CALL sp_VinculaUsuarioProjeto (3,2,1);

/*Vilma participa do FESTA JUNINA como RESPONSÁVEL*/
CALL sp_VinculaUsuarioProjeto (4,3,1);


/* Uma vez criado os RESPONSÁVEIS, agora adicione os Integrantes para cada projeto seguindo o SCRIPT abaixo:

	
	No projeto Cinema
		Responsável: Joaquim
		Integrantes:
			1 - Antonia
			2 - Vilma
		
	No projeto Volei
		Responsável: Antonia
		Integrantes:
			1 - Joaquim
			2 - Vilma
			
	No projeto Festa Junina
		Responsável: Vilma 
		Integrantes:
			1 - Joaquim
			2 - Antonia		
			
*/

/* NOVOS INTEGRANTES: Antonia & Vilma [CINEMA]*/
CALL sp_VinculaUsuarioProjeto (3,1,0);
CALL sp_VinculaUsuarioProjeto (4,1,0);

/* NOVOS INTEGRANTES: Joaquim & Vilma [VÔLEI]*/
CALL sp_VinculaUsuarioProjeto (2,2,0);
CALL sp_VinculaUsuarioProjeto (4,2,0);

/* NOVOS INTEGRANTES: Joaquim & Antonia[FESTA JUNINA]*/
CALL sp_VinculaUsuarioProjeto (2,3,0);
CALL sp_VinculaUsuarioProjeto (3,3,0);




/* MÉTODO ALTERAR [PROJETO] */ 
/*HELPER: Nome, Descricao, DataInicio, DataTermino, codProjeto */
DELIMITER //
	CREATE PROCEDURE sp_AlterarProjeto(
		IN p_nome VARCHAR(255),
		IN p_descricao VARCHAR(255),
		IN p_dataInicio DATE,
		IN p_dataTermino DATE,
		IN p_codProjeto INT
	)
	BEGIN
		UPDATE projetos SET nome = p_nome, descricao = p_descricao, dataInicio = p_dataInicio, dataTermino = p_dataTermino WHERE idProjeto = p_codProjeto;
	END //
DELIMITER ;







/*CRIAR MÉTODO: REMOVER/ADICIONAR CARGO DE RESPONSÁVEL */
DELIMITER //
	CREATE PROCEDURE sp_SwitchResponsavel(
		IN p_codUsuario INT,
		IN p_codProjeto INT,
		IN p_isResponsable BOOL
	)
	BEGIN
		UPDATE usuarios_projetos SET isResponsable = p_isResponsable WHERE (codUsuario = p_codUsuario AND codProjeto = p_codProjeto);
	END //
DELIMITER ;




/*helper SwitchResponsavel: CodUsuario, CodProjeto, isResponsable 
CALL sp_SwitchResponsavel (2,1,1);
CALL sp_SwitchResponsavel (3,2,1);
CALL sp_SwitchResponsavel (4,3,1);
*/



/*CRIAR MÉTODO: REMOVER RESPONSÁVEL/INTEGRANTE DO PROJETO  */
/*helper: codUsuario, codProjeto*/
DELIMITER //
	CREATE PROCEDURE sp_RemoveUsuarioProjeto(
		IN p_codUsuario INT,
		IN p_codProjeto INT
	)	
	BEGIN
		UPDATE usuarios_projetos UP  SET UP.usuproj_isActive = 0, UP.isResponsable = 0 WHERE UP.codUsuario = p_codUsuario AND UP.codProjeto = p_codProjeto;
	END //
DELIMITER ;




/*	MEUS PROJETOS [SELECT]*/
/*helper: idUsuario */
DELIMITER //
	CREATE PROCEDURE sp_meusProjetos (
		IN p_idUsuario INT
	)
	BEGIN
      	SELECT P.idProjeto 'idProjeto', P.nome 'Projeto', U.nome 'Usuário', UP.isResponsable 'Responsável'  
			FROM USUARIOS U 
			INNER JOIN usuarios_projetos UP ON U.idUsuario = UP.codUsuario 
			INNER JOIN projetos P ON P.idProjeto = UP.codProjeto WHERE U.idUsuario = p_idUsuario AND P.projeto_isActive =  1 AND UP.usuproj_isActive = 1;
	END //

DELIMITER ;







/*	MINHAS TAREFAS [SELECT]*/
/*helper: idUsuario, idProjeto */
DELIMITER //
	CREATE PROCEDURE sp_MinhasTarefas (
		IN p_idUsuario INT,
		IN p_idProjeto INT
	)
	BEGIN

            SELECT U.idUsuario AS 'Código', U.nome AS 'Usuário', P.nome AS 'Projeto', T.descricao AS 'Tarefa'
            FROM usuarios U
            INNER JOIN usuarios_projetos UP ON U.idUsuario = UP.codUsuario
            INNER JOIN projetos P ON P.idProjeto = UP.codProjeto
            INNER JOIN tarefas T ON (T.codProjeto = P.idProjeto AND T.codUsuario = U.idUsuario)
            WHERE U.idUsuario = p_idUsuario AND P.idProjeto = p_idProjeto AND UP.usuproj_isActive = 1 AND P.projeto_isActive = 1;
	END //

DELIMITER ;






/* STORED PROCEDURE - 	NOVA TAREFA [CREATE]*/
/*helper: codProjeto, codUsuario, descricao, dataInicio, dataTermino, status */
DELIMITER //
CREATE PROCEDURE sp_NovaTarefa(
	IN p_codProjeto INT,
	IN p_codUsuario INT,
	IN p_descricao VARCHAR(255),
	IN p_dataInicio DATE,
	IN p_dataTermino DATE,
	IN p_status INT 
)
BEGIN
	INSERT INTO tarefas (codProjeto, codUsuario, descricao, dataInicio, dataTermino, STATUS) 
	VALUES (p_codProjeto, p_codUsuario, p_descricao, p_dataInicio, p_dataTermino, p_status);
END//

DELIMITER ;




/*CRIAR PROCEDURE (RESPONSÁVEL): VER TAREFAS DA EQUIPE: PROJETO - NOME DO USUÁRIO - DESC TAREFA - DATA TÉRMINO - STATUS TAREFA*/
/*idProjeto*/
DELIMITER //
	CREATE PROCEDURE sp_VerTarefasEquipe(
		IN p_idProjeto INT
	)
	BEGIN
		SELECT P.nome 'Projeto', U.nome 'Usuário', T.descricao 'Tarefa', T.dataTermino 'Data Término', T.`Status` 'Status'
		FROM usuarios U INNER JOIN usuarios_projetos UP ON U.idUsuario = UP.codUsuario
		INNER JOIN projetos P ON P.idProjeto = UP.codProjeto 
		INNER JOIN tarefas T ON T.codProjeto = P.idProjeto AND T.codUsuario = U.idUsuario
		WHERE P.idProjeto = p_idProjeto AND UP.usuproj_isActive = 1 AND P.projeto_isActive = 1;
	END //
DELIMITER ;

/*ALTERAR SITUAÇÃO DA TAREFA*/
/* 
	STATUS 1: EM ANDAMENTO
	STATUS 2: EM ALERTA
	STATUS 3: FINALIZADO
	
*/
DELIMITER //
	CREATE PROCEDURE sp_AlterarSituacaoTarefa(
		IN p_idTarefa INT,
		IN p_situacao INT
	)
	BEGIN
		UPDATE tarefas SET STATUS = p_situacao WHERE idTarefa = p_idTarefa;	
	END //
DELIMITER ;

/*	PROCEDURE: ADD COMMENT [CREATE] */
/*helper: codTarefa, Texto  */
DELIMITER //
	CREATE PROCEDURE sp_AdicionarComentario(
		IN p_codTarefa INT,
		IN p_texto VARCHAR(255)		
	)
	BEGIN
		INSERT INTO comentarios (codTarefa, texto, dataHora) VALUES (p_codTarefa, p_Texto, NOW());
	END//
DELIMITER ; 
	

CALL sp_AdicionarComentario(1,'Fui ao mercado porecatu e não encontrei a Pipoca do Tipo Doce Caramelo! Precisarei de mais tempo para tentar encontrar no Muffato!');
	
CALL sp_MinhasTarefas(2,1);
	

DELIMITER //
				
CREATE PROCEDURE sp_UsuariosNaoVinculados(
	IN p_codProjeto INT 
)
BEGIN						
	SELECT * FROM usuarios U  WHERE NOT EXISTS 
	(
		SELECT * FROM usuarios_projetos UP  WHERE UP.codProjeto = p_codProjeto AND UP.codUsuario = U.idUsuario AND UP.usuproj_isActive = 1
	);

END//

DELIMITER ;
		

DELIMITER //
CREATE PROCEDURE sp_selectUsuarios(
	IN p_idProjeto INT
)
BEGIN
SELECT U.nome, U.idUsuario FROM usuarios U INNER JOIN usuarios_projetos UP ON U.idUsuario = UP.codUsuario 
								 INNER JOIN projetos P ON P.idProjeto = UP.codProjeto 
								 WHERE P.idProjeto = p_idProjeto AND UP.usuproj_isActive = 1 AND P.projeto_isActive = 1;
END //
DELIMITER ;

							
							
							
							
							
							
