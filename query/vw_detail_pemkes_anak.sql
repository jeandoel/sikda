select 
`b`.`ID_KUNJUNGAN` AS `ID_KUNJUNGAN`,
`kunj`.`KD_KUNJUNGAN` AS `KD_KUNJUNGAN`,
`a`.`TANGGAL_KUNJUNGAN` AS `TANGGAL_KUNJUNGAN`,
concat(`c`.`PRODUK`,'-','Qty:',`c`.`QTY`) AS `TINDAKAN`,
`d`.`NAMA_OBAT` AS `ALERGI`,
concat(`e`.`NAMA_OBAT`,'-',
	'Dosis:',`e`.`DOSIS`,'-','Qty:',`e`.`JUMLAH`) AS `RESEP_OBAT`,
`f`.`NAMA` AS `dokter_pemeriksa`,`g`.`NAMA` AS `dokter_petugas`,
`h`.`PENYAKIT` AS `PENYAKIT` 
from ((((((((
	`trans_kia` `b`
left join `pemeriksaan_anak` `a` on((`b`.`KD_KIA` = `a`.`KD_KIA`)))
left join `kunjungan` `kunj` on((`kunj`.`ID_KUNJUNGAN` = `b`.`ID_KUNJUNGAN`))) 
left join `vw_tindakan` `c` on((convert(`c`.`ID_KUNJUNGAN` using utf8) = convert(`b`.`ID_KUNJUNGAN` using utf8)))) 
left join `vw_alergi_obat` `d` on((convert(`d`.`ID_KUNJUNGAN` using utf8) = convert(`b`.`ID_KUNJUNGAN` using utf8))))
left join `vw_resep_obat` `e` on((convert(`e`.`ID_KUNJUNGAN` using utf8) = convert(`b`.`ID_KUNJUNGAN` using utf8)))) 
left join `mst_dokter` `f` on((`f`.`KD_DOKTER` = `b`.`KD_DOKTER_PEMERIKSA`))) 
left join `mst_dokter` `g` on((`f`.`KD_DOKTER` = `b`.`KD_DOKTER_PETUGAS`))) 
left join `vw_diagnosa` `h` on((convert(`h`.`ID_KUNJUNGAN` using utf8) = convert(`b`.`ID_KUNJUNGAN` using utf8))))