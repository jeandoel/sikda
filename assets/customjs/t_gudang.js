jQuery().ready(function (){ 
	jQuery("#listt_gudang").jqGrid({ 
		url:'t_gudang/t_gudangxml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['Kode PKM','Kode Obat','Nama Obat','Kode Gol. Obat','Satuan Kecil','Satuan Besar','Fraction','Nama Unit','Stok','Action'],
		rownumbers:true,
		width: 1049,
		height: 'auto',
		mtype: 'POST',
		altRows     : false,
		colModel:[ 
				{name:'kd_pkm',index:'kd_pkm', width:75,hidden:false}, 
				{name:'column0',index:'column0', width:50,hidden:false}, 
				{name:'column1',index:'column1', width:155,sortable:false}, 
				{name:'column2',index:'column2', width:55,sortable:false}, 
				{name:'column3',index:'column3', width:55,sortable:false},
				{name:'column5',index:'column5', width:55,align:'center',sortable:false},
				{name:'column6',index:'column6', width:35,sortable:false,align:'center'},
				{name:'column7',index:'column7', width:75,sortable:false,align:'center'},
				{name:'column8',index:'column8', width:35,sortable:false,align:'center'},
				{name:'aksi',index:'aksi', width:91,align:'center',hidden:false,formatter:formatterAction,hidden:true}
			],
			rowNum:10, 
			rowList:[10,20,30], 
			pager: jQuery('#pagert_gudang'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				keyword=$('#keywordt_gudang').val()?$('#keywordt_gudang').val():'';
				carinama=$('#carinamat_gudang').val()?$('#carinamat_gudang').val():'';
				$('#listt_gudang').setGridParam({postData:{'keyword':keyword,'cari':carinama}})
			},
			
			multiselect: false, 
			subGrid: true, 
			subGridRowExpanded: function(subgrid_id, row_id) {
				achtungHideLoader();
				var subgrid_table_id_gudang_puskesmas, pager_id_gudang_puskesmas; 
				subgrid_table_id_gudang_puskesmas = subgrid_id+"_t_riwayat2b";
				pager_id_gudang_puskesmas = 'p2b_'+subgrid_table_id_gudang_puskesmas;
				var rowval = $('#listt_gudang').jqGrid('getRowData', row_id);
				var kd_puskesmas = rowval.kd_pkm;
				var level = rowval.column7;		
				var kd_obat = rowval.column0;		
				
				var htm='';
				//htm += '<div class="subgridtitle">Data Terlaksana</div>';
				htm +="<table id='"+subgrid_table_id_gudang_puskesmas+"' class='scroll'></table><div id='"+pager_id_gudang_puskesmas+"' class='scroll'></div>";
				$("#"+subgrid_id).append(htm);
					
					jQuery("#"+subgrid_table_id_gudang_puskesmas).jqGrid({			
					url:'t_gudang/t_subgridgudangxml', 
					rownumbers:true,
					mtype: 'POST',
					width: 850,
					height: 'auto',
					datatype: "xml", colNames: ['Kode','Tanggal Transaksi','No. Faktur','Jenis Transaksi','Terima dari','Kirim ke','Jumlah'/*,'Stok Awal','Stok Akhir'*/], 
					colModel: [ 
								{name:'id',index:'id', width:5,hidden:true},
								{name:"tanggal_terima",index:"tanggal_terima",width:120,align:'center',sortable:false}, 
								{name:"jns_trans",index:"jns_trans",width:90,align:'center',sortable:false}, 
								{name:"flag",index:"flag",width:90,align:'center',sortable:false}, 
								{name:"terima",index:"terima",width:80,align:'center',sortable:false}, 
								{name:"kirim",index:"kirim",width:91,align:"center",sortable:false}, 
								{name:"jlh",index:"jlh",width:91,align:"center",sortable:false} 		
								/*{name:'st_awal',index:'st_awal', width:131,align:'center',sortable:false},
								{name:'st_akhir',index:'st_akhir', width:101,align:'center',sortable:false},*/
								//{name:'myid',index:'myid', width:70,align:'center',formatter:formatterActionsub},
								],
					rowNum:5, 
					pager: pager_id_gudang_puskesmas,
					
					beforeRequest:function(){
							
						$('#'+subgrid_table_id_gudang_puskesmas).setGridParam({postData:{'kd_puskesmas':kd_puskesmas,'level':level,'kd_obat':kd_obat}})
					}
				});
			},subGridBeforeExpand:function(subgrid_id,row_id){
				achtungShowLoader();
			}
	}).navGrid('#pagert_gudang',{edit:false,add:false,del:false,search:false});
	
	jQuery("#listt_gudangapt").jqGrid({ 
		url:'t_gudang/t_gudangxmlapt', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['Kode PKM','Kode Obat','Nama Obat','Kode Gol. Obat','Satuan Kecil','Satuan Besar','Fraction','Nama Unit','Stok','Action'],
		rownumbers:true,
		width: 1049,
		height: 'auto',
		mtype: 'POST',
		altRows     : false,
		colModel:[ 
				{name:'kd_pkm',index:'kd_pkm', width:75,hidden:false}, 
				{name:'column0',index:'column0', width:50,hidden:false}, 
				{name:'column1',index:'column1', width:155,sortable:false}, 
				{name:'column2',index:'column2', width:55,sortable:false}, 
				{name:'column3',index:'column3', width:55,sortable:false},
				{name:'column5',index:'column5', width:55,align:'center',sortable:false},
				{name:'column6',index:'column6', width:35,sortable:false,align:'center'},
				{name:'column7',index:'column7', width:75,sortable:false,align:'center'},
				{name:'column8',index:'column8', width:35,sortable:false,align:'center'},
				{name:'aksi',index:'aksi', width:91,align:'center',hidden:false,formatter:formatterAction,hidden:true}
			],
			rowNum:10, 
			rowList:[10,20,30], 
			pager: jQuery('#pagert_gudangapt'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				keyword=$('#keywordt_gudang').val()?$('#keywordt_gudang').val():'';
				carinama=$('#carinamat_gudang').val()?$('#carinamat_gudang').val():'';
				$('#listt_gudangapt').setGridParam({postData:{'keyword':keyword,'cari':carinama}})
			},
			
			multiselect: false, 
			subGrid: true, 
			subGridRowExpanded: function(subgrid_id, row_id) {
				achtungHideLoader();
				var subgrid_table_id_gudang_puskesmas, pager_id_gudang_puskesmas; 
				subgrid_table_id_gudang_puskesmas = subgrid_id+"_t_riwayat2b";
				pager_id_gudang_puskesmas = 'p2b_'+subgrid_table_id_gudang_puskesmas;
				var rowval = $('#listt_gudangapt').jqGrid('getRowData', row_id);
				var kd_puskesmas = rowval.kd_pkm;
				var level = rowval.column7;		
				var kd_obat = rowval.column0;		
				
				var htm='';
				//htm += '<div class="subgridtitle">Data Terlaksana</div>';
				htm +="<table id='"+subgrid_table_id_gudang_puskesmas+"' class='scroll'></table><div id='"+pager_id_gudang_puskesmas+"' class='scroll'></div>";
				$("#"+subgrid_id).append(htm);
					
					jQuery("#"+subgrid_table_id_gudang_puskesmas).jqGrid({			
					url:'t_gudang/t_subgridgudangxmlapt', 
					rownumbers:true,
					mtype: 'POST',
					width: 850,
					height: 'auto',
					// datatype: "xml", colNames: ['Kode','Tanggal Transaksi','No. Faktur',/*'Jenis Transaksi',*/'Terima dari','Kirim ke','Jumlah'/*,'Stok Awal','Stok Akhir'*/], 
					// colModel: [ 
					// 			{name:'id',index:'id', width:5,hidden:true},
					// 			{name:"tanggal_terima",index:"tanggal_terima",width:120,align:'center',sortable:false}, 
					// 			{name:"flag",index:"flag",width:90,align:'center',sortable:false}, 
					// 			//{name:"jns_trans",index:"jns_trans",width:90,align:'center',sortable:false}, 
					// 			{name:"terima",index:"terima",width:80,align:'center',sortable:false}, 
					// 			{name:"kirim",index:"kirim",width:91,align:"center",sortable:false}, 
					// 			{name:"jlh",index:"jlh",width:91,align:"center",sortable:false} 		
					// 			/*{name:'st_awal',index:'st_awal', width:131,align:'center',sortable:false},
					// 			{name:'st_akhir',index:'st_akhir', width:101,align:'center',sortable:false},*/
					// 			//{name:'myid',index:'myid', width:70,align:'center',formatter:formatterActionsub},
					// 			],
					datatype: "xml", colNames: ['Kode','Tanggal Transaksi','No. Faktur','Jenis Transaksi','Terima dari','Kirim ke','Jumlah'/*,'Stok Awal','Stok Akhir'*/], 
					colModel: [ 
								{name:'id',index:'id', width:5,hidden:true},
								{name:"tanggal_terima",index:"tanggal_terima",width:120,align:'center',sortable:false}, 
								{name:"jns_trans",index:"jns_trans",width:90,align:'center',sortable:false}, 
								{name:"flag",index:"flag",width:90,align:'center',sortable:false}, 
								{name:"terima",index:"terima",width:80,align:'center',sortable:false}, 
								{name:"kirim",index:"kirim",width:91,align:"center",sortable:false}, 
								{name:"jlh",index:"jlh",width:91,align:"center",sortable:false} 		
								/*{name:'st_awal',index:'st_awal', width:131,align:'center',sortable:false},
								{name:'st_akhir',index:'st_akhir', width:101,align:'center',sortable:false},*/
								//{name:'myid',index:'myid', width:70,align:'center',formatter:formatterActionsub},
								],
					rowNum:5, 
					pager: pager_id_gudang_puskesmas,
					loadComplete:function(data){
						console.log(data);
					},
					beforeRequest:function(){
						$('#'+subgrid_table_id_gudang_puskesmas).setGridParam({postData:{'kd_puskesmas':kd_puskesmas,'level':level,'kd_obat':kd_obat}})
					}
				});
			},subGridBeforeExpand:function(subgrid_id,row_id){
				achtungShowLoader();
			}
	}).navGrid('#pagert_gudangapt',{edit:false,add:false,del:false,search:false});
	
	function formatterAction(cellvalue, options, rowObject) {
		var content = '';
		//content  += '<a rel="' + cellvalue + '" class="icon-detail"  title="View"></a> ';
		content  += '<a id="pkm" rel="' + cellvalue + '" class="icon-edit" title="Edit PKM?"></a>';
		content  += '<a id="dk" rel="' + cellvalue + '" class="icon-edit2" title="Edit DK?"></a>';
		//content  += '<a rel="' + cellvalue + '" class="icon-delete" title="Remove?"></a>';
		return content;
	}
	
	$("#listt_gudang .icon-detail").live('click', function(f){
		if($(f.target).data('oneclicked')!='yes')
		{
			$("#t304","#tabs").empty();
			$("#t304","#tabs").load('t_gudang/detail'+'?id='+this.rel);
		}
		$(f.target).data('oneclicked','yes');
	});
	
	$("#listt_gudang .icon-edit").live('click', function(f){
		if($(f.target).data('oneclicked')!='yes')
		{
			$("#t304","#tabs").empty();
			$("#t304","#tabs").load('t_gudang/edit_pkm'+'?id='+this.rel);
		}
		$(f.target).data('oneclicked','yes');		
	});
	
	$("#listt_gudang .icon-edit2").live('click', function(g){
		if($(g.target).data('oneclicked')!='yes')
		{
			$("#t304","#tabs").empty();
			$("#t304","#tabs").load('t_gudang/edit_dk'+'?id='+this.rel);
		}
		$(g.target).data('oneclicked','yes');		
	});
	
	function deldata(myid){
		achtungShowLoader();
		$.ajax({
			  url: 't_gudang/delete',
			  type: "post",
			  data: {id:myid},
			  dataType: "json",
			  success: function(msg){
				if(msg == 'OK'){
					$("#dialogt_gudang").dialog("close");
					$.achtung({message: 'Proses Hapus Data Berhasil', timeout:5});
					$('#listt_gudang').trigger("reloadGrid");							
				}
				else{						
					$("#dialogt_gudang").dialog("close");
					$.achtung({message: 'Maaf Proses Hapus Data Gagal', timeout:5});
				}						
			  }
		  });
		achtungHideLoader();
	}
	
	$("#listt_gudang .icon-delete").live('click', function(){
		var myid= this.rel;
		$("#dialogt_gudang").dialog({
		  autoOpen: false,
          modal:true,
		  buttons : {
			"Confirm" : function() {
				deldata(myid);
			},
			"Cancel" : function() {
			  $(this).dialog("close");
			}
		  }
		});
		
		$("#dialogt_gudang").dialog("open");
	});
	
	$('form').resize(function(e) {
		if($("#listt_gudang").getGridParam("records")>0){
		jQuery('#listt_gudang').setGridWidth(($(this).width()-28));
		}
	});
	
	$('form').resize(function(e) {
		if($("#listt_gudangapt").getGridParam("records")>0){
		jQuery('#listt_gudangapt').setGridWidth(($(this).width()-28));
		}
	});
	
	$('input:radio[name="tampilan_data_gudang"]').change(
    function(){
        if ($(this).is(':checked') && $(this).val() == 'gudangpuskesmas') {
			jQuery("#Gudang_grid_pasien").show();
			$('#listt_gudang').trigger("reloadGrid");
			jQuery("#Gudang_grid_antrian").hide();
        }else{
			jQuery("#Gudang_grid_antrian").show();
			$('#listt_gudangapt').trigger("reloadGrid");
			jQuery("#Gudang_grid_pasien").hide();
		}
    });
	
	function formattermou(cellvalue, options, rowObject) {
		var content = '';
		if(cellvalue){		
			content  += '<a href="tmp/t_gudang/' + cellvalue + '" style="color:blue;cursor:pointer" title="">download</a>';
		}else{
			content  += ' - ';
		}
		return content;
	}
	
	$('#t_gudangadd').click(function(){
		$("#t304","#tabs").empty();
		$("#t304","#tabs").load('t_gudang/add'+'?_=' + (new Date()).getTime());
	});
	
	$('#t_gudangkeluar').click(function(){
		$("#t304","#tabs").empty();
		$("#t304","#tabs").load('t_gudang/obatkeluar'+'?_=' + (new Date()).getTime());
	});
	
	$( "#sampait_gudang" )
		.keypress(function(event) {
			var keycode =(event.keyCode?event.keyCode:event.which);	
			if(keycode ==13){
				event.preventDefault();
				$('#listt_gudang').trigger("reloadGrid");
			}
	});
	
	$('#darit_gudang').datepicker({dateFormat: "dd-mm-yy",changeYear: true,onSelect: function(dateText, inst){$('#sampait_gudang').datepicker('option', 'minDate', dateText);$.datepicker._clearDate('#sampait_gudang');}});
	$('#sampait_gudang').datepicker({dateFormat: "dd-mm-yy",changeYear: true,onClose: function(dateText, inst){$('#listt_gudang').trigger("reloadGrid");}});
	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	$("#resett_gudang").live('click', function(event){
		event.preventDefault();
		$('#formt_gudang').reset();
		$('#listt_gudang').trigger("reloadGrid");
	});
	$("#carit_gudang").live('click', function(event){
		event.preventDefault();
		$('#listt_gudang').trigger("reloadGrid");
	});
})
