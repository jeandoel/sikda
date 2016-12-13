jQuery().ready(function (){ 
	jQuery("#listt_pendaftaran").jqGrid({ 
		url:'t_pendaftaran/t_pendaftaranxml', 
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
				{name:'column1',index:'column1', width:115,sortable:false}, 
				{name:'column2',index:'column2', width:125,sortable:false}, 
				{name:'column3',index:'column3', width:125,sortable:false},
				{name:'column4',index:'column4', width:75,align:'center',sortable:false},
				{name:'column5',index:'column5', width:55,align:'center',sortable:false},
				{name:'column6',index:'column6', width:125,sortable:false},
				{name:'aksi',index:'aksi', width:69,align:'center',formatter:formatterPelayanan},
				{name:'aksi2',index:'aksi2', width:69,align:'center',formatter:formatterGabung}
			],
			rowNum:5, 
			rowList:[5,10,25], 
			pager: jQuery('#pagert_pendaftaran'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				//dari=$('#darit_pendaftaran').val()?$('#darit_pendaftaran').val():'';
				//sampai=$('#sampait_pendaftaran').val()?$('#sampait_pendaftaran').val():'';
				keyword=$('#keywordt_pendaftaran').val()?$('#keywordt_pendaftaran').val():'';
				cari=$('#carit_pendaftaran').val()?$('#carit_pendaftaran').val():'';
				$('#listt_pendaftaran').setGridParam({postData:{'keyword':keyword,'cari':cari}})
			},
			multiselect: false, 
			subGrid: true, 
			subGridRowExpanded: function(subgrid_id, row_id) {
				achtungHideLoader();
				var subgrid_table_id_pasien; 
				subgrid_table_id_pasien = subgrid_id+"_t_pasien";
				var rowval = $('#listt_pendaftaran').jqGrid('getRowData', row_id);
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
	}).navGrid('#pagert_pendaftaran',{edit:false,add:false,del:false,search:false});
	
	jQuery("#listt_pendaftaranantrian").jqGrid({ 
		url:'t_pendaftaran/t_pendaftaranantrianxml', 
		emptyrecords: 'Tidak ada data',
		datatype: "xml",
		colNames:['KD_KUNJUNGAN','KD_PASIEN','KD_PUSKESMAS','Urut<br/>Masuk','Rekam<br/> Medis','Nama Pasien','Umur','KK','Alamat','Unit','Dokter','Status','Aksi'],
		rownumbers:true,
		width: 1049,
		height: 'auto',
		mtype: 'POST',
		altRows     : false,		
		colModel:[ 
				{name:'kd_kunjungan',index:'kd_kunjungan', width:5,hidden:true},
				{name:'kd_puskesmas',index:'kd_puskesmas', width:5,hidden:true},
				{name:'idb',index:'idb', width:5,hidden:true},				
				{name:'column1b',index:'column1b', width:35,sortable:false,align:'center'}, 
				{name:'column2b',index:'column2b', width:55,sortable:false}, 
				{name:'column3b',index:'column3b', width:115,sortable:false},
				{name:'column3b',index:'column3b', width:35,sortable:false,align:'center'},
				{name:'column4b',index:'column4b', width:115,sortable:false},
				{name:'column5b',index:'column5b', width:155,sortable:false},
				{name:'column6b',index:'column6b', width:55,sortable:false,align:'center'},
				{name:'column7b',index:'column7b', width:75,sortable:false,align:'center'},
				{name:'column8b',index:'column8b', width:85,sortable:false,align:'center',formatter:formatterStatus},
				{name:'aksib',index:'aksib', width:69,align:'center',formatter:formatterUbah}
			],
			rowNum:5, 
			rowList:[5,10,25], 
			pager: jQuery('#pagert_pendaftarananantrian'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				dari=$('#tanggalt_pendaftaran').val()?$('#tanggalt_pendaftaran').val():'';
				unit=$('#poliklinikt_pendaftaran').val()?$('#poliklinikt_pendaftaran').val():'';
				mystatus=$('#status_pelayanant_pendaftaran').val()?$('#status_pelayanant_pendaftaran').val():'';
				myjenis=$('#jenis_pelayanant_pendaftaran').val()?$('#jenis_pelayanant_pendaftaran').val():'';
				$('#listt_pendaftaranantrian').setGridParam({postData:{'dari':dari,'unit':unit,'status':mystatus,'jenis':myjenis}})
			},
			multiselect: false, 
			subGrid: true, 
			subGridRowExpanded: function(subgrid_id, row_id) {
				achtungHideLoader();
				var subgrid_table_id_riwayat, pager_id_riwayat; 
				subgrid_table_id_riwayat = subgrid_id+"_t_riwayat2";
				pager_id_riwayat = 'p2_'+subgrid_table_id_riwayat;
				var rowval = $('#listt_pendaftaranantrian').jqGrid('getRowData', row_id);
				var kd_puskesmas = rowval.kd_puskesmas;
				var kd_pasien = rowval.idb;				
				
				var htm='';
				htm += '<div class="subgridtitle">Riwayat Pasien</div>';
				htm +="<table id='"+subgrid_table_id_riwayat+"' class='scroll'></table><div id='"+pager_id_riwayat+"' class='scroll'></div>";
				$("#"+subgrid_id).append(htm);
								jQuery("#"+subgrid_table_id_riwayat).jqGrid({			
					url:'t_masters/t_riwayatbyparentxml', 
					rownumbers:true,
					mtype: 'POST',
					height: 'auto',
					datatype: "xml", colNames: ['Tgl. Kunjungan','Poli','Diagnosa'/*,'Anamnesa'*/,'Tindakan','Obat'], 
					colModel: [ {name:"kd_obat",index:"kd_obat",width:80,sortable:false,align:'center'}, 
								{name:"jenis_obat",index:"jenis_obat",width:85,align:"center",sortable:false},
								{name:"nama_obat",index:"nama_obat",width:255,sortable:false}, 								
								//{name:"dosis",index:"dosis",width:215,align:"center",sortable:false}, 
								{name:"harga",index:"harga",width:225,align:"center",sortable:false}, 
								{name:"qty",index:"qty",width:255,align:"center",sortable:false}
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
	}).navGrid('#pagert_pendaftarananantrian',{edit:false,add:false,del:false,search:false});
	
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
	
	$("#listt_pendaftaranantrian .lab-blue").live('click', function(e){
		if($(e.target).data('oneclicked')!='yes')
		{
			$("#listt_pendaftaranantrian").find('.lab-blue').each(function() {
				$(this).click( function(){
					var colid = $(this).parents('tr:last').attr('id');
						$("#listt_pendaftaranantrian").jqGrid('setSelection', colid );
						var myCellDataId = jQuery('#listt_pendaftaranantrian').jqGrid('getCell', colid, 'kd_kunjungan');
						var myCellDataId2 = jQuery('#listt_pendaftaranantrian').jqGrid('getCell', colid, 'kd_puskesmas');
						$("#t202","#tabs").empty();
						$("#t202","#tabs").load('t_pendaftaran/ubahkunjungan'+'?id='+decodeURIComponent(myCellDataId)+'&id2='+decodeURIComponent(myCellDataId2));
				});	
			});
		}
		$(e.target).data('oneclicked','yes');
	});
	
	$("#listt_pendaftaran .lab-green").live('click', function(e){
		if($(e.target).data('oneclicked')!='yes')
		{
			$("#listt_pendaftaran").find('.lab-green').each(function() {
				$(this).click( function(){
					var colid = $(this).parents('tr:last').attr('id');
						$("#listt_pendaftaran").jqGrid('setSelection', colid );
						var myCellDataId = jQuery('#listt_pendaftaran').jqGrid('getCell', colid, 'kd_pasien');
						var myCellDataId2 = jQuery('#listt_pendaftaran').jqGrid('getCell', colid, 'kd_puskesmas');
						$("#t202","#tabs").empty();
						$("#t202","#tabs").load('t_pendaftaran/pendaftaranpelayanan'+'?id='+decodeURIComponent(myCellDataId)+'&id2='+decodeURIComponent(myCellDataId2));
				});	
			});
		}
		$(e.target).data('oneclicked','yes');
	});
	
	$("#listt_pendaftaran .lab-blue").live('click', function(e){
		if($(e.target).data('oneclicked')!='yes')
		{
			$("#listt_pendaftaran").find('.lab-blue').each(function() {
				$(this).click( function(){
					var colid = $(this).parents('tr:last').attr('id');
						$("#listt_pendaftaran").jqGrid('setSelection', colid );
						var myCellDataId = jQuery('#listt_pendaftaran').jqGrid('getCell', colid, 'kd_pasien');
						var myCellDataId2 = jQuery('#listt_pendaftaran').jqGrid('getCell', colid, 'kd_puskesmas');
						$("#t202","#tabs").empty();
						$("#t202","#tabs").load('t_pendaftaran/gabungpasien'+'?id='+decodeURIComponent(myCellDataId)+'&id2='+decodeURIComponent(myCellDataId2));
				});	
			});
		}
		$(e.target).data('oneclicked','yes');
	});
	
	$('form').resize(function(e) {
		if($("#listt_pendaftaran").getGridParam("records")>0){
			jQuery('#listt_pendaftaran').setGridWidth(($(this).width()-28));
		}
		if($("#listt_pendaftaranantrian").getGridParam("records")>0){
			jQuery('#listt_pendaftaranantrian').setGridWidth(($(this).width()-28));
		}
	});
	
	$('#t_pendaftaranadd').click(function(){
		$("#t202","#tabs").empty();
		$("#t202","#tabs").load('t_pendaftaran/add'+'?_=' + (new Date()).getTime());
	});	
	
	
	$( "#sampait_pendaftaran" )
		.keypress(function(event) {
			var keycode =(event.keyCode?event.keyCode:event.which);	
			if(keycode ==13){
				event.preventDefault();
				$('#listt_pendaftaran').trigger("reloadGrid");
			}
	});
	
	//$('#tanggalt_pendaftaran').datepicker({dateFormat: "dd/mm/yy",changeYear: true,onSelect: function(dateText, inst){$('#sampait_pendaftaran').datepicker('option', 'minDate', dateText);$.datepicker._clearDate('#sampait_pendaftaran');$('#listt_pendaftaran').trigger("reloadGrid");}});
	$('#tanggalt_pendaftaran').datepicker({dateFormat: "dd/mm/yy",changeYear: true,onClose: function(dateText, inst){$('#listt_pendaftaranantrian').trigger("reloadGrid");}});
	$("#tanggalt_pendaftaran").mask("99/99/9999");
	//$("#sampait_pendaftaran").mask("99/99/9999");
	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	$("#resett_pendaftaran").live('click', function(event){
		event.preventDefault();		
		if($('input:radio[name="tampilan_data_pendaftaran"]:checked').val()=='antrian_pasien'){
			$('#formt_pendaftaran').reset();
			$('#listt_pendaftaran').trigger("reloadGrid");			
		}else{			
			$('#tanggalt_pendaftaran').val('');
			$('#poliklinikt_pendaftaran').val('');
			$('#status_pelayanant_pendaftaran').val('');
			$('#jenis_pelayanant_pendaftaran').val('');
			$('#listt_pendaftaranantrian').trigger("reloadGrid");
		}
	});
	$("#carit_pendaftaran2").live('click', function(event){
		event.preventDefault();
		if($('input:radio[name="tampilan_data_pendaftaran"]:checked').val()=='antrian_pasien'){
			$('#listt_pendaftaran').trigger("reloadGrid");			
		}else{
			$('#listt_pendaftaranantrian').trigger("reloadGrid");
		}		
	});
	
	$('input:radio[name="tampilan_data_pendaftaran"]').change(
    function(){
        if ($(this).is(':checked') && $(this).val() == 'antrian_pasien') {
            $("#fieldset_t_pendaftaran_pasien").show();
            $("#fieldset_t_pendaftaran_antrian").hide();
			jQuery("#pendaftaran_grid_pasien").show();
			$('#listt_pendaftaran').trigger("reloadGrid");
			jQuery("#pendaftaran_grid_antrian").hide();
        }else{
			$("#fieldset_t_pendaftaran_pasien").hide();
            $("#fieldset_t_pendaftaran_antrian").show();
			jQuery("#pendaftaran_grid_antrian").show();
			$('#listt_pendaftaranantrian').trigger("reloadGrid");
			jQuery("#pendaftaran_grid_pasien").hide();
		}
    });
	
})