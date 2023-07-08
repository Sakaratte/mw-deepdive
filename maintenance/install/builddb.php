create database additional;

CREATE TABLE additional.database (
	db_id INT NOT NULL PRIMARY KEY,
	db_name NVARCHAR(MAX) NOT NULL
)

CREATE TABLE additional.regexList (
	rl_id INT NOT NULL PRIMARY KEY,
	rl_pattern NVARCHAR(max) NOT NULL,
	rl_description BLOB(max),
	rl_query INT,
	rl_enabled int NOT NULL DEFAULT 1
);

CREATE TABLE additional.regexExclusion (
	re_id int NOT NULL PRIMARY KEY,
	re_pattern NVARCHAR(MAX) NOT NULL,
	re_enabled int NOT NULL DEFAULT 1
);

CREATE TABLE additional.query (
	qry_id INT NOT NULL PRIMARY KEY,
	qry_name NVARCHAR(MAX) NOT NULL 
);