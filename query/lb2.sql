SELECT 
	DATE_FORMAT($P{date1},'%d-%m-%Y') as dt1, 
	DATE_FORMAT($P{date2},'%d-%m-%Y') as dt2, 
	$P{parameter1} AS KD_PUSKESMAS,
	(
		SELECT PUSKESMAS 
		FROM mst_puskesmas AS S 
		WHERE KD_PUSKESMAS=$P{parameter1} 
		LIMIT 1
	) AS NAMA_PUSKESMAS,
	(
		SELECT md.NAMA 
		FROM sys_setting_def sd
		LEFT JOIN mst_dokter md ON md.KD_DOKTER=sd.NAMA_PIMPINAN
		WHERE sd.KD_PUSKESMAS=$P{parameter1} 
		LIMIT 1
	) AS KEPALA_PUSKESMAS, 
	I.KD_OBAT, 
	I.NAMA_OBAT,
	I.KD_SAT_KECIL,
	IFNULL	
	(
		COL_STOKAWAL,
		IFNULL
		(
			(
				SELECT SUM(JUMLAH_STOK_OBAT) 
				FROM apt_stok_obat 
				WHERE KD_OBAT=Z.KD_OBAT 
				AND KD_MILIK_OBAT='PKM' 
				AND KD_PKM=$P{parameter1}
			),0
		)
	) AS COL_STOKAWAL,
	IFNULL
	(
		COL_PENERIMAAN_APBD,'0'
	) AS COL_PENERIMAAN_APBD,
	IFNULL
	(
		COL_PERSEDIAAN_APBD,
		IFNULL
		(
			(
				SELECT SUM(JUMLAH_STOK_OBAT) 
				FROM apt_stok_obat 
				WHERE KD_OBAT=Z.KD_OBAT 
				AND KD_MILIK_OBAT='PKM' 
				AND KD_PKM=$P{parameter1}
			),0
		)
	) 
	AS COL_PERSEDIAAN_APBD,
	IFNULL
	(
		COL_PEMAKAIAN_APBD,'0'
	) AS COL_PEMAKAIAN_APBD,
	IFNULL
	(
		COL_STOKAKHIR_APBD,
		IFNULL
		(
			(
				SELECT SUM(JUMLAH_STOK_OBAT) 
				FROM apt_stok_obat 
				WHERE KD_OBAT=Z.KD_OBAT 
				AND KD_MILIK_OBAT='PKM' 
				AND KD_PKM=$P{parameter1}
			),0
		)
	) AS COL_STOKAKHIR_APBD, 
	IFNULL
	(
		(
			SELECT R.HARGA_BELI 
			FROM apt_mst_harga_obat R 
			WHERE R.KD_OBAT=Z.KD_OBAT 
			LIMIT 1
		),0
	) 
	AS HARGA_BELI,
	IFNULL
	(
		(
			SELECT D.HARGA_JUAL 
			FROM apt_mst_harga_obat D 
			WHERE D.KD_OBAT=Z.KD_OBAT 
			LIMIT 1
		),0
	) AS HARGA_JUAL
	
FROM apt_stok_obat Z 
LEFT JOIN 
(
	SELECT
		A.KD_OBAT,  
		A.KD_MILIK_OBAT,
		SUM(
			IF(
				HEADER_STOKAWAL='STOKAWAL'
				, 
					A.QTY + IFNULL
					(
						(
							SELECT 
							SUM(JUMLAH_STOK_OBAT) 
							FROM apt_stok_obat 
							WHERE KD_OBAT=A.KD_OBAT 
							AND KD_MILIK_OBAT='PKM' 
							AND KD_PKM=$P{parameter1}
						),0
					) - IFNULL
					(
						(
							SELECT 
							SUM(DISTINCT c.JUMLAH_TERIMA) AS total 
							FROM apt_obat_terima_detail c 
							JOIN apt_obat_terima a ON a.`KD_TERIMA`=c.`KD_TERIMA` 
							WHERE a.`UNIT_APT_FROM`='KABUPATEN' 
							AND A.KD_OBAT=c.KD_OBAT 
							AND a.KD_PKM=$P{parameter1} 
							AND 
								(a.`TGL_TERIMA` BETWEEN $P{date1} AND $P{date2})
						),0
					)
				,0
			)
		) AS `COL_STOKAWAL`,
		SUM(
			IF(
				HEADER='PENERIMAAN'
				, 
					IFNULL
					(
						(
							SELECT SUM(DISTINCT c.JUMLAH_TERIMA) 
							AS total 
							FROM apt_obat_terima_detail c 
							JOIN apt_obat_terima a ON a.`KD_TERIMA`=c.`KD_TERIMA` 
							WHERE a.`UNIT_APT_FROM`='KABUPATEN' 
							AND A.KD_OBAT=c.KD_OBAT 
							AND (
								a.`TGL_TERIMA` BETWEEN $P{date1} AND $P{date2}
							) 
							AND a.KD_PKM=$P{parameter1}
						),0
					)
				,0
			)
		) AS `COL_PENERIMAAN_APBD`,
		SUM(
			IF
			(
				HEADER_PERSEDIAAN='PERSEDIAAN'
				,  
					A.QTY + IFNULL
					(
						(
							SELECT SUM(JUMLAH_STOK_OBAT) 
							FROM apt_stok_obat 
							WHERE KD_OBAT=A.KD_OBAT 
							AND KD_MILIK_OBAT='PKM' 
							AND KD_PKM=$P{parameter1}
						),0
					)
				,0
			)
		) AS `COL_PERSEDIAAN_APBD`,
		SUM(
			IF(HEADER_PEMAKAIAN='PEMAKAIAN' , A.QTY, 0)
		) AS `COL_PEMAKAIAN_APBD`,
		SUM(
			IF(
				HEADER_STOKAKHIR='STOKAKHIR' 
				, 
					(
						SELECT SUM(JUMLAH_STOK_OBAT) 
						FROM apt_stok_obat 
						WHERE KD_OBAT=A.KD_OBAT 
						AND KD_MILIK_OBAT='PKM' 
						AND KD_PKM=$P{parameter1}
					)
				,0
			)
		) AS `COL_STOKAKHIR_APBD`
	FROM 
	(
		SELECT 
			V.KD_PUSKESMAS, 
			V.KD_OBAT, 
			V.NAMA_OBAT, 
			V.KD_MILIK_OBAT,
			'STOKAWAL' AS `HEADER_STOKAWAL`,
			'PENERIMAAN' AS `HEADER`,
			'PERSEDIAAN' AS `HEADER_PERSEDIAAN`,
			'PEMAKAIAN' AS `HEADER_PEMAKAIAN`,
			'STOKAKHIR' AS `HEADER_STOKAKHIR`,
			SUM(QTY) AS `QTY` 
		FROM vw_rpt_obat AS V 
		WHERE 
			(TGL_PELAYANAN BETWEEN $P{date1} AND $P{date2}) 
			AND V.KD_PUSKESMAS = $P{parameter1}
		GROUP BY 
			V.KD_PUSKESMAS, 
			V.KD_OBAT, 
			V.NAMA_OBAT, 
			V.KD_MILIK_OBAT
	) A  
	GROUP BY
		A.KD_OBAT, 
		A.KD_MILIK_OBAT
) P ON Z.`KD_OBAT`=P.KD_OBAT 
LEFT JOIN apt_mst_obat I ON I.KD_OBAT=Z.KD_OBAT 
WHERE Z.`KD_PKM` = $P{parameter1} 
AND Z.`KD_MILIK_OBAT`='PKM' 
GROUP BY Z.`KD_OBAT`
ORDER BY I.NAMA_OBAT