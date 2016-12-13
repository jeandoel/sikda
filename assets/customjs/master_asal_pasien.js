jQuery().ready(function (){ 
	jQuery("#listmasterasalpasien").jqGrid({ 
		url:'c_master_asal_pasien/masterasalpasienxml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['ID','Kode Asal','Asal Pasien','Action'],
		rownumbers:true,
		width: 1021,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[ 
				{name:'id',index:'id', width:5,hidden:true}, 
				{name:'kode_asal',index:'kode_asal', width:30}, 
				{name:'asal_pasien',index:'asal_pasien', width:50}, 
				{name:'x',index:'x', width:15,align:'center',formatter:formatterAction}
			],
			rowNum:10, 
			rowList:[10,20,30], 
			pager: jQuery('#pagermasterasalpasien'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				nama=$('#namamasterasalpasien').val()?$('#namamasterasalpasien').val():'';
				$('#listmasterasalpasien').setGridParam({postData:{'nama':nama}})
			}
	}).navGrid('#pagermasterasalpasien',{edit:false,add:false,del:false,search:false});
	
	function formatterAction(cellvalue, options, rowObject) {
		var content = '';
		content  += '<a rel="' + cellvalue + '" class="icon-detail" title="View"></a> ';
		content  += '<a rel="' + cellvalue + '" class="icon-edit" title="Edit?"></a>';
		content  += '<a rel="' + cellvalue + '" class="icon-delete" title="Remove?"></a>';
		return content;
	}
	
	$("#listmasterasalpasien .icon-detail").live('click', function(p){
		if($(p.target).data('oneclicked')!='yes')
		{
		$("#t14","#tabs").empty();
		$("#t14","#tabs").load('c_master_asal_pasien/detail'+'?id='+this.rel);
		}
		$(p.target).data('oneclicked','yes');
	});
	
	$("#listmasterasalpasien .icon-edit").live('click', function(p){
		if($(p.target).data('oneclicked')!='yes')
		{
		$("#t14","#tabs").empty();
		$("#t14","#tabs").load('c_master_asal_pasien/edit'+'?id	='+this.rel);
		}
		$(p.target).data('oneclicked','yes');
	});
	
	function deldata(myid){
		achtungShowLoader();
		$.ajax({
			  url: 'c_master_asal_pasien/delete',
			  type: "post",
			  data: {id:myid},
			  dataType: "json",
			  success: function(msg){
				if(msg == 'OK'){
					$("#dialogmasterasalpasien_new").dialog("close");
					$.achtung({message: 'Proses Hapus Data Berhasil', timeout:5});
					$('#listmasterasalpasien').trigger("reloadGrid");							
				}
				else{						
					$("#dialogmasterasalpasien_new").dialog("close");
					$.achtung({message: 'Maaf Proses Hapus Data Gagal', timeout:5});
				}						
			  }
		  });
		achtungHideLoader();
	}
	
	$("#listmasterasalpasien .icon-delete").live('click', function(){
		var myid= this.rel;
		$("#dialogmasterasalpasien_new").dialog({
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
		
		$("#dialogmasterasalpasien_new").dialog("open");
	});
	
	$('form').resize(function(e) {
		if($("#listmasterasalpasien").getGridParam("records")>0){
		jQuery('#listmasterasalpasien').setGridWidth(($(this).width()-28));
		}
	});
	
	function formattermou(cellvalue, options, rowObject) {
		var content = '';
		if(cellvalue){		
			content  += '<a href="tmp/masterasalpasien/' + cellvalue + '" style="color:blue;cursor:pointer" title="">download</a>';
		}else{
			content  += ' - ';
		}
		return content;
	}
	
	$('#masterasalpasienadd').click(function(){
		$("#t14","#tabs").empty();
		$("#t14","#tabs").load('c_master_asal_pasien/add'+'?_=' + (new Date()).getTime());
	});
	
	$( "#namamasterasalpasien" )
		.keypress(function(event) {
			var keycode =(event.keyCode?event.keyCode:event.which);	
			if(keycode ==13){
				event.preventDefault();
				$('#listmasterasalpasien').trigger("reloadGrid");
			}
	});
	
	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	$("#resetmasterasalpasien").live('click', function(event){
		event.preventDefault();
		$('#formmasterasalpasien').reset();
		$('#listmasterasalpasien').trigger("reloadGrid");
	});
	$("#carimasterasalpasien").live('click', function(event){
		event.preventDefault();
		$('#listmasterasalpasien').trigger("reloadGrid");
	});
})
