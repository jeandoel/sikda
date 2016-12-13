<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tmp_Testing extends CI_Controller {
	public function index(){

		$db = $this->load->database('sikda', TRUE);

		$date1 = "2014-10-26";
		$date2 = "2014-10-28";
		$kd_kabupaten = "1704";
		$kd_puskesmas = "";

		$query_total_awal_terima = " SELECT 
			o.KD_OBAT, o.NAMA_OBAT, SUM(td.JUMLAH_TERIMA) as TOTAL_TERIMA
			FROM apt_obat_terima_detail td
				INNER JOIN apt_obat_terima t ON td.KD_TERIMA=t.KD_TERIMA
				INNER JOIN apt_mst_obat o ON td.KD_OBAT=o.KD_OBAT
			WHERE 
				t.TGL_TERIMA < '$date1' AND
				-- t.KD_PKM = '$kd_puskesmas'
				t.KD_KABUPATEN = '$kd_kabupaten'
			GROUP BY td.KD_OBAT
		";
		$result_awal_terima = $db->query($query_total_awal_terima)->result();

		$query_total_awal_keluar = " SELECT
			o.KD_OBAT, o.NAMA_OBAT, SUM(tk.JUMLAH_KELUAR) as TOTAL_KELUAR
			FROM apt_obat_keluar_detail tk
				INNER JOIN apt_obat_keluar k ON tk.KD_KELUAR_OBAT=k.KD_KELUAR_OBAT
				INNER JOIN apt_mst_obat o ON tk.KD_OBAT=o.KD_OBAT
			WHERE 
				k.TGL_OBAT_KELUAR < '$date1' AND
				k.KD_KABUPATEN = '$kd_kabupaten' AND
				(CASE WHEN
					k.UNIT_APT_FROM = 'PUSKESMAS' 
					THEN k.UNIT_APT_TO != 'APT'
					ELSE 1 -- needed
				END)
			GROUP BY tk.KD_OBAT
		";
		$result_awal_keluar = $db->query($query_total_awal_keluar)->result();

		$query_total_awal_pemakaian = " SELECT
			o.KD_OBAT, o.NAMA_OBAT, SUM(po.QTY) as TOTAL_PEMAKAIAN
			FROM pel_ord_obat po
				INNER JOIN apt_mst_obat o ON po.KD_OBAT=o.KD_OBAT
			WHERE
				po.KD_KABUPATEN = '$kd_kabupaten' AND
				po.TANGGAL < '$date1' AND
				po.STATUS = 1
			GROUP BY po.KD_OBAT
		";
		$result_awal_pemakaian = $db->query($query_total_awal_pemakaian)->result();

		$query_penerimaan = " SELECT
			o.KD_OBAT, o.NAMA_OBAT, SUM(td.JUMLAH_TERIMA) as TOTAL_TERIMA
			FROM apt_obat_terima_detail td
				INNER JOIN apt_obat_terima t ON td.KD_TERIMA=t.KD_TERIMA
				INNER JOIN apt_mst_obat o ON td.KD_OBAT=o.KD_OBAT
			WHERE 
				(t.TGL_TERIMA BETWEEN '$date1' AND '$date2') AND
				t.KD_KABUPATEN = '$kd_kabupaten'
			GROUP BY td.KD_OBAT
		";
		$result_penerimaan = $db->query($query_penerimaan)->result();

		$query_pengeluaran = " SELECT
			o.KD_OBAT, o.NAMA_OBAT, SUM(tk.JUMLAH_KELUAR) as TOTAL_KELUAR
			FROM apt_obat_keluar_detail tk
				INNER JOIN apt_obat_keluar k ON tk.KD_KELUAR_OBAT=k.KD_KELUAR_OBAT
				INNER JOIN apt_mst_obat o ON tk.KD_OBAT=o.KD_OBAT
			WHERE 
				(k.TGL_OBAT_KELUAR BETWEEN '$date1' AND '$date2') AND
				k.KD_KABUPATEN = '$kd_kabupaten' AND
				(CASE WHEN
					k.UNIT_APT_FROM = 'PUSKESMAS' 
					THEN k.UNIT_APT_TO != 'APT'
					ELSE 1 -- needed
				END)
			GROUP BY tk.KD_OBAT
		";
		$result_pengeluaran = $db->query($query_pengeluaran)->result();

		$query_pemakaian = "SELECT
			o.KD_OBAT, o.NAMA_OBAT, SUM(po.QTY) as TOTAL_PEMAKAIAN
			FROM pel_ord_obat po
				INNER JOIN apt_mst_obat o ON po.KD_OBAT=o.KD_OBAT
			WHERE
				po.KD_KABUPATEN = '$kd_kabupaten' AND
				(po.TANGGAL BETWEEN '$date1' AND '$date2') AND
				po.STATUS = 1
			GROUP BY po.KD_OBAT
		";
		$result_pemakaian = $db->query($query_pemakaian)->result();

		$stock = array();
		foreach ($result_awal_terima as $a):
			$stock[$a->KD_OBAT] = array(
					'NAMA_OBAT'=>$a->NAMA_OBAT,
					'QTY'=>$a->TOTAL_TERIMA
				);
		endforeach;

		foreach($result_awal_keluar as $a):
			$stock[$a->KD_OBAT]['QTY']=$stock[$a->KD_OBAT]['QTY']-$a->TOTAL_KELUAR;
		endforeach;

		foreach($result_awal_pemakaian as $a):
			$stock[$a->KD_OBAT]['QTY']=$stock[$a->KD_OBAT]['QTY']-$a->TOTAL_PEMAKAIAN;
		endforeach;

		foreach($result_penerimaan as $b):
			if(array_key_exists($b->KD_OBAT, $stock)){
				$stock[$b->KD_OBAT]['QTY']=$stock[$b->KD_OBAT]['QTY']+$b->TOTAL_TERIMA;
			}else{
				$stock[$b->KD_OBAT] = array(
					'NAMA_OBAT'=>$b->NAMA_OBAT,
					'QTY'=>$b->TOTAL_TERIMA
				);
			}
		endforeach;

		foreach($result_pengeluaran as $b):
			$stock[$b->KD_OBAT]['QTY']=$stock[$b->KD_OBAT]['QTY']-$b->TOTAL_KELUAR;
		endforeach;

		foreach($result_pemakaian as $b):
			$stock[$b->KD_OBAT]['QTY']=$stock[$b->KD_OBAT]['QTY']-$b->TOTAL_PEMAKAIAN;
		endforeach;

		$data =  array(
				'items_terima'=>$result_awal_terima,
				'items_keluar'=>$result_awal_keluar,
				'items_pemakaian'=>$result_awal_pemakaian,
				'penerimaan'=>$result_penerimaan,
				'pengeluaran'=>$result_pengeluaran,
				'pemakaian'=>$result_pemakaian,
				'stock'=>$stock
			);

		$combined_query = " SELECT *,
								DATE_FORMAT($date1,'%d-%m-%Y') AS dt1, 
								DATE_FORMAT($date2,'%d-%m-%Y') AS dt2,
								TOTAL_PENERIMAAN - AWAL_KELUAR - AWAL_PEMAKAIAN - KELUAR - PEMAKAIAN AS STOK_AKHIR,
								TOTAL_PENERIMAAN - AWAL_KELUAR - AWAL_PEMAKAIAN AS PERSEDIAAN,
								AWAL_TERIMA - AWAL_KELUAR - AWAL_PEMAKAIAN AS STOK_AWAL,
								(
									SELECT KABUPATEN
										FROM mst_kabupaten
										WHERE 
											KD_KABUPATEN='$kd_kabupaten' LIMIT 1
								) AS NAMA_KABUPATEN
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
							t.TGL_TERIMA <= '$date2' AND
							t.KD_KABUPATEN = '$kd_kabupaten'
						GROUP BY td.KD_OBAT 
					)ob 
					LEFT JOIN
					( -- get total awal penerimaan for stock awal calculation
						SELECT td.KD_OBAT, SUM(td.JUMLAH_TERIMA) AS AWAL_TERIMA
						FROM apt_obat_terima_detail td
							LEFT JOIN apt_obat_terima t ON t.KD_TERIMA=td.KD_TERIMA
						WHERE
							t.TGL_TERIMA < '$date1' AND
							t.KD_KABUPATEN = '$kd_kabupaten'
						GROUP BY td.KD_OBAT
					)at ON ob.KD_OBAT=at.KD_OBAT
					LEFT JOIN 
					( -- get total awal pengeluaran di luar pengeluaran dari kabupaten ke puskesmas dan dari puskesmas ke apotik
						SELECT tk.KD_OBAT, IFNULL(SUM(tk.JUMLAH_KELUAR),0) AS AWAL_KELUAR
						FROM apt_obat_keluar_detail tk
							LEFT JOIN apt_obat_keluar k ON tk.KD_KELUAR_OBAT = k.KD_KELUAR_OBAT
						WHERE
							k.TGL_OBAT_KELUAR < '$date1' AND
							k.KD_KABUPATEN = '$kd_kabupaten' AND
							(CASE WHEN
								k.UNIT_APT_FROM = 'PUSKESMAS' 
								THEN k.UNIT_APT_TO != 'APT'
								ELSE 1 -- needed
							END)
						GROUP BY tk.KD_OBAT
					)ak ON ob.KD_OBAT=ak.KD_OBAT
					LEFT JOIN
					( -- get total awal pemakaian posting obat
						SELECT po.KD_OBAT, SUM(po.QTY) as AWAL_PEMAKAIAN
						FROM pel_ord_obat po
						WHERE
							po.KD_KABUPATEN = '$kd_kabupaten' AND
							po.TANGGAL < '$date1' AND
							po.STATUS = 1
						GROUP BY po.KD_OBAT
					)ap ON ob.KD_OBAT=ap.KD_OBAT
					LEFT JOIN
					( -- get total pengeluaran updated di luar apotik
						SELECT tk.KD_OBAT, SUM(tk.JUMLAH_KELUAR) as KELUAR
						FROM apt_obat_keluar_detail tk
							INNER JOIN apt_obat_keluar k ON tk.KD_KELUAR_OBAT=k.KD_KELUAR_OBAT
						WHERE 
							(k.TGL_OBAT_KELUAR BETWEEN '$date1' AND '$date2') AND
							k.KD_KABUPATEN = '$kd_kabupaten' AND
							(CASE WHEN
								k.UNIT_APT_FROM = 'PUSKESMAS' 
								THEN k.UNIT_APT_TO != 'APT'
								ELSE 1 -- needed
							END)
						GROUP BY tk.KD_OBAT
					)k ON ob.KD_OBAT=k.KD_OBAT
					LEFT JOIN 
					( -- get pemakaian updated
						SELECT po.KD_OBAT, SUM(po.QTY) as PEMAKAIAN
						FROM pel_ord_obat po
						WHERE
							po.KD_KABUPATEN = '$kd_kabupaten' AND
							(po.TANGGAL BETWEEN '$date1' AND '$date2') AND
							po.STATUS = 1
						GROUP BY po.KD_OBAT
					)p ON ob.KD_OBAT=p.KD_OBAT
					INNER JOIN apt_mst_obat o ON ob.KD_OBAT=o.KD_OBAT
					LEFT JOIN apt_mst_harga_obat h ON ob.KD_OBAT = h.KD_OBAT AND h.KD_MILIK_OBAT='PKM'
			)por
			ORDER BY NAMA_OBAT ASC
		";
		$combined_result = $db->query($combined_query)->result();
		// echo $db->last_query();

		$data['combined']=$combined_result;

		$this->load->view('tmp_testing',$data);
	}
}