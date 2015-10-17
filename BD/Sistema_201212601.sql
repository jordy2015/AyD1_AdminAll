
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




/**************************************PROCEDIMIENTROS ALMACENADOS********************************/


#procedimento almacenado para efectuar pagos diarios
delimiter $
drop procedure if exists EfectuarPagos$
create procedure EfectuarPagos()
begin 
	insert into `pract1`.`pago_diario`(`empleado_empleado`,`Dia`,`total_horas`)
	select empleado_empleado as id, dia,sum(cast((hour(h_salida)+minute(h_salida)/60)-(hour(h_entrada)+minute(h_entrada)/60) as decimal(10,2))) as horas from horario
	where dia=date(now())
	group by empleado_empleado;
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


#procedimiento almacenado reporte mensual de un empleado
DELIMITER $
DROP PROCEDURE IF EXISTS ReporteMensual$	
CREATE PROCEDURE ReporteMensual(mes int, anio int, id2 int)
begin
	declare id integer;
	set id = (SELECT `empleado`.`empleado` FROM `pract1`.`empleado` where `empleado`.`empleado`=id2);
	if id is NULL then
		select 'ID no existe';
	else
		select B.nombre,A.dia, concat('Q ',A.pago_total) as total, A.total_horas as 'hr', sum(C.descontar) 'descueto' from pago_diario A, empleado B, descuento C
		where A.empleado_empleado=id2 and A.empleado_empleado=B.empleado and C.empleado_empleado = A.empleado_empleado
		and A.dia BETWEEN cast(concat(anio,'-',mes,'-1') as date) AND  LAST_DAY(concat(anio,'-',mes,'-1'))
		and C.dia=A.dia;
	end if;
end$
DELIMITER ;


/**************************************FUNCIONES ALMACENADAS********************************/
#procedimiento almacenado para nuevo usuarios
	DELIMITER $
DROP FUNCTION IF EXISTS NuevoEmpleado$	
CREATE FUNCTION NuevoEmpleado(id2 int,nombre1 varchar(50), dir varchar(50), foto1 varchar(100), tipo1 int) RETURNS varchar(60)
begin
	declare id integer;
	set id = (SELECT `empleado`.`empleado` FROM `pract1`.`empleado` where `empleado`.`empleado`=id2);
	if id is NULL then
		INSERT INTO `pract1`.`empleado`
		(`empleado`,`nombre`,`direccion`,`foto`,`fecha_inicio`,`Puesto_puesto`)
		VALUES (id2, nombre1, dir,foto1, date(NOW()),tipo1);
		return '1-Guardado con exito';
	else
		return '0-ID ya existe, ingrese otro';
	end if;
end$
DELIMITER ;


#funcion almacenado para eliminar usuario
DELIMITER $
DROP FUNCTION IF EXISTS EliminarEmpleado$
CREATE FUNCTION EliminarEmpleado(idemp int) RETURNS varchar(100)
BEGIN
	DECLARE id int;
	DECLARE foto varchar(100);
	SET id = (select empleado from empleado where empleado=idemp);
	if id is null then
		return '0-El empleado no existe';
	else
		DELETE FROM `pract1`.`empleado`
		WHERE empleado=idemp;
		return '1-Empleado eliminado';
	end if;
end$
DELIMITER ;


#marcar
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



#marcar con fin de muestra
DELIMITER $
DROP FUNCTION IF EXISTS Marcarbeta$
CREATE FUNCTION Marcarbeta(id1 int, hora time) RETURNS varchar(50)
BEGIN
	DECLARE id integer;
	declare aux integer;
	DECLARE hf integer;
	DECLARE conta integer;
	set id= (SELECT `empleado`.`empleado` FROM `pract1`.`empleado` where `empleado`.`empleado`=id1);
	if(id is NULL) then
		return 'ID empleado no existe';
	else
			SET id = (SELECT `horario`.`idhorario` FROM `pract1`.`horario` where `horario`.`empleado_empleado`=id1 and `horario`.`dia`=date(now())  order by `horario`.`idhorario` asc limit 1);
			IF id IS NULL then
				INSERT INTO `pract1`.`horario`
				(`empleado_empleado`,`h_entrada`,`dia`)
				VALUES (id1,hora,date(now()));
				return 'entrando 1er periodo';
			else 
				SET hf = (SELECT `horario`.`h_salida` FROM `pract1`.`horario` where `horario`.`empleado_empleado`=id1 and `horario`.`dia`=date(now()) order by `horario`.`idhorario` asc limit 1);
				if hf is null then
					UPDATE `pract1`.`horario` SET `h_salida` = hora WHERE `idhorario` = id;
					return 'saliendo 1er periodo';
				else	
					SET aux = (SELECT `horario`.`idhorario` FROM `pract1`.`horario` where `horario`.`empleado_empleado`=id1 and `horario`.`dia`=date(now()) order by `horario`.`idhorario` desc limit 1);
					if aux=id then
						INSERT INTO `pract1`.`horario`
						(`empleado_empleado`,`h_entrada`,`dia`)
						VALUES (id1,hora,date(now()));
						return 'entrando 2do periodo';
					else
						SET hf = (SELECT `horario`.`h_salida` FROM `pract1`.`horario` where `horario`.`idhorario`=aux);
						if hf is null then
							UPDATE `pract1`.`horario` SET `h_salida` = hora WHERE `idhorario` = aux;
							return 'saliendo 2do periodo';
						else
							return 'El empleado ya completo los 2 periodos del dia';
						end if;
					end if;
				end if;
			end if;
	end if;

end$
DELIMITER ;


/******************************************TRIGGERS********************************/
#trigger a la tabla pago_diario
DELIMITER $
DROP TRIGGER IF EXISTS PagarHoras$
CREATE TRIGGER PagarHoras BEFORE INSERT ON pago_diario
  FOR EACH ROW
  BEGIN
	declare var int;
	declare descu int;
	declare pago decimal(10,2);
	set var = (select Puesto_puesto from empleado where empleado=new.empleado_empleado);
	set descu = (select sum(descontar) from descuento where empleado_empleado=new.empleado_empleado and dia=date(now()));
	if (var=1) then
		set pago = new.total_horas*36;
	elseif var=2 then	
		set pago = new.total_horas*12;
	elseif var=3 then
		set pago = new.total_horas*14;
	elseif var=4 then	
		set pago = new.total_horas*12;
	end if;
	if(descu is null) then
		set new.pago_total=pago;
	else
		set new.pago_total=pago-descu;
	end if;
END$
DELIMITER ;

/********************************************EVENTOS****************************************/
#evento que se ejecuta cada dia "cuando cierran el restaurante"
SET GLOBAL event_scheduler = ON;
DELIMITER $
drop event if exists EventoPago $
CREATE EVENT EventoPago
ON SCHEDULE EVERY 1 DAY STARTS '2009-01-01 23:00:00'
DO call EfectuarPagos();
$
DELIMITER ;



/**************************************VISTAS********************************/
/*

create or replace view DiasLab as
select count(distinct day(dia)) as dia, empleado_empleado from horario where
dia BETWEEN concat(year(now()),'/',month(now()),'/1') AND date(now()) group by empleado_empleado

*/

create or replace view DiasLab as
select distinct day(dia) as dia, empleado_empleado from horario where
dia BETWEEN concat(year(now()),'/',month(now()),'/1') AND date(now()) order by empleado_empleado asc;

create or replace view reporte as
select C.nombre, C.empleado 'ID', count(B.dia) 'dias_laborados', sum(A.pago_total) as 'total_hasta_ahora',
sum(A.total_horas) 'total_horas'
from pago_diario A, DiasLab B, empleado C
where A.empleado_empleado=B.empleado_empleado and C.empleado=A.empleado_empleado
and A.dia=concat(year(now()),'/',month(now()),'/',B.dia)
group by B.empleado_empleado;


create or replace view QuienDescuento as
select nombre, empleado from empleado
where empleado
in(select distinct empleado_empleado
from descuento where
dia BETWEEN concat(year(now()),'/',month(now()),'/1') AND date(now())
);

create or replace view ReporteDiario as
select B.nombre, A.pago_total as total, A.total_horas from pago_diario A, empleado B
where A.empleado_empleado=B.empleado and A.dia=date(now());

