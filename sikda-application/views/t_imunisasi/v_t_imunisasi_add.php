<style>
.ui-menu-item{
	font-size:.59em;
	color:blue!important;
}
.ui-autocomplete-category {
	font-weight: bold;
	padding: .1em .1.5em;
	margin: .8em 0 .2em;
	line-height: 1.5;
	font-size:.71em;
}
.ui-autocomplete{
	width:355px!important;
}
.inputaction1{
	width:255px;font-weight:bold;
}
.inputaction2{
	width:255px;font-weight:bold;color:#0B77B7
}
.labelaction{
	font-weight:bold;font-size:1.05em;color:#0B77B7;width:175px;
}
.declabel{width:91px}
.declabel2{width:175px}
.decinput{width:99px}
</style>
<script>
$(document).ready(function(){
	$('#form1t_imunisasi_add').ajaxForm({
			beforeSend: function() {
				achtungShowLoader();	
			},
			uploadProgress: function(event, position, total, percentComplete) {
			},
			complete: function(xhr) {
				achtungHideLoader();
				if(xhr.responseText!=='OK'){
					$.achtung({message: xhr.responseText, timeout:5});
				}else{
					$.achtung({message: 'Proses Tambah Data Berhasil', timeout:5});
					$("#t215","#tabs").empty();
					$("#t215","#tabs").load('t_imunisasi'+'?_=' + (new Date()).getTime());
				}
			}
		});	
			jQuery("#listpetugasimunisasi").jqGrid({
			datatype: 'clientSide',
			rownumbers:true,
			width: 705,
			height: 'auto',
			colNames:['Kode Petugas','Petugas','Keterangan'],
			colModel :[ 
			{name:'kd_petugas',index:'kd_petugas', width:55,align:'center',hidden:true}, 
			{name:'petugas',index:'petugas', width:100}, 
			{name:'keterangan',index:'keterangan', width:100}, 
			],
			rowNum:35,
			viewrecords: true
		});
		
		$("#kabupaten_kotat_pendaftaranadd").remoteChained("#provinsit_pendaftaranadd", "<?=site_url('t_masters/getKabupatenByProvinceId')?>");
		$("#kecamatant_pendaftaranadd").remoteChained("#kabupaten_kotat_pendaftaranadd", "<?=site_url('t_masters/getKecamatanByKabupatenId')?>");
		$("#kelurahant_pendaftaranadd").remoteChained("#kecamatant_pendaftaranadd", "<?=site_url('t_masters/getKelurahanByKecamatanId')?>");
		
		$("#tahunlahirpasienid").change(function() {
		getDOB();
		});

		$("#bulanlahirpasienid").change(function() {
			getDOB();
		});
		
		$("#tanggal_lahirt_pasienadd").change(function() {
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
			
			$('#tahunlahirpasienid').val(yearAge);
			$('#bulanlahirpasienid').val(monthAge+1);
			$("#jeniskelaminid").focus();
		});
	
		
		
		var petugasimunisasiid = 0;
		$('#tambahpetugasimunisasiid').click(function(){
			if($('#petugasimunisasisearch_tmpval').val()){
				var myfirstrow = {kd_petugas:$('#petugasimunisasisearch_tmpval').val(), petugas:$('#petugasimunisasisearch_tmptext').val(),keterangan:$('#pembinaid:checked').val()};
				jQuery("#listpetugasimunisasi").addRowData(petugasimunisasiid+1, myfirstrow);
				$('#petugasimunisasisearch').val('');
				$('#petugasimunisasisearch_tmpval').val('');
				$('#petugasimunisasisearch_tmptext').val('');
				$('#pembinaid').prop('checked',false);
				$('#pembinaid').removeProp('checked');
				if(confirm('Tambah Data Petugas Lain?')){
					$('#petugasimunisasisearch').focus();					
				}
			}else{
				alert('Silahkan Pilih Petugas.');
			}
		})
		
		$('#hapuspetugasimunisasiid').click(function(){
			jQuery("#listpetugasimunisasi").clearGridData();
		})		
		
		$('#showhide_jenis_pasien_kunjungan').on('change', function() {
			if($(this).val()=='1'){
				$('#jenispasienplaceholder').empty();
				$('#jenispasienplaceholder').load('t_imunisasi/siswa_anak_bayi_balita?_=' + (new Date()).getTime());
			}else if($(this).val()=='2'){
				$('#jenispasienplaceholder').empty();
				$('#jenispasienplaceholder').load('t_imunisasi/siswa_anak_bayi_balita?_=' + (new Date()).getTime());
			}else if($(this).val()=='3'){
				$('#jenispasienplaceholder').empty();
				$('#jenispasienplaceholder').load('t_imunisasi/siswa_anak_bayi_balita?_=' + (new Date()).getTime());
			}else if($(this).val()=='4'){
				$('#jenispasienplaceholder').empty();
				$('#jenispasienplaceholder').load('t_imunisasi/siswa_anak_bayi_balita?_=' + (new Date()).getTime());
			}else if($(this).val()=='5'){
				$('#jenispasienplaceholder').empty();
				$('#jenispasienplaceholder').load('t_imunisasi/wustidakhamil?_=' + (new Date()).getTime());
			}else if($(this).val()=='6'){
				$('#jenispasienplaceholder').empty();
				$('#jenispasienplaceholder').load('t_imunisasi/wushamil?_=' + (new Date()).getTime());
			}else if($(this).val()=='7'){
				$('#jenispasienplaceholder').empty();
				$('#jenispasienplaceholder').load('t_imunisasi/pasienbiasa_caten?_=' + (new Date()).getTime());
			}else if($(this).val()=='8'){
				$('#jenispasienplaceholder').empty();
				$('#jenispasienplaceholder').load('t_imunisasi/pasienbiasa_caten?_=' + (new Date()).getTime());
			}else{
				$('#jenispasienplaceholder').empty();
			}
		});
})

$("#form1t_imunisasi_add").validate({focusInvalid:true});

$.widget( "custom.catcomplete", $.ui.autocomplete, {
	_renderMenu: function( ul, items ) {
		var that = this,
		currentCategory = "";
		$.each( items, function( index, item ) {
		if ( item.category != currentCategory ) {
			ul.append( "<li class='ui-autocomplete-category'>" + item.category + "</li>" );
			currentCategory = item.category;
		}
			that._renderItemData( ul, item );
		});
	}
});

$('#form1t_imunisasi_add :submit').click(function(e) {
	e.preventDefault();
	if($("#form1t_imunisasi_add").valid()) {
		if(kumpularray())$('#form1t_imunisasi_add').submit();
	}
	return false;
});

$( "#petugasimunisasisearch" ).catcomplete({
	source: "t_imunisasi/petugasimunisasisource",
	minLength: 2,
	select: function( event, ui ) {
	//log( ui.item ?"Selected: " + ui.item.value + " aka " + ui.item.id :"Nothing selected, input was " + this.value );
		$('#petugasimunisasisearch_tmpval').val(ui.item.id);
		$('#petugasimunisasisearch_tmptext').val(ui.item.label);
		//$('#selectjeniskasusid').focus();
	}
});

$("#tanggalt_imunisasi_add").mask("99/99/9999");
$("#tanggal_lahirt_pasienadd").mask("99/99/9999");

$(':text,:radio,:checkbox,select,textarea').bind("keydown", function(e) {
   var n = $(":text,:radio,:checkbox,select,textarea").length;
   if (e.which == 13) 
   {
		e.preventDefault();
		var nextIndex = $(':text,:radio,:checkbox,select,textarea').index(this) + 1;
		var thisIndex = $(':text,:radio,:checkbox,select,textarea').index(this);
		if(nextIndex < n && $(this).valid()){
			if($(this).attr('id')=='petugasimunisasiid'){
				if($('#petugasimunisasisearch_tmpval').val()){
					$('#tambahpetugasimunisasiid').focus();return false;
				}else{
					$(':text,:radio,:checkbox,select,textarea')[nextIndex].focus();
				}
			}
			if($(this).attr('id')=='tanggal_lahirt_pasienadd'){
				$('#jenis_kelamint_pasienadd').focus();
			}else{
				$(':text,:radio,:checkbox,select,textarea')[nextIndex].focus();			
			}
			
		}else{			
			if($("#form1t_imunisasi_add").valid()) {
				//$(':text,:radio,:checkbox,select,textarea')[nextIndex-1].blur();
				if(kumpularray())$('#form1t_imunisasi_add').submit();
			}
			return false;
		}
   }
});
</script>

<script>
	function kumpularray(){
		if($('#listpetugasimunisasi').getGridParam("records")>0){
			var rows= jQuery("#listpetugasimunisasi").jqGrid('getRowData');
			var paras=new Array();
			for(var i=0;i<rows.length;i++){
				var row = rows[i];
				paras.push(JSON.stringify(row));
				//paras.push($.param(row));
			}
			$("#petugasimunisasi_final").val(JSON.stringify(paras));
		}
		
		if($('#listimunisasivaksin').getGridParam("records")>0){
			var rows= jQuery("#listimunisasivaksin").jqGrid('getRowData');
			var paras=new Array();
			for(var i=0;i<rows.length;i++){
				var row = rows[i];
				paras.push(JSON.stringify(row));
				//paras.push($.param(row));
			}
			$("#imunisasivaksin_final").val(JSON.stringify(paras));
		}
		return true;			
	}
</script>

<script>
	$("#form1t_imunisasi_add input[name = 'batal'], #backlistt_imunisasi").click(function(){
		$("#t215","#tabs").empty();
		$("#t215","#tabs").load('t_imunisasi'+'?_=' + (new Date()).getTime());
	});
</script>

<script>
	function getDOB(){
        var y=0;
        var m=0;
        var dbo="";
		var yr = new Date().getFullYear()
        if ($('#tahunlahirpasienid').val().length>0||$('#tahunlahirpasienid').val()>0||$('#bulanlahirpasienid').val().length>0||$('#bulanlahirpasienid').val()>0)
            {
                y=$('#tahunlahirpasienid').val()?parseInt($('#tahunlahirpasienid').val()):yr;
                if ($('#bulanlahirpasienid').val().length>0||$('#bulanlahirpasienid').val()>0)
                    {
                        m=parseInt($('#bulanlahirpasienid').val());
                    }

                m= y==yr?m:m +(y*12);
                dbo = dateAdd("m", -m, new Date());
                dt=dbo.format('dd/mm/yyyy');
                $('#tanggal_lahirt_pasienadd').val(dt);
           
            }else{
			objDate = new Date()
			y = objDate.getFullYear();
			m = objDate.getMonth();
			d = objDate.getDate();
			today = new Date(y,m,d);
			dt = today.format('dd/mm/yyyy');
			$('#tanggal_lahirt_pasienadd').val(dt);
		}
          
    }
	
	
$(':text,:radio,:checkbox,select,textarea').bind("keydown", function(e) {
   var n = $(":text,:radio,:checkbox,select,textarea").length;
   if (e.which == 13) 
   {
		e.preventDefault();
		var nextIndex = $(':text,:radio,:checkbox,select,textarea').index(this) + 1;
		var thisIndex = $(':text,:radio,:checkbox,select,textarea').index(this);
		if(nextIndex < n && $(this).valid()){
			if($(this).attr('id')=='tanggal_lahirt_pasienadd'){
				$('#jenis_kelamint_pendaftaranadd').focus();
			}else{
				$(':text,:radio,:checkbox,select,textarea')[nextIndex].focus();			
			}
		}else{			
			if($("#form1t_imunisasi_add").valid()) {
				//$(':text,:radio,:checkbox,select,textarea')[nextIndex-1].blur();
				$('#form1t_imunisasi_add').submit();
			}
			return false;
		}
   }
});
	
	$("#tanggal_lahirt_pasienadd").change(function() {
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
	
	$("#tanggal_lahirt_pasienadd").mask("99/99/9999");
	
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
$("#desat_imunisasiadd").remoteChained("#kecamatant_imunisasiadd", "<?=site_url('t_masters/getDesaByKecamatanId')?>");	  

</script>
<div class="mycontent">


<div class="formtitle">Tambah Daftar Imunisasi Luar Gedung</div>
<div class="backbutton"><span class="kembali" id="backlistt_imunisasi">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="form1t_imunisasi_add" onsubmit="bt1.disabled = true; return true;" method="post" action="<?=site_url('t_imunisasi/addprocess')?>" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Tanggal </label>
		<input type="text" name="tanggal_imunisasi" id="tanggal_imunisasi" class="mydate" value="<?=date('d/m/Y')?>" />
		</span>
	</fieldset>
	<?=getComboJenisLokasiimunisasi('','jenis_lokasi','jenis_lokasit_imunisasiadd','required','')?>	
	<fieldset>
		<span>
		<label>Nama Lokasi</label>
		<input type="text" name="namalokasi" id="namalokasi" value="" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Alamat</label>
		<textarea name="alamatlokasi" rows="3" cols="23" value="" ></textarea>
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Kecamatan</label>
			<input type="text" name="kecamatanlokasi" id="kecamatant_imunisasiadd" value="<?=$KECAMATAN?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Desa/Kelurahan</label>
			<select name="desalokasi" id="desat_imunisasiadd">
				<option value="<?=$KD_KELURAHAN?>" selected:selected ></option>
			</select>
		</span>
	</fieldset>

	<br/>
	<div class="subformtitle">Petugas</div>
	<table id="listpetugasimunisasi"></table>
	<fieldset id="fieldspetugasimunisasi">
		<span>
		<label>Cari Petugas</label>
		<input type="text" name="text" value="" id="petugasimunisasisearch" />
		</span>
		<span>
			<input type="checkbox" name="pembina" id="pembinaid" value="1">Pembina Wilayah
		</span>
		<span>
		<input type="hidden" name="petugasimunisasisearch_tmpval" id="petugasimunisasisearch_tmpval" />
		<input type="hidden" name="petugasimunisasisearch_tmptext" id="petugasimunisasisearch_tmptext" />
		<input type="hidden" name="petugasimunisasi_final" id="petugasimunisasi_final" />
		<input type="button" value="Tambah" id="tambahpetugasimunisasiid" />
		<input type="button" value="Hapus" id="hapuspetugasimunisasiid" />
		</span>
	</fieldset>
	<br/>
	<fieldset>
		<span>
		<label>Nama Pasien</label>
		<input type="text" name="nama_pasien" id="nama_pasien" value="" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Tanggal Lahir* (dd/mm/yyyy)</label>
		<input type="text" name="tanggal_lahir" id="tanggal_lahirt_pasienadd" class="mydate" />		
		</span>
		<span>
		-
		<input type="text" name="tahun_usia" id="tahunlahirpasienid" style="width:25px" /> Tahun
		<input type="text" name="bulan_usia" id="bulanlahirpasienid" style="width:25px" /> Bulan
		</span>
	</fieldset>
	<?=getComboJeniskelamin('','jenis_kelamin','jenis_kelamint_pasienadd','required','')?>
	<fieldset>
		<span>
		<label>Alamat</label>
		<textarea name="alamatpasien" rows="3" cols="23" ></textarea>
		</span>
	</fieldset>
	<?=getComboProvinsi($this->session->userdata('kd_provinsi'),'provinsipasien','provinsit_pendaftaranadd','required','')?>
	<fieldset>
	<span>
	<label>Kab/Kota</label>
		<select name="kabupaten_kotapasien" id="kabupaten_kotat_pendaftaranadd">
			<option value="">--</option>
		</select>
	</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Kecamatan</label>
			<select name="kecamatanpasien" id="kecamatant_pendaftaranadd">
				<option value="">--</option>
			</select>
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Desa/Kelurahan</label>
			<select name="desa_kelurahanpasien" id="kelurahant_pendaftaranadd">
				<option value="">--</option>
			</select>
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Jenis Pasien</label>
			<select name="showhide_jenis_pasien" id="showhide_jenis_pasien_kunjungan">
				<option value="">- silakan pilih -</option>
				<option value="1">SISWA/SISWI</option>
				<option value="2">ANAK</option>
				<option value="3">BAYI</option>
				<option value="4">BALITA</option>
				<option value="5">WUS TIDAK HAMIL</option>
				<option value="6">WUS HAMIL</option>
				<option value="7">PASIEN BIASA</option>
				<option value="8">CATEN</option>
			</select>
		</span>
	</fieldset>
	<div id="jenispasienplaceholder"><!-- placeholder for loaded jenis kunjungan --></div>
	<fieldset>
		<span>
		<label>Pemeriksaan Fisik</label>
		<textarea name="pemeriksaan_fisik" rows="3" cols="23" ></textarea>
		</span>
	</fieldset>
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