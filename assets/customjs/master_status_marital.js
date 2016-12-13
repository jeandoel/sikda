jQuery().ready(function (){ 
	jQuery("#liststatusmarital").jqGrid({ 
		url:'c_master_status_marital/statusmaritalxml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
			colNames:['KODE STATUS','STATUS','Action'],
		rownumbers:true,
		width: 1021,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[ 
				{name:'kd_status_marital',index:'kd_status_marital', width:80}, 
				{name:'status_marital',index:'status_marital', width:80},				
				{name:'x',index:'x', width:100,align:'center',formatter:formatterAction}
			],
			rowNum:10, 
			rowList:[10,20,30], 
			pager: jQuery('#pagerstatusmarital'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				dari=$('#daristatusmarital').val()?$('#daristatusmarital').val():'';
				sampai=$('#sampaistatusmarital').val()?$('#sampaistatusmarital').val():'';
				nama=$('#namastatusmarital').val()?$('#namastatusmarital').val():'';
				$('#liststatusmarital').setGridParam({postData:{'dari':dari,'sampai':sampai,'nama':nama}})
			}
	}).navGrid('#pagerstatusmarital',{edit:false,add:false,del:false,search:false});
	
	function formatterAction(cellvalue, options, rowObject) {
		var content = '';
		content  += '<a rel="' + cellvalue + '" class="icon-detail" title="View"></a> ';
		content  += '<a rel="' + cellvalue + '" class="icon-edit" title="Edit?"></a>';
		content  += '<a rel="' + cellvalue + '" class="icon-delete" title="Remove?"></a>';
		return content;
	}
	
	$("#liststatusmarital .icon-detail").live('click', function(c){
		if($(c.target).data('oneclicked')!='yes')
		{
			$("#t64","#tabs").empty();
			$("#t64","#tabs").load('c_master_status_marital/detail'+'?kd_status_marital='+this.rel);
		}
		$(c.target).data('oneclicked','yes');
	});
	
	$("#liststatusmarital .icon-edit").live('click', function(c){
		if($(c.target).data('oneclicked')!='yes')
		{
			$("#t64","#tabs").empty();
			$("#t64","#tabs").load('c_master_status_marital/edit'+'?kd_status_marital='+this.rel);
		}
		$(c.target).data('oneclicked','yes');
	});
	
	
	function deldata(myid){
		achtungShowLoader();
		$.ajax({
			  url: 'c_master_status_marital/delete',
			  type: "post",
			  data: {id:myid},
			  dataType: "json",
			  success: function(msg){
				if(msg == 'OK'){
					$("#dialogstatusmarital_new").dialog("close");
					$.achtung({message: 'Proses Hapus Data Berhasil', timeout:5});
					$('#liststatusmarital').trigger("reloadGrid");							
				}
				else{						
					$("#dialogstatusmarital_new").dialog("close");
					$.achtung({message: 'Maaf Proses Hapus Data Gagal', timeout:5});
				}						
			  }
		  });
		achtungHideLoader();
	}
	
	$(" .icon-delete").live('click', function(){
		var myid= this.rel;
		$("#dialogstatusmarital_new").dialog({
		autoOpen : false,
		modal :true,
		  buttons : {
			"Confirm" : function() {
				deldata(myid);
				
			},
			"Cancel" : function() {
			  $(this).dialog("close");
			}
		  }
		});
		
		$("#dialogstatusmarital_new").dialog("open");
	});
	
	$('form').resize(function(c) {
		if($("#liststatusmarital").getGridParam("records")>0){
		jQuery('#liststatusmarital').setGridWidth(($(this).width()-28));
		}
	});
	
	function formattermou(cellvalue, options, rowObject) {
		var content = '';
		if(cellvalue){		
			content  += '<a href="tmp/status_marital/' + cellvalue + '" style="color:blue;cursor:pointer" title="">download</a>';
		}else{
			content  += ' - ';
		}
		return content;
	}
	
	$('#master_status_marital_add').click(function(){
		$("#t64","#tabs").empty();
		$("#t64","#tabs").load('c_master_status_marital/add'+'?_=' + (new Date()).getTime());
	});
	
	$( "#sampaistatusmarital" )
		.keypress(function(event) {
			var keycode =(event.keyCode?event.keyCode:event.which);	
			if(keycode ==13){
				event.preventDefault();
				$('#liststatusmarital').trigger("reloadGrid");
			}
	});
	$( "#namastatusmarital" )
		.keypress(function(event) {
			var keycode =(event.keyCode?event.keyCode:event.which);	
			if(keycode ==13){
				event.preventDefault();
				$('#liststatusmarital').trigger("reloadGrid");
			}
	});
	$('#daristatusmarital').datepicker({dateFormat: "dd-mm-yy",changeYear: true,onSelect: function(dateText, inst){$('#sampaistatusmarital').datepicker('option', 'minDate', dateText);$.datepicker._clearDate('#sampaistatusmarital');}});
	$('#sampaistatusmarital').datepicker({dateFormat: "dd-mm-yy",changeYear: true,onClose: function(dateText, inst){$('#liststatusmarital').trigger("reloadGrid");}});
	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	$("#resetstatusmarital").live('click', function(event){
		event.preventDefault();
		$('#formmasterststusmarital').reset();
		$('#liststatusmarital').trigger("reloadGrid");
	});
	$("#caristatusmarital").live('click', function(event){
		event.preventDefault();
		$('#liststatusmarital').trigger("reloadGrid");
	});
})
