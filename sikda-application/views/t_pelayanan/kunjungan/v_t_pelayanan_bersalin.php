<script>
$(document).ready(function(){
		$('#form1masterkesehatanibubersalindanbayiadd').ajaxForm({
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
		});
		$("#carabayart_pelayananaddrj").chained("#jenis_pasient_pelayananaddrj");
		//nampilin grid//
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

		jQuery("#listanaknontunggal").jqGrid({
		datatype: 'clientSide',
		rownumbers:true,
		width: 580,
		height: 'auto',
		colNames:['Anak ke','Berat Lahir','Panjang Badan','Lingkar Kepala','Jenis Kelamin'],
		colModel :[
		{name:'anak_ke',index:'anak_ke', width:25,align:'center'},
		{name:'berat_lahir',index:'berat_lahir', width:50},
		{name:'panjang_badan',index:'panjang_badan', width:50},
		{name:'lingkar_kepala',index:'lingkar_kepala', width:50},
		{name:'jenis_kelamin',index:'jenis_kelamin', width:50},
		],
		rowNum:35,
			viewrecords: true
		});
		//////////// Modul Tindakan dan Harga ////////////////////
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

		var databayi = 0;
		$('#tambahbayi').click(function(){
			if($('#anak_ke_id').val() && $('#berat_lahir_id').val() && $('#panjang_badan_id').val() && $('#lingkar_kepala_id').val() && $('input:radio[name="jk1"]:checked').val()){
				var myfirstrow = {anak_ke:$('#anak_ke_id').val(), berat_lahir:$('#berat_lahir_id').val(), panjang_badan:$('#panjang_badan_id').val(), lingkar_kepala:$('#lingkar_kepala_id').val(), jenis_kelamin:$('input:radio[name="jk1"]:checked').val()};
				jQuery("#listanaknontunggal").addRowData(databayi+1, myfirstrow);
				$('#anak_ke_id').val('');
				$('#berat_lahir_id').val('');
				$('#panjang_badan_id').val('');
				$('#lingkar_kepala_id').val('');
				$('input:radio[name="jk1"]').prop('checked',false);
				if(confirm('Tambah Bayi Lain?')){
					$('#anak_ke_id').focus();
				}else{
					$('#keadaanbayisearch').focus();
				}
			}else{
				alert('Lengkapi Data Terlebih Dahulu');
			}
		});

		var tindakanid = 0;
		$('#tambahtindakanid').click(function(){
			if($('#produktindakansearch_tmpval').val()){
				if($('#kuantitastindakanid').val()==''){
					alert("Silahkan Lengkapi Kolom 'Qty'");
					$('#kuantitastindakanid').focus();return false;
				}
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
				// aouto complate tindakan //

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
		$('#hapustindakanid').click(function(){
			jQuery("#listtindakanrawatjalan").clearGridData();
		})


	////////////////////////////////////////////////////////////////////////////////////////////////////

	function formatterPelayanan(cellvalue, options, rowObject) {
		var content = '';
		if(cellvalue=='SUDAH'){
			content += '-';
		}else{
			content  += '<a rel="'+cellvalue+'" class="lab-blue">Pelayanan</a>';
		}
		return content;
	}


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
				}else{
					$('#ket_tambahan').focus();
				}
			}else{
				alert('Silahkan Pilih Asuhan Bayi.');
			}
		})

	$('#hapusbayi').click(function(){
			jQuery("#listanaknontunggal").clearGridData();
		})

	$('#hapuskeadaanbayiid').click(function(){
			jQuery("#listkeadaanbayi").clearGridData();
		})

	$('#hapusasuhanbayiid').click(function(){
			jQuery("#listasuhanbayi").clearGridData();
		})


	$("#form1masterkesehatanibubersalindanbayiadd").validate({focusInvalid:true});

	$('#form1masterkesehatanibubersalindanbayiadd :submit').click(function(e) {
		e.preventDefault();
		if($("#form1masterkesehatanibubersalindanbayiadd").valid()) {
			if(kumpularray())$('#form1masterkesehatanibubersalindanbayiadd').submit();
		}
		return false;
	});

	$( "#keadaanbayisearch" ).catcomplete({
			source: "t_kesehatan_ibu_dan_anak/keadaanbayisource",
			minLength: 1,
			select: function( event, ui ) {
				$('#keadaanbayisearch_tmpval').val(ui.item.id);
				$('#keadaanbayisearch_tmptext').val(ui.item.label);
				$('#tambahkeadaanbayiid').focus();
			}
	});

	$( "#asuhanbayisearch" ).catcomplete({
			source: "t_kesehatan_ibu_dan_anak/asuhanbayisource",
			minLength: 1,
			select: function( event, ui ) {
				$('#asuhanbayisearch_tmpval').val(ui.item.id);
				$('#asuhanbayisearch_tmptext').val(ui.item.label);
				$('#tambahasuhanbayiid').focus();
			}
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

});

$('#tglmaster').datepicker({dateFormat: "dd-mm-yy",changeYear: true});
$("#jamlahirid").mask("99:99");
</script>
<script>
	$("input[name = 'batal']").click(function(){
		$("#t203","#tabs").empty();
		$("#t203","#tabs").load('t_pelayanan'+'?_=' + (new Date()).getTime());
	})
</script>
<script>
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
		if($('#listanaknontunggal').getGridParam("records")>0){
			var rows= jQuery("#listanaknontunggal").jqGrid('getRowData');
			var paras=new Array();
			for(var i=0;i<rows.length;i++){
				var row = rows[i];
				paras.push(JSON.stringify(row));
				//paras.push($.param(row));
			}
			$("#databayi_final").val(JSON.stringify(paras));
		}
		if($('#listkeadaanbayi').getGridParam("records")>0){
			var rows= jQuery("#listkeadaanbayi").jqGrid('getRowData');
			var paras=new Array();
			for(var i=0;i<rows.length;i++){
				var row = rows[i];
				paras.push(JSON.stringify(row));
				//paras.push($.param(row));
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


		return true;

	}

	$('#pupupkunjungan_bersalin').click(function(){
		var get_kd_pasien = $('#get_kd_pasien').val();
			$("#dialog_kunjungan_bersalin").dialog({
				autoOpen: false,
				modal:true,
				width: 1200,
				height: 600,
				buttons : {
					"Cancel" : function() {
					  $(this).dialog("close");
					}
				}
			});

			$('#dialog_kunjungan_bersalin').load('t_kesehatan_ibu_dan_anak/riwayatkunjunganbersalinpopup?id_caller=form1masterkesehatanibubersalindanbayiadd',
				{'get_kd_pasien':get_kd_pasien}, function() {
				$("#dialog_kunjungan_bersalin").dialog("open");
			});
		});
		//// Radio Choosen ///
		$('#alergiobatselectid').change(function(){
			var c = this.checked ?'checked':'unchecked';
			if(c=='checked'){
				$('#showhidealergitable').show();
				$('#obatsearchalergi').focus();
			}else{
				$('#showhidealergitable').hide();
			}
		});
		/// Grid Alergi Obat ///
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
		/// Tambah Obat Alergi ///
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
		// Autocomplate List Alergi Obat //

		$( "#obatsearchalergi" ).catcomplete({
			source: "t_pemeriksaan_kesehatan_anak/obatsource",
			minLength: 1,
			select: function( event, ui ) {
				$('#obat_tmpvalalergi').val(ui.item.id);
				$('#obat_tmptextalergi').val(ui.item.label);
			}
		});
		// Hapus Alergi Obat //
		$('#hapusobatalergiid').click(function(){
		jQuery("#listalergirawatjalan").clearGridData();
		})

		////////// Grid List Obat ////////////
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
		// Autocomplate List Obat //

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

	// Tambah Obat //
	var obatid = 0;
		$('#tambahobatid').click(function(){
			if($('#obat_tmpval').val()){
				if($('#kuantitasobatid').val()==''){
					alert("Silahkan Lengkapi Kolom 'Qty'");
					$('#kuantitasobatid').focus();return false;
				}
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
					$('#nama_pemeriksa').focus();
				}
			}else{
				alert('Silahkan Pilih Obat.');
			}
		})
	// Hapus Obat //
	$('#hapusobatid').click(function(){
			jQuery("#listobatrawatjalan").clearGridData();
		})

	$(':text,:radio,:checkbox,select,textarea').bind("keydown", function(e) {
   var n = $(":text,:radio,:checkbox,select,textarea").length;
   if (e.which == 13)
   {
		e.preventDefault();
		var nextIndex = $(':text,:radio,:checkbox,select,textarea').index(this) + 1;
		var thisIndex = $(':text,:radio,:checkbox,select,textarea').index(this);
		if(nextIndex < n && $(this).valid()){
			if($(this).attr('name')=='jk'){
				if($('#anak_ke_id').val() && $('#berat_lahir_id').val() && $('#panjang_badan').val() && $('#lingkar_kepala').val()){
					$('#tambahbayi').focus();
				}else{
					$('#keadaanbayisearch').focus();
				}
			}
			if($(this).attr('id')=='keadaanbayisearch'){
				if($('#keadaanbayisearch_tmpval').val()){
					$('#tambahkeadaanbayiid').focus();
				}else{
					$('#asuhanbayisearch').focus();
				}
			}
			if($(this).attr('id')=='asuhanbayisearch'){
				if($('#asuhanbayisearch_tmpval').val()){
					$('#tambahasuhanbayiid').focus();
				}else{
					$('#ket_tambahan').focus();
				}
			}if($(this).attr('id')=='keterangantindakanid'){
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

			if($(this).attr('id')=='obatsearch'){
				if($('#obat_tmptextnostock').val()=='no'){$( "#obat_tmptextnostock" ).val('');$( "#obatsearch" ).focus();return false;}
			}

			if($(this).attr('id')=='alergiobatselectid'){
				$( "#obatsearch" ).focus();
				$('#alergiobatselectid').css('outline-color', 'white');
			}

			$(':text,:radio,:checkbox,select,textarea')[nextIndex].focus();
		}else{
			if($("#form1masterkesehatanibubersalindanbayiadd").valid()) {
				if(kumpularray())$('#form1masterkesehatanibubersalindanbayiadd').submit();
			}
			return false;
		}
   }
});

	$('#jenis_kelahiran').on("change",function(){
		if($("#jenis_kelahiran").val()=='')
		{
			$('#idanaktunggal').hide();
			$('#idanaknontunggal').hide();
		}
		else if($("#jenis_kelahiran").val()==1)
		{
			$('#idanaktunggal').show();
			$('#idanaknontunggal').hide();
		}
		else
		{
			$('#idanaktunggal').hide();
			$('#idanaknontunggal').show();
		}
	});

	$('#jenis_kelahiran').on("change",function(){
		if(document.getElementById("jenis_kelahiran").value==1)
		{
			document.getElementById("jumlah_lahirt_pendaftaranadd").value = 1;
		}
		else if(document.getElementById("jenis_kelahiran").value==2)
		{
			document.getElementById("jumlah_lahirt_pendaftaranadd").value = 2;
		}
		else if(document.getElementById("jenis_kelahiran").value==3)
		{
			document.getElementById("jumlah_lahirt_pendaftaranadd").value = 3;
		}
		else
		{
			document.getElementById("jumlah_lahirt_pendaftaranadd").value = '';
		}
		$('#jumlah_lahirt_pendaftaranadd').focus();
	});
///////////////////////////////////////////////////////////////////////////////////////////////////

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
<div id="dialog_kunjungan_bersalin" title="Riwayat Kunjungan Bersalin"></div>
</br>
<span id='errormsg'></span>
<form name="frApps" id="form1masterkesehatanibubersalindanbayiadd" onsubmit="bt1.disabled = true; return true;" method="post" action="<?=site_url('t_kesehatan_ibu_dan_anak/addprocess')?>" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Rekam Medis#</label>
		<input type="text" name="text" value="<?=$data->KD_PASIEN?>" disabled />
		<input type="hidden" name="kd_pasien_hidden" id="get_kd_pasien" value="<?=$data->KD_PASIEN?>" />
		<input type="hidden" name="kd_puskesmas_hidden" id="textid" value="<?=$data->KD_PUSKESMAS?>" />
		<input type="hidden" name="kd_kunjungan_hidden" id="textid" value="<?=$data->ID_KUNJUNGAN?>" />
		<input type="hidden" name="kd_unit_hidden" id="textid" value="<?=$data->KD_UNIT?>" />
		<input type="hidden" name="kd_urutmasuk_hidden" id="textid" value="<?=$data->URUT_MASUK?>" />
		<input type="hidden" name="nama_lengkap_hidden" id="textid" value="<?=$data->NAMA_PASIEN?>" />
		<input type="hidden" name="kia_ibu" id="textid" value="<?php echo $mykd?>" />
		</span>
		<span>
		<label>NIK</label>
		<input type="text" name="nik" value="<?=$data->NIK?>" disabled />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Nama Pasien</label>
		<input type="text" name="nama_lengkap" id="textid" value="<?=$data->NAMA_PASIEN?>" disabled />
		</span>
		<span>
		<label>Golongan Darah</label>
		<input type="text" name="gol_darah" id="textid" value="<?=$data->KD_GOL_DARAH?>" disabled />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Jenis Pasien</label>
		<input type="text" name="jenis_pasien" id="textid" value="<?=$data->CUSTOMER?>" disabled />
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
		<?=getComboJenispasien($data->KD_CUSTOMER,'jenis_pasien','jenis_pasient_pelayananaddrj','required','inline')?>
		<?=getComboCarabayar($data->CARA_BAYAR,'cara_bayar','carabayart_pelayananaddrj','required','inline')?>
	</fieldset>
	<fieldset>
		<span>
		<label>Unit Pelayanan</label>
		<input type="text" name="text" value="<?=$data->UNIT?>" disabled />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Tanggal Daftar* (dd/mm/yyyy)</label>
		<input type="text" name="tanggal_daftar" id="tglmaster" value="<?=date('d/m/Y')?>" required  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Jam Kelahiran</label>
		<input type="text" name="jam_kelahiran" id="jamlahirid" value="" required style="width:50px" />
		<select name="ket_waktu" style="width:140px">
			<option value="1">WIB</option>
			<option value="2">WITA</option>
			<option value="3">WIT</option>
		</select>
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Umur Kehamilan(minggu)*</label>
		<input type="text" name="umur_kehamilan" id="umur_kehamilan_id_minggu" value="" required  />
		</span>
	</fieldset>
	<fieldset>
		<?=getComboDokter10('','dokter','dokter','required','inline')?>
	</fieldset>
	<fieldset>
		<?=getComboPetugas10('','petugas','petugas','required','inline')?>
	</fieldset>
	<fieldset>
		<?=getComboJenispersalinan('','jenis_persalinan','jenis_persalinan','required','inline')?>
	</fieldset>
	<fieldset>
		<?=getComboJeniskelahiran('','jenis_kelahiran','jenis_kelahiran','required','inline')?>
	</fieldset>
	<fieldset>
		<span>
		<label>Jumlah Bayi</label>
		<input type="text" name="jumlah_bayi" id="jumlah_lahirt_pendaftaranadd" value="" required  />
		</span>
	</fieldset>
		<fieldset>
		<?=getComboKesehatan('','keadaan_kesehatan','keadaan_kesehatan','required','inline')?>
	</fieldset>

	<fieldset>
		<?=getComboStatushamil('Melahirkan','status_hamil','status_hamil','required','inline')?>
	</fieldset>

<div class="subformtitle">Bayi saat Lahir</div>
    <div id="idanaktunggal" style="display:none">
	<fieldset>
		<span>
		<label>Anak Ke</label>
		<input type="text" name="anak_ke" id="tempat_lahirt_pendaftaranadd1" value="" required  />
		</span>
	</fieldset>
	 <fieldset>
		<span>
		<label>Berat Lahir (gram)</label>
		<input type="text" name="berat_lahir" id="tempat_lahirt_pendaftaranadd2" value="" required  />
		</span>
	</fieldset>
	  <fieldset>
		<span>
		<label>Panjang Badan(cm)</label>
		<input type="text" name="panjang_badan" id="tempat_lahirt_pendaftaranadd3" value="" required  />
		</span>
	</fieldset>
	   <fieldset>
		<span>
		<label>Lingkar Kepala(cm)</label>
		<input type="text" name="lingkar_kepala" id="tempat_lahirt_pendaftaranadd4" value="" required  />
		</span>
	</fieldset>
        <fieldset>
		<span>
		<label>Jenis Kelamin</label>
		<input type="radio" name="jk" value="L">Laki - Laki
		<input type="radio" name="jk" value="P">Perempuan
		</span>
	</fieldset>
	</div>
	<div id="idanaknontunggal" style="display:none">
	<table id="listanaknontunggal"></table>
	<fieldset>
		<span>
		<label>Anak Ke</label>
		<input type="text" name="anak_ke1" id="anak_ke_id" value="" />
		</span>
	</fieldset>
	 <fieldset>
		<span>
		<label>Berat Lahir (gram)</label>
		<input type="text" name="berat_lahir1" id="berat_lahir_id" value="" />
		</span>
	</fieldset>
	  <fieldset>
		<span>
		<label>Panjang Badan(cm)</label>
		<input type="text" name="panjang_badan1" id="panjang_badan_id" value="" />
		</span>
	</fieldset>
	   <fieldset>
		<span>
		<label>Lingkar Kepala(cm)</label>
		<input type="text" name="lingkar_kepala1" id="lingkar_kepala_id" value="" />
		</span>
	</fieldset>
        <fieldset>
		<span>
		<label>Jenis Kelamin</label>
		<input type="radio" name="jk1" value="L" id="jenis_kelamin_id">Laki - Laki
		<input type="radio" name="jk1" value="P" id="jenis_kelamin_id1">Perempuan
		</span>
		<span>
		<input type="hidden" name="databayi_final" id="databayi_final" />
		&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp
		<input type="button" value="Tambah" id="tambahbayi" />
		<input type="button" id="hapusbayi" value="Hapus" />
		</span>
	</fieldset>
	</div>
	<br/>
	<table id="listkeadaanbayi"></table>
	<fieldset id="fieldskeadaanbayi">
		<span>
		<label>Keadaan Bayi Saat Lahir</label>
		<input type="text" name="keadaan_bayi_lahir" value="" id="keadaanbayisearch"/>
		</span>
		<span>
		<input type="hidden" name="keadaanbayisearch_tmpval" id="keadaanbayisearch_tmpval" />
		<input type="hidden" name="keadaanbayisearch_tmptext" id="keadaanbayisearch_tmptext" />
		<input type="hidden" name="keadaanbayi_final" id="keadaanbayi_final" />
		<input type="button" value="Tambah" id="tambahkeadaanbayiid" />
		<input type="button" id="hapuskeadaanbayiid" value="Hapus" />
		</span>
	</fieldset>
	<br/>
	<table id="listasuhanbayi"></table>
	<fieldset id="fieldsasuhanbayi">
		<span>
		<label>Asuhan Bayi Baru Lahir</label>
		<input type="text" name="asuhan_bayi_lahir" value="" id="asuhanbayisearch"/>
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
		<textarea name="ket_tambahan" id="ket_tambahan" rows="3" cols="45"></textarea>
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
	<div class="subformtitle">Pemberian Obat/Vitamin</div>
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
	<div class="subformtitle">Obat</div>
	<table id="listobatrawatjalan"></table>
	<fieldset id="fieldstindakanrawatjalan">
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
	<br/>
	<?=getComboStatuskeluar('DILAYANI','status_keluar','statuskeluarid','required','')?>
	<br/>
	<br/>
	<fieldset>
		<span>
		<input type="submit" name="bt1" value="Proses Data"/>
		&nbsp; - &nbsp;
		<input type="button" name="batal" value="Batal"/>
		&nbsp; - &nbsp;
		<input type="button" name="pupup" id="pupupkunjungan_bersalin" value="Riwayat Kunjungan"  />
		</span>
	</fieldset>
</form>