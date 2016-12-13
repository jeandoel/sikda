jQuery().ready(function (){ 
	jQuery("#listt_sarana").jqGrid({ 
		url:'t_sarana/t_saranaxml', 
		emptyrecords: 'Tidak ada data',
		datatype: "xml", 
		colNames:['Kode Sarana','a','Nama Sarana','Stok','Action'],
		rownumbers:true,
		width: 1049,
		height: 'auto',
		mtype: 'POST',
		altRows     : false,
		colModel:[ 
				{name:'kd_sarana',index:'kd_sarana', width:35,sortable:false}, 
				{name:'a',index:'a', width:55,hidden:true}, 
				{name:'nama_sarana',index:'nama_sarana', width:55,sortable:false}, 
				{name:'stok',index:'stok', width:55,sortable:false,align:'center'},
				{name:'aksi',index:'aksi', width:55,align:'center',hidden:false,formatter:formatterAction,hidden:true}
			],
			rowNum:10, 
			rowList:[10,20,30], 
			pager: jQuery('#pagert_sarana'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				carisarana=$('#carijenissarana').val()?$('#carijenissarana').val():'';
				$('#listt_sarana').setGridParam({postData:{'carisarana':carisarana}})
			},
			
			multiselect: false, 
			subGrid: true, 
			subGridRowExpanded: function(subgrid_id, row_id) {
				achtungHideLoader();
				var subgrid_table_id_sarana, pager_id_sarana; 
				subgrid_table_id_sarana = subgrid_id+"_t_riwayat2b";
				pager_id_sarana = 'p2b_'+subgrid_table_id_sarana;
				var rowval = $('#listt_sarana').jqGrid('getRowData', row_id);
				var kd_sarana = rowval.kd_sarana;
				var nama_sarana = rowval.nama_sarana;
				
				var htm='';
				htm +="<table id='"+subgrid_table_id_sarana+"' class='scroll'></table><div id='"+pager_id_sarana+"' class='scroll'></div>";
				$("#"+subgrid_id).append(htm);
					
					jQuery("#"+subgrid_table_id_sarana).jqGrid({			
					url:'t_sarana/t_subgridsaranaxml', 
					rownumbers:true,
					mtype: 'POST',
					width: 850,
					height: 'auto',
					datatype: "xml", colNames: ['id trans','KD SARANA','Tanggal','No Faktur','Jenis Transaksi','Asal Sarana','Tujuan Sarana','Jumlah','Stok Awal','Stok Akhir'], 
					colModel: [ 
								{name:"id",index:"id",width:50,align:'center',sortable:false,hidden:true},  
								{name:"kd_sarana",index:"kd_sarana",width:150,align:'center',sortable:false,hidden:true}, 
								{name:"tgl_transaksi",index:"tgl_transaksi",width:150,align:'center',sortable:false}, 
								{name:"no_faktur",index:"no_faktur",width:120,align:'center',sortable:false}, 
								{name:"jenis_transaksi",index:"jenis_transaksi",width:150,align:'center',sortable:false}, 
								{name:"terima",index:"terima",width:130,align:'center',sortable:false}, 
								{name:"kirim",index:"kirim",width:91,align:"center",sortable:false}, 
								{name:"jumlah",index:"jumlah",width:91,align:"center",sortable:false}, 		
								{name:'stok_awal',index:'stok_awal', width:101,align:'center',sortable:false},
								{name:'stok_akhir',index:'stok_akhir', width:101,align:'center',sortable:false}
								],
					rowNum:5,
					rowList:[5,10,20], 
					pager: pager_id_sarana, 
					viewrecords: true, 
					sortorder: "desc",
										
					beforeRequest:function(){
							
						$('#'+subgrid_table_id_sarana).setGridParam({postData:{'kd_sarana':kd_sarana,'nama_sarana':nama_sarana}})
					}
				});
			},subGridBeforeExpand:function(subgrid_id,row_id){
				achtungShowLoader();
			}
	}).navGrid('#pagert_sarana',{edit:false,add:false,del:false,search:false});
	
	function formatterAction(cellvalue, options, rowObject) {
		var content = '';
		content  += '<a rel="' + cellvalue + '" class="icon-detail" title="View"></a> ';
		content  += '<a rel="' + cellvalue + '" class="icon-edit" title="Edit?"></a>';
		content  += '<a rel="' + cellvalue + '" class="icon-delete" title="Remove?"></a>';
		return content;
	}
	
	$("#listt_sarana .icon-detail").live('click', function(f){
		if($(f.target).data('oneclicked')!='yes')
		{
			$("#t305","#tabs").empty();
			$("#t305","#tabs").load('t_sarana/detail'+'?id='+this.rel);
		}
		$(f.target).data('oneclicked','yes');
	});
	
	$("#listt_sarana .icon-edit").live('click', function(f){
		if($(f.target).data('oneclicked')!='yes')
		{
			$("#t305","#tabs").empty();
			$("#t305","#tabs").load('t_sarana/edit'+'?id='+this.rel);
		}
		$(f.target).data('oneclicked','yes');		
	});
	
	function deldata(myid){
		achtungShowLoader();
		$.ajax({
			  url: 't_sarana/delete',
			  type: "post",
			  data: {id:myid},
			  dataType: "json",
			  success: function(msg){
				if(msg == 'OK'){
					$("#dialogt_sarana").dialog("close");
					$.achtung({message: 'Proses Hapus Data Berhasil', timeout:5});
					$('#listt_sarana').trigger("reloadGrid");							
				}
				else{						
					$("#dialogt_sarana").dialog("close");
					$.achtung({message: 'Maaf Proses Hapus Data Gagal', timeout:5});
				}						
			  }
		  });
		achtungHideLoader();
	}
	
	$("#listt_sarana .icon-delete").live('click', function(){
		var myid= this.rel;
		$("#dialogt_sarana").dialog({
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
		
		$("#dialogt_sarana").dialog("open");
	});
	
	$('form').resize(function(e) {
		if($("#listt_sarana").getGridParam("records")>0){
		jQuery('#listt_sarana').setGridWidth(($(this).width()-28));
		}
	});
	
	function formattermou(cellvalue, options, rowObject) {
		var content = '';
		if(cellvalue){		
			content  += '<a href="tmp/t_sarana/' + cellvalue + '" style="color:blue;cursor:pointer" title="">download</a>';
		}else{
			content  += ' - ';
		}
		return content;
	}
	
	$('#t_saranamasukadd').click(function(){
		$("#t305","#tabs").empty();
		$("#t305","#tabs").load('t_sarana/addsaranamasuk'+'?_=' + (new Date()).getTime());
	});
	
	$('#t_saranakeluaradd').click(function(){
		$("#t305","#tabs").empty();
		$("#t305","#tabs").load('t_sarana/addsaranakeluar'+'?_=' + (new Date()).getTime());
	});
	
	$("#carijenissarana")
		.keypress(function(event) {
			var keycode =(event.keyCode?event.keyCode:event.which);	
			if(keycode ==13){
				event.preventDefault();
				$('#listt_sarana').trigger("reloadGrid");
			}			
	});
	
	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	$("#resett_sarana").live('click', function(event){
		event.preventDefault();
		$('#formt_sarana').reset();
		$('#listt_sarana').trigger("reloadGrid");
	});
	$("#carit_sarana").live('click', function(event){
		event.preventDefault();
		$('#listt_sarana').trigger("reloadGrid");
	});
})
