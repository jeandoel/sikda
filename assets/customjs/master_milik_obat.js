jQuery().ready(function (){ 
	jQuery("#listmastermilikobat").jqGrid({ 
		url:'c_master_milik_obat/mastermilikobatxml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['Kode Milik Obat','Kepemilikan','Action'],
		rownumbers:true,
		width: 1000,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[ 
				{name:'kdmilikobat',index:'kdmilikobat', width:20}, 
				{name:'kepemilikan',index:'kepemilikan', width:50}, 
				{name:'x',index:'x', width:50,align:'center',formatter:formatterAction}
			],
			rowNum:10, 
			rowList:[10,20,30], 
			pager: jQuery('#pagermastermilikobat'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				pemilik=$('#pemilikmasterpemilik').val()?$('#pemilikmasterpemilik').val():'';
				$('#listmastermilikobat').setGridParam({postData:{'pemilik':pemilik}})
			}
	}).navGrid('#pagermastermilikobat',{edit:false,add:false,del:false,search:false});
	
	function formatterAction(cellvalue, options, rowObject) {
		var content = '';
		content  += '<a rel="' + cellvalue + '" class="icon-detail" title="View"></a> ';
		content  += '<a rel="' + cellvalue + '" class="icon-edit" title="Edit?"></a>';
		content  += '<a rel="' + cellvalue + '" class="icon-delete" title="Remove?"></a>';
		return content;
	}
	
	$("#listmastermilikobat .icon-detail").live('click', function(c){
	if($(c.target).data('oneclicked')!='yes')
		{
		$("#t74","#tabs").empty();
		$("#t74","#tabs").load('c_master_milik_obat/detail'+'?id='+this.rel);
		}
		$(c.target).data('oneclicked','yes');
	});
	
	$("#listmastermilikobat .icon-edit").live('click', function(c){
	if($(c.target).data('oneclicked')!='yes')
		{
		$("#t74","#tabs").empty();
		$("#t74","#tabs").load('c_master_milik_obat/edit'+'?id='+this.rel);
		}
		$(c.target).data('oneclicked','yes');
	});
	
	function deldata(myid){
		achtungShowLoader();
		$.ajax({
			  url: 'c_master_milik_obat/delete',
			  type: "post",
			  data: {id:myid},
			  dataType: "json",
			  success: function(msg){
				if(msg == 'OK'){
					$("#dialogmastermilikobat").dialog("close");
					$.achtung({message: 'Proses Hapus Data Berhasil', timeout:5});
					$('#listmastermilikobat').trigger("reloadGrid");							
				}
				else{						
					$("#dialogmastermilikobat").dialog("close");
					$.achtung({message: 'Maaf Proses Hapus Data Gagal', timeout:5});
				}						
			  }
		  });
		achtungHideLoader();
	}
	
	$("#listmastermilikobat .icon-delete").live('click', function(){
		var myid= this.rel;
		$("#dialogmastermilikobat").dialog({
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
		
		$("#dialogmastermilikobat").dialog("open");
	});
	
	$('form').resize(function(c) {
		if($("#listmastermilikobat").getGridParam("records")>0){
		jQuery('#listmastermilikobat').setGridWidth(($(this).width()-28));
		}
	});
	
	function formattermou(cellvalue, options, rowObject) {
		var content = '';
		if(cellvalue){		
			content  += '<a href="tmp/mastermilikobat/' + cellvalue + '" style="color:blue;cursor:pointer" title="">download</a>';
		}else{
			content  += ' - ';
		}
		return content;
	}
	
	$('#v_master_milik_obat_add').click(function(){
		$("#t74","#tabs").empty();
		$("#t74","#tabs").load('c_master_milik_obat/add'+'?_=' + (new Date()).getTime());
	});
	
	$( "#sampaimasterrole" )
		.keypress(function(event) {
			var keycode =(event.keyCode?event.keyCode:event.which);	
			if(keycode ==13){
				event.preventDefault();
				$('#listmastermilikobat').trigger("reloadGrid");
			}
	});
	
	$( "#pemilikmasterpemilik" )
		.keypress(function(event) {
			var keycode =(event.keyCode?event.keyCode:event.which);	
			if(keycode ==13){
				event.preventDefault();
				$('#listmastermilikobat').trigger("reloadGrid");
			}
	});
	
	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	$("#resetmastermilikobat").live('click', function(event){
		event.preventDefault();
		$('#formmastermilikobat').reset();
		$('#listmastermilikobat').trigger("reloadGrid");
	});
	$("#carimastermilikobat").live('click', function(event){
		event.preventDefault();
		$('#listmastermilikobat').trigger("reloadGrid");
	});
})