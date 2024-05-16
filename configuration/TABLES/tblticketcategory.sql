CREATE TABLE `db_a6ebb6_tixdb`.`tblticketcategory` (
  `ID` INT NOT NULL AUTO_INCREMENT,
  `CategoryCode` VARCHAR(45) NOT NULL,
  `CategoryName` VARCHAR(45) NOT NULL,
  `Description` VARCHAR(50) NULL,
  `isActive` INT NULL DEFAULT 1,
  `Remarks` VARCHAR(50) NULL,
  `CreatedByID` INT NOT NULL DEFAULT -1,
  `DateCreated` DATETIME NOT NULL DEFAULT now(),
  `ModifiedByID` INT NULL,
  `DateModified` DATETIME NULL,
  PRIMARY KEY (`ID`, `CategoryCode`, `CategoryName`));