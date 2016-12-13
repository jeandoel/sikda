jQuery().ready(function (){ 
	jQuery("#listmaster1").jqGrid({ 
		url:'master1/master1xml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['ID','Column1','Column2','Column3','Tgl. Master1','Action'],
		rownumbers:true,
		width: 1021,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[ 
				{name:'id',index:'id', width:5,hidden:true}, 
				{name:'column1',index:'column1', width:100}, 
				{name:'column2',index:'column2', width:155}, 
				{name:'column3',index:'column3', width:99},
				{name:'tgl_master1',index:'tgl_master1', width:75,align:'center'},
				{name:'myid',index:'myid', width:91,align:'center',formatter:formatterAction}
			],
			rowNum:10, 
			rowList:[10,20,30], 
			pager: jQuery('#pagermaster1'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				dari=$('#darimaster1').val()?$('#darimaster1').val():'';
				sampai=$('#sampaimaster1').val()?$('#sampaimaster1').val():'';
				$('#listmaster1').setGridParam({postData:{'dari':dari,'sampai':sampai}})
			}
	}).navGrid('#pagermaster1',{edit:false,add:false,del:false,search:false});
	
	function formatterAction(cellvalue, options, rowObject) {
		var content = '';
		content  += '<a rel="' + cellvalue + '" class="icon-detail"  title="View"></a> ';
		content  += '<a rel="' + cellvalue + '" class="icon-edit" title="Edit?"></a>';
		content  += '<a rel="' + cellvalue + '" class="icon-delete" title="Remove?"></a>';
		return content;
	}
	
	$("#listmaster1 .icon-detail").live('click', function(e){
		if($(e.target).data('oneclicked')!='yes')
		{
			$("#t6","#tabs").empty();
			$("#t6","#tabs").load('master1/detail'+'?id='+this.rel+ '_=' + (new Date()).getTime());
		}
		$(e.target).data('oneclicked','yes');
	});
	
	$("#listmaster1 .icon-edit").live('click', function(e){
		if($(e.target).data('oneclicked')!='yes')
		{
			$("#t6","#tabs").empty();
			$("#t6","#tabs").load('master1/edit'+'?id='+this.rel+ '_=' + (new Date()).getTime());
		}
		$(e.target).data('oneclicked','yes');		
	});
	
	function deldata(myid){
		achtungShowLoader();
		$.ajax({
			  url: 'master1/delete',
			  type: "post",
			  data: {id:myid},
			  dataType: "json",
			  success: function(msg){
				if(msg == 'OK'){
					$("#dialogmaster1").dialog("close");
					$.achtung({message: 'Proses Hapus Data Berhasil', timeout:5});
					$('#listmaster1').trigger("reloadGrid");							
				}
				else{						
					$("#dialogmaster1").dialog("close");
					$.achtung({message: 'Maaf Proses Hapus Data Gagal', timeout:5});
				}						
			  }
		  });
		achtungHideLoader();
	}
	
	$("#listmaster1 .icon-delete").live('click', function(){
		var myid= this.rel;
		$("#dialogmaster1").dialog({
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
		
		$("#dialogmaster1").dialog("open");
	});
	
	$('form').resize(function(e) {
		if($("#listmaster1").getGridParam("records")>0){
		jQuery('#listmaster1').setGridWidth(($(this).width()-28));
		}
	});
	
	function formattermou(cellvalue, options, rowObject) {
		var content = '';
		if(cellvalue){		
			content  += '<a href="tmp/master1/' + cellvalue + '" style="color:blue;cursor:pointer" title="">download</a>';
		}else{
			content  += ' - ';
		}
		return content;
	}
	
	$('#master1add').click(function(){
		$("#t6","#tabs").empty();
		$("#t6","#tabs").load('master1/add'+'?_=' + (new Date()).getTime());
	});
	
	$( "#sampaimaster1" )
		.keypress(function(event) {
			var keycode =(event.keyCode?event.keyCode:event.which);	
			if(keycode ==13){
				event.preventDefault();
				$('#listmaster1').trigger("reloadGrid");
			}
	});
	
	$('#darimaster1').datepicker({dateFormat: "dd-mm-yy",changeYear: true,onSelect: function(dateText, inst){$('#sampaimaster1').datepicker('option', 'minDate', dateText);$.datepicker._clearDate('#sampaimaster1');}});
	$('#sampaimaster1').datepicker({dateFormat: "dd-mm-yy",changeYear: true,onClose: function(dateText, inst){$('#listmaster1').trigger("reloadGrid");}});
	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	$("#resetmaster1").live('click', function(event){
		event.preventDefault();
		$('#formmaster1').reset();
		$('#listmaster1').trigger("reloadGrid");
	});
	$("#carimaster1").live('click', function(event){
		event.preventDefault();
		$('#listmaster1').trigger("reloadGrid");
	});
})