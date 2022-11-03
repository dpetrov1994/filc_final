CREATE TABLE assistencias_clientes (
  id_assistencia_cliente int(11) NOT NULL,
  nome_assistencia_cliente varchar(250) DEFAULT NULL,
  descricao text DEFAULT NULL,
   id_cliente int(11) DEFAULT null,  id_assistencia int(11) DEFAULT null,  assinado int(11) DEFAULT 0,  emails text DEFAULT null,  email_enviado int(11) DEFAULT 0,  data_assinado datetime DEFAULT null, 
  id_criou int(11) DEFAULT NULL,
  created_at timestamp DEFAULT CURRENT_TIMESTAMP,
  id_editou int(11) DEFAULT NULL,
  updated_at datetime DEFAULT NULL,
  ativo int(11) DEFAULT '1'
);