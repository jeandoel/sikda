jQuery().ready(function (){ 
	jQuery("#listmasterusers").jqGrid({ 
		url:'c_master_users/masterusersxml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['KD USER','KD PUSKESMAS','USER NAME','FULL NAME','USER DESC','USER PASSWORD','USER PASSWORD 2',
		'EMAIL','GROUP ID','MUST CHG PASS','CANNOT CHG PASS','PASS NEVER EXPIRES','ACC DISABLED','ACC LOCKED OUT',
		'ACC EXPIRES','END OF EXPIRES','LAST LOGON','BAD LOGON ATTEMPS','Action'],
		rownumbers:true,
		width: 1000,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[ 
				{name:'kduser',index:'kduser', width:75}, 
				{name:'kdpuskesmas',index:'kdpuskesmas', width:100},
				{name:'username',index:'username', width:100},
				{name:'fullname',index:'fullname', width:100},
				{name:'userdesc',index:'userdesc', width:100,hidden:true},
				{name:'userpassword',index:'userpassword', width:150},
				{name:'userpassword2',index:'userpassword2', width:100,hidden:true},
				{name:'email',index:'email', width:100},
				{name:'groupid',index:'groupid', width:100},
				{name:'mustchgpass',index:'mustchgpass', width:100,hidden:true},
				{name:'cannotchgpass',index:'cannotchgpass', width:100,hidden:true},
				{name:'passneverexpires',index:'passneverexpires', width:100,hidden:true},
				{name:'accdisabled',index:'accdisabled', width:100,hidden:true},
				{name:'acclockedout',index:'acclockedout', width:100,hidden:true},
				{name:'accexpires',index:'accexpires', width:100,hidden:true},
				{name:'endofexpires',index:'endofexpires', width:100,hidden:true},
				{name:'lastlogon',index:'lastlogon', width:100,hidden:true},
				{name:'badlogonattemps',index:'badlogonattemps', width:100,hidden:true},
				{name:'x',index:'x', width:91,align:'center',formatter:formatterAction}
			],
			rowNum:10, 
			rowList:[10,20,30], 
			pager: jQuery('#pagermasterusers'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				user=$('#usermasteruser').val()?$('#usermasteruser').val():'';
				$('#listmasterusers').setGridParam({postData:{'user':user}})
			}
	}).navGrid('#pagermasterusers',{edit:false,add:false,del:false,search:false});
	
	function formatterAction(cellvalue, options, rowObject) {
		var content = '';
		content  += '<a rel="' + cellvalue + '" class="icon-detail" title="View"></a> ';
		content  += '<a rel="' + cellvalue + '" class="icon-edit" title="Edit?"></a>';
		if($('#group_id').val()=='kabupaten'){
			content  += '<a rel="' + cellvalue + '" class="icon-delete" title="Remove?"></a>';
		}
		return content;
	}
	
	$("#listmasterusers .icon-detail").live('click', function(c){
	if($(c.target).data('oneclicked')!='yes')
		{
		$("#t75","#tabs").empty();
		$("#t75","#tabs").load('c_master_users/detail'+'?id='+this.rel);
		}
		$(c.target).data('oneclicked','yes');
	});
	
	$("#listmasterusers .icon-edit").live('click', function(c){
	if($(c.target).data('oneclicked')!='yes')
		{
		$("#t75","#tabs").empty();
		$("#t75","#tabs").load('c_master_users/edit'+'?id='+this.rel);
		}
		$(c.target).data('oneclicked','yes');
	});
	
	function deldata(myid){
		achtungShowLoader();
		$.ajax({
			  url: 'c_master_users/delete',
			  type: "post",
			  data: {id:myid},
			  dataType: "json",
			  success: function(msg){
				if(msg == 'OK'){
					$("#dialogmasterusers").dialog("close");
					$.achtung({message: 'Proses Hapus Data Berhasil', timeout:5});
					$('#listmasterusers').trigger("reloadGrid");							
				}
				else{						
					$("#dialogmasterusers").dialog("close");
					$.achtung({message: 'Maaf Proses Hapus Data Gagal', timeout:5});
				}						
			  }
		  });
		achtungHideLoader();
	}
	
	$("#listmasterusers .icon-delete").live('click', function(){
		var myid= this.rel;
		$("#dialogmasterusers").dialog({
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
		
		$("#dialogmasterusers").dialog("open");
	});
	
	$('form').resize(function(c) {
		if($("#listmasterusers").getGridParam("records")>0){
		jQuery('#listmasterusers').setGridWidth(($(this).width()-28));
		}
	});
	
	function formattermou(cellvalue, options, rowObject) {
		var content = '';
		if(cellvalue){		
			content  += '<a href="tmp/masterusers/' + cellvalue + '" style="color:blue;cursor:pointer" title="">download</a>';
		}else{
			content  += ' - ';
		}
		return content;
	}
	
	$('#v_master_users_add').click(function(){
		$("#t75","#tabs").empty();
		$("#t75","#tabs").load('c_master_users/add'+'?_=' + (new Date()).getTime());
	});
	
	$( "#sampaimasterusers" )
		.keypress(function(event) {
			var keycode =(event.keyCode?event.keyCode:event.which);	
			if(keycode ==13){
				event.preventDefault();
				$('#listmasterusers').trigger("reloadGrid");
			}
	});
	
	$( "#rolemasterusers" )
		.keypress(function(event) {
			var keycode =(event.keyCode?event.keyCode:event.which);	
			if(keycode ==13){
				event.preventDefault();
				$('#listmasterusers').trigger("reloadGrid");
			}
	});
	
	
	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	$("#resetmasterusers").live('click', function(event){
		event.preventDefault();
		$('#formmasterusers').reset();
		$('#listmasterusers').trigger("reloadGrid");
	});
	$("#carimasterusers").live('click', function(event){
		event.preventDefault();
		$('#listmasterusers').trigger("reloadGrid");
	});
})