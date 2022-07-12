CREATE TABLE `payme`.`sales` (
     id int NOT NULL AUTO_INCREMENT,
     `time` DATE NOT NULL ,
     `sale_number` INT NOT NULL ,
     `description` TEXT NOT NULL ,
     `sale_price` FLOAT NOT NULL ,
     `currency` TEXT NOT NULL ,
     `url` TEXT NOT NULL,
     PRIMARY KEY (id)
);
