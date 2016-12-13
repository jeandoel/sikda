jQuery().ready(function (){ 
	jQuery("#listpel_trans_kia").jqGrid({ 
		url:'c_pel_trans_kia/pel_trans_kiaxml', 
		emptyrecords: 'Tidak ada data',
		datatype: "xml", 
		colNames:['ID','Kode Puskesmas','No Urut','Kode Pasien','Nama Pasien','JK','Tanggal Lahir','Kategori Kunjungan',
			  'Kunjungan Pemeriksaan','Status','Kode Kunjungan Pemeriksaan','Pelayanan','id2'],
		rownumbers:true,
		width: 1035,
		height: 'auto',
		mtype: 'POST',
		altRows     : false,
		colModel:[ 
				{name:'id',index:'id', width:5,hidden:true}, 
				{name:'kd_puskesmas',index:'kd_puskesmas', width:5,hidden:true}, 
				{name:'no_urut',index:'no_urut', width:40}, 
				{name:'kd_pasien',index:'kd_pasien', width:125}, 
				{name:'nama_pengunjung',index:'nama_pengunjung', width:125,sortable:false}, 
				{name:'jk',index:'jk', width:30,align:'center',sortable:false}, 
				{name:'tanggal_lahir',index:'tanggal_lahir', width:80,sortable:false}, 
				{name:'kategori_kunjungan',index:'kategori_kunjungan', width:100,align:'center',sortable:false},
				{name:'kunjungan_pemeriksaan',index:'kunjungan_pemeriksaan', width:100,align:'center',sortable:false},
				{name:'status',index:'status', width:85,sortable:false,align:'center',formatter:formatterStatus},
				{name:'kd_kunjungan_pemeriksaan',index:'kd_kunjungan_pemeriksaan', width:100,hidden:true},
				{name:'aksi',index:'aksi', width:69,align:'center',formatter:formatterPelayanan},
				{name:'id2',index:'id2', width:69,align:'center',hidden:true},
			],
			rowNum:5, 
			rowList:[5,10,25], 
			pager: jQuery('#pagert_trans_kia'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				//dari=$('#darit_trans_kia').val()?$('#darit_trans_kia').val():'';
				//sampai=$('#sampait_trans_kia').val()?$('#sampait_trans_kia').val():'';
				keyword=$('#keywordt_trans_kia').val()?$('#keywordt_trans_kia').val():'';
				cari=$('#carit_trans_kia').val()?$('#carit_trans_kia').val():'';
				$('#listpel_trans_kia').setGridParam({postData:{'keyword':keyword,'cari':cari}})
			},
			
			///////////////////////////////////////// SUBGRID ////////////////////////////////////////////////////
			multiselect: false, 
			subGrid: true, 
			subGridRowExpanded: function(subgrid_id, row_id) {
				achtungHideLoader();
				var subgrid_table_id_pasien; 
				subgrid_table_id_pasien = subgrid_id+"_t_pasien";
				var rowval = $('#listpel_trans_kia').jqGrid('getRowData', row_id);
				var kd_puskesmas = rowval.kd_puskesmas;
				var kd_pasien = rowval.kd_pasien;				
				
				var htm='';
				htm += '<div class="subgridtitle">Detail Pelayanan</div>';
				htm +="<table id='"+subgrid_table_id_pasien+"' class='scroll'></table>";
				$("#"+subgrid_id).append(htm);
				jQuery("#"+subgrid_table_id_pasien).jqGrid({			
					url:'c_t_trans_kia/t_subgridpelayanankia', 
					rownumbers:false,
					width: 750,
					height: 'auto',
					mtype: 'POST',
					datatype: "xml", colNames: ['ID','Tanggal Kunjungan','Pemeriksa','Petugas','Aksi'], 
					colModel: [ {name:"id",index:"id",width:30, hidden:true}, 
								{name:"tgl_kunjungan",index:"tgl_kunjungan",width:80,sortable:false}, 
								{name:"pemeriksa",index:"pemeriksa",width:50,align:"center",sortable:false}, 
								{name:"petugas",index:"petugas",width:50,align:"center",sortable:false}, 
								{name:"myid",index:"myid",width:30,align:"center",formatter:formatterAction}, 
								],
					beforeRequest:function(){
						$('#'+subgrid_table_id_pasien).setGridParam({postData:{'kd_pasien':kd_pasien,'kd_puskesmas':kd_puskesmas,'kd_pelayanan':''}})
					}					
				});
			},subGridBeforeExpand:function(subgrid_id,row_id){
				achtungShowLoader();
			}
	}).navGrid('#pagert_trans_kia',{edit:false,add:false,del:false,search:false});
	
	
	/////////////////////////////////------ FORMATTER------////////////////////////////////
	
	//pelayanan - green//
	function formatterPelayanan(cellvalue, options, rowObject) {
		var content = '';
		content  += '<a rel="'+cellvalue+'" class="lab-green">Pelayanan</a>';
		return content;
	}
	//Ubah - Green//
	function formatterUbah(cellvalue, options, rowObject) {
		var content = '';
		if(cellvalue=='SUDAH'){
			content += '-';
		}else{
			content  += '<a rel="'+cellvalue+'" class="lab-green">Ubah Status</a>';
		}
		return content;
	}
	//Status - green//
	function formatterStatus(cellvalue, options, rowObject) {
		var content = '';
		if(cellvalue=='BELUM DILAYANI'){
			content  += '<span style="color:green">'+cellvalue+'<span>';
		}else{
			content  += '<span style="color:blue">'+cellvalue+'<span>';
		}
		return content;
	}
	///Detail Formatter///
	function formatterAction(cellvalue, options, rowObject) {
		var content = '';
		content  += '<a rel="' + cellvalue + '" class="icon-detail" title="View"></a> ';
		return content;
	}
	////////////////////////////////////////--Formatter Action--//////////////////////////////////////
	//Pelayanan - Green//
	$("#listpel_trans_kia .lab-green").live('click', function(e){
		if($(e.target).data('oneclicked')!='yes')
		{
			$("#listpel_trans_kia").find('.lab-green').each(function() {
				$(this).click( function(){
					var colid = $(this).parents('tr:last').attr('id');
						$("#listpel_trans_kia").jqGrid('setSelection', colid );
						var myCellDataId = jQuery('#listpel_trans_kia').jqGrid('getCell', colid, 'kd_pasien'); //alert(myCellDataId);
						var myCellDataId2 = jQuery('#listpel_trans_kia').jqGrid('getCell', colid, 'id2');
						$("#t423","#tabs").empty();
						$("#t423","#tabs").load('t_kesehatan_ibu_dan_anak/detailkunjungan'+'?id='+decodeURIComponent(myCellDataId)+'&id2='+decodeURIComponent(myCellDataId2));
				});	
			});
		}
		$(e.target).data('oneclicked','yes');
	});
	
	//Gabung Pelayanan - Blue//
	$("#listc_t_trans_kia .lab-blue").live('click', function(e){
		if($(e.target).data('oneclicked')!='yes')
		{
			$("#listc_t_trans_kia").find('.lab-blue').each(function() {
				$(this).click( function(){
					var colid = $(this).parents('tr:last').attr('id');
						$("#listc_t_trans_kia").jqGrid('setSelection', colid );
						var myCellDataId = jQuery('#listc_t_trans_kia').jqGrid('getCell', colid, 'kd_pasien');
						var myCellDataId2 = jQuery('#listc_t_trans_kia').jqGrid('getCell', colid, 'kd_puskesmas');
						$("#t423","#tabs").empty();
						$("#t423","#tabs").load('c_t_trans_kia/gabungpelayanankia'+'?id='+decodeURIComponent(myCellDataId)+'&id2='+decodeURIComponent(myCellDataId2));
				});	
			});
		}
		$(e.target).data('oneclicked','yes');
	});
	
	//Status - Red//
	$("#listc_t_trans_kia .lab-red").live('click', function(e){
		if($(e.target).data('oneclicked')!='yes')
		{
			$("#listc_t_trans_kia").find('.lab-red').each(function() {
				$(this).click( function(){
					var colid = $(this).parents('tr:last').attr('id');
						$("#listc_t_trans_kia").jqGrid('setSelection', colid );
						var myCellDataId = jQuery('#listc_t_trans_kia').jqGrid('getCell', colid, 'kd_pasien');
						var myCellDataId2 = jQuery('#listc_t_trans_kia').jqGrid('getCell', colid, 'kd_puskesmas');
						$("#t423","#tabs").empty();
						$("#t423","#tabs").load('c_t_trans_kia/statuspelayanankia'+'?id='+decodeURIComponent(myCellDataId)+'&id2='+decodeURIComponent(myCellDataId2));
				});	
			});
		}
		$(e.target).data('oneclicked','yes');
	});
	
	$("#listc_t_trans_kia .icon-detail").live('click', function(a){
		if($(a.target).data('oneclicked')!='yes')
		{
			$("#t423","#tabs").empty();
			$("#t423","#tabs").load('c_t_trans_kia/detailpelayanankia'+'?id='+ this.rel);
		}
		$(a.target).data('oneclicked','yes');
	});
	
	
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	$('#c_t_trans_kiaadd').click(function(){
		$("#t422","#tabs").empty();
		$("#t422","#tabs").load('c_t_trans_kia/add'+'?_=' + (new Date()).getTime());
	});
	
	
	
	$("#listc_t_trans_kia .lab-blue").live('click', function(e){
		if($(e.target).data('oneclicked')!='yes')
		{
			$("#listc_t_trans_kia").find('.lab-blue').each(function() {
				$(this).click( function(){
					var colid = $(this).parents('tr:last').attr('id');
						$("#listc_t_trans_kia").jqGrid('setSelection', colid );
						var myCellDataId = jQuery('#listc_t_trans_kia').jqGrid('getCell', colid, 'kd_kunjungan');
						var myCellDataId2 = jQuery('#listc_t_trans_kia').jqGrid('getCell', colid, 'kd_puskesmas');
						$("#t422","#tabs").empty();
						$("#t422","#tabs").load('c_t_trans_kia/edit'+'?id='+decodeURIComponent(myCellDataId)+'&id2='+decodeURIComponent(myCellDataId2));
				});	
			});
		}
		$(e.target).data('oneclicked','yes');
	});
	
	
	
	$('form').resize(function(e) {
		if($("#listc_t_trans_kia").getGridParam("records")>0){
			jQuery('#listc_t_trans_kia').setGridWidth(($(this).width()-28));
		}
		if($("#listc_t_trans_kiaantrian").getGridParam("records")>0){
			jQuery('#listc_t_trans_kiaantrian').setGridWidth(($(this).width()-28));
		}
	});
		
	
	
	$( "#sampaic_t_trans_kia" )
		.keypress(function(event) {
			var keycode =(event.keyCode?event.keyCode:event.which);	
			if(keycode ==13){
				event.preventDefault();
				$('#listc_t_trans_kia').trigger("reloadGrid");
			}
	});
	
	//$('#tanggalc_t_trans_kia').datepicker({dateFormat: "dd/mm/yy",changeYear: true,onSelect: function(dateText, inst){$('#sampaic_t_trans_kia').datepicker('option', 'minDate', dateText);$.datepicker._clearDate('#sampaic_t_trans_kia');$('#listc_t_trans_kia').trigger("reloadGrid");}});
	$('#tanggalc_t_trans_kia').datepicker({dateFormat: "dd/mm/yy",changeYear: true,onClose: function(dateText, inst){$('#listc_t_trans_kiaantrian').trigger("reloadGrid");}});
	$("#tanggalc_t_trans_kia").mask("99/99/9999");
	//$("#sampaic_t_trans_kia").mask("99/99/9999");
	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	$("#resetc_t_trans_kia").live('click', function(event){
		event.preventDefault();		
		if($('input:radio[name="tampilan_data_transkia"]:checked').val()=='antrian_pasien'){
			$('#formc_t_trans_kia').reset();
			$('#listc_t_trans_kia').trigger("reloadGrid");			
		}else{			
			$('#tanggalc_t_trans_kia').val('');
			$('#poliklinikc_t_trans_kia').val('');
			$('#status_pelayananc_t_trans_kia').val('');
			$('#jenis_pelayananc_t_trans_kia').val('');
			$('#listc_t_trans_kiaantrian').trigger("reloadGrid");
		}
	});
	$("#caric_t_trans_kia").live('click', function(event){
		event.preventDefault();
		if($('input:radio[name="tampilan_data_transkia"]:checked').val()=='antrian_pasien'){
			$('#listc_t_trans_kia').trigger("reloadGrid");			
		}else{
			$('#listc_t_trans_kiaantrian').trigger("reloadGrid");
		}		
	});
	$("#resetc_t_trans_kia").live('click', function(event){
		event.preventDefault();
		$('#formc_t_trans_kia').reset();
		$('#listc_t_trans_kia').trigger("reloadGrid");
	});
	
	$('input:radio[name="tampilan_data_transkia"]').change(
    function(){
        if ($(this).is(':checked') && $(this).val() == 'antrian_pasien') {
            $("#fieldset_c_t_trans_kia_pasien").show();
            $("#fieldset_c_t_trans_kia_antrian").hide();
			jQuery("#transkia_grid_pasien").show();
			$('#listc_t_trans_kia').trigger("reloadGrid");
			jQuery("#transkia_grid_antrian").hide();
        }else{
			$("#fieldset_c_t_trans_kia_pasien").hide();
            $("#fieldset_c_t_trans_kia_antrian").show();
			jQuery("#transkia_grid_antrian").show();
			$('#listc_t_trans_kiaantrian').trigger("reloadGrid");
			jQuery("#transkia_grid_pasien").hide();
		}
    });
	
})