CREATE TABLE relatorios_comerciais (
  id_ralatorio int(11) NOT NULL,
  nome_ralatorio varchar(250) DEFAULT NULL,
  descricao text DEFAULT NULL,
   id_cliente int(11) DEFAULT null,  id_utilizador int(11) DEFAULT null,  data_relatorio datetime DEFAULT null,  id_categoria int(11) DEFAULT null, 
  id_criou int(11) DEFAULT NULL,
  created_at timestamp DEFAULT CURRENT_TIMESTAMP,
  id_editou int(11) DEFAULT NULL,
  updated_at datetime DEFAULT NULL,
  ativo int(11) DEFAULT '1'
);