<script type="text/javascript" src="<?=base_url()?>assets/js/date.format.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/js/ajax-load-global.js"></script>
<script>
$('document').ready(function() {		
	$('#form1t_pendaftaranedit').ajaxForm({
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
	
	$("#kabupaten_kotat_pendaftaranadd").remoteChained("#provinsit_pendaftaranadd", "<?=site_url('t_masters/getKabupatenByProvinceId?kabedit=').$data->KD_KABKOTA?>");
	$("#kecamatant_pendaftaranadd").remoteChained("#kabupaten_kotat_pendaftaranadd", "<?=site_url('t_masters/getKecamatanByKabupatenId?kecedit=').$data->KD_KECAMATAN?>");
	$("#kelurahant_pendaftaranadd").remoteChained("#kecamatant_pendaftaranadd", "<?=site_url('t_masters/getKelurahanByKecamatanId?keledit=').$data->KD_KELURAHAN?>");
	$("#carabayart_pendaftaranadd").chained("#jenis_pasient_pendaftaranadd");
	
	// $("#tahunlahirid").bind("keyup",function() {
	// 	getDOB();
	// });

	// $("#bulanlahirid").bind("keyup",function() {
	// 	getDOB();
	// });

	// $("#harilahirid").bind("keyup",function() {
	// 	getDOB();
	// });
	$("#tanggal_lahirt_pendaftaranedit").bind("change keyup",function() {
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
	
	/**
	 * Custom validation function to be added to jqueryvalidation
	 * @see http://jqueryvalidation.org/documentation/
	 * @see http://jqueryvalidation.org/jQuery.validator.addMethod
	 */
	$.validator.addMethod("local_date",function(value, element){
		return value.match(/^(0?[1-9]|[12][0-9]|3[01])[\/](0?[1-9]|1[012])[\/]\d{4}$/);
	},"Silahkan masukkan tanggal yang benar");
	//------------------------------------------------------------
	
	$("#form1t_pendaftaranedit").validate({
		rules: {
			tanggal_lahir:{
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
		if($('#jenis_pasient_pendaftaranadd').val()!='0000000001' && $('#jenis_pasient_pendaftaranadd').val()!=''){
			$('#noasuransi').show();
		}else{
			$('#noasuransi').hide();
		}
	}).change();

	 $('#form1t_pendaftaranedit :submit').click(function(e) {
		e.preventDefault();
        if($("#form1t_pendaftaranedit").valid()) {
			$('#form1t_pendaftaranedit').submit();
		}
		return false;
    });		
})

$("#kode_pos_pendaftaranedit").mask("99999");
$("#no_kkt_pendaftaranedit").mask("9999999999999999");
$("#nik_pendaftaranedit").mask("9999999999999999");
$("#tanggal_lahirt_pendaftaranedit").mask("99/99/9999");
$("#tanggal_daftart_pendaftaranedit").mask("99/99/9999");

$("#form1t_pendaftaranedit").validate({focusInvalid:true});

$(':text,:radio,:checkbox,select,textarea').bind("keydown", function(e) {
   var n = $(":text,:radio,:checkbox,select,textarea").length;
   if (e.which == 13) 
   {
		e.preventDefault();
		var nextIndex = $(':text,:radio,:checkbox,select,textarea').index(this) + 1;
		var thisIndex = $(':text,:radio,:checkbox,select,textarea').index(this);
		if(nextIndex < n && $(this).valid()){
			if($(this).attr('id')=='tanggal_lahirt_pendaftaranedit'){
				$('#jenis_kelamint_pendaftaranedit').focus();
			}else{
				$(':text,:radio,:checkbox,select,textarea')[nextIndex].focus();			
			}
		}else{			
			if($("#form1t_pendaftaranedit").valid()) {
				//$(':text,:radio,:checkbox,select,textarea')[nextIndex-1].blur();
				$('#form1t_pendaftaranedit').submit();
			}
			return false;
		}
   }
});

//$("#form1t_pendaftaranedit input:text").first().focus();
//$("#nik_pendaftaranedit").focus();
$("#cmlama_pendaftaranedit").focus();
</script>
<script>
	$("#form1t_pendaftaranedit input[name = 'batal'], #backlistt_pendaftaran").click(function(){
		$("#t202","#tabs").empty();
		$("#t202","#tabs").load('t_pendaftaran'+'?_=' + (new Date()).getTime());
	});
	
	function getDOB(){
        var y=0;
        var m=0;
        var d=0;
        var dbo="";
		var yr = new Date().getFullYear()
        if ($('#tahunlahirid').val().length>0||$('#tahunlahirid').val()>0||$('#bulanlahirid').val().length>0||$('#bulanlahirid').val()>0)
            {
                y=$('#tahunlahirid').val()?parseInt($('#tahunlahirid').val()):yr;
                if ($('#bulanlahirid').val().length>0||$('#bulanlahirid').val()>0)
                    {
                        m=parseInt($('#bulanlahirid').val());
                    }

                // var tanggal_lahir = $("#tanggal_lahirt_pendaftaranedit").val();
                // if(tanggal_lahir){
                // 	var dt_tanggal_lahir = tanggal_lahir.substring(0,2);
                // 	var m_tanggal_lahir = tanggal_lahir.substring(3,5);
                // 	var y_tanggal_lahir = tanggal_lahir.substring(6,10);
                // }

                // m= y==yr?m:m +(y*12);
                // dbo = dateAdd("m", -m, new Date());
                // dt=dbo.format('dd/mm/yyyy');
                // $('#tanggal_lahirt_pendaftaranedit').val(dt);
                
                // d = $("#harilahirid").val()?parseInt($("#harilahirid").val()):d;
                
                // var dt = moment();
                // if(tanggal_lahir) dt = dt.set("date",dt_tanggal_lahir);
                // if(tanggal_lahir){
                // 	dt = dt.subtract(moment().get("date") - dt_tanggal_lahir, "days");
                // }else{
                // 	dt = dt.subtract(moment().get("date"),"days");
                // }
                
                // dt = dt.subtract(d, "days");
                // dt = dt.subtract(m, "months"); //moment month start from 0
                // dt = dt.subtract(y, "years");

                // var d = moment.duration({
                // 	days:d,
                // 	months:m,
                // 	years:y
                // });
                // console.log(d.asMilliseconds());
                // var date = moment().subtract(d.asMilliseconds(),"milliseconds");


                // console.log(dt.format("DD MM YYYY"));

                // $('#tanggal_lahirt_pendaftaranedit').val(date.format("DD/MM/YYYY"));
            }else{
				objDate = new Date()
				y = objDate.getFullYear();
				m = objDate.getMonth();
				d = objDate.getDate();
				today = new Date(y,m,d);
				var dt = today.format('dd/mm/yyyy');
				$('#tanggal_lahirt_pendaftaranedit').val(dt).trigger("keyup");
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
<div class="formtitle">Ubah Data Pasien </div>
<div class="backbutton"><span class="kembali" id="backlistt_pendaftaran">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="form1t_pendaftaranedit" method="post" action="<?=site_url('t_pendaftaran/editpasienprocess')?>" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Rekam Medis</label>
		<input type="text" name="rekam_medis" id="rekammedist_pendaftaranedit" value="Otomatis" disabled />
		<input type="hidden" name="kd_pasien" id="kd_pasien" value="<?=$data->KD_PASIEN?>" />
		<input type="text" name="cmlama" id="cmlama_pendaftaranedit" style="" value="<?=$data->CMLAMA?>" placeholder="CM Lama (Bila Ada)" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>NIK</label>
		<input type="text" name="nik" id="nik_pendaftaranedit" style="width:130px;" value="<?=$data->NO_PENGENAL?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Nama Lengkap*</label>
		<input type="text" name="nama_lengkap" id="nama_lengkapt_pendaftaranedit" value="<?=$data->NAMA_LENGKAP?>" required  />
		</span>
		<span>
		<label>Tanggal Daftar* (dd/mm/yyyy)</label>
		<input type="text" name="tanggal_daftar" id="tanggal_daftart_pendaftaranedit" class="input-datepicker mydate" value="<?=date("d/m/Y", strtotime($data->TGL_PENDAFTARAN))?>" required  />
		</span>
	</fieldset>	
	<fieldset>
		<span>
		<label>Tempat Lahir*</label>
		<input type="text" name="tempat_lahir" id="tempat_lahirt_pendaftaranedit" value="<?=$data->TEMPAT_LAHIR?>" required  />		
		</span>		
	</fieldset>
	<fieldset>
		<span>
		<label>Tanggal Lahir* (dd/mm/yyyy)</label>
		<input type="text" name="tanggal_lahir" id="tanggal_lahirt_pendaftaranedit" class="input-datepicker mydate" required value="<?=date("d/m/Y", strtotime($data->TGL_LAHIR))?>"  />		
		</span>
		<span>
		-
		<input type="text" tabindex="-1" name="tahun_usia" id="tahunlahirid" style="width:25px;" class="readonly" readonly="readonly" /> Tahun
		<input type="text" tabindex="-1" name="bulan_usia" id="bulanlahirid" style="width:25px;" class="readonly" readonly="readonly" /> Bulan
		<input type="text" tabindex="-1" name="hari_usia" id="harilahirid" style="width:25px;" class="readonly" readonly="readonly" /> Hari
		</span>
	</fieldset>
	<?=getComboJeniskelamin($data->KD_JENIS_KELAMIN,'jenis_kelamin','jenis_kelamint_pendaftaranedit','required','')?>	
	<fieldset>		
		<?=getComboJenispasien($data->KD_CUSTOMER,'jenis_pasien','jenis_pasient_pendaftaranadd','required','inline')?>
		<?=getComboCarabayar($data->CARA_BAYAR,'cara_bayar','carabayart_pendaftaranadd','required','inline')?>
		<span id="noasuransi" style="display:none">
			<label>No. Asuransi*</label>
			<input type="text" name="no_asuransi_pasien" id="no_asuransi_pasienid" value="<?=$data->NO_ASURANSI?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Nama KK*</label>
		<input type="text" name="nama_kk" id="nama_kkt_pendaftaranedit" value="<?=$data->KK?>" required />
		</span>
		<span>
		<label>No. KK</label>
		<input type="text" name="no_kk" style="width:130px;" id="no_kkt_pendaftaranedit" value="<?=$data->NO_KK?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Ket. Wilayah</label>
			<select name="wilayah">
				<option <?=$data->KET_WIL=='DW'?'SELECTED':''?> value="DW">Dalam Wilayah</option>
				<option <?=$data->KET_WIL=='LW'?'SELECTED':''?> value="LW">Luar Wilayah</option>
			</select>
		</span>
	</fieldset>
	<div class="subformtitle">Data Alamat</div>
	<fieldset>
		<span>
		<label>Alamat*</label>
		<textarea name="alamat" rows="3" cols="85" required><?=$data->ALAMAT?></textarea>
		</span>
	</fieldset>
	<fieldset>
		<?=getComboProvinsi($data->KD_PROVINSI,'provinsi','provinsit_pendaftaranadd','required','inline')?>
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
			<input type="text" name="kode_pos" style="width:40px;" id="kode_pos_pendaftaranedit" value="<?=$data->KD_POS?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
			<label>No. Tlp</label>
			<input type="number" name="no_tlp" style="width:195px;" id="no_tlp_pendaftaranedit" value="<?=$data->TELEPON?>" />
		</span>
		<span>
			<label>No. HP</label>
			<input type="number" name="no_hp" style="width:195px;" id="no_hp_pendaftaranedit" value="<?=$data->HP?>" />
		</span>
	</fieldset>
	
	<div class="subformtitle">Data Pribadi</div>
	<?=getComboAgama($data->KD_AGAMA,'agama','agamat_pendaftaranedit','','')?>
	<fieldset>
		<?=getComboGoldarah($data->KD_GOL_DARAH,'gol_darah','gol_daraht_pendaftaranedit','','inline')?>
		<?=getComboPendidikan($data->KD_PENDIDIKAN,'pendidikan_akhir','pendidikan_akhirt_pendaftaranedit','','inline')?>
	</fieldset>
	<fieldset>
		<?=getComboPekerjaan($data->KD_PEKERJAAN,'pekerjaan','pekerjaant_pendaftaranedit','','inline')?>
		<?=getComboRas($data->KD_RAS,'ras_suku','ras_sukut_pendaftaranedit','','inline')?>
	</fieldset>	
	<?=getComboStatusnikah($data->STATUS_MARITAL,'status_nikah','status_nikaht_pendaftaranedit','','')?>
	<div class="subformtitle">Keluarga</div>
	<fieldset>
		<span>
			<label>Nama Ayah</label>
			<input type="text" name="nama_ayah" value="<?=$data->NAMA_AYAH?>" />
		</span>
		<span>
			<label>Nama Ibu</label>
			<input type="text" name="nama_ibu" value="<?=$data->NAMA_IBU?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
			<label>Orang yang Dapat di Hubungi</label>
			<input type="text" name="pic" value="<?=$data->NAMA_KLG_LAIN?>" />
		</span>		
	</fieldset>
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
