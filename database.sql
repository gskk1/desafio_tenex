CREATE DATABASE carne_db;

CREATE TABLE carne (
 id INT NOT NULL AUTO_INCREMENT,
 valor_total FLOAT DEFAULT 0,
 qtd_parcelas INT NOT NULL DEFAULT 0,
 data_primeiro_vencimento CHAR(10) NOT NULL,
 periodicidade VARCHAR(10) NOT NULL,
 valor_entrada FLOAT DEFAULT 0,
 PRIMARY KEY (id)
);
