jQuery().ready(function (){ 
	jQuery("#listmasterposisi").jqGrid({ 
		url:'c_master_posisi/masterposisixml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['ID','Kode Posisi','Posisi','Action'],
		rownumbers:true,
		width: 1021,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[ 
				{name:'id',index:'id', width:5,hidden:true}, 
				{name:'kode_posisi',index:'kode_posisi', width:30}, 
				{name:'nama_posisi',index:'nama_posisi', width:50}, 
				{name:'x',index:'x', width:15,align:'center',formatter:formatterAction}
			],
			rowNum:10, 
			rowList:[10,20,30], 
			pager: jQuery('#pagermasterposisi'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				nama=$('#namamasterposisi').val()?$('#namamasterposisi').val():'';
				$('#listmasterposisi').setGridParam({postData:{'nama':nama}})
			}
	}).navGrid('#pagermasterposisi',{edit:false,add:false,del:false,search:false});
	
	function formatterAction(cellvalue, options, rowObject) {
		var content = '';
		content  += '<a rel="' + cellvalue + '" class="icon-detail" title="View"></a> ';
		content  += '<a rel="' + cellvalue + '" class="icon-edit" title="Edit?"></a>';
		content  += '<a rel="' + cellvalue + '" class="icon-delete" title="Remove?"></a>';
		return content;
	}
	
	$("#listmasterposisi .icon-detail").live('click', function(p){
		if($(p.target).data('oneclicked')!='yes')
		{
		$("#t11","#tabs").empty();
		$("#t11","#tabs").load('c_master_posisi/detail'+'?id='+this.rel);
		}
		$(p.target).data('oneclicked','yes');
	});
	
	$("#listmasterposisi .icon-edit").live('click', function(p){
		if($(p.target).data('oneclicked')!='yes')
		{
		$("#t11","#tabs").empty();
		$("#t11","#tabs").load('c_master_posisi/edit'+'?id	='+this.rel);
		}
		$(p.target).data('oneclicked','yes');
	});
	
	function deldata(myid){
		achtungShowLoader();
		$.ajax({
			  url: 'c_master_posisi/delete',
			  type: "post",
			  data: {id:myid},
			  dataType: "json",
			  success: function(msg){
				if(msg == 'OK'){
					$("#dialog").dialog("close");
					$.achtung({message: 'Proses Hapus Data Berhasil', timeout:5});
					$('#listmasterposisi').trigger("reloadGrid");							
				}
				else{						
					$("#dialog").dialog("close");
					$.achtung({message: 'Maaf Proses Hapus Data Gagal', timeout:5});
				}						
			  }
		  });
		achtungHideLoader();
	}
	
	$("#listmasterposisi .icon-delete").live('click', function(){
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
		if($("#listmasterposisi").getGridParam("records")>0){
		jQuery('#listmasterposisi').setGridWidth(($(this).width()-28));
		}
	});
	
	function formattermou(cellvalue, options, rowObject) {
		var content = '';
		if(cellvalue){		
			content  += '<a href="tmp/masterposisi/' + cellvalue + '" style="color:blue;cursor:pointer" title="">download</a>';
		}else{
			content  += ' - ';
		}
		return content;
	}
	
	$('#masterposisiadd').click(function(){
		$("#t11","#tabs").empty();
		$("#t11","#tabs").load('c_master_posisi/add'+'?_=' + (new Date()).getTime());
	});
	
	$( "#namamasterposisi" )
		.keypress(function(event) {
			var keycode =(event.keyCode?event.keyCode:event.which);	
			if(keycode ==13){
				event.preventDefault();
				$('#listmasterposisi').trigger("reloadGrid");
			}
	});
	
	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	$("#resetmasterposisi").live('click', function(event){
		event.preventDefault();
		$('#formmasterposisi').reset();
		$('#listmasterposisi').trigger("reloadGrid");
	});
	$("#carimasterposisi").live('click', function(event){
		event.preventDefault();
		$('#listmasterposisi').trigger("reloadGrid");
	});
})