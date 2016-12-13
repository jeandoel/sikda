jQuery().ready(function (){ 
	jQuery("#listpenkes").jqGrid({ 
		url:'c_master_pendidikan_kesehatan/penkesxml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
			colNames:['KODE PENDIDIKAN','PENDIDIKAN','Action'],
		rownumbers:true,
		width: 1021,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[ 
				{name:'kd_penkes',index:'kd_penkes', width:80}, 
				{name:'penkes',index:'penkes', width:80},				
				{name:'x',index:'x', width:100,align:'center',formatter:formatterAction}
			],
			rowNum:10, 
			rowList:[10,20,30], 
			pager: jQuery('#pagerpenkes'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				dari=$('#daripenkes').val()?$('#daripenkes').val():'';
				sampai=$('#sampaipenkes').val()?$('#sampaipenkes').val():'';
				nama=$('#namapenkes').val()?$('#namapenkes').val():'';
				$('#listpenkes').setGridParam({postData:{'dari':dari,'sampai':sampai,'nama':nama}})
			}
	}).navGrid('#pagerpenkes',{edit:false,add:false,del:false,search:false});
	
	function formatterAction(cellvalue, options, rowObject) {
		var content = '';
		content  += '<a rel="' + cellvalue + '" class="icon-detail" title="View"></a> ';
		content  += '<a rel="' + cellvalue + '" class="icon-edit" title="Edit?"></a>';
		content  += '<a rel="' + cellvalue + '" class="icon-delete" title="Remove?"></a>';
		return content;
	}
	
	$("#listpenkes .icon-detail").live('click', function(i){
		if($(i.target).data('oneclicked')!='yes')
		{
			$("#t66","#tabs").empty();
			$("#t66","#tabs").load('c_master_pendidikan_kesehatan/detail'+'?kd_penkes='+this.rel);
		}
		$(i.target).data('oneclicked','yes');
	});
	
	$("#listpenkes .icon-edit").live('click', function(i){
		if($(i.target).data('oneclicked')!='yes')
		{
			$("#t66","#tabs").empty();
			$("#t66","#tabs").load('c_master_pendidikan_kesehatan/edit'+'?kd_penkes='+this.rel);
		}
		$(i.target).data('oneclicked','yes');
	});
	
	
	function deldata(myid){
		achtungShowLoader();
		$.ajax({
			  url: 'c_master_pendidikan_kesehatan/delete',
			  type: "post",
			  data: {id:myid},
			  dataType: "json",
			  success: function(msg){
				if(msg == 'OK'){
					$("#dialogpenkes_new").dialog("close");
					$.achtung({message: 'Proses Hapus Data Berhasil', timeout:5});
					$('#listpenkes').trigger("reloadGrid");							
				}
				else{						
					$("#dialogpenkes_new").dialog("close");
					$.achtung({message: 'Maaf Proses Hapus Data Gagal', timeout:5});
				}						
			  }
		  });
		achtungHideLoader();
	}
	
	$(" .icon-delete").live('click', function(){
		var myid= this.rel;
		$("#dialogpenkes_new").dialog({
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
		
		$("#dialogpenkes_new").dialog("open");
	});
	
	$('form').resize(function(i) {
		if($("#listpenkes").getGridParam("records")>0){
		jQuery('#listpenkes').setGridWidth(($(this).width()-28));
		}
	});
	
	function formattermou(cellvalue, options, rowObject) {
		var content = '';
		if(cellvalue){		
			content  += '<a href="tmp/penkes/' + cellvalue + '" style="color:blue;cursor:pointer" title="">download</a>';
		}else{
			content  += ' - ';
		}
		return content;
	}
	
	$('#master_penkes_add').click(function(){
		$("#t66","#tabs").empty();
		$("#t66","#tabs").load('c_master_pendidikan_kesehatan/add'+'?_=' + (new Date()).getTime());
	});
	
	$( "#sampaipenkes" )
		.keypress(function(event) {
			var keycode =(event.keyCode?event.keyCode:event.which);	
			if(keycode ==13){
				event.preventDefault();
				$('#listpenkes').trigger("reloadGrid");
			}
	});
	$( "#namapenkes" )
		.keypress(function(event) {
			var keycode =(event.keyCode?event.keyCode:event.which);	
			if(keycode ==13){
				event.preventDefault();
				$('#listpenkes').trigger("reloadGrid");
			}
	});
	$('#daripenkes').datepicker({dateFormat: "dd-mm-yy",changeYear: true,onSelect: function(dateText, inst){$('#sampaipenkes').datepicker('option', 'minDate', dateText);$.datepicker._clearDate('#sampaipenkes');}});
	$('#sampaipenkes').datepicker({dateFormat: "dd-mm-yy",changeYear: true,onClose: function(dateText, inst){$('#listpenkes').trigger("reloadGrid");}});
	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	$("#resetpenkes").live('click', function(event){
		event.preventDefault();
		$('#formmaster1').reset();
		$('#listpenkes').trigger("reloadGrid");
	});
	$("#caripenkes").live('click', function(event){
		event.preventDefault();
		$('#listpenkes').trigger("reloadGrid");
	});
})
