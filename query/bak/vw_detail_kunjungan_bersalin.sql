select 
`trans_kia`.`KD_KUNJUNGAN` AS `KD_KUNJUNGAN`,
`pasien`.`KD_PASIEN` AS `KD_PASIEN`,
date_format(`kunjungan_bersalin`.`TANGGAL_PERSALINAN`,'%d-%M-%Y') AS `TANGGAL_KUNJUNGAN`,
`kunjungan_bersalin`.`JAM_KELAHIRAN` AS `JAM_KELAHIRAN`,
`kunjungan_bersalin`.`UMUR_KEHAMILAN` AS `UMUR_KEHAMILAN`,
`kunjungan_bersalin`.`JML_BAYI` AS `JML_BAYI`,
`kunjungan_bersalin`.`KET_TAMBAHAN` AS `KET_TAMBAHAN`,
`mst_dokter`.`NAMA` AS `petugas`,
`mst_dokter`.`NAMA` AS `pemeriksa`,
`mst_cara_persalinan`.`CARA_PERSALINAN` AS `CARA_PERSALINAN`,
`mst_jenis_kelahiran`.`JENIS_KELAHIRAN` AS `JENIS_KELAHIRAN`,
`mst_keadaan_kesehatan`.`KEADAAN_KESEHATAN` AS `KEADAAN_KESEHATAN`,
`detail_keadaan_bayi`.`KEADAAN_BAYI_LAHIR` AS `KEADAAN_BAYI_LAHIR`,
`mst_status_hamil`.`STATUS_HAMIL` AS `STATUS_HAMIL`,
`kunjungan_bersalin`.`ANAK_KE` AS `ANAK_KE`,
`kunjungan_bersalin`.`LINGKAR_KEPALA` AS `LINGKAR_KEPALA`,
`kunjungan_bersalin`.`BERAT_LAHIR` AS `BERAT_LAHIR`,
`kunjungan_bersalin`.`PANJANG_BADAN` AS `PANJANG_BADAN`,
`mst_jenis_kelamin`.`JENIS_KELAMIN` AS `JENIS_KELAMIN`,
`detail_asuhan_bayi`.`ASUHAN_BAYI_LAHIR` AS `ASUHAN_BAYI_LAHIR`,
(
	select 
		group_concat(
			distinct concat(
				`mst_produk`.`PRODUK`,'-Rp.',`pel_tindakan`.`HRG_TINDAKAN`,'-Jml:',`pel_tindakan`.`QTY`,'-Ket:',`pel_tindakan`.`KETERANGAN`
			) separator ' | '
		) 
		from 
		(
			(
			`mst_produk` 
				join `pel_tindakan` on
				(
					(`mst_produk`.`KD_PRODUK` = `pel_tindakan`.`KD_TINDAKAN`)
				)
			) 
			join `trans_kia` on
			(
				(convert(`pel_tindakan`.`KD_PELAYANAN` using utf8) = `trans_kia`.`KD_PELAYANAN`)
			)
		)
) AS `TINDAKAN`,
group_concat(distinct `apt_mst_obat`.`NAMA_OBAT` separator ' | ') AS `ALERGI`, #this make the bug where it will combine all row into one, must be separated inside subquery
(
	select group_concat(
		distinct concat(
			`apt_mst_obat`.`NAMA_OBAT`,'-',`apt_mst_harga_obat`.`HARGA_JUAL`,'-Dosis:',`pel_ord_obat`.`DOSIS`,'-Jlh:',`pel_ord_obat`.`QTY`
		) separator ' | '
	) from (
		(
		`apt_mst_obat` join `apt_mst_harga_obat` on
			(
				(`apt_mst_obat`.`KD_OBAT` = `apt_mst_harga_obat`.`KD_OBAT`)
			)
		) 
		join `pel_ord_obat` on
		(
			(`apt_mst_obat`.`KD_OBAT` = `pel_ord_obat`.`KD_OBAT`)
		)
	)
) AS `OBAT` 
from 
(
	(
		(
			(
				(
					(
						`pel_ord_obat` 
						left join 
							(
								(
									(
										(
											(
												(
													(
														(
															`mst_dokter` 
															left join 
																(
																	(
																		`trans_kia` 
																		left join `kunjungan_bersalin` on
																		(
																			(`kunjungan_bersalin`.`KD_KIA` = `trans_kia`.`KD_KIA`)
																		)
																	) 
																	left join `pasien` on
																	(
																		(convert(`pasien`.`KD_PASIEN` using utf8) = `kunjungan_bersalin`.`KD_PASIEN`)
																	)
																) 
															on
															(
																(`trans_kia`.`KD_DOKTER_PEMERIKSA` = `mst_dokter`.`KD_DOKTER`)
															)
														) 
														left join `mst_cara_persalinan` on
														(
															(`mst_cara_persalinan`.`KD_CARA_PERSALINAN` = `kunjungan_bersalin`.`KD_CARA_BERSALIN`)
														)
													) 
													left join `mst_jenis_kelahiran` on
													(
														(`mst_jenis_kelahiran`.`KD_JENIS_KELAHIRAN` = `kunjungan_bersalin`.`KD_JENIS_KELAHIRAN`)
													)
												) 
												left join `mst_keadaan_kesehatan` on
												(
													(`mst_keadaan_kesehatan`.`KD_KEADAAN_KESEHATAN` = `kunjungan_bersalin`.`KD_KEADAAN_KESEHATAN`)
												)
											) 
											left join `detail_keadaan_bayi` on
											(
												(`detail_keadaan_bayi`.`KD_KUNJUNGAN_BERSALIN` = `kunjungan_bersalin`.`KD_KUNJUNGAN_BERSALIN`)
											)
										) 
										left join `mst_status_hamil` on
										(
											(`mst_status_hamil`.`KD_STATUS_HAMIL` = `kunjungan_bersalin`.`KD_STATUS_HAMIL`)
										)
									) 
									left join `mst_jenis_kelamin` on
									(
										(`mst_jenis_kelamin`.`KD_JENIS_KELAMIN` = convert(`pasien`.`KD_JENIS_KELAMIN` using utf8))
									)
								) 
								left join `detail_asuhan_bayi` on
								(
									(`detail_asuhan_bayi`.`KD_KUNJUNGAN_BERSALIN` = `kunjungan_bersalin`.`KD_KUNJUNGAN_BERSALIN`)
								)
							) on
							(
								(`trans_kia`.`KD_PELAYANAN` = convert(`pel_ord_obat`.`KD_PELAYANAN` using utf8)
							)
						)
					) left join `pasien_alergi_obt` on
					(
						(`pasien_alergi_obt`.`KD_PASIEN` = convert(`kunjungan_bersalin`.`KD_PASIEN` using utf8))
					)
				) 
				left join `apt_mst_obat` on
				(
					(`apt_mst_obat`.`KD_OBAT` = `pasien_alergi_obt`.`KD_OBAT`)
				)
			) 
			left join `apt_mst_harga_obat` on
			(
				(`apt_mst_harga_obat`.`KD_OBAT` = `pasien_alergi_obt`.`KD_OBAT`)
			)
		) 
		left join `pel_tindakan` on
		(
			(`pel_tindakan`.`KD_TINDAKAN` = `kunjungan_bersalin`.`KD_TINDAKAN`)
		)
	) 
	left join `mst_produk` on
	(
		(`mst_produk`.`KD_PRODUK` = `pel_tindakan`.`KD_TINDAKAN`)
	)
)