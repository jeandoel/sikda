select 
`a`.`ID_KUNJUNGAN` AS `ID_KUNJUNGAN`,
`a`.`KD_KUNJUNGAN` AS `KD_KUNJUNGAN`,
`a`.`KD_PUSKESMAS` AS `KD_PUSKESMAS`,
`b`.`KD_PELAYANAN` AS `KD_PELAYANAN`,
`b`.`KD_PASIEN` AS `KD_PASIEN`,
`c`.`KD_OBAT` AS `KD_OBAT`,
`e`.`NAMA_OBAT` AS `NAMA_OBAT`,
`c`.`SAT_BESAR` AS `SAT_BESAR`,
`c`.`SAT_KECIL` AS `SAT_KECIL`,
`c`.`DOSIS` AS `DOSIS`,
`c`.`JUMLAH` AS `JUMLAH`,
`d`.`HARGA_JUAL` AS `HARGA_JUAL` from 
(
	(
		(
			(
				`kunjungan` `a` 
				left join `pelayanan` `b` on(
					(`b`.`KD_PASIEN` = `a`.`KD_PASIEN`)
				)
			) 
				left join `pel_ord_obat` `c` on(
					(`c`.`KD_PELAYANAN` = `b`.`KD_PELAYANAN`)
				)
			) 
				left join `apt_mst_harga_obat` `d` on(
					(
						`d`.`KD_OBAT` = convert(`c`.`KD_OBAT` using utf8)
					)
				)
	) left join `apt_mst_obat` `e` on(
		(`e`.`KD_OBAT` = `c`.`KD_OBAT`)
	)
) 
group by `a`.`KD_KUNJUNGAN`