jQuery().ready(function (){ 
	jQuery("#listmasterProp").jqGrid({ 
		url:'c_master_propinsi/masterpropinsixml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['KODE','id1','PROVINSI','Action'],
		rownumbers:true,
		width: 1021,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[ 
				{name:'id',index:'id', width:25,align:'center'}, 
				{name:'id1',index:'id1', width:25,align:'center',hidden:true}, 
				{name:'namaProp',index:'namaProp', width:100}, 
				{name:'myid',index:'myid', width:91,align:'center',formatter:formatterAction}
			],
			rowNum:10, 
			rowList:[10,20,30], 
			pager: jQuery('#pagermasterProp'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				dari=$('#darimasterProp').val()?$('#darimasterProp').val():'';
				sampai=$('#sampaimasterProp').val()?$('#sampaimasterProp').val():'';
				carinama=$('#carinamamasterProp').val()?$('#carinamamasterProp').val():'';
				$('#listmasterProp').setGridParam({postData:{'dari':dari,'sampai':sampai,'carinama':carinama}})
			}
	}).navGrid('#pagermasterProp',{edit:false,add:false,del:false,search:false});
	
	function formatterAction(cellvalue, options, rowObject) {
		var content = '';
		content  += '<a rel="' + cellvalue + '" class="icon-detail"  title="View"></a> ';
		content  += '<a rel="' + cellvalue + '" class="icon-edit" title="Edit?"></a>';
		content  += '<a rel="' + cellvalue + '" class="icon-delete" title="Remove?"></a>';
		return content;
	}
	
	$("#listmasterProp .icon-detail").live('click', function(f){
		if($(f.target).data('oneclicked')!='yes')
		{
			$("#t25","#tabs").empty();
			$("#t25","#tabs").load('c_master_propinsi/detail'+'?id='+this.rel);
		}
		$(f.target).data('oneclicked','yes');
	});
	
	$("#listmasterProp .icon-edit").live('click', function(f){
		if($(f.target).data('oneclicked')!='yes')
		{
			$("#t25","#tabs").empty();
			$("#t25","#tabs").load('c_master_propinsi/edit'+'?id='+this.rel);
		}
		$(f.target).data('oneclicked','yes');		
	});
	
	function deldata(myid){
		achtungShowLoader();
		$.ajax({
			  url: 'c_master_propinsi/delete',
			  type: "post",
			  data: {id:myid},
			  dataType: "json",
			  success: function(msg){
				if(msg == 'OK'){
					$("#dialogmasterProp").dialog("close");
					$.achtung({message: 'Proses Hapus Data Berhasil', timeout:5});
					$('#listmasterProp').trigger("reloadGrid");							
				}
				else{						
					$("#dialogmasterProp").dialog("close");
					$.achtung({message: 'Maaf Proses Hapus Data Gagal', timeout:5});
				}						
			  }
		  });
		achtungHideLoader();
	}
	
	$("#listmasterProp .icon-delete").live('click', function(){
		var myid= this.rel;
		$("#dialogmasterProp").dialog({
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
		
		$("#dialogmasterProp").dialog("open");
	});
	
	$('form').resize(function(e) {
		if($("#listmasterProp").getGridParam("records")>0){
		jQuery('#listmasterProp').setGridWidth(($(this).width()-28));
		}
	});
	
	function formattermou(cellvalue, options, rowObject) {
		var content = '';
		if(cellvalue){		
			content  += '<a href="tmp/c_master_propinsi/' + cellvalue + '" style="color:blue;cursor:pointer" title="">download</a>';
		}else{
			content  += ' - ';
		}
		return content;
	}
	
	$('#masterPropadd').click(function(){
		$("#t25","#tabs").empty();
		$("#t25","#tabs").load('c_master_propinsi/add'+'?_=' + (new Date()).getTime());
	});
	
	$( "#sampaimasterProp" )
		.keypress(function(event) {
			var keycode =(event.keyCode?event.keyCode:event.which);	
			if(keycode ==13){
				event.preventDefault();
				$('#listmasterProp').trigger("reloadGrid");
			}
	});
	
	$('#darimasterProp').datepicker({dateFormat: "dd-mm-yy",changeYear: true,onSelect: function(dateText, inst){$('#sampaimasterProp').datepicker('option', 'minDate', dateText);$.datepicker._clearDate('#sampaimasterProp');}});
	$('#sampaimasterProp').datepicker({dateFormat: "dd-mm-yy",changeYear: true,onClose: function(dateText, inst){$('#listmasterProp').trigger("reloadGrid");}});
	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	$("#resetmasterProp").live('click', function(event){
		event.preventDefault();
		$('#formmasterProp').reset();
		$('#listmasterProp').trigger("reloadGrid");
	});
	$("#carimasterProp").live('click', function(event){
		event.preventDefault();
		$('#listmasterProp').trigger("reloadGrid");
	});
})