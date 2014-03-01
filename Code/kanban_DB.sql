SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE SCHEMA IF NOT EXISTS `kanban_DB` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `kanban_DB` ;

-- -----------------------------------------------------
-- Table `kanban_DB`.`user`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `kanban_DB`.`user` (
  `iduser` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `password` VARCHAR(45) NOT NULL,
  `mail` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`iduser`),
  UNIQUE INDEX `iduser_UNIQUE` (`iduser` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `kanban_DB`.`board`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `kanban_DB`.`board` (
  `idboard` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NULL,
  PRIMARY KEY (`idboard`),
  UNIQUE INDEX `idboard_UNIQUE` (`idboard` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `kanban_DB`.`state`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `kanban_DB`.`state` (
  `idstate` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `pos` INT NULL,
  `idboard` INT NOT NULL,
  PRIMARY KEY (`idstate`, `idboard`),
  UNIQUE INDEX `idstate_UNIQUE` (`idstate` ASC),
  INDEX `fk_state_board1_idx` (`idboard` ASC),
  CONSTRAINT `fk_state_board1`
    FOREIGN KEY (`idboard`)
    REFERENCES `kanban_DB`.`board` (`idboard`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `kanban_DB`.`task`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `kanban_DB`.`task` (
  `idtask` INT NOT NULL AUTO_INCREMENT,
  `pos` INT NULL,
  `name` VARCHAR(45) NOT NULL,
  `description` VARCHAR(45) NULL,
  `priority` INT NOT NULL,
  `owner` INT NOT NULL,
  `start` DATE NULL,
  `end` DATE NULL,
  `idstate` INT NOT NULL,
  PRIMARY KEY (`idtask`, `idstate`),
  INDEX `fk_task_state1_idx` (`idstate` ASC),
  UNIQUE INDEX `idtask_UNIQUE` (`idtask` ASC),
  CONSTRAINT `fk_task_state1`
    FOREIGN KEY (`idstate`)
    REFERENCES `kanban_DB`.`state` (`idstate`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `kanban_DB`.`userBoard`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `kanban_DB`.`userBoard` (
  `iduser` INT NOT NULL,
  `idboard` INT NOT NULL,
  PRIMARY KEY (`iduser`, `idboard`),
  INDEX `fk_user_has_board_board1_idx` (`idboard` ASC),
  INDEX `fk_user_has_board_user1_idx` (`iduser` ASC),
  CONSTRAINT `fk_user_has_board_user1`
    FOREIGN KEY (`iduser`)
    REFERENCES `kanban_DB`.`user` (`iduser`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_user_has_board_board1`
    FOREIGN KEY (`idboard`)
    REFERENCES `kanban_DB`.`board` (`idboard`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
