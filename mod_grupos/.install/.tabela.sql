CREATE TABLE simulacoes_grupos (
  id_grupo int(11) NOT NULL,
  nome_grupo varchar(250) DEFAULT NULL,
  descricao text DEFAULT NULL,
   nome_responsavel varchar(250) DEFAULT null,  contacto varchar(250) DEFAULT null,  contacto_alternativo varchar(250) DEFAULT null,  nif int(11) DEFAULT null,  morada varchar(250) DEFAULT null,  cod_post varchar(250) DEFAULT null,  localidade varchar(250) DEFAULT null,  id_cliente int(11) DEFAULT null,  id_simulacao int(11) DEFAULT null, 
  id_criou int(11) DEFAULT NULL,
  created_at timestamp DEFAULT CURRENT_TIMESTAMP,
  id_editou int(11) DEFAULT NULL,
  updated_at datetime DEFAULT NULL,
  ativo int(11) DEFAULT '1'
);