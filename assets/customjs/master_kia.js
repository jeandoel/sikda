jQuery().ready(function (){ 
	jQuery("#listmasterKia").jqGrid({ 
		url:'c_master_kia/masterkiaxml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['VARIA_ID','FORMAT XML','VARIABEL ID','PARENT ID','VARIABEL DATA','DEFINISI','PILIHAN VALUE','IROW','STATUS','PELAYANAN ULANG','Action'],
		rownumbers:true,
		width: 1021,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[ 
				{name:'id1',index:'id1', width:25,align:'center',hidden:true}, 
				{name:'id',index:'id', width:70}, 
				{name:'varId',index:'varId', width:50}, 
				{name:'parId',index:'parId', width:50}, 
				{name:'varNam',index:'varNam', width:55}, 
				{name:'varDef',index:'varDef', width:50}, 
				{name:'pilVal',index:'pilVal', width:55,align:'center'}, 
				{name:'irow',index:'irow', width:35,align:'center'}, 
				{name:'stat',index:'stat', width:15,align:'center'}, 
				{name:'pelul',index:'pelul', width:15,align:'center'}, 
				{name:'myid',index:'myid', width:91,align:'center',formatter:formatterAction}
			],
			rowNum:10, 
			rowList:[10,20,30], 
			pager: jQuery('#pagermasterKia'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				dari=$('#darimasterKia').val()?$('#darimasterKia').val():'';
				sampai=$('#sampaimasterKia').val()?$('#sampaimasterKia').val():'';
				keyword=$('#keywordmasterKia').val()?$('#keywordmasterKia').val():'';
				carinama=$('#carinamamasterKia').val()?$('#carinamamasterKia').val():'';
				$('#listmasterKia').setGridParam({postData:{'dari':dari,'sampai':sampai,'keyword':keyword,'carinama':carinama}})
			}
	}).navGrid('#pagermasterKia',{edit:false,add:false,del:false,search:false});
	
	function formatterAction(cellvalue, options, rowObject) {
		var content = '';
		content  += '<a rel="' + cellvalue + '" class="icon-detail"  title="View"></a> ';
		content  += '<a rel="' + cellvalue + '" class="icon-edit" title="Edit?"></a>';
		content  += '<a rel="' + cellvalue + '" class="icon-delete" title="Remove?"></a>';
		return content;
	}
	
	$("#listmasterKia .icon-detail").live('click', function(c){
		if($(c.target).data('oneclicked')!='yes')
		{
			$("#t29","#tabs").empty();
			$("#t29","#tabs").load('c_master_kia/detail'+'?id='+this.rel);
		}
		$(c.target).data('oneclicked','yes');
	});
	
	$("#listmasterKia .icon-edit").live('click', function(c){
		if($(c.target).data('oneclicked')!='yes')
		{
			$("#t29","#tabs").empty();
			$("#t29","#tabs").load('c_master_kia/edit'+'?id='+this.rel);
		}
		$(c.target).data('oneclicked','yes');		
	});
	
	function deldata(myid){
		achtungShowLoader();
		$.ajax({
			  url: 'c_master_kia/delete',
			  type: "post",
			  data: {id:myid},
			  dataType: "json",
			  success: function(msg){
				if(msg == 'OK'){
					$("#dialogmasterKia").dialog("close");
					$.achtung({message: 'Proses Hapus Data Berhasil', timeout:5});
					$('#listmasterKia').trigger("reloadGrid");							
				}
				else{						
					$("#dialogmasterKia").dialog("close");
					$.achtung({message: 'Maaf Proses Hapus Data Gagal', timeout:5});
				}						
			  }
		  });
		achtungHideLoader();
	}
	
	$("#listmasterKia .icon-delete").live('click', function(){
		var myid= this.rel;
		$("#dialogmasterKia").dialog({
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
		
		$("#dialogmasterKia").dialog("open");
	});
	
	$('form').resize(function(e) {
		if($("#listmasterKia").getGridParam("records")>0){
		jQuery('#listmasterKia').setGridWidth(($(this).width()-28));
		}
	});
	
	function formattermou(cellvalue, options, rowObject) {
		var content = '';
		if(cellvalue){		
			content  += '<a href="tmp/c_master_kia/' + cellvalue + '" style="color:blue;cursor:pointer" title="">download</a>';
		}else{
			content  += ' - ';
		}
		return content;
	}
	
	$('#masterKiaadd').click(function(){
		$("#t29","#tabs").empty();
		$("#t29","#tabs").load('c_master_kia/add'+'?_=' + (new Date()).getTime());
	});
	
	$( "#sampaimasterKia" )
		.keypress(function(event) {
			var keycode =(event.keyCode?event.keyCode:event.which);	
			if(keycode ==13){
				event.preventDefault();
				$('#listmasterKia').trigger("reloadGrid");
			}
	});
	
	$('#darimasterKia').datepicker({dateFormat: "dd-mm-yy",changeYear: true,onSelect: function(dateText, inst){$('#sampaimasterKia').datepicker('option', 'minDate', dateText);$.datepicker._clearDate('#sampaimasterKia');}});
	$('#sampaimasterKia').datepicker({dateFormat: "dd-mm-yy",changeYear: true,onClose: function(dateText, inst){$('#listmasterKia').trigger("reloadGrid");}});
	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	$("#resetmasterKia").live('click', function(event){
		event.preventDefault();
		$('#formmasterKia').reset();
		$('#listmasterKia').trigger("reloadGrid");
	});
	$("#carimasterKia").live('click', function(event){
		event.preventDefault();
		$('#listmasterKia').trigger("reloadGrid");
	});
})