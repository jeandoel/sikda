<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once '/../libraries/pdfclass.php';

class Surat_keterangan extends CI_Controller {

	public function index()
	{	
		$id = $this->input->get('kdpasien');
		$db = $this->load->database('sikda',TRUE);
		$nama = $db->query("SELECT NAMA_LENGKAP,KD_PASIEN FROM pasien WHERE KD_PASIEN='".$id."'")->row();
		$data['data'] = $nama;
		$this->load->helper('beries_helper');
		$this->load->view('v_cetak_skd',$data);
	}
	
	public function cetak_sk()
	{	
		$id = $this->input->get('kd_pasien')?$this->input->get('kd_pasien'):'';
		$nosu = $this->input->get('nomor_surat')?$this->input->get('nomor_surat'):'';
		$berat = $this->input->get('berat')?$this->input->get('berat'):'';
		$tinggi = $this->input->get('tinggi')?$this->input->get('tinggi'):'';
		$tensi = $this->input->get('tensi')?$this->input->get('tensi'):'';
		$sec = $this->input->get('perdetik')?$this->input->get('perdetik'):'';
		$buwar = $this->input->get('buwar')?$this->input->get('buwar'):'';
		$guna = $this->input->get('guna')?$this->input->get('guna'):'';
		$dokter = $this->input->get('dokter')?$this->input->get('dokter'):'';
		
		$db = $this->load->database('sikda',true);
		$rs = $db->query("select A.NAMA_LENGKAP,A.ALAMAT,REPLACE(REPLACE(REPLACE(Get_Age(A.TGL_LAHIR),'m',' Bln'),'y',' Th'),'d','Hr') AS UMUR, S.PEKERJAAN FROM pasien A LEFT JOIN mst_pekerjaan S ON A.KD_PEKERJAAN=S.KD_PEKERJAAN WHERE A.KD_PASIEN='".$id."'")->row();
		
		// create new PDF document
		$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('');
		$pdf->SetTitle('Surat Keterangan Dokter');
		$pdf->SetSubject('SK');
		$pdf->SetKeywords('SK, Dokter, sehat, sakit');

		$pdf->AddPage();
		// set default header data
		#$pdf->SetHeaderData('', '', 'PEMERINTAH KABUPATEN '.$this->session->userdata('nama_kabupaten').$pdf->Ln().'DINAS KESEHATAN');
		$txt = "PEMERINTAH KABUPATEN ".$this->session->userdata('nama_kabupaten')."
				DINAS KESEHATAN
				PUSKESMAS ".$this->session->userdata('puskesmas')."
				";
		$pdf->SetFont('times', 'B', 14);
		$pdf->Write($h=5, $txt, $link='', $fill=0, $align='C', $ln=true, $stretch=0, $firstline=false, $firstblock=true, $maxh=0);
		// set header and footer fonts
		$pdf->setHeaderFont(Array('times', '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		//set margins
		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

		//set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

		//set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		//set some language-dependent strings
		//$pdf->setLanguageArray($l);

		// ---------------------------------------------------------

		$style = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0));

		$pdf->Line(10, 29, 200, 29, $style);

		// set font
		$html = '<table border="0" style="width:670px;line-height:180%;">
				<tr style="font-size:13;text-align:center;">
					<th colspan="2"><b><u>SURAT KETERANGAN DOKTER</u></b></th>
				</tr>
				<tr style="text-align:center;line-height:100%;">
					<td colspan="2"><b>Nomor : '.$nosu.'</b></td>
				</tr>
				<tr>
					<td></td>
				</tr>
				<tr style="text-align:justify;"><td colspan="2"><span style="color:white;">______</span>';
		$html.=		"Yang bertanda tangan di bawah ini, kami dokter Pemerintah pada Puskesmas ".$this->session->userdata('puskesmas')." Kabupaten ".$this->session->userdata('nama_kabupaten').", menerangkan bahwa :";
		
		$html.='</td></tr>
				<tr style="text-align:justify;"><td style="width:250px;"><span style="color:white;">______</span>';
		$html.=		"Nama";
		$html.='</td><td style="width:420px;">: <b>'.$rs->NAMA_LENGKAP.'</b></td></tr>
				<tr style="text-align:justify;"><td style="width:250px;"><span style="color:white;">______</span>';
		$html.=		"Umur";
		$html.='</td><td style="width:420px;">: <b>'.$rs->UMUR.'</b></td></tr>
				<tr style="text-align:justify;"><td style="width:250px;"><span style="color:white;">______</span>';
		$html.=		"Pekerjaan";
		$html.='</td><td style="width:420px;">: <b>'.$rs->PEKERJAAN.'</b></td></tr>
				<tr style="text-align:justify;"><td style="width:250px;"><span style="color:white;">______</span>';
		$html.=		"Alamat";
		$html.='</td><td style="width:420px;">: <b>'.$rs->ALAMAT.'</b></td></tr>
				<tr style="text-align:justify;"><td colspan="2">';
		$sehat_sakit='<b><u>sehat</u></b>';
		$html.=		"Pada tanggal ".date('d-m-Y')." kami lakukan pemeriksaan dengan hasil ".$sehat_sakit.".";
		$html.='</td></tr>
				<tr style="text-align:justify;"><td colspan="2"><span style="color:white;">______</span>';
		$html.=		"Surat keterangan ini dipergunakan untuk <b>".$guna."</b>.";
		$html.='</td></tr>
				<tr style="text-align:justify;"><td colspan="2"><span style="color:white;">______</span>';
		$html.=		"Demikian surat ini kami buat sesuai dengan keadaan yang sebenarnya, terimakasih.";
		$html.='</td></tr>';
		$html.='<tr style="text-align:justify;"><td colspan="2">';
		$html.=		"<b>CATATAN :</b>";
		$html.='</td></tr>';
		$html.='<tr style="text-align:justify;"><td style="width:150px;"><span style="color:white;">______</span>';
		$html.=		"Berat Badan";
		$html.='</td><td style="width:450px;">: '.$berat.' Kg</td></tr>';
		$html.='<tr style="text-align:justify;"><td style="width:150px;"><span style="color:white;">______</span>';
		$html.=		"Tinggi Badan";
		$html.='</td><td style="width:450px;">: '.$tinggi.' Cm</td></tr>';
		$html.='<tr style="text-align:justify;"><td style="width:150px;"><span style="color:white;">______</span>';
		$html.=		"Tensi";
		$html.='</td><td style="width:450px;">: '.$tensi.'/'.$sec.'</td></tr>';
		$html.='<tr style="text-align:justify;"><td style="width:150px;"><span style="color:white;">______</span>';
		$html.=		"Buta Warna";
		if($buwar=='ya'){
			$buta = '<span style="">Ya</span>/<span style="text-decoration:line-through">Tidak</span>';
		}elseif($buwar=='tidak'){
			$buta = '<span style="text-decoration:line-through">Ya</span>/<span style="">Tidak</span>';
		}else{
			$buta = '<span style="">Ya</span>/<span style="">Tidak</span>';
		}
		$html.='</td><td style="width:450px;">: '.$buta.'</td></tr>';
		$html.='<tr style="text-align:center;"><td style="width:370px;">';
		$html.='</td><td style="width:300px;">'.$this->session->userdata('puskesmas').','.date('d-m-Y').'</td></tr>';
		$html.='<tr style="text-align:center;"><td style="width:370px;">';
		$html.='</td><td style="width:300px;">Dokter Pemeriksa</td></tr>';
		$html.='<tr style="text-align:center;"><td colspan="2"></td></tr>';
		$html.='<tr style="text-align:center;"><td colspan="2"></td></tr>';
		$html.='<tr style="text-align:center;"><td colspan="2"></td></tr>';
		$html.='<tr style="text-align:center;"><td style="width:370px;">';
		$html.='</td><td style="width:300px;"><span style="text-decoration:underlined">'.$dokter.'</span></td></tr>';
		$html.='</table>';

		// set core font
		$pdf->SetFont('times', '', 12);

		// output the HTML content
		$pdf->writeHTML($html, true, 0, true, true);

		$pdf->Ln();

		// reset pointer to the last page
		$pdf->lastPage();

		// ---------------------------------------------------------

		//Close and output PDF document
		$pdf->Output('surat keterangan sehat', 'I');
	}
	
	public function cetak_sk_sakit()
	{	
		$id = $this->input->get('kd_pasien')?$this->input->get('kd_pasien'):'';
		$nosu = $this->input->get('nomor_surat')?$this->input->get('nomor_surat'):'';
		$berat = $this->input->get('berat')?$this->input->get('berat'):'';
		$tinggi = $this->input->get('tinggi')?$this->input->get('tinggi'):'';
		$tensi = $this->input->get('tensi')?$this->input->get('tensi'):'';
		$sec = $this->input->get('perdetik')?$this->input->get('perdetik'):'';
		$buwar = $this->input->get('buwar')?$this->input->get('buwar'):'';
		$guna = $this->input->get('guna')?$this->input->get('guna'):'';
		$dokter = $this->input->get('dokter')?$this->input->get('dokter'):'';
		$dari = $this->input->get('dari')?$this->input->get('dari'):'';
		$sampai = $this->input->get('sampai')?$this->input->get('sampai'):'';
		$startTimeStamp = strtotime($dari);
		$endTimeStamp = strtotime($sampai);

		$timeDiff = abs($endTimeStamp - $startTimeStamp);

		$numberDays = $timeDiff/86400;

		// and you might want to convert to integer
		$numberDays = intval($numberDays);
		
		$db = $this->load->database('sikda',true);
		$rs = $db->query("select A.NAMA_LENGKAP,A.ALAMAT,REPLACE(REPLACE(REPLACE(Get_Age(A.TGL_LAHIR),'m',' Bln'),'y',' Th'),'d','Hr') AS UMUR, S.PEKERJAAN FROM pasien A LEFT JOIN mst_pekerjaan S ON A.KD_PEKERJAAN=S.KD_PEKERJAAN WHERE A.KD_PASIEN='".$id."'")->row();
		
		// create new PDF document
		$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('');
		$pdf->SetTitle('Surat Keterangan Sakit');
		$pdf->SetSubject('SK');
		$pdf->SetKeywords('SK, Dokter, sehat, sakit');

		$pdf->AddPage();
		// set default header data
		#$pdf->SetHeaderData('', '', 'PEMERINTAH KABUPATEN '.$this->session->userdata('nama_kabupaten').$pdf->Ln().'DINAS KESEHATAN');
		$txt = "PEMERINTAH KABUPATEN ".$this->session->userdata('nama_kabupaten')."
				DINAS KESEHATAN
				PUSKESMAS ".$this->session->userdata('puskesmas')."
				";
		$pdf->SetFont('times', 'B', 14);
		$pdf->Write($h=5, $txt, $link='', $fill=0, $align='C', $ln=true, $stretch=0, $firstline=false, $firstblock=true, $maxh=0);
		// set header and footer fonts
		$pdf->setHeaderFont(Array('times', '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		//set margins
		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

		//set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

		//set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		//set some language-dependent strings
		//$pdf->setLanguageArray($l);

		// ---------------------------------------------------------

		$style = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0));

		$pdf->Line(10, 29, 200, 29, $style);

		// set font
		$html = '<table border="0" style="width:670px;line-height:180%;">
				<tr style="font-size:13;text-align:center;">
					<th colspan="2"><b><u>SURAT KETERANGAN SAKIT</u></b></th>
				</tr>
				<tr>
					<td></td>
				</tr>
				<tr style="text-align:justify;"><td colspan="2"><span style="color:white;">______</span>';
		$html.=		"Yang bertanda tangan di bawah ini, kami dokter Pemerintah pada Puskesmas ".$this->session->userdata('puskesmas')." Kabupaten ".$this->session->userdata('nama_kabupaten').", menerangkan bahwa :";
		
		$html.='</td></tr>
				<tr style="text-align:justify;"><td style="width:250px;"><span style="color:white;">______</span>';
		$html.=		"Nama";
		$html.='</td><td style="width:420px;">: <b>'.$rs->NAMA_LENGKAP.'</b></td></tr>
				<tr style="text-align:justify;"><td style="width:250px;"><span style="color:white;">______</span>';
		$html.=		"Umur";
		$html.='</td><td style="width:420px;">: <b>'.$rs->UMUR.'</b></td></tr>
				<tr style="text-align:justify;"><td style="width:250px;"><span style="color:white;">______</span>';
		$html.=		"Pekerjaan";
		$html.='</td><td style="width:420px;">: <b>'.$rs->PEKERJAAN.'</b></td></tr>
				<tr style="text-align:justify;"><td style="width:250px;"><span style="color:white;">______</span>';
		$html.=		"Alamat";
		$html.='</td><td style="width:420px;">: <b>'.$rs->ALAMAT.'</b></td></tr>
				<tr style="text-align:justify;"><td colspan="2">';
		$sehat_sakit='<b><u>sakit</u></b>';
		$html.=		"Pada tanggal ".date('d-m-Y')." kami lakukan pemeriksaan dengan hasil ".$sehat_sakit.".";
		$html.='</td></tr>
				<tr style="text-align:justify;"><td colspan="2"><span style="color:white;">______</span>';
		$html.=		"Perlu istirahat selama <b>".($numberDays+1)."</b> Hari.";
		$html.='</td></tr>
				<tr style="text-align:justify;"><td colspan="2"><span style="color:white;">______</span>';
		$html.=		"Terhitung mulai tanggal ".$dari." sampai ".$sampai." .";
		$html.='</td></tr>';
		$html.='<tr style="text-align:justify;"><td colspan="2"><span style="color:white;">______</span>';
		$html.=		"Demikian surat ini kami buat sesuai dengan keadaan yang sebenarnya, terimakasih.";
		$html.='</td></tr>';
		$html.='<tr style="text-align:justify;"><td colspan="2">';
		$html.=		"<b>CATATAN :</b>";
		$html.='</td></tr>';
		$html.='<tr style="text-align:justify;"><td style="width:150px;"><span style="color:white;">______</span>';
		$html.=		"Berat Badan";
		$html.='</td><td style="width:450px;">: '.$berat.' Kg</td></tr>';
		$html.='<tr style="text-align:justify;"><td style="width:150px;"><span style="color:white;">______</span>';
		$html.=		"Tinggi Badan";
		$html.='</td><td style="width:450px;">: '.$tinggi.' Cm</td></tr>';
		$html.='<tr style="text-align:justify;"><td style="width:150px;"><span style="color:white;">______</span>';
		$html.=		"Tensi";
		$html.='</td><td style="width:450px;">: '.$tensi.'/'.$sec.'</td></tr>';
		$html.='<tr style="text-align:justify;"><td style="width:150px;"><span style="color:white;">______</span>';
		$html.=		"Buta Warna";
		if($buwar=='ya'){
			$buta = '<span style="">Ya</span>/<span style="text-decoration:line-through">Tidak</span>';
		}elseif($buwar=='tidak'){
			$buta = '<span style="text-decoration:line-through">Ya</span>/<span style="">Tidak</span>';
		}else{
			$buta = '<span style="">Ya</span>/<span style="">Tidak</span>';
		}
		$html.='</td><td style="width:450px;">: '.$buta.'</td></tr>';
		$html.='<tr style="text-align:center;"><td style="width:370px;">';
		$html.='</td><td style="width:300px;">'.$this->session->userdata('puskesmas').','.date('d-m-Y').'</td></tr>';
		$html.='<tr style="text-align:center;"><td style="width:370px;">';
		$html.='</td><td style="width:300px;">Dokter Pemeriksa</td></tr>';
		$html.='<tr style="text-align:center;"><td colspan="2"></td></tr>';
		$html.='<tr style="text-align:center;"><td colspan="2"></td></tr>';
		$html.='<tr style="text-align:center;"><td colspan="2"></td></tr>';
		$html.='<tr style="text-align:center;"><td style="width:370px;">';
		$html.='</td><td style="width:300px;"><span style="text-decoration:underlined">'.$dokter.'</span></td></tr>';
		$html.='</table>';

		// set core font
		$pdf->SetFont('times', '', 12);

		// output the HTML content
		$pdf->writeHTML($html, true, 0, true, true);

		$pdf->Ln();

		// reset pointer to the last page
		$pdf->lastPage();

		// ---------------------------------------------------------

		//Close and output PDF document
		$pdf->Output('surat keterangan sehat', 'I');
	}
	
}
