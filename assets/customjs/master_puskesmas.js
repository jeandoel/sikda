jQuery().ready(function (){ 
	jQuery("#listpuskesmas").jqGrid({ 
		url:'c_master_puskesmas/puskesmasxml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['Kode Puskesmas','Kode Puskesmas','Kode Kecamatan','Puskesmas','Alamat','Action'],
		rownumbers:true,
		width: 1021,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[ 
				{name:'id',index:'id', width:90,hidden:true}, 
				{name:'kodepuskesmas',index:'kodepuskesmas', width:80}, 
				{name:'kodekecamatan',index:'kodekecamatan', width:80}, 
				{name:'namapuskesmas',index:'namapuskesmas', width:90},
				{name:'alamat',index:'alamat', width:120},
				{name:'x',index:'x', width:70,align:'center',formatter:formatterAction}
			],
			rowNum:10, 
			rowList:[10,20,30], 
			pager: jQuery('#pagerpuskesmas'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				id_kd_puskesmas=$('#idkodepuskesmas').val()?$('#idkodepuskesmas').val():'';
				nama=$('#namapuskesmas').val()?$('#namapuskesmas').val():'';
				$('#listpuskesmas').setGridParam({postData:{'kodepuskesmas':id_kd_puskesmas,'nama':nama}})
			}
	}).navGrid('#pagerpuskesmas',{edit:false,add:false,del:false,search:false});
	
	function formatterAction(cellvalue, options, rowObject) {
		var content = '';
		content  += '<a rel="' + cellvalue + '" class="icon-detail" title="View"></a> ';
		content  += '<a rel="' + cellvalue + '" class="icon-edit" title="Edit?"></a>';
		content  += '<a rel="' + cellvalue + '" class="icon-delete" title="Remove?"></a>';
		return content;
	}
	
	$("#listpuskesmas .icon-detail").live('click', function(a){
		if($(a.target).data('oneclicked')!='yes')
		{
			$("#t51","#tabs").empty();
			$("#t51","#tabs").load('c_master_puskesmas/detail'+'?kd_puskesmas='+this.rel);
		}
		$(a.target).data('oneclicked','yes');
	});
	
	$("#listpuskesmas .icon-edit").live('click', function(a){
		if($(a.target).data('oneclicked')!='yes')
		{
			$("#t51","#tabs").empty();
			$("#t51","#tabs").load('c_master_puskesmas/edit'+'?kd_puskesmas='+this.rel);
		}
		$(a.target).data('oneclicked','yes');
	});
	
	function deldata(myid){
		achtungShowLoader();
		$.ajax({
			  url: 'c_master_puskesmas/delete',
			  type: "post",
			  data: {kd_puskesmas:myid},
			  dataType: "json",
			  success: function(msg){
				if(msg == 'OK'){
					$("#dialogpuskesmas").dialog("close");
					$.achtung({message: 'Proses Hapus Data Berhasil', timeout:5});
					$('#listpuskesmas').trigger("reloadGrid");							
				}
				else{						
					$("#dialogpuskesmas").dialog("close");
					$.achtung({message: 'Maaf Proses Hapus Data Gagal', timeout:5});
				}						
			  }
		  });
		achtungHideLoader();
	}
	
	$("#listpuskesmas .icon-delete").live('click', function(){
		var myid= this.rel;
		$("#dialogpuskesmas").dialog({
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
		
		$("#dialogpuskesmas").dialog("open");
	});
	
	$('form').resize(function(e) {
		if($("#listpuskesmas").getGridParam("records")>0){
		jQuery('#listpuskesmas').setGridWidth(($(this).width()-28));
		}
	});
	
	function formattermou(cellvalue, options, rowObject) {
		var content = '';
		if(cellvalue){		
			content  += '<a href="tmp/puskesmas/' + cellvalue + '" style="color:blue;cursor:pointer" title="">download</a>';
		}else{
			content  += ' - ';
		}
		return content;
	}
	
	$('#masterpuskesmasadd').click(function(){
		$("#t51","#tabs").empty();
		$("#t51","#tabs").load('c_master_puskesmas/add'+'?_=' + (new Date()).getTime());
	});
	
	$( "#namapuskesmas" )
		.keypress(function(event) {
			var keycode =(event.keyCode?event.keyCode:event.which);	
			if(keycode ==13){
				event.preventDefault();
				$('#listpuskesmas').trigger("reloadGrid");
			}
	});
	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	$("#resetpuskesmas").live('click', function(event){
		event.preventDefault();
		$('#formpuskesmas').reset();
		$('#listpuskesmas').trigger("reloadGrid");
	});
	$("#caripuskesmas").live('click', function(event){
		event.preventDefault();
		$('#listpuskesmas').trigger("reloadGrid");
	});
})