CREATE TABLE newsletters (
  id_newsletter int(11) NOT NULL,
  nome_newsletter varchar(250) DEFAULT NULL,
  descricao text DEFAULT NULL,
   id_cliente int(11) DEFAULT null,  destinatario varchar(250) DEFAULT null, 
  id_criou int(11) DEFAULT NULL,
  created_at timestamp DEFAULT CURRENT_TIMESTAMP,
  id_editou int(11) DEFAULT NULL,
  updated_at datetime DEFAULT NULL,
  ativo int(11) DEFAULT '1'
);