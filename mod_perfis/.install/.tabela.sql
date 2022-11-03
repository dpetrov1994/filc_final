CREATE TABLE mod_perfis (
  id_perfil int(11) NOT NULL,
  nome_perfil varchar(250) DEFAULT NULL,
  descricao text DEFAULT NULL,
   n1 text DEFAULT null,  n2 text DEFAULT null,  n3 text DEFAULT null,  n4 text DEFAULT null,  n5 text DEFAULT null, 
  id_criou int(11) DEFAULT NULL,
  created_at timestamp DEFAULT CURRENT_TIMESTAMP,
  id_editou int(11) DEFAULT NULL,
  updated_at datetime DEFAULT NULL,
  ativo int(11) DEFAULT '1'
);