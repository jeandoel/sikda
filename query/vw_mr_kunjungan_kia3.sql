select 
`p`.`KD_PUSKESMAS` AS `KD_PUSKESMAS`,
date_format(`p`.`TGL_PELAYANAN`,'%d-%m-%Y') AS `TANGGAL`,
`p`.`UNIT_PELAYANAN` AS `UNIT_PELAYANAN`,
`p`.`KD_PASIEN` AS `KD_PASIEN`,`a`.`NAMA_LENGKAP` AS `NAMA`,
`kd`.`ID_KUNJUNGAN` AS `ID_KUNJUNGAN`,
`kunj`.`KD_KUNJUNGAN` AS `KD_KUNJUNGAN`,
group_concat(distinct `p`.`ANAMNESA` separator ' | ') AS `ANAMNESA`,
`p`.`JENIS_KASUS` AS `JENIS_KASUS`,
group_concat(distinct `mi`.`PENYAKIT` separator ' | ') AS `PENYAKIT`,
group_concat(distinct `t`.`PRODUK` separator ' | ') AS `TINDAKAN`,
group_concat(distinct `p`.`CATATAN_DOKTER` separator ' | ') AS `CATATAN_DOKTER`,
group_concat(distinct `p`.`CATATAN_FISIK` separator ' | ') AS `CATATAN_FISIK`,
group_concat(distinct `o`.`KD_OBAT` separator ', ') AS `KD_OBAT`,
group_concat(distinct `r`.`NAMA_OBAT` separator ', ') AS `NAMA_OBAT`,
group_concat(distinct `u`.`UNIT` separator ', ') AS `NAMA_UNIT`,
group_concat(distinct `p`.`KD_DOKTER` separator ', ') AS `KD_DOKTER`
from 
((((((((((
	`civira_sikda`.`pelayanan` `p` 
left join `civira_sikda`.`pel_ord_obat` `o` on((`o`.`KD_PELAYANAN` = `p`.`KD_PELAYANAN`))) 
left join `civira_sikda`.`apt_mst_obat` `r` on((`r`.`KD_OBAT` = `o`.`KD_OBAT`))) 
join `civira_sikda`.`pasien` `a` on((`a`.`KD_PASIEN` = `p`.`KD_PASIEN`))) 
join `civira_sikda`.`trans_kia` `kd` on((convert(`kd`.`KD_PELAYANAN` using utf8) = convert(`p`.`KD_PELAYANAN` using utf8)))) 
join `civira_sikda`.`pel_tindakan` `m` on((`m`.`KD_PELAYANAN` = `p`.`KD_PELAYANAN`))) 
join `civira_sikda`.`mst_produk` `t` on((`t`.`KD_PRODUK` = `m`.`KD_TINDAKAN`))) 
join `civira_sikda`.`pel_diagnosa` `pd` on((`pd`.`KD_PELAYANAN` = `p`.`KD_PELAYANAN`))) 
join `civira_sikda`.`mst_icd` `mi` on((`mi`.`KD_PENYAKIT` = `pd`.`KD_PENYAKIT`))) 
left join `civira_sikda`.`mst_unit` `u` on((`u`.`KD_UNIT` = `p`.`KD_UNIT`))) 
join `civira_sikda`.`kunjungan` `kunj` on((`kunj`.`ID_KUNJUNGAN` = `kd`.`ID_KUNJUNGAN`))) 
group by `kd`.`KD_PELAYANAN`
