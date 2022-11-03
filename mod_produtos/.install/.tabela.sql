CREATE TABLE produtos (
  id_produto int(11) NOT NULL,
  nome_produto varchar(250) DEFAULT NULL,
  descricao text DEFAULT NULL,
   valor_liquido varchar(250) DEFAULT null,  percentagem_iva int(11) DEFAULT null, 
  id_criou int(11) DEFAULT NULL,
  created_at timestamp DEFAULT CURRENT_TIMESTAMP,
  id_editou int(11) DEFAULT NULL,
  updated_at datetime DEFAULT NULL,
  ativo int(11) DEFAULT '1'
);