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
-- Table `kanban_DB`.`state`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `kanban_DB`.`state` (
  `idstate` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `pos` INT NULL,
  PRIMARY KEY (`idstate`),
  UNIQUE INDEX `idstate_UNIQUE` (`idstate` ASC))
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
-- Table `kanban_DB`.`user_has_task`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `kanban_DB`.`user_has_task` (
  `iduser` INT NOT NULL,
  `idtask` INT NOT NULL,
  PRIMARY KEY (`iduser`, `idtask`),
  INDEX `fk_user_has_task_task1_idx` (`idtask` ASC),
  INDEX `fk_user_has_task_user_idx` (`iduser` ASC),
  CONSTRAINT `fk_user_has_task_user`
    FOREIGN KEY (`iduser`)
    REFERENCES `kanban_DB`.`user` (`iduser`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_user_has_task_task1`
    FOREIGN KEY (`idtask`)
    REFERENCES `kanban_DB`.`task` (`idtask`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `kanban_DB`.`state`
-- -----------------------------------------------------
START TRANSACTION;
USE `kanban_DB`;
INSERT INTO `kanban_DB`.`state` (`idstate`, `name`, `pos`) VALUES (NULL, 'TO DO', 1);
INSERT INTO `kanban_DB`.`state` (`idstate`, `name`, `pos`) VALUES (NULL, 'DOING', 2);
INSERT INTO `kanban_DB`.`state` (`idstate`, `name`, `pos`) VALUES (NULL, 'DONE', 3);

COMMIT;

