CREATE TABLE orcamentos (
  id_orcamento int(11) NOT NULL,
  ref varchar(250) DEFAULT NULL,
  descricao text DEFAULT NULL,
   ref varchar(250) DEFAULT null,  id_cliente int(11) DEFAULT null, 
  id_criou int(11) DEFAULT NULL,
  created_at timestamp DEFAULT CURRENT_TIMESTAMP,
  id_editou int(11) DEFAULT NULL,
  updated_at datetime DEFAULT NULL,
  ativo int(11) DEFAULT '1'
);