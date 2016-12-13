jQuery().ready(function (){ 
	jQuery("#listmasterkelurahan").jqGrid({ 
		url:'c_master_kelurahan/masterkelurahanxml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['Pilih','Kode Kelurahan','Kode Kecamatan','Kelurahan','Kode Kelurahan'],
		rownumbers:true,
		width: 1021,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[
				{name:'id',index:'id', width:10,hidden:true}, 
				{name:'kodekelurahan',index:'kodekelurahan', width:35}, 
				{name:'kode_kecamatan',index:'kode_kecamatan', width:35}, 
				{name:'kelurahan',index:'kelurahan', width:50},
				{name:'myid',index:'myid', width:30,align:'center',formatter:formatterAction}
			],
			rowNum:10, 
			rowList:[10,20,30], 
			pager: jQuery('#pagermasterkelurahan'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				nama=$('#namamasterkelurahan').val()?$('#namamasterkelurahan').val():'';
				$('#listmasterkelurahan').setGridParam({postData:{'nama':nama}})
			}
	}).navGrid('#pagermasterkelurahan',{edit:false,add:false,del:false,search:false});
	
	function formatterAction(cellvalue, options, rowObject) {
		var content = '';
		content  += '<a rel="' + cellvalue + '" class="icon-detail" title="View"></a> ';
		content  += '<a rel="' + cellvalue + '" class="icon-edit" title="Edit?"></a>';
		content  += '<a rel="' + cellvalue + '" class="icon-delete" title="Remove?"></a>';
		return content;
	}
	
	$("#listmasterkelurahan .icon-detail").live('click', function(d){
		if($(d.target).data('oneclicked')!='yes')
		{
		$("#t19","#tabs").empty();
		$("#t19","#tabs").load('c_master_kelurahan/detail'+'?kode_kelurahan='+this.rel);
		}
		$(d.target).data('oneclicked','yes');
	});
	
	$("#listmasterkelurahan .icon-edit").live('click', function(d){
		if($(d.target).data('oneclicked')!='yes')
		{
		$("#t19","#tabs").empty();
		$("#t19","#tabs").load('c_master_kelurahan/edit'+'?kode_kelurahan='+this.rel);
		}
		$(d.target).data('oneclicked','yes');
	});
	
	function deldata(myid){
		achtungShowLoader();
		$.ajax({
			  url: 'c_master_kelurahan/delete',
			  type: "post",
			  data: {kode_kelurahan:myid},
			  dataType: "json",
			  success: function(msg){
				if(msg == 'OK'){
					$("#dialog").dialog("close");
					$.achtung({message: 'Proses Hapus Data Berhasil', timeout:5});
					$('#listmasterkelurahan').trigger("reloadGrid");							
				}
				else{						
					$("#dialog").dialog("close");
					$.achtung({message: 'Maaf Proses Hapus Data Gagal', timeout:5});
				}						
			  }
		  });
		achtungHideLoader();
	}
	
	$("#listmasterkelurahan .icon-delete").live('click', function(){
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
		if($("#listmasterkelurahan").getGridParam("records")>0){
		jQuery('#listmasterkelurahan').setGridWidth(($(this).width()-28));
		}
	});
	
	function formattermou(cellvalue, options, rowObject) {
		var content = '';
		if(cellvalue){		
			content  += '<a href="tmp/masterkelurahan/' + cellvalue + '" style="color:blue;cursor:pointer" title="">download</a>';
		}else{
			content  += ' - ';
		}
		return content;
	}
	
	$('#masterkelurahanadd').click(function(){
		$("#t19","#tabs").empty();
		$("#t19","#tabs").load('c_master_kelurahan/add'+'?_=' + (new Date()).getTime());
	});
	
	$( "#sampaimasterkelurahan" )
		.keypress(function(event) {
			var keycode =(event.keyCode?event.keyCode:event.which);	
			if(keycode ==13){
				event.preventDefault();
				$('#listmasterkelurahan').trigger("reloadGrid");
			}
	});
	
	$( "#namamasterkelurahan" )
		.keypress(function(event) {
			var keycode =(event.keyCode?event.keyCode:event.which);	
			if(keycode ==13){
				event.preventDefault();
				$('#listmasterkelurahan').trigger("reloadGrid");
			}
	});
	
	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	$("#resetmasterkelurahan").live('click', function(event){
		event.preventDefault();
		$('#formmasterkelurahan').reset();
		$('#listmasterkelurahan').trigger("reloadGrid");
	});
	$("#carimasterkelurahan").live('click', function(event){
		event.preventDefault();
		$('#listmasterkelurahan').trigger("reloadGrid");
	});
})