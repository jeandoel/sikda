select 
	`b`.`KD_PASIEN` AS `KD_PASIEN`,
	`a`.`TANGGAL_KIPI` AS `TANGGAL_KIPI`,
	`d`.`JENIS_IMUNISASI` AS `JENIS_IMUNISASI`,
	`e`.`NAMA_OBAT` AS `NAMA_OBAT`,
	`f`.`KATEGORI_IMUNISASI` AS `KATEGORI_IMUNISASI`,
	`a`.`KD_KECAMATAN` AS `KD_KECAMATAN`,
	`g`.`KELURAHAN` AS `KELURAHAN`,
	`i`.`NAMA` AS `dokter`,
	`j`.`GEJALA_KIPI` AS `GEJALA_KIPI`,
	`k`.`KEADAAN_KESEHATAN` AS `KEADAAN_KESEHATAN`,
	`a`.`KD_TRANS_KIPI` AS `KD_TRANS_KIPI` 
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
											`trans_kipi` `a` 
											left join `pel_imunisasi` `c` 
											on
												(
													(`c`.`KD_TRANS_IMUNISASI` = `a`.`KD_TRANS_IMUNISASI`)
												)
										) 
									join `apt_mst_obat` `e` on
										(
											(
												`e`.`KD_OBAT` = `c`.`KD_OBAT`
											)
										)
									) 
								join `mst_jenis_imunisasi` `d` on
									(
										(
											`d`.`KD_JENIS_IMUNISASI` = `c`.`KD_JENIS_IMUNISASI`
										)
									)
								) 
							join `trans_imunisasi` `b` on
								(
									(
										`b`.`KD_TRANS_IMUNISASI` = `c`.`KD_TRANS_IMUNISASI`
									)
								)
							) 
						join `mst_kategori_jenis_lokasi_imunisasi` `f` on
							(
								(
									`f`.`KD_KATEGORI_IMUNISASI` = `b`.`KD_KATEGORI_IMUNISASI`
								)
							)
						) 
					join `mst_kelurahan` `g` on
						(
							(
								convert(`g`.`KD_KELURAHAN` using utf8) = `a`.`KD_KELURAHAN`
							)
						)
					) 
				join `pel_petugas` `h` on
					(
						(
							`h`.`KD_TRANS_KIPI` = `a`.`KD_TRANS_KIPI`
						)
					)
				) 
			join `mst_dokter` `i` on
				(
					(
						`i`.`KD_DOKTER` = `h`.`KD_DOKTER`
					)
				)
			) 
		join `pel_gejala_kipi` `j` on
			(
				(
					`j`.`KD_TRANS_KIPI` = `a`.`KD_TRANS_KIPI`
				)
			)
		) 
	join `mst_keadaan_kesehatan` `k` on
	(
		(
			`k`.`KD_KEADAAN_KESEHATAN` = `a`.`KONDISI_AKHIR`
		)
	)
) 
group by `a`.`KD_TRANS_KIPI` desc