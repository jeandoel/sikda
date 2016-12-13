jQuery().ready(function (){ 
	jQuery("#listmasterdesa").jqGrid({ 
		url:'c_master_desa/masterdesaxml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['ID','Nama Desa','Tgl. Master Desa','Action'],
		rownumbers:true,
		width: 1021,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[ 
				{name:'id',index:'id', width:5,hidden:true}, 
				{name:'kolom_desa',index:'kolom_desa', width:155}, 
				{name:'tgl_masterdesa',index:'tgl_masterdesa', width:100,align:'center'},
				{name:'x',index:'x', width:91,align:'center',formatter:formatterAction}
			],
			rowNum:10, 
			rowList:[10,20,30], 
			pager: jQuery('#pagermasterdesa'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				dari=$('#darimasterdesa').val()?$('#darimasterdesa').val():'';
				sampai=$('#sampaimasterdesa').val()?$('#sampaimasterdesa').val():'';
				nama=$('#namamasterdesa').val()?$('#namamasterdesa').val():'';
				$('#listmasterdesa').setGridParam({postData:{'dari':dari,'sampai':sampai,'nama':nama}})
			}
	}).navGrid('#pagermasterdesa',{edit:false,add:false,del:false,search:false});
	
	function formatterAction(cellvalue, options, rowObject) {
		var content = '';
		content  += '<a rel="' + cellvalue + '" class="icon-detail" title="View"></a> ';
		content  += '<a rel="' + cellvalue + '" class="icon-edit" title="Edit?"></a>';
		content  += '<a rel="' + cellvalue + '" class="icon-delete" title="Remove?"></a>';
		return content;
	}
	
	$("#listmasterdesa .icon-detail").live('click', function(d){
		if($(d.target).data('oneclicked')!='yes')
		{
		$("#t19","#tabs").empty();
		$("#t19","#tabs").load('c_master_desa/detail'+'?id='+this.rel+ '_=' + (new Date()).getTime());
		}
		$(d.target).data('oneclicked','yes');
	});
	
	$("#listmasterdesa .icon-edit").live('click', function(d){
		if($(d.target).data('oneclicked')!='yes')
		{
		$("#t19","#tabs").empty();
		$("#t19","#tabs").load('c_master_desa/edit'+'?id='+this.rel);
		}
		$(d.target).data('oneclicked','yes');
	});
	
	function deldata(myid){
		achtungShowLoader();
		$.ajax({
			  url: 'c_master_desa/delete',
			  type: "post",
			  data: {id:myid},
			  dataType: "json",
			  success: function(msg){
				if(msg == 'OK'){
					$("#dialog").dialog("close");
					$.achtung({message: 'Proses Hapus Data Berhasil', timeout:5});
					$('#listmasterdesa').trigger("reloadGrid");							
				}
				else{						
					$("#dialog").dialog("close");
					$.achtung({message: 'Maaf Proses Hapus Data Gagal', timeout:5});
				}						
			  }
		  });
		achtungHideLoader();
	}
	
	$("#listmasterdesa .icon-delete").live('click', function(){
		var myid= this.rel;
		$("#dialog").dialog({
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
		
		$("#dialog").dialog("open");
	});
	
	$('form').resize(function(e) {
		if($("#listmasterdesa").getGridParam("records")>0){
		jQuery('#listmasterdesa').setGridWidth(($(this).width()-28));
		}
	});
	
	function formattermou(cellvalue, options, rowObject) {
		var content = '';
		if(cellvalue){		
			content  += '<a href="tmp/masterdesa/' + cellvalue + '" style="color:blue;cursor:pointer" title="">download</a>';
		}else{
			content  += ' - ';
		}
		return content;
	}
	
	$('#masterdesaadd').click(function(){
		$("#t19","#tabs").empty();
		$("#t19","#tabs").load('c_master_desa/add'+'?_=' + (new Date()).getTime());
	});
	
	$( "#sampaimasterdesa" )
		.keypress(function(event) {
			var keycode =(event.keyCode?event.keyCode:event.which);	
			if(keycode ==13){
				event.preventDefault();
				$('#listmasterdesa').trigger("reloadGrid");
			}
	});
	
	$( "#namamasterdesa" )
		.keypress(function(event) {
			var keycode =(event.keyCode?event.keyCode:event.which);	
			if(keycode ==13){
				event.preventDefault();
				$('#listmasterdesa').trigger("reloadGrid");
			}
	});
	
	$('#darimasterdesa').datepicker({dateFormat: "dd-mm-yy",changeYear: true,onSelect: function(dateText, inst){$('#sampaimasterdesa').datepicker('option', 'minDate', dateText);$.datepicker._clearDate('#sampaimasterdesa');}});
	$('#sampaimasterdesa').datepicker({dateFormat: "dd-mm-yy",changeYear: true,onClose: function(dateText, inst){$('#listmasterdesa').trigger("reloadGrid");}});
	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	$("#resetmasterdesa").live('click', function(event){
		event.preventDefault();
		$('#formmasterdesa').reset();
		$('#listmasterdesa').trigger("reloadGrid");
	});
	$("#carimasterdesa").live('click', function(event){
		event.preventDefault();
		$('#listmasterdesa').trigger("reloadGrid");
	});
})