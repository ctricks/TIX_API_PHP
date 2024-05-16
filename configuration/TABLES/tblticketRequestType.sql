CREATE TABLE `tixdb`.`tblrequesttype` (
  `ID` INT NOT NULL AUTO_INCREMENT,
  `ReqTypeCode` VARCHAR(45) NOT NULL,
  `ReqTypeDescription` VARCHAR(45) NULL,
  `isActive` INT NOT NULL DEFAULT 1,
  `Remarks` VARCHAR(45) NULL,
  `DateCreated` DATETIME NULL DEFAULT now(),
  `CreatedByID` INT NULL DEFAULT -1,
  `DateModified` DATETIME NULL,
  `ModifiedByID` INT NULL,
  PRIMARY KEY (`ID`, `ReqTypeCode`));