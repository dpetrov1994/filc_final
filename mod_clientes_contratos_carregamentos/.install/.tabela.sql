CREATE TABLE clientes_contratos_carregamentos (
  id_carregamento int(11) NOT NULL,
  nome_carregamento varchar(250) DEFAULT NULL,
  descricao text DEFAULT NULL,
   id_cliente int(11) DEFAULT null,  id_contrato int(11) DEFAULT null,  segundos int(11) DEFAULT null,  data_expira datetime DEFAULT null,  expira int(11) DEFAULT 0,  valor varchar(250) DEFAULT null,
  id_criou int(11) DEFAULT NULL,
  created_at timestamp DEFAULT CURRENT_TIMESTAMP,
  id_editou int(11) DEFAULT NULL,
  updated_at datetime DEFAULT NULL,
  ativo int(11) DEFAULT '1'
);