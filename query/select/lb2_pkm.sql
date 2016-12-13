SELECT *, 
	DATE_FORMAT($P{date1},'%d-%m-%Y') AS dt1, 
	DATE_FORMAT($P{date2},'%d-%m-%Y') AS dt2,
	TOTAL_PENERIMAAN - AWAL_KELUAR - AWAL_PEMAKAIAN - KELUAR - PEMAKAIAN AS STOK_AKHIR,
	TOTAL_PENERIMAAN - AWAL_KELUAR - AWAL_PEMAKAIAN AS PERSEDIAAN,
	AWAL_TERIMA - AWAL_KELUAR - AWAL_PEMAKAIAN AS STOK_AWAL,
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
	) AS KEPALA_PUSKESMAS 
 FROM
 (
	 SELECT 
	 	o.KD_OBAT, 
	 	o.NAMA_OBAT,
	 	h.HARGA_BELI,
	 	h.HARGA_JUAL,
	 	IFNULL(AWAL_TERIMA,0) AS AWAL_TERIMA,
	 	TOTAL_PENERIMAAN - IFNULL(AWAL_TERIMA,0) AS TERIMA,
	 	IFNULL(TOTAL_PENERIMAAN,0) AS TOTAL_PENERIMAAN,
		IFNULL(AWAL_PEMAKAIAN,0) AS AWAL_PEMAKAIAN,
		IFNULL(AWAL_KELUAR,0) AS AWAL_KELUAR,
		IFNULL(KELUAR,0) AS KELUAR,
		IFNULL(PEMAKAIAN,0) AS PEMAKAIAN
	 FROM
		( -- get obat list until that date
			SELECT td.KD_OBAT, SUM(td.JUMLAH_TERIMA) AS TOTAL_PENERIMAAN
			FROM apt_obat_terima_detail td
				LEFT JOIN apt_obat_terima t ON t.KD_TERIMA=td.KD_TERIMA
			WHERE
				t.TGL_TERIMA <= $P{date2} AND
				t.KD_PKM = $P{parameter1}
			GROUP BY td.KD_OBAT 
		)ob 
		LEFT JOIN
		( -- get total awal penerimaan for stock awal calculation
			SELECT td.KD_OBAT, SUM(td.JUMLAH_TERIMA) AS AWAL_TERIMA
			FROM apt_obat_terima_detail td
				LEFT JOIN apt_obat_terima t ON t.KD_TERIMA=td.KD_TERIMA
			WHERE
				t.TGL_TERIMA < $P{date1} AND
				t.KD_PKM = $P{parameter1}
			GROUP BY td.KD_OBAT
		)at ON ob.KD_OBAT=at.KD_OBAT
		LEFT JOIN 
		( -- get total awal pengeluaran di luar pengeluaran dari kabupaten ke puskesmas dan dari puskesmas ke apotik
			SELECT tk.KD_OBAT, IFNULL(SUM(tk.JUMLAH_KELUAR),0) AS AWAL_KELUAR
			FROM apt_obat_keluar_detail tk
				LEFT JOIN apt_obat_keluar k ON tk.KD_KELUAR_OBAT = k.KD_KELUAR_OBAT
			WHERE
				k.TGL_OBAT_KELUAR < $P{date1} AND
				k.KD_PKM = $P{parameter1} AND
				k.UNIT_APT_TO != 'APT' AND k.UNIT_APT_TO != 'PUSKESMAS'
			GROUP BY tk.KD_OBAT
		)ak ON ob.KD_OBAT=ak.KD_OBAT
		LEFT JOIN
		( -- get total awal pemakaian posting obat
			SELECT po.KD_OBAT, SUM(po.QTY) as AWAL_PEMAKAIAN
			FROM pel_ord_obat po
			WHERE
				po.KD_PUSKESMAS = $P{parameter1} AND
				po.TANGGAL < $P{date1} AND
				po.STATUS = 1
			GROUP BY po.KD_OBAT
		)ap ON ob.KD_OBAT=ap.KD_OBAT
		LEFT JOIN
		( -- get total pengeluaran updated di luar apotik
			SELECT tk.KD_OBAT, SUM(tk.JUMLAH_KELUAR) as KELUAR
			FROM apt_obat_keluar_detail tk
				INNER JOIN apt_obat_keluar k ON tk.KD_KELUAR_OBAT=k.KD_KELUAR_OBAT
			WHERE 
				(k.TGL_OBAT_KELUAR BETWEEN $P{date1} AND $P{date2}) AND
				k.KD_PKM = $P{parameter1} AND
				k.UNIT_APT_TO != 'APT' AND k.UNIT_APT_TO != 'PUSKESMAS'
			GROUP BY tk.KD_OBAT
		)k ON ob.KD_OBAT=k.KD_OBAT
		LEFT JOIN 
		( -- get pemakaian updated
			SELECT po.KD_OBAT, SUM(po.QTY) as PEMAKAIAN
			FROM pel_ord_obat po
			WHERE
				po.KD_PUSKESMAS = $P{parameter1} AND
				(po.TANGGAL BETWEEN $P{date1} AND $P{date2}) AND
				po.STATUS = 1
			GROUP BY po.KD_OBAT
		)p ON ob.KD_OBAT=p.KD_OBAT
		INNER JOIN apt_mst_obat o ON ob.KD_OBAT=o.KD_OBAT
		LEFT JOIN apt_mst_harga_obat h ON ob.KD_OBAT = h.KD_OBAT AND h.KD_MILIK_OBAT='PKM'
)por
ORDER BY NAMA_OBAT ASC;