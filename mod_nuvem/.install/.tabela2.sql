CREATE TABLE pastas_ficheiros
(
    id_ficheiro INT PRIMARY KEY AUTO_INCREMENT,
    id_pasta INT,
    nome_ficheiro VARCHAR(250),
    nome_real VARCHAR(250),
    dir TEXT,
    id_criou INT,
    created_at TIMESTAMP DEFAULT current_timestamp,
    id_editou INT,
    updated_at DATETIME,
    ativo INT DEFAULT 1
);