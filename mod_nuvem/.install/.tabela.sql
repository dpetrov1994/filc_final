CREATE TABLE pastas
(
    id_pasta INT PRIMARY KEY AUTO_INCREMENT,
    nome_pasta VARCHAR(250),
    nome_real VARCHAR(250),
    dir TEXT,
    id_parent INT,
    tipo VARCHAR(250),
    id_item INT,
    id_criou INT,
    created_at TIMESTAMP DEFAULT current_timestamp,
    id_editou INT,
    updated_at DATETIME,
    ativo INT DEFAULT 1
);



