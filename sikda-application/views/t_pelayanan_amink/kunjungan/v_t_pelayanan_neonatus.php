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
.declabel{width:9px}
.declabel2{width:215px}
.decinput{width:99px}
</style>

<script>
$(document).ready(function(){
		$('#form1transaksi_pemeriksaanneonatus_add').ajaxForm({
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
				$("#t203","#tabs").empty();
				$("#t203","#tabs").load('t_pelayanan'+'?_=' + (new Date()).getTime());
			}
			achtungHideLoader();
		}
		});	
		
		jQuery("#listprodukibu").jqGrid({
			datatype: 'clientSide',
			rownumbers:true,
			width: 600,
			height: 'auto',
			colNames:['Kode Produk','Tindakan Ibu'],
			colModel :[ 
			{name:'kdprodukibu',index:'kdprodukibu', width:55,align:'center',hidden:true}, 
			{name:'produkibu',index:'produkibu', width:801}
			],
			rowNum:35,
			viewrecords: true
		}); 
		
		jQuery("#listprodukanak").jqGrid({
			datatype: 'clientSide',
			rownumbers:true,
			width: 600,
			height: 'auto',
			colNames:['Kode Produk','Tindakan Bayi/Anak', 'Keterangan'],
			colModel :[ 
			{name:'kdprodukanak',index:'kdprodukanak', width:55,align:'center',hidden:true}, 
			{name:'produkanak',index:'produkanak', width:801},
			{name:'keterangan',index:'keterangan', width:300}
			],
			rowNum:35,
			viewrecords: true
		}); 
			$("#carabayaradd").chained("#jenispasienadd")
			jQuery("#listalergirawatjalan").jqGrid({
			datatype: 'clientSide',
			rownumbers:true,
			width: 1049,
			height: 'auto',
			colNames:['Kode Obat','Obat'],
			colModel :[ 
			{name:'kd_obat',index:'kd_obat', width:55,align:'center'}, 
			{name:'obat',index:'obat', width:300}
			],
			rowNum:35,
			viewrecords: true
		}); 
		
		jQuery("#listobatrawatjalan").jqGrid({
			datatype: 'clientSide',
			rownumbers:true,
			width: 1049,
			height: 'auto',
			colNames:['Kode Obat','Obat', 'Dosis','Satuan','Jumlah'],
			colModel :[ 
			{name:'kd_obat',index:'kd_obat', width:55,align:'center'}, 
			{name:'obat',index:'obat', width:300}, 
			{name:'dosis',index:'dosis', width:81}, 
			{name:'satuan_obat',index:'satuan_obat', width:81}, 
			{name:'jumlah',index:'jumlah', width:51,align:'center'}
			],
			rowNum:35,
			viewrecords: true
		});	
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			var produkibuid = 0;
		$('#tambahprodukibuid').click(function(){
			if($('#produkibusearch_tmpval').val()){
				var myfirstrow = {kdprodukibu:$('#produkibusearch_tmpval').val(), produkibu:$('#produkibusearch_tmptext').val()};
				jQuery("#listprodukibu").addRowData(produkibuid+1, myfirstrow);
				$('#produkibusearch').val('');
				$('#produkibusearch_tmptext').val('');
				$('#produkibusearch_tmpval').val('');
				if(confirm('Tambah Tindakan Lain?')){
					$('#produkibusearch').focus();					
				}
			}else{
				alert('Silahkan Pilih Tindakan.');
			}
		})
		
		var produkanakid = 0;
		$('#tambahprodukanakid').click(function(){
			if($('#produkanaksearch_tmpval').val()){
				var myfirstrow = {kdprodukanak:$('#produkanaksearch_tmpval').val(), produkanak:$('#produkanaksearch_tmptext').val(), keterangan:$('#keterangantindakanid').val()};
				jQuery("#listprodukanak").addRowData(produkanakid+1, myfirstrow);
				$('#produkanaksearch').val('');
				$('#produkanaksearch_tmptext').val('');
				$('#produkanaksearch_tmpval').val('');
				$('#keterangantindakanid').val('');
				if(confirm('Tambah Tindakan Lain?')){
					$('#produkanaksearch').focus();					
				}
			}else{
				alert('Silahkan Pilih Tindakan.');
			}
		})
		
		$('#alergiobatselectid').change(function(){
			var c = this.checked ?'checked':'unchecked';
			if(c=='checked'){
				$('#showhidealergitable').show();
				$('#obatsearchalergi').focus();
			}else{
				$('#showhidealergitable').hide();
			}
		});
		
		var obatid = 0;
		$('#tambahobatid').click(function(){
			if($('#obat_tmpval').val()){
				var myfirstrow = {kd_obat:$('#obat_tmpval').val(), obat:$('#obat_tmptext').val(), dosis:$('#dosisobatid').val(), jumlah:$('#kuantitasobatid').val(), satuan:$('#satuanobatid').val()};
				jQuery("#listobatrawatjalan").addRowData(obatid+1, myfirstrow);
				$('#obatsearch').val('');
				$('#dosisobatid').val('');
				$('#kuantitasobatid').val('');
				$('#satuan_obatid').val('');
				$('#kuantitasobatid').val('');
				$('#obat_tmptext').val('');
				$('#obat_tmpval').val('');
				if(confirm('Tambah Obat Lain?')){
					$('#obatsearch').focus();					
				}else{
					$('#statuskeluarid').focus();
				}
			}else{
				alert('Silahkan Pilih Obat.');
			}
		})
				
		var obatalergiid = 0;
		$('#tambahobatalergiid').click(function(){
			if($('#obat_tmpvalalergi').val()){
				var myfirstrow = {kd_obat:$('#obat_tmpvalalergi').val(), obat:$('#obat_tmptextalergi').val()};
				jQuery("#listalergirawatjalan").addRowData(obatalergiid+1, myfirstrow);
				$('#obatsearchalergi').val('');
				$('#obat_tmptextalergi').val('');
				$('#obat_tmpvalalergi').val('');
				if(confirm('Tambah Data Alergi Obat Lain?')){
					$('#obatsearchalergi').focus();					
				}else{
					$('#obatsearch').focus();
				}
			}else{
				alert('Silahkan Pilih Obat.');
			}
		})		
		
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$('#hapusprodukibuid').click(function(){
			jQuery("#listprodukibu").clearGridData();
		})
		
		$('#hapusprodukanakid').click(function(){
			jQuery("#listprodukanak").clearGridData();
		})
		
		$('#hapusobatid').click(function(){
			jQuery("#listobatrawatjalan").clearGridData();
		})
		
		$('#hapusobatalergiid').click(function(){
		jQuery("#listalergirawatjalan").clearGridData();
		})
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		
		$("#form1transaksi_pemeriksaanneonatus_add").validate({focusInvalid:true});

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


			$('#form1transaksi_pemeriksaanneonatus_add :submit').click(function(e) {
			e.preventDefault();
			if($("#form1transaksi_pemeriksaanneonatus_add").valid()) {
				if(kumpularray())$('#form1transaksi_pemeriksaanneonatus_add').submit();
			}
			return false;
		});

			$( "#produkibusearch" ).catcomplete({
			source: "t_pemeriksaan_neonatus/produkibusource",
			minLength: 1,
			select: function( event, ui ) {
			//log( ui.item ?"Selected: " + ui.item.value + " aka " + ui.item.id :"Nothing selected, input was " + this.value );
				$('#produkibusearch_tmpval').val(ui.item.id);
				$('#produkibusearch_tmptext').val(ui.item.label);
				//$('#selectjeniskasusid').focus();
			}
		});
		
		$( "#produkanaksearch" ).catcomplete({
			source: "t_pemeriksaan_neonatus/produkanaksource",
			minLength: 1,
			select: function( event, ui ) {
			//log( ui.item ?"Selected: " + ui.item.value + " aka " + ui.item.id :"Nothing selected, input was " + this.value );
				$('#produkanaksearch_tmpval').val(ui.item.id);
				$('#produkanaksearch_tmptext').val(ui.item.label);
				//$('#selectjeniskasusid').focus();
			}
		});
		
		$( "#obatsearch" ).catcomplete({
			source: "t_pemeriksaan_neonatus/obatsource",
			minLength: 1,
			select: function( event, ui ) {
			$('#obat_tmpval').val(ui.item.id);
			$('#obat_tmptext').val(ui.item.label);
			}
		});

		$( "#obatsearchalergi" ).catcomplete({
			source: "t_pemeriksaan_neonatus/obatsource",
			minLength: 1,
			select: function( event, ui ) {
				$('#obat_tmpvalalergi').val(ui.item.id);
				$('#obat_tmptextalergi').val(ui.item.label);
			}
		});
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		
		
		$(':text,:radio,:checkbox,select,textarea').bind("keydown", function(e) {
   var n = $(":text,:radio,:checkbox,select,textarea").length;
   if (e.which == 13) 
   {
		e.preventDefault();
		var nextIndex = $(':text,:radio,:checkbox,select,textarea').index(this) + 1;
		var thisIndex = $(':text,:radio,:checkbox,select,textarea').index(this);
		if(nextIndex < n && $(this).valid()){
			if($(this).attr('id')=='selectjenisdiagnosaid'){
				if($('#penyakitsearch_tmpval').val()){
					$('#tambahpenyakitid').focus();return false;
				}
			}
			
			
			
			if($(this).attr('id')=='kuantitasobatid'){				
				if($('#obat_tmpval').val()){
					$('#tambahobatid').focus();return false;
				}else{
					$('#statuskeluarid').focus();
				}
			}
			if($(this).attr('id')=='obatsearchalergi'){				
				if($('#obat_tmpvalalergi').val()){
					$('#tambahobatalergiid').focus();return false;
				}else{
					$('#obatsearch').focus();
				}
			}
			
			$(':text,:radio,:checkbox,select,textarea')[nextIndex].focus();
		}else{			
			if($("#form1transaksi_pemeriksaanneonatus_add").valid()) {
				if(kumpularray())$('#form1transaksi_pemeriksaanneonatus_add').submit();
			}
			return false;
		}
   }
});
		
		function kumpularray(){
		if($('#listprodukibu').getGridParam("records")>0){
			var rows= jQuery("#listprodukibu").jqGrid('getRowData');
			var paras=new Array();
			for(var i=0;i<rows.length;i++){
				var row = rows[i];
				paras.push(JSON.stringify(row));
				//paras.push($.param(row));
			}
			$("#produkibu_final").val(JSON.stringify(paras));
		}
		
		
		if($('#listprodukanak').getGridParam("records")>0){
			var rows= jQuery("#listprodukanak").jqGrid('getRowData');
			var paras=new Array();
			for(var i=0;i<rows.length;i++){
				var row = rows[i];
				paras.push(JSON.stringify(row));
				//paras.push($.param(row));
			}
			$("#produkanak_final").val(JSON.stringify(paras));
		}
		
		if($('#listobatrawatjalan').getGridParam("records")>0){
			var rows= jQuery("#listobatrawatjalan").jqGrid('getRowData');
			var paras=new Array();
			for(var i=0;i<rows.length;i++){
				var row = rows[i];
				paras.push(JSON.stringify(row));
			}
			$("#obat_final").val(JSON.stringify(paras));
		}
		
		if($('#listalergirawatjalan').getGridParam("records")>0){
			var rows= jQuery("#listalergirawatjalan").jqGrid('getRowData');
			var paras=new Array();
			for(var i=0;i<rows.length;i++){
				var row = rows[i];
				paras.push(JSON.stringify(row));
			}
			$("#alergi_final").val(JSON.stringify(paras));
		}
		
	return true;
				
	}
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	$("#form1transaksi_pemeriksaanneonatus_add").validate({
		rules: {
			tanggal_lahir: {
				date:true,
				required: true
			},
			tanggal_daftar: {
				date:true,
				required: true
			},
			tglkunjungan: {
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
			},tglkunjungan: {
				date: "Silahkan Masukkan Tanggal Sesuai Format",
				required:"Silahkan Lengkapi Data"
			}
		}
	});
	$("#tglkunjungan").mask("99/99/9999");
		
		
	$('#pemeriksaan_neonatus_id_hidden').focus(function(){
			$("#dialogcari_pemeriksaan_neonatus_id").dialog({
				autoOpen: false,
				modal:true,
				width: 1030,
				height: 405,
				buttons : {
					"Cancel" : function() {
					  $(this).dialog("close");
					}
				}
			});
			$('#dialogcari_pemeriksaan_neonatus_id').load('t_pemeriksaan_neonatus/pemeriksaanneonatuspopup?id_caller=form1transaksi_pemeriksaanneonatus_add', function() {
				$("#dialogcari_pemeriksaan_neonatus_id").dialog("open");
			});
		});	
		
		
})
</script>
<script>
	$('#backlisttransaksi_pemeriksaanneonatus').click(function(){
		$("#t203","#tabs").empty();
		$("#t203","#tabs").load('t_pelayanan'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div id="dialogcari_pemeriksaan_neonatus_id" title="Riwayat Kunjungan"></div>
<div class="formtitle">Pemeriksaan Neonatus</div>
<div class="backbutton"><span class="kembali" id="backlisttransaksi_pemeriksaanneonatus">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="form1transaksi_pemeriksaanneonatus_add" method="post" action="<?=site_url('t_pemeriksaan_neonatus/addprocess')?>" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Rekam Medis#</label>
		<input type="text" name="text" value="<?=$data->KD_PASIEN?>" disabled />
		<input type="hidden" name="kd_pasien_hidden" id="textid" value="<?=$data->KD_PASIEN?>" />
		<input type="hidden" name="kd_puskesmas_hidden" id="textid" value="<?=$data->KD_PUSKESMAS?>" />
		<input type="hidden" name="kd_kunjungan_hidden" id="textid" value="<?=$data->KD_KUNJUNGAN?>" />
		<input type="hidden" name="kd_unit_hidden" id="textid" value="<?=$data->KD_UNIT?>" />
		<input type="hidden" name="kd_urutmasuk_hidden" id="textid" value="<?=$data->URUT_MASUK?>" />
		<input type="hidden" name="showhide_kunjungan" id="textid" value="rawat_inap" />
		</span>
		<span>
		<label>NIK</label>
		<input type="text" name="text" value="<?=$data->NIK?>" disabled />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Nama Pasien</label>
		<input type="text" name="text" value="<?=$data->NAMA_PASIEN?>" disabled />
		</span>
		<span>
		<label>Golongan Darah</label>
		<input type="text" name="text" value="<?=$data->KD_GOL_DARAH?>" disabled />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Jenis Pasien</label>
		<input type="text" name="text" value="<?=$data->CUSTOMER?>" disabled />
		</span>
		<span>
		<label>Tanggal Lahir</label>
		<input type="text" name="text" value="<?=$data->TGL_LAHIR?>" disabled />
		</span>
	</fieldset>
	<div class="subformtitle">Pelayanan</div>
	<fieldset>
		<span>
		<?=getComboJenispasien('','jenispasien','jenispasienadd','required','inline')?>
		</span>
		<span>
		<?=getComboCarabayar('','carabayar','carabayaradd','required','inline')?>
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Unit Pelayanan</label>
		<input type="text" name="text" value="<?=$data->UNIT?>" disabled />
		</span>	
		<span>
		<label>Tanggal Pelayanan*</label>
		<input type="text" name="tanggal_daftar" id="tanggal_daftart_pelayananaddrj" class="mydate" value="<?=date('d/m/Y')?>" required  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Kode Pemeriksaan Neonatus</label>
		<input type="text" placeholder="Otomatis" readonly name="kodepemeriksaanneonatus" id="kodepemeriksaanneonatus" value="" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Tanggal Kunjungan</label>
		<input type="text" name="tglkunjungan" id="tglkunjungan" class="mydate" value="<?=date('d/m/Y')?>" required  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Kunjungan ke</label>
		<input type="text" name="kunjunganke" id="kunjunganke" value="" required />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Berat Badan (kg)</label>
		<input type="text" name="beratbadan" id="beratbadan" value="" required />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Panjang Badan (cm)</label>
		<input type="text" name="panjangbadan" id="panjangbadan" value="" required />
		</span>
	</fieldset>
	<table id="listprodukanak"></table>
	<fieldset id="produkanak">
		<span>
		<label class="declabel2">Memeriksa Bayi/Anak</label>
		<input type="text" name="text" value="" id="produkanaksearch" style="width:195px;"/>
		<input type="hidden" name="produkanaksearch_tmpval" id="produkanaksearch_tmpval" />
		<input type="hidden" name="produkanaksearch_tmptext" id="produkanaksearch_tmptext" />
	
		</span>
	</fieldset>	
	<fieldset>
		<span>
			<label class="declabel2">Keterangan Tindakan</label>
			<input type="text" name="keterangantindakan" id="keterangantindakanid" style="width:195px" />
			<input type="hidden" id="produkanak_final" name="produkanak_final" />
			<input type="button" value="Tambah" id="tambahprodukanakid" />
			<input type="button" value="Hapus" id="hapusprodukanakid" />	
		</span>
	</fieldset>
	<table id="listprodukibu"></table>
	<fieldset id="produkibu">
		<span>
		<label class="declabel2">Tindakan Ibu</label>
		<input type="text1" name="text1" value="" id="produkibusearch" style="width:195px;" />
		
		<input type="hidden" name="produkibusearch_tmpval" id="produkibusearch_tmpval" />
		<input type="hidden" name="produkibusearch_tmptext" id="produkibusearch_tmptext" />
		<input type="button" value="Tambah" id="tambahprodukibuid" />
		<input type="button" id="hapusprodukibuid" value="Hapus" />
		<input type="hidden" id="produkibu_final" name="produkibu_final" />
		</span>
	</fieldset>		
	<fieldset>
		<span>
		<label>Keluhan Ibu</label>
		<textarea name="keluhan" rows="2" cols="27"> </textarea> 
		</span>
	</fieldset>
	<fieldset>
		<?=getComboDokterPemeriksa('','pemeriksa','pemeriksa','required','inline')?>
	</fieldset>
	<fieldset>
		<?=getComboDokterPetugas('','petugas','petugas','required','inline')?>
	</fieldset>
	<br/>
	<div class="subformtitle">Pemberian Obat/Vitamin</div>
	<div class="subformtitle">Alergi Obat</div>
	<fieldset>
		<span>
			<label class="declabel2">Alergi Obat?</label>
			<input type="checkbox" name="alergiobat" id="alergiobatselectid" value="ya">
		</span>
	</fieldset>
	<div id="showhidealergitable" style="display:none">
	<table id="listalergirawatjalan"></table>
	<fieldset id="fieldstindakanrawatjalanalergi">
		<span>
		<label class="declabel2">Cari Obat</label>
		<input type="text" name="text" value="" id="obatsearchalergi" style="width:255px;" />
		<input type="hidden" name="obat_tmpval" id="obat_tmpvalalergi" />
			<input type="hidden" name="obat_tmptext" id="obat_tmptextalergi" />
			<input type="hidden" name="alergi_final" id="alergi_final" />
			<input type="button" value="Tambah" id="tambahobatalergiid" />
			<input type="button" value="Hapus" id="hapusobatalergiid" />
		</span>
	</fieldset>
	</div>
	<div class="subformtitle">Obat</div>
	<table id="listobatrawatjalan"></table>
	<fieldset id="fieldstindakanrawatjalan">
		<span>
		<label class="declabel2">Cari Obat</label>
		<input type="text" name="text" value="" id="obatsearch" style="width:255px;" />
		</span>
		<span>
		<label style="width:57px">Dosis</label>
			<input type="text" name="hargatindakan" id="dosisobatid" style="width:55px" />
		</span>
		<?=getComboSatuan('','satuan_obat','satuan_obat','','inline')?>
		<span>
		<label style="width:37px">Qty</label>
			<input type="text" name="kuantitastindakan" id="kuantitasobatid"  style="width:39px" />
			<input type="hidden" name="obat_tmpval" id="obat_tmpval" />
			<input type="hidden" name="obat_tmptext" id="obat_tmptext" />
			<input type="hidden" name="obat_final" id="obat_final" />
			<input type="button" value="Tambah" id="tambahobatid" />
			<input type="button" value="Hapus" id="hapusobatid" />
		</span>		
	</fieldset>
	<fieldset>
		<span>
		<input type="submit" name="bt1" value="Simpan"/>
		</span>
		<span>
	<input type="button" name="popup" id="pemeriksaan_neonatus_id_hidden" value="Riwayat Kunjungan"  />
	</span>
	</fieldset>	
</form>
</div >