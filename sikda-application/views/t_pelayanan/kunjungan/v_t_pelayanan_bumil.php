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
//$('#tanggal_kembaliid').datepicker({dateFormat: "dd/mm/yy",changeYear: true});
//$("#tanggal_kembaliid").mask("99/99/9999");
$(document).ready(function(){
	$('#hphthpl').datepicker({
		dateFormat:'dd-mm-yy',
		maxDate: '0',
		onSelect: function(date) {
			$('#hpht').show();
			var dt = date.split('-').reverse().join('-');
			//var rumus = <?=date('d-m-Y',strtotime('+7 days, -3 months, +1 year'))?>;
			/*var hpa = new Date(dt);//alert(hpa);
			var hpl = hpa.setMonth(hpa.getMonth()+10,hpa.getDate()+7);
			hps = new Date(hpl);
			var y = hps.getFullYear(), m = hps.getMonth(), d = hps.getDate();
			$('#hpht').val(d+'-'+m+'-'+y);*/
			gethpl(dt);
			umurhamil($('#hphthpl').val());
			$('#tinggi_fundus_ibu_hamil').focus();
		}
	});
	$('#form1t_kunjungan_ibu_hamil_add').ajaxForm({
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
				$("#t203","#tabs").empty();
				$("#t203","#tabs").load('t_pelayanan'+'?_=' + (new Date()).getTime());
			}
		}
	})
	
	$("#carabayart_kunjungan_bumiladd").chained("#jenis_pasient_kunjungan_bumiladd");
		
	jQuery("#listtindakanibuhamil").jqGrid({
		datatype: 'clientSide',
		rownumbers:true,
		width: 1049,
		height: 'auto',
		colNames:['Kode Tindakan','Tindakan', 'Harga','Jumlah','Keterangan'],
		colModel :[ 
		{name:'kd_tindakan',index:'kd_tindakan', width:55,align:'center'}, 
		{name:'tindakan',index:'tindakan', width:300}, 
		{name:'harga',index:'harga', width:81}, 
		{name:'jumlah',index:'jumlah', width:51,align:'center'},
		{name:'keterangan',index:'keterangan', width:400}
		],
		rowNum:35,
		viewrecords: true
	});

	jQuery("#listobatibuhamil").jqGrid({
		datatype: 'clientSide',
		rownumbers:true,
		width: 1049,
		height: 'auto',
		colNames:['Kode Obat','Obat', 'Dosis','Satuan','Harga','Jumlah'],
		colModel :[ 
		{name:'kd_obat',index:'kd_obat', width:55,align:'center'}, 
		{name:'obat',index:'obat', width:300}, 
		{name:'dosis',index:'dosis', width:81}, 
		{name:'satuan',index:'satuan', width:81},
		{name:'harga',index:'harga', width:81},
		{name:'jumlah',index:'jumlah', width:51,align:'center'}
		],
		rowNum:35,
		viewrecords: true
	});
		
	jQuery("#listalergiibuhamil").jqGrid({
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
	
	jQuery("#listdiagnosarawatjalan").jqGrid({
		datatype: 'clientSide',
		rownumbers:true,
		width: 1049,
		height: 'auto',
		colNames:['Kode Penyakit','Penyakit', 'Jenis Kasus','Jenis Diagnosa'],
		colModel :[ 
		{name:'kd_penyakit',index:'kd_penyakit', width:55,align:'center'}, 
		{name:'penyakit',index:'penyakit', width:801}, 
		{name:'jenis_kasus',index:'jenis_kasus', width:81}, 
		{name:'jenis_diagnosa',index:'jenis_diagnosa', width:81}
		],
		rowNum:35,
		viewrecords: true
	}); 
	var diagnosatid = 0;
	$('#tambahdiagnosaid').click(function(){
		if($('#icdsearch_tmpval').val()){
			var myfirstrow = {kd_penyakit:$('#icdsearch_tmpval').val(), penyakit:$('#icdsearch_tmptext').val(), jenis_kasus:$('#selectjeniskasusid').val(), jenis_diagnosa:$('#selectjenisdiagnosaid').val()};
			jQuery("#listdiagnosarawatjalan").addRowData(diagnosatid+1, myfirstrow);
			$('#icdsearch').val('');
			$('#icdsearch_tmptext').val('');
			$('#icdsearch_tmpval').val('');
			if(confirm('Tambah Data Diagnosa Lain?')){
				$('#icdsearch').focus();					
			}else{
				$('#produktindakansearch').focus();
			}
		}else{
			alert('Silahkan Pilih Diagnosa.');
		}
	})
	$('#hapusdiagnosaid').click(function(){
		jQuery("#listdiagnosarawatjalan").clearGridData();
	})
	
	var tindakanibuhamilid = 0;
	$('#tambahtindakanid').click(function(){
		if($('#produktindakansearch_tmpval').val()){
			if($('#kuantitastindakanid').val()==''){
					alert("Silahkan Lengkapi Kolom 'Qty'");
					$('#kuantitastindakanid').focus();return false;
			}
			var myfirstrow = {kd_tindakan:$('#produktindakansearch_tmpval').val(), tindakan:$('#produktindakansearch_tmptext').val(), harga:$('#hargatindakanid').val(), jumlah:$('#kuantitastindakanid').val(), keterangan:$('#keterangantindakanid').val()};
			jQuery("#listtindakanibuhamil").addRowData(tindakanibuhamilid+1, myfirstrow);
			$('#produktindakansearch').val('');
			$('#keterangantindakanid').val('');
			$('#hargatindakanid').val('');
			$('#kuantitastindakanid').val('');
			$('#produktindakansearch_tmptext').val('');
			$('#produktindakansearch_tmpval').val('');
			if(confirm('Tambah Data Diagnosa Lain?')){
				$('#produktindakansearch').focus();					
			}else{
				$('#alergiobatselectid').focus();
				$('#alergiobatselectid').css('outline-color', 'yellow');
				$('#alergiobatselectid').css('outline-style', 'solid');
				$('#alergiobatselectid').css('outline-width', 'thick');
			}
		}else{
			alert('Silahkan Pilih Tindakan.');
		}
	});		
		
	$('#alergiobatselectid').change(function(){
		var c = this.checked ?'checked':'unchecked';
		if(c=='checked'){
			$('#showhidealergitable').show();
			$('#obatsearchalergi').focus();
		}else{
			$('#showhidealergitable').hide();
			jQuery("#listalergiibuhamil").clearGridData();
		}
	});
		
		
	var obatibuhamilid = 0;
	$('#tambahobatid').click(function(){
		if($('#obat_tmpval').val()){
			if($('#kuantitasobatid').val()==''){
				alert("Silahkan Lengkapi Kolom 'Qty'");
				$('#kuantitasobatid').focus();return false;
			}
			var myfirstrow = {kd_obat:$('#obat_tmpval').val(), obat:$('#obat_tmptext').val(), dosis:$('#dosisobatid').val(), jumlah:$('#kuantitasobatid').val(), satuan:$('#satuanobatid').val(), harga:$('#hargaobattmpid').val()};
			jQuery("#listobatibuhamil").addRowData(obatibuhamilid+1, myfirstrow);
			$('#obatsearch').val('');
			$('#dosisobatid').val('');
			$('#kuantitasobatid').val('');
			$('#satuan_obatid').val('');
			$('#kuantitasobatid').val('');
			$('#obat_tmptext').val('');
			$('#obat_tmpval').val('');
			$('#hargaobattmpid').val('');
			if(confirm('Tambah Obat Lain?')){
				$('#obatsearch').focus();					
			}else{
				$('#nama_pemeriksa').focus();
			}
		}else{
			alert('Silahkan Pilih Obat.');
		}
	})
				
	var obatalergiibuhamilid = 0;
	$('#tambahobatalergiid').click(function(){
		if($('#obat_tmpvalalergi').val()){
			var myfirstrow = {kd_obat:$('#obat_tmpvalalergi').val(), obat:$('#obat_tmptextalergi').val()};
			jQuery("#listalergiibuhamil").addRowData(obatalergiibuhamilid+1, myfirstrow);
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

	$('#hapusobatid').click(function(){
		jQuery("#listobatibuhamil").clearGridData();
	})
	
	$('#hapusobatalergiid').click(function(){
		jQuery("#listalergiibuhamil").clearGridData();
	})
	
	$('#hapustindakanid').click(function(){
		jQuery("#listtindakanibuhamil").clearGridData();
	}) 		
		
});

$("#form1t_kunjungan_ibu_hamil_add").validate({focusInvalid:true});

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

$('#form1t_kunjungan_ibu_hamil_add :submit').click(function(e) {
	e.preventDefault();
	if($("#form1t_kunjungan_ibu_hamil_add").valid()) {
		if(kumpularray())$('#form1t_kunjungan_ibu_hamil_add').submit();
	}
	return false;
});

$( "#icdsearch" ).catcomplete({
	source: "t_pelayanan/icdsource",
	minLength: 2,
	select: function( event, ui ) {
	//log( ui.item ?"Selected: " + ui.item.value + " aka " + ui.item.id :"Nothing selected, input was " + this.value );
		$('#icdsearch_tmpval').val(ui.item.id);
		$('#icdsearch_tmptext').val(ui.item.label);
		//$('#selectjeniskasusid').focus();
	}
});

$( "#obatsearch" ).catcomplete({
	source: "t_pelayanan/obatsource",
	minLength: 2,
	select: function( event, ui ) {
		var lb = ui.item.label.split("=>");
		var lb1 = lb[1].split(':');
		if(parseInt(lb1[1])<1){alert('Maaf Stok Obat Kosong, Silahkan Pilih Obat Lain');$( "#obatsearch" ).val('');$( "#obat_tmptextnostock" ).val('no');return false;}
		var lb2 = lb[2].split(':');
		$('#hargaobattmpid').val(lb2[1]);
		$('#obat_tmpval').val(ui.item.id);
		$('#obat_tmptext').val(lb[0]);
	}
});

$( "#obatsearchalergi" ).catcomplete({
	source: "t_kunjungan_ibu_hamil/obatsource_alergi",
	minLength: 2,
	select: function( event, ui ) {
		$('#obat_tmpvalalergi').val(ui.item.id);
		$('#obat_tmptextalergi').val(ui.item.label);
	}
});

var searchdataproduk = <?=$dataproduktindakan?>;
$( "#produktindakansearch" ).catcomplete({
	delay: 0,
	source: searchdataproduk,
	select: function( event, ui ) {
		var lb = ui.item.label.split("=>");
		var lb1 = lb[1].split(':');
		$('#hargatindakanid').val(lb1[1]);
		$('#produktindakansearch_tmpval').val(ui.item.id);
		$('#produktindakansearch_tmptext').val(lb[0]);
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
			if($(this).attr('id')=='keterangantindakanid'){
				if($('#produktindakansearch_tmpval').val()){
					$('#tambahtindakanid').focus();return false;
				}else{
					$('#alergiobatselectid').focus();
					$('#alergiobatselectid').css('outline-color', 'yellow');
					$('#alergiobatselectid').css('outline-style', 'solid');
					$('#alergiobatselectid').css('outline-width', 'thick');
				}				
			}
			if($(this).attr('id')=='kuantitasobatid'){				
				if($('#obat_tmpval').val()){
					$('#tambahobatid').focus();return false;
				}else{
					$('#nama_pemeriksa').focus();
				}
			}
			if($(this).attr('id')=='obatsearchalergi'){				
				if($('#obat_tmpvalalergi').val()){
					$('#tambahobatalergiid').focus();return false;
				}else{
					$('#obatsearch').focus();
				}
			}
			
			if($(this).attr('id')=='obatsearch'){
				if($('#obat_tmptextnostock').val()=='no'){$( "#obat_tmptextnostock" ).val('');$( "#obatsearch" ).focus();return false;}
			}
			
			if($(this).attr('id')=='alergiobatselectid'){
				$( "#obatsearch" ).focus();
				$('#alergiobatselectid').css('outline-color', 'white');
			}
			
			$(':text,:radio,:checkbox,select,textarea')[nextIndex].focus();
		}else{			
			if($("#form1t_kunjungan_ibu_hamil_add").valid()) {
				//$(':text,:radio,:checkbox,select,textarea')[nextIndex-1].blur();
				if(kumpularray())$('#form1t_kunjungan_ibu_hamil_add').submit();
			}
			return false;
		}
   }
});

$('#kunjungan_ibu_hamil_id_hidden').click(function(){
	var kd_pasien = $('#get_kd_pasien').val();
	$("#dialogcari_kunjungan_ibu_hamil_id").dialog({
		autoOpen: false,
		modal:true,
		width: 1000,
		height: 405,
		buttons : {
			"Cancel" : function() {
			  $(this).dialog("close");
			}
		}
	});
	$('#dialogcari_kunjungan_ibu_hamil_id').load('t_kunjungan_ibu_hamil/kunjungan_ibu_hamil_popup?id_caller=form1t_kunjungan_ibu_hamil_add',
		{'kd_pasien':kd_pasien}, 
		function() {
		$("#dialogcari_kunjungan_ibu_hamil_id").dialog("open");
	});
});

$("#tgl_kunjungan_ibu_hamil").focus();

$("#tgl_kunjungan_ibu_hamil").mask("99/99/9999");
</script>
<script>
	//$('#tglt_pelayanan').datepicker({dateFormat: "yy-mm-dd",changeYear: true,yearRange: "-100:+0"});
	function kumpularray(){
		if($('#listdiagnosarawatjalan').getGridParam("records")>0){
			var rows= jQuery("#listdiagnosarawatjalan").jqGrid('getRowData');
			var paras=new Array();
			for(var i=0;i<rows.length;i++){
				var row = rows[i];
				paras.push(JSON.stringify(row));
				//paras.push($.param(row));
			}
			$("#diagnosa_final").val(JSON.stringify(paras));
		}
		if($('#listobatibuhamil').getGridParam("records")>0){
			var rows= jQuery("#listobatibuhamil").jqGrid('getRowData');
			var paras=new Array();
			for(var i=0;i<rows.length;i++){
				var row = rows[i];
				paras.push(JSON.stringify(row));
			}
			$("#obat_final").val(JSON.stringify(paras));
		}
		if($('#listalergiibuhamil').getGridParam("records")>0){
			var rows= jQuery("#listalergiibuhamil").jqGrid('getRowData');
			var paras=new Array();
			for(var i=0;i<rows.length;i++){
				var row = rows[i];
				paras.push(JSON.stringify(row));
			}
			$("#alergi_final").val(JSON.stringify(paras));
		}
		if($('#listtindakanibuhamil').getGridParam("records")>0){
			var rows= jQuery("#listtindakanibuhamil").jqGrid('getRowData');
			var paras=new Array();
			for(var i=0;i<rows.length;i++){
				var row = rows[i];
				paras.push(JSON.stringify(row));
			}
			$("#tindakan_final").val(JSON.stringify(paras));
		}
		
		return true;
				
	}
	
	function gethpl(dates){
		$.ajax({
			type: "GET",
			url: "t_pelayanan/gethpl?hpht="+dates,
			dataType: "text",
			success: function(result) {
				$('#hpht').val(result);
			},      
		});
	}
	function umurhamil(dates){
		$.ajax({
			type: "GET",
			url: "t_pelayanan/umurhamil?hpht="+dates,
			dataType: "text",
			success: function(result) {
				$('#umur_kehamilan_ibu_hamil').val(result);
			},      
		});
	}
</script>
<script>
	$("#form1t_kunjungan_ibu_hamil_add input[name = 'batal']").click(function(){
		$("#t203","#tabs").empty();
		$("#t203","#tabs").load('t_pelayanan'+'?_=' + (new Date()).getTime());
	});
</script>
<div id="dialogcari_kunjungan_ibu_hamil_id" title="Riwayat Kunjungan"></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="form1t_kunjungan_ibu_hamil_add" method="post" onsubmit="bt1.disabled = true; return true;" action="<?=site_url('t_kunjungan_ibu_hamil/addprocess')?>" enctype="multipart/form-data">
		<fieldset>
		<span>
		<label>Rekam Medis#</label>
		<input type="text" name="text" value="<?=$data->KD_PASIEN?>" disabled />
		<input type="hidden" name="kd_pasien_hidden" id="get_kd_pasien" value="<?=$data->KD_PASIEN?>" />
		<input type="hidden" name="kd_puskesmas_hidden" id="textid" value="<?=$data->KD_PUSKESMAS?>" />
		<input type="hidden" name="kd_kunjungan_hidden" id="textid" value="<?=$data->ID_KUNJUNGAN?>" />
		<input type="hidden" name="kd_unit_hidden" id="textid" value="<?=$data->KD_UNIT?>" />
		<input type="hidden" name="kd_urutmasuk_hidden" id="textid" value="<?=$data->URUT_MASUK?>" />
		<input type="hidden" name="kia_ibu" id="textid" value="<?php echo $mykd?>" />
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
		<label>Unit Pelayanan</label>
		<input type="text" name="text" value="<?=$data->UNIT?>" disabled />
		</span>	
		<span>
		<label>Tanggal Pelayanan*</label>
		<input type="text" name="tanggal_daftar" id="tanggal_daftart_pelayananaddrj" class="mydate" value="<?=date('d/m/Y')?>" required  />
		</span>
	</fieldset>
		<fieldset>		
			<?=getComboJenispasien($data->KD_CUSTOMER,'jenis_pasien','jenis_pasient_kunjungan_bumiladd','required','inline')?>
			<?=getComboCarabayar($data->CARA_BAYAR,'cara_bayar','carabayart_kunjungan_bumiladd','required','inline')?>
		</fieldset>
		<fieldset>
			<span>
				<label>Kunjungan Ke</label>
				<select name="kunjungan_ke" id="kunjungan_ke">
					<option <?=$kunj==''?'selected':''?> value="K1">K1</option>
					<option <?=$kunj=='K1'?'selected':''?> value="K2">K2</option>
					<option <?=$kunj=='K2'?'selected':''?> value="K3">K3</option>
					<option <?=$kunj=='K3'?'selected':''?> value="K4">K4</option>
					<!--<option <?=$kunj=='K4'?'selected':''?> value="K5">K5</option>
					<option <?=$kunj=='K5'?'selected':''?> value="K6">K6</option>
					<option <?=$kunj=='K6'?'selected':''?> value="K7">K7</option>
					<option <?=$kunj=='K7'?'selected':''?> value="K8">K8</option>
					<option <?=$kunj=='K8'?'selected':''?> value="K9">K9</option>
					<option <?=$kunj=='K9'?'selected':''?> value="K10">K10</option>-->
				</select>
			</span>
		</fieldset>	
		<fieldset>
			<span>
				<label>Keluhan Sekarang</label>
				<textarea placeholder="Sebutkan Keluhan" name="keluhan" id="keluhan_ibu_hamil" value="" style="width:195px;height:75px"></textarea>
			</span>
		</fieldset>
		<fieldset>
			<span>
			<label>Lingkar Lengan Atas</label>
			<input type="text" name="lila" id="lila"  value="" />
			</span>
		</fieldset>
		<fieldset>
			<span>
				<label>Tekanan Darah (mmHg)</label>
				<input type="text" name="tekanan_darah" id="tekanan_darah_ibu_hamil"  value=""  />
			</span>
		</fieldset>	
		<fieldset>
			<span>
				<label>Berat Badan (Kg)</label>
				<input type="text" name="berat_badan" id="berat_badan_ibu_hamil"  value=""  />
			</span>
		</fieldset>	
		<fieldset>
			<span>
				<label>Tinggi Badan (Cm)</label>
				<input type="text" name="tinggi_badan" id="tinggi_badan_ibu_hamil"  value=""  />
			</span>
		</fieldset>	
		<fieldset>
			<span>
				<label>HPHT dan HPL</label>
				<input type="text" name="hphthpl" id="hphthpl" class="mydate" placeholder="H P H T" value=""  /> & 
				<input type="text" name="hpht" id="hpht" readonly value="" class="mydate" style="display:none" />
			</span>
		</fieldset>	
		<fieldset>
			<span>
				<label>Umur Kehamilan (minggu)</label>
				<input type="text" name="umur_hamil" readonly id="umur_kehamilan_ibu_hamil"  value=""  />
			</span>
		</fieldset>	
		<fieldset>
			<span>
				<label>Tinggi Fundus (cm)</label>
				<input type="text" name="tinggi_fundus" id="tinggi_fundus_ibu_hamil"  value=""  />
			</span>
		</fieldset>	
		<fieldset>
		<?=getComboLetakJanin('','letak_janin','letak_janin','required','inline')?>
		</fieldset>
		<fieldset>
			<span>
				<label>Denyut Jantung Janin per Menit</label>
				<input type="text" name="denyut_jantung" id="denyut_jantung_ibu_hamil"  value=""  />
			</span>
		</fieldset>	
		<fieldset>
			<span>
				<label>Kaki Bengkak</label>
				<select name="kaki_bengkak" id="kaki_bengkak_ibu_hamil">
					<option value="">- silahkan pilih -</option>
					<option value="+">Positif (+)</option>
					<option value="-">Negatif (-)</option>
				</select>
			</span>
		</fieldset>	
		<fieldset>
			<span>
				<label>Lab Darah HB (gram%)</label>
				<input type="text" name="lab_darah" id="lab_darah_ibu_hamil"  value=""  />
			</span>
		</fieldset>	
		<fieldset>
			<span>
				<label>Lab Urine Reduksi</label>
				<input type="text" name="lab_urin_reduksi" id="lab_urin_reduksi_ibu_hamil"  value=""  />
			</span>
		</fieldset>	
		<fieldset>
			<span>
				<label>Lab Urine Protein</label>
				<input type="text" name="lab_urin_protein" id="lab_urin_protein_ibu_hamil"  value=""  />
			</span>
		</fieldset>	
		<fieldset>
			<span>
				<label>Pemeriksaan Khusus</label>
				<select name="pemeriksaan_khusus" id="pemeriksaan_khusus_ibu_hamil">
					<option value="">- silahkan pilih -</option>
					<option value=""></option>
					<option value=""></option>
				</select>
			</span>
		</fieldset>	
		<fieldset>
			<span>
				<label>Status Hamil</label>
				<input type="text" name="status_hamil" readonly id="status_hamil_ibu_hamil"  value="Belum Melahirkan"  />
			</span>
		</fieldset>	
		<fieldset>
			<span>
				<label>Nasehat yang Disampaikan</label>
				<textarea type="text" name="nasehat" id="nasehat_ibu_hamil" value="" style="width:195px;height:75px"></textarea>
			</span>
		</fieldset>
		<br/>
		<div class="subformtitle">Diagnosa</div>
		<table id="listdiagnosarawatjalan"></table>
		<fieldset id="fieldsdiagnosarawatjalan">
			<span>
			<label class="declabel2">Cari Jenis Penyakit / ICD10</label>
			<input type="text" name="text" value="" id="icdsearch" style="width:255px;" />
			</span>
			<span>
			<label class="declabel">Jenis Kasus</label>
			<select class="decinput" name="selectjeniskasus" id="selectjeniskasusid">
				<option value="Baru">Kasus Baru</option>
				<option value="Lama">Kasus Lama</option>
			</select>
			</span>	
			<span>
			<label class="decinput">Jenis Diagnosa</label>
			<select class="decinput" name="selectjenisdiagnosa" id="selectjenisdiagnosaid">
				<option value="Primer">Primer</option>
				<option value="Sekunder">Sekunder</option>
				<option value="Komplikasi">Komplikasi</option>
			</select>
			<input type="hidden" name="icdsearch_tmpval" id="icdsearch_tmpval" />
			<input type="hidden" name="icdsearch_tmptext" id="icdsearch_tmptext" />
			<input type="button" value="Tambah" id="tambahdiagnosaid" />
			<input type="button" id="hapusdiagnosaid" value="Hapus" />
			</span>
		</fieldset>
		<br/>
		<div class="subformtitle">Tindakan</div>
		<table id="listtindakanibuhamil"></table>
		<fieldset id="fieldstindakanibuhamil">
			<span>
			<label class="declabel2">Cari Tindakan</label>
			<input type="text" name="text" value="" id="produktindakansearch" style="width:255px;" />
			</span>
			<span>
			<label class="declabel">Harga</label>
			<input type="text" name="hargatindakan" id="hargatindakanid" style="width:101px" />
			</span>	
			<span>
			<label style="width:37px">Qty</label>
			<input type="text" name="kuantitastindakan" id="kuantitastindakanid" style="width:39px" />
			<input type="hidden" name="produktindakansearch_tmpval" id="produktindakansearch_tmpval" />
			<input type="hidden" name="produktindakansearch_tmptext" id="produktindakansearch_tmptext" />		
			</span>
		</fieldset>
		<fieldset>
			<span>
			<label class="declabel2">Keterangan Tindakan</label>
			<input type="text" name="keterangantindakan" id="keterangantindakanid" style="width:583px" />
			<input type="button" value="Tambah" id="tambahtindakanid" />
			<input type="button" value="Hapus" id="hapustindakanid" />
			</span>
		</fieldset>
		<br/>
		<div class="subformtitle">Alergi Obat</div>
		<fieldset>
			<span>
			<label class="declabel2">Alergi Obat?</label>
			<input type="checkbox" name="alergiobat" id="alergiobatselectid" value="ya">
			</span>
		</fieldset>
		<div id="showhidealergitable" style="display:none">
		<table id="listalergiibuhamil"></table>
		<fieldset id="fieldstindakanibuhamilalergi">
			<span>
			<label class="declabel2">Cari Obat</label>
			<input type="text" name="text" value="" id="obatsearchalergi" style="width:255px;" />
			<input type="hidden" name="obat_tmpval" id="obat_tmpvalalergi" />
			<input type="hidden" name="obat_tmptext" id="obat_tmptextalergi" />
			<input type="button" value="Tambah" id="tambahobatalergiid" />
			<input type="button" value="Hapus" id="hapusobatalergiid" />
			</span>
		</fieldset>
		</div>
		<br/>
		<div class="subformtitle">Obat</div>
		<table id="listobatibuhamil"></table>
		<fieldset id="fieldstindakanibuhamil">
			<span>
			<label class="declabel2">Cari Obat</label>
			<input type="text" name="text" value="" id="obatsearch" style="width:255px;" />
			</span>
			<span>
			<label style="width:77px">Aturan Pakai</label>
			<input type="text" name="hargatindakan" id="dosisobatid" style="width:55px" />
			</span>
			<?=getComboSatuan('','satuan_obat','satuanobatid','','inline')?>
			<span>
			<label style="width:37px">Qty</label>
			<input type="text" name="kuantitastindakan" id="kuantitasobatid"  style="width:39px" />
			<input type="hidden" name="obat_tmpval" id="obat_tmpval" />
			<input type="hidden" name="obat_tmptext" id="obat_tmptext" />
			<input type="hidden" name="hargaobattmpid" id="hargaobattmpid" />
			<input type="hidden" name="obat_tmptextnostock" id="obat_tmptextnostock" />
			<input type="button" value="Tambah" id="tambahobatid" />
			<input type="button" value="Hapus" id="hapusobatid" />
			
			<input type="hidden" name="diagnosa_final" id="diagnosa_final" />
			<input type="hidden" name="obat_final" id="obat_final" />
			<input type="hidden" name="alergi_final" id="alergi_final" />
			<input type="hidden" name="tindakan_final" id="tindakan_final" />
			</span>		
		</fieldset>
		<fieldset>
			<?=getComboPemeriksa('','nama_pemeriksa','nama_pemeriksa','required','inline')?>
		</fieldset>
		<fieldset>
			<?=getComboPetugas('','nama_petugas','nama_petugas','','inline')?>
		</fieldset>
		<br/>
		<br/>
		<fieldset>
			<span>
			<input type="button" name="batal" value="Batal" />
			&nbsp; - &nbsp;
			<input type="submit" name="bt1" value="Simpan"/>
			&nbsp; - &nbsp;
			<input type="button" name="popup" id="kunjungan_ibu_hamil_id_hidden" value="Lihat Kunjungan">
			</span>
		</fieldset>	
</form>
