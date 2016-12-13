jQuery().ready(function (){ 
	jQuery("#listmastergigi").jqGrid({ 
		url:'c_master_gigi/masterXml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['ID','Kode Gigi','Nama Gigi','Action'],
		rownumbers:true,
		width: 1021,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[ 
				{name:'id',index:'id', width:7,hidden:true}, 
				{name:'kd_gigi',index:'kd_gigi', width:30, align:'center'}, 
				{name:'nama_gigi',index:'nama_gigi', width:50}, 
				{name:'x',index:'x', width:10,align:'center',formatter:formatterAction}
			],
			rowNum:10, 
			rowList:[10,20,30], 
			pager: jQuery('#pagermastergigi'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				kode=$('#kodemastergigi').val()?$('#kodemastergigi').val():'';
				$('#listmastergigi').setGridParam({postData:{'kode':kode}})
			}
	}).navGrid('#pagermastergigi',{edit:false,add:false,del:false,search:false});
	
	function formatterAction(cellvalue, options, rowObject) {
		var content = '';
		content  += '<a rel="' + cellvalue + '" class="icon-detail" title="View"></a> ';
		content  += '<a rel="' + cellvalue + '" class="icon-edit" title="Edit?"></a>';
		content  += '<a rel="' + cellvalue + '" class="icon-delete" title="Remove?"></a>';
		return content;
	}
	
	$("#listmastergigi .icon-detail").live('click', function(p){
		if($(p.target).data('oneclicked')!='yes')
		{
		$("#t1001","#tabs").empty();				
		$("#t1001","#tabs").load('c_master_gigi/detail'+'?id='+this.rel);
		}
		$(p.target).data('oneclicked','yes');
	});
	
	$("#listmastergigi .icon-edit").live('click', function(p){

		if($(p.target).data('oneclicked')!='yes')
		{
		$("#t1001","#tabs").empty();
		$("#t1001","#tabs").load('c_master_gigi/edit'+'?id='+this.rel);
		}
		$(p.target).data('oneclicked','yes');
	});
	
	function deldata(myid){
		achtungShowLoader();
		$.ajax({
			  url: 'c_master_gigi/delete',
			  type: "post",
			  data: {id:myid},
			  dataType: "json",
			  success: function(msg){
				if(msg == 'OK'){
					$("#dialogmastergigi").dialog("close");
					$.achtung({message: 'Proses Hapus Data Berhasil', timeout:5});
					$('#listmastergigi').trigger("reloadGrid");							
				}
				else{						
					$("#dialogmastergigi").dialog("close");
					$.achtung({message: 'Maaf Proses Hapus Data Gagal', timeout:5});
				}						
			  }
		  });
		achtungHideLoader();
	}
	
	$("#listmastergigi .icon-delete").live('click', function(){
		var myid= this.rel;
		$("#dialogmastergigi").dialog({
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
		
		$("#dialogmastergigi").dialog("open");
	});
	
	$('form').resize(function(e) {
		if($("#listmastergigi").getGridParam("records")>0){
		jQuery('#listmastergigi').setGridWidth(($(this).width()-28));
		}
	});
	
	function formattermou(cellvalue, options, rowObject) {
		var content = '';
		if(cellvalue){		
			content  += '<a href="tmp/mastergigi/' + cellvalue + '" style="color:blue;cursor:pointer" title="">download</a>';
		}else{
			content  += ' - ';
		}
		return content;
	}
	
	$('#mastergigiadd').click(function(){
		$("#t1001","#tabs").empty();
		$("#t1001","#tabs").load('c_master_gigi/add'+'?_=' + (new Date()).getTime());
	});
	
	$( "#kodemastergigi" )
		.keypress(function(event) {
			var keycode =(event.keyCode?event.keyCode:event.which);	
			if(keycode ==13){
				event.preventDefault();
				$('#listmastergigi').trigger("reloadGrid");
			}
	});
	
	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	$("#resetmastergigi").live('click', function(event){
		event.preventDefault();
		$('#formmastergigi').reset();
		$('#listmastergigi').trigger("reloadGrid");
	});
	$("#carimastergigi").live('click', function(event){
		event.preventDefault();
		$('#listmastergigi').trigger("reloadGrid");
	});
})
