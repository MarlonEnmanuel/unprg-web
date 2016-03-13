-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema unprg-web
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema unprg-web
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `unprg-web` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ;
USE `unprg-web` ;

-- -----------------------------------------------------
-- Table `unprg-web`.`usuario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `unprg-web`.`usuario` (
  `idUsuario` INT NOT NULL AUTO_INCREMENT COMMENT '',
  `email` VARCHAR(45) NOT NULL COMMENT 'correo electronico del usuario',
  `password` VARCHAR(45) NOT NULL COMMENT 'contraseña del usuario codificada en SHA-1',
  `nombres` VARCHAR(45) NOT NULL COMMENT 'nombres del usuario',
  `apellidos` VARCHAR(45) NOT NULL COMMENT 'apellidos del usuario',
  `oficina` VARCHAR(45) NOT NULL COMMENT 'departamento u oficina de la unprg al que pertenece el usuario',
  `fchReg` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'fecha de registro del usuario',
  `permisos` TEXT NOT NULL COMMENT 'codigos de permisos asignados al usuario, separado por comas',
  `estado` TINYINT(1) NOT NULL DEFAULT 1 COMMENT 'indica si el usuario está activo y inactivo',
  `reset` TINYINT(1) NOT NULL DEFAULT 1 COMMENT 'indica si la contraseña ha sido resetada',
  PRIMARY KEY (`idUsuario`),
  UNIQUE INDEX `login_UNIQUE` (`email` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `unprg-web`.`archivo`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `unprg-web`.`archivo` (
  `idArchivo` INT NOT NULL AUTO_INCREMENT COMMENT '',
  `nombre` TEXT NOT NULL COMMENT 'nombre del archivo, si el type es igual a link, entonces este campo contiene el enlace a la pagina',
  `type` VARCHAR(45) NOT NULL COMMENT 'tipo del archivo, pdf, imagen, o enlace(link)',
  `rutaArch` TEXT NOT NULL COMMENT 'ruta del archivo a mostrar',
  `fchReg` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'fecha de registro del archivo',
  PRIMARY KEY (`idArchivo`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `unprg-web`.`aviso`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `unprg-web`.`aviso` (
  `idAviso` INT NOT NULL AUTO_INCREMENT COMMENT '',
  `fchReg` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'fecha de registro del aviso',
  `texto` TEXT NOT NULL COMMENT 'descripcion del aviso',
  `destacado` TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'si es true, el aviso parpadea para llamar la atencion',
  `emergente` TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'indica si el aviso se muestro al cargar la pagina',
  `visible` TINYINT(1) NOT NULL DEFAULT 1 COMMENT 'indica si el aviso es visible en la pagina principal',
  `estado` TINYINT(1) NOT NULL DEFAULT 1 COMMENT 'indica si el aviso está activo o inactivo',
  `bloqueado` TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'indica si el aviso está bloqueado por el administrador, al estar bloqueado el usuario pierde todo control sobre el aviso',
  `idArchivo` INT NOT NULL COMMENT 'archivo de este aviso',
  `idUsuario` INT NOT NULL COMMENT 'usuario creador del aviso',
  PRIMARY KEY (`idAviso`) ,
  INDEX `fk_aviso_archivo_idx` (`idArchivo` ASC) ,
  INDEX `fk_aviso_usuario1_idx` (`idUsuario` ASC) ,
  CONSTRAINT `fk_aviso_archivo`
    FOREIGN KEY (`idArchivo`)
    REFERENCES `unprg-web`.`archivo` (`idArchivo`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_aviso_usuario1`
    FOREIGN KEY (`idUsuario`)
    REFERENCES `unprg-web`.`usuario` (`idUsuario`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `unprg-web`.`usuario`
-- -----------------------------------------------------
START TRANSACTION;
USE `unprg-web`;
INSERT INTO `unprg-web`.`usuario` (`idUsuario`, `email`, `password`, `nombres`, `apellidos`, `oficina`, `fchReg`, `permisos`, `estado`, `reset`) VALUES (DEFAULT, 'admin@admin.com', '9dbf7c1488382487931d10235fc84a74bff5d2f4', 'admin', 'admin', 'Red Telemática', DEFAULT, 'admin,aviso,noticia,evento', 1, 1);

COMMIT;

