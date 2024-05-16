CREATE TABLE `tblcustomeraccount` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `AccountID` varchar(50) NOT NULL,
  `AccountName` varchar(50) NOT NULL,
  `Remarks` varchar(45) DEFAULT NULL,
  `isActive` int DEFAULT '1',
  `CreatedByID` int NOT NULL DEFAULT '-1',
  `DateCreated` datetime DEFAULT CURRENT_TIMESTAMP,
  `ModifiedByID` int DEFAULT NULL,
  `DateModified` datetime DEFAULT NULL,
  PRIMARY KEY (`ID`,`AccountID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;