-- Create all tables
CREATE TABLE isaType
(
    id INT UNSIGNED AUTO_INCREMENT NOT NULL DEFAULT NULL,
    name VARCHAR(255) NOT NULL,
    UNIQUE INDEX(name),
    PRIMARY KEY(id)
) ENGINE=InnoDB;

CREATE TABLE depositLimit
(
    id INT UNSIGNED AUTO_INCREMENT NOT NULL DEFAULT NULL,
    tax_year_end SMALLINT UNSIGNED NOT NULL,
    annual_limit DECIMAL(8,2) UNSIGNED NOT NULL,
    UNIQUE INDEX(tax_year_end),
    PRIMARY KEY(id)
) ENGINE=InnoDB;

CREATE TABLE product
(
    id INT UNSIGNED AUTO_INCREMENT NOT NULL DEFAULT NULL,
    name VARCHAR(255) NOT NULL,
    isa_type_id INT UNSIGNED NOT NULL,
    UNIQUE INDEX(name),
    PRIMARY KEY(id),
    FOREIGN KEY(isa_type_id) REFERENCES isaType(id) ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB;

CREATE TABLE fund
(
    id INT UNSIGNED AUTO_INCREMENT NOT NULL DEFAULT NULL,
    name VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    UNIQUE INDEX(name),
    PRIMARY KEY(id)
) ENGINE=InnoDB;

CREATE TABLE customer
(
    id INT UNSIGNED AUTO_INCREMENT NOT NULL DEFAULT NULL,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    UNIQUE INDEX(username),
    PRIMARY KEY(id)
) ENGINE=InnoDB;

CREATE TABLE account
(
    id INT UNSIGNED AUTO_INCREMENT NOT NULL DEFAULT NULL,
    customer_id INT UNSIGNED NOT NULL,
    product_id INT UNSIGNED NOT NULL,
    active BOOLEAN NOT NULL,
    PRIMARY KEY(id),
    FOREIGN KEY(customer_id) REFERENCES customer(id) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY(product_id) REFERENCES product(id) ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE investment
(
    id INT UNSIGNED AUTO_INCREMENT NOT NULL DEFAULT NULL,
    account_id INT UNSIGNED NOT NULL,
    fund_id INT UNSIGNED NOT NULL,
    amount DECIMAL(8,2) UNSIGNED NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY(id),
    FOREIGN KEY(account_id) REFERENCES account(id) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY(fund_id) REFERENCES fund(id) ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB;

-- Populate default application data
INSERT INTO isaType(id, name)
VALUES(1, 'Stocks and shares'), (2, 'Cash'), (3, 'Lifetime'), (4, 'Innovative Finance'), (5, 'Junior');

INSERT INTO depositLimit(id, tax_year_end, annual_limit)
VALUES(1, 2024, 20000);

INSERT INTO product(id, name, isa_type_id)
VALUES(1, 'Cushon ISA', 1), (2, 'Cushon Lifetime ISA', 3);

INSERT INTO fund(id, name, description)
VALUES
    (1, 'Cushon Equities Fund', 'An equities fund for the Cushon recruitment scenario'),
    (2, 'Example fund', 'An example fund for the Cushon recruitment scenario');


-- Customer passwords are hashed using PHP's password_hash() function.
-- The password is 'CushonTest2023!'
INSERT INTO customer(id, username, password)
VALUES(1, 'thomas.revell', '$2y$10$hgrGMZizE72OCSSg9nPVZuBFcl.grn2/61AsPIKn6RUiLMVciEp82');

INSERT INTO account(id, customer_id, product_id, active)
VALUES(1, 1, 1, 1);
