select
  COUNT(pt.KD_TINDAKAN) as JUMLAH,
  mst_produk.KD_PRODUK AS KD_PRODUK,
  mst_produk.PRODUK AS PRODUK,
  DATE_FORMAT($P{date1},'%d-%m-%Y') AS dt1,
  DATE_FORMAT($P{date2},'%d-%m-%Y') AS dt2,
  (
      SELECT KABUPATEN
      FROM mst_kabupaten
      WHERE
      KD_KABUPATEN=$P{parameter1} LIMIT 1
  ) AS NAMA_KABUPATEN,
  (
      SELECT COUNT(DISTINCT pt.KD_PASIEN)
      FROM pel_tindakan pt
      join mst_produk mp on pt.KD_TINDAKAN = mp.KD_PRODUK
      where SUBSTRING(pt.KD_PUSKESMAS,2,4) = $P{parameter1}
      AND (pt.TANGGAL BETWEEN $P{date1} AND $P{date2})
      AND mp.IS_ODONTOGRAM = 1
  ) AS JUMLAH_PASIEN
from pel_tindakan pt
join mst_produk on pt.KD_TINDAKAN = mst_produk.KD_PRODUK
where SUBSTRING(pt.KD_PUSKESMAS,2,4) = $P{parameter1}
AND mst_produk.IS_ODONTOGRAM = 1
AND (pt.TANGGAL BETWEEN $P{date1} AND $P{date2})
group by mst_produk.KD_PRODUK
ORDER BY `pt`.`KD_TINDAKAN` ASC