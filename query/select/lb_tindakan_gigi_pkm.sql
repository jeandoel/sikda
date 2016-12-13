select
  COUNT(pt.KD_TINDAKAN) as JUMLAH,
  mst_produk.KD_PRODUK AS KD_PRODUK,
  mst_produk.PRODUK AS PRODUK,
  DATE_FORMAT($P{date1},'%d-%m-%Y') AS dt1,
  DATE_FORMAT($P{date2},'%d-%m-%Y') AS dt2,
  (
      SELECT PUSKESMAS
      FROM mst_puskesmas AS S
      WHERE
      KD_PUSKESMAS=$P{parameter1} LIMIT 1
  ) AS NAMA_PUSKESMAS,
  (
      SELECT IFNULL(md.NAMA,sd.NAMA_PIMPINAN)
      FROM sys_setting_def sd
      LEFT JOIN
      mst_dokter md ON md.KD_DOKTER=sd.NAMA_PIMPINAN
      WHERE
      sd.KD_PUSKESMAS=$P{parameter1} LIMIT 1
  ) AS KEPALA_PUSKESMAS,
  (
      SELECT COUNT(DISTINCT pt.KD_PASIEN)
      FROM pel_tindakan pt
      join mst_produk mp on pt.KD_TINDAKAN = mp.KD_PRODUK
      WHERE pt.KD_PUSKESMAS = $P{parameter1}
      AND (pt.TANGGAL BETWEEN $P{date1} AND $P{date2})
      AND mp.IS_ODONTOGRAM = 1
  ) AS JUMLAH_PASIEN
from pel_tindakan pt
join mst_produk on pt.KD_TINDAKAN = mst_produk.KD_PRODUK
where pt.KD_PUSKESMAS = $P{parameter1}
AND mst_produk.IS_ODONTOGRAM = 1
AND (pt.TANGGAL BETWEEN $P{date1} AND $P{date2})
group by mst_produk.KD_PRODUK
ORDER BY `pt`.`KD_TINDAKAN` ASC