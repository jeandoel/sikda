select 
	`pel_ord_obat`.`KD_PELAYANAN` AS `KD_PELAYANAN`,
	`pel_ord_obat`.`KD_OBAT` AS `KD_OBAT`,
	`pel_ord_obat`.`SAT_BESAR` AS `SAT_BESAR`,
	`pel_ord_obat`.`SAT_KECIL` AS `SAT_KECIL`,
	`pel_ord_obat`.`HRG_DASAR` AS `HRG_DASAR`,
	`pel_ord_obat`.`HRG_JUAL` AS `HRG_JUAL`,
	`pel_ord_obat`.`QTY` AS `QTY`,
	`pel_ord_obat`.`DOSIS` AS `DOSIS`,
	if(
		(`pel_ord_obat`.`RACIKAN` = '0'),' ',`pel_ord_obat`.`RACIKAN`
	) AS `RACIKAN`,
	`pel_ord_obat`.`JUMLAH` AS `JUMLAH`,
	`pel_ord_obat`.`KD_PETUGAS` AS `KD_PETUGAS`,
	`pel_ord_obat`.`STATUS` AS `STATUS`,
	`pel_ord_obat`.`iROW` AS `iROW`,
	`apt_mst_obat`.`NAMA_OBAT` AS `NAMA_OBAT`,
	if(
		(`apt_mst_obat`.`GENERIK` = '1'),'GENERIK','NON GENERIK'
	) AS `GENERIK`,
	`apt_mst_obat`.`SINGKATAN` AS `SINGKATAN`,
	ifnull(
		`pel_ord_obat`.`KD_MILIK_OBAT`,'APT'
	) AS `KD_MILIK_OBAT`,
	`pel_ord_obat`.`NO_RESEP` AS `NO_RESEP`,
	`pel_ord_obat`.`KD_PUSKESMAS` AS `KD_PUSKESMAS`,
	`mst_dokter`.`NAMA` AS `NAMA`,
	`pasien`.`KD_PASIEN` AS `KD_PASIEN`,
	`Get_Age`(`pasien`.`TGL_LAHIR`) AS `UMUR`,`pasien`.`NAMA_LENGKAP` AS `NAMA_PASIEN`,
	`pelayanan`.`TGL_PELAYANAN` AS `TGL_PELAYANAN`,
	ifnull(`mst_kel_pasien`.`CUSTOMER`,'') AS `CUSTOMER`,
	`pasien`.`ALAMAT` AS `ALAMAT`,
	`pel_ord_obat`.`TANGGAL` AS `TANGGAL`,
	ifnull(`pel_ord_obat`.`APT_UNIT`,'APT') AS `APT_UNIT` 
from 
(
	(
		(
			(
				(
				`pel_ord_obat` join `apt_mst_obat` on
					(
						(`pel_ord_obat`.`KD_OBAT` = `apt_mst_obat`.`KD_OBAT`)
					)
				) 
				join `pelayanan` on
				(
					(`pel_ord_obat`.`KD_PELAYANAN` = `pelayanan`.`KD_PELAYANAN`)
				)
			) 
			left join `mst_dokter` on
			(
				(`mst_dokter`.`KD_DOKTER` = convert(`pelayanan`.`KD_DOKTER` using utf8))
			)
		) 
		join `pasien` on
		(
			(`pelayanan`.`KD_PASIEN` = `pasien`.`KD_PASIEN`)
		)
	) 
	join `mst_kel_pasien` on
	(
		(`pelayanan`.`JENIS_PASIEN` = `mst_kel_pasien`.`KD_CUSTOMER`)
	)
)