CREATE TABLE imap (
  id_imap int(11) NOT NULL,
  nome_imap varchar(250) DEFAULT NULL,
  descricao text DEFAULT NULL,
   nome_de varchar(250) DEFAULT null,  para_nome varchar(250) DEFAULT null,  de_email varchar(250) DEFAULT null,  email_para varchar(250) DEFAULT null,  message_id text DEFAULT null,  in_reply_to text DEFAULT null,  references_to text DEFAULT null,  uid varchar(250) DEFAULT null,  raw text DEFAULT null, 
  id_criou int(11) DEFAULT NULL,
  created_at timestamp DEFAULT CURRENT_TIMESTAMP,
  id_editou int(11) DEFAULT NULL,
  updated_at datetime DEFAULT NULL,
  ativo int(11) DEFAULT '1'
);