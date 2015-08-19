
/**************************************INICIO DEL ESQUEMA********************************/
SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE SCHEMA IF NOT EXISTS `pract1` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `pract1` ;

-- -----------------------------------------------------
-- Table `pract1`.`Puesto`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `pract1`.`Puesto` (
  `puesto` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(50) NOT NULL,
  `sueldo_base` DECIMAL(10,2) NOT NULL,
  `descripcion_puesto` TINYTEXT NULL,
  PRIMARY KEY (`puesto`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `pract1`.`empleado`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `pract1`.`empleado` (
  `empleado` INT NOT NULL ,
  `nombre` VARCHAR(50) NOT NULL,
  `direccion` VARCHAR(50) NULL,
  `foto` VARCHAR(100) NULL,
  `fecha_inicio` DATE NULL,
  `Puesto_puesto` INT NOT NULL,
  PRIMARY KEY (`empleado`),
  INDEX `fk_empleado_Puesto1_idx` (`Puesto_puesto` ASC),
  CONSTRAINT `fk_empleado_Puesto1`
    FOREIGN KEY (`Puesto_puesto`)
    REFERENCES `pract1`.`Puesto` (`puesto`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `pract1`.`horario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `pract1`.`horario` (
  `idhorario` INT NOT NULL AUTO_INCREMENT,
  `empleado_empleado` INT NOT NULL,
  `h_entrada` TIME NULL,
  `h_salida` TIME NULL,
  `dia` DATE NULL,
  INDEX `fk_horario_empleado1_idx` (`empleado_empleado` ASC),
  PRIMARY KEY (`idhorario`),
  CONSTRAINT `fk_horario_empleado1`
    FOREIGN KEY (`empleado_empleado`)
    REFERENCES `pract1`.`empleado` (`empleado`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `pract1`.`pago_diario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `pract1`.`pago_diario` (
  `idpago` INT NOT NULL AUTO_INCREMENT,
  `empleado_empleado` INT NOT NULL,
  `Dia` DATE NOT NULL,
  `pago_total` DECIMAL(10,2) NULL,
  `total_horas` DECIMAL(10,2) NULL,
  INDEX `fk_pago_diario_empleado1_idx` (`empleado_empleado` ASC),
  PRIMARY KEY (`idpago`),
  CONSTRAINT `fk_pago_diario_empleado1`
    FOREIGN KEY (`empleado_empleado`)
    REFERENCES `pract1`.`empleado` (`empleado`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `pract1`.`descuento`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `pract1`.`descuento` (
  `descuento` INT NOT NULL AUTO_INCREMENT,
  `empleado_empleado` INT NOT NULL,
  `dia` DATE NOT NULL,
  `informe` LONGTEXT NULL,
  `descontar` DECIMAL(10,2) NULL,
  PRIMARY KEY (`descuento`),
  INDEX `fk_queja_empleado1_idx` (`empleado_empleado` ASC),
  CONSTRAINT `fk_queja_empleado1`
    FOREIGN KEY (`empleado_empleado`)
    REFERENCES `pract1`.`empleado` (`empleado`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
/**************************************FIN DEL ESQUEMA********************************/



