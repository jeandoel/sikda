jQuery().ready(function (){ 
	jQuery("#listdaftar_transkia").jqGrid({ 
		url:'t_registrasi_kia/t_registrasi_kiaxml', 
		emptyrecords: 'Tidak ada data',
		datatype: "xml", 
		colNames:['KD_PASIEN','KD_PUSKESMAS','Rekam Medis','Nama Pasien','KK','Tanggal Lahir','Umur','Alamat','Pelayanan','Gabung'],
		rownumbers:true,
		width: 1049,
		height: 'auto',
		mtype: 'POST',
		altRows     : false,
		colModel:[ 
				{name:'kd_pasien',index:'kd_pasien', width:5,hidden:true}, 
				{name:'kd_puskesmas',index:'kd_puskesmas', width:5,hidden:true}, 
				{name:'rekam_medis',index:'rekam_medis', width:115,sortable:false}, 
				{name:'nama_pasien',index:'nama_pasien', width:125,sortable:false}, 
				{name:'kk',index:'kk', width:125,sortable:false},
				{name:'tgl_lahir',index:'tgl_lahir', width:75,align:'center',sortable:false},
				{name:'umur',index:'umur', width:55,align:'center',sortable:false},
				{name:'alamat',index:'alamat', width:125,sortable:false},
				{name:'aksi',index:'aksi', width:69,align:'center',formatter:formatterPelayanan},
				{name:'aksi2',index:'aksi2', width:69,align:'center',formatter:formatterGabung}
			],
			rowNum:5, 
			rowList:[5,10,25], 
			pager: jQuery('#pagert_registrasi_kia'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				//dari=$('#darit_registrasi_kia').val()?$('#darit_registrasi_kia').val():'';
				//sampai=$('#sampait_registrasi_kia').val()?$('#sampait_registrasi_kia').val():'';
				keyword=$('#keywordt_registrasi_kia').val()?$('#keywordt_registrasi_kia').val():'';
				cari=$('#carit_registrasi_kia').val()?$('#carit_registrasi_kia').val():'';
				$('#listdaftar_transkia').setGridParam({postData:{'keyword':keyword,'cari':cari}})
			},
			multiselect: false, 
			subGrid: true, 
			subGridRowExpanded: function(subgrid_id, row_id) {
				achtungHideLoader();
				var subgrid_table_id_pasien; 
				subgrid_table_id_pasien = subgrid_id+"_t_pasien";
				var rowval = $('#listdaftar_transkia').jqGrid('getRowData', row_id);
				var kd_puskesmas = rowval.kd_puskesmas;
				var kd_pasien = rowval.kd_pasien;				
				
				var htm='';
				htm += '<div class="subgridtitle">Detail Pasien</div>';
				htm +="<table id='"+subgrid_table_id_pasien+"' class='scroll'></table>";
				$("#"+subgrid_id).append(htm);
				jQuery("#"+subgrid_table_id_pasien).jqGrid({			
					url:'t_masters/t_pasienbyparentxml', 
					rownumbers:false,
					height: 'auto',
					mtype: 'POST',
				datatype: "xml", colNames: ['NIK','Tempat Tgl. Lahir','Gol. Darah','Jenis Pasien','Cara Bayar','Telp/HP'], 
					colModel: [ {name:"kd_obat",index:"kd_obat",width:95,sortable:false}, 
								{name:"nama_obat",index:"nama_obat",width:255,sortable:false}, 
								{name:"jenis_obat",index:"jenis_obat",width:75,align:"center",sortable:false}, 
								{name:"dosis",index:"dosis",width:95,align:"center",sortable:false}, 
								{name:"dosis",index:"dosis",width:95,align:"center",sortable:false}, 
								{name:"harga",index:"harga",width:175,align:"left",sortable:false}
								],
					beforeRequest:function(){
						$('#'+subgrid_table_id_pasien).setGridParam({postData:{'kd_pasien':kd_pasien,'kd_puskesmas':kd_puskesmas,'kd_pelayanan':''}})
					}					
				});
			},subGridBeforeExpand:function(subgrid_id,row_id){
				achtungShowLoader();
			}
	}).navGrid('#pagert_registrasi_kia',{edit:false,add:false,del:false,search:false});
	
	jQuery("#listdaftar_transkiaantrian").jqGrid({ 
		url:'t_registrasi_kia/t_registrasi_kiaantrianxml', 
		emptyrecords: 'Tidak ada data',
		datatype: "xml",
			colNames:['ID','Kode Puskesmas','No Urut','Kode Pasien','Nama Pasien','JK','Tanggal Lahir','Kategori</br>Kunjungan',
			  'Kunjungan Pemeriksaan','Status','Aksi'],
		rownumbers:true,
		width: 1049,
		height: 'auto',
		mtype: 'POST',
		altRows     : false,		
		colModel:[ 
				{name:'kd_kunjungan',index:'kd_kunjungan', width:5,hidden:true},
				{name:'kd_puskesmas',index:'kd_puskesmas', width:5,hidden:true},
				{name:'idb',index:'idb', width:5,hidden:true},				
				{name:'column1b',index:'column1b', width:150,sortable:false,align:'center'}, 
				{name:'column2b',index:'column2b', width:99,sortable:false}, 
				{name:'column3b',index:'column3b', width:30,sortable:false},
				{name:'column4b',index:'column4b', width:100,sortable:false},
				{name:'column5b',index:'column5b', width:130,sortable:false},
				{name:'column6b',index:'column6b', width:100,sortable:false,align:'center'},
				{name:'column8b',index:'column8b', width:90,sortable:false,align:'center',formatter:formatterStatus},
				{name:'aksib',index:'aksib', width:69,align:'center',formatter:formatterUbah}
			],
			rowNum:5, 
			rowList:[5,10,25], 
			pager: jQuery('#pagert_registrasi_kiaanantrian'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				dari=$('#tanggalt_registrasi_kia').val()?$('#tanggalt_registrasi_kia').val():'';
				unit=$('#poliklinikt_registrasi_kia').val()?$('#poliklinikt_registrasi_kia').val():'';
				mystatus=$('#status_pelayanant_registrasi_kia').val()?$('#status_pelayanant_registrasi_kia').val():'';
				myjenis=$('#jenis_pelayanant_registrasi_kia').val()?$('#jenis_pelayanant_registrasi_kia').val():'';
				$('#listdaftar_transkiaantrian').setGridParam({postData:{'dari':dari,'unit':unit,'status':mystatus,'jenis':myjenis}})
			},
			multiselect: false, 
			subGrid: true, 
			subGridRowExpanded: function(subgrid_id, row_id) {
				achtungHideLoader();
				var subgrid_table_id_riwayat, pager_id_riwayat; 
				subgrid_table_id_riwayat = subgrid_id+"_t_riwayat2";
				pager_id_riwayat = 'p2_'+subgrid_table_id_riwayat;
				var rowval = $('#listdaftar_transkiaantrian').jqGrid('getRowData', row_id);
				var kd_puskesmas = rowval.kd_puskesmas;
				var kd_pasien = rowval.idb;				
				
				var htm='';
				htm += '<div class="subgridtitle">Detail Antrian Kunjungan</div>';
				htm +="<table id='"+subgrid_table_id_riwayat+"' class='scroll'></table><div id='"+pager_id_riwayat+"' class='scroll'></div>";
				$("#"+subgrid_id).append(htm);
								jQuery("#"+subgrid_table_id_riwayat).jqGrid({			
					url:'t_registrasi_kia/t_detailantriankunjungan', 
					rownumbers:true,
					mtype: 'POST',	
					height: 'auto',
					datatype: "xml", colNames: ['ID','Tanggal Kunjungan','Pemeriksa','Petugas','Aksi'], 
					colModel: [ {name:"id",index:"id",width:30, hidden:true}, 
								{name:"tgl_kunjungan",index:"tgl_kunjungan",width:150,sortable:false}, 
								{name:"pemeriksa",index:"pemeriksa",width:125,align:"center",sortable:false}, 
								{name:"petugas",index:"petugas",width:125,align:"center",sortable:false}, 
								{name:"myid",index:"myid",width:60,align:"center",formatter:formatterAction}, 
								],
					rowNum:5, 
					pager: pager_id_riwayat,
					beforeRequest:function(){
						$('#'+subgrid_table_id_riwayat).setGridParam({postData:{'kd_pasien':kd_pasien,'kd_puskesmas':kd_puskesmas,'kd_pelayanan':''}})
					}
				});
			},subGridBeforeExpand:function(subgrid_id,row_id){
				achtungShowLoader();
			}
	}).navGrid('#pagert_registrasi_kiaanantrian',{edit:false,add:false,del:false,search:false});
	
	function formatterAction(cellvalue, options, rowObject) {
		var content = '';
		content  += '<a rel="' + cellvalue + '" class="icon-detail" title="View"></a> ';
		return content;
	}
	function formatterPelayanan(cellvalue, options, rowObject) {
		var content = '';
		content  += '<a rel="'+cellvalue+'" class="lab-green">Kunjungan</a>';
		return content;
	}
	
	function formatterGabung(cellvalue, options, rowObject) {
		var content = '';
		content  += '<a rel="'+cellvalue+'" class="lab-blue">Gabung</a>';
		return content;
	}
	
	function formatterUbah(cellvalue, options, rowObject) {
		var content = '';
		if(cellvalue=='SUDAH'){
			content += '-';
		}else{
			content  += '<a rel="'+cellvalue+'" class="lab-blue">Ubah Data</a>';
		}
		return content;
	}
	
	function formatterStatus(cellvalue, options, rowObject) {
		var content = '';
		if(cellvalue=='BELUM DILAYANI'){
			content  += '<span style="color:green">'+cellvalue+'<span>';
		}else{
			content  += '<span style="color:blue">'+cellvalue+'<span>';
		}
		return content;
	}
	$("#listt_registrasi_kia .icon-detail").live('click', function(a){
		if($(a.target).data('oneclicked')!='yes')
		{
			$("#t424","#tabs").empty();
			$("#t424","#tabs").load('t_registrasi_kia/detailpelayanankia'+'?id='+ this.rel);
		}
		$(a.target).data('oneclicked','yes');
	});
	$('#daftarbaru_transkiaadd').click(function(){
		$("#t424","#tabs").empty();
		$("#t424","#tabs").load('t_registrasi_kia/add'+'?_=' + (new Date()).getTime());
	});	
	
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	$("#listdaftar_transkiaantrian .lab-blue").live('click', function(e){
		if($(e.target).data('oneclicked')!='yes')
		{
			$("#listdaftar_transkiaantrian").find('.lab-blue').each(function() {
				$(this).click( function(){
					var colid = $(this).parents('tr:last').attr('id');
						$("#listdaftar_transkiaantrian").jqGrid('setSelection', colid );
						var myCellDataId = jQuery('#listdaftar_transkiaantrian').jqGrid('getCell', colid, 'kd_kunjungan');
						var myCellDataId2 = jQuery('#listdaftar_transkiaantrian').jqGrid('getCell', colid, 'kd_puskesmas');
						$("#t424","#tabs").empty();
						$("#t424","#tabs").load('t_registrasi_kia/ubahkunjungan'+'?id='+decodeURIComponent(myCellDataId)+'&id2='+decodeURIComponent(myCellDataId2));
				});	
			});
		}
		$(e.target).data('oneclicked','yes');
	});
	
	$("#listdaftar_transkia .lab-green").live('click', function(e){
		if($(e.target).data('oneclicked')!='yes')
		{
			$("#listdaftar_transkia").find('.lab-green').each(function() {
				$(this).click( function(){
					var colid = $(this).parents('tr:last').attr('id');
						$("#listdaftar_transkia").jqGrid('setSelection', colid );
						var myCellDataId = jQuery('#listdaftar_transkia').jqGrid('getCell', colid, 'kd_pasien');
						var myCellDataId2 = jQuery('#listdaftar_transkia').jqGrid('getCell', colid, 'kd_puskesmas');
						$("#t424","#tabs").empty();
						$("#t424","#tabs").load('t_registrasi_kia/pendaftaranpelayanan'+'?id='+decodeURIComponent(myCellDataId)+'&id2='+decodeURIComponent(myCellDataId2));
				});	
			});
		}
		$(e.target).data('oneclicked','yes');
	});
	
	$("#listdaftar_transkia .lab-blue").live('click', function(e){
		if($(e.target).data('oneclicked')!='yes')
		{
			$("#listdaftar_transkia").find('.lab-blue').each(function() {
				$(this).click( function(){
					var colid = $(this).parents('tr:last').attr('id');
						$("#listdaftar_transkia").jqGrid('setSelection', colid );
						var myCellDataId = jQuery('#listdaftar_transkia').jqGrid('getCell', colid, 'kd_pasien');
						var myCellDataId2 = jQuery('#listdaftar_transkia').jqGrid('getCell', colid, 'kd_puskesmas');
						$("#t424","#tabs").empty();
						$("#t424","#tabs").load('t_registrasi_kia/gabungpasien'+'?id='+decodeURIComponent(myCellDataId)+'&id2='+decodeURIComponent(myCellDataId2));
				});	
			});
		}
		$(e.target).data('oneclicked','yes');
	});
	
	$('form').resize(function(e) {
		if($("#listdaftar_transkia").getGridParam("records")>0){
			jQuery('#listdaftar_transkia').setGridWidth(($(this).width()-28));
		}
		if($("#listdaftar_transkiaantrian").getGridParam("records")>0){
			jQuery('#listdaftar_transkiaantrian').setGridWidth(($(this).width()-28));
		}
	});
	
	
	
	
	$( "#sampait_registrasi_kia" )
		.keypress(function(event) {
			var keycode =(event.keyCode?event.keyCode:event.which);	
			if(keycode ==13){
				event.preventDefault();
				$('#listdaftar_transkia').trigger("reloadGrid");
			}
	});
	
	//$('#tanggalt_registrasi_kia').datepicker({dateFormat: "dd/mm/yy",changeYear: true,onSelect: function(dateText, inst){$('#sampait_registrasi_kia').datepicker('option', 'minDate', dateText);$.datepicker._clearDate('#sampait_registrasi_kia');$('#listdaftar_transkia').trigger("reloadGrid");}});
	$('#tanggalt_registrasi_kia').datepicker({dateFormat: "dd/mm/yy",changeYear: true,onClose: function(dateText, inst){$('#listdaftar_transkiaantrian').trigger("reloadGrid");}});
	$("#tanggalt_registrasi_kia").mask("99/99/9999");
	//$("#sampait_registrasi_kia").mask("99/99/9999");
	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	$("#resett_registrasi_kia").live('click', function(event){
		event.preventDefault();		
		if($('input:radio[name="tampilan_data_pendaftaran"]:checked').val()=='antrian_pasien'){
			$('#formt_registrasi_kia').reset();
			$('#listdaftar_transkia').trigger("reloadGrid");			
		}else{			
			$('#tanggalt_registrasi_kia').val('');
			$('#poliklinikt_registrasi_kia').val('');
			$('#status_pelayanant_registrasi_kia').val('');
			$('#jenis_pelayanant_registrasi_kia').val('');
			$('#listdaftar_transkiaantrian').trigger("reloadGrid");
		}
	});
	$("#carit_registrasi_kia2").live('click', function(event){
		event.preventDefault();
		if($('input:radio[name="tampilan_data_pendaftaran"]:checked').val()=='antrian_pasien'){
			$('#listdaftar_transkia').trigger("reloadGrid");			
		}else{
			$('#listdaftar_transkiaantrian').trigger("reloadGrid");
		}		
	});
	
	$('input:radio[name="tampilan_data_pendaftaran"]').change(
    function(){
        if ($(this).is(':checked') && $(this).val() == 'antrian_pasien') {
            $("#fieldset_t_registrasi_kia_pasien").show();
            $("#fieldset_t_registrasi_kia_antrian").hide();
			jQuery("#pendaftaran_grid_pasien").show();
			$('#listdaftar_transkia').trigger("reloadGrid");
			jQuery("#pendaftaran_grid_antrian").hide();
        }else{
			$("#fieldset_t_registrasi_kia_pasien").hide();
            $("#fieldset_t_registrasi_kia_antrian").show();
			jQuery("#pendaftaran_grid_antrian").show();
			$('#listdaftar_transkiaantrian').trigger("reloadGrid");
			jQuery("#pendaftaran_grid_pasien").hide();
		}
    });
	
})