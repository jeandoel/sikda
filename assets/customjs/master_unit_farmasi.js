jQuery().ready(function (){ 
	jQuery("#listmaster_unitfarmasi").jqGrid({ 
		url:'c_master_unit_farmasi/master_unitfarmasixml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['KD UNIT FARMASI','KD UNIT FARMASI','NAMA UNIT FARMASI','FARMASI UTAMA?','ACTION'],
		rownumbers:true,
		width: 1021,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[  
				{name:'id',index:'id', width:50, hidden:true}, 		
				{name:'kodeunitfarmasi',index:'kodeunitfarmasi', width:50}, 
				{name:'unitfarmasi',index:'unitfarmasi', width:50}, 
				{name:'farmasiutama',index:'farmasiutama', width:50}, 
				{name:'myid',index:'myid', width:50,align:'center',formatter:formatterAction}
			],
			rowNum:10, 
			rowList:[10,20,30], 
			pager: jQuery('#pagermaster_unitfarmasi'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				kodeunitfarmasi=$('#kodeunitfarmasimaster_unitfarmasi').val()?$('#kodeunitfarmasimaster_unitfarmasi').val():'';
				$('#listmaster_unitfarmasi').setGridParam({postData:{'kodeunitfarmasi':kodeunitfarmasi}})
			}
	}).navGrid('#pagermaster_unitfarmasi',{edit:false,add:false,del:false,search:false});
	
	function formatterAction(cellvalue, options, rowObject) {
		var content = '';
		content  += '<a rel="' + cellvalue + '" class="icon-detail" title="View"></a> ';
		content  += '<a rel="' + cellvalue + '" class="icon-edit" title="Edit?"></a>';
		content  += '<a rel="' + cellvalue + '" class="icon-delete" title="Remove?"></a>';
		return content;
	}
	
	$("#listmaster_unitfarmasi .icon-detail").live('click', function(g){
		if($(g.target).data('oneclicked')!='yes')
		{
			$("#t44","#tabs").empty();
			$("#t44","#tabs").load('c_master_unit_farmasi/detail'+'?kodeunitfarmasi='+this.rel);
		}
		$(g.target).data('oneclicked','yes');
	});
	
	$("#listmaster_unitfarmasi .icon-edit").live('click', function(g){
		if($(g.target).data('oneclicked')!='yes')
		{
			$("#t44","#tabs").empty();
			$("#t44","#tabs").load('c_master_unit_farmasi/edit'+'?kodeunitfarmasi='+this.rel);
		}
		$(g.target).data('oneclicked','yes');
	});
	
	function deldata(myid){
		achtungShowLoader();
		$.ajax({
			  url: 'c_master_unit_farmasi/delete',
			  type: "post",
			  data: {kodeunitfarmasi:myid},
			  dataType: "json",
			  success: function(msg){
				if(msg == 'OK'){
					$("#dialogunitfarmasi").dialog("close");
					$.achtung({message: 'Proses Hapus Data Berhasil', timeout:5});
					$('#listmaster_unitfarmasi').trigger("reloadGrid");							
				}
				else{						
					$("#dialogunitfarmasi").dialog("close");
					$.achtung({message: 'Maaf Proses Hapus Data Gagal', timeout:5});
				}						
			  }
		  });
		achtungHideLoader();
	}
	
	$("#listmaster_unitfarmasi .icon-delete").live('click', function(){
		var myid= this.rel;
		$("#dialogunitfarmasi").dialog({
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
		
		$("#dialogunitfarmasi").dialog("open");
	});
	
	$('form').resize(function(g) {
		if($("#listmaster_unitfarmasi").getGridParam("records")>0){
		jQuery('#listmaster_unitfarmasi').setGridWidth(($(this).width()-28));
		}
	});
	
	function formattermou(cellvalue, options, rowObject) {
		var content = '';
		if(cellvalue){		
			content  += '<a href="tmp/c_master_unit_farmasi/' + cellvalue + '" style="color:blue;cursor:pointer" title="">download</a>';
		}else{
			content  += ' - ';
		}
		return content;
	}
	
	$('#master_unitfarmasi_add').click(function(){
		$("#t44","#tabs").empty();
		$("#t44","#tabs").load('c_master_unit_farmasi/add'+'?_=' + (new Date()).getTime());
	});
	
	$( "#sampaimaster_unitfarmasi" )
		.keypress(function(event) {
			var keycode =(event.keyCode?event.keyCode:event.which);	
			if(keycode ==13){
				event.preventDefault();
				$('#listmaster_unitfarmasi').trigger("reloadGrid");
			}			
	});
	
	$( "#kodeunitfarmasimaster_unitfarmasi" )
		.keypress(function(event) {
			var keycode =(event.keyCode?event.keyCode:event.which);	
			if(keycode ==13){
				event.preventDefault();
				$('#listmaster_unitfarmasi').trigger("reloadGrid");
			}			
	});

	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	$("#resetmaster_unitfarmasi").live('click', function(event){
		event.preventDefault();
		$('#formmaster_unitfarmasi').reset();
		$('#listmaster_unitfarmasi').trigger("reloadGrid");
	});
	$("#carimaster_unitfarmasi").live('click', function(event){
		event.preventDefault();
		$('#listmaster_unitfarmasi').trigger("reloadGrid");
	});
})