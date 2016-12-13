select 
	`a`.`ID_KUNJUNGAN` AS `ID_KUNJUNGAN`,
	`a`.`KD_KUNJUNGAN` AS `KD_KUNJUNGAN`,
	`a`.`KD_PUSKESMAS` AS `KD_PUSKESMAS`,
	`b`.`KD_PELAYANAN` AS `KD_PELAYANAN`,
	`b`.`KD_PASIEN` AS `KD_PASIEN`,
	`b`.`TGL_PELAYANAN` AS `TGL_PELAYANAN`,
	`b`.`JENIS_PASIEN` AS `KD_JENIS_PASIEN`,
	`d`.`CUSTOMER` AS `CUSTOMER`,
	`a`.`KD_UNIT` AS `KD_UNIT`,
	`c`.`UNIT` AS `UNIT`,
	`b`.`CARA_BAYAR` AS `KD_CARA_BAYAR`,
	`e`.`CARA_BAYAR` AS `CARA_BAYAR`,
	`b`.`ANAMNESA` AS `ANAMNESA`,
	`b`.`CATATAN_FISIK` AS `CATATAN_FISIK`,
	`b`.`CATATAN_DOKTER` AS `CATATAN_DOKTER`,
	`b`.`KEADAAN_KELUAR` AS `KEADAAN_KELUAR` 
from 
(
	(
		(
			(`kunjungan` `a` 
				left join `pelayanan` `b` on
				(
					(`b`.`KD_PELAYANAN` = `a`.`KD_PELAYANAN`) AND
					(`b`.`KD_PUSKESMAS` = `a`.`KD_PUSKESMAS`)
				)
			) 
			left join `mst_unit` `c` on
			(
				(`c`.`KD_UNIT` = `a`.`KD_UNIT`)
			)
		) 
		left join `mst_kel_pasien` `d` on
		(
			(`d`.`KD_CUSTOMER` = `b`.`JENIS_PASIEN`)
		)
	) 
	left join `mst_cara_bayar` `e` on
	(
		(`e`.`KD_BAYAR` = `b`.`CARA_BAYAR`)
	)
)