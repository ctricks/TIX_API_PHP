CREATE TABLE `db_a6ebb6_tixdb`.`tblticketstatus` (
  `ID` INT NOT NULL AUTO_INCREMENT,
  `StatusCode` VARCHAR(45) NOT NULL,
  `StatusName` VARCHAR(45) NOT NULL,
  `Remarks` VARCHAR(45) NULL,
  `isActive` INT NULL DEFAULT 1,
  `DateCreated` DATETIME NULL DEFAULT now(),
  `CreatedByID` INT NOT NULL DEFAULT -1,
  `DateModified` DATETIME NULL,
  `ModifiedByID` INT NULL,
  PRIMARY KEY (`ID`, `StatusCode`));
