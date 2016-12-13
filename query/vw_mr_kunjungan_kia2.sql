select 
`pa`.`KD_PASIEN` AS `KD_PASIEN`,
`pa`.`KD_PELAYANAN` AS `KD_PELAYANAN`,
`k`.`KD_KIA` AS `KD_KIA`,
`k`.`ID_KUNJUNGAN` AS `ID_KUNJUNGAN`,
`kunj`.`KD_KUNJUNGAN` AS `KD_KUNJUNGAN`,
`u`.`KD_PEMERIKSAAN_NEONATUS` AS `id`,
`u`.`KD_PEMERIKSAAN_NEONATUS` AS `KD_PEMERIKSAAN_NEONATUS`,
date_format(`u`.`TANGGAL_KUNJUNGAN`,'%d-%m-%Y') AS `TANGGAL_KUNJUNGAN`,
`u`.`KUNJUNGAN_KE` AS `KUNJUNGAN_KE`,
`u`.`BERAT_BADAN` AS `BERAT_BADAN`,
`u`.`PANJANG_BADAN` AS `PANJANG_BADAN`,
`a`.`HRG_TINDAKAN_ANAK` AS `HRG_TINDAKAN_ANAK`,
group_concat(distinct `a`.`TINDAKAN_ANAK` separator ' | ') AS `TINDAKAN_ANAK`,
group_concat(distinct `a`.`KET_TINDAKAN_ANAK` separator ' | ') AS `KET_TINDAKAN_ANAK`,
`u`.`KELUHAN` AS `KELUHAN`,group_concat(distinct `m`.`NAMA_OBAT` separator ' | ') AS `ALERGI`,
group_concat(distinct `n`.`NAMA_OBAT` separator ' | ') AS `OBAT`,
group_concat(distinct `i`.`TINDAKAN_IBU` separator ' | ') AS `TINDAKAN_IBU`,
concat(`d`.`NAMA`,'::',`d`.`JABATAN`) AS `dokter_pemeriksa`,
concat(`e`.`NAMA`,'::',`e`.`JABATAN`) AS `dokter_petugas`,
`u`.`KD_PEMERIKSAAN_NEONATUS` AS `kode` 
from 
((((((((((`civira_sikda`.`trans_kia` `k` 
left join `civira_sikda`.`pelayanan` `pa` on((convert(`k`.`KD_PELAYANAN` using utf8) = convert(`pa`.`KD_PELAYANAN` using utf8)))) 
left join `civira_sikda`.`pemeriksaan_neonatus` `u` on((`u`.`KD_KIA` = `k`.`KD_KIA`)))
left join `civira_sikda`.`pel_ord_obat` `p` on((convert(`k`.`KD_PELAYANAN` using utf8) = convert(`p`.`KD_PELAYANAN` using utf8))))
left join `civira_sikda`.`apt_mst_obat` `m` on((`p`.`KD_OBAT` = `m`.`KD_OBAT`))) 
left join `civira_sikda`.`apt_mst_obat` `n` on((`p`.`KD_OBAT` = `n`.`KD_OBAT`))) 
left join `civira_sikda`.`mst_dokter` `d` on((`d`.`KD_DOKTER` = `k`.`KD_DOKTER_PEMERIKSA`))) 
left join `civira_sikda`.`mst_dokter` `e` on((`e`.`KD_DOKTER` = `k`.`KD_DOKTER_PETUGAS`))) 
left join `civira_sikda`.`detail_tindakan_anak_pem_neo` `a` on((`a`.`KD_PEMERIKSAAN_NEONATUS` = `u`.`KD_PEMERIKSAAN_NEONATUS`)))
left join `civira_sikda`.`detail_tindakan_ibu_pem_neo` `i` on((`i`.`KD_PEMERIKSAAN_NEONATUS` = `u`.`KD_PEMERIKSAAN_NEONATUS`)))
left join `civira_sikda`.`kunjungan` `kunj` on((`kunj`.`ID_KUNJUNGAN` = `k`.`ID_KUNJUNGAN`)))
