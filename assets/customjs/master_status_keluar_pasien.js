jQuery().ready(function (){ 
	jQuery("#listkeluarpasien").jqGrid({ 
		url:'c_master_status_keluar_pasien/keluarpasienxml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['Kode Status','Keterangan','Action'],
		rownumbers:true,
		width: 1040,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[ 
				{name:'kd',index:'kd', width:99}, 
				{name:'keterangan',index:'keterangan', width:99},
				{name:'x',index:'x', width:110,align:'center',formatter:formatterAction}
			],
			rowNum:10, 
			rowList:[10,20,30], 
			pager: jQuery('#pagermasterkeluarpasien'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				keyword=$('#keywordid').val()?$('#keywordid').val():'';
				cari=$('#carinamamasterkeluarpasien').val()?$('#carinamamasterkeluarpasien').val():'';
				$('#listkeluarpasien').setGridParam({postData:{'keyword':'KD_STATUS','cari':cari}})
			}
	}).navGrid('#pagermasterkeluarpasien',{edit:false,add:false,del:false,search:false});
	
	function formatterAction(cellvalue, options, rowObject) {
		var content = '';
		content  += '<a rel="' + encodeURIComponent(cellvalue) + '" class="icon-detail"  title="View"></a> ';
		content  += '<a rel="' + encodeURIComponent(cellvalue) + '" class="icon-edit" title="Edit?"></a>';
		content  += '<a rel="' + encodeURIComponent(cellvalue) + '" class="icon-delete" title="Remove?"></a>';
		return content;
	}
	
	$("#listkeluarpasien .icon-detail").live('click', function(a){
		if($(a.target).data('oneclicked')!='yes')
                {    
		$("#t34","#tabs").empty();
		$("#t34","#tabs").load('c_master_status_keluar_pasien/detail'+'?kd='+this.rel);
                }
                $(a.target).data('oneclicked','yes');
	});
	
	$("#listkeluarpasien .icon-edit").live('click', function(a){
		if($(a.target).data('oneclicked')!='yes')
                {    
		$("#t34","#tabs").empty();
		$("#t34","#tabs").load('c_master_status_keluar_pasien/edit'+'?kd='+this.rel);
                }
                $(a.target).data('oneclicked','yes');
                
	});
	
	function deldata(myid){
		achtungShowLoader();
		$.ajax({
			  url: 'c_master_status_keluar_pasien/delete',
			  type: "post",
			  data: {kd:myid},
			  dataType: "json",
			  success: function(msg){
				if(msg == 'OK'){
					$("#dialogkeluarpasien").dialog("close");
					$.achtung({message: 'Proses Hapus Data Berhasil', timeout:5});
					$('#listkeluarpasien').trigger("reloadGrid");							
				}
				else{						
					$("#dialogkeluarpasien").dialog("close");
					$.achtung({message: 'Maaf Proses Hapus Data Gagal', timeout:5});
				}						
			  }
		  });
		achtungHideLoader();
	}
	
	$("#listkeluarpasien .icon-delete").live('click', function(){
		var myid= this.rel;
		$("#dialogkeluarpasien").dialog({
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
		
		$("#dialogkeluarpasien").dialog("open");
	});
	
	$('form').resize(function(a) {
		if($("#listkeluarpasien").getGridParam("records")>0){
		jQuery('#listkeluarpasien').setGridWidth(($(this).width()-28));
		}
	});
	
	function formattermou(cellvalue, options, rowObject) {
		var content = '';
		if(cellvalue){		
			content  += '<a href="tmp/c_master_status_keluar_pasien/' + cellvalue + '" style="color:blue;cursor:pointer" title="">download</a>';
		}else{
			content  += ' - ';
		}
		return content;
	}
	
	$('#masterkeluarpasienadd').click(function(){
		$("#t34","#tabs").empty();
		$("#t34","#tabs").load('c_master_status_keluar_pasien/add'+'?_=' + (new Date()).getTime());
	});
	
	$( "#sampaimasterkeluarpasien" )
		.keypress(function(event) {
			var keycode =(event.keyCode?event.keyCode:event.which);	
			if(keycode ==13){
				event.preventDefault();
				$('#listkeluarpasien').trigger("reloadGrid");
			}
	});
		
		$( "#carimasterkeluarpasien" )
		.keypress(function(event) {
			var keycode =(event.keyCode?event.keyCode:event.which);	
			if(keycode ==13){
				event.preventDefault();
				$('#listkeluarpasien').trigger("reloadGrid");
			}
	});
	
	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	$("#resetmasterkeluarpasien").live('click', function(event){
		event.preventDefault();
		$('#formmasterkeluarpasien').reset();
		$('#listkeluarpasien').trigger("reloadGrid");
	});
	$("#carimasterkeluarpasien").live('click', function(event){
		event.preventDefault();
		$('#listkeluarpasien').trigger("reloadGrid");
	});
})