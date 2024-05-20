CREATE TABLE `tblticket` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `Subject` varchar(45) NOT NULL,
  `Description` varchar(45) DEFAULT NULL,
  `CategoryID` int NOT NULL,
  `GroupID` int DEFAULT NULL,
  `RequestTypeID` int DEFAULT NULL,
  `isActive` int DEFAULT '1',
  `Remarks` varchar(45) DEFAULT NULL,
  `CreatedByID` int DEFAULT NULL,
  `DateCreated` datetime DEFAULT NULL,
  `ModifiedByID` int DEFAULT NULL,
  `DateModified` datetime DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;