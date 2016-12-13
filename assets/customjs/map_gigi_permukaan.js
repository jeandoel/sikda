jQuery().ready(function (){ 
	jQuery("#list_map_gigi").jqGrid({ 
		url:'c_map_gigi_permukaan/masterXml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['ID', 'Kode Permukaan Gigi', 'Kode Status Gigi', 'Status', 'Gambar', 'Action'],
		rownumbers:true,
		width: 1021,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[ 
				{name:'id',index:'id', width:10, align:"center", hidden:true}, 
				{name:'kode',index:'kode', width:10, align:"center"},
				{name:'kd_status_gigi',index:'kd_status_gigi', width:10, align:"center"},
				{name:'status',index:'status', width:10}, 
				{name:'gambar',index:'gambar', width:5, formatter:formatterImageGigi, align:"center"}, 
				{name:'x',index:'x', width:10,align:'center',formatter:formatterAction}
			],
			rowNum:10, 
			rowList:[10,20,30], 
			pager: jQuery('#pager_map_gigi'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				kd_status_gigi = $("#c_map_kd_status").val()?$("#c_map_kd_status").val():'';
				status_gigi = $("#c_map_status").val()?$("#c_map_status").val():'';
				modvl = $("#c_map_modvl").val()?$("#c_map_modvl").val():'';
				$('#list_map_gigi').setGridParam({postData:{'kd_status_gigi':kd_status_gigi, 'status':status_gigi, 'kode':modvl}})
			}
	}).navGrid('#pager_map_gigi',{edit:false,add:false,del:false,search:false});
	
	function formatterAction(cellvalue, options, rowObject) {
		var content = '';
		content  += '<a rel="' + cellvalue + '" class="icon-detail" title="View"></a> ';
		content  += '<a rel="' + cellvalue + '" class="icon-edit" title="Edit?"></a>';
		content  += '<a rel="' + cellvalue + '" class="icon-delete" title="Remove?"></a>';
		return content;
	}
	function formatterImageGigi(cellValue, options, rowObject){
		var content = '';
		content += '<img src="./assets/images/map_gigi_permukaan/'+cellValue+'" width="35" height="60"/>';
		return content;
	}
	
	$("#list_map_gigi .icon-detail").live('click', function(p){
		if($(p.target).data('oneclicked')!='yes')
		{
		$("#t1005","#tabs").empty();
		$("#t1005","#tabs").load('c_map_gigi_permukaan/detail'+'?id='+this.rel);
		}	

		$(p.target).data('oneclicked','yes');
	});
	
	$("#list_map_gigi .icon-edit").live('click', function(p){

		if($(p.target).data('oneclicked')!='yes')
		{
		$("#t1005","#tabs").empty();
		$("#t1005","#tabs").load('c_map_gigi_permukaan/edit'+'?id='+this.rel);
		}
		$(p.target).data('oneclicked','yes');
	});
	
	function deldata(myid){
		achtungShowLoader();
		$.ajax({
			  url: 'c_map_gigi_permukaan/delete',
			  type: "post",
			  data: {id:myid},
			  dataType: "json",
			  success: function(msg){
				if(msg == 'OK'){
					$("#dialog_map_gigi").dialog("close");
					$.achtung({message: 'Proses Hapus Data Berhasil', timeout:5});
					$('#list_map_gigi').trigger("reloadGrid");							
				}
				else{						
					$("#dialog_map_gigi").dialog("close");
					$.achtung({message: 'Maaf Proses Hapus Data Gagal', timeout:5});
				}						
			  }
		  });
		achtungHideLoader();
	}
	
	$("#list_map_gigi .icon-delete").live('click', function(){
		var myid= this.rel;
		$("#dialog_map_gigi").dialog({
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
		
		$("#dialog_map_gigi").dialog("open");
	});
	
	$('form').resize(function(e) {
		if($("#list_map_gigi").getGridParam("records")>0){
		jQuery('#list_map_gigi').setGridWidth(($(this).width()-28));
		}
	});
	
	function formattermou(cellvalue, options, rowObject) {
		var content = '';
		if(cellvalue){		
			content  += '<a href="tmp/_map_gigi/' + cellvalue + '" style="color:blue;cursor:pointer" title="">download</a>';
		}else{
			content  += ' - ';
		}
		return content;
	}
	
	$('#_map_gigiadd').click(function(){
		$("#t1005","#tabs").empty();
		$("#t1005","#tabs").load('c_map_gigi_permukaan/add'+'?_=' + (new Date()).getTime());
	});
	
	$( "#kode_map_gigi" )
		.keypress(function(event) {
			var keycode =(event.keyCode?event.keyCode:event.which);	
			if(keycode ==13){
				event.preventDefault();
				$('#list_map_gigi').trigger("reloadGrid");
			}
	});
	
	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	$("#reset_map_gigi").live('click', function(event){
		event.preventDefault();
		$('#form_map_gigi').reset();
		$('#list_map_gigi').trigger("reloadGrid");
	});
	$("#cari_map_gigi").live('click', function(event){
		event.preventDefault();
		$('#list_map_gigi').trigger("reloadGrid");
	});
})
