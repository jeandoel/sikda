jQuery().ready(function (){ 
	jQuery("#listmaster_kecamatan").jqGrid({ 
		url:'c_master_kecamatan/master_kecamatanxml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['KD KECAMATAN','KD KECAMATAN','KD KABUPATEN','KECAMATAN','ACTION'],
		rownumbers:true,
		width: 1021,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[ 
				{name:'id',index:'id', width:50, hidden:true}, 
				{name:'kodekecamatan',index:'kodekecamatan', width:50}, 
				{name:'kodekabupaten',index:'kodekabupaten', width:50}, 
				{name:'kecamatan',index:'kecamatan', width:100,align:'center'},
				{name:'myid',index:'myid', width:50,align:'center',formatter:formatterAction}
			],
			rowNum:10, 
			rowList:[10,20,30], 
			pager: jQuery('#pagermaster_kecamatan'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				kodekecamatan=$('#kodekecamatanmaster_kecamatan').val()?$('#kodekecamatanmaster_kecamatan').val():'';
				$('#listmaster_kecamatan').setGridParam({postData:{'kodekecamatan':kodekecamatan}})
			}
	}).navGrid('#pagermaster_kecamatan',{edit:false,add:false,del:false,search:false});
	
	function formatterAction(cellvalue, options, rowObject) {
		var content = '';
		content  += '<a rel="' + cellvalue + '" class="icon-detail" title="View"></a> ';
		content  += '<a rel="' + cellvalue + '" class="icon-edit" title="Edit?"></a>';
		content  += '<a rel="' + cellvalue + '" class="icon-delete" title="Remove?"></a>';
		return content;
	}
	
	$("#listmaster_kecamatan .icon-detail").live('click', function(g){
		if($(g.target).data('oneclicked')!='yes')
		{
			$("#t40","#tabs").empty();
			$("#t40","#tabs").load('c_master_kecamatan/detail'+'?kodekecamatan='+this.rel);
		}
		$(g.target).data('oneclicked','yes');
	});
	
	$("#listmaster_kecamatan .icon-edit").live('click', function(g){
		if($(g.target).data('oneclicked')!='yes')
		{
			$("#t40","#tabs").empty();
			$("#t40","#tabs").load('c_master_kecamatan/edit'+'?kodekecamatan='+this.rel);
		}
		$(g.target).data('oneclicked','yes');
	});
	
	function deldata(myid){
		achtungShowLoader();
		$.ajax({
			  url: 'c_master_kecamatan/delete',
			  type: "post",
			  data: {kodekecamatan:myid},
			  dataType: "json",
			  success: function(msg){
				if(msg == 'OK'){
					$("#dialogkecamatan").dialog("close");
					$.achtung({message: 'Proses Hapus Data Berhasil', timeout:5});
					$('#listmaster_kecamatan').trigger("reloadGrid");							
				}
				else{						
					$("#dialogkecamatan").dialog("close");
					$.achtung({message: 'Maaf Proses Hapus Data Gagal', timeout:5});
				}						
			  }
		  });
		achtungHideLoader();
	}
	
	$("#listmaster_kecamatan .icon-delete").live('click', function(){
		var myid= this.rel;
		$("#dialogkecamatan").dialog({
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
		
		$("#dialogkecamatan").dialog("open");
	});
	
	$('form').resize(function(g) {
		if($("#listmaster_kecamatan").getGridParam("records")>0){
		jQuery('#listmaster_kecamatan').setGridWidth(($(this).width()-28));
		}
	});
	
	function formattermou(cellvalue, options, rowObject) {
		var content = '';
		if(cellvalue){		
			content  += '<a href="tmp/c_master_kecamatan/' + cellvalue + '" style="color:blue;cursor:pointer" title="">download</a>';
		}else{
			content  += ' - ';
		}
		return content;
	}
	
	$('#master_kecamatan_add').click(function(){
		$("#t40","#tabs").empty();
		$("#t40","#tabs").load('c_master_kecamatan/add'+'?_=' + (new Date()).getTime());
	});
	
	$( "#sampaimaster_kecamatan" )
		.keypress(function(event) {
			var keycode =(event.keyCode?event.keyCode:event.which);	
			if(keycode ==13){
				event.preventDefault();
				$('#listmaster_kecamatan').trigger("reloadGrid");
			}			
	});
	
	$( "#kodekecamatanmaster_kecamatan" )
		.keypress(function(event) {
			var keycode =(event.keyCode?event.keyCode:event.which);	
			if(keycode ==13){
				event.preventDefault();
				$('#listmaster_kecamatan').trigger("reloadGrid");
			}			
	});

	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	$("#resetmaster_kecamatan").live('click', function(event){
		event.preventDefault();
		$('#formmaster_kecamatan').reset();
		$('#listmaster_kecamatan').trigger("reloadGrid");
	});
	$("#carimaster_kecamatan").live('click', function(event){
		event.preventDefault();
		$('#listmaster_kecamatan').trigger("reloadGrid");
	});
})