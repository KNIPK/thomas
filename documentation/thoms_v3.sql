SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE SCHEMA IF NOT EXISTS `mydb` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci ;
USE `mydb` ;

-- -----------------------------------------------------
-- Table `mydb`.`languanges`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mydb`.`languanges` (
  `lang_id` INT NOT NULL ,
  `languange_name` VARCHAR(20) NOT NULL ,
  PRIMARY KEY (`lang_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`users`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mydb`.`users` (
  `user_id` INT NOT NULL AUTO_INCREMENT ,
  `user_login` VARCHAR(20) NOT NULL ,
  `user_password` CHAR(32) NOT NULL ,
  `user_name` VARCHAR(20) NULL ,
  `user_surname` VARCHAR(45) NULL ,
  `user_email` VARCHAR(100) NULL ,
  `user_is_temp` TINYINT(1) NOT NULL ,
  `user_languange_id` INT NULL ,
  PRIMARY KEY (`user_id`) ,
  UNIQUE INDEX `user_login_UNIQUE` (`user_login` ASC) ,
  INDEX `user_languange_id_idx` (`user_languange_id` ASC) ,
  CONSTRAINT `user_languange_id`
    FOREIGN KEY (`user_languange_id` )
    REFERENCES `mydb`.`languanges` (`lang_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`courses`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mydb`.`courses` (
  `course_id` INT NOT NULL AUTO_INCREMENT ,
  `course_name` VARCHAR(150) NOT NULL ,
  `course_start_date` DATE NULL ,
  `course_end_date` DATE NULL ,
  `course_description` TEXT NULL ,
  `user_id_course` INT NOT NULL COMMENT 'author' ,
  PRIMARY KEY (`course_id`) ,
  INDEX `user_id_idx` (`user_id_course` ASC) ,
  CONSTRAINT `user_id_course`
    FOREIGN KEY (`user_id_course` )
    REFERENCES `mydb`.`users` (`user_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`workshops`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mydb`.`workshops` (
  `workshop_id` INT NOT NULL AUTO_INCREMENT ,
  `workshop_name` VARCHAR(45) NOT NULL ,
  `workshop_start_date` DATETIME NULL ,
  `workshop_end_date` DATETIME NULL ,
  `workshop_description` TEXT NULL ,
  `course_id_works` INT NULL ,
  `user_id_works` INT NOT NULL COMMENT 'author' ,
  PRIMARY KEY (`workshop_id`) ,
  INDEX `user_id_idx` (`user_id_works` ASC) ,
  INDEX `course_id_idx` (`course_id_works` ASC) ,
  CONSTRAINT `user_id_works`
    FOREIGN KEY (`user_id_works` )
    REFERENCES `mydb`.`users` (`user_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `course_id_works`
    FOREIGN KEY (`course_id_works` )
    REFERENCES `mydb`.`courses` (`course_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`steps`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mydb`.`steps` (
  `step_id` INT NOT NULL AUTO_INCREMENT ,
  `step_name` VARCHAR(45) NULL ,
  `step_description` TEXT NULL ,
  `workshop_id_step` INT NOT NULL ,
  `step_order` INT NULL ,
  PRIMARY KEY (`step_id`) ,
  INDEX `workshop_id_idx` (`workshop_id_step` ASC) ,
  CONSTRAINT `workshop_id_step`
    FOREIGN KEY (`workshop_id_step` )
    REFERENCES `mydb`.`workshops` (`workshop_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`questions`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mydb`.`questions` (
  `question_id` INT NOT NULL AUTO_INCREMENT ,
  `question_type` INT NOT NULL ,
  `question_content` VARCHAR(45) NOT NULL ,
  `step_id_quest` INT NULL ,
  `question_order` INT NULL ,
  PRIMARY KEY (`question_id`) ,
  INDEX `step_id_idx` (`step_id_quest` ASC) ,
  CONSTRAINT `step_id_quset`
    FOREIGN KEY (`step_id_quest` )
    REFERENCES `mydb`.`steps` (`step_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`answers`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mydb`.`answers` (
  `answer_id` INT NOT NULL AUTO_INCREMENT ,
  `question_id_ans` INT NOT NULL ,
  `answer_content` VARCHAR(200) NULL ,
  `answer_is_correct` TINYINT(1) NULL ,
  PRIMARY KEY (`answer_id`) ,
  INDEX `question_id_idx` (`question_id_ans` ASC) ,
  CONSTRAINT `question_id_ans`
    FOREIGN KEY (`question_id_ans` )
    REFERENCES `mydb`.`questions` (`question_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`users_answers`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mydb`.`users_answers` (
  `user_answer_id` INT NOT NULL AUTO_INCREMENT ,
  `user_id_usr_ans` INT NOT NULL ,
  `question_id_usr_ans` INT NOT NULL ,
  `answer_id_usr_ans` INT NOT NULL ,
  PRIMARY KEY (`user_answer_id`) ,
  INDEX `answer_id_idx` (`answer_id_usr_ans` ASC) ,
  INDEX `question_id_idx` (`question_id_usr_ans` ASC) ,
  INDEX `user_id_idx` (`user_id_usr_ans` ASC) ,
  CONSTRAINT `answer_id_usr_ans`
    FOREIGN KEY (`answer_id_usr_ans` )
    REFERENCES `mydb`.`answers` (`answer_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `question_id_usr_ans`
    FOREIGN KEY (`question_id_usr_ans` )
    REFERENCES `mydb`.`questions` (`question_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `user_id_usr_ans`
    FOREIGN KEY (`user_id_usr_ans` )
    REFERENCES `mydb`.`users` (`user_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`blackboard`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mydb`.`blackboard` (
  `blackboard_id` INT NOT NULL AUTO_INCREMENT ,
  `workshop_id` INT NOT NULL ,
  `blackboard_content` TEXT NULL ,
  PRIMARY KEY (`blackboard_id`) ,
  UNIQUE INDEX `workshop_id_UNIQUE` (`workshop_id` ASC) ,
  INDEX `workshop_id_idx` (`workshop_id` ASC) ,
  CONSTRAINT `workshop_id`
    FOREIGN KEY (`workshop_id` )
    REFERENCES `mydb`.`workshops` (`workshop_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`files`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mydb`.`files` (
  `files_id` INT NOT NULL ,
  `file_name` VARCHAR(45) NOT NULL ,
  `file_src` VARCHAR(145) NOT NULL ,
  `step_id_files` INT NULL ,
  PRIMARY KEY (`files_id`) ,
  INDEX `step_id_idx` (`step_id_files` ASC) ,
  CONSTRAINT `step_id_files`
    FOREIGN KEY (`step_id_files` )
    REFERENCES `mydb`.`steps` (`step_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`workshop_participants`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mydb`.`workshop_participants` (
  `workshop_participant_id` INT NOT NULL ,
  `user_id_wp` INT NULL ,
  `workshop_id_wp` INT NULL ,
  PRIMARY KEY (`workshop_participant_id`) ,
  INDEX `user_id_wp_idx` (`user_id_wp` ASC) ,
  INDEX `workshop_id_wp_idx` (`workshop_id_wp` ASC) ,
  CONSTRAINT `user_id_wp`
    FOREIGN KEY (`user_id_wp` )
    REFERENCES `mydb`.`users` (`user_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `workshop_id_wp`
    FOREIGN KEY (`workshop_id_wp` )
    REFERENCES `mydb`.`workshops` (`workshop_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

USE `mydb` ;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
