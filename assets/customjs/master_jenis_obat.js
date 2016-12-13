jQuery().ready(function (){ 
	jQuery("#listmasterjenisobat").jqGrid({ 
		url:'c_master_jenis_obat/masterjenisobatxml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['Kode Jenis Obat','Jenis Obat','Action'],
		rownumbers:true,
		width: 1000,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[ 
				{name:'kdjnsobat',index:'kdjnsobat', width:20}, 
				{name:'jenisobat',index:'jenisobat', width:50}, 
				{name:'x',index:'x', width:50,align:'center',formatter:formatterAction}
			],
			rowNum:10, 
			rowList:[10,20,30], 
			pager: jQuery('#pagermasterjenisobat'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				jnsobat=$('#jnsobatmasterjnsobat').val()?$('#jnsobatmasterjnsobat').val():'';
				$('#listmasterjenisobat').setGridParam({postData:{'jnsobat':jnsobat}})
			}
	}).navGrid('#pagermasterjenisobat',{edit:false,add:false,del:false,search:false});
	
	function formatterAction(cellvalue, options, rowObject) {
		var content = '';
		content  += '<a rel="' + cellvalue + '" class="icon-detail" title="View"></a> ';
		content  += '<a rel="' + cellvalue + '" class="icon-edit" title="Edit?"></a>';
		content  += '<a rel="' + cellvalue + '" class="icon-delete" title="Remove?"></a>';
		return content;
	}
	
	$("#listmasterjenisobat .icon-detail").live('click', function(c){
	if($(c.target).data('oneclicked')!='yes')
		{
		$("#t73","#tabs").empty();
		$("#t73","#tabs").load('c_master_jenis_obat/detail'+'?id='+this.rel);
		}
		$(c.target).data('oneclicked','yes');
	});
	
	$("#listmasterjenisobat .icon-edit").live('click', function(c){
	if($(c.target).data('oneclicked')!='yes')
		{
		$("#t73","#tabs").empty();
		$("#t73","#tabs").load('c_master_jenis_obat/edit'+'?id='+this.rel);
		}
		$(c.target).data('oneclicked','yes');
	});
	
	function deldata(myid){
		achtungShowLoader();
		$.ajax({
			  url: 'c_master_jenis_obat/delete',
			  type: "post",
			  data: {id:myid},
			  dataType: "json",
			  success: function(msg){
				if(msg == 'OK'){
					$("#dialogmasterjenisobat").dialog("close");
					$.achtung({message: 'Proses Hapus Data Berhasil', timeout:5});
					$('#listmasterjenisobat').trigger("reloadGrid");							
				}
				else{						
					$("#dialogmasterjenisobat").dialog("close");
					$.achtung({message: 'Maaf Proses Hapus Data Gagal', timeout:5});
				}						
			  }
		  });
		achtungHideLoader();
	}
	
	$("#listmasterjenisobat .icon-delete").live('click', function(){
		var myid= this.rel;
		$("#dialogmasterjenisobat").dialog({
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
		
		$("#dialogmasterjenisobat").dialog("open");
	});
	
	$('form').resize(function(c) {
		if($("#listmasterjenisobat").getGridParam("records")>0){
		jQuery('#listmasterjenisobat').setGridWidth(($(this).width()-28));
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
	
	$('#v_master_jenis_obat_add').click(function(){
		$("#t73","#tabs").empty();
		$("#t73","#tabs").load('c_master_jenis_obat/add'+'?_=' + (new Date()).getTime());
	});
	
	$( "#sampaimasterrole" )
		.keypress(function(event) {
			var keycode =(event.keyCode?event.keyCode:event.which);	
			if(keycode ==13){
				event.preventDefault();
				$('#listmasterjenisobat').trigger("reloadGrid");
			}
	});
	
	$( "#jnsobatmasterjnsobat" )
		.keypress(function(event) {
			var keycode =(event.keyCode?event.keyCode:event.which);	
			if(keycode ==13){
				event.preventDefault();
				$('#listmasterjenisobat').trigger("reloadGrid");
			}
	});
	
	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	$("#resetmasterjenisobat").live('click', function(event){
		event.preventDefault();
		$('#formmasterjenisobat').reset();
		$('#listmasterjenisobat').trigger("reloadGrid");
	});
	$("#carimasterjenisobat").live('click', function(event){
		event.preventDefault();
		$('#listmasterjenisobat').trigger("reloadGrid");
	});
})