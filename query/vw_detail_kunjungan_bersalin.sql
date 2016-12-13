select 
	`trans_kia`.`ID_KUNJUNGAN` AS `ID_KUNJUNGAN`,
	`kunjungan`.`KD_KUNJUNGAN` AS `KD_KUNJUNGAN`,
	`kunjungan`.`KD_PUSKESMAS` AS `KD_PUSKESMAS`,
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
	`v_concat_tdk_kia`.`TINDAKAN_PASIEN` AS `TINDAKAN`,
	`v_concat_alergi`.`ALERGI_PASIEN` as `ALERGI`,
	`v_concat_ord_obat`.`OBAT_PASIEN` AS `OBAT` 
from
(
`mst_dokter` 
left join `trans_kia` on (`trans_kia`.`KD_DOKTER_PEMERIKSA` = `mst_dokter`.`KD_DOKTER`)
join `kunjungan` on (`kunjungan`.`ID_KUNJUNGAN`=`trans_kia`.`ID_KUNJUNGAN`)
left join `v_concat_ord_obat` ON `v_concat_ord_obat`.`KD_PASIEN` = `trans_kia`.`KD_PASIEN`
left join `v_concat_alergi` ON `v_concat_alergi`.`KD_PASIEN` = `trans_kia`.`KD_PASIEN`
left join `v_concat_tdk_kia` ON `v_concat_tdk_kia`.`KD_PASIEN` = `trans_kia`.`KD_PASIEN`
left join `kunjungan_bersalin` on (`kunjungan_bersalin`.`KD_KIA` = `trans_kia`.`KD_KIA`)
-- left join `pasien` on (convert(`pasien`.`KD_PASIEN` using utf8) = `kunjungan_bersalin`.`KD_PASIEN`)
INNER join `pasien` on (convert(`pasien`.`KD_PASIEN` using utf8) = `kunjungan_bersalin`.`KD_PASIEN`)
left join `mst_cara_persalinan` on (`mst_cara_persalinan`.`KD_CARA_PERSALINAN` = `kunjungan_bersalin`.`KD_CARA_BERSALIN`)
left join `mst_jenis_kelahiran` on (`mst_jenis_kelahiran`.`KD_JENIS_KELAHIRAN` = `kunjungan_bersalin`.`KD_JENIS_KELAHIRAN`)
left join `mst_keadaan_kesehatan` on (`mst_keadaan_kesehatan`.`KD_KEADAAN_KESEHATAN` = `kunjungan_bersalin`.`KD_KEADAAN_KESEHATAN`)
left join `detail_keadaan_bayi` on (`detail_keadaan_bayi`.`KD_KUNJUNGAN_BERSALIN` = `kunjungan_bersalin`.`KD_KUNJUNGAN_BERSALIN`)
left join `mst_status_hamil` on (`mst_status_hamil`.`KD_STATUS_HAMIL` = `kunjungan_bersalin`.`KD_STATUS_HAMIL`)
left join `mst_jenis_kelamin` on (`mst_jenis_kelamin`.`KD_JENIS_KELAMIN` = convert(`pasien`.`KD_JENIS_KELAMIN` using utf8))
left join `detail_asuhan_bayi` on (`detail_asuhan_bayi`.`KD_KUNJUNGAN_BERSALIN` = `kunjungan_bersalin`.`KD_KUNJUNGAN_BERSALIN`)
left join `pel_ord_obat` on (`trans_kia`.`KD_PELAYANAN` = convert(`pel_ord_obat`.`KD_PELAYANAN` using utf8))
left join `pasien_alergi_obt` on (`pasien_alergi_obt`.`KD_PASIEN` = convert(`kunjungan_bersalin`.`KD_PASIEN` using utf8))
left join `apt_mst_obat` on (`apt_mst_obat`.`KD_OBAT` = `pasien_alergi_obt`.`KD_OBAT`)
left join `apt_mst_harga_obat` on (`apt_mst_harga_obat`.`KD_OBAT` = `pasien_alergi_obt`.`KD_OBAT`)
left join `pel_tindakan` on (`pel_tindakan`.`KD_TINDAKAN` = `kunjungan_bersalin`.`KD_TINDAKAN`)
left join `mst_produk` on (`mst_produk`.`KD_PRODUK` = `pel_tindakan`.`KD_TINDAKAN`)
)
GROUP BY `kunjungan`.`KD_KUNJUNGAN`, `kunjungan`.`KD_PUSKESMAS`