jQuery().ready(function (){ 
	jQuery("#listmasterKota").jqGrid({ 
		url:'c_master_kota/masterkotaxml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['ID','Nama Propinsi','Tgl. Master','Action'],
		rownumbers:true,
		width: 1021,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[ 
				{name:'id',index:'id', width:5,hidden:true}, 
				{name:'namaKota',index:'namaKota', width:100}, 
				{name:'tgl_masterKota',index:'tgl_masterKota', width:75,align:'center'},
				{name:'myid',index:'myid', width:91,align:'center',formatter:formatterAction}
			],
			rowNum:10, 
			rowList:[10,20,30], 
			pager: jQuery('#pagermasterKota'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				dari=$('#darimasterKota').val()?$('#darimasterKota').val():'';
				sampai=$('#sampaimasterKota').val()?$('#sampaimasterKota').val():'';
				carinama=$('#carinamamasterKota').val()?$('#carinamamasterKota').val():'';
				$('#listmasterKota').setGridParam({postData:{'dari':dari,'sampai':sampai,'carinama':carinama}})
			}
	}).navGrid('#pagermasterKota',{edit:false,add:false,del:false,search:false});
	
	function formatterAction(cellvalue, options, rowObject) {
		var content = '';
		content  += '<a rel="' + cellvalue + '" class="icon-detail"  title="View"></a> ';
		content  += '<a rel="' + cellvalue + '" class="icon-edit" title="Edit?"></a>';
		content  += '<a rel="' + cellvalue + '" class="icon-delete" title="Remove?"></a>';
		return content;
	}
	
	$("#listmasterKota .icon-detail").live('click', function(e){
		if($(e.target).data('oneclicked')!='yes')
		{
			$("#t27","#tabs").empty();
			$("#t27","#tabs").load('c_master_kota/detail'+'?id='+this.rel+ '_=' + (new Date()).getTime());
		}
		$(e.target).data('oneclicked','yes');
	});
	
	$("#listmasterKota .icon-edit").live('click', function(e){
		if($(e.target).data('oneclicked')!='yes')
		{
			$("#t27","#tabs").empty();
			$("#t27","#tabs").load('c_master_kota/edit'+'?id='+this.rel+ '_=' + (new Date()).getTime());
		}
		$(e.target).data('oneclicked','yes');		
	});
	
	function deldata(myid){
		achtungShowLoader();
		$.ajax({
			  url: 'c_master_kota/delete',
			  type: "post",
			  data: {id:myid},
			  dataType: "json",
			  success: function(msg){
				if(msg == 'OK'){
					$("#dialogmasterKota").dialog("close");
					$.achtung({message: 'Proses Hapus Data Berhasil', timeout:5});
					$('#listmasterKota').trigger("reloadGrid");							
				}
				else{						
					$("#dialogmasterKota").dialog("close");
					$.achtung({message: 'Maaf Proses Hapus Data Gagal', timeout:5});
				}						
			  }
		  });
		achtungHideLoader();
	}
	
	$("#listmasterKota .icon-delete").live('click', function(){
		var myid= this.rel;
		$("#dialogmasterKota").dialog({
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
		
		$("#dialogmasterKota").dialog("open");
	});
	
	$('form').resize(function(e) {
		if($("#listmasterKota").getGridParam("records")>0){
		jQuery('#listmasterKota').setGridWidth(($(this).width()-28));
		}
	});
	
	function formattermou(cellvalue, options, rowObject) {
		var content = '';
		if(cellvalue){		
			content  += '<a href="tmp/c_master_kota/' + cellvalue + '" style="color:blue;cursor:pointer" title="">download</a>';
		}else{
			content  += ' - ';
		}
		return content;
	}
	
	$('#masterKotaadd').click(function(){
		$("#t27","#tabs").empty();
		$("#t27","#tabs").load('c_master_kota/add'+'?_=' + (new Date()).getTime());
	});
	
	$( "#sampaimasterKota" )
		.keypress(function(event) {
			var keycode =(event.keyCode?event.keyCode:event.which);	
			if(keycode ==13){
				event.preventDefault();
				$('#listmasterKota').trigger("reloadGrid");
			}
	});
	
	$('#darimasterKota').datepicker({dateFormat: "dd-mm-yy",changeYear: true,onSelect: function(dateText, inst){$('#sampaimasterKota').datepicker('option', 'minDate', dateText);$.datepicker._clearDate('#sampaimasterKota');}});
	$('#sampaimasterKota').datepicker({dateFormat: "dd-mm-yy",changeYear: true,onClose: function(dateText, inst){$('#listmasterKota').trigger("reloadGrid");}});
	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	$("#resetmasterKota").live('click', function(event){
		event.preventDefault();
		$('#formmasterKota').reset();
		$('#listmasterKota').trigger("reloadGrid");
	});
	$("#carimasterKota").live('click', function(event){
		event.preventDefault();
		$('#listmasterKota').trigger("reloadGrid");
	});
})