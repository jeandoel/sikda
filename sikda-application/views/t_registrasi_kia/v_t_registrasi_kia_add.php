<script>
	$("#nama_suamit_registrasi_kiaadd").focus();
	
	$("#tahunlahirid_suami").change(function() {
		getDOBsuami();
	});

	$("#bulanlahirid_suami").change(function() {
		getDOBsuami();
	});
	
	$("#tanggal_lahirt_registrasi_kiaadd").change(function() {
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
		
		yearAge = yearNow - yearDob;
		monthAge = monthNow - monthDob;
		
		$('#tahunlahirid_suami').val(yearAge);
		$('#bulanlahirid_suami').val(monthAge+1);
	}).change();
	
	$("form").validate({
		rules: {
			tanggal_lahir_suami: {
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
			tanggal_lahir_suami: {
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
	
	$("#tanggal_lahirt_registrasi_kiaadd").mask("99/99/9999");
	$("#tanggal_daftart_registrasi_kiaadd").mask("99/99/9999");
	
	$(':text,:radio,:checkbox,select,textarea').bind("keydown", function(e) {
	   var n = $(":text,:radio,:checkbox,select,textarea").length;
	   if (e.which == 13) 
	   {
			e.preventDefault();
			var nextIndex = $(':text,:radio,:checkbox,select,textarea').index(this) + 1;
			var thisIndex = $(':text,:radio,:checkbox,select,textarea').index(this);
			if(nextIndex < n && $(this).valid()){
				if($(this).attr('id')=='tanggal_lahirt_registrasi_kiaadd'){
					$('#agamat_registrasi_kiaadd').focus();
				}else{
					$(':text,:radio,:checkbox,select,textarea')[nextIndex].focus();			
				}
			}else{			
				if($(this).closest("form").valid()) {
						$(this).closest("form").submit();
					}
				return false;
			}
	   }
	});
</script>
<script>
	function getDOBsuami(){
        var y=0;
        var m=0;
        var dbo="";
		var yr = new Date().getFullYear()
        if ($('#tahunlahirid_suami').val().length>0||$('#tahunlahirid_suami').val()>0||$('#bulanlahirid_suami').val().length>0||$('#bulanlahirid_suami').val()>0)
            {
                y=$('#tahunlahirid_suami').val()?parseInt($('#tahunlahirid_suami').val()):yr;
                if ($('#bulanlahirid_suami').val().length>0||$('#bulanlahirid_suami').val()>0)
                    {
                        m=parseInt($('#bulanlahirid_suami').val());
                    }

                m= y==yr?m:m +(y*12);
                dbo = dateAdd("m", -m, new Date());
                dt=dbo.format('dd/mm/yyyy');
                $('#tanggal_lahirt_registrasi_kiaadd').val(dt);
           
            }else{
			objDate = new Date()
			y = objDate.getFullYear();
			m = objDate.getMonth();
			d = objDate.getDate();
			today = new Date(y,m,d);
			dt = today.format('dd/mm/yyyy');
			$('#tanggal_lahirt_registrasi_kiaadd').val(dt);
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
<div>
	<div id="showhide_pemeriksaan_ibu">
	<div class="subformtitle">Identitas Suami</div>
	<fieldset>
		<span>
		<label>Nama Suami</label>
		<input type="text" name="nama_suami" id="nama_suamit_registrasi_kiaadd" value="<?=isset($data->NAMA_SUAMI)?$data->NAMA_SUAMI:''?>" />
		</span>
	</fieldset>	
	<fieldset>
		<span>
		<label>Tempat Lahir</label>
		<input type="text" name="tempat_lahir_suami" id="tempat_lahirt_registrasi_kiaadd" value="<?=isset($data->TEMPAT_LAHIR)?$data->TEMPAT_LAHIR:''?>" />		
		</span>		
	</fieldset>
	<fieldset>
		<span>
		<label>Tanggal Lahir (dd/mm/yyyy)</label>
		<input type="text" name="tanggal_lahir_suami" id="tanggal_lahirt_registrasi_kiaadd" class="mydate" value="<?=isset($data->TGL_LAHIR)?$data->TGL_LAHIR:''?>" date/>		
		</span>
		<span>
		-
		<input type="text" name="tahun_usia_suami" id="tahunlahirid_suami" value="<?=isset($data->UMUR)?$data->UMUR:''?>" style="width:25px" /> Th
		<input type="text" name="bulan_usia_suami" id="bulanlahirid_suami" style="width:25px" /> Bln
		</span>
	</fieldset>
		<?=getComboAgama(isset($data->KD_AGAMA)?$data->KD_AGAMA:'','agama_suami','agamat_registrasi_kiaadd','','')?>			
		<?=getComboGoldarah(isset($data->KD_GOL_DARAH)?$data->KD_GOL_DARAH:'','gol_darah_suami','gol_daraht_registrasi_kiaadd','','')?>
		<?=getComboPendidikan(isset($data->KD_PENDIDIKAN)?$data->KD_PENDIDIKAN:'','pendidikan_suami','pendididkant_registrasi_kiaadd','','')?>
		<?=getComboPekerjaan(isset($data->KD_PEKERJAAN)?$data->KD_PEKERJAAN:'','pekerjaan_suami','pekerjaant_registrasi_kiaadd','','')?>
	</fieldset>
</div>
<div id="showhide_pemeriksaan_anak"><!-- placeholder for loaded jenis KIA --></div>