CREATE DATABASE php_framework;

USE php_framework;

CREATE TABLE IF NOT EXISTS product (
    entity_id INT AUTO_INCREMENT primary key,
    name VARCHAR(255),
    sku VARCHAR(100),
    quantity INT
);

INSERT INTO product
(name, sku, quantity)
VALUES
    ('Iphone 14XS Max', 'iphone-14xs-max', 50),
    ('Bphone', 'b-phone', 10),
    ('Xiaomi Mi Mix3 5G', 'mi-mix3-5g', 25);

