jQuery().ready(function (){ 
	jQuery("#listmastersatuankecil").jqGrid({ 
		url:'c_master_satuan_kecil/mastersatuankecilxml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['Pilih','Kode Satuan Kecil Obat','Satuan Kecil Obat','Action'],
		rownumbers:true,
		width: 1000,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[ 
				{name:'id',index:'id', width:20,hidden:true}, 
				{name:'kdsatkclobat',index:'kdsatkclobat', width:20}, 
				{name:'satkclobat',index:'satkclobat', width:50}, 
				{name:'x',index:'x', width:50,align:'center',formatter:formatterAction}
			],
			rowNum:10, 
			rowList:[10,20,30], 
			pager: jQuery('#pagermastersatuanobat'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				satuankcl=$('#satuanmastersatuankcl').val()?$('#satuanmastersatuankcl').val():'';
				$('#listmastersatuankecil').setGridParam({postData:{'satuankcl':satuankcl}})
			}
	}).navGrid('#pagermastersatuanobat',{edit:false,add:false,del:false,search:false});
	
	function formatterAction(cellvalue, options, rowObject) {
		var content = '';
		content  += '<a rel="' + cellvalue + '" class="icon-detail" title="View"></a> ';
		content  += '<a rel="' + cellvalue + '" class="icon-edit" title="Edit?"></a>';
		content  += '<a rel="' + cellvalue + '" class="icon-delete" title="Remove?"></a>';
		return content;
	}
	
	$("#listmastersatuankecil .icon-detail").live('click', function(c){
	if($(c.target).data('oneclicked')!='yes')
		{
		$("#t72","#tabs").empty();
		$("#t72","#tabs").load('c_master_satuan_kecil/detail'+'?id='+this.rel);
		}
		$(c.target).data('oneclicked','yes');
	});
	
	$("#listmastersatuankecil .icon-edit").live('click', function(c){
	if($(c.target).data('oneclicked')!='yes')
		{
		$("#t72","#tabs").empty();
		$("#t72","#tabs").load('c_master_satuan_kecil/edit'+'?id='+this.rel);
		}
		$(c.target).data('oneclicked','yes');
	});
	
	function deldata(myid){
		achtungShowLoader();
		$.ajax({
			  url: 'c_master_satuan_kecil/delete',
			  type: "post",
			  data: {id:myid},
			  dataType: "json",
			  success: function(msg){
				if(msg == 'OK'){
					$("#dialogmastersatuankecil").dialog("close");
					$.achtung({message: 'Proses Hapus Data Berhasil', timeout:5});
					$('#listmastersatuankecil').trigger("reloadGrid");							
				}
				else{						
					$("#dialogmastersatuankecil").dialog("close");
					$.achtung({message: 'Maaf Proses Hapus Data Gagal', timeout:5});
				}						
			  }
		  });
		achtungHideLoader();
	}
	
	$("#listmastersatuankecil .icon-delete").live('click', function(){
		var myid= this.rel;
		$("#dialogmastersatuankecil").dialog({
			autoOpen:false,
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
		
		$("#dialogmastersatuankecil").dialog("open");
	});
	
	$('form').resize(function(c) {
		if($("#listmastersatuankecil").getGridParam("records")>0){
		jQuery('#listmastersatuankecil').setGridWidth(($(this).width()-28));
		}
	});
	
	function formattermou(cellvalue, options, rowObject) {
		var content = '';
		if(cellvalue){		
			content  += '<a href="tmp/mastersatuankecil/' + cellvalue + '" style="color:blue;cursor:pointer" title="">download</a>';
		}else{
			content  += ' - ';
		}
		return content;
	}
	
	$('#v_master_satuan_kecil_add').click(function(){
		$("#t72","#tabs").empty();
		$("#t72","#tabs").load('c_master_satuan_kecil/add'+'?_=' + (new Date()).getTime());
	});
	
	$( "#sampaimastersatuan" )
		.keypress(function(event) {
			var keycode =(event.keyCode?event.keyCode:event.which);	
			if(keycode ==13){
				event.preventDefault();
				$('#listmastersatuankecil').trigger("reloadGrid");
			}
	});
	
	$( "#satuanmastersatuankcl" )
		.keypress(function(event) {
			var keycode =(event.keyCode?event.keyCode:event.which);	
			if(keycode ==13){
				event.preventDefault();
				$('#listmastersatuankecil').trigger("reloadGrid");
			}
	});
	
	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	$("#resetmastersatuankecil").live('click', function(event){
		event.preventDefault();
		$('#formmastersatuankecil').reset();
		$('#listmastersatuankecil').trigger("reloadGrid");
	});
	$("#carimastersatuankecil").live('click', function(event){
		event.preventDefault();
		$('#listmastersatuankecil').trigger("reloadGrid");
	});
})