CREATE TABLE `TixDB`.`tblUsers` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `Username` VARCHAR(45) NOT NULL,
  `Password` VARCHAR(45) NOT NULL,
  `RoleID` INT NOT NULL,
  `DateCreated` DATETIME NOT NULL DEFAULT NOW(),
  `CreatedByID` INT NOT NULL DEFAULT -1,
  `DateModified` DATETIME NULL,
  `ModifiedByID` INT NULL,
  `isActive` TINYINT NOT NULL DEFAULT 1,
  `Remarks` VARCHAR(500) NULL,
  PRIMARY KEY (`Id`, `Username`));
