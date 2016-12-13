jQuery().ready(function (){ 
	jQuery("#listmastertransfer").jqGrid({ 
		url:'c_master_transfer/mastertransferxml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['ID','Kode Transfer','Produk Transfer','Action'],
		rownumbers:true,
		width: 1021,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[ 
				{name:'id',index:'id', width:5,hidden:true}, 
				{name:'kode_transfer',index:'kode_transfer', width:100}, 
				{name:'produk_transfer',index:'produk_transfer', width:155}, 
				{name:'myid',index:'myid', width:91,align:'center',formatter:formatterAction}
			],
			rowNum:10, 
			rowList:[10,20,30], 
			pager: jQuery('#pagermastertransfer'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				nama=$('#namamastertransfer').val()?$('#namamastertransfer').val():'';
				$('#listmastertransfer').setGridParam({postData:{'nama':nama}})
			}
	}).navGrid('#pagermastertransfer',{edit:false,add:false,del:false,search:false});
	
	function formatterAction(cellvalue, options, rowObject) {
		var content = '';
		content  += '<a rel="' + cellvalue + '" class="icon-detail"  title="View"></a> ';
		content  += '<a rel="' + cellvalue + '" class="icon-edit" title="Edit?"></a>';
		content  += '<a rel="' + cellvalue + '" class="icon-delete" title="Remove?"></a>';
		return content;
	}
	
	$("#listmastertransfer .icon-detail").live('click', function(e){
		if($(e.target).data('oneclicked')!='yes')
		{
			$("#t16","#tabs").empty();
			$("#t16","#tabs").load('c_master_transfer/detail'+'?id='+this.rel);
		}
		$(e.target).data('oneclicked','yes');
	});
	
	$("#listmastertransfer .icon-edit").live('click', function(e){
		if($(e.target).data('oneclicked')!='yes')
		{
			$("#t16","#tabs").empty();
			$("#t16","#tabs").load('c_master_transfer/edit'+'?id='+this.rel);
		}
		$(e.target).data('oneclicked','yes');		
	});
	
	function deldata(myid){
		achtungShowLoader();
		$.ajax({
			  url: 'c_master_transfer/delete',
			  type: "post",
			  data: {id:myid},
			  dataType: "json",
			  success: function(msg){
				if(msg == 'OK'){
					$("#dialogmastertransfer").dialog("close");
					$.achtung({message: 'Proses Hapus Data Berhasil', timeout:5});
					$('#listmastertransfer').trigger("reloadGrid");							
				}
				else{						
					$("#dialogmastertransfer").dialog("close");
					$.achtung({message: 'Maaf Proses Hapus Data Gagal', timeout:5});
				}						
			  }
		  });
		achtungHideLoader();
	}
	
	$("#listmastertransfer .icon-delete").live('click', function(){
		var myid= this.rel;
		$("#dialogmastertransfer").dialog({
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
		
		$("#dialogmastertransfer").dialog("open");
	});
	
	$('form').resize(function(e) {
		if($("#listmastertransfer").getGridParam("records")>0){
		jQuery('#listmastertransfer').setGridWidth(($(this).width()-28));
		}
	});
	
	function formattermou(cellvalue, options, rowObject) {
		var content = '';
		if(cellvalue){		
			content  += '<a href="tmp/c_master_transfer/' + cellvalue + '" style="color:blue;cursor:pointer" title="">download</a>';
		}else{
			content  += ' - ';
		}
		return content;
	}
	
	$('#mastertransferadd').click(function(){
		$("#t16","#tabs").empty();
		$("#t16","#tabs").load('c_master_transfer/add'+'?_=' + (new Date()).getTime());
	});
	
	$( "#sampaimastertransfer" )
		.keypress(function(event) {
			var keycode =(event.keyCode?event.keyCode:event.which);	
			if(keycode ==13){
				event.preventDefault();
				$('#listmastertransfer').trigger("reloadGrid");
			}
	});
	
	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	$("#resetmastertransfer").live('click', function(event){
		event.preventDefault();
		$('#formmastertransfer').reset();
		$('#listmastertransfer').trigger("reloadGrid");
	});
	$("#carimastertransfer").live('click', function(event){
		event.preventDefault();
		$('#listmastertransfer').trigger("reloadGrid");
	});
})