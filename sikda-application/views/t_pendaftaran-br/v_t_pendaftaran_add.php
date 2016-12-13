<script type="text/javascript" src="<?=base_url()?>assets/js/date.format.js"></script>
<script>
$('document').ready(function() {		
	$('#form1t_pendaftaranadd').ajaxForm({
		beforeSend: function() {
			achtungShowLoader();
		},
		uploadProgress: function(event, position, total, percentComplete) {
		},
		complete: function(xhr) {			
			if(xhr.responseText!=='OK'){
				$.achtung({message: xhr.responseText, timeout:5});
			}else{
				$.achtung({message: 'Proses Berhasil', timeout:5});
				$("#t202","#tabs").empty();
				$("#t202","#tabs").load('t_pendaftaran'+'?_=' + (new Date()).getTime());
			}
			achtungHideLoader();
		}
	});
	
	$("#kabupaten_kotat_pendaftaranadd").remoteChained("#provinsit_pendaftaranadd", "<?=site_url('t_masters/getKabupatenByProvinceId')?>");
	$("#kecamatant_pendaftaranadd").remoteChained("#kabupaten_kotat_pendaftaranadd", "<?=site_url('t_masters/getKecamatanByKabupatenId')?>");
	$("#kelurahant_pendaftaranadd").remoteChained("#kecamatant_pendaftaranadd", "<?=site_url('t_masters/getKelurahanByKecamatanId')?>");
	$("#carabayart_pendaftaranadd").chained("#jenis_pasient_pendaftaranadd");
	
	$("#tahunlahirid").change(function() {
		getDOB();
	});

	$("#bulanlahirid").change(function() {
		getDOB();
	});
	
	$("#tanggal_lahirt_pendaftaranadd").change(function() {
		var now = new Date();

		var yearNow = now.getYear();
		var monthNow = now.getMonth();

		var dateString = $(this).val();
		var dob = new Date(dateString.substring(6,10),
						 dateString.substring(3,5)
						 );
		
		var yearDob = dob.getYear();
		var monthDob = dob.getMonth();
		
		if (monthNow >= monthDob)
			var monthAge = monthNow - monthDob;
		else {
			yearAge--;
			var monthAge = 12 + monthNow -monthDob;
		}
		
		/*if (dateNow >= dateDob)
			var dateAge = dateNow - dateDob;
		else {
			monthAge--;
			var dateAge = 31 + dateNow - dateDob;
			if (monthAge < 0) {
				monthAge = 11;
				yearAge--;
			}
		}
		 */
		
		yearAge = yearNow - yearDob;
		monthAge = monthNow - monthDob;
		
		$('#tahunlahirid').val(yearAge);
		$('#bulanlahirid').val(monthAge+1);
		$("#jeniskelaminid").focus();
	});
	
	$("#form1t_pendaftaranadd").validate({
		rules: {
			tanggal_lahir: {
				date:true,
				required: true
			},
			tanggal_daftar: {
				date:true,
				required: true
			},
			tanggal_kunjungan: {
				date:true,
				required: true
			}
		},
		messages: {
			tanggal_lahir: {
				date: "Silahkan Masukkan Tanggal Sesuai Format",
				required:"Silahkan Lengkapi Data"
			},tanggal_daftar: {
				date: "Silahkan Masukkan Tanggal Sesuai Format",
				required:"Silahkan Lengkapi Data"
			},tanggal_kunjungan: {
				date: "Silahkan Masukkan Tanggal Sesuai Format",
				required:"Silahkan Lengkapi Data"
			}
		}
	});
	
	$('#showhide_pasienbaru_kunjungan').on('change', function() {
		if($(this).val()=='rawat_jalan'){
			$('#jeniskunjunganplaceholder').empty();
			$('#jeniskunjunganplaceholder').load('t_pendaftaran/rawatjalan?_=' + (new Date()).getTime());
		}else if($(this).val()=='UGD'){
			$('#jeniskunjunganplaceholder').empty();
			$('#jeniskunjunganplaceholder').load('t_pendaftaran/ugd?_=' + (new Date()).getTime());
		}else if($(this).val()=='rawat_inap'){
			$('#jeniskunjunganplaceholder').empty();
			$('#jeniskunjunganplaceholder').load('t_pendaftaran/rawatinap?_=' + (new Date()).getTime());
		}else{
			$('#jeniskunjunganplaceholder').empty();
		}
	});

	 $('#form1t_pendaftaranadd :submit').click(function(e) {
		e.preventDefault();
        if($("#form1t_pendaftaranadd").valid()) {
			$('#form1t_pendaftaranadd').submit();
		}
		return false;
    });		
})

$("#tanggal_lahirt_pendaftaranadd").mask("99/99/9999");
$("#tanggal_daftart_pendaftaranadd").mask("99/99/9999");

$("#form1t_pendaftaranadd").validate({focusInvalid:true});

$(':text,:radio,:checkbox,select,textarea').bind("keydown", function(e) {
   var n = $(":text,:radio,:checkbox,select,textarea").length;
   if (e.which == 13) 
   {
		e.preventDefault();
		var nextIndex = $(':text,:radio,:checkbox,select,textarea').index(this) + 1;
		var thisIndex = $(':text,:radio,:checkbox,select,textarea').index(this);
		if(nextIndex < n && $(this).valid()){
			if($(this).attr('id')=='tanggal_lahirt_pendaftaranadd'){
				$('#jenis_kelamint_pendaftaranadd').focus();
			}else{
				$(':text,:radio,:checkbox,select,textarea')[nextIndex].focus();			
			}
		}else{			
			if($("#form1t_pendaftaranadd").valid()) {
				//$(':text,:radio,:checkbox,select,textarea')[nextIndex-1].blur();
				$('#form1t_pendaftaranadd').submit();
			}
			return false;
		}
   }
});

//$("#form1t_pendaftaranadd input:text").first().focus();
$("#nama_lengkapt_pendaftaranadd").focus();
</script>
<script>
	$("#form1t_pendaftaranadd input[name = 'batal'], #backlistt_pendaftaran").click(function(){
		$("#t202","#tabs").empty();
		$("#t202","#tabs").load('t_pendaftaran'+'?_=' + (new Date()).getTime());
	});
	
	function getDOB(){
        var y=0;
        var m=0;
        var dbo="";
		var yr = new Date().getFullYear()
        if ($('#tahunlahirid').val().length>0||$('#tahunlahirid').val()>0||$('#bulanlahirid').val().length>0||$('#bulanlahirid').val()>0)
            {
                y=$('#tahunlahirid').val()?parseInt($('#tahunlahirid').val()):yr;
                if ($('#bulanlahirid').val().length>0||$('#bulanlahirid').val()>0)
                    {
                        m=parseInt($('#bulanlahirid').val());
                    }

                m= y==yr?m:m +(y*12);
                dbo = dateAdd("m", -m, new Date());
                dt=dbo.format('dd/mm/yyyy');
                $('#tanggal_lahirt_pendaftaranadd').val(dt);
           
            }else{
			objDate = new Date()
			y = objDate.getFullYear();
			m = objDate.getMonth();
			d = objDate.getDate();
			today = new Date(y,m,d);
			dt = today.format('dd/mm/yyyy');
			$('#tanggal_lahirt_pendaftaranadd').val(dt);
		}
          
    }
	
	function dateAdd(datepart,number,objDate){
           y = objDate.getFullYear();
           m = objDate.getMonth();
           d = objDate.getDate();
           hr =     objDate.getHours();
           mn =     objDate.getMinutes();
           sc =     objDate.getSeconds();
           newY=y;
           newM=m;
           newD=d;
           if (datepart== 'y'){
                newY = parseInt(y) + parseInt(number);
           } else if (datepart== 'm') {
                newM = parseInt(m) + parseInt(number);
           } else {
                newD = parseInt(d) + parseInt(number);
           }
           objNewDate = new Date(newY,newM,newD);
           return objNewDate;
      }	
</script>
<div class="mycontent">
<div class="formtitle">Pendaftaran Baru</div>
<div class="backbutton"><span class="kembali" id="backlistt_pendaftaran">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="form1t_pendaftaranadd" method="post" action="<?=site_url('t_pendaftaran/addprocess')?>" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Rekam Medis</label>
		<input type="text" name="rekam_medis" id="rekammedist_pendaftaranadd" value="Otomatis" disabled />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Nama Lengkap*</label>
		<input type="text" name="nama_lengkap" id="nama_lengkapt_pendaftaranadd" value="" required  />
		</span>
		<span>
		<label>Tanggal Daftar* (dd/mm/yyyy)</label>
		<input type="text" name="tanggal_daftar" id="tanggal_daftart_pendaftaranadd" class="mydate" value="<?=date('d/m/Y')?>" required  />
		</span>
	</fieldset>	
	<fieldset>
		<span>
		<label>Tempat Lahir*</label>
		<input type="text" name="tempat_lahir" id="tempat_lahirt_pendaftaranadd" value="" required  />		
		</span>		
	</fieldset>
	<fieldset>
		<span>
		<label>Tanggal Lahir* (dd/mm/yyyy)</label>
		<input type="text" name="tanggal_lahir" id="tanggal_lahirt_pendaftaranadd" class="mydate" required  />		
		</span>
		<span>
		-
		<input type="text" name="tahun_usia" id="tahunlahirid" style="width:25px" /> Tahun
		<input type="text" name="bulan_usia" id="bulanlahirid" style="width:25px" /> Bulan
		</span>
	</fieldset>
	<?=getComboJeniskelamin('','jenis_kelamin','jenis_kelamint_pendaftaranadd','required','')?>	
	<fieldset>		
		<?=getComboJenispasien('','jenis_pasien','jenis_pasient_pendaftaranadd','required','inline')?>
		<?=getComboCarabayar('','cara_bayar','carabayart_pendaftaranadd','required','inline')?>
	</fieldset>
	<fieldset>
		<span>
		<label>No. KK</label>
		<input type="text" name="no_kk" id="no_kkt_pendaftaranadd" value="" />
		</span>
		<span>
		<label>Nama KK</label>
		<input type="text" name="nama_kk" id="nama_kkt_pendaftaranadd" value="" required />
		</span>
	</fieldset>
	<!--<fieldset>
		<span>
		<label>Asuransi</label>
		<input type="text" name="asuransi" id="asuransit_pendaftaranadd" value="" />
		</span>
		<span>
		<label>No. Asuransi</label>
		<input type="text" name="no_asuransi" id="no_asuransit_pendaftaranadd" value=""/>
		</span>
	</fieldset>
	-->
	<fieldset>
		<span>
		<label>Ket. Wilayah</label>
			<select name="wilayah">
				<option value="DW">Dalam Wilayah</option>
				<option value="LW">Luar Wilayah</option>
			</select>
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>NIK</label>
		<input type="text" name="nik" id="nik_pendaftaranadd" value="" />
		</span>
	</fieldset>
	<div class="subformtitle">Data Alamat</div>
	<fieldset>
		<span>
		<label>Alamat*</label>
		<textarea name="alamat" rows="3" cols="45" required></textarea>
		</span>
	</fieldset>
	<fieldset>
		<?=getComboProvinsi($this->session->userdata('kd_provinsi'),'provinsi','provinsit_pendaftaranadd','required','inline')?>
		<span>
		<label>Kab/Kota</label>
			<select name="kabupaten_kota" id="kabupaten_kotat_pendaftaranadd">
				<option value="">--</option>
			</select>
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Kecamatan</label>
			<select name="kecamatan" id="kecamatant_pendaftaranadd">
				<option value="">--</option>
			</select>
		</span>
		<span>
		<label>Desa/Kelurahan</label>
			<select name="desa_kelurahan" id="kelurahant_pendaftaranadd">
				<option value="">--</option>
			</select>
		</span>
	</fieldset>
	<fieldset>
		<span>
			<label>Kode Pos</label>
			<input type="text" name="kode_pos" id="kode_pos_pendaftaranadd" value="" />
		</span>
	</fieldset>
	<fieldset>
		<span>
			<label>No. Tlp</label>
			<input type="text" name="no_tlp" id="no_tlp_pendaftaranadd" value="" />
		</span>
		<span>
			<label>No. HP</label>
			<input type="text" name="no_hp" id="no_hp_pendaftaranadd" value="" />
		</span>
	</fieldset>
	
	<div class="subformtitle">Data Pribadi</div>
	<?=getComboAgama('','agama','agamat_pendaftaranadd','','')?>
	<fieldset>
		<?=getComboGoldarah('','gol_darah','gol_daraht_pendaftaranadd','','inline')?>
		<?=getComboPendidikan('','pendidikan_akhir','pendidikan_akhirt_pendaftaranadd','','inline')?>
	</fieldset>
	<fieldset>
		<?=getComboPekerjaan('','pekerjaan','pekerjaant_pendaftaranadd','','inline')?>
		<?=getComboRas('','ras_suku','ras_sukut_pendaftaranadd','','inline')?>
	</fieldset>	
	<?=getComboStatusnikah('','status_nikah','status_nikaht_pendaftaranadd','','')?>
	<div class="subformtitle">Keluarga</div>
	<fieldset>
		<span>
			<label>Nama Ayah</label>
			<input type="text" name="nama_ayah" />
		</span>
		<span>
			<label>Nama Ibu</label>
			<input type="text" name="nama_ibu" />
		</span>
	</fieldset>
	<fieldset>
		<span>
			<label>Orang yang Dapat di Hubungi</label>
			<input type="text" name="pic" />
		</span>		
	</fieldset>
	<!--<fieldset>
		<span>
			<label>Rincian Penanggung</label>
			<textarea name="rincian_penangggung" rows="2" cols="45"></textarea>
		</span>
	</fieldset>
	-->
	
	<div class="subformtitle">Daftarkan Ke Kunjungan</div>	
	<fieldset>
		<span>
		<label>Jenis Kunjungan</label>
			<select name="showhide_kunjungan" id="showhide_pasienbaru_kunjungan">
				<option value="">Pilih Jenis Kunjungan</option>
				<option value="rawat_jalan">Rawat Jalan</option>
				<option value="UGD">Unit Gawat Darurat</option>
				<option value="rawat_inap">Rawat Inap</option>
			</select>
		</span>
	</fieldset>
	<div id="jeniskunjunganplaceholder"><!-- placeholder for loaded jenis kunjungan --></div>
	<br/>
	<br/>
	<fieldset>
		<span>
		<input type="button" name="batal" value="Batal" />
		&nbsp; - &nbsp;
		<input type="submit" name="bt1" value="Proses Data"/>
		</span>
	</fieldset>	
</form>
</div >