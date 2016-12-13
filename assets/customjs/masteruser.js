jQuery().ready(function (){ 
	jQuery("#listmasteruser").jqGrid({ 
		url:'masteruser/masteruserxml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['ID','Nama user','Email user','Alamat user','No telp','Tgl. Input','Action'],
		rownumbers:true,
		width: 1021,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[ 
				{name:'id',index:'id', width:5,hidden:true}, 
				{name:'namauser',index:'namauser', width:100}, 
				{name:'emailuser',index:'emailuser', width:155}, 
				{name:'alamatuser',index:'alamatuser', width:99},
				{name:'notelp',index:'notelp', width:99},
				{name:'tgl_user',index:'tgl_user', width:75,align:'center'},
				{name:'x',index:'x', width:91,align:'center',formatter:formatterAction}
			],
			rowNum:10, 
			rowList:[10,20,30], 
			pager: jQuery('#pagermasteruser'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				dari=$('#darimasteruser').val()?$('#darimasteruser').val():'';
				sampai=$('#sampaimasteruser').val()?$('#sampaimasteruser').val():'';
				nama=$('#namamasteruser').val()?$('#namamasteruser').val():'';
				$('#listmasteruser').setGridParam({postData:{'dari':dari,'sampai':sampai,'nama':nama}})
			}
	}).navGrid('#pagermasteruser',{edit:false,add:false,del:false,search:false});
	
	function formatterAction(cellvalue, options, rowObject) {
		var content = '';
		content  += '<a rel="' + cellvalue + '" class="icon-detail"  title="View"></a> ';
		content  += '<a rel="' + cellvalue + '" class="icon-edit" title="Edit?"></a>';
		content  += '<a rel="' + cellvalue + '" class="icon-delete" title="Remove?"></a>';
		return content;
	}
	
	$(".icon-detail").live('click', function(){
		$("#t7","#tabs").empty();
		$("#t7","#tabs").load('masteruser/detail'+'?id='+this.rel+ '_=' + (new Date()).getTime());
	});
	
	$(".icon-edit").live('click', function(){
		$("#t7","#tabs").empty();
		$("#t7","#tabs").load('masteruser/edit'+'?id='+this.rel);
	});
	
	function deldata(myid){
		achtungShowLoader();
		$.ajax({
			  url: 'masteruser/delete',
			  type: "post",
			  data: {id:myid},
			  dataType: "json",
			  success: function(msg){
				if(msg == 'OK'){
					$("#dialog").dialog("close");
					$.achtung({message: 'Proses Hapus Data Berhasil', timeout:5});
					$('#listmasteruser').trigger("reloadGrid");							
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
		if($("#listmasteruser").getGridParam("records")>0){
		jQuery('#listmasteruser').setGridWidth(($(this).width()-28));
		}
	});
	
	function formattermou(cellvalue, options, rowObject) {
		var content = '';
		if(cellvalue){		
			content  += '<a href="tmp/masteruser/' + cellvalue + '" style="color:blue;cursor:pointer" title="">download</a>';
		}else{
			content  += ' - ';
		}
		return content;
	}
	
	$('#masteruseradd').click(function(){
		$("#t7","#tabs").empty();
		$("#t7","#tabs").load('masteruser/add'+'?_=' + (new Date()).getTime());
	});
	
	$( "#sampaimasteruser" )
		.keypress(function(event) {
			var keycode =(event.keyCode?event.keyCode:event.which);	
			if(keycode ==13){
				event.preventDefault();
				$('#listmasteruser').trigger("reloadGrid");
			}
	});
	
	$( "#namamasteruser" )
		.keypress(function(event) {
			var keycode =(event.keyCode?event.keyCode:event.which);	
			if(keycode ==13){
				event.preventDefault();
				$('#listmasteruser').trigger("reloadGrid");
			}
	});
	
	$('#darimasteruser').datepicker({dateFormat: "dd-mm-yy",changeYear: true,onSelect: function(dateText, inst){$('#sampaimasteruser').datepicker('option', 'minDate', dateText);$.datepicker._clearDate('#sampaimasteruser');}});
	$('#sampaimasteruser').datepicker({dateFormat: "dd-mm-yy",changeYear: true,onClose: function(dateText, inst){$('#listmasteruser').trigger("reloadGrid");}});
	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	$("#resetmasteruser").live('click', function(event){
		event.preventDefault();
		$('#formmasteruser').reset();
		$('#listmasteruser').trigger("reloadGrid");
	});
	$("#carimasteruser").live('click', function(event){
		event.preventDefault();
		$('#listmasteruser').trigger("reloadGrid");
	});
})