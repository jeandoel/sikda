jQuery().ready(function (){ 
	jQuery("#listmaster_pendidikan").jqGrid({ 
		url:'c_master_pendidikan/master_pendidikanxml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['KD PENDIDIKAN','KD PENDIDIKAN','PENDIDIKAN','ACTION'],
		rownumbers:true,
		width: 1021,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[  
				{name:'id',index:'id', width:50, hidden:true}, 		
				{name:'kodependidikan',index:'kodependidikan', width:50}, 
				{name:'pendidikan',index:'pendidikan', width:50}, 
				{name:'myid',index:'myid', width:50,align:'center',formatter:formatterAction}
			],
			rowNum:10, 
			rowList:[10,20,30], 
			pager: jQuery('#pagermaster_pendidikan'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				kodependidikan=$('#kodependidikanmaster_pendidikan').val()?$('#kodependidikanmaster_pendidikan').val():'';
				$('#listmaster_pendidikan').setGridParam({postData:{'kodependidikan':kodependidikan}})
			}
	}).navGrid('#pagermaster_pendidikan',{edit:false,add:false,del:false,search:false});
	
	function formatterAction(cellvalue, options, rowObject) {
		var content = '';
		content  += '<a rel="' + cellvalue + '" class="icon-detail" title="View"></a> ';
		content  += '<a rel="' + cellvalue + '" class="icon-edit" title="Edit?"></a>';
		content  += '<a rel="' + cellvalue + '" class="icon-delete" title="Remove?"></a>';
		return content;
	}
	
	$("#listmaster_pendidikan .icon-detail").live('click', function(g){
		if($(g.target).data('oneclicked')!='yes')
		{
			var myrel = this.rel==0?'nol':this.rel;
			$("#t42","#tabs").empty();
			$("#t42","#tabs").load('c_master_pendidikan/detail'+'?kodependidikan='+encodeURIComponent(myrel));
		}
		$(g.target).data('oneclicked','yes');
	});
	
	$("#listmaster_pendidikan .icon-edit").live('click', function(g){
		if($(g.target).data('oneclicked')!='yes')
		{
			var myrel = this.rel==0?'nol':this.rel;
			$("#t42","#tabs").empty();
			$("#t42","#tabs").load('c_master_pendidikan/edit'+'?kodependidikan='+encodeURIComponent(myrel));
		}
		$(g.target).data('oneclicked','yes');
	});
	
	function deldata(myid){
		achtungShowLoader();
		$.ajax({
			  url: 'c_master_pendidikan/delete',
			  type: "post",
			  data: {kodependidikan:myid},
			  dataType: "json",
			  success: function(msg){
				if(msg == 'OK'){
					$("#dialogpendidikan_new").dialog("close");
					$.achtung({message: 'Proses Hapus Data Berhasil', timeout:5});
					$('#listmaster_pendidikan').trigger("reloadGrid");							
				}
				else{						
					$("#dialogpendidikan_new").dialog("close");
					$.achtung({message: 'Maaf Proses Hapus Data Gagal', timeout:5});
				}						
			  }
		  });
		achtungHideLoader();
	}
	
	$("#listmaster_pendidikan .icon-delete").live('click', function(){
		var myid = this.rel==0?'nol':this.rel;
		$("#dialogpendidikan_new").dialog({
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
		
		$("#dialogpendidikan_new").dialog("open");
	});
	
	$('form').resize(function(g) {
		if($("#listmaster_pendidikan").getGridParam("records")>0){
		jQuery('#listmaster_pendidikan').setGridWidth(($(this).width()-28));
		}
	});
	
	function formattermou(cellvalue, options, rowObject) {
		var content = '';
		if(cellvalue){		
			content  += '<a href="tmp/c_master_pendidikan/' + cellvalue + '" style="color:blue;cursor:pointer" title="">download</a>';
		}else{
			content  += ' - ';
		}
		return content;
	}
	
	$('#master_pendidikan_add').click(function(){
		$("#t42","#tabs").empty();
		$("#t42","#tabs").load('c_master_pendidikan/add'+'?_=' + (new Date()).getTime());
	});
	
	$( "#sampaimaster_pendidikan" )
		.keypress(function(event) {
			var keycode =(event.keyCode?event.keyCode:event.which);	
			if(keycode ==13){
				event.preventDefault();
				$('#listmaster_pendidikan').trigger("reloadGrid");
			}			
	});
	
	$( "#kodependidikanmaster_pendidikan" )
		.keypress(function(event) {
			var keycode =(event.keyCode?event.keyCode:event.which);	
			if(keycode ==13){
				event.preventDefault();
				$('#listmaster_pendidikan').trigger("reloadGrid");
			}			
	});

	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	$("#resetmaster_pendidikan").live('click', function(event){
		event.preventDefault();
		$('#formmaster_pendidikan').reset();
		$('#listmaster_pendidikan').trigger("reloadGrid");
	});
	$("#carimaster_pendidikan").live('click', function(event){
		event.preventDefault();
		$('#listmaster_pendidikan').trigger("reloadGrid");
	});
})
