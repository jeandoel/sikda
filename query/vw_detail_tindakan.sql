select 
`c`.`KD_KIA` AS `KD_KIA`,
`c`.`ID_KUNJUNGAN` AS `ID_KUNJUNGAN`,
`k`.`KD_KUNJUNGAN` AS `KD_KUNJUNGAN`,
concat(`a`.`PRODUK`,'-Rp.',`b`.`HRG_TINDAKAN`,'-Jml:',`b`.`QTY`,'-Ket:',`b`.`KETERANGAN`) AS `TINDAKAN` 
from ((((`civira_sikda`.`trans_kia` `c` 
	left join `civira_sikda`.`pelayanan` `d` on((convert(`d`.`KD_PELAYANAN` using utf8) = convert(`c`.`KD_PELAYANAN` using utf8)))) 
	left join `civira_sikda`.`pel_tindakan` `b` on((`b`.`KD_PELAYANAN` = `d`.`KD_PELAYANAN`))) 
	left join `civira_sikda`.`mst_produk` `a` on((`a`.`KD_PRODUK` = `b`.`KD_TINDAKAN`)))
	left join `civira_sikda`.`kunjungan` `k` on((`k`.`ID_KUNJUNGAN` = `c`.`ID_KUNJUNGAN`)))
