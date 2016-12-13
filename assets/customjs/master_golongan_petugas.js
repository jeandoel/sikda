jQuery().ready(function (){ 
	jQuery("#listgolongan").jqGrid({ 
		url:'c_master_golongan/golonganxml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
			colNames:['KODE GOLONGAN','NAMA GOLONGAN','Action'],
		rownumbers:true,
		width: 1021,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[ 
				{name:'kd_golongan',index:'kd_golongan', width:80}, 
				{name:'nama_golongan',index:'nama_golongan', width:80},				
				{name:'x',index:'x', width:100,align:'center',formatter:formatterAction}
			],
			rowNum:10, 
			rowList:[10,20,30], 
			pager: jQuery('#pagergolongan'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				dari=$('#darigolongan').val()?$('#darigolongan').val():'';
				sampai=$('#sampaigolongan').val()?$('#sampaigolongan').val():'';
				nama=$('#namagolongan').val()?$('#namagolongan').val():'';
				$('#listgolongan').setGridParam({postData:{'dari':dari,'sampai':sampai,'nama':nama}})
			}
	}).navGrid('#pagergolongan',{edit:false,add:false,del:false,search:false});
	
	function formatterAction(cellvalue, options, rowObject) {
		var content = '';
		content  += '<a rel="' + cellvalue + '" class="icon-detail" title="View"></a> ';
		content  += '<a rel="' + cellvalue + '" class="icon-edit" title="Edit?"></a>';
		content  += '<a rel="' + cellvalue + '" class="icon-delete" title="Remove?"></a>';
		return content;
	}
	
	$("#listgolongan .icon-detail").live('click', function(b){
		if($(b.target).data('oneclicked')!='yes')
		{
			$("#t65","#tabs").empty();
			$("#t65","#tabs").load('c_master_golongan/detail'+'?kd_golongan='+this.rel);
		}
		$(b.target).data('oneclicked','yes');
	});
	
	$("#listgolongan .icon-edit").live('click', function(b){
		if($(b.target).data('oneclicked')!='yes')
		{
			$("#t65","#tabs").empty();
			$("#t65","#tabs").load('c_master_golongan/edit'+'?kd_golongan='+this.rel);
		}
		$(b.target).data('oneclicked','yes');
	});
	
	
	function deldata(myid){
		achtungShowLoader();
		$.ajax({
			  url: 'c_master_golongan/delete',
			  type: "post",
			  data: {id:myid},
			  dataType: "json",
			  success: function(msg){
				if(msg == 'OK'){
					$("#dialoggolongan").dialog("close");
					$.achtung({message: 'Proses Hapus Data Berhasil', timeout:5});
					$('#listgolongan').trigger("reloadGrid");							
				}
				else{						
					$("#dialoggolongan").dialog("close");
					$.achtung({message: 'Maaf Proses Hapus Data Gagal', timeout:5});
				}						
			  }
		  });
		achtungHideLoader();
	}
	
	$(" .icon-delete").live('click', function(){
		var myid= this.rel;
		$("#dialoggolongan").dialog({
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
		
		$("#dialoggolongan").dialog("open");
	});
	
	$('form').resize(function(b) {
		if($("#listgolongan").getGridParam("records")>0){
		jQuery('#listgolongan').setGridWidth(($(this).width()-28));
		}
	});
	
	function formattermou(cellvalue, options, rowObject) {
		var content = '';
		if(cellvalue){		
			content  += '<a href="tmp/golonganpetugas/' + cellvalue + '" style="color:blue;cursor:pointer" title="">download</a>';
		}else{
			content  += ' - ';
		}
		return content;
	}
	
	$('#master_golongan_add').click(function(){
		$("#t65","#tabs").empty();
		$("#t65","#tabs").load('c_master_golongan/add'+'?_=' + (new Date()).getTime());
	});
	
	$( "#sampaigolongan" )
		.keypress(function(event) {
			var keycode =(event.keyCode?event.keyCode:event.which);	
			if(keycode ==13){
				event.preventDefault();
				$('#listgolongan').trigger("reloadGrid");
			}
	});
	$( "#namagolongan" )
		.keypress(function(event) {
			var keycode =(event.keyCode?event.keyCode:event.which);	
			if(keycode ==13){
				event.preventDefault();
				$('#listgolongan').trigger("reloadGrid");
			}
	});
	$('#darigolongan').datepicker({dateFormat: "dd-mm-yy",changeYear: true,onSelect: function(dateText, inst){$('#sampaigolongan').datepicker('option', 'minDate', dateText);$.datepicker._clearDate('#sampaigolongan');}});
	$('#sampaigolongan').datepicker({dateFormat: "dd-mm-yy",changeYear: true,onClose: function(dateText, inst){$('#listgolongan').trigger("reloadGrid");}});
	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	$("#resetgolongan").live('click', function(event){
		event.preventDefault();
		$('#formgolongan').reset();
		$('#listgolongan').trigger("reloadGrid");
	});
	$("#carigolongan").live('click', function(event){
		event.preventDefault();
		$('#listgolongan').trigger("reloadGrid");
	});
})