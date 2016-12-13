jQuery().ready(function (){ 
	jQuery("#listmasterspesialisasi").jqGrid({ 
		url:'c_master_spesialisasi/masterspesialisasixml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['ID','Kode Spesialisasi','Spesialisasi','Action'],
		rownumbers:true,
		width: 1021,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[ 
				{name:'id',index:'id', width:5,hidden:true}, 
				{name:'kode_spesialisasi',index:'kode_spesialisasi', width:100}, 
				{name:'kolom_spesialisasi',index:'kolom_spesialisasi', width:155}, 
				{name:'myid',index:'myid', width:91,align:'center',formatter:formatterAction}
			],
			rowNum:10, 
			rowList:[10,20,30], 
			pager: jQuery('#pagermasterspesialisasi'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				nama=$('#namamasterspesialisasi').val()?$('#namamasterspesialisasi').val():'';
				$('#listmasterspesialisasi').setGridParam({postData:{'nama':nama}})
			}
	}).navGrid('#pagermasterspesialisasi',{edit:false,add:false,del:false,search:false});
	
	function formatterAction(cellvalue, options, rowObject) {
		var content = '';
		content  += '<a rel="' + cellvalue + '" class="icon-detail"  title="View"></a> ';
		content  += '<a rel="' + cellvalue + '" class="icon-edit" title="Edit?"></a>';
		content  += '<a rel="' + cellvalue + '" class="icon-delete" title="Remove?"></a>';
		return content;
	}
	
	$("#listmasterspesialisasi .icon-detail").live('click', function(e){
		if($(e.target).data('oneclicked')!='yes')
		{
			$("#t13","#tabs").empty();
			$("#t13","#tabs").load('c_master_spesialisasi/detail'+'?id='+this.rel);
		}
		$(e.target).data('oneclicked','yes');
	});
	
	$("#listmasterspesialisasi .icon-edit").live('click', function(e){
		if($(e.target).data('oneclicked')!='yes')
		{
			$("#t13","#tabs").empty();
			$("#t13","#tabs").load('c_master_spesialisasi/edit'+'?id='+this.rel);
		}
		$(e.target).data('oneclicked','yes');		
	});
	
	function deldata(myid){
		achtungShowLoader();
		$.ajax({
			  url: 'c_master_spesialisasi/delete',
			  type: "post",
			  data: {id:myid},
			  dataType: "json",
			  success: function(msg){
				if(msg == 'OK'){
					$("#dialogmasterspesialisasi").dialog("close");
					$.achtung({message: 'Proses Hapus Data Berhasil', timeout:5});
					$('#listmasterspesialisasi').trigger("reloadGrid");							
				}
				else{						
					$("#dialogmasterspesialisasi").dialog("close");
					$.achtung({message: 'Maaf Proses Hapus Data Gagal', timeout:5});
				}						
			  }
		  });
		achtungHideLoader();
	}
	
	$("#listmasterspesialisasi .icon-delete").live('click', function(){
		var myid= this.rel;
		$("#dialogmasterspesialisasi").dialog({
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
		
		$("#dialogmasterspesialisasi").dialog("open");
	});
	
	$('form').resize(function(e) {
		if($("#listmasterspesialisasi").getGridParam("records")>0){
		jQuery('#listmasterspesialisasi').setGridWidth(($(this).width()-28));
		}
	});
	
	function formattermou(cellvalue, options, rowObject) {
		var content = '';
		if(cellvalue){		
			content  += '<a href="tmp/c_master_spesialisasi/' + cellvalue + '" style="color:blue;cursor:pointer" title="">download</a>';
		}else{
			content  += ' - ';
		}
		return content;
	}
	
	$('#masterspesialisasiadd').click(function(){
		$("#t13","#tabs").empty();
		$("#t13","#tabs").load('c_master_spesialisasi/add'+'?_=' + (new Date()).getTime());
	});
	
	$( "#sampaimasterspesialisasi" )
		.keypress(function(event) {
			var keycode =(event.keyCode?event.keyCode:event.which);	
			if(keycode ==13){
				event.preventDefault();
				$('#listmasterspesialisasi').trigger("reloadGrid");
			}
	});
	
	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	$("#resetmasterspesialisasi").live('click', function(event){
		event.preventDefault();
		$('#formmasterspesialisasi').reset();
		$('#listmasterspesialisasi').trigger("reloadGrid");
	});
	$("#carimasterspesialisasi").live('click', function(event){
		event.preventDefault();
		$('#listmasterspesialisasi').trigger("reloadGrid");
	});
})