CREATE TABLE `db_a6ebb6_tixdb`.`tblsupportconvo` (
  `ID` INT NOT NULL AUTO_INCREMENT,
  `TicketID` INT NOT NULL,
  `UserCommentID` INT NOT NULL,
  `Comment` VARCHAR(500) NULL,
  `Attachment` BLOB NULL DEFAULT NULL,
  `isActive` INT NOT NULL DEFAULT 1,
  `CreatedByID` INT NOT NULL DEFAULT -1,
  `DateCreated` DATETIME NULL DEFAULT now(),
  `ModifiedByID` INT NULL,
  `DateModified` DATETIME NULL,
  `Remarks` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`ID`));
