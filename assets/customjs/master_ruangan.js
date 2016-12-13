jQuery().ready(function (){ 
	jQuery("#listmaster_ruangan").jqGrid({ 
		url:'c_master_ruangan/master_ruanganxml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['KD RUANGAN','KD RUANGAN','KD PUSKESMAS','NAMA RUANGAN','ACTION'],
		rownumbers:true,
		width: 1021,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[  
				{name:'id',index:'id', width:50, hidden:true}, 		
				{name:'koderuangan',index:'koderuangan', width:50}, 
				{name:'kodepuskesmas',index:'kodepuskesmas', width:50}, 
				{name:'ruangan',index:'ruangan', width:50}, 
				
				{name:'myid',index:'myid', width:50,align:'center',formatter:formatterAction}
			],
			rowNum:10, 
			rowList:[10,20,30], 
			pager: jQuery('#pagermaster_ruangan'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				koderuangan=$('#koderuanganmaster_ruangan').val()?$('#koderuanganmaster_ruangan').val():'';
				$('#listmaster_ruangan').setGridParam({postData:{'koderuangan':koderuangan}})
			}
	}).navGrid('#pagermaster_ruangan',{edit:false,add:false,del:false,search:false});
	
	function formatterAction(cellvalue, options, rowObject) {
		var content = '';
		content  += '<a rel="' + cellvalue + '" class="icon-detail" title="View"></a> ';
		content  += '<a rel="' + cellvalue + '" class="icon-edit" title="Edit?"></a>';
		content  += '<a rel="' + cellvalue + '" class="icon-delete" title="Remove?"></a>';
		return content;
	}
	
	$("#listmaster_ruangan .icon-detail").live('click', function(g){
		if($(g.target).data('oneclicked')!='yes')
		{
			$("#t45","#tabs").empty();
			$("#t45","#tabs").load('c_master_ruangan/detail'+'?koderuangan='+this.rel);
		}
		$(g.target).data('oneclicked','yes');
	});
	
	$("#listmaster_ruangan .icon-edit").live('click', function(g){
		if($(g.target).data('oneclicked')!='yes')
		{
			$("#t45","#tabs").empty();
			$("#t45","#tabs").load('c_master_ruangan/edit'+'?koderuangan='+this.rel);
		}
		$(g.target).data('oneclicked','yes');
	});
	
	function deldata(myid){
		achtungShowLoader();
		$.ajax({
			  url: 'c_master_ruangan/delete',
			  type: "post",
			  data: {koderuangan:myid},
			  dataType: "json",
			  success: function(msg){
				if(msg == 'OK'){
					$("#dialogruangan").dialog("close");
					$.achtung({message: 'Proses Hapus Data Berhasil', timeout:5});
					$('#listmaster_ruangan').trigger("reloadGrid");							
				}
				else{						
					$("#dialogruangan").dialog("close");
					$.achtung({message: 'Maaf Proses Hapus Data Gagal', timeout:5});
				}						
			  }
		  });
		achtungHideLoader();
	}
	
	$("#listmaster_ruangan .icon-delete").live('click', function(){
		var myid= this.rel;
		$("#dialogruangan").dialog({
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
		
		$("#dialogruangan").dialog("open");
	});
	
	$('form').resize(function(g) {
		if($("#listmaster_ruangan").getGridParam("records")>0){
		jQuery('#listmaster_ruangan').setGridWidth(($(this).width()-28));
		}
	});
	
	function formattermou(cellvalue, options, rowObject) {
		var content = '';
		if(cellvalue){		
			content  += '<a href="tmp/c_master_ruangan/' + cellvalue + '" style="color:blue;cursor:pointer" title="">download</a>';
		}else{
			content  += ' - ';
		}
		return content;
	}
	
	$('#master_ruangan_add').click(function(){
		$("#t45","#tabs").empty();
		$("#t45","#tabs").load('c_master_ruangan/add'+'?_=' + (new Date()).getTime());
	});
	
	$( "#sampaimaster_ruangan" )
		.keypress(function(event) {
			var keycode =(event.keyCode?event.keyCode:event.which);	
			if(keycode ==13){
				event.preventDefault();
				$('#listmaster_ruangan').trigger("reloadGrid");
			}			
	});
	
	$( "#koderuanganmaster_ruangan" )
		.keypress(function(event) {
			var keycode =(event.keyCode?event.keyCode:event.which);	
			if(keycode ==13){
				event.preventDefault();
				$('#listmaster_ruangan').trigger("reloadGrid");
			}			
	});

	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	$("#resetmaster_ruangan").live('click', function(event){
		event.preventDefault();
		$('#formmaster_ruangan').reset();
		$('#listmaster_ruangan').trigger("reloadGrid");
	});
	$("#carimaster_ruangan").live('click', function(event){
		event.preventDefault();
		$('#listmaster_ruangan').trigger("reloadGrid");
	});
})