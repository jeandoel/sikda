select 
`a`.`ID_KUNJUNGAN` AS `ID_KUNJUNGAN`,
`a`.`KD_KUNJUNGAN` AS `KD_KUNJUNGAN`,
`a`.`KD_PUSKESMAS` AS `KD_PUSKESMAS`,
`b`.`KD_PELAYANAN` AS `KD_PELAYANAN`,
`b`.`KD_PASIEN` AS `KD_PASIEN`,
`c`.`KD_TINDAKAN` AS `KD_TINDAKAN`,
`d`.`PRODUK` AS `PRODUK`,
`c`.`HRG_TINDAKAN` AS `HRG_TINDAKAN`,
`c`.`QTY` AS `QTY`,
`c`.`KETERANGAN` AS `KETERANGAN` 
from 
(
	(
		(`kunjungan` `a` 
			left join `pelayanan` `b` on(
				(`b`.`KD_PASIEN` = `a`.`KD_PASIEN`)
			)
		) 
		left join `pel_tindakan` `c` on(
				(`c`.`KD_PELAYANAN` = `b`.`KD_PELAYANAN`)
			)
		) 
		left join `mst_produk` `d` on(
			(
				convert(`c`.`KD_TINDAKAN` using utf8) = convert(`d`.`KD_PRODUK` using utf8)
			)
		)
) 
group by `a`.`KD_KUNJUNGAN`