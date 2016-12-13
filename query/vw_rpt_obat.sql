select 
	`vw_layanan_order_obat`.`KD_PELAYANAN` AS `KD_PELAYANAN`,
	`vw_layanan_order_obat`.`KD_PUSKESMAS` AS `KD_PUSKESMAS`,
	`vw_layanan_order_obat`.`KD_OBAT` AS `KD_OBAT`,
	`vw_layanan_order_obat`.`NO_RESEP` AS `NO_RESEP`,
	`vw_layanan_order_obat`.`NAMA_OBAT` AS `NAMA_OBAT`,
	`vw_layanan_order_obat`.`QTY` AS `QTY`,
	`vw_layanan_order_obat`.`STATUS` AS `STATUS`,
	`pelayanan`.`TGL_PELAYANAN` AS `TGL_PELAYANAN`,
	`pelayanan`.`KD_UNIT` AS `KD_UNIT`,
	`vw_layanan_order_obat`.`KD_MILIK_OBAT` AS `KD_MILIK_OBAT` 
from 
(
	`vw_layanan_order_obat` 
	join `pelayanan` on
	(
		(`vw_layanan_order_obat`.`KD_PELAYANAN` = `pelayanan`.`KD_PELAYANAN`)
	)
) 
where 
(
	`vw_layanan_order_obat`.`STATUS` = 1
)