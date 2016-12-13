jQuery().ready(function (){  
	jQuery("#listmasterusergroup").jqGrid({ 
		url:'c_master_user_group/masterusergroupxml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['Pilih','Group Id','Group Name','Description','Action'],
		rownumbers:true,
		width: 1021,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[ 
				{name:'id',index:'id', width:75,hidden:true},
				{name:'idgroup',index:'idgroup', width:75},	
				{name:'namagroup',index:'namagroup', width:100},
				{name:'deskripsi',index:'deskripsi', width:100},
				{name:'myid',index:'myid', width:91,align:'center',formatter:formatterAction}
			],
			rowNum:10, 
			rowList:[10,20,30], 
			pager: jQuery('#pagermasterusergroup'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				dari=$('#darimasterusergroup').val()?$('#darimasterusergroup').val():'';
				sampai=$('#sampaimasterusergroup').val()?$('#sampaimasterusergroup').val():'';
				group=$('#groupmastergroup').val()?$('#groupmastergroup').val():'';
				$('#listmasterusergroup').setGridParam({postData:{'dari':dari,'sampai':sampai,'group':group}})
			}
	}).navGrid('#pagermasterusergroup',{edit:false,add:false,del:false,search:false});
	
	function formatterAction(cellvalue, options, rowObject) {
		var content = '';
		content  += '<a rel="' + cellvalue + '" class="icon-detail" title="View"></a> ';
		content  += '<a rel="' + cellvalue + '" class="icon-edit" title="Edit?"></a>';
		content  += '<a rel="' + cellvalue + '" class="icon-delete" title="Remove?"></a>';
		return content;
	}
	
	$("#listmasterusergroup .icon-detail").live('click', function(c){
	if($(c.target).data('oneclicked')!='yes')
		{
		$("#t17","#tabs").empty();
		$("#t17","#tabs").load('c_master_user_group/detail'+'?id='+this.rel);
		}
		$(c.target).data('oneclicked','yes');
	});
	
	$("#listmasterusergroup .icon-edit").live('click', function(c){
	if($(c.target).data('oneclicked')!='yes')
		{
		$("#t17","#tabs").empty();
		$("#t17","#tabs").load('c_master_user_group/edit'+'?id='+this.rel);
		}
		$(c.target).data('oneclicked','yes');
	});
	
	function deldata(myid){
		achtungShowLoader();
		$.ajax({
			  url: 'c_master_user_group/delete',
			  type: "post",
			  data: {id:myid},
			  dataType: "json",
			  success: function(msg){
				if(msg == 'OK'){
					$("#dialogmasterusergroup").dialog("close");
					$.achtung({message: 'Proses Hapus Data Berhasil', timeout:5});
					$('#listmasterusergroup').trigger("reloadGrid");							
				}
				else{						
					$("#dialogmasterusergroup").dialog("close");
					$.achtung({message: 'Maaf Proses Hapus Data Gagal', timeout:5});
				}						
			  }
		  });
		achtungHideLoader();
	}
	
	$("#listmasterusergroup .icon-delete").live('click', function(){
		var myid= this.rel;
		$("#dialogmasterusergroup").dialog({
			autoOpen:false,
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
		
		$("#dialogmasterusergroup").dialog("open");
	});
	
	$('form').resize(function(c) {
		if($("#listmasterusergroup").getGridParam("records")>0){
		jQuery('#listmasterusergroup').setGridWidth(($(this).width()-28));
		}
	});
	
	function formattermou(cellvalue, options, rowObject) {
		var content = '';
		if(cellvalue){		
			content  += '<a href="tmp/masterusergroup/' + cellvalue + '" style="color:blue;cursor:pointer" title="">download</a>';
		}else{
			content  += ' - ';
		}
		return content;
	}
	
	$('#v_master_user_group_add').click(function(){
		$("#t17","#tabs").empty();
		$("#t17","#tabs").load('c_master_user_group/add'+'?_=' + (new Date()).getTime());
	});
	
	$( "#sampaimasterusergroup" )
		.keypress(function(event) {
			var keycode =(event.keyCode?event.keyCode:event.which);	
			if(keycode ==13){
				event.preventDefault();
				$('#listmasterusergroup').trigger("reloadGrid");
			}
	});
	
	$( "#rolemasterusergroup" )
		.keypress(function(event) {
			var keycode =(event.keyCode?event.keyCode:event.which);	
			if(keycode ==13){
				event.preventDefault();
				$('#listmasterusergroup').trigger("reloadGrid");
			}
	});
	
	$('#darimasterusergroup').datepicker({dateFormat: "dd-mm-yy",changeYear: true,onSelect: function(dateText, inst){$('#sampaimasterusergroup').datepicker('option', 'minDate', dateText);$.datepicker._clearDate('#sampaimasterusergroup');}});
	$('#sampaimasterusergroup').datepicker({dateFormat: "dd-mm-yy",changeYear: true,onClose: function(dateText, inst){$('#listmasterusergroup').trigger("reloadGrid");}});
	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	$("#resetmasterusergroup").live('click', function(event){
		event.preventDefault();
		$('#formmasterusergroup').reset();
		$('#listmasterusergroup').trigger("reloadGrid");
	});
	$("#carimasterusergroup").live('click', function(event){
		event.preventDefault();
		$('#listmasterusergroup').trigger("reloadGrid");
	});
})