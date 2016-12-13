jQuery().ready(function (){ 
	jQuery("#listmasterLetakJanin").jqGrid({ 
		url:'c_master_letak_janin/masterletakjaninxml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['KODE','id1','Letak Janin','Action'],
		rownumbers:true,
		width: 1021,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[ 
				{name:'id',index:'id', width:25,align:'center'}, 
				{name:'id1',index:'id1', width:25,align:'center',hidden:true}, 
				{name:'letak_janin',index:'letak_janin', width:150}, 
				{name:'myid',index:'myid', width:91,align:'center',formatter:formatterAction}
			],
			rowNum:10, 
			rowList:[10,20,30], 
			pager: jQuery('#pagermasterLetakJanin'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				dari=$('#darimasterLetakJanin').val()?$('#darimasterLetakJanin').val():'';
				sampai=$('#sampaimasterLetakJanin').val()?$('#sampaimasterLetakJanin').val():'';
				carinama=$('#carinamamasterLetakJanin').val()?$('#carinamamasterLetakJanin').val():'';
				$('#listmasterLetakJanin').setGridParam({postData:{'dari':dari,'sampai':sampai,'carinama':carinama}})
			}
	}).navGrid('#pagermasterLetakJanin',{edit:false,add:false,del:false,search:false});
	
	function formatterAction(cellvalue, options, rowObject) {
		var content = '';
		content  += '<a rel="' + cellvalue + '" class="icon-detail"  title="View"></a> ';
		content  += '<a rel="' + cellvalue + '" class="icon-edit" title="Edit?"></a>';
		content  += '<a rel="' + cellvalue + '" class="icon-delete" title="Remove?"></a>';
		return content;
	}
	
	$("#listmasterLetakJanin .icon-detail").live('click', function(f){
		if($(f.target).data('oneclicked')!='yes')
		{
			$("#t901","#tabs").empty();
			$("#t901","#tabs").load('c_master_letak_janin/detail'+'?id='+this.rel);
		}
		$(f.target).data('oneclicked','yes');
	});
	
	$("#listmasterLetakJanin .icon-edit").live('click', function(f){
		if($(f.target).data('oneclicked')!='yes')
		{
			$("#t901","#tabs").empty();
			$("#t901","#tabs").load('c_master_letak_janin/edit'+'?id='+this.rel);
		}
		$(f.target).data('oneclicked','yes');		
	});
	
	function deldata(myid){
		achtungShowLoader();
		$.ajax({
			  url: 'c_master_letak_janin/delete',
			  type: "post",
			  data: {id:myid},
			  dataType: "json",
			  success: function(msg){
				if(msg == 'OK'){
					$("#dialogmasterLetakJanin").dialog("close");
					$.achtung({message: 'Proses Hapus Data Berhasil', timeout:5});
					$('#listmasterLetakJanin').trigger("reloadGrid");							
				}
				else{						
					$("#dialogmasterLetakJanin").dialog("close");
					$.achtung({message: 'Maaf Proses Hapus Data Gagal', timeout:5});
				}						
			  }
		  });
		achtungHideLoader();
	}
	
	$("#listmasterLetakJanin .icon-delete").live('click', function(){
		var myid= this.rel;
		$("#dialogmasterLetakJanin").dialog({
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
		
		$("#dialogmasterLetakJanin").dialog("open");
	});
	
	$('form').resize(function(e) {
		if($("#listmasterLetakJanin").getGridParam("records")>0){
		jQuery('#listmasterLetakJanin').setGridWidth(($(this).width()-28));
		}
	});
	
	function formattermou(cellvalue, options, rowObject) {
		var content = '';
		if(cellvalue){		
			content  += '<a href="tmp/c_master_letak_janin/' + cellvalue + '" style="color:blue;cursor:pointer" title="">download</a>';
		}else{
			content  += ' - ';
		}
		return content;
	}
	
	$('#masterLetakJaninadd').click(function(){
		$("#t901","#tabs").empty();
		$("#t901","#tabs").load('c_master_letak_janin/add'+'?_=' + (new Date()).getTime());
	});
	
	$( "#sampaimasterLetakJanin" )
		.keypress(function(event) {
			var keycode =(event.keyCode?event.keyCode:event.which);	
			if(keycode ==13){
				event.preventDefault();
				$('#listmasterLetakJanin').trigger("reloadGrid");
			}
	});
	
	$('#darimasterLetakJanin').datepicker({dateFormat: "dd-mm-yy",changeYear: true,onSelect: function(dateText, inst){$('#sampaimasterLetakJanin').datepicker('option', 'minDate', dateText);$.datepicker._clearDate('#sampaimasterLetakJanin');}});
	$('#sampaimasterLetakJanin').datepicker({dateFormat: "dd-mm-yy",changeYear: true,onClose: function(dateText, inst){$('#listmasterLetakJanin').trigger("reloadGrid");}});
	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	$("#resetmasterLetakJanin").live('click', function(event){
		event.preventDefault();
		$('#formmasterLetakJanin').reset();
		$('#listmasterLetakJanin').trigger("reloadGrid");
	});
	$("#carimasterLetakJanin").live('click', function(event){
		event.preventDefault();
		$('#listmasterLetakJanin').trigger("reloadGrid");
	});
})