-- Create all tables
CREATE TABLE isa_types
(
    id INT UNSIGNED AUTO_INCREMENT NOT NULL DEFAULT NULL,
    name VARCHAR(255) NOT NULL,
    UNIQUE INDEX(name)
) ENGINE=InnoDB;

CREATE TABLE deposit_limits
(
    id INT UNSIGNED AUTO_INCREMENT NOT NULL DEFAULT NULL,
    isa_type_id INT UNSIGNED NOT NULL,
    tax_year_end SMALLINT UNSIGNED NOT NULL,
    annual_limit DECIMAL(8,2) UNSIGNED NOT NULL,
    UNIQUE INDEX(isa_type_id, tax_year_end)
) ENGINE=InnoDB;

CREATE TABLE products
(
    id INT UNSIGNED AUTO_INCREMENT NOT NULL DEFAULT NULL,
    name VARCHAR(255),
    isa_type_id INT UNSIGNED NOT NULL,
    flexible BOOLEAN NOT NULL
) ENGINE=InnoDB;

-- Populate default application data
INSERT INTO isa_types(id, name)
VALUES(1, 'Stocks and shares'), (2, 'Cash'), (3, 'Lifetime'), (4, 'Innovative Finance'), (5, 'Junior');

INSERT INTO deposit_limits(id, isa_type_id, tax_year_end, annual_limit)
VALUES(1, 1, 2024, 20000), (2, 2, 2024, 20000), (3, 3, 2024, 20000), (4, 4, 2024, 20000), (5, 5, 2024, 9000);

INSERT INTO products(id, name, isa_type_id, flexible)
VALUES(1, 'Cushon ISA', 1, 0), (2, 'Cushon Flexible ISA', 1, 1);
