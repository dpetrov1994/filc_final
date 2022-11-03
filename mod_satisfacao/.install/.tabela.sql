CREATE TABLE assistencias_clientes_satisfacao (
  id_satisfacao int(11) NOT NULL,
  nome_satisfacao varchar(250) DEFAULT NULL,
  descricao text DEFAULT NULL,
   id_assistencia_cliente int(11) DEFAULT null,  id_utilizador int(11) DEFAULT null,  classificacao int(11) DEFAULT null,  id_cliente int(11) DEFAULT null, 
  id_criou int(11) DEFAULT NULL,
  created_at timestamp DEFAULT CURRENT_TIMESTAMP,
  id_editou int(11) DEFAULT NULL,
  updated_at datetime DEFAULT NULL,
  ativo int(11) DEFAULT '1'
);