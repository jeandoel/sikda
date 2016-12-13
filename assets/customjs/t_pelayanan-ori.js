jQuery().ready(function (){ 	
	jQuery("#listt_pelayananantrian").jqGrid({ 
		url:'t_pelayanan/t_pelayananantrianxml', 
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
				{name:'column6b',index:'column6b', width:95,sortable:false,align:'center'},
				{name:'column7b',index:'column7b', width:75,sortable:false,align:'center'},
				{name:'column8b',index:'column8b', width:85,sortable:false,align:'center',formatter:formatterStatus},
				{name:'aksib',index:'aksib', width:61,align:'center',formatter:formatterPelayanan}
			],
			rowNum:5, 
			rowList:[5,10,25], 
			pager: jQuery('#pagert_pelayanananantrian'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				dari=$('#tanggalt_pelayananantrian').val()?$('#tanggalt_pelayananantrian').val():'';
				unit=$('#poliklinikt_pelayananantrian').val()?$('#poliklinikt_pelayananantrian').val():'';
				mystatus=$('#status_pelayanant_pelayananantrian').val()?$('#status_pelayanant_pelayananantrian').val():'';
				myjenis=$('#jenis_pelayanant_pelayananantrian').val()?$('#jenis_pelayanant_pelayananantrian').val():'';
				$('#listt_pelayananantrian').setGridParam({postData:{'dari':dari,'unit':unit,'status':mystatus,'jenis':myjenis}})
			},
			multiselect: false, 
			subGrid: true, 
			subGridRowExpanded: function(subgrid_id, row_id) {
				achtungHideLoader();
				var subgrid_table_id_riwayat, pager_id_riwayat; 
				subgrid_table_id_riwayat = subgrid_id+"_t_riwayat2b";
				pager_id_riwayat = 'p2b_'+subgrid_table_id_riwayat;
				var rowval = $('#listt_pelayananantrian').jqGrid('getRowData', row_id);
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
	}).navGrid('#pagert_pelayanananantrian',{edit:false,add:false,del:false,search:false});
	
	function formatterPelayanan(cellvalue, options, rowObject) {
		var content = '';
		if(cellvalue=='SUDAH'){
			content += '-';
		}else{
			content  += '<a rel="'+cellvalue+'" class="lab-blue">Pelayanan</a>';
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
	
	$("#listt_pelayananantrian .lab-blue").live('click', function(e){
		if($(e.target).data('oneclicked')!='yes')
		{
			$("#listt_pelayananantrian").find('.lab-blue').each(function() {
				$(this).click( function(){
					var colid = $(this).parents('tr:last').attr('id');
						$("#listt_pelayananantrian").jqGrid('setSelection', colid );
						var myCellDataId = jQuery('#listt_pelayananantrian').jqGrid('getCell', colid, 'idb');
						var myCellDataId2 = jQuery('#listt_pelayananantrian').jqGrid('getCell', colid, 'kd_puskesmas');
						var myCellDataId3 = jQuery('#listt_pelayananantrian').jqGrid('getCell', colid, 'kd_kunjungan');
						$("#t203","#tabs").empty();
						$("#t203","#tabs").load('t_pelayanan/layanan'+'?id='+decodeURIComponent(myCellDataId)+'&id2='+decodeURIComponent(myCellDataId2)+'&id3='+decodeURIComponent(myCellDataId3));
				});	
			});
		}
		$(e.target).data('oneclicked','yes');
	});
	
	$('form').resize(function(e) {
		if($("#listt_pelayanan").getGridParam("records")>0){
			jQuery('#listt_pelayanan').setGridWidth(($(this).width()-28));
		}
		if($("#listt_pelayananantrian").getGridParam("records")>0){
			jQuery('#listt_pelayananantrian').setGridWidth(($(this).width()-28));
		}
	});
	
	//$('#darit_pelayanan').datepicker({dateFormat: "dd/mm/yy",changeYear: true,onSelect: function(dateText, inst){$('#sampait_pelayanan').datepicker('option', 'minDate', dateText);$.datepicker._clearDate('#sampait_pelayanan');$('#listt_pelayanan').trigger("reloadGrid");}});
	$('#tanggalt_pelayananantrian').datepicker({dateFormat: "dd/mm/yy",changeYear: true,onClose: function(dateText, inst){$('#listt_pelayananantrian').trigger("reloadGrid");}});
	//$("#darit_pelayanan").mask("99/99/9999");
	$("#tanggalt_pelayananantrian").mask("99/99/9999");
	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	$("#resett_pelayanan").live('click', function(event){
		event.preventDefault();
		$('#formt_pelayanan').reset();
		$('#listt_pelayananantrian').trigger("reloadGrid");
	});
	$("#carit_pelayanan").live('click', function(event){
		event.preventDefault();
		$('#listt_pelayananantrian').trigger("reloadGrid");
	});
	
})