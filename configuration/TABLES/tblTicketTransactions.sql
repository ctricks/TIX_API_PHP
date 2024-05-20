CREATE TABLE `db_a6ebb6_tixdb`.`tbltickettransactions` (
  `ID` INT NOT NULL AUTO_INCREMENT,
  `TicketID` INT NOT NULL,
  `AssignedUserByID` INT NULL DEFAULT -1,
  `Remarks` VARCHAR(100) NULL,
  `Status` INT NULL,
  `isActive` INT NOT NULL DEFAULT 1,
  `DateCreated` DATETIME NULL DEFAULT now(),
  `CreatedByID` INT NULL DEFAULT -1,
  `DateModified` DATETIME NULL,
  `ModifiedByID` INT NULL,
  PRIMARY KEY (`ID`),
  INDEX `Ticket_idx` (`TicketID` ASC) VISIBLE,
  CONSTRAINT `Ticket`
    FOREIGN KEY (`TicketID`)
    REFERENCES `db_a6ebb6_tixdb`.`tblticket` (`ID`)
    ON DELETE CASCADE
    ON UPDATE CASCADE);