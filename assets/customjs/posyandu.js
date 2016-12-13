jQuery().ready(function (){ 
	jQuery("#listposyandu").jqGrid({ 
		url:'posyandu/posyanduxml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['ID','Kode Posyandu','Nama Posyandu','Alamat', 'Jumlah Kader','Tanggal','Action'],
		rownumbers:true,
		width: 1021,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[ 
				{name:'id',index:'id', width:10,hidden:true}, 
				{name:'kodeposyandu',index:'kodeposyandu', width:50}, 
				{name:'namaposyandu',index:'namaposyandu', width:90}, 
				{name:'alamatposyandu',index:'alamatposyandu', width:120},
				{name:'jumlahkader',index:'jumlahkader', width:50},
				{name:'tgl_posyandu',index:'tgl_posyandu', width:70,align:'center'},
				{name:'x',index:'x', width:90,align:'center',formatter:formatterAction}
			],
			rowNum:10, 
			rowList:[10,20,30], 
			pager: jQuery('#pagerposyandu'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				dari=$('#dariposyandu').val()?$('#dariposyandu').val():'';
				sampai=$('#sampaiposyandu').val()?$('#sampaiposyandu').val():'';
				nama=$('#namaposyandu').val()?$('#namaposyandu').val():'';
				$('#listposyandu').setGridParam({postData:{'dari':dari,'sampai':sampai,'nama':nama}})
			}
	}).navGrid('#pagerposyandu',{edit:false,add:false,del:false,search:false});
	
	function formatterAction(cellvalue, options, rowObject) {
		var content = '';
		content  += '<a rel="' + cellvalue + '" class="icon-detail"  title="View"></a> ';
		content  += '<a rel="' + cellvalue + '" class="icon-edit" title="Edit?"></a>';
		content  += '<a rel="' + cellvalue + '" class="icon-delete" title="Remove?"></a>';
		return content;
	}
	
	$(".icon-detail").live('click', function(){
		$("#t8","#tabs").empty();
		$("#t8","#tabs").load('posyandu/detail'+'?id='+this.rel+ '_=' + (new Date()).getTime());
	});
	
	$(".icon-edit").live('click', function(){
		$("#t8","#tabs").empty();
		$("#t8","#tabs").load('posyandu/edit'+'?id='+this.rel);
	});
	
	function deldata(myid){
		achtungShowLoader();
		$.ajax({
			  url: 'posyandu/delete',
			  type: "post",
			  data: {id:myid},
			  dataType: "json",
			  success: function(msg){
				if(msg == 'OK'){
					$("#dialog").dialog("close");
					$.achtung({message: 'Proses Hapus Data Berhasil', timeout:5});
					$('#listposyandu').trigger("reloadGrid");							
				}
				else{						
					$("#dialog").dialog("close");
					$.achtung({message: 'Maaf Proses Hapus Data Gagal', timeout:5});
				}						
			  }
		  });
		achtungHideLoader();
	}
	
	$(".icon-delete").live('click', function(){
		var myid= this.rel;
		$("#dialog").dialog({
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
		if($("#listposyandu").getGridParam("records")>0){
		jQuery('#listposyandu').setGridWidth(($(this).width()-28));
		}
	});
	
	function formattermou(cellvalue, options, rowObject) {
		var content = '';
		if(cellvalue){		
			content  += '<a href="tmp/posyandu/' + cellvalue + '" style="color:blue;cursor:pointer" title="">download</a>';
		}else{
			content  += ' - ';
		}
		return content;
	}
	
	$('#vposyanduadd').click(function(){
		$("#t8","#tabs").empty();
		$("#t8","#tabs").load('posyandu/add'+'?_=' + (new Date()).getTime());
	});
	
	$( "#sampaiposyandu" )
		.keypress(function(event) {
			var keycode =(event.keyCode?event.keyCode:event.which);	
			if(keycode ==13){
				event.preventDefault();
				$('#listposyandu').trigger("reloadGrid");
			}
	});
	$( "#namaposyandu" )
		.keypress(function(event) {
			var keycode =(event.keyCode?event.keyCode:event.which);	
			if(keycode ==13){
				event.preventDefault();
				$('#listposyandu').trigger("reloadGrid");
			}
	});
	$('#dariposyandu').datepicker({dateFormat: "dd-mm-yy",changeYear: true,onSelect: function(dateText, inst){$('#sampaiposyandu').datepicker('option', 'minDate', dateText);$.datepicker._clearDate('#sampaiposyandu');}});
	$('#sampaiposyandu').datepicker({dateFormat: "dd-mm-yy",changeYear: true,onClose: function(dateText, inst){$('#listposyandu').trigger("reloadGrid");}});
	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	$("#resetposyandu").live('click', function(event){
		event.preventDefault();
		$('#formposyandu').reset();
		$('#listposyandu').trigger("reloadGrid");
	});
	$("#cariposyandu").live('click', function(event){
		event.preventDefault();
		$('#listposyandu').trigger("reloadGrid");
	});
})