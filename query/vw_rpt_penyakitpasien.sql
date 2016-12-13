 select 
	 `d`.`KD_PUSKESMAS` AS `KD_PUSKESMAS`,
	 `d`.`KD_PELAYANAN` AS `KD_PELAYANAN`,
	 `d`.`KD_PENYAKIT` AS `KD_PENYAKIT`,
	 `d`.`JNS_KASUS` AS `JNS_KASUS`,
	 `d`.`JNS_DX` AS `JNS_DX`,
	 `y`.`TGL_PELAYANAN` AS `TGL_PELAYANAN`,
	 `y`.`KD_UNIT` AS `KD_UNIT`,
	 `m`.`KD_TINDAKAN` AS `KD_TINDAKAN`,
	 `k`.`PRODUK` AS `TINDAKAN`,
	 (
	 	select `mst_unit`.`UNIT` 
	 	from `mst_unit` 
	 	where 
	 		(
	 			(`mst_unit`.`KD_UNIT` = `y`.`KD_UNIT`) and 
	 			(`mst_unit`.`KD_KELAS` = '4') and 
	 			(`mst_unit`.`PARENT` = '2')
	 		)
	 ) AS `NM_UNIT`,
	 `y`.`UNIT_PELAYANAN` AS `UNIT_PELAYANAN`,
	 `y`.`KD_PASIEN` AS `KD_PASIEN`,
	 `y`.`CARA_BAYAR` AS `CARA_BAYAR`,
	 `y`.`KETERANGAN_WILAYAH` AS `KETERANGAN_WILAYAH`,
	 (
	 		select `mst_kel_pasien`.`CUSTOMER` 
	 		from `mst_kel_pasien` 
	 		where 
	 			(`mst_kel_pasien`.`KD_CUSTOMER` = `y`.`JENIS_PASIEN`)
	 ) AS `JENIS_PASIEN`,
	 `p`.`TGL_LAHIR` AS `TGL_LAHIR`,
	 `Get_AgeInDays`(`y`.`TGL_PELAYANAN`,`p`.`TGL_LAHIR`) AS `UMURINDAYS`,
	 `p`.`KD_JENIS_KELAMIN` AS `SEX`,
	 (
	 	select `sys_setting`.`KEY_VALUE` AS `KEY_VALUE` 
	 	from `sys_setting` 
	 	where 
	 	(
	 		(`sys_setting`.`KEY_DATA` = 'LEVEL_NAME') and 
	 		(
	 			`sys_setting`.`PUSKESMAS` = convert(`d`.`KD_PUSKESMAS` using utf8)
	 		)
	 	) limit 1
	 ) AS `NAMA_PUSKESMAS` 
 from 
 (
 	(
 		(
 			(
 				`pelayanan` `y` left join `pasien` `p` on
 				(
 					(`p`.`KD_PASIEN` = `y`.`KD_PASIEN`)
 				)
 			) 
 			left join `pel_tindakan` `m` on
 			(
 				(`y`.`KD_PELAYANAN` = `m`.`KD_PELAYANAN`)
 			)
 		) left join `pel_diagnosa` `d` on
 			(
 				(`y`.`KD_PELAYANAN` = `d`.`KD_PELAYANAN`)
 			)
 	) left join `mst_produk` `k` on 
	(
		(`k`.`KD_PRODUK` = `m`.`KD_TINDAKAN`)
	)
) 
where 
(
	(`d`.`KD_PUSKESMAS` is not null) and 
	(`d`.`KD_PUSKESMAS` <> '')
)