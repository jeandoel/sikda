jQuery().ready(function (){ 
	jQuery("#listmaster_hasupdate").jqGrid({ 
		url:'c_modul_library/modul_libraryxml?action=hasupdate', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['ID','Nama Modul','Space Modul','Tgl. Modifikasi','Action'],
		rownumbers:true,
		width: 1021,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[ 
				{name:'id',index:'id', width:5,hidden:true}, 
				{name:'nama_folder',index:'nama_folder', width:155,align:'center'}, 
				{name:'size',index:'size', width:155,align:'center'}, 
				{name:'date',index:'date', width:100,align:'center'},
				{name:'size',index:'size', width:91,align:'center',formatter:formatterAction3}
			],
			rowNum:10, 
			rowList:[10,20,30], 
			pager: jQuery('#pagermaster_hasupdate'), 
			viewrecords: true, 
			sortorder: "desc"
	}).navGrid('#pagermaster_hasupdate',{edit:false,add:false,del:false,search:false});
	
	function formatterAction3(cellvalue, options, rowObject) {
		var content = '';
		content  += '<a rel="' + cellvalue + '" class="icon-delete" title="Remove?"></a>';
		return content;
	}
	
	jQuery("#listmaster_installed").jqGrid({ 
		url:'c_modul_library/modul_libraryxml?action=doupdate', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['ID','Nama Modul','Space Modul','Tgl. Modifikasi','Action'],
		rownumbers:true,
		width: 1021,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[ 
				{name:'id',index:'id', width:5,hidden:true}, 
				{name:'nama_folder',index:'nama_folder', width:155,align:'center'}, 
				{name:'size',index:'size', width:155,align:'center'}, 
				{name:'date',index:'date', width:100,align:'center'},
				{name:'size',index:'size', width:91,align:'center',formatter:formatterAction}
			],
			rowNum:10, 
			rowList:[10,20,30], 
			pager: jQuery('#pagermaster_installed'), 
			viewrecords: true, 
			sortorder: "desc"
	}).navGrid('#pagermaster_installed',{edit:false,add:false,del:false,search:false});
	
	function formatterAction(cellvalue, options, rowObject) {
		var content = '';
		//content  += '<a rel="' + cellvalue + '" class="icon-detail" title="View"></a> ';
		content  += '<a rel="' + cellvalue + '" class="icon-edit" title="Update"></a>';
		content  += '<a rel="' + cellvalue + '" class="icon-delete" title="Remove?"></a>';
		return content;
	}
	
	jQuery("#listmasterstore").jqGrid({ 
		url:'c_modul_library/modul_libraryxml?action=install', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['ID','Versi','Nama Modul','Deskripsi','Action'],
		rownumbers:true,
		width: 1021,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[ 
				{name:'id',index:'id', width:5,hidden:true}, 
				{name:'nama_folder',index:'nama_folder', width:155,align:'center'}, 
				{name:'size',index:'size', width:155,align:'center'}, 
				{name:'date',index:'date', width:100,align:'center'},
				{name:'size',index:'size', width:91,align:'center',formatter:formatterAction2}
			],
			rowNum:10, 
			rowList:[10,20,30], 
			pager: jQuery('#pagermasterstore'), 
			viewrecords: true, 
			sortorder: "desc"
	}).navGrid('#pagermasterstore',{edit:false,add:false,del:false,search:false});
	
	function formatterAction2(cellvalue, options, rowObject) {
		var content = '';
		//content  += '<a rel="' + cellvalue + '" class="icon-detail" title="View"></a> ';
		content  += '<a rel="' + cellvalue + '" class="icon-edit" title="Install?"></a>';		
		return content;
	}
	
	$("#listmasterstore .icon-edit").live('click', function(d){
		if($(d.target).data('oneclicked')!='yes')
		{
			$("#t1007","#tabs").empty();
			$("#t1007","#tabs").load('c_modul_library/prepare'+'?folder='+this.rel);
		}
		$(d.target).data('oneclicked','yes');
	});
	
	$(".icon-delete").live('click', function(d){
		if($(d.target).data('oneclicked')!='yes')
		{
			$("#t1007","#tabs").empty();
			$("#t1007","#tabs").load('c_modul_library/prepare_uninstall'+'?link='+this.rel);
		}
		$(d.target).data('oneclicked','yes');
	});
	
	/* 
	$("#listmaster .icon-edit").live('click', function(d){
		if($(d.target).data('oneclicked')!='yes')
		{
		$("#t18","#tabs").empty();
		$("#t18","#tabs").load('modul_admin/create_patch'+'?folder='+this.rel);
		
		}
		$(d.target).data('oneclicked','yes');
	});
	
	$("#listmaster .icon-detail").live('click', function(d){
		if($(d.target).data('oneclicked')!='yes')
		{
		$("#t18","#tabs").empty();
		$("#t18","#tabs").load('modul_admin/edit_title'+'?folder='+this.rel);
		
		}
		$(d.target).data('oneclicked','yes');
	}); */
	
	function deldata(myid){
		achtungShowLoader();
		$.ajax({
			  url: 'c_master_installed/delete',
			  type: "post",
			  data: {id:myid},
			  dataType: "json",
			  success: function(msg){
				if(msg == 'OK'){
					$("#dialog").dialog("close");
					$.achtung({message: 'Proses Hapus Data Berhasil', timeout:5});
					$('#listmaster').trigger("reloadGrid");							
				}
				else{						
					$("#dialog").dialog("close");
					$.achtung({message: 'Maaf Proses Hapus Data Gagal', timeout:5});
				}						
			  }
		  });
		achtungHideLoader();
	}
	
	$("#listmaster .icon-delete").live('click', function(){
		var myid= this.rel;
		$("#dialog").dialog({
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
		
		$("#dialog").dialog("open");
	});
	
	$('form').resize(function(e) {
		if($("#listmaster").getGridParam("records")>0){
		jQuery('#listmaster').setGridWidth(($(this).width()-28));
		}
	});
	
	function formattermou(cellvalue, options, rowObject) {
		var content = '';
		if(cellvalue){		
			content  += '<a href="tmp/masterinstalled/' + cellvalue + '" style="color:blue;cursor:pointer" title="">download</a>';
		}else{
			content  += ' - ';
		}
		return content;
	}
	
	$('#masterinstalledadd').click(function(){
		$("#t18","#tabs").empty();
		$("#t18","#tabs").load('c_master_installed/add'+'?_=' + (new Date()).getTime());
	});
	
	$( "#sampaimasterinstalled" )
		.keypress(function(event) {
			var keycode =(event.keyCode?event.keyCode:event.which);	
			if(keycode ==13){
				event.preventDefault();
				$('#listmaster').trigger("reloadGrid");
			}
	});
	
	$( "#namamasterinstalled" )
		.keypress(function(event) {
			var keycode =(event.keyCode?event.keyCode:event.which);	
			if(keycode ==13){
				event.preventDefault();
				$('#listmaster').trigger("reloadGrid");
			}
	});
	
	$('#darimasterinstalled').datepicker({dateFormat: "dd-mm-yy",changeYear: true,onSelect: function(dateText, inst){$('#sampaimasterinstalled').datepicker('option', 'minDate', dateText);$.datepicker._clearDate('#sampaimasterinstalled');}});
	$('#sampaimasterinstalled').datepicker({dateFormat: "dd-mm-yy",changeYear: true,onClose: function(dateText, inst){$('#listmaster').trigger("reloadGrid");}});
	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	$("#resetmasterinstalled").live('click', function(event){
		event.preventDefault();
		$('#formmasterinstalled').reset();
		$('#listmaster').trigger("reloadGrid");
	});
	$("#carimasterinstalled").live('click', function(event){
		event.preventDefault();
		$('#listmaster').trigger("reloadGrid");
	});
})