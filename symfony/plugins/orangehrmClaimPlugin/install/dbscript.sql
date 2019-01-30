CREATE TABLE ohrm_claim_event (
id INT AUTO_INCREMENT,
name TEXT,
description TEXT,
added_by INT, PRIMARY KEY(id))
ENGINE = INNODB;

CREATE TABLE ohrm_expense_type (
id INT AUTO_INCREMENT,
name TEXT,
description TEXT,
status VARCHAR(64),
PRIMARY KEY(id)) ENGINE = INNODB;