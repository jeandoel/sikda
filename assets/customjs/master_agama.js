jQuery().ready(function (){ 
	jQuery("#listmaster_agama").jqGrid({ 
		url:'c_master_agama/master_agamaxml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['KD AGAMA','KD AGAMA','AGAMA','ACTION'],
		rownumbers:true,
		width: 1021,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[  
				{name:'id',index:'id', width:50, hidden:true}, 		
				{name:'kodeagama',index:'kodeagama', width:50}, 
				{name:'agama',index:'agama', width:50}, 
				{name:'myid',index:'myid', width:50,align:'center',formatter:formatterAction}
			],
			rowNum:10, 
			rowList:[10,20,30], 
			pager: jQuery('#pagermaster_agama'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				kodeagama=$('#kodeagamamaster_agama').val()?$('#kodeagamamaster_agama').val():'';
				$('#listmaster_agama').setGridParam({postData:{'kodeagama':kodeagama}})
			}
	}).navGrid('#pagermaster_agama',{edit:false,add:false,del:false,search:false});
	
	function formatterAction(cellvalue, options, rowObject) {
		var content = '';
		content  += '<a rel="' + cellvalue + '" class="icon-detail" title="View"></a> ';
		content  += '<a rel="' + cellvalue + '" class="icon-edit" title="Edit?"></a>';
		content  += '<a rel="' + cellvalue + '" class="icon-delete" title="Remove?"></a>';
		return content;
	}
	
	$("#listmaster_agama .icon-detail").live('click', function(g){
		if($(g.target).data('oneclicked')!='yes')
		{
			$("#t41","#tabs").empty();
			$("#t41","#tabs").load('c_master_agama/detail'+'?kodeagama='+this.rel);
		}
		$(g.target).data('oneclicked','yes');
	});
	
	$("#listmaster_agama .icon-edit").live('click', function(g){
		if($(g.target).data('oneclicked')!='yes')
		{
			$("#t41","#tabs").empty();
			$("#t41","#tabs").load('c_master_agama/edit'+'?kodeagama='+this.rel);
		}
		$(g.target).data('oneclicked','yes');
	});
	
	function deldata(myid){
		achtungShowLoader();
		$.ajax({
			  url: 'c_master_agama/delete',
			  type: "post",
			  data: {kodeagama:myid},
			  dataType: "json",
			  success: function(msg){
				if(msg == 'OK'){
					$("#dialogagama").dialog("close");
					$.achtung({message: 'Proses Hapus Data Berhasil', timeout:5});
					$('#listmaster_agama').trigger("reloadGrid");							
				}
				else{						
					$("#dialogagama").dialog("close");
					$.achtung({message: 'Maaf Proses Hapus Data Gagal', timeout:5});
				}						
			  }
		  });
		achtungHideLoader();
	}
	
	$("#listmaster_agama .icon-delete").live('click', function(){
		var myid= this.rel;
		$("#dialogagama").dialog({
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
		
		$("#dialogagama").dialog("open");
	});
	
	$('form').resize(function(g) {
		if($("#listmaster_agama").getGridParam("records")>0){
		jQuery('#listmaster_agama').setGridWidth(($(this).width()-28));
		}
	});
	
	function formattermou(cellvalue, options, rowObject) {
		var content = '';
		if(cellvalue){		
			content  += '<a href="tmp/c_master_agama/' + cellvalue + '" style="color:blue;cursor:pointer" title="">download</a>';
		}else{
			content  += ' - ';
		}
		return content;
	}
	
	$('#master_agama_add').click(function(){
		$("#t41","#tabs").empty();
		$("#t41","#tabs").load('c_master_agama/add'+'?_=' + (new Date()).getTime());
	});
	
	$( "#sampaimaster_agama" )
		.keypress(function(event) {
			var keycode =(event.keyCode?event.keyCode:event.which);	
			if(keycode ==13){
				event.preventDefault();
				$('#listmaster_agama').trigger("reloadGrid");
			}			
	});
	
	$( "#kodeagamamaster_agama" )
		.keypress(function(event) {
			var keycode =(event.keyCode?event.keyCode:event.which);	
			if(keycode ==13){
				event.preventDefault();
				$('#listmaster_agama').trigger("reloadGrid");
			}			
	});

	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	$("#resetmaster_agama").live('click', function(event){
		event.preventDefault();
		$('#formmaster_agama').reset();
		$('#listmaster_agama').trigger("reloadGrid");
	});
	$("#carimaster_agama").live('click', function(event){
		event.preventDefault();
		$('#listmaster_agama').trigger("reloadGrid");
	});
})