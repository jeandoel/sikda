select `p`.`KD_PUSKESMAS` AS `KD_PUSKESMAS`,
date_format(`p`.`TGL_PELAYANAN`,'%d-%m-%Y') AS `TANGGAL`,
`p`.`UNIT_PELAYANAN` AS `UNIT_PELAYANAN`,
`p`.`KD_PASIEN` AS `KD_PASIEN`,
`t`.`KD_PELAYANAN` AS `KD_PELAYANAN`,
`t`.`ID_KUNJUNGAN` AS `ID_KUNJUNGAN`,
`kunj`.`KD_KUNJUNGAN` AS `KD_KUNJUNGAN`,
`a`.`NAMA_LENGKAP` AS `NAMA`,
group_concat(distinct `d`.`KD_PENYAKIT` separator ', ') AS `KD_PENYAKIT`,
group_concat(distinct `q`.`PENYAKIT` separator ', ') AS `PENYAKIT`,
group_concat(distinct `p`.`ANAMNESA` separator ' | ') AS `ANAMNESA`,
`p`.`JENIS_KASUS` AS `JENIS_KASUS`,
group_concat(distinct `m`.`TINDAKAN` separator ' | ') AS `TINDAKAN`,
group_concat(distinct `p`.`CATATAN_DOKTER` separator ' | ') AS `CATATAN_DOKTER`,
group_concat(distinct `p`.`CATATAN_FISIK` separator ' | ') AS `CATATAN_FISIK`,
group_concat(distinct `o`.`KD_OBAT` separator ', ') AS `KD_OBAT`,
group_concat(distinct `r`.`NAMA_OBAT` separator ', ') AS `NAMA_OBAT`,
group_concat(distinct `u`.`UNIT` separator ', ') AS `NAMA_UNIT`,
group_concat(distinct `p`.`KD_DOKTER` separator ', ') AS `KD_DOKTER` 
from 
((((((((((
	`civira_sikda`.`pelayanan` `p` join `civira_sikda`.`pel_diagnosa` `d` on(((`d`.`KD_PELAYANAN` = `p`.`KD_PELAYANAN`) and (`d`.`KD_PUSKESMAS` = `p`.`KD_PUSKESMAS`)))) join `civira_sikda`.`mst_icd` `q` on((`q`.`KD_PENYAKIT` = `d`.`KD_PENYAKIT`))) 
left join `civira_sikda`.`pel_ord_obat` `o` on((`o`.`KD_PELAYANAN` = `p`.`KD_PELAYANAN`)))
join `civira_sikda`.`trans_kia` `t` on((convert(`t`.`KD_PELAYANAN` using utf8) = convert(`p`.`KD_PELAYANAN` using utf8))))
left join `civira_sikda`.`apt_mst_obat` `r` on((`r`.`KD_OBAT` = `o`.`KD_OBAT`))) 
join `civira_sikda`.`pasien` `a` on((`a`.`KD_PASIEN` = `p`.`KD_PASIEN`))) 
join `civira_sikda`.`kunjungan` `kd` on((`kd`.`KD_PASIEN` = `a`.`KD_PASIEN`))) 
join `civira_sikda`.`detail_tindakan_kb` `m` on((`m`.`KD_PELAYANAN` = convert(`p`.`KD_PELAYANAN` using utf8)))) 
left join `civira_sikda`.`mst_unit` `u` on((`u`.`KD_UNIT` = `p`.`KD_UNIT`)))
join `civira_sikda`.`kunjungan` `kunj` on((`kunj`.`ID_KUNJUNGAN` = `t`.`ID_KUNJUNGAN`)))  
group by `kunj`.`KD_KUNJUNGAN`, `kunj`.`KD_PUSKESMAS`
