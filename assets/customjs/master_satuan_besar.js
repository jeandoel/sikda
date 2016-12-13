jQuery().ready(function (){ 
	jQuery("#listmastersatuanbesar").jqGrid({ 
		url:'c_master_satuan_besar/mastersatuanbesarxml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['Pilih','Kode Satuan Besar','Satuan Besar Obat','Action'],
		rownumbers:true,
		width: 1000,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[
				{name:'id',index:'id', width:20,hidden:true},
				{name:'kdsatbesar',index:'kdsatbesar', width:20}, 
				{name:'satbesarobat',index:'satbesarobat', width:50}, 
				{name:'x',index:'x', width:50,align:'center',formatter:formatterAction}
			],
			rowNum:10, 
			rowList:[10,20,30], 
			pager: jQuery('#pagermastersatuanbesar'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				satuan=$('#satuanmastersatuan').val()?$('#satuanmastersatuan').val():'';
				$('#listmastersatuanbesar').setGridParam({postData:{'satuan':satuan}})
			}
	}).navGrid('#pagermastersatuanbesar',{edit:false,add:false,del:false,search:false});
	
	function formatterAction(cellvalue, options, rowObject) {
		var content = '';
		content  += '<a rel="' + cellvalue + '" class="icon-detail" title="View"></a> ';
		content  += '<a rel="' + cellvalue + '" class="icon-edit" title="Edit?"></a>';
		content  += '<a rel="' + cellvalue + '" class="icon-delete" title="Remove?"></a>';
		return content;
	}
	
	$("#listmastersatuanbesar .icon-detail").live('click', function(c){
	if($(c.target).data('oneclicked')!='yes')
		{
		$("#t71","#tabs").empty();
		$("#t71","#tabs").load('c_master_satuan_besar/detail'+'?id='+this.rel);
		}
		$(c.target).data('oneclicked','yes');
	});
	
	$("#listmastersatuanbesar .icon-edit").live('click', function(c){
	if($(c.target).data('oneclicked')!='yes')
		{
		$("#t71","#tabs").empty();
		$("#t71","#tabs").load('c_master_satuan_besar/edit'+'?id='+this.rel);
		}
		$(c.target).data('oneclicked','yes');
	});
	
	function deldata(myid){
		achtungShowLoader();
		$.ajax({
			  url: 'c_master_satuan_besar/delete',
			  type: "post",
			  data: {id:myid},
			  dataType: "json",
			  success: function(msg){
				if(msg == 'OK'){
					$("#dialogmastersatuanbesar").dialog("close");
					$.achtung({message: 'Proses Hapus Data Berhasil', timeout:5});
					$('#listmastersatuanbesar').trigger("reloadGrid");							
				}
				else{						
					$("#dialogmastersatuanbesar").dialog("close");
					$.achtung({message: 'Maaf Proses Hapus Data Gagal', timeout:5});
				}						
			  }
		  });
		achtungHideLoader();
	}
	
	$("#listmastersatuanbesar .icon-delete").live('click', function(){
		var myid= this.rel;
		$("#dialogmastersatuanbesar").dialog({
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
		
		$("#dialogmastersatuanbesar").dialog("open");
	});
	
	$('form').resize(function(c) {
		if($("#listmastersatuanbesar").getGridParam("records")>0){
		jQuery('#listmastersatuanbesar').setGridWidth(($(this).width()-28));
		}
	});
	
	function formattermou(cellvalue, options, rowObject) {
		var content = '';
		if(cellvalue){		
			content  += '<a href="tmp/mastersatuanbesar/' + cellvalue + '" style="color:blue;cursor:pointer" title="">download</a>';
		}else{
			content  += ' - ';
		}
		return content;
	}
	
	$('#v_master_satuan_besar_add').click(function(){
		$("#t71","#tabs").empty();
		$("#t71","#tabs").load('c_master_satuan_besar/add'+'?_=' + (new Date()).getTime());
	});
	
	$( "#sampaimasterrole" )
		.keypress(function(event) {
			var keycode =(event.keyCode?event.keyCode:event.which);	
			if(keycode ==13){
				event.preventDefault();
				$('#listmastersatuanbesar').trigger("reloadGrid");
			}
	});
	
	$( "#satuanmastersatuan" )
		.keypress(function(event) {
			var keycode =(event.keyCode?event.keyCode:event.which);	
			if(keycode ==13){
				event.preventDefault();
				$('#listmastersatuanbesar').trigger("reloadGrid");
			}
	});
	
	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	$("#resetmastersatuanbesar").live('click', function(event){
		event.preventDefault();
		$('#formmastersatuanbesar').reset();
		$('#listmastersatuanbesar').trigger("reloadGrid");
	});
	$("#carimastersatuanbesar").live('click', function(event){
		event.preventDefault();
		$('#listmastersatuanbesar').trigger("reloadGrid");
	});
})