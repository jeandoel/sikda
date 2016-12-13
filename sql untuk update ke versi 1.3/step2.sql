ALTER TABLE pelayanan DROP PRIMARY KEY,ADD PRIMARY KEY (kd_puskesmas,kd_pasien,kd_pelayanan);


/*!50003 DROP FUNCTION IF EXISTS `Get_Age` */;
DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` FUNCTION `Get_Age`(dob DATE) RETURNS varchar(20) CHARSET latin1
BEGIN
	DECLARE years INT DEFAULT 0;
    DECLARE months INT DEFAULT 0;
    DECLARE days INT DEFAULT 0;
    DECLARE age DATE;
 
    SELECT DATE_ADD('0001-01-01', INTERVAL DATEDIFF(CURRENT_DATE(),dob) DAY ) INTO age;
 
    
    IF age IS NULL OR age = 0 OR age = '0000-00-00' THEN
        RETURN age;
    END IF;
 
    SELECT YEAR(age) - 1 INTO years;
    SELECT MONTH(age)- 1 INTO months;
    SELECT DAY(age) - 1 INTO days;
 
    IF years THEN
        RETURN CONCAT(years,'y ',months,'m');
 
    ELSEIF months THEN
        RETURN CONCAT(months,'m ',days,'d');
 
    ELSE
            RETURN CONCAT(days,'d');
    END IF;
END */$$
DELIMITER ;
