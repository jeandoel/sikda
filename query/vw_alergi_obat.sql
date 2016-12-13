select 
`a`.`ID_KUNJUNGAN` AS `ID_KUNJUNGAN`,
`a`.`KD_KUNJUNGAN` AS `KD_KUNJUNGAN`,
`a`.`KD_PUSKESMAS` AS `KD_PUSKESMAS`,
`b`.`KD_PELAYANAN` AS `KD_PELAYANAN`,
`b`.`KD_PASIEN` AS `KD_PASIEN`,
`c`.`KD_OBAT` AS `KD_OBAT`,
`d`.`NAMA_OBAT` AS `NAMA_OBAT` 
from 
(
	(
		(
			`kunjungan` `a` 
			left join `pelayanan` `b` on
			(
				(`b`.`KD_PASIEN` = `a`.`KD_PASIEN`)
			)
		) 
		left join `pasien_alergi_obt` `c` on
		(
			(
				convert (`c`.`KD_PASIEN` using utf8) = convert(`a`.`KD_PASIEN` using utf8)
			)
		)
	) 
	left join `apt_mst_obat` `d` on 
	(
		(
			`d`.`KD_OBAT` = `c`.`KD_OBAT`
		)
	)
) 
group by `a`.`KD_KUNJUNGAN`