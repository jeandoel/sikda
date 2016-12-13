jQuery().ready(function (){ 
	jQuery("#listmasterpekerjaan").jqGrid({ 
		url:'c_master_pekerjaan/pekerjaanxml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['KD PEKERJAAN','Kode Pekerjaan','Pekerjaan','Action'],
		rownumbers:true,
		width: 1021,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[  
				{name:'id',index:'id', width:50, hidden:true}, 		
				{name:'kodepekerjaan',index:'kodepekerjaan', width:30}, 
				{name:'pekerjaan',index:'pekerjaan', width:50}, 
				{name:'myid',index:'myid', width:15,align:'center',formatter:formatterAction}
			],
			rowNum:10, 
			rowList:[10,20,30], 
			pager: jQuery('#pagermasterpekerjaan'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				caripekerjaan=$('#namapekerjaan').val()?$('#namapekerjaan').val():'';
				$('#listmasterpekerjaan').setGridParam({postData:{'caripekerjaan':caripekerjaan}})
			}
	}).navGrid('#pagermasterpekerjaan',{edit:false,add:false,del:false,search:false});
	
	function formatterAction(cellvalue, options, rowObject) {
		var content = '';
		content  += '<a rel="' + cellvalue + '" class="icon-detail" title="View"></a> ';
		content  += '<a rel="' + cellvalue + '" class="icon-edit" title="Edit?"></a>';
		content  += '<a rel="' + cellvalue + '" class="icon-delete" title="Remove?"></a>';
		return content;
	}
	
	$("#listmasterpekerjaan .icon-detail").live('click', function(g){
		if($(g.target).data('oneclicked')!='yes')
		{
			var myrel=this.rel==0?'nol':this.rel;
			$("#t54","#tabs").empty();
			$("#t54","#tabs").load('c_master_pekerjaan/detail'+'?id='+ encodeURIComponent(myrel));
		}
		$(g.target).data('oneclicked','yes');
	});
	
	$("#listmasterpekerjaan .icon-edit").live('click', function(g){
		if($(g.target).data('oneclicked')!='yes')
		{
			var myrel=this.rel==0?'nol':this.rel;
			$("#t54","#tabs").empty();
			$("#t54","#tabs").load('c_master_pekerjaan/edit'+'?id='+ encodeURIComponent(myrel));
		}
		$(g.target).data('oneclicked','yes');
	});
	
	function deldata(myid){
		achtungShowLoader();
		$.ajax({
			  url: 'c_master_pekerjaan/delete',
			  type: "post",
			  data: {id:myid},
			  dataType: "json",
			  success: function(msg){
				if(msg == 'OK'){
					$("#dialogpekerjaan").dialog("close");
					$.achtung({message: 'Proses Hapus Data Berhasil', timeout:5});
					$('#listmasterpekerjaan').trigger("reloadGrid");							
				}
				else{						
					$("#dialogpekerjaan").dialog("close");
					$.achtung({message: 'Maaf Proses Hapus Data Gagal', timeout:5});
				}						
			  }
		  });
		achtungHideLoader();
	}
	
	$("#listmasterpekerjaan .icon-delete").live('click', function(){
		var myid=this.rel==0?'nol':this.rel;
		$("#dialogpekerjaan").dialog({
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
		
		$("#dialogpekerjaan").dialog("open");
	});
	
	$('form').resize(function(g) {
		if($("#listmasterpekerjaan").getGridParam("records")>0){
		jQuery('#listmasterpekerjaan').setGridWidth(($(this).width()-28));
		}
	});
	
	function formattermou(cellvalue, options, rowObject) {
		var content = '';
		if(cellvalue){		
			content  += '<a href="tmp/c_master_pekerjaan/' + cellvalue + '" style="color:blue;cursor:pointer" title="">download</a>';
		}else{
			content  += ' - ';
		}
		return content;
	}
	
	$('#masterpekerjaanadd').click(function(){
		$("#t54","#tabs").empty();
		$("#t54","#tabs").load('c_master_pekerjaan/add'+'?_=' + (new Date()).getTime());
	});
	
	$( "#sampaipekerjaan" )
		.keypress(function(event) {
			var keycode =(event.keyCode?event.keyCode:event.which);	
			if(keycode ==13){
				event.preventDefault();
				$('#listmasterpekerjaan').trigger("reloadGrid");
			}			
	});
	
	$( "#namapekerjaan" )
		.keypress(function(event) {
			var keycode =(event.keyCode?event.keyCode:event.which);	
			if(keycode ==13){
				event.preventDefault();
				$('#listmasterpekerjaan').trigger("reloadGrid");
			}			
	});

	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	$("#resetmasterpekerjaan").live('click', function(event){
		event.preventDefault();
		$('#formmasterpekerjaan').reset();
		$('#listmasterpekerjaan').trigger("reloadGrid");
	});
	$("#carimasterpekerjaan").live('click', function(event){
		event.preventDefault();
		$('#listmasterpekerjaan').trigger("reloadGrid");
	});
})