CREATE TABLE `RD1_db`.`weather` (
    `wId` INT NOT NULL AUTO_INCREMENT,
    `geocode` INT NOT NULL,
    `startTime` DATE NOT NULL,
    `endTime` DATE NOT NULL,
    `PoP12h` INT NULL,
    `perTemp` INT NOT NULL,
    `perWet` INT NOT NULL,
    `minTemp` INT NOT NULL,
    `maxTemp` INT NOT NULL,
    `minATemp` INT NOT NULL,
    `maxATemp` INT NOT NULL,
    `minCI` INT NOT NULL,
    `maxCI` INT NOT NULL,
    `UVI` INT NOT NULL,
    `td` INT NOT NULL,
    `ws` INT NOT NULL,
    `wd` VARCHAR(4) NOT NULL,
    `wx` VARCHAR(12) NOT NULL,
    `wDescript` VARCHAR(50) NOT NULL,
    PRIMARY KEY (`wId`)
) ENGINE = InnoDB;

CREATE TABLE `RD1_db`.`cityCode` (
    `geoCode` INT NOT NULL,
    `cityName` VARCHAR(5) NOT NULL,
    PRIMARY KEY (`geoCode`)
) ENGINE = InnoDB;