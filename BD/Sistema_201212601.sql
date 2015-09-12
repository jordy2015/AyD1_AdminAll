
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


/**************************************Procedimiento almacenados***************************/
#funcion marca la entrada y salida del empleado y calcula sus horas
DELIMITER $
DROP FUNCTION IF EXISTS Marcar$
CREATE FUNCTION Marcar(id1 int) RETURNS varchar(50)
BEGIN
	DECLARE id integer;
	declare aux integer;
	DECLARE hf integer;
	DECLARE conta integer;
	DECLARE foto varchar(100);
	set id= (SELECT `empleado`.`empleado` FROM `pract1`.`empleado` where `empleado`.`empleado`=id1);
	set foto= (SELECT `empleado`.`foto` FROM `pract1`.`empleado` where `empleado`.`empleado`=id1);

	if(id is NULL) then
		return '1-ID empleado no existe';
	else
			SET id = (SELECT `horario`.`idhorario` FROM `pract1`.`horario` where `horario`.`empleado_empleado`=id1 and `horario`.`dia`=date(now())  order by `horario`.`idhorario` asc limit 1);
			IF id IS NULL then
				INSERT INTO `pract1`.`horario`
				(`empleado_empleado`,`h_entrada`,`dia`)
				VALUES (id1,time(now()),date(now()));
				return concat('0-entrando 1er periodo-',foto);
			else 
				SET hf = (SELECT `horario`.`h_salida` FROM `pract1`.`horario` where `horario`.`empleado_empleado`=id1 and `horario`.`dia`=date(now()) order by `horario`.`idhorario` asc limit 1);
				if hf is null then
					UPDATE `pract1`.`horario` SET `h_salida` = time(now()) WHERE `idhorario` = id;
					return concat('0-saliendo 1er periodo-',foto);
				else	
					SET aux = (SELECT `horario`.`idhorario` FROM `pract1`.`horario` where `horario`.`empleado_empleado`=id1 and `horario`.`dia`=date(now()) order by `horario`.`idhorario` desc limit 1);
					if aux=id then
						INSERT INTO `pract1`.`horario`
						(`empleado_empleado`,`h_entrada`,`dia`)
						VALUES (id1,time(now()),date(now()));
						return concat('0-entrando 2do periodo-',foto);
					else
						SET hf = (SELECT `horario`.`h_salida` FROM `pract1`.`horario` where `horario`.`idhorario`=aux);
						if hf is null then
							UPDATE `pract1`.`horario` SET `h_salida` = time(now()) WHERE `idhorario` = aux;
							return concat('0-saliendo 2do periodo-',foto);
						else
							return concat('1-El empleado ya completo los 2 periodos del dia');

						end if;
					end if;
				end if;
			end if;
	end if;
end$
DELIMITER ;

#procedimiento almacenado para descont
DELIMITER $
drop procedure if exists Descontar$
create PROCEDURE Descontar(id int, infor longtext, descu decimal(10,2))
begin
	declare var int;
	SET var = (SELECT `empleado`.`empleado` FROM `pract1`.`empleado`where `empleado`.`empleado`= id);
	if var is null then
		select 'El id del empleado no existe';
	else
		INSERT INTO `pract1`.`descuento`
		(`empleado_empleado`,`dia`,`informe`,`descontar`)
		VALUES(id,date(now()),infor,descu);
	end if;
end$
DELIMITER ;



