SELECT
  *,
  DATE_FORMAT($P{date1},'%d-%m-%Y') AS dt1,
  DATE_FORMAT($P{date2},'%d-%m-%Y') AS dt2,
  (
      SELECT KABUPATEN
      FROM mst_kabupaten
      WHERE
      KD_KABUPATEN=$P{parameter1} LIMIT 1
  ) AS NAMA_KABUPATEN,
  (
      SELECT COUNT(DISTINCT tpgp.KD_PASIEN)
      FROM t_perawatan_gigi_pasien tpgp
      WHERE SUBSTRING(tpgp.KD_PUSKESMAS,2,4) = $P{parameter1}
      AND (tpgp.TANGGAL BETWEEN $P{date1} AND $P{date2})
  ) AS JUMLAH_PASIEN
FROM(
  SELECT
    MAX(CASE WHEN DMF = 'D' THEN JUMLAH END) DMF_D,
    MAX(CASE WHEN DMF = 'M' THEN JUMLAH END) DMF_M,
    MAX(CASE WHEN DMF = 'F' THEN JUMLAH END) DMF_F,
    '1' AS DUMMY_FOREIGN
  FROM(
    SELECT va.DMF, SUM(va.JUMLAH) AS JUMLAH
    FROM
        (
        SELECT
            CEILING(COUNT(mgs.KD_STATUS_GIGI)/mgs.JUMLAH_GIGI) AS JUMLAH,
            mgs.DMF,
            mgs.KD_STATUS_GIGI AS KD_STATUS_GIGI,
            mgs.STATUS AS NAMA_STATUS_GIGI
            FROM t_perawatan_gigi_pasien tpgp
            INNER JOIN map_gigi_permukaan mpg ON tpgp.KD_MAP_GIGI = mpg.ID
            INNER JOIN mst_gigi_status mgs ON mgs.ID_STATUS_GIGI = mpg.ID_STATUS_GIGI
            WHERE SUBSTRING(KD_PUSKESMAS,2,4) = $P{parameter1}
            AND (tpgp.TANGGAL BETWEEN $P{date1} AND $P{date2})
            GROUP BY mgs.KD_STATUS_GIGI
         )va
     GROUP BY va.DMF
  )vt
)vta
LEFT JOIN
(
  SELECT
    CEILING(COUNT(mgs.KD_STATUS_GIGI)/mgs.JUMLAH_GIGI) AS JUMLAH,
    mgs.KD_STATUS_GIGI AS KD_STATUS_GIGI,
    mgs.STATUS AS NAMA_STATUS_GIGI,
    mgs.DMF,
    '1' AS DUMMY_FOREIGN
  FROM t_perawatan_gigi_pasien tpgp
  INNER JOIN map_gigi_permukaan mpg ON tpgp.KD_MAP_GIGI = mpg.ID
  INNER JOIN mst_gigi_status mgs ON mgs.ID_STATUS_GIGI = mpg.ID_STATUS_GIGI
  WHERE SUBSTRING(KD_PUSKESMAS,2,4) = $P{parameter1}
  AND (tpgp.TANGGAL BETWEEN $P{date1} AND $P{date2})
  GROUP BY mgs.KD_STATUS_GIGI
)vtb ON vtb.DUMMY_FOREIGN=vta.DUMMY_FOREIGN