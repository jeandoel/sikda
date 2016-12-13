jQuery().ready(function (){ 
	jQuery("#listmaster_icd_induk").jqGrid({ 
		url:'c_master_icd_induk/icdindukxml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['KD ICD INDUK','Kode ICD Induk','ICD Induk','Action'],
		rownumbers:true,
		width: 1021,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[  
				{name:'id',index:'id', width:50, hidden:true}, 		
				{name:'kodeicdinduk',index:'kodeicdinduk', width:30}, 
				{name:'icdinduk',index:'icdinduk', width:50}, 
				{name:'myid',index:'myid', width:15,align:'center',formatter:formatterAction}
			],
			rowNum:10, 
			rowList:[10,20,30], 
			pager: jQuery('#pagermaster_icd_induk'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				keyword=$('#namakeyword').val()?$('#namakeyword').val():'';
				cari=$('#carikategori').val()?$('#carikategori').val():'';
				$('#listmaster_icd_induk').setGridParam({postData:{'keyword':keyword,'cari':cari}})
			}
	}).navGrid('#pagermaster_icd_induk',{edit:false,add:false,del:false,search:false});
	
	function formatterAction(cellvalue, options, rowObject) {
		var content = '';
		content  += '<a rel="' + cellvalue + '" class="icon-detail" title="View"></a> ';
		content  += '<a rel="' + cellvalue + '" class="icon-edit" title="Edit?"></a>';
		content  += '<a rel="' + cellvalue + '" class="icon-delete" title="Remove?"></a>';
		return content;
	}
	
	$("#listmaster_icd_induk .icon-detail").live('click', function(g){
		if($(g.target).data('oneclicked')!='yes')
		{
			$("#t57","#tabs").empty();
			$("#t57","#tabs").load('c_master_icd_induk/detail'+'?id='+encodeURIComponent(this.rel));
		}
		$(g.target).data('oneclicked','yes');
	});
	
	$("#listmaster_icd_induk .icon-edit").live('click', function(g){
		if($(g.target).data('oneclicked')!='yes')
		{
			$("#t57","#tabs").empty();
			$("#t57","#tabs").load('c_master_icd_induk/edit'+'?id='+encodeURIComponent(this.rel));
		}
		$(g.target).data('oneclicked','yes');
	});
	
	function deldata(myid){
		achtungShowLoader();
		$.ajax({
			  url: 'c_master_icd_induk/delete',
			  type: "post",
			  data: {id:myid},
			  dataType: "json",
			  success: function(msg){
				if(msg == 'OK'){
					$("#dialogicdinduk_new").dialog("close");
					$.achtung({message: 'Proses Hapus Data Berhasil', timeout:5});
					$('#listmaster_icd_induk').trigger("reloadGrid");							
				}
				else{						
					$("#dialogicdinduk_new").dialog("close");
					$.achtung({message: 'Maaf Proses Hapus Data Gagal', timeout:5});
				}						
			  }
		  });
		achtungHideLoader();
	}
	
	$("#listmaster_icd_induk .icon-delete").live('click', function(){
		var myid= this.rel;
		$("#dialogicdinduk_new").dialog({
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
		
		$("#dialogicdinduk_new").dialog("open");
	});
	
	$('form').resize(function(g) {
		if($("#listmaster_icd_induk").getGridParam("records")>0){
		jQuery('#listmaster_icd_induk').setGridWidth(($(this).width()-28));
		}
	});
	
	function formattermou(cellvalue, options, rowObject) {
		var content = '';
		if(cellvalue){		
			content  += '<a href="tmp/c_master_icd_induk/' + cellvalue + '" style="color:blue;cursor:pointer" title="">download</a>';
		}else{
			content  += ' - ';
		}
		return content;
	}
	
	$('#master_icd_induk_add').click(function(){
		$("#t57","#tabs").empty();
		$("#t57","#tabs").load('c_master_icd_induk/add'+'?_=' + (new Date()).getTime());
	});
	
	$( "#cariindukicd" )
		.keypress(function(event) {
			var keycode =(event.keyCode?event.keyCode:event.which);	
			if(keycode ==13){
				event.preventDefault();
				$('#listmaster_icd_induk').trigger("reloadGrid");
			}			
	});

	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	$("#resetmaster_icd_induk").live('click', function(event){
		event.preventDefault();
		$('#formmaster_icd_induk').reset();
		$('#listmaster_icd_induk').trigger("reloadGrid");
	});
	$("#carimaster_icd_induk").live('click', function(event){
		event.preventDefault();
		$('#listmaster_icd_induk').trigger("reloadGrid");
	});
})
