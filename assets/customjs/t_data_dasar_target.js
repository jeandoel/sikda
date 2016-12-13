jQuery().ready(function (){ 
	jQuery("#listt_data_dasar_target").jqGrid({ 
		url:'t_data_dasar_target/t_datadasartargetxml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['kode','Kode Kecamatan','Kode Kelurahan','Kecamatan','Kelurahan','Tahun','Jml Bayi','Jml Balita','Jml Anak','Jml Caten','Jml WUS Hamil','Jml WUS Tidak Hamil', 'Action'],
		rownumbers:true,
		width: 1021,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[ 
				{name:'id',index:'id', width:5,hidden:true},
				{name:'kodekecamatan',index:'kodekecamatan', width:70,hidden:true}, 
				{name:'namadesa',index:'namadesa', width:70,hidden:true}, 
				{name:'a',index:'a', width:70}, 
				{name:'a',index:'a', width:70}, 
				{name:'tahun',index:'tahun', width:50}, 
				{name:'jmlbayi',index:'jmlbayi', width:50}, 
				{name:'jmlbalita',index:'jmlbalita', width:50}, 
				{name:'jmlanak',index:'jmlanak', width:50}, 
				{name:'jmlcaten',index:'jmlcaten', width:50}, 
				{name:'jmlwushamil',index:'jmlwushamil', width:70}, 
				{name:'jmlwustdkhamil',index:'jmlwustdkhamil', width:90}, 
				{name:'myid',index:'myid', width:70,align:'center',formatter:formatterAction}
			],
			rowNum:10, 
			rowList:[10,20,30], 
			pager: jQuery('#pagert_data_dasar_target'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				kodedatadasartarget=$('#kodedatadasartargett_data_dasar_target').val()?$('#kodedatadasartargett_data_dasar_target').val():'';
				carinama=$('#carinamadatadasartarget').val()?$('#carinamadatadasartarget').val():'';
			$('#listt_data_dasar_target').setGridParam({postData:{'kodedatadasartarget':kodedatadasartarget,'carinama':carinama}})
			},
			//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			multiselect: false, 
			subGrid: true, 
			subGridRowExpanded: function(subgrid_id, row_id) {
				achtungHideLoader();
				var subgrid_table_id_data_dasar_target, pager_id_data_dasar_target; 
				subgrid_table_id_data_dasar_target = subgrid_id+"_t_riwayat2b";
				pager_id_data_dasar_target = 'p2b_'+subgrid_table_id_data_dasar_target;
				var rowval = $('#listt_data_dasar_target').jqGrid('getRowData', row_id);
				var kodekecamatan = rowval.kodekecamatan;
				var namadesa = rowval.namadesa;		
				var tahun = rowval.tahun;		
				
				var htm='';
				htm += '<div class="subgridtitle">Data Terlaksana</div>';
				htm +="<table id='"+subgrid_table_id_data_dasar_target+"' class='scroll'></table><div id='"+pager_id_data_dasar_target+"' class='scroll'></div>";
				$("#"+subgrid_id).append(htm);
					
					jQuery("#"+subgrid_table_id_data_dasar_target).jqGrid({			
					url:'t_data_dasar_target/t_subgriddatadasartargetxml', 
					rownumbers:true,
					mtype: 'POST',
					width: 850,
					height: 'auto',
					datatype: "xml", colNames: ['Kode','Tahun','Jumlah Siswa','Jml Anak','Jml Bayi','Jml Balita','Jml Wus Tidak Hamil','Jml WUS Hamil','Pasien Biasa','Jml Caten'], 
					colModel: [ 
								{name:'id',index:'id', width:5,hidden:true},
								{name:"tahun",index:"tahun",width:80,align:'center',sortable:false}, 
								{name:"jumlahsiswa",index:"jumlahsiswa",width:90,align:'center',sortable:false}, 
								{name:"jumlahanak",index:"jumlahanak",width:80,align:'center',sortable:false}, 
								{name:"jmlbayi",index:"jmlbayi",width:91,align:"center",sortable:false}, 
								{name:"jmlbalita",index:"jmlbalita",width:91,align:"center",sortable:false}, 		
								{name:'jmlwustdkhamil',index:'jmlwustdkhamil', width:131,align:'center',sortable:false},
								{name:'jmlwushamil',index:'jmlwushamil', width:101,align:'center',sortable:false},
								{name:'pasienbiasa',index:'pasienbiasa', width:91,align:'center',sortable:false},
								{name:'jmlcaten',index:'jmlcaten', width:61,align:'center',sortable:false},
								//{name:'myid',index:'myid', width:70,align:'center',formatter:formatterActionsub},
								],
					rowNum:5, 
					pager: pager_id_data_dasar_target,
					
					beforeRequest:function(){
							
						$('#'+subgrid_table_id_data_dasar_target).setGridParam({postData:{'namadesa':namadesa,'tahun':tahun,'kodekecamatan':kodekecamatan}})
					}
				});
				/*$("#"+subgrid_table_id_data_dasar_target+" .icon-detail").live('click', function(h){
					if($(h.target).data('oneclicked')!='yes')
					{
						var colid1 = $(this).closest('tr');
						var colid = colid1[0].id;
							$("#"+subgrid_table_id_data_dasar_target).jqGrid('setSelection', colid );
							var myCellDataId = jQuery('#'+subgrid_table_id_data_dasar_target).jqGrid('getCell', colid, 'tahun');
							$("#t442","#tabs").empty();
							$("#t442","#tabs").load('t_data_dasar_target/detailsub'+'?namadesa='+this.rel+'&tahun='+myCellDataId);
					}
					$(h.target).data('oneclicked','yes');
				});*/
			},subGridBeforeExpand:function(subgrid_id,row_id){
				achtungShowLoader();
			}
	}).navGrid('#pagert_data_dasar_target',{edit:false,add:false,del:false,search:false});
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function formatterAction(cellvalue, options, rowObject) {
		var content = '';
		content  += '<a rel="' + cellvalue + '" class="icon-detail" title="View"></a> ';
		content  += '<a rel="' + cellvalue + '" class="icon-edit" title="Edit?"></a>';
		//content  += '<a rel="' + cellvalue + '" class="icon-delete" title="Remove?"></a>';
		return content;
	}
	
	/*function formatterActionsub(cellvalue, options, rowObject) {
		var content = '';
		content  += '<a rel="' + cellvalue + '" class="icon-detail" title="View"></a> ';
		content  += '<a rel="' + cellvalue + '" class="icon-edit" title="Edit?"></a>';
		content  += '<a rel="' + cellvalue + '" class="icon-delete" title="Remove?"></a>';
		return content;
	}*/
	
	$("#listt_data_dasar_target .icon-detail").live('click', function(g){
		if($(g.target).data('oneclicked')!='yes')
		{
			$("#t442","#tabs").empty();
			$("#t442","#tabs").load('t_data_dasar_target/detail'+'?id='+this.rel);
		}
		$(g.target).data('oneclicked','yes');
	});
	
	
	$("#listt_data_dasar_target .icon-edit").live('click', function(g){
		if($(g.target).data('oneclicked')!='yes')
		{
			$("#t442","#tabs").empty();
			$("#t442","#tabs").load('t_data_dasar_target/edit'+'?id='+this.rel);
		}
		$(g.target).data('oneclicked','yes');
	});
	
	/*function deldata(myid){
		achtungShowLoader();
		$.ajax({
			  url: 't_data_dasar_target/delete',
			  type: "post",
			  data: {kodedatadasartarget:myid},
			  dataType: "json",
			  success: function(msg){
				if(msg == 'OK'){
					$("#dialogdatadasartarget").dialog("close");
					$.achtung({message: 'Proses Hapus Data Berhasil', timeout:5});
					$('#listt_data_dasar_target').trigger("reloadGrid");							
				}
				else{						
					$("#dialogdatadasartarget").dialog("close");
					$.achtung({message: 'Maaf Proses Hapus Data Gagal', timeout:5});
				}						
			  }
		  });
		achtungHideLoader();
	}*/
	
	/*$(" .icon-delete").live('click', function(){
		var myid= this.rel;
		$("#dialogdatadasartarget").dialog({
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
		
		$("#dialogdatadasartarget").dialog("open");
	});*/
	
	$('form').resize(function(g) {
		if($("#listt_data_dasar_target").getGridParam("records")>0){
		jQuery('#listt_data_dasar_target').setGridWidth(($(this).width()-28));
		}
	});
	
	function formattermou(cellvalue, options, rowObject) {
		var content = '';
		if(cellvalue){		
			content  += '<a href="tmp/t_data_dasar_target/' + cellvalue + '" style="color:blue;cursor:pointer" title="">download</a>';
		}else{
			content  += ' - ';
		}
		return content;
	}
	
	$('#t_data_dasar_target_add').click(function(){
		$("#t442","#tabs").empty();
		$("#t442","#tabs").load('t_data_dasar_target/add'+'?_=' + (new Date()).getTime());
	});
	
	$( "#sampait_data_dasar_target" )
		.keypress(function(event) {
			var keycode =(event.keyCode?event.keyCode:event.which);	
			if(keycode ==13){
				event.preventDefault();
				$('#listt_data_dasar_target').trigger("reloadGrid");
			}			
	});
	

	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	$("#resett_data_dasar_target").live('click', function(event){
		event.preventDefault();
		$('#formt_data_dasar_target').reset();
		$('#listt_data_dasar_target').trigger("reloadGrid");
	});
	$("#carit_data_dasar_target").live('click', function(event){
		event.preventDefault();
		$('#listt_data_dasar_target').trigger("reloadGrid");
	});
})