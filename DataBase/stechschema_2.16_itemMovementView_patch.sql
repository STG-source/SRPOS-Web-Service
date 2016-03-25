CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `itemmovementview` AS select `i`.`itemIndex` AS `itemIndex`,`i`.`itemID` AS `itemID`,`s`.`saleNo` AS `actionType`,sum(`s`.`saleQTY`) AS `QTY`,min(`s`.`stockQTY`) AS `stockQTY`,`s`.`CRE_DTE` AS `CRE_DTE` from (`salelist` `s` join `_item` `i`) where (`s`.`itemIndex` = `i`.`itemIndex`) group by `i`.`itemIndex`,`s`.`saleNo` union all select `i`.`itemIndex` AS `itemIndex`,`i`.`itemID` AS `itemID`,`in`.`inID` AS `actionType`,`in`.`inQTY` AS `QTY`,`in`.`stockQTY` AS `stockQTY`,`in`.`CRE_DTE` AS `CRE_DTE` from (`inventoryin` `in` join `_item` `i`) where (`i`.`itemIndex` = `in`.`itemIndex`) union all select `i`.`itemIndex` AS `itemIndex`,`i`.`itemID` AS `itemID`,`move`.`moveID` AS `actionType`,`move`.`moveQTY` AS `QTY`,`move`.`stockQTY` AS `stockQTY`,`move`.`CRE_DTE` AS `CRE_DTE` from (`inventorymove` `move` join `_item` `i`) where (`move`.`itemIndex` = `i`.`itemIndex`) order by `itemIndex`,`CRE_DTE`;

--
-- Table structure for table `workcode`
--

CREATE TABLE IF NOT EXISTS `workcode` (
  `code` varchar(10) NOT NULL,
  `setvalue` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `workcode`
--

INSERT INTO `workcode` (`code`, `setvalue`) VALUES
('0', 'waiting'),
('1', 'Done'),
('DB_VER', '2.16'),
('DB_NAME', 'SMITPOS'),
('CUSTOMIZED', 'No'),
('CUSTOMER', '0000'),
('MAC_NO', '0001'),
('PRINTSLIP', 'TRUE'),
('REPRINT', '0'),
('FORCEPRINT', 'TRUE'),
('SLIP_LOGO', 'INVISIBLE'),
('SLIP_ADV', 'INVISIBLE'),
('CADIS_MIN', '0'),
('CADIS_MAX', '50000'),
('BC_SCAN', 'SIMPLY'),
('POS_MODE', 'PICKCREDIT'),
('ZPI', 'NOCOUNT_NOPRN'),
('RECEIPT_LA', 'BASIC_MART'),
('PRN_TAX', 'VISIBLE'),
('CUS_DISP', 'DISABLE');

-- --------------------------------------------------------
