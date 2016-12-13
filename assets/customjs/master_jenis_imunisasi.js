jQuery().ready(function (){ 
	jQuery("#listmaster_jenis_imunisasi").jqGrid({ 
		url:'c_master_jenis_imunisasi/jenisimunisasixml', 
		emptyrecords: 'Tidak ada data',
		datatype: "xml", 
		colNames:['KD Jenis Imunisasi','Kode Jenis Imunisasi','Jenis Imunisasi','Action'],
		rownumbers:true,
		width: 1021,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[  
				{name:'id',index:'id', width:50, hidden:true}, 		
				{name:'kodejenisimunisasi',index:'kodejenisimunisasi', width:30}, 
				{name:'jenisimunisasi',index:'jenisimunisasi', width:50}, 
				{name:'myid',index:'myid', width:15,align:'center',formatter:formatterAction}
			],
			rowNum:10, 
			rowList:[10,20,30], 
			pager: jQuery('#pagermaster_jenis_imunisasi'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				carijenisimunisasi=$('#cariimunisasi').val()?$('#cariimunisasi').val():'';
				$('#listmaster_jenis_imunisasi').setGridParam({postData:{'carijenisimunisasi':carijenisimunisasi}})
			}
	}).navGrid('#pagermaster_jenis_imunisasi',{edit:false,add:false,del:false,search:false});
	
	function formatterAction(cellvalue, options, rowObject) {
		var content = '';
		content  += '<a rel="' + cellvalue + '" class="icon-detail" title="View"></a> ';
		content  += '<a rel="' + cellvalue + '" class="icon-edit" title="Edit?"></a>';
		content  += '<a rel="' + cellvalue + '" class="icon-delete" title="Remove?"></a>';
		return content;
	}
	
	$("#listmaster_jenis_imunisasi .icon-detail").live('click', function(g){
		if($(g.target).data('oneclicked')!='yes')
		{
			$("#t60","#tabs").empty();
			$("#t60","#tabs").load('c_master_jenis_imunisasi/detail'+'?id='+this.rel);
		}
		$(g.target).data('oneclicked','yes');
	});
	
	$("#listmaster_jenis_imunisasi .icon-edit").live('click', function(g){
		if($(g.target).data('oneclicked')!='yes')
		{
			$("#t60","#tabs").empty();
			$("#t60","#tabs").load('c_master_jenis_imunisasi/edit'+'?id='+this.rel);
		}
		$(g.target).data('oneclicked','yes');
	});
	
	function deldata(myid){
		achtungShowLoader();
		$.ajax({
			  url: 'c_master_jenis_imunisasi/delete',
			  type: "post",
			  data: {id:myid},
			  dataType: "json",
			  success: function(msg){
				if(msg == 'OK'){
					$("#dialogjenisimunisasi_new").dialog("close");
					$.achtung({message: 'Proses Hapus Data Berhasil', timeout:5});
					$('#listmaster_jenis_imunisasi').trigger("reloadGrid");							
				}
				else{						
					$("#dialogjenisimunisasi_new").dialog("close");
					$.achtung({message: 'Maaf Proses Hapus Data Gagal', timeout:5});
				}						
			  }
		  });
		achtungHideLoader();
	}
	
	$("#listmaster_jenis_imunisasi .icon-delete").live('click', function(){
		var myid= this.rel;
		$("#dialogjenisimunisasi_new").dialog({
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
		
		$("#dialogjenisimunisasi_new").dialog("open");
	});
	
	$('form').resize(function(g) {
		if($("#listmaster_jenis_imunisasi").getGridParam("records")>0){
		jQuery('#listmaster_jenis_imunisasi').setGridWidth(($(this).width()-28));
		}
	});
	
	function formattermou(cellvalue, options, rowObject) {
		var content = '';
		if(cellvalue){		
			content  += '<a href="tmp/c_master_jenis_imunisasi/' + cellvalue + '" style="color:blue;cursor:pointer" title="">download</a>';
		}else{
			content  += ' - ';
		}
		return content;
	}
	
	$('#master_jenis_imunisasi_add').click(function(){
		$("#t60","#tabs").empty();
		$("#t60","#tabs").load('c_master_jenis_imunisasi/add'+'?_=' + (new Date()).getTime());
	});

	$("#cariimunisasi")
		.keypress(function(event) {
			var keycode =(event.keyCode?event.keyCode:event.which);	
			if(keycode ==13){
				event.preventDefault();
				$('#listmaster_jenis_imunisasi').trigger("reloadGrid");
			}			
	});

	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	$("#resetmaster_jenis_imunisasi").live('click', function(event){
		event.preventDefault();
		$('#formmaster_jenis_imunisasi').reset();
		$('#listmaster_jenis_imunisasi').trigger("reloadGrid");
	});
	$("#carimaster_jenis_imunisasi").live('click', function(event){
		event.preventDefault();
		$('#listmaster_jenis_imunisasi').trigger("reloadGrid");
	});
})
