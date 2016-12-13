jQuery().ready(function (){ 
	jQuery("#listras").jqGrid({ 
		url:'c_master_ras/rasxml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
			colNames:['KODE RAS','RAS','Action'],
		rownumbers:true,
		width: 1021,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[ 
				{name:'kd_ras',index:'kd_ras', width:80}, 
				{name:'ras',index:'ras', width:80},				
				{name:'x',index:'x', width:100,align:'center',formatter:formatterAction}
			],
			rowNum:10, 
			rowList:[10,20,30], 
			pager: jQuery('#pagerras'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				dari=$('#dariras').val()?$('#dariras').val():'';
				sampai=$('#sampairas').val()?$('#sampairas').val():'';
				nama=$('#namaras').val()?$('#namaras').val():'';
				$('#listras').setGridParam({postData:{'dari':dari,'sampai':sampai,'nama':nama}})
			}
	}).navGrid('#pagerras',{edit:false,add:false,del:false,search:false});
	
	function formatterAction(cellvalue, options, rowObject) {
		var content = '';
		content  += '<a rel="' + cellvalue + '" class="icon-detail" title="View"></a> ';
		content  += '<a rel="' + cellvalue + '" class="icon-edit" title="Edit?"></a>';
		content  += '<a rel="' + cellvalue + '" class="icon-delete" title="Remove?"></a>';
		return content;
	}
	
	$("#listras .icon-detail").live('click', function(b){
		if($(b.target).data('oneclicked')!='yes')
		{
			$("#t63","#tabs").empty();
			$("#t63","#tabs").load('c_master_ras/detail'+'?kd_ras='+this.rel);
		}
		$(b.target).data('oneclicked','yes');
	});
	
	$("#listras .icon-edit").live('click', function(b){
		if($(b.target).data('oneclicked')!='yes')
		{
			$("#t63","#tabs").empty();
			$("#t63","#tabs").load('c_master_ras/edit'+'?kd_ras='+this.rel);
		}
		$(b.target).data('oneclicked','yes');
	});
	
	
	function deldata(myid){
		achtungShowLoader();
		$.ajax({
			  url: 'c_master_ras/delete',
			  type: "post",
			  data: {id:myid},
			  dataType: "json",
			  success: function(msg){
				if(msg == 'OK'){
					$("#dialogras").dialog("close");
					$.achtung({message: 'Proses Hapus Data Berhasil', timeout:5});
					$('#listras').trigger("reloadGrid");							
				}
				else{						
					$("#dialogras").dialog("close");
					$.achtung({message: 'Maaf Proses Hapus Data Gagal', timeout:5});
				}						
			  }
		  });
		achtungHideLoader();
	}
	
	$(" .icon-delete").live('click', function(){
		var myid= this.rel;
		$("#dialogras").dialog({
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
		
		$("#dialogras").dialog("open");
	});
	
	$('form').resize(function(b) {
		if($("#listras").getGridParam("records")>0){
		jQuery('#listras').setGridWidth(($(this).width()-28));
		}
	});
	
	function formattermou(cellvalue, options, rowObject) {
		var content = '';
		if(cellvalue){		
			content  += '<a href="tmp/obat/' + cellvalue + '" style="color:blue;cursor:pointer" title="">download</a>';
		}else{
			content  += ' - ';
		}
		return content;
	}
	
	$('#v_master_ras_add').click(function(){
		$("#t63","#tabs").empty();
		$("#t63","#tabs").load('c_master_ras/add'+'?_=' + (new Date()).getTime());
	});
	
	$( "#sampairas" )
		.keypress(function(event) {
			var keycode =(event.keyCode?event.keyCode:event.which);	
			if(keycode ==13){
				event.preventDefault();
				$('#listras').trigger("reloadGrid");
			}
	});
	$( "#namaras" )
		.keypress(function(event) {
			var keycode =(event.keyCode?event.keyCode:event.which);	
			if(keycode ==13){
				event.preventDefault();
				$('#listras').trigger("reloadGrid");
			}
	});
	$('#dariras').datepicker({dateFormat: "dd-mm-yy",changeYear: true,onSelect: function(dateText, inst){$('#sampairas').datepicker('option', 'minDate', dateText);$.datepicker._clearDate('#sampairas');}});
	$('#sampairas').datepicker({dateFormat: "dd-mm-yy",changeYear: true,onClose: function(dateText, inst){$('#listras').trigger("reloadGrid");}});
	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	$("#resetras").live('click', function(event){
		event.preventDefault();
		$('#formmaster1').reset();
		$('#listras').trigger("reloadGrid");
	});
	$("#cariras").live('click', function(event){
		event.preventDefault();
		$('#listras').trigger("reloadGrid");
	});
})