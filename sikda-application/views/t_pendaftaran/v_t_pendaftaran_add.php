<script type="text/javascript" src="<?=base_url()?>assets/js/date.format.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/js/ajax-load-global.js"></script>
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
	
	// $("#tahunlahirid").bind("keyup",function() {
	// 	getDOB();
	// });

	// $("#bulanlahirid").bind("keyup",function() {
	// 	getDOB();
	// });
	
	$("#tanggal_lahirt_pendaftaranadd").bind("change keyup",function() {
		var now = moment();
		
		var dateString = $(this).val();
		var dob = moment([
				dateString.substring(6,10),
				parseInt(dateString.substring(3,5)-1), //moment month start from 0
				dateString.substring(0,2)
			]);
		
		var duration_ms = now.diff(dob);
		var d = moment.duration(duration_ms);

		var dayAge = d.days();
		var monthAge = d.months();
		var yearAge = d.years();

		// monthAge%=12;
		
		var incorrectYear = parseInt(dateString.substring(6,10))<1000;
		if(incorrectYear || isNaN(yearAge)) yearAge="";
		if(incorrectYear || isNaN(monthAge)) monthAge="";
		if(incorrectYear || isNaN(dayAge)) dayAge="";

		$("#harilahirid").val(dayAge);
		$('#tahunlahirid').val(yearAge);
		$('#bulanlahirid').val(monthAge);
		$("#jeniskelaminid").focus();
	}).keyup();
	$("#tanggal_lahirt_pendaftaranadd").bind("change",function(){
		$(this).trigger("keyup");
	})
	
	/**
	 * Custom validation function to be added to jqueryvalidation
	 * @see http://jqueryvalidation.org/documentation/
	 * @see http://jqueryvalidation.org/jQuery.validator.addMethod
	 */
	$.validator.addMethod("local_date",function(value, element){
		return value.match(/^(0?[1-9]|[12][0-9]|3[01])[\/](0?[1-9]|1[012])[\/]\d{4}$/);
	},"Silahkan masukkan tanggal yang benar");
	//------------------------------------------------------------
	
	$("#form1t_pendaftaranadd").validate({
		rules: {
			tanggal_lahir: {
				local_date:true,
				required: true
			},
			tanggal_daftar: {
				local_date:true,
				required: true
			},
			tanggal_kunjungan: {
				local_date:true,
				required: true
			}
		},
		messages: {
			tanggal_lahir: {
				local_date: "Silahkan Masukkan Tanggal Sesuai Format",
				required:"Silahkan Lengkapi Data"
			},tanggal_daftar: {
				local_date: "Silahkan Masukkan Tanggal Sesuai Format",
				required:"Silahkan Lengkapi Data"
			},tanggal_kunjungan: {
				local_date: "Silahkan Masukkan Tanggal Sesuai Format",
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

	$('#jenis_pasient_pendaftaranadd').on('change', function() {
		if($('#jenis_pasient_pendaftaranadd').val()!='0000000001' && $('#jenis_pasient_pendaftaranadd').val()!=""){
			$('#noasuransi').show();
		}else{
			$('#noasuransi').hide();
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

$("#kode_pos_pendaftaranadd").mask("99999");
$("#no_kkt_pendaftaranadd").mask("9999999999999999");
$("#nik_pendaftaranadd").mask("9999999999999999");
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
//$("#nik_pendaftaranadd").focus();
$("#cmlama_pendaftaranadd").focus();
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
                // y=$('#tahunlahirid').val()?parseInt($('#tahunlahirid').val()):yr;
                // if ($('#bulanlahirid').val().length>0||$('#bulanlahirid').val()>0)
                //     {
                //         m=parseInt($('#bulanlahirid').val());
                //     }

                // var tanggal_lahir = $("#tanggal_lahirt_pendaftaranadd").val();
                // if(tanggal_lahir){
                // 	var dt_tanggal_lahir = tanggal_lahir.substring(0,2);
                // }

                // m= y==yr?m:m +(y*12);
                // dbo = dateAdd("m", -m, new Date());
                // // dt=dbo.format('dd/mm/yyyy');
                // // $('#tanggal_lahirt_pendaftaranedit').val(dt);
                
                // var dt = moment().subtract(m, "months");
                // if(tanggal_lahir) dt = dt.set("date",dt_tanggal_lahir);
                // $('#tanggal_lahirt_pendaftaranadd').val(dt.format("DD/MM/YYYY"));
           
            }else{
				objDate = new Date()
				y = objDate.getFullYear();
				m = objDate.getMonth();
				d = objDate.getDate();
				today = new Date(y,m,d);
				dt = today.format('dd/mm/yyyy');
				$('#tanggal_lahirt_pendaftaranadd').val(dt).trigger("keyup");
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
<form name="frApps" id="form1t_pendaftaranadd" method="post" onsubmit="bt1.disabled = true; return true;" action="<?=site_url('t_pendaftaran/addprocess')?>" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Rekam Medis</label>
		<input type="text" name="rekam_medis" id="rekammedist_pendaftaranadd" value="Otomatis" disabled />
		<input type="text" name="cmlama" id="cmlama_pendaftaranadd" style="" value="" placeholder="CM Lama (Bila Ada)" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>NIK</label>
		<input type="text" name="nik" id="nik_pendaftaranadd" style="width:130px;" value="" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Nama Lengkap*</label>
		<input type="text" name="nama_lengkap" id="nama_lengkapt_pendaftaranadd" value="" required  />
		</span>
		<span>
		<label>Tanggal Daftar* (dd/mm/yyyy)</label>
		<input type="text" name="tanggal_daftar" id="tanggal_daftart_pendaftaranadd" class="input-datepicker mydate" value="<?=date('d/m/Y')?>" required  />
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
		<input type="text" name="tanggal_lahir" id="tanggal_lahirt_pendaftaranadd" class="input-datepicker mydate" required  />		
		</span>
		<span>
		-
		<input type="text" tabindex="-1" name="tahun_usia" id="tahunlahirid" style="width:25px;" class="readonly" readonly="readonly" /> Tahun
		<input type="text" tabindex="-1" name="bulan_usia" id="bulanlahirid" style="width:25px;" class="readonly" readonly="readonly" /> Bulan
		<input type="text" tabindex="-1" name="hari_usia" id="harilahirid" style="width:25px;" class="readonly" readonly="readonly" /> Hari
		</span>
	</fieldset>
	<?=getComboJeniskelamin('','jenis_kelamin','jenis_kelamint_pendaftaranadd','required','')?>	
	<fieldset>		
		<?=getComboJenispasien('','jenis_pasien','jenis_pasient_pendaftaranadd','required','inline')?>
		<?=getComboCarabayar('','cara_bayar','carabayart_pendaftaranadd','required','inline')?>
		<span id="noasuransi" style="display:none">
			<label>No. Asuransi*</label>
			<input type="text" name="no_asuransi_pasien" id="no_asuransi_pasienid" value="" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Nama KK*</label>
		<input type="text" name="nama_kk" id="nama_kkt_pendaftaranadd" value="" required />
		</span>
		<span>
		<label>No. KK</label>
		<input type="text" name="no_kk" style="width:130px;" id="no_kkt_pendaftaranadd" value="" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Ket. Wilayah</label>
			<select name="wilayah">
				<option value="DW">Dalam Wilayah</option>
				<option value="LW">Luar Wilayah</option>
			</select>
		</span>
	</fieldset>
	<div class="subformtitle">Data Alamat</div>
	<fieldset>
		<span>
		<label>Alamat*</label>
		<textarea name="alamat" rows="3" cols="85" required></textarea>
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
			<input type="text" name="kode_pos" style="width:40px;" id="kode_pos_pendaftaranadd" value="" />
		</span>
	</fieldset>
	<fieldset>
		<span>
			<label>No. Tlp</label>
			<input type="number" name="no_tlp" style="width:195px;" id="no_tlp_pendaftaranadd" value="" />
		</span>
		<span>
			<label>No. HP</label>
			<input type="number" name="no_hp" style="width:195px;" id="no_hp_pendaftaranadd" value="" />
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
	
	<div class="subformtitle">Daftarkan Ke Kunjungan</div>	
	<fieldset>
		<span>
		<label>Jenis Kunjungan</label>
			<select name="showhide_kunjungan" id="showhide_pasienbaru_kunjungan">
				<option value="">Pilih Jenis Kunjungan</option>
				<option value="rawat_jalan">Rawat Jalan</option>
				<!--<option value="UGD">Unit Gawat Darurat</option>-->
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
