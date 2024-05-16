CREATE TABLE `TixDB`.`tblRoles` (
  `ID` INT NOT NULL AUTO_INCREMENT,
  `RoleName` VARCHAR(45) NOT NULL,
  `Description` VARCHAR(100) NULL,
  `DateCreated` DATETIME NOT NULL DEFAULT Now(),
  `CreatedByID` INT NOT NULL DEFAULT -1,
  `DateModifed` DATETIME NULL,
  `ModifiedByID` INT NULL,
  `Remarks` VARCHAR(500) NULL,
  `isActive` TINYINT NOT NULL DEFAULT 1,
  PRIMARY KEY (`ID`, `RoleName`));
