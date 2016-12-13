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
<?php if(!empty($dataibu->KD_PASIEN)){if(!empty($data_kd->KD_KUNJUNGAN_BERSALIN)){?>
<script>
	jQuery("#listkeadaanbayi").jqGrid({
	url:'t_kesehatan_ibu_dan_anak/t_keadaanxml', 
	emptyrecords: 'Nothing to display',
	datatype: "xml", 
	colNames:['Keadaan Bayi Saat Lahir'],
	rownumbers:true,
	width: 1049,
	height: 'auto',
	mtype: 'POST',
	altRows : true,	
	colModel :[ {name:'keadaan_bayi_lahir',index:'keadaan_bayi_lahir', width:801}, 
	],
		rowNum:35,
		pager: jQuery('#pagert_keadaanbayi'),
		viewrecords: true, 
		sortorder: "desc",
		beforeRequest:function(){
			id5="<?=$data_kd->KD_KUNJUNGAN_BERSALIN?>";
			$('#listkeadaanbayi').setGridParam({postData:{'myid5':id5}})
		}			
	}).navGrid('#pagert_keadaanbayi',{search:false}); 
		
	jQuery("#listasuhanbayi").jqGrid({
	url:'t_kesehatan_ibu_dan_anak/t_asuhanxml', 
	emptyrecords: 'Nothing to display',
	datatype: "xml", 
	colNames:['Asuhan Bayi Baru Lahir'],
	rownumbers:true,
	width: 1049,
	height: 'auto',
	mtype: 'POST',
	altRows : true,	
	colModel :[ 
	{name:'asuhan_bayi_lahir',index:'asuhan_bayi_lahir', width:801}, 
	],
		rowNum:35,
		pager: jQuery('#pagert_asuhanbayi'),
		viewrecords: true, 
		sortorder: "desc",
		beforeRequest:function(){
			id6='<?=$data_kd->KD_KUNJUNGAN_BERSALIN?>';
			$('#listasuhanbayi').setGridParam({postData:{'myid6':id6}})
		}			
	}).navGrid('#pagert_asuhanbayi',{search:false});
	
</script>
<?php }}?>
<script>
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
	}).change();
	
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
	}).change();
	
	$("form").validate({
	rules: {
		tanggal_lahir_ibu: {
			date:true,required: true
		},
		tanggal_lahir_ayah: {
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
				}else{
					$('#asuhanbayisearch').focus();
				}
			}else{
				alert('Silahkan Pilih Keadaan Bayi.');
			}
		});	
		
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
				}else{
					$('#ket_tambah').focus();					
				}
			}else{
				alert('Silahkan Pilih Asuhan Bayi.');
			}
		});	
		
	$('#hapuskeadaanbayiid').click(function(){
			jQuery("#listkeadaanbayi").clearGridData();
		});
		
	$('#hapusasuhanbayiid').click(function(){
			jQuery("#listasuhanbayi").clearGridData();
		});


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

	/*$('form :submit').click(function(e) {
		e.preventDefault();
		if($("form").valid()) {
			if(kumpularray())$('form').submit();
		}
		return false;
	});*/

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
				$(':text,:radio,:checkbox,select,textarea')[nextIndex].focus();			
				if($(this).attr('id')=='tanggal_lahir_ibut_registrasi_bayi_add'){
					$('#agama_ibu').focus();
				}
				if($(this).attr('id')=='tanggal_lahir_ayaht_registrasi_bayi_add'){
					$('#agama_ayah_t_registrasi_bayi_add').focus();
				}
				if($(this).attr('id')=='keadaanbayisearch'){				
					if($('#keadaanbayisearch_tmpval').val()){
						$('#tambahkeadaanbayiid').focus();return false;
					}else{
						$('#asuhanbayisearch').focus();
					}
				}
				if($(this).attr('id')=='asuhanbayisearch'){				
					if($('#asuhanbayisearch_tmpval').val()){
						$('#tambahasuhanbayiid').focus();return false;
					}else{
						$('#ket_tambah').focus();
					}
				}
				
			}else{			
				if($(this).closest("form").valid()) {
						$(this).closest("form").submit();
					}
				return false;
			}
	   }
	});

	$("#tanggal_lahir_ibut_registrasi_bayi_add").mask("99/99/9999");
	$("#tanggal_lahir_ayaht_registrasi_bayi_add").mask("99/99/9999");
	$("#anak_ket_registrasi_bayi_add").focus();

</script>
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
		
		return true;		
	}
</script>
<script>
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
<div class="subformtitle">Identitas Ibu</div>
	<fieldset>
		<span>
		<label>Nama Ibu*</label>
		<input type="text" name="nama_ibu_pasien" id="nama_ibu" value="<?=isset($dataibu->NAMA_IBU)?$dataibu->NAMA_IBU:''?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Tempat Lahir*</label>
		<input type="text" name="tempat_lahir_ibu" id="nama_ibu" value="<?=isset($dataibu->TEMPAT_LAHIR_IBU)?$dataibu->TEMPAT_LAHIR_IBU:''?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Tanggal Lahir*</label>
		<input type="text" name="tanggal_lahir_ibu" id="tanggal_lahir_ibut_registrasi_bayi_add" class="mydate" value="<?=isset($dataibu->TGL_LAHIR_IBU)?$dataibu->TGL_LAHIR_IBU:''?>" />
		</span>
		<span>
		-
		<input type="text" name="tahun_usia_ibu" id="tahunlahirid_ibu" style="width:25px" value="<?=isset($dataibu->UMUR_IBU)?$dataibu->UMUR_IBU:''?>" /> Th
		<input type="text" name="bulan_usia_ibu" id="bulanlahirid_ibu" style="width:25px" /> Bln
		</span>
	</fieldset>
	<?=getComboAgama(isset($dataibu->AGAMA_IBU)?$dataibu->AGAMA_IBU:'','agama_ibu','agama_ibu','','')?>
	<?=getComboGoldarah(isset($dataibu->DARAH_IBU)?$dataibu->DARAH_IBU:'','gol_darah_ibu','gol_darah_ibu','','')?>
	<?=getComboPendidikan(isset($dataibu->PEND_IBU)?$dataibu->PEND_IBU:'','pendidikan_ibu','pendidikan_ibu','','')?>
	<?=getComboPekerjaan(isset($dataibu->KERJA_IBU)?$dataibu->KERJA_IBU:'','pekerjaan_ibu','pekerjaan_ibu','','')?>
	<div class="subformtitle">Identitas Ayah</div>
	<fieldset>
		<span>
		<label>Nama Ayah</label>
		<input type="text" name="nama_ayah_pasien" id="nama_ayaht_registrasi_bayi_add" value="<?=isset($data->NAMA_AYAH)?$data->NAMA_AYAH:''?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Tempat Lahir</label>
		<input type="text" name="tempat_lahir_ayah" id="tempat_lahir_ayaht_registrasi_bayi_add" value="<?=isset($data->TEMPAT_LAHIR_AYAH)?$data->TEMPAT_LAHIR_AYAH:''?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Tanggal Lahir</label>
		<input type="text" name="tanggal_lahir_ayah" id="tanggal_lahir_ayaht_registrasi_bayi_add" class="mydate" value="<?=isset($data->TGL_LAHIR_AYAH)?$data->TGL_LAHIR_AYAH:''?>" />
		</span>
		<span>
		-
		<input type="text" name="tahun_usia_ayah" id="tahunlahirid_ayah" style="width:25px" value="<?=isset($data->UMUR_AYAH)?$data->UMUR_AYAH:''?>" /> Th
		<input type="text" name="bulan_usia_ayah" id="bulanlahirid_ayah" style="width:25px" /> Bln
		</span>
	</fieldset>
	<?=getComboAgama(isset($data->AGAMA_AYAH)?$data->AGAMA_AYAH:'','agama_ayah','agama_ayah_t_registrasi_bayi_add','','')?>
	<?=getComboGoldarah(isset($data->DARAH_AYAH)?$data->DARAH_AYAH:'','gol_darah_ayah','gol_darah_ayah_t_registrasi_bayi_add','','')?>
	<?=getComboPendidikan(isset($data->PEND_AYAH)?$data->PEND_AYAH:'','pendidikan_ayah','pendidikan_ayah_t_registrasi_bayi_add','','')?>
	<?=getComboPekerjaan(isset($data->KERJA_AYAH)?$data->KERJA_AYAH:'','pekerjaan_ayah','pekerjaan_ayah_t_registrasi_bayi_add','','')?>
	<?php if(!empty($dataibu->KD_PASIEN)){if(!empty($data_kd->KD_KUNJUNGAN_BERSALIN)){?>
	<div class="subformtitle">Catatan Saat Bayi Baru Lahir</div>
	<table id="listkeadaanbayi"></table>
	<div id="pagert_keadaanbayi"></div>
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
	<div id="pagert_asuhanbayi"></div>
	<fieldset id="fieldsasuhanbayi">
		<span>
		<label>Asuhan Bayi Baru Lahir</label>
		<input type="text" name="text1" value="" id="asuhanbayisearch"/>
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
		<textarea name="ket" id="ket_tambah" value="<?=isset($data_kd->KET_TAMBAHAN)?$data_kd->KET_TAMBAHAN:''?>" rows="3" cols="23"></textarea>
		</span>
	</fieldset>
	<?php }}?>
	<div id="pemeriksaanplaceholder"><!-- placeholder for loaded jenis pemeriksaan --></div>