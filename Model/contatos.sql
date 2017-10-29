create database testeFogo;
use testeFogo;

create table tb_pessoas (
  id int(11) auto_increment not null,
  nome varchar(80) not null,
  sobrenome varchar(80) default null,
  constraint pk_tb_pessoas primary key (id)
);

create table tb_contatos (
  id int(11) auto_increment not null,
  nome varchar(80) not null,
  sobrenome varchar(80) default null,
  email varchar(80) default null,
  telefone varchar(15) default null,
  celular varchar(15) default null,
  constraint pk_tb_contatos primary key (id)
);

select * from tb_pessoas;

select * from tb_contatos;