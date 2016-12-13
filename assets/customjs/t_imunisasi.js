jQuery().ready(function (){
		
		////////////////////////////-- Imunisasi -- ////////////////////////////////////////
		jQuery("#listt_pendaftaran_imunisasi").jqGrid({ 
		url:'t_imunisasi/t_imunisasixml', 
		emptyrecords: 'Tidak ada data',
		datatype: "xml", 
		colNames:['Rekam Medis','kd_puskesmas','Nama Pasien','Tanggal Lahir','JK','Alamat','Status Menikah','Nama Ibu','Nama Suami','Imunisasi','KIPI', 'Aksi'],
		rownumbers:true,
		width: 1049,
		height: 'auto',
		mtype: 'POST',
		altRows     : false,
		colModel:[ 
				{name:'kd_pasien',index:'kd_pasien', width:135}, 
				{name:'kd_puskesmas',index:'kd_puskesmas', width:115,hidden:true}, 
				{name:'nama_pasien',index:'nama_pasien', width:115}, 
				{name:'column1',index:'column1', width:99,sortable:false}, 
				{name:'column2',index:'column2', width:50,sortable:false}, 
				{name:'column3',index:'column3', width:125,sortable:false},
				{name:'column4',index:'column4', width:75,align:'center',sortable:false},
				{name:'column5',index:'column5', width:100,align:'center',sortable:false},
				{name:'column6',index:'column6', width:100,sortable:false, hidden:true},
				{name:'aksi',index:'aksi', width:69,align:'center',formatter:formatterImunisasi},
				{name:'aksi2',index:'aksi2', width:69,align:'center',formatter:formatterKipi},
				{name:'aksi3',index:'aksi3', width:99,align:'center',hidden:true,formatter:formatterAction}
			],
			rowNum:5, 
			rowList:[5,10,25], 
			pager: jQuery('#pagert_pendaftaran_imunisasi'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				//dari=$('#darit_pendaftaran').val()?$('#darit_pendaftaran').val():'';
				//sampai=$('#sampait_pendaftaran').val()?$('#sampait_pendaftaran').val():'';
				keyword=$('#keywordt_pendaftaran').val()?$('#keywordt_pendaftaran').val():'';
				cari=$('#carit_pendaftaran').val()?$('#carit_pendaftaran').val():'';
				$('#listt_pendaftaran_imunisasi').setGridParam({postData:{'keyword':keyword,'cari':cari}})
			},
			multiselect: false, 
			subGrid: true, 
			subGridRowExpanded: function(subgrid_id, row_id) {
				achtungHideLoader();
				var subgrid_table_id_pasien; 
				subgrid_table_id_pasien = subgrid_id+"_t_pasien";
				var rowval = $('#listt_pendaftaran_imunisasi').jqGrid('getRowData', row_id);
				var kd_puskesmas = rowval.kd_puskesmas;
				var kd_pasien = rowval.kd_pasien;				
				
				var htm='';
				htm += '<div class="subgridtitle">Detail Pasien</div>';
				htm +="<table id='"+subgrid_table_id_pasien+"' class='scroll'></table>";
				$("#"+subgrid_id).append(htm);
				jQuery("#"+subgrid_table_id_pasien).jqGrid({			
					url:'t_imunisasi/t_imunisasisubgrid', 
					rownumbers:false,
					height: 'auto',
					mtype: 'POST',
					datatype: "xml", colNames: ['Tanggal Imunisasi','Jenis Imunisasi','Nama Vaksin','Jenis Lokasi','Kecamatan','Desa','Petugas','Aksi'], 
					colModel: [ 
								{name:"kd_obat",index:"kd_obat",width:95,sortable:false}, 
								{name:"nama_obat",index:"nama_obat",width:115,sortable:false}, 
								{name:"jenis_obat",index:"jenis_obat",width:75,align:"center",sortable:false}, 
								{name:"dosis",index:"dosis",width:99,align:"center",sortable:false}, 
								{name:"dosis",index:"dosis",width:99,align:"center",sortable:false}, 
								{name:"harga",index:"harga",width:99,align:"left",sortable:false},
								{name:"harga",index:"harga",width:99,align:"left",sortable:false},
								{name:'aksi3',index:'aksi3', width:99,align:'center',formatter:formatterAction}
								],
					beforeRequest:function(){
						$('#'+subgrid_table_id_pasien).setGridParam({postData:{'kd_pasien':kd_pasien,'kd_puskesmas':kd_puskesmas,'kd_pelayanan':''}})
					}					
				});
			},subGridBeforeExpand:function(subgrid_id,row_id){
				achtungShowLoader();
			}
	}).navGrid('#pagert_pendaftaran_imunisasi',{edit:false,add:false,del:false,search:false});
	
	function formatterImunisasi(cellvalue, options, rowObject) {
		var content = '';
		content  += '<a rel="'+cellvalue+'" class="lab-green">Pelayanan</a>';
		return content;
	}
	
	$("#listt_pendaftaran_imunisasi .lab-green").live('click', function(e){
		if($(e.target).data('oneclicked')!='yes')
		{
			$("#listt_pendaftaran_imunisasi").find('.lab-green').each(function() {
				$(this).click( function(){
					var colid = $(this).parents('tr:last').attr('id');
						$("#listt_pendaftaran_imunisasi").jqGrid('setSelection', colid );
						var myCellDataId = jQuery('#listt_pendaftaran_imunisasi').jqGrid('getCell', colid, 'kd_pasien');
						var myCellDataId2 = jQuery('#listt_pendaftaran_imunisasi').jqGrid('getCell', colid, 'kd_puskesmas');
						$("#t215","#tabs").empty();
						$("#t215","#tabs").load('t_imunisasi/load_view_imunisasi'+'?id='+decodeURIComponent(myCellDataId)+'&id2='+decodeURIComponent(myCellDataId2));
				});	
			});
		}
		$(e.target).data('oneclicked','yes');
	});
	
	function formatterKipi(cellvalue, options, rowObject) {
		var content = '';
		if(cellvalue=='TIDAK BOLEH'){
			content  += '<span style="color:RED"> - <span>';
		}else{
			content  += '<a rel="'+cellvalue+'" class="lab-blue">Pelayanan</a>';
		}
		return content;
	}
	
	$("#listt_pendaftaran_imunisasi .lab-blue").live('click', function(a){
		if($(a.target).data('oneclicked')!='yes')
		{
			$("#listt_pendaftaran_imunisasi").find('.lab-blue').each(function() {
				$(this).click( function(){
					var colid = $(this).parents('tr:last').attr('id');
						$("#listt_pendaftaran_imunisasi").jqGrid('setSelection', colid );
						var myCellDataId = jQuery('#listt_pendaftaran_imunisasi').jqGrid('getCell', colid, 'kd_pasien');
						var myCellDataId2 = jQuery('#listt_pendaftaran_imunisasi').jqGrid('getCell', colid, 'kd_puskesmas');
						$("#t215","#tabs").empty();
						$("#t215","#tabs").load('t_imunisasi/load_view_kipi'+'?id='+decodeURIComponent(myCellDataId)+'&id2='+decodeURIComponent(myCellDataId2));
				});	
			});
		}
		$(a.target).data('oneclicked','yes');
	});
	function formatterAction(cellvalue, options, rowObject) {
		var content = '';
		content  += '<a rel="' + cellvalue + '" class="icon-detail" title="View"></a> ';
		return content;
	}
	$("#listt_pendaftaran_imunisasi .icon-detail").live('click', function(p){
		if($(p.target).data('oneclicked')!='yes')
		{
		$("#t215","#tabs").empty();
		$("#t215","#tabs").load('t_imunisasi/detail_pasien_imunisasi'+'?id='+this.rel);
		}
		$(p.target).data('oneclicked','yes');
	});
	
	////////////////////////////--- Imunisasi KIPI ---///////////////////////////////////////
	jQuery("#listt_pendaftaran_imunisasi_kipi").jqGrid({ 
		url:'t_imunisasi/t_imunisasi_kipixml', 
		emptyrecords: 'Tidak ada data',
		datatype: "xml", 
		colNames:['Rekam Medis','kd_puskesmas','Nama Pasien','Tanggal Lahir','JK','Alamat','Status Menikah','Nama Ibu','Nama Suami','Imunisasi','KIPI', 'Aksi'],
		rownumbers:true,
		width: 1049,
		height: 'auto',
		mtype: 'POST',
		altRows     : false,
		colModel:[ 
				{name:'kd_pasien',index:'kd_pasien', width:130}, 
				{name:'kd_puskesmas',index:'kd_puskesmas', width:115, hidden:true}, 
				{name:'nama_pasien',index:'nama_pasien', width:115}, 
				{name:'column1',index:'column1', width:99,sortable:false}, 
				{name:'column2',index:'column2', width:50,sortable:false}, 
				{name:'column3',index:'column3', width:125,sortable:false},
				{name:'column4',index:'column4', width:75,align:'center',sortable:false},
				{name:'column5',index:'column5', width:100,align:'center',sortable:false},
				{name:'column6',index:'column6', width:100,sortable:false},
				{name:'aksi',index:'aksi', width:69,align:'center',formatter:formatterImunisasi},
				{name:'aksi2',index:'aksi2', width:69,align:'center',formatter:formatterKipi},
				{name:'aksi3',index:'aksi3', width:99,align:'center',hidden:true,formatter:formatterAction}
			],
			rowNum:5, 
			rowList:[5,10,25], 
			pager: jQuery('#pagert_pendaftaran_imunisasi_kipi'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				//dari=$('#darit_pendaftaran').val()?$('#darit_pendaftaran').val():'';
				//sampai=$('#sampait_pendaftaran').val()?$('#sampait_pendaftaran').val():'';
				keyword=$('#keywordt_pendaftaran').val()?$('#keywordt_pendaftaran').val():'';
				cari=$('#carit_pendaftaran').val()?$('#carit_pendaftaran').val():'';
				$('#listt_pendaftaran_imunisasi_kipi').setGridParam({postData:{'keyword':keyword,'cari':cari}})
			},
			multiselect: false, 
			subGrid: true, 
			subGridRowExpanded: function(subgrid_id, row_id) {
				achtungHideLoader();
				var subgrid_table_id_pasien; 
				subgrid_table_id_pasien = subgrid_id+"_t_pasien";
				var rowval = $('#listt_pendaftaran_imunisasi_kipi').jqGrid('getRowData', row_id);
				var kd_puskesmas = rowval.kd_puskesmas;
				var kd_pasien = rowval.kd_pasien;				
				
				var htm='';
				htm += '<div class="subgridtitle">Detail Pasien</div>';
				htm +="<table id='"+subgrid_table_id_pasien+"' class='scroll'></table>";
				$("#"+subgrid_id).append(htm);
				jQuery("#"+subgrid_table_id_pasien).jqGrid({			
					url:'t_masters/t_subgrid_pasien_kipixml', 
					rownumbers:false,
					height: 'auto',
					mtype: 'POST',
					datatype: "xml", colNames: ['kd_pasien','Tanggal Imunisasi','Jenis Imunisasi','Nama Vaksin','Jenis Lokasi','Kecamatan','Desa','Petugas', 'Gejala','Kondisi Akhir','Aksi'], 
					colModel: [ {name:"kd_pasien",index:"kd_pasien",width:95,hidden:true}, 
								{name:"nama_obat",index:"nama_obat",width:100,sortable:false}, 
								{name:"nama_obat",index:"nama_obat",width:100,sortable:false}, 
								{name:"jenis_obat",index:"jenis_obat",width:75,align:"center",sortable:false}, 
								{name:"dosis",index:"dosis",width:75,align:"center",sortable:false}, 
								{name:"dosis",index:"dosis",width:75,align:"center",sortable:false}, 
								{name:"harga",index:"harga",width:75,align:"left",sortable:false},
								{name:"harga",index:"harga",width:75,align:"left",sortable:false},
								{name:"harga",index:"harga",width:75,align:"left",sortable:false},
								{name:"harga",index:"harga",width:75,align:"left",sortable:false},
								{name:'aksi3',index:'aksi3', width:90,align:'center',formatter:formatterAction}
								],
					beforeRequest:function(){
						$('#'+subgrid_table_id_pasien).setGridParam({postData:{'kd_pasien':kd_pasien,'kd_puskesmas':kd_puskesmas,'kd_pelayanan':''}})
					}					
				});
			},subGridBeforeExpand:function(subgrid_id,row_id){
				achtungShowLoader();
			}
	}).navGrid('#pagert_pendaftaran_imunisasi_kipi',{edit:false,add:false,del:false,search:false});
	
	$("#listt_pendaftaran_imunisasi_kipi .lab-green").live('click', function(e){
		if($(e.target).data('oneclicked')!='yes')
		{
			$("#listt_pendaftaran_imunisasi_kipi").find('.lab-green').each(function() {
				$(this).click( function(){
					var colid = $(this).parents('tr:last').attr('id');
						$("#listt_pendaftaran_imunisasi_kipi").jqGrid('setSelection', colid );
						var myCellDataId = jQuery('#listt_pendaftaran_imunisasi_kipi').jqGrid('getCell', colid, 'kd_pasien');
						var myCellDataId2 = jQuery('#listt_pendaftaran_imunisasi_kipi').jqGrid('getCell', colid, 'kd_puskesmas');
						$("#t215","#tabs").empty();
						$("#t215","#tabs").load('t_imunisasi/load_view_imunisasi'+'?id='+decodeURIComponent(myCellDataId)+'&id2='+decodeURIComponent(myCellDataId2));
				});	
			});
		}
		$(e.target).data('oneclicked','yes');
	});
	
	$("#listt_pendaftaran_imunisasi_kipi .lab-blue").live('click', function(a){
		if($(a.target).data('oneclicked')!='yes')
		{
			$("#listt_pendaftaran_imunisasi_kipi").find('.lab-blue').each(function() {
				$(this).click( function(){
					var colid = $(this).parents('tr:last').attr('id');
						$("#listt_pendaftaran_imunisasi_kipi").jqGrid('setSelection', colid );
						var myCellDataId = jQuery('#listt_pendaftaran_imunisasi_kipi').jqGrid('getCell', colid, 'kd_pasien');
						var myCellDataId2 = jQuery('#listt_pendaftaran_imunisasi_kipi').jqGrid('getCell', colid, 'kd_puskesmas');
						$("#t215","#tabs").empty();
						$("#t215","#tabs").load('t_imunisasi/load_view_kipi'+'?id='+decodeURIComponent(myCellDataId)+'&id2='+decodeURIComponent(myCellDataId2));
				});	
			});
		}
		$(a.target).data('oneclicked','yes');
	});
	
	$("#listt_pendaftaran_imunisasi_kipi .icon-detail").live('click', function(p){
		if($(p.target).data('oneclicked')!='yes')
		{
		$("#t215","#tabs").empty();
		$("#t215","#tabs").load('t_imunisasi/detail_pasien_kipi'+'?id='+this.rel);
		}
		$(p.target).data('oneclicked','yes');
	});
	
	
	//////////////////////////--- Semua Pasien---///////////////////////////////////////////
	jQuery("#listt_semuapasienimunisasi").jqGrid({ 
		url:'t_imunisasi/t_semua_pasienxml', 
		emptyrecords: 'Tidak ada data',
		datatype: "xml", 
		colNames:['Rekam Medis','kd_puskesmas','Nama Pasien','Tanggal Lahir','JK','Alamat','Status Menikah','Nama Ibu','Nama Suami','Imunisasi','KIPI', 'Aksi'],
		rownumbers:true,
		width: 1049,
		height: 'auto',
		mtype: 'POST',
		altRows     : false,
		colModel:[ 
				{name:'kd_pasien',index:'kd_pasien', width:130}, 
				{name:'kd_puskesmas',index:'kd_puskesmas', width:115, hidden:true}, 
				{name:'nama_pasien',index:'nama_pasien', width:115}, 
				{name:'column1',index:'column1', width:99,sortable:false}, 
				{name:'column2',index:'column2', width:50,sortable:false}, 
				{name:'column3',index:'column3', width:125,sortable:false},
				{name:'column4',index:'column4', width:75,align:'center',sortable:false},
				{name:'column5',index:'column5', width:100,align:'center',sortable:false},
				{name:'column6',index:'column6', width:100,sortable:false},
				{name:'aksi',index:'aksi', width:69,align:'center',formatter:formatterImunisasi},
				{name:'aksi2',index:'aksi2', width:69,align:'center',formatter:formatterKipi},
				{name:'aksi3',index:'aksi3', width:99,align:'center',hidden:true,formatter:formatterAction}
			],
			rowNum:5, 
			rowList:[5,10,25], 
			pager: jQuery('#pagert_semuapasienimunisasi'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				//dari=$('#darit_pendaftaran').val()?$('#darit_pendaftaran').val():'';
				//sampai=$('#sampait_pendaftaran').val()?$('#sampait_pendaftaran').val():'';
				keyword=$('#keywordt_pendaftaran').val()?$('#keywordt_pendaftaran').val():'';
				cari=$('#carit_pendaftaran').val()?$('#carit_pendaftaran').val():'';
				$('#listt_semuapasienimunisasi').setGridParam({postData:{'keyword':keyword,'cari':cari}})
			},
			multiselect: false, 
			subGrid: true, 
			subGridRowExpanded: function(subgrid_id, row_id) {
				achtungHideLoader();
				var subgrid_table_id_pasien; 
				subgrid_table_id_pasien = subgrid_id+"_t_pasien";
				var rowval = $('#listt_semuapasienimunisasi').jqGrid('getRowData', row_id);
				var kd_puskesmas = rowval.kd_puskesmas;
				var kd_pasien = rowval.kd_pasien;				
				
				var htm='';
				htm += '<div class="subgridtitle">Detail Pasien</div>';
				htm +="<table id='"+subgrid_table_id_pasien+"' class='scroll'></table>";
				$("#"+subgrid_id).append(htm);
				jQuery("#"+subgrid_table_id_pasien).jqGrid({			
					url:'t_imunisasi/t_subgridsemuapasienxml', 
					rownumbers:false,
					height: 'auto',
					mtype: 'POST',
					datatype: "xml", 
					colNames: ['NIK','Tempat Tgl. Lahir','Gol. Darah','Jenis Pasien','Cara Bayar','Telp/HP'], 
					colModel: [ 
								{name:"kd_obat",index:"kd_obat",width:95,sortable:false}, 
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
	}).navGrid('#pagert_semuapasienimunisasi',{edit:false,add:false,del:false,search:false});
	
	
	
	$("#listt_semuapasienimunisasi .lab-green").live('click', function(e){
		if($(e.target).data('oneclicked')!='yes')
		{
			$("#listt_semuapasienimunisasi").find('.lab-green').each(function() {
				$(this).click( function(){
					var colid = $(this).parents('tr:last').attr('id');
						$("#listt_semuapasienimunisasi").jqGrid('setSelection', colid );
						var myCellDataId = jQuery('#listt_semuapasienimunisasi').jqGrid('getCell', colid, 'kd_pasien');
						var myCellDataId2 = jQuery('#listt_semuapasienimunisasi').jqGrid('getCell', colid, 'kd_puskesmas');
						$("#t215","#tabs").empty();
						$("#t215","#tabs").load('t_imunisasi/load_view_imunisasi'+'?id='+decodeURIComponent(myCellDataId)+'&id2='+decodeURIComponent(myCellDataId2));
				});	
			});
		}	
		$(e.target).data('oneclicked','yes');
	});
	
	$("#listt_semuapasienimunisasi .lab-blue").live('click', function(a){
		if($(a.target).data('oneclicked')!='yes')
		{
			$("#listt_semuapasienimunisasi").find('.lab-blue').each(function() {
				$(this).click( function(){
					var colid = $(this).parents('tr:last').attr('id');
						$("#listt_semuapasienimunisasi").jqGrid('setSelection', colid );
						var myCellDataId = jQuery('#listt_semuapasienimunisasi').jqGrid('getCell', colid, 'kd_pasien');
						var myCellDataId2 = jQuery('#listt_semuapasienimunisasi').jqGrid('getCell', colid, 'kd_puskesmas');
						$("#t215","#tabs").empty();
						$("#t215","#tabs").load('t_imunisasi/load_view_kipi'+'?id='+decodeURIComponent(myCellDataId)+'&id2='+decodeURIComponent(myCellDataId2));
				});	
			});
		}
		$(a.target).data('oneclicked','yes');
	});
	
	
	$('#v_t_imunisasi_add').click(function(){
		$("#t215","#tabs").empty();
		$("#t215","#tabs").load('t_imunisasi/add'+'?_=' + (new Date()).getTime());
	});
	

	$('form').resize(function(e) {
		if($("#listt_pendaftaran_imunisasi").getGridParam("records")>0){
			jQuery('#listt_pendaftaran_imunisasi').setGridWidth(($(this).width()-28));
		}
		if($("#listt_semuapasienimunisasi").getGridParam("records")>0){
			jQuery('#listt_semuapasienimunisasi').setGridWidth(($(this).width()-28));
		}
	});
	
	
	
	//$('#tgl_imunisasi').datepicker({dateFormat: "dd/mm/yy",changeYear: true,onSelect: function(dateText, inst){$('#sampait_pendaftaran').datepicker('option', 'minDate', dateText);$.datepicker._clearDate('#sampait_pendaftaran');$('#listt_pendaftaran_imunisasi').trigger("reloadGrid");}});
	$('#tgl_imunisasi').datepicker({dateFormat: "dd/mm/yy",changeYear: true,onClose: function(dateText, inst){$('#listt_semuapasienimunisasi').trigger("reloadGrid");}});
	$("#tgl_imunisasi").mask("99/99/9999");
	//$("#sampait_pendaftaran").mask("99/99/9999");
	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	$("#resett_pendaftaran").live('click', function(event){
		event.preventDefault();		
		if($('input:radio[name="tampilan_data_pendaftaran"]:checked').val()=='antrian_pasien'){
			$('#formt_pendaftaran').reset();
			$('#listt_pendaftaran_imunisasi').trigger("reloadGrid");			
		}else{			
			$('#tgl_imunisasi').val('');
			$('#poliklinikt_pendaftaran').val('');
			$('#status_pelayanant_pendaftaran').val('');
			$('#jenis_pelayanant_pendaftaran').val('');
			$('#listt_semuapasienimunisasi').trigger("reloadGrid");
		}
	});
	$("#carit_pendaftaran2").live('click', function(event){
		event.preventDefault();
		if($('input:radio[name="tampilan_data_pendaftaran"]:checked').val()=='antrian_pasien'){
			$('#listt_pendaftaran_imunisasi').trigger("reloadGrid");			
		}else if($('input:radio[name="tampilan_data_pendaftaran"]:checked').val()=='antrian_pasien_kipi'){
			$('#listt_pendaftaran_imunisasi_kipi').trigger("reloadGrid");
		}else{
			$('#listt_semuapasienimunisasi').trigger("reloadGrid");
		}		
	});
	
	$('input:radio[name="tampilan_data_pendaftaran"]').change(
    function(){
        if ($(this).is(':checked') && $(this).val() == 'antrian_pasien') {
            $("#fieldset_t_pendaftaran_pasien_imunisasi").show();
			jQuery("#pendaftaran_grid_pasien_imunisasi").show();
			$('#listt_pendaftaran_imunisasi').trigger("reloadGrid");
			jQuery("#semua_pasien").hide();
			jQuery("#pendaftaran_grid_pasien_imunisasi_kipi").hide();
        }else if ($(this).is(':checked') && $(this).val() == 'antrian_pasien_kipi') {
            $("#fieldset_t_pendaftaran_pasien_imunisasi").show();
			jQuery("#pendaftaran_grid_pasien_imunisasi_kipi").show();
			$('#listt_pendaftaran_imunisasi_kipi').trigger("reloadGrid");
			jQuery("#semua_pasien").hide();
			jQuery("#pendaftaran_grid_pasien_imunisasi").hide();
        }else{
			$("#fieldset_t_pendaftaran_pasien_imunisasi").show();
			jQuery("#semua_pasien").show();
			$('#listt_semuapasienimunisasi').trigger("reloadGrid");
			jQuery("#pendaftaran_grid_pasien_imunisasi_kipi").hide();
			jQuery("#pendaftaran_grid_pasien_imunisasi").hide();
		}
    });
	
})