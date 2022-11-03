CREATE TABLE _conf_imap (
  id_conf int(11) NOT NULL,
  nome_conf varchar(250) DEFAULT NULL,
  descricao text DEFAULT NULL,
   servidor varchar(250) DEFAULT null,  utilizador varchar(250) DEFAULT null,  password varchar(250) DEFAULT null,  encryption varchar(250) DEFAULT null,  folder_prefix varchar(250) DEFAULT null,  inbox_folder_name varchar(250) DEFAULT null,  sent_folder_name varchar(250) DEFAULT null, 
  id_criou int(11) DEFAULT NULL,
  created_at timestamp DEFAULT CURRENT_TIMESTAMP,
  id_editou int(11) DEFAULT NULL,
  updated_at datetime DEFAULT NULL,
  ativo int(11) DEFAULT '1'
);