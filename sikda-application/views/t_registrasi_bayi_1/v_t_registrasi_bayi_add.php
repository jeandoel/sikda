<script type="text/javascript" src="<?=base_url()?>assets/js/date.format.js"></script>
<script>
$(document).ready(function(){
	$('#form1t_registrasi_bayi_add').ajaxForm({
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
				$("#t362","#tabs").empty();
				$("#t362","#tabs").load('t_kematian'+'?_=' + (new Date()).getTime());
			}
		}
	});	
	
	$("#tahunlahirid_ayah").change(function() {
		getDOBayah();
	});

	$("#bulanlahirid_ayah").change(function() {
		getDOBayah();
	});
	
	$("#tanggal_lahir_ayaht_registrasi_bayi_add").change(function() {
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
		
		$('#tahunlahirid_ayah').val(yearAge);
		$('#bulanlahirid_ayah').val(monthAge+1);
	});
	
	$("#tahunlahirid_ibu").change(function() {
		getDOBibu();
	});

	$("#bulanlahirid_ibu").change(function() {
		getDOibu();
	});
	
	$("#tanggal_lahir_ibut_registrasi_bayi_add").change(function() {
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
		
		$('#tahunlahirid_ibu').val(yearAge);
		$('#bulanlahirid_ibu').val(monthAge+1);
	});
	
	$("#form1t_registrasi_bayi_add").validate({
	rules: {
		tanggal_lahir: {
			date:true,required: true
		},
		tanggal_daftar: {
			date:true,required: true
		},
		tanggal_kunjungan: {
			date:true,required: true
		}
	},
	messages: {
		tanggal_lahir_ibu: {
			date: "Silahkan Masukkan Tanggal Sesuai Format",required:"Silahkan Lengkapi Data"
		},tanggal_lahir_ayah: {
			date: "Silahkan Masukkan Tanggal Sesuai Format",required:"Silahkan Lengkapi Data"
		},tanggal_daftar: {
			date: "Silahkan Masukkan Tanggal Sesuai Format",required:"Silahkan Lengkapi Data"
		},tanggal_kunjungan: {
			date: "Silahkan Masukkan Tanggal Sesuai Format",required:"Silahkan Lengkapi Data"
		}
	}
	});
	
	jQuery("#listkeadaanbayi").jqGrid({
		datatype: 'clientSide',
		rownumbers:true,
		width: 580,
		height: 'auto',
		colNames:['Kode Keadaan Bayi Saat Lahir','Keadaan Bayi Saat Lahir'],
		colModel :[ 
		{name:'kd_keadaan_bayi_lahir',index:'kd_keadaan_bayi_lahir', width:55,align:'center',hidden:true},
		{name:'keadaan_bayi_lahir',index:'keadaan_bayi_lahir', width:801}, 
		],
		rowNum:35,
		viewrecords: true
	}); 
		
	jQuery("#listasuhanbayi").jqGrid({
		datatype: 'clientSide',
		rownumbers:true,
		width: 580,
		height: 'auto',
		colNames:['Kode Asuhan Bayi Baru Lahir','Asuhan Bayi Baru Lahir'],
		colModel :[ 
		{name:'kd_asuhan_bayi_lahir',index:'kd_asuhan_bayi_lahir', width:55,align:'center',hidden:true},
		{name:'asuhan_bayi_lahir',index:'asuhan_bayi_lahir', width:801}, 
		],
		rowNum:35,
			viewrecords: true
		}); 
		
	var keadaanbayiid = 0;
		$('#tambahkeadaanbayiid').click(function(){
			if($('#keadaanbayisearch_tmpval').val()){
				var myfirstrow = {kd_keadaan_bayi_lahir:$('#keadaanbayisearch_tmpval').val(),keadaan_bayi_lahir:$('#keadaanbayisearch_tmptext').val()};
				jQuery("#listkeadaanbayi").addRowData(keadaanbayiid+1, myfirstrow);
				$('#keadaanbayisearch').val('');
				$('#keadaanbayisearch_tmpval').val('');
				$('#keadaanbayisearch_tmptext').val('');
				if(confirm('Tambah Data Keadaan Bayi?')){
					$('#keadaanbayisearch').focus();					
				}
			}else{
				alert('Silahkan Pilih Keadaan Bayi.');
			}
		})	
		
	var asuhanbayiid = 0;
		$('#tambahasuhanbayiid').click(function(){
			if($('#asuhanbayisearch_tmpval').val()){
				var myfirstrow = {kd_asuhan_bayi_lahir:$('#asuhanbayisearch_tmpval').val(),asuhan_bayi_lahir:$('#asuhanbayisearch_tmptext').val()};
				jQuery("#listasuhanbayi").addRowData(asuhanbayiid+1, myfirstrow);
				$('#asuhanbayisearch').val('');
				$('#asuhanbayisearch_tmpval').val('');
				$('#asuhanbayisearch_tmptext').val('');
				if(confirm('Tambah Data Asuhan Bayi?')){
					$('#asuhanbayisearch').focus();					
				}
			}else{
				alert('Silahkan Pilih Asuhan Bayi.');
			}
		})	
		
	$('#hapuskeadaanbayiid').click(function(){
			jQuery("#listkeadaanbayi").clearGridData();
		})
		
	$('#hapusasuhanbayiid').click(function(){
			jQuery("#listasuhanbayi").clearGridData();
		})
});

$("#form1t_registrasi_bayi_add").validate({focusInvalid:true});

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

$('#form1t_registrasi_bayi_add :submit').click(function(e) {
	e.preventDefault();
	if($("#form1t_registrasi_bayi_add").valid()) {
		if(kumpularray())$('#form1t_registrasi_bayi_add').submit();
	}
	return false;
});

$( "#registrasiibusearch" ).catcomplete({
		source: "t_registrasi_bayi/registrasiibusource",
		minLength: 1,
		select: function( event, ui ) {
			$('#registrasiibusearch_tmpval').val(ui.item.id);
			$('#registrasiibusearch_tmptext').val(ui.item.label);
		}
});

$( "#keadaanbayisearch" ).catcomplete({
		source: "t_pendaftaran/keadaanbayisource",
		minLength: 1,
		select: function( event, ui ) {
			$('#keadaanbayisearch_tmpval').val(ui.item.id);
			$('#keadaanbayisearch_tmptext').val(ui.item.label);
		}
});

$( "#asuhanbayisearch" ).catcomplete({
		source: "t_pendaftaran/asuhanbayisource",
		minLength: 1,
		select: function( event, ui ) {
			$('#asuhanbayisearch_tmpval').val(ui.item.id);
			$('#asuhanbayisearch_tmptext').val(ui.item.label);
		}
});

$(':text,:radio,:checkbox,select,textarea').bind("keydown", function(e) {
   var n = $(":text,:radio,:checkbox,select,textarea").length;
   if (e.which == 13) 
   {
		e.preventDefault();
		var nextIndex = $(':text,:radio,:checkbox,select,textarea').index(this) + 1;
		var thisIndex = $(':text,:radio,:checkbox,select,textarea').index(this);
		if(nextIndex < n && $(this).valid()){
			if($(this).attr('id')=='selectjenisdiagnosaid'){
				if($('#keadaanbayisearch_tmpval').val()){
					$('#tambahkeadaanbayiid').focus();return false;
				}
			}
			if($(this).attr('id')){
				if($('#asuhanbayisearch_tmpval').val()){
					$('#tambahasuhanbayiid').focus();return false;
				}	
			}
			
			$(':text,:radio,:checkbox,select,textarea')[nextIndex].focus();
		}else{			
			if($("#form1t_registrasi_bayi_add").valid()) {
				if(kumpularray())$('#form1t_registrasi_bayi_add').submit();
			}
			return false;
		}
   }
});
$('#showhide_pemeriksaan_KIA').on('change', function() {
	if($(this).val()=='pemeriksaan_neonatus'){
		$('#pemeriksaanplaceholder').empty();
		$('#pemeriksaanplaceholder').load('t_registrasi_bayi/neonatus?_=' + (new Date()).getTime());
		
	}else if($(this).val()=='pemeriksaan_kesehatan_anak'){
		$('#pemeriksaanplaceholder').empty();
		$('#pemeriksaanplaceholder').load('t_registrasi_bayi/kesehatananak?_=' + (new Date()).getTime());
	}else{
		$('#pemeriksaanplaceholder').empty();
	}
});	

$("#tanggal_lahir_ibut_registrasi_bayi_add").mask("99/99/9999");
$("#tanggal_lahir_ayaht_registrasi_bayi_add").mask("99/99/9999");
$("#anak_ket_registrasi_bayi_add").focus();

</script>
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
	function kumpularray(){
		if($('#listkeadaanbayi').getGridParam("records")>0){
			var rows= jQuery("#listkeadaanbayi").jqGrid('getRowData');
			var paras=new Array();
			for(var i=0;i<rows.length;i++){
				var row = rows[i];
				paras.push(JSON.stringify(row));
			}
			$("#keadaanbayi_final").val(JSON.stringify(paras));
		}
		if($('#listasuhanbayi').getGridParam("records")>0){
			var rows= jQuery("#listasuhanbayi").jqGrid('getRowData');
			var paras=new Array();
			for(var i=0;i<rows.length;i++){
				var row = rows[i];
				paras.push(JSON.stringify(row));
			}
			$("#asuhanbayi_final").val(JSON.stringify(paras));
		}
		if($('#listprodukibu').getGridParam("records")>0){
			var rows= jQuery("#listprodukibu").jqGrid('getRowData');
			var paras=new Array();
			for(var i=0;i<rows.length;i++){
				var row = rows[i];
				paras.push(JSON.stringify(row));
			}
			$("#produkibu_final").val(JSON.stringify(paras));
		}
		
		if($('#listprodukanak').getGridParam("records")>0){
			var rows= jQuery("#listprodukanak").jqGrid('getRowData');
			var paras=new Array();
			for(var i=0;i<rows.length;i++){
				var row = rows[i];
				paras.push(JSON.stringify(row));
			}
			$("#produkanak_final").val(JSON.stringify(paras));
		}
		
		if($('#listpenyakit').getGridParam("records")>0){
			var rows= jQuery("#listpenyakit").jqGrid('getRowData');
			var paras=new Array();
			for(var i=0;i<rows.length;i++){
				var row = rows[i];
				paras.push(JSON.stringify(row));
			}
			$("#penyakit_final").val(JSON.stringify(paras));
		}
		
		if($('#listtindakan').getGridParam("records")>0){
			var rows= jQuery("#listtindakan").jqGrid('getRowData');
			var paras=new Array();
			for(var i=0;i<rows.length;i++){
				var row = rows[i];
				paras.push(JSON.stringify(row));
			}
			$("#tindakan_final").val(JSON.stringify(paras));
		}
		
		return true;		
	}
</script>
<script>
	$('#backlistt_registrasi_bayi').click(function(){
		$("#t361","#tabs").empty();
		$("#t361","#tabs").load('t_registrasi_bayi'+'?_=' + (new Date()).getTime());
	})
	
	function getDOBayah(){
        var y=0;
        var m=0;
        var dbo="";
		var yr = new Date().getFullYear()
        if ($('#tahunlahirid_ayah').val().length>0||$('#tahunlahirid_ayah').val()>0||$('#bulanlahirid_ayah').val().length>0||$('#bulanlahirid_ayah').val()>0)
            {
                y=$('#tahunlahirid_ayah').val()?parseInt($('#tahunlahirid_ayah').val()):yr;
                if ($('#bulanlahirid_ayah').val().length>0||$('#bulanlahirid_ayah').val()>0)
                    {
                        m=parseInt($('#bulanlahirid_ayah').val());
                    }

                m= y==yr?m:m +(y*12);
                dbo = dateAdd("m", -m, new Date());
                dt=dbo.format('dd/mm/yyyy');
                $('#tanggal_lahir_ayaht_registrasi_bayi_add').val(dt);
           
            }else{
			objDate = new Date()
			y = objDate.getFullYear();
			m = objDate.getMonth();
			d = objDate.getDate();
			today = new Date(y,m,d);
			dt = today.format('dd/mm/yyyy');
			$('#tanggal_lahir_ayaht_registrasi_bayi_add').val(dt);
		}
          
    }
	
	function getDOBibu(){
        var y=0;
        var m=0;
        var dbo="";
		var yr = new Date().getFullYear()
        if ($('#tahunlahirid_ibu').val().length>0||$('#tahunlahirid_ibu').val()>0||$('#bulanlahirid_ibu').val().length>0||$('#bulanlahirid_ibu').val()>0)
            {
                y=$('#tahunlahirid_ibu').val()?parseInt($('#tahunlahirid_ibu').val()):yr;
                if ($('#bulanlahirid_ibu').val().length>0||$('#bulanlahirid_ibu').val()>0)
                    {
                        m=parseInt($('#bulanlahirid_ibu').val());
                    }

                m= y==yr?m:m +(y*12);
                dbo = dateAdd("m", -m, new Date());
                dt=dbo.format('dd/mm/yyyy');
                $('#tanggal_lahir_ibut_registrasi_bayi_add').val(dt);
           
            }else{
			objDate = new Date()
			y = objDate.getFullYear();
			m = objDate.getMonth();
			d = objDate.getDate();
			today = new Date(y,m,d);
			dt = today.format('dd/mm/yyyy');
			$('#tanggal_lahir_ibut_registrasi_bayi_add').val(dt);
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
<div class="subformtitle">Form Registrasi</div>
	<fieldset>
		<span>
		<label>Anak ke*</label>
		<input type="text" name="anak_ke" id="anak_ket_registrasi_bayi_add"  value="" required/>
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Berat Lahir (gram)</label>
		<input type="text" name="berat_lahir" id="berat_lahirt_registrasi_bayi_add"  value="" required/>
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Panjang Badan (cm)</label>
		<input type="text" name="panjang_badan" id="panjang_badant_registrasi_bayi_add"  value="" required/>
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Lingkar Kepala (cm)</label>
		<input type="text" name="lingkar_kepala" id="lingkar_kepalat_registrasi_bayi_add"  value="" required/>
		</span>
	</fieldset>
	<div class="subformtitle">Identitas Ibu</div>
	<fieldset>
		<span>
		<label>Nama Ibu</label>
		<input type="text" name="nama_ibu_pasien" id="nama_ibu" value="" required/>
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Tempat Lahir</label>
		<input type="text" name="tempat_lahir_ibu" id="nama_ibu" value="" required/>
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Tanggal Lahir</label>
		<input type="text" name="tanggal_lahir_ibu" id="tanggal_lahir_ibut_registrasi_bayi_add" class="mydate" required />
		</span>
		<span>
		-
		<input type="text" name="tahun_usia_ibu" id="tahunlahirid_ibu" style="width:25px" /> Th
		<input type="text" name="bulan_usia_ibu" id="bulanlahirid_ibu" style="width:25px" /> Bln
		</span>
	</fieldset>
	<?=getComboAgama('','agama_ibu','agama_ibu','required','')?>
	<?=getComboGoldarah('','gol_darah_ibu','gol_darah_ibu','','')?>
	<?=getComboPendidikan('','pendidikan_ibu','pendidikan_ibu','','')?>
	<?=getComboPekerjaan('','pekerjaan_ibu','pekerjaan_ibu','','')?>
	<div class="subformtitle">Identitas Ayah</div>
	<fieldset>
		<span>
		<label>Nama Ayah</label>
		<input type="text" name="nama_ayah_pasien" id="nama_ayaht_registrasi_bayi_add" value="" required/>
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Tempat Lahir</label>
		<input type="text" name="tempat_lahir_ayah" id="tempat_lahir_ayaht_registrasi_bayi_add" value="" required/>
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Tanggal Lahir</label>
		<input type="text" name="tanggal_lahir_ayah" id="tanggal_lahir_ayaht_registrasi_bayi_add" class="mydate" required />
		</span>
		<span>
		-
		<input type="text" name="tahun_usia_ayah" id="tahunlahirid_ayah" style="width:25px" /> Th
		<input type="text" name="bulan_usia_ayah" id="bulanlahirid_ayah" style="width:25px" /> Bln
		</span>
	</fieldset>
	<?=getComboAgama('','agama_ayah','agama_ayah_t_registrasi_bayi_add','required','')?>
	<?=getComboGoldarah('','gol_darah_ayah','gol_darah_ayah_t_registrasi_bayi_add','','')?>
	<?=getComboPendidikan('','pendidikan_ayah','pendidikan_ayah_t_registrasi_bayi_add','','')?>
	<?=getComboPekerjaan('','pekerjaan_ayah','pekerjaan_ayah_t_registrasi_bayi_add','','')?>
	<div class="subformtitle">Catatan Saat Bayi Baru Lahir</div>
	<table id="listkeadaanbayi"></table>
	<fieldset id="fieldskeadaanbayi">
		<span>
		<label>Keadaan Bayi Saat Lahir</label>
		<input type="text" name="text" value="" id="keadaanbayisearch"/>
		</span>
		<span>
		<input type="hidden" name="keadaanbayisearch_tmpval" id="keadaanbayisearch_tmpval" />
		<input type="hidden" name="keadaanbayisearch_tmptext" id="keadaanbayisearch_tmptext" />
		<input type="hidden" name="keadaanbayi_final" id="keadaanbayi_final" />
		<input type="button" value="Tambah" id="tambahkeadaanbayiid" />
		<input type="button" id="hapuskeadaanbayiid" value="Hapus" />
		</span>
	</fieldset>
	<table id="listasuhanbayi"></table>
	<fieldset id="fieldsasuhanbayi">
		<span>
		<label>Asuhan Bayi Baru Lahir</label>
		<input type="text" name="text" value="" id="asuhanbayisearch"/>
		</span>	
		<span>
		<input type="hidden" name="asuhanbayisearch_tmpval" id="asuhanbayisearch_tmpval" />
		<input type="hidden" name="asuhanbayisearch_tmptext" id="asuhanbayisearch_tmptext" />
		<input type="hidden" name="asuhanbayi_final" id="asuhanbayi_final" />
		<input type="button" value="Tambah" id="tambahasuhanbayiid" />
		<input type="button" id="hapusasuhanbayiid" value="Hapus" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Keterangan Tambahan</label>
		<textarea name="ket" rows="3" cols="23"></textarea>
		</span>
	</fieldset>
	<div class="subformtitle">Pemeriksaan</div>
	<fieldset>
	<span>
		<label>Pilih Pemeriksaan</label>
		<select name="showhide_pemeriksaan" id="showhide_pemeriksaan_KIA">
			<option>- Silahkan Pilih -</option>
			<option value="1">Pemeriksaan Neonatus</option>
			<option value="2">Pemeriksaan Kesehatan Anak</option>
		</select>
	</span>
	</fieldset>
	<div id="pemeriksaanplaceholder"><!-- placeholder for loaded jenis pemeriksaan --></div>