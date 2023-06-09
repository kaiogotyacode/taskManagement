USE dbTaskManagement;


/*1 - CRIANDO UMA PROCEDURE PARA CADASTRAR ADMINISTRADOR */
DELIMITER //
	CREATE PROCEDURE sp_CadAdmin (
		IN nome VARCHAR(255),
		IN email VARCHAR(255),
		IN senha VARCHAR(255)
	)
	BEGIN
		INSERT INTO usuarios (nome, email, senha) VALUES (nome, email, senha);
		INSERT INTO administradores (idUsuario) VALUES  (LAST_INSERT_ID());
	END //
DELIMITER ;

/*2 - CRIANDO UMA PROCEDURE PARA CADASTRAR USUÁRIO */
DELIMITER //
	CREATE PROCEDURE sp_CadUser (
		IN nome VARCHAR(255),
		IN email VARCHAR(255),
		IN senha VARCHAR(255)
	)
	BEGIN
		INSERT INTO usuarios (nome, email, senha) VALUES (nome, email, senha);
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
		IN nome VARCHAR(255),
		IN descricao VARCHAR(255),
		IN dataInicio DATE,
		IN dataTermino DATE,
		IN isActive BOOL
	)
	BEGIN
		INSERT INTO projetos (nome,descricao,dataInicio,dataTermino,isActive) VALUES (nome,descricao,dataInicio,dataTermino,isActive);
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



/*	CRIAR O VÍNCULO DE USUÁRIO NO PROJETO */
DELIMITER //
	CREATE PROCEDURE sp_VinculaUsuarioProjeto(
		IN codUsuario INT, 
		IN codProjeto INT, 
		IN isResponsable BOOL	
	)
	BEGIN
		INSERT INTO usuarios_projetos  (codUsuario, codProjeto, isResponsable) VALUES (codUsuario,codProjeto,isResponsable);		
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
CREATE PROCEDURE sp_AlterarProjeto(
	IN nome VARCHAR(255),
	IN descricao VARCHAR(255),
	IN dataInicio DATE,
	IN dataTermino DATE
)

