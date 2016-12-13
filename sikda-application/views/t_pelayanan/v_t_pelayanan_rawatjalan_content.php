
<script>
$(document).ready(function(){
		$('#form1t_pelayananpelayanan').ajaxForm({
			beforeSend: function() {
				achtungShowLoader();	
			},
			uploadProgress: function(event, position, total, percentComplete) {
			},
			complete: function(xhr) {
				achtungHideLoader();
				// if(xhr.responseText=="odontogram error OK"){
				// 	if(confirm('Data odontogram belum terisi, yakin mau melanjutkan?')){
						
				// 	}else{
				// 		$('#to_odontogram').trigger('click');
				// 		return false;
				// 	}
				// }else 
				if(xhr.responseText!=='OK'){
					$.achtung({message: xhr.responseText, timeout:5});
					return false;
				}else{
					$.achtung({message: 'Proses Ubah Data Berhasil', timeout:5});
					$("#t203","#tabs").empty();
					$("#t203","#tabs").load('t_pelayanan'+'?_=' + (new Date()).getTime());
				}
			}
		});
		
		$("#carabayart_pelayananaddrj").chained("#jenis_pasient_pelayananaddrj");
		
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
		
		jQuery("#listtindakanrawatjalan").jqGrid({
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

		jQuery("#listobatrawatjalan").jqGrid({
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

		jQuery("#listlabrawatjalan").jqGrid({
			datatype: 'clientSide',
			rownumbers:true,
			width: 1049,
			height: 'auto',
			colNames:['Kode Lab','Lab','Jumlah'],
			colModel :[ 
			{name:'kd_lab',index:'kd_obat', width:55,align:'center'}, 
			{name:'lab',index:'obat', width:300},
			{name:'jumlah',index:'jumlah', width:55,align:'center'}
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
		
		var tindakanid = 0;
		$('#tambahtindakanid').click(function(){
			if($('#produktindakansearch_tmpval').val()){
				if(!$('#kuantitastindakanid').val()){alert('Silahkan Tambahkan Kuantitas Tindakan');return false;}
				var myfirstrow = {kd_tindakan:$('#produktindakansearch_tmpval').val(), tindakan:$('#produktindakansearch_tmptext').val(), harga:$('#hargatindakanid').val(), jumlah:$('#kuantitastindakanid').val(), keterangan:$('#keterangantindakanid').val()};
				jQuery("#listtindakanrawatjalan").addRowData(tindakanid+1, myfirstrow);
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
				jQuery("#listalergirawatjalan").clearGridData();
			}
		});
		
		$('#labobatselectid').change(function(){
			var c = this.checked ?'checked':'unchecked';
			if(c=='checked'){
				$('#showhidelabtable').show();
				$('#obatsearchlab').focus();
			}else{
				$('#showhidelabtable').hide();
				jQuery("#listlabrawatjalan").clearGridData();
			}
		});
		
		
		var obatid = 0;
		$('#tambahobatid').click(function(){
			if($('#obat_tmpval').val()){
				if(!$('#kuantitasobatid').val()){alert('Silahkan Tambahkan Jumlah Obat');return false;}
				if(parseInt($('#obat_kuantitas_asli').val())<parseInt($('#kuantitasobatid').val())){alert('Maaf Pengeluaran Obat Melebihi Stok');return false;}
				var myfirstrow = {kd_obat:$('#obat_tmpval').val(), obat:$('#obat_tmptext').val(), dosis:$('#dosisobatid').val(), jumlah:$('#kuantitasobatid').val(), satuan:$('#satuanobatid').val(), harga:$('#hargaobattmpid').val()};
				jQuery("#listobatrawatjalan").addRowData(obatid+1, myfirstrow);
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
					$('#poliklinikt_pendaftaranpelayananrj').focus();
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
					$('#labobatselectid').focus();
					$('#labobatselectid').css('outline-color', 'yellow');
					$('#labobatselectid').css('outline-style', 'solid');
					$('#labobatselectid').css('outline-width', 'thick');
				}
			}else{
				alert('Silahkan Pilih Layanan Lab.');
			}
		})
		
		$('#poliklinikt_pendaftaranpelayananrj').change(function(){
			//if($(this).val()=='TRANSFER'){
				//$('#poliklinikt_pendaftaranpelayananrjfs').show();
			//}else{
				$('#statuskeluarid').focus();
			//}
		})
		
		
		var obatlabid = 0;
		$('#tambahobatlabid').click(function(){
			if($('#obat_tmpvallab').val()){
				var myfirstrow = {kd_lab:$('#obat_tmpvallab').val(), lab:$('#obat_tmptextlab').val(), jumlah:$('#kuantitaslabid').val()};
				jQuery("#listlabrawatjalan").addRowData(obatlabid+1, myfirstrow);
				$('#obatsearchlab').val('');
				$('#obat_tmptextlab').val('');
				$('#kuantitaslabid').val('');
				$('#obat_tmpvalalergi').val('');
				if(confirm('Tambah Data Lab Lain?')){
					$('#obatsearchlab').focus();					
				}else{
					$('#obatsearch').focus();
					$('#labobatselectid').css('outline-color', 'white');
				}
			}else{
				alert('Silahkan Pilih Obat.');
			}
		})		

		$('#hapusobatid').click(function(){
			jQuery("#listobatrawatjalan").clearGridData();
		})
		
		$('#hapusobatalergiid').click(function(){
			jQuery("#listalergirawatjalan").clearGridData();
		})
		
		$('#hapusobatlabid').click(function(){
			jQuery("#listlabrawatjalan").clearGridData();
		})
		
		$('#hapusdiagnosaid').click(function(){
			jQuery("#listdiagnosarawatjalan").clearGridData();
		})
		
		$('#hapustindakanid').click(function(){
			jQuery("#listtindakanrawatjalan").clearGridData();
		}) 		
		
		/*$('#pilihaksiid').on('change', function() {alert($(this).val());
			if($(this).val()=='diagnosa'){	
				$("#listdiagnosarawatjalan").show();
				$("#fieldsdiagnosarawatjalan").show();			
			}else if($(this).val()=='obat'){
			}
		});*/
		
		$('#statuskeluarid').on('change', function() {
			if($(this).val()=='DIRUJUK'){	
				$("#rujukanid").show();
				$("#rujukanrsid").show();			
			}else{
				$("#rujukanid").hide();
				$("#rujukanrsid").hide();			
			}
		});
		
		$('#jenis_pasient_pelayananaddrj').on('change', function() {
			// if($(this).val()=='0000000003' || $(this).val()=='0000000004' || $(this).val()=='0000000005' || $(this).val()=='0000000006'){
			if($(this).val()=='0000000001' || $(this).val()==''){
				$('#noasuransi').hide();
			}else{
				$('#noasuransi').show();
			}
		}).change();
				
		$('#poliklinikt_pendaftaranpelayananrj').on('change', function() {
			if($(this).val()=='219'){
				$('#kategori_kia').show();
			}else{
				$('#kategori_kia').hide();
			}
		});
				
});

$("#form1t_pelayananpelayanan").validate({focusInvalid:true});

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

$('#form1t_pelayananpelayanan :submit').click(function(e) {
	achtungShowLoader();
	e.preventDefault();

	var kd_pasien = $('.get_kd_pasien').attr('value');
	var kd_petugas = $('.get_kd_petugas').attr('value');
	var kd_puskesmas = $('.get_kd_puskesmas').attr('value');
	var unit_pelayanan = $('#get_unit_pelayanan').attr('value');

	$.ajax({
		url : 't_pelayanan/existsOdontogramRecord',
		type : 'POST',
		data : 'kd_puskesmas_hidden='+kd_puskesmas+'&kd_pasien_hidden='+kd_pasien+'&get_unit_pelayanan='+unit_pelayanan
	}).done(function(data){
		achtungHideLoader();
		if(data=='OK'){
			if($("#form1t_pelayananpelayanan").valid()) {
				if(kumpularray()) $('#form1t_pelayananpelayanan').submit();
			}
		}else{
			if(confirm('Data odontogram belum terisi, yakin mau melanjutkan?')){
				if(kumpularray()) $('#form1t_pelayananpelayanan').submit();				
			}else{
				$('#to_odontogram').trigger('click');
				return false;
			}
		}
	});
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

function getAllMethods(object) {
    return Object.getOwnPropertyNames(object).filter(function(property) {
        return typeof object[property] == 'function';
    });
}

// $("#icdsearch").autocomplete({
// 	source: "t_pelayanan/icdsource",
// 	minLength: 2,
// 	select: function( event, ui ) {
// 	// log( ui.item ?"Selected: " + ui.item.value + " aka " + ui.item.id :"Nothing selected, input was " + this.value );
// 		$('#icdsearch_tmpval').val(ui.item.id);
// 		$('#icdsearch_tmptext').val(ui.item.label);
// 		//$('#selectjeniskasusid').focus();
// 	}
// })

$( "#obatsearch" ).catcomplete({
	source: "t_pelayanan/obatsource",
	minLength: 2,
	select: function( event, ui ) {
		var lb = ui.item.label.split("=>");
		var lb1 = lb[1].split(':');
		var lb2 = lb[2]?lb[2].split(':'):'';
		var lb3 = lb[1].split(':');
		if(parseInt(lb1[1])<1){alert('Maaf Stok Obat Kosong, Silahkan Pilih Obat Lain');$( "#obatsearch" ).val('');$( "#obat_tmptextnostock" ).val('no');return false;}		
		$('#obat_kuantitas_asli').val(lb3[1]);
		$('#hargaobattmpid').val(lb2[1]);
		$('#obat_tmpval').val(ui.item.id);
		$('#obat_tmptext').val(lb[0]);
	}
});

$( "#obatsearchalergi" ).catcomplete({
	source: "t_pelayanan/obatsource_alergi",
	minLength: 2,
	select: function( event, ui ) {
		$('#obat_tmpvalalergi').val(ui.item.id);
		$('#obat_tmptextalergi').val(ui.item.label);
	}
});

$( "#obatsearchlab" ).catcomplete({
	source: "t_pelayanan/obatsource_lab",
	minLength: 1,
	select: function( event, ui ) {
		$('#obat_tmpvallab').val(ui.item.id);
		$('#obat_tmptextlab').val(ui.item.label);
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
			if($(this).attr('id')=='selectjenisdiagnosaid'){
				if($('#icdsearch_tmpval').val()){
					$('#tambahdiagnosaid').focus();return false;
				}else{
					$('#produktindakansearch').focus();
				}
			}
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
					$('#poliklinikt_pendaftaranpelayananrj').focus();
				}
			}
			if($(this).attr('id')=='obatsearchalergi'){				
				if($('#obat_tmpvalalergi').val()){
					$('#tambahobatalergiid').focus();return false;
				}else{
					$('#labobatselectid').focus();
					$('#labobatselectid').css('outline-color', 'yellow');
					$('#labobatselectid').css('outline-style', 'solid');
					$('#labobatselectid').css('outline-width', 'thick');
				}
			}
			
			if($(this).attr('id')=='obatsearchlab'){				
				if($('#obat_tmpvallab').val()){
					$('#tambahobatlabid').focus();return false;
				}else{
					$('#obatsearch').focus();
				}
			}
			
			if($(this).attr('id')=='obatsearch'){
				if($('#obat_tmptextnostock').val()=='no'){$( "#obat_tmptextnostock" ).val('');$( "#obatsearch" ).focus();return false;}
			}
			
			if($(this).attr('id')=='alergiobatselectid'){
				$( "#labobatselectid" ).focus();
				$('#alergiobatselectid').css('outline-color', 'white');
				$('#labobatselectid').css('outline-color', 'yellow');
				$('#labobatselectid').css('outline-style', 'solid');
				$('#labobatselectid').css('outline-width', 'thick');
			}
			
			if($(this).attr('id')=='labobatselectid'){
				$( "#obatsearch" ).focus();
				$('#labobatselectid').css('outline-color', 'white');
			}
			
			$(':text,:radio,:checkbox,select,textarea')[nextIndex].focus();
		}else{			
			if($("#form1t_pelayananpelayanan").valid()) {
				//$(':text,:radio,:checkbox,select,textarea')[nextIndex-1].blur();
				if(kumpularray())$('#form1t_pelayananpelayanan').submit();
			}
			return false;
		}
   }
});

$("#tanggal_daftart_pelayananaddrj").focus();

$("#tanggal_daftart_pelayananaddrj").mask("99/99/9999");

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
		if($('#listtindakanrawatjalan').getGridParam("records")>0){
			var rows= jQuery("#listtindakanrawatjalan").jqGrid('getRowData');
			var paras=new Array();
			for(var i=0;i<rows.length;i++){
				var row = rows[i];
				paras.push(JSON.stringify(row));
			}
			$("#tindakan_final").val(JSON.stringify(paras));
		}
		
		if($('#listlabrawatjalan').getGridParam("records")>0){
			var rows= jQuery("#listlabrawatjalan").jqGrid('getRowData');
			var paras=new Array();
			for(var i=0;i<rows.length;i++){
				var row = rows[i];
				paras.push(JSON.stringify(row));
			}
			$("#lab_final").val(JSON.stringify(paras));
		}
		
		return true;
				
	}
</script>
<script>

</script>
<script>
	var kd_pasien = $('.get_kd_pasien').attr('value');
	var kd_petugas = $('.get_kd_petugas').attr('value');
	var kd_puskesmas = $('.get_kd_puskesmas').attr('value');
	var unit_pelayanan = $('#get_unit_pelayanan').attr('value');

	$("#to_odontogram").bind("click",function(){
		$("#content_pelayanan").load("t_gigi_pasien",{
			"pasien_id": kd_pasien,
			"petugas_id": kd_petugas,
			"puskesmas_id":kd_puskesmas
		},function(){	

		})
	})

	$("#form1t_pelayananpelayanan input[name = 'batal'],#backlistt_pelayanan").html("kembali ke list").unbind("click").bind("click",function(){
	$("#t203","#tabs").empty();
	$("#t203","#tabs").load('t_pelayanan'+'?_=' + (new Date()).getTime());
	});
	$("#showhide_pelayananlayanan").focus();
	$("#btn_to_odontogram").show();	

	// Melakukan pengecekana bila pasien melakukan kunjungan Gigi atau bukan.
	if(unit_pelayanan == 'Gigi'){
		$("#btn_to_odontogram").show();	
	}else{
		$("#btn_to_odontogram").hide();	
	}
</script>
		<div class="subformtitle">Pelayanan</div>
		<fieldset>
			<span>
			<label>Unit Pelayanan</label>
			<input type="text" name="text" value="<?=$data->UNIT?>" disabled id="get_unit_pelayanan" />
			</span>	
			<span>
			<label>Tanggal Pelayanan*</label>
			<input type="text" name="tanggal_daftar" id="tanggal_daftart_pelayananaddrj" class="mydate" value="<?=date('d/m/Y')?>" required  />
			</span>
		</fieldset>
		<fieldset>		
			<?=getComboJenispasien($data->KD_CUSTOMER,'jenis_pasien','jenis_pasient_pelayananaddrj','required','inline')?>
			<?=getComboCarabayar($data->CARA_BAYAR,'cara_bayar','carabayart_pelayananaddrj','required','inline')?>
			<!--<span id="noasuransi" style=" *$data->KD_CUSTOMER==0000000003||$data->KD_CUSTOMER==0000000004||$data->KD_CUSTOMER==0000000005||$data->KD_CUSTOMER==0000000006?'':'display:none'* ">-->
			<span id="noasuransi" style="<?=$data->KD_CUSTOMER==0000000001?'display:none':''?>">
				<label>No. Asuransi*</label>
				<input type="text" name="no_asuransi_pasien" id="no_asuransi_pasienid" value="<?=isset($data->NO_ASURANSI)?$data->NO_ASURANSI:''?>">
			</span>
			<span id="btn_to_odontogram" style="border:none">
			<label style="background:none;"><input type="button" id="to_odontogram" value="Odontogram" /></label>
			</span>		
		</fieldset>
		<fieldset>		
			<span>
				<label>Anamnesa</label>
				<textarea name="anamnesa" rows="2" cols="45" ></textarea>
			</span>	
		</fieldset>
		<fieldset>	
			<span>
				<label>Catatan Fisik</label>
				<textarea name="catatan_fisik" rows="2" cols="45" ></textarea>
			</span>	
		</fieldset>
		<fieldset>		
			<span>
				<label>Catatan Dokter</label>
				<textarea name="catatan_dokter" rows="2" cols="45" ></textarea>
			</span>			
		</fieldset>	
		<br/>
		<div class="subformtitle">Diagnosa</div>
		<table id="listdiagnosarawatjalan"></table>
		<fieldset id="fieldsdiagnosarawatjalan" class="ui-front">
			<span class="ui-front">
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
		<table id="listtindakanrawatjalan"></table>
		<fieldset id="fieldstindakanrawatjalan">
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
		<table id="listalergirawatjalan"></table>
		<fieldset id="fieldstindakanrawatjalanalergi">
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
		<div class="subformtitle">Lab</div>
		<fieldset>
			<span>
				<label class="declabel2">Lab?</label>
				<input type="checkbox" name="labobat" id="labobatselectid" value="ya">
			</span>
		</fieldset>
		<div id="showhidelabtable" style="display:none">
		<table id="listlabrawatjalan"></table>
		<fieldset id="fieldstindakanrawatjalanlab">
			<span>
			<label class="declabel2">List Lab</label>
			<input type="text" name="text" value="" id="obatsearchlab" style="width:255px;" />
			<input type="hidden" name="obat_tmpvallab" id="obat_tmpvallab" />
			<input type="hidden" name="obat_tmptextlab" id="obat_tmptextlab" />			
			</span>
			<span>
			<label style="width:37px">Qty</label>
			<input type="text" name="kuantitaslab" id="kuantitaslabid" style="width:39px" />
			<input type="button" value="Tambah" id="tambahobatlabid" />
			<input type="button" value="Hapus" id="hapusobatlabid" />
			</span>
		</fieldset>
		</div>
		<br/>
		<div class="subformtitle">Obat</div>
		<table id="listobatrawatjalan"></table>
		<fieldset id="fieldstindakanrawatjalan">
			<span>
			<label class="declabel2">Cari Obat</label>
			<input type="text" name="text" value="" id="obatsearch" style="width:255px;" />
			</span>
			<span>
			<label style="width:77px">Aturan Pakai</label>
				<input type="text" name="dosis" id="dosisobatid" style="width:55px" />
			</span>
			<?=getComboSatuan('','satuan_obat','satuanobatid','','inline')?>
			<span>
			<label style="width:37px">Qty</label>
				<input type="text" name="kuantitastindakan" id="kuantitasobatid"  style="width:39px" />
				<input type="hidden" name="obat_tmpval" id="obat_tmpval" />
				<input type="hidden" name="obat_kuantitas_asli" id="obat_kuantitas_asli" />
				<input type="hidden" name="hargaobattmpid" id="hargaobattmpid" />
				<input type="hidden" name="obat_tmptext" id="obat_tmptext" />
				<input type="hidden" name="obat_tmptextnostock" id="obat_tmptextnostock" />
				<input type="button" value="Tambah" id="tambahobatid" />
				<input type="button" value="Hapus" id="hapusobatid" />
				
				<input type="hidden" name="diagnosa_final" id="diagnosa_final" />
				<input type="hidden" name="obat_final" id="obat_final" />
				<input type="hidden" name="alergi_final" id="alergi_final" />
				<input type="hidden" name="tindakan_final" id="tindakan_final" />
				<input type="hidden" name="lab_final" id="lab_final" />
				
			</span>		
		</fieldset>
		<br/>
		<fieldset>
		<?=getComboPoliklinikPlus('','konsulpoliklinik','poliklinikt_pendaftaranpelayananrj','','inline')?>
			<span id="kategori_kia" style="display:none">
				<label>Kategori KIA</label>
				<select name="kategori_kia" id="pilihkategorikia">
<!--					<option value="">- silahkan pilih -</option>-->
					<option value="1">Kesehatan Ibu</option>
					<option value="2">Kesehatan Anak/Bayi</option>
					<option value="3">Kegiatan Imunisasi</option>
				</select>
			</span>
		</fieldset>
		<br/>	
		<fieldset>
			<?=getComboStatuskeluar('DILAYANI','status_keluar','statuskeluarid','required','inline')?>
			<span style="display:none" id="rujukanid">
				<label style="width:37px">Poli</label>
				<input type="text" name="polirujuk" id="fillpolirujuk" value="" />
			</span>
			<span style="display:none" id="rujukanrsid">
				<label style="width:37px">RS</label>
				<input type="text" name="rsrujuk" id="fillrsrujuk" value="" />
			</span>
		</fieldset><br/>
		<!--<fieldset>
			<span>
			<label class="labelaction">Tambah Data Pelayanan</label>
			<select class="inputaction2" id="pilihaksiid">
				<option value="">- Pilih Aksi -</option>
				<option value="diagnosa">Diagnosa</option>
				<option value="tindakan">Tindakan</option>
				<option value="obat">Obat</option>
			</select>
			</span>	
		</fieldset>
		<br/>-->
		<fieldset>
				<span>
					<label>Petugas 1</label>
					<input type="text" name="petugas" readonly value="<?=$this->session->userdata('kd_petugas')?>"
				</span>
		</fieldset>
		<?=getComboDokterdanPetugas('','petugas2','petugas2t_pendaftaranpelayanan','','')?>
		<fieldset>
			<span>
			<input type="button" name="batal" value="Batal" />
			&nbsp; - &nbsp;
			<input type="submit" name="bt1" id="submitpelrj" value="Proses Data"/>
			</span>
		</fieldset>	