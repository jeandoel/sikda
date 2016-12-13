select 
	`a`.`ID_KUNJUNGAN` AS `ID_KUNJUNGAN`,
	`kun`.`KD_KUNJUNGAN` AS `KD_KUNJUNGAN`,
	`a`.`KD_PELAYANAN` AS `KD_PELAYANAN`,
	`c`.`KD_PUSKESMAS` AS `KD_PUSKESMAS`,
	`c`.`KD_PASIEN` AS `KD_PASIEN`,
	`b`.`TANGGAL_PERSALINAN` AS `TANGGAL_PERSALINAN`,
	`b`.`JAM_KELAHIRAN` AS `JAM_KELAHIRAN`,
	`b`.`KD_KUNJUNGAN_BERSALIN` AS `KD_KUNJUNGAN_BERSALIN`,
	`b`.`UMUR_KEHAMILAN` AS `UMUR_KEHAMILAN`,
	`b`.`ANAK_KE` AS `ANAK_KE`,
	`b`.`BERAT_LAHIR` AS `BERAT_LAHIR`,
	`b`.`JML_BAYI` AS `JML_BAYI`,
	`b`.`KET_TAMBAHAN` AS `KET_TAMBAHAN`,
	`b`.`LINGKAR_KEPALA` AS `LINGKAR_KEPALA`,
	`b`.`PANJANG_BADAN` AS `PANJANG_BADAN`,
	`d`.`NAMA` AS `DOKTER_PEMERIKSA`,
	`e`.`NAMA` AS `DOKTER_PETUGAS`,
	`f`.`CARA_PERSALINAN` AS `CARA_PERSALINAN`,
	`f`.`KD_CARA_PERSALINAN` AS `KD_CARA_PERSALINAN`,
	`g`.`JENIS_KELAHIRAN` AS `JENIS_KELAHIRAN`,
	`h`.`KEADAAN_KESEHATAN` AS `KEADAAN_KESEHATAN`,
	`h`.`KD_KEADAAN_KESEHATAN` AS `KD_KEADAAN_KESEHATAN`,
	`z`.`CATATAN_DOKTER` AS `CATATAN_DOKTER`,
	`z`.`CATATAN_APOTEK` AS `CATATAN_APOTEK`,
	group_concat(distinct `i`.`KEADAAN_BAYI_LAHIR` separator ' | ') AS `KEADAAN_BAYI_LAHIR`,
	group_concat(distinct `j`.`ASUHAN_BAYI_LAHIR` separator ' | ') AS `ASUHAN_BAYI_LAHIR`,
	`k`.`STATUS_HAMIL` AS `STATUS_HAMIL`,
	`k`.`KD_STATUS_HAMIL` AS `KD_STATUS_HAMIL`,
	concat(`l`.`PRODUK`,'-','Qty:',`l`.`QTY`) AS `TINDAKAN`,
	concat(`m`.`NAMA_OBAT`,'-','Dosis:',`m`.`DOSIS`,'-','Qty:',`m`.`JUMLAH`) AS `RESEP_OBAT`,
	`n`.`NAMA_OBAT` AS `ALERGI`,
	`o`.`JENIS_KELAMIN` AS `JENIS_KELAMIN` 
from 
(
	(
		(
			(
				(
					(
						(
							(
								(
									(
										(
											(
												(
													(
														(
															`trans_kia` `a`
															join `kunjungan` `kun` on `a`.`ID_KUNJUNGAN` = `kun`.`ID_KUNJUNGAN` 
															left join `kunjungan_bersalin` `b` on(
																(`a`.`KD_KIA` = `b`.`KD_KIA`)
															)
														) 
														left join `pasien` `c` on(
															(convert(`c`.`KD_PASIEN` using utf8) = `b`.`KD_PASIEN`)
														) #need to join with pelayanan table or kunjungan table so we can get kd puskesmas
													) 
													left join `mst_jenis_kelamin` `o` on(
														(`o`.`KD_JENIS_KELAMIN` = convert(`c`.`KD_JENIS_KELAMIN` using utf8))
													)
												)
												left join `mst_dokter` `d` on(
													(`d`.`KD_DOKTER` = `a`.`KD_DOKTER_PEMERIKSA`)
												)
											)
											left join `check_coment` `z` on(
												(`z`.`KD_PELAYANAN` = `a`.`KD_PELAYANAN`)
											)
										)
										left join `mst_dokter` `e` on(
											(`e`.`KD_DOKTER` = `a`.`KD_DOKTER_PETUGAS`)
										)
									)
									left join `mst_cara_persalinan` `f` on(
										(`f`.`KD_CARA_PERSALINAN` = `b`.`KD_CARA_BERSALIN`)
									)
								)
								left join `mst_jenis_kelahiran` `g` on(
									(`g`.`KD_JENIS_KELAHIRAN` = `b`.`KD_JENIS_KELAHIRAN`)
								)
							)
							left join `mst_keadaan_kesehatan` `h` on(
								(`h`.`KD_KEADAAN_KESEHATAN` = `b`.`KD_KEADAAN_KESEHATAN`)
							)
						)
						left join `detail_keadaan_bayi` `i` on(
							(`i`.`KD_KUNJUNGAN_BERSALIN` = `b`.`KD_KUNJUNGAN_BERSALIN`)
						)
					)
					left join `detail_asuhan_bayi` `j` on(
						(`j`.`KD_KUNJUNGAN_BERSALIN` = `b`.`KD_KUNJUNGAN_BERSALIN`)
					)
				)
				left join `mst_status_hamil` `k` on(
					(`k`.`KD_STATUS_HAMIL` = `b`.`KD_STATUS_HAMIL`)
				)
			)
			left join `vw_tindakan` `l` on(
				(convert(`l`.`ID_KUNJUNGAN` using utf8) = `a`.`ID_KUNJUNGAN`))
		) 
		left join `vw_resep_obat` `m` on(
			(convert(`m`.`ID_KUNJUNGAN` using utf8) = `a`.`ID_KUNJUNGAN`))
	)
	left join `vw_alergi_obat` `n` on(
	(convert(`n`.`ID_KUNJUNGAN` using utf8) = `a`.`ID_KUNJUNGAN`))
) 
group by `kun`.`KD_KUNJUNGAN`, `c`.`KD_PUSKESMAS`