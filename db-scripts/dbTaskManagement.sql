CREATE DATABASE dbTaskManagement;
USE dbTaskManagement;


CREATE TABLE Usuarios (
	idUsuario INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
	nome  VARCHAR(255),
	email VARCHAR(255),
	senha VARCHAR(255)
);

CREATE TABLE administradores (
   idUsuario INT PRIMARY KEY,
	FOREIGN KEY (idUsuario) REFERENCES Usuarios(idUsuario)
);

CREATE TABLE Projetos (
	idProjeto INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
	nome		VARCHAR(255),
	descricao	VARCHAR(255),
	dataInicio DATE,
	dataTermino DATE,
	projeto_isActive BOOL
);

CREATE TABLE Usuarios_Projetos(
	codUsuario INT,
	codProjeto INT,
	
	isResponsable BOOL,
	
	usuproj_isActive BOOL,
	
	FOREIGN KEY (codProjeto) REFERENCES Projetos(idProjeto),
	FOREIGN KEY (codUsuario) REFERENCES Usuarios(idUsuario),

	PRIMARY KEY (codUsuario, codProjeto)
);

CREATE TABLE Tarefas (
	idTarefa INT PRIMARY KEY NOT NULL AUTO_INCREMENT,

	codProjeto INT,
	codUsuario INT,

	descricao	VARCHAR(255),
	dataInicio	DATE,
	dataTermino	DATE,

	Status INT CHECK (Status IN(1,2,3)),
	FOREIGN KEY (codProjeto) REFERENCES Projetos(idProjeto),
	FOREIGN KEY (codUsuario) REFERENCES Usuarios(idUsuario)
);

CREATE TABLE Comentarios (
	idComentario INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
	codTarefa INT,
	texto VARCHAR(255),
	dataHora DATETIME,
	
	FOREIGN KEY (codTarefa) REFERENCES Tarefas(idTarefa)
);



