CREATE TABLE viaturas (
  id_viaturas int(11) NOT NULL,
  nome_viatura varchar(250) DEFAULT NULL,
  descricao text DEFAULT NULL,
   matricula varchar(250) DEFAULT null,  data_seguro datetime DEFAULT null,  data_inspecao datetime DEFAULT null,  kms_revisao int(11) DEFAULT null,  kms_pneus int(11) DEFAULT null,  data_lavagem datetime DEFAULT null,  kms_inicio int(11) DEFAULT null,  preco_km varchar(250) DEFAULT null, 
  id_criou int(11) DEFAULT NULL,
  created_at timestamp DEFAULT CURRENT_TIMESTAMP,
  id_editou int(11) DEFAULT NULL,
  updated_at datetime DEFAULT NULL,
  ativo int(11) DEFAULT '1'
);