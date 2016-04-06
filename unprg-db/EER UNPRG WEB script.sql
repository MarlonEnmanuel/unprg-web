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
CREATE SCHEMA IF NOT EXISTS `unprg-web` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `unprg-web` ;

-- -----------------------------------------------------
-- Table `unprg-web`.`usuario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `unprg-web`.`usuario` (
  `idUsuario` INT NOT NULL AUTO_INCREMENT COMMENT '',
  `email` VARCHAR(200) NOT NULL COMMENT '',
  `password` VARCHAR(45) NOT NULL COMMENT '',
  `nombres` VARCHAR(45) NOT NULL COMMENT '',
  `apellidos` VARCHAR(45) NOT NULL COMMENT '',
  `oficina` VARCHAR(45) NOT NULL COMMENT '',
  `fchReg` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '',
  `permisos` TEXT NOT NULL COMMENT '',
  `estado` TINYINT(1) NOT NULL DEFAULT 1 COMMENT '',
  `reset` TINYINT(1) NOT NULL DEFAULT 1 COMMENT '',
  PRIMARY KEY (`idUsuario`)  COMMENT '',
  UNIQUE INDEX `email_UNIQUE` (`email` ASC)  COMMENT '')
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `unprg-web`.`documento`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `unprg-web`.`documento` (
  `idDocumento` INT NOT NULL AUTO_INCREMENT COMMENT '',
  `fchReg` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '',
  `nombre` VARCHAR(45) NOT NULL COMMENT '',
  `tipo` VARCHAR(45) NOT NULL COMMENT '',
  `ruta` TEXT NOT NULL COMMENT '',
  `version` INT NOT NULL DEFAULT 1 COMMENT '',
  `estado` TINYINT(1) NOT NULL DEFAULT 1 COMMENT '',
  `idUsuario` INT NOT NULL COMMENT '',
  PRIMARY KEY (`idDocumento`)  COMMENT '',
  INDEX `fk_documento_usuario_idx` (`idUsuario` ASC)  COMMENT '',
  CONSTRAINT `fk_documento_usuario`
    FOREIGN KEY (`idUsuario`)
    REFERENCES `unprg-web`.`usuario` (`idUsuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `unprg-web`.`galeria`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `unprg-web`.`galeria` (
  `idGaleria` INT NOT NULL AUTO_INCREMENT COMMENT '',
  `nombre` VARCHAR(45) NOT NULL COMMENT '',
  `estado` TINYINT(1) NOT NULL COMMENT '',
  PRIMARY KEY (`idGaleria`)  COMMENT '',
  UNIQUE INDEX `nombre_UNIQUE` (`nombre` ASC)  COMMENT '')
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `unprg-web`.`imagen`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `unprg-web`.`imagen` (
  `idImagen` INT NOT NULL AUTO_INCREMENT COMMENT '',
  `fchReg` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '',
  `nombre` VARCHAR(45) NOT NULL COMMENT '',
  `tipo` VARCHAR(45) NOT NULL COMMENT '',
  `ruta` TEXT NULL COMMENT '',
  `version` INT NOT NULL DEFAULT 1 COMMENT '',
  `idUsuario` INT NOT NULL COMMENT '',
  `idGaleria` INT NULL COMMENT '',
  PRIMARY KEY (`idImagen`)  COMMENT '',
  INDEX `fk_imagen_usuario1_idx` (`idUsuario` ASC)  COMMENT '',
  INDEX `fk_imagen_galeria1_idx` (`idGaleria` ASC)  COMMENT '',
  CONSTRAINT `fk_imagen_usuario1`
    FOREIGN KEY (`idUsuario`)
    REFERENCES `unprg-web`.`usuario` (`idUsuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_imagen_galeria1`
    FOREIGN KEY (`idGaleria`)
    REFERENCES `unprg-web`.`galeria` (`idGaleria`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `unprg-web`.`aviso`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `unprg-web`.`aviso` (
  `idAviso` INT NOT NULL AUTO_INCREMENT COMMENT '',
  `fchReg` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '',
  `titulo` VARCHAR(45) NOT NULL COMMENT '',
  `texto` TEXT NULL COMMENT '',
  `destacado` TINYINT(1) NOT NULL DEFAULT 0 COMMENT '',
  `emergente` TINYINT(1) NOT NULL DEFAULT 0 COMMENT '',
  `link` TEXT NULL COMMENT '',
  `estado` TINYINT(1) NOT NULL DEFAULT 1 COMMENT '',
  `idUsuario` INT NOT NULL COMMENT '',
  PRIMARY KEY (`idAviso`)  COMMENT '',
  INDEX `fk_aviso_usuario1_idx` (`idUsuario` ASC)  COMMENT '',
  UNIQUE INDEX `titulo_UNIQUE` (`titulo` ASC)  COMMENT '',
  CONSTRAINT `fk_aviso_usuario1`
    FOREIGN KEY (`idUsuario`)
    REFERENCES `unprg-web`.`usuario` (`idUsuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `unprg-web`.`agenda`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `unprg-web`.`agenda` (
  `idAgenda` INT NOT NULL COMMENT '',
  `fchInicio` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '',
  `titulo` VARCHAR(45) NOT NULL COMMENT '',
  `texto` TEXT NOT NULL COMMENT '',
  `lugar` VARCHAR(45) NOT NULL COMMENT '',
  `mapa` TEXT NULL COMMENT '',
  `organizador` VARCHAR(45) NOT NULL COMMENT '',
  `estado` TINYINT(1) NOT NULL DEFAULT 1 COMMENT '',
  `idUsuario` INT NOT NULL COMMENT '',
  PRIMARY KEY (`idAgenda`)  COMMENT '',
  INDEX `fk_agenda_usuario1_idx` (`idUsuario` ASC)  COMMENT '',
  CONSTRAINT `fk_agenda_usuario1`
    FOREIGN KEY (`idUsuario`)
    REFERENCES `unprg-web`.`usuario` (`idUsuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `unprg-web`.`noticia`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `unprg-web`.`noticia` (
  `idNoticia` INT NOT NULL AUTO_INCREMENT COMMENT '',
  `fchReg` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '',
  `titulo` VARCHAR(45) NOT NULL COMMENT '',
  `json` TEXT NOT NULL COMMENT '',
  `extras` TEXT NOT NULL COMMENT '',
  `estado` TINYINT(1) NOT NULL DEFAULT 1 COMMENT '',
  `idUsuario` INT NOT NULL COMMENT '',
  `idGaleria` INT NULL COMMENT '',
  PRIMARY KEY (`idNoticia`)  COMMENT '',
  UNIQUE INDEX `titulo_UNIQUE` (`titulo` ASC)  COMMENT '',
  INDEX `fk_noticia_usuario1_idx` (`idUsuario` ASC)  COMMENT '',
  INDEX `fk_noticia_galeria1_idx` (`idGaleria` ASC)  COMMENT '',
  CONSTRAINT `fk_noticia_usuario1`
    FOREIGN KEY (`idUsuario`)
    REFERENCES `unprg-web`.`usuario` (`idUsuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_noticia_galeria1`
    FOREIGN KEY (`idGaleria`)
    REFERENCES `unprg-web`.`galeria` (`idGaleria`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `unprg-web`.`enlace`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `unprg-web`.`enlace` (
  `idEnlace` INT NOT NULL AUTO_INCREMENT COMMENT '',
  `nombre` VARCHAR(45) NOT NULL COMMENT '',
  `descripcion` VARCHAR(45) NOT NULL COMMENT '',
  `link` VARCHAR(45) NOT NULL COMMENT '',
  `estado` TINYINT(1) NOT NULL DEFAULT 1 COMMENT '',
  `idUsuario` INT NOT NULL COMMENT '',
  PRIMARY KEY (`idEnlace`)  COMMENT '',
  UNIQUE INDEX `nombre_UNIQUE` (`nombre` ASC)  COMMENT '',
  INDEX `fk_enlace_usuario1_idx` (`idUsuario` ASC)  COMMENT '',
  CONSTRAINT `fk_enlace_usuario1`
    FOREIGN KEY (`idUsuario`)
    REFERENCES `unprg-web`.`usuario` (`idUsuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `unprg-web`.`portada`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `unprg-web`.`portada` (
  `idPortada` INT NOT NULL AUTO_INCREMENT COMMENT '',
  `titulo` VARCHAR(45) NOT NULL COMMENT '',
  `descripcion` TEXT NOT NULL COMMENT '',
  `estado` TINYINT(1) NOT NULL DEFAULT 1 COMMENT '',
  `idUsuario` INT NOT NULL COMMENT '',
  `idImagen` INT NOT NULL COMMENT '',
  PRIMARY KEY (`idPortada`)  COMMENT '',
  UNIQUE INDEX `titulo_UNIQUE` (`titulo` ASC)  COMMENT '',
  INDEX `fk_portada_usuario1_idx` (`idUsuario` ASC)  COMMENT '',
  INDEX `fk_portada_imagen1_idx` (`idImagen` ASC)  COMMENT '',
  CONSTRAINT `fk_portada_usuario1`
    FOREIGN KEY (`idUsuario`)
    REFERENCES `unprg-web`.`usuario` (`idUsuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_portada_imagen1`
    FOREIGN KEY (`idImagen`)
    REFERENCES `unprg-web`.`imagen` (`idImagen`)
    ON DELETE NO ACTION
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
INSERT INTO `unprg-web`.`usuario` (`idUsuario`, `email`, `password`, `nombres`, `apellidos`, `oficina`, `fchReg`, `permisos`, `estado`, `reset`) VALUES (DEFAULT, 'admin@admin.com', '9dbf7c1488382487931d10235fc84a74bff5d2f4', 'Administrador', 'del Sistema', 'Oficina de Desarrollo', DEFAULT, 'admin,imagen,documento,aviso,agenda,noticia,enlace,portada,pagina', 1, 1);

COMMIT;

