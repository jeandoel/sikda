jQuery().ready(function (){ 
	jQuery("#listpetugas").jqGrid({ 
		url:'c_master_petugas/petugasxml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['KODE PETUGAS','NAMA PETUGAS','UNIT','Action'],
		rownumbers:true,
		width: 1021,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[ 
				{name:'kdpetugas',index:'kdpetugas', width:100}, 
				{name:'nmpetugas',index:'nmpetugas', width:100}, 
				{name:'Unt',index:'Unt', width:100}, 
				{name:'x',index:'x', width:91,align:'center',formatter:formatterAction}
			],
			rowNum:10, 
			rowList:[10,20,30], 
			pager: jQuery('#pagerpetugas'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				dari=$('#daripetugas').val()?$('#daripetugas').val():'';
				sampai=$('#sampaipetugas').val()?$('#sampaipetugas').val():'';
				nama=$('#namapetugas').val()?$('#namapetugas').val():'';
				$('#listpetugas').setGridParam({postData:{'dari':dari,'sampai':sampai,'nama':nama}})
			}
	}).navGrid('#pagerpetugas',{edit:false,add:false,del:false,search:false});
	
	function formatterAction(cellvalue, options, rowObject) {
		var content = '';
		content  += '<a rel="' + cellvalue + '" class="icon-detail"  title="View"></a> ';
		content  += '<a rel="' + cellvalue + '" class="icon-edit"   title="Edit?"></a>';
		content  += '<a rel="' + cellvalue + '" class="icon-delete" title="Remove?"></a>';
		return content;
	}
	
	$("#listpetugas .icon-detail").live('click', function(d){
		if($(d.target).data('oneclicked')!='yes')
		{
		$("#t62","#tabs").empty();
		$("#t62","#tabs").load('c_master_petugas/detail'+'?id='+this.rel );
		}
		$(d.target).data('oneclicked','yes');
	});
	
	$("#listpetugas .icon-edit").live('click', function(d){
		if($(d.target).data('oneclicked')!='yes')
		{
		$("#t62","#tabs").empty();
		$("#t62","#tabs").load('c_master_petugas/edit'+'?id='+this.rel);
		}
		$(d.target).data('oneclicked','yes');
	});
	
	function deldata(myid){
		achtungShowLoader();
		$.ajax({
			  url: 'c_master_petugas/delete',
			  type: "post",
			  data: {id:myid},
			  dataType: "json",
			  success: function(msg){
				if(msg == 'OK'){
					$("#dialogpetugas_new").dialog("close");
					$.achtung({message: 'Proses Hapus Data Berhasil', timeout:5});
					$('#listpetugas').trigger("reloadGrid");							
				}
				else{						
					$("#dialogpetugas_new").dialog("close");
					$.achtung({message: 'Maaf Proses Hapus Data Gagal', timeout:5});
				}						
			  }
		  });
		achtungHideLoader();
	}
	
	$(" .icon-delete").live('click', function(){
		var myid= this.rel;
		$("#dialogpetugas_new").dialog({
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
		
		$("#dialogpetugas_new").dialog("open");
	});
	
	$('form').resize(function(e) {
		if($("#listpetugas").getGridParam("records")>0){
		jQuery('#listpetugas').setGridWidth(($(this).width()-28));
		}
	});
	
	function formattermou(cellvalue, options, rowObject) {
		var content = '';
		if(cellvalue){		
			content  += '<a href="tmp/petugas/' + cellvalue + '" style="color:blue;cursor:pointer" title="">download</a>';
		}else{
			content  += ' - ';
		}
		return content;
	}
	
	$('#v_master_petugas_add').click(function(){
		$("#t62","#tabs").empty();
		$("#t62","#tabs").load('c_master_petugas/add'+'?_=');
	});
	
	$( "#sampaipetugas" )
		.keypress(function(event) {
			var keycode =(event.keyCode?event.keyCode:event.which);	
			if(keycode ==13){
				event.preventDefault();
				$('#listpetugas').trigger("reloadGrid");
			}
	});
	
	$( "#namapetugas" )
		.keypress(function(event) {
			var keycode =(event.keyCode?event.keyCode:event.which);	
			if(keycode ==13){
				event.preventDefault();
				$('#listpetugas').trigger("reloadGrid");
			}
	});
	
	$('#daripetugas').datepicker({dateFormat: "dd-mm-yy",changeYear: true,onSelect: function(dateText, inst){$('#sampaipetugas').datepicker('option', 'minDate', dateText);$.datepicker._clearDate('#sampaipetugas');}});
	$('#sampaipetugas').datepicker({dateFormat: "dd-mm-yy",changeYear: true,onClose: function(dateText, inst){$('#listpetugas').trigger("reloadGrid");}});
	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	$("#resetpetugas").live('click', function(event){
		event.preventDefault();
		$('#form').reset();
		$('#listpetugas').trigger("reloadGrid");
	});
	$("#caripetugas").live('click', function(event){
		event.preventDefault();
		$('#listpetugas').trigger("reloadGrid");
	});
})
