CREATE TABLE assistencias (
  id_assistencia int(11) NOT NULL,
  nome_assistencia varchar(250) DEFAULT NULL,
  descricao text DEFAULT NULL,
   id_utilizador int(11) DEFAULT null,  data_inicio datetime DEFAULT null,  data_fim datetime DEFAULT null,  segundos int(11) DEFAULT null, 
  id_criou int(11) DEFAULT NULL,
  created_at timestamp DEFAULT CURRENT_TIMESTAMP,
  id_editou int(11) DEFAULT NULL,
  updated_at datetime DEFAULT NULL,
  ativo int(11) DEFAULT '1'
);