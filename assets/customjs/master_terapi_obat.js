jQuery().ready(function (){ 
	jQuery("#listmaster_terapiobat").jqGrid({ 
		url:'c_master_terapi_obat/master_terapiobatxml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['KD TERAPI OBAT','KD TERAPI OBAT','TERAPI OBAT','ACTION'],
		rownumbers:true,
		width: 1021,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[  
				{name:'id',index:'id', width:50, hidden:true}, 		
				{name:'kodeterapiobat',index:'kodeterapiobat', width:50}, 
				{name:'terapiobat',index:'terapiobat', width:50}, 
				{name:'myid',index:'myid', width:50,align:'center',formatter:formatterAction}
			],
			rowNum:10, 
			rowList:[10,20,30], 
			pager: jQuery('#pagermaster_terapiobat'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				kodeterapiobat=$('#kodeterapiobatmaster_terapiobat').val()?$('#kodeterapiobatmaster_terapiobat').val():'';
				$('#listmaster_terapiobat').setGridParam({postData:{'kodeterapiobat':kodeterapiobat}})
			}
	}).navGrid('#pagermaster_terapiobat',{edit:false,add:false,del:false,search:false});
	
	function formatterAction(cellvalue, options, rowObject) {
		var content = '';
		content  += '<a rel="' + cellvalue + '" class="icon-detail" title="View"></a> ';
		content  += '<a rel="' + cellvalue + '" class="icon-edit" title="Edit?"></a>';
		content  += '<a rel="' + cellvalue + '" class="icon-delete" title="Remove?"></a>';
		return content;
	}
	
	$("#listmaster_terapiobat .icon-detail").live('click', function(g){
		if($(g.target).data('oneclicked')!='yes')
		{
			$("#t43","#tabs").empty();
			$("#t43","#tabs").load('c_master_terapi_obat/detail'+'?kodeterapiobat='+this.rel);
		}
		$(g.target).data('oneclicked','yes');
	});
	
	$("#listmaster_terapiobat .icon-edit").live('click', function(g){
		if($(g.target).data('oneclicked')!='yes')
		{
			$("#t43","#tabs").empty();
			$("#t43","#tabs").load('c_master_terapi_obat/edit'+'?kodeterapiobat='+this.rel);
		}
		$(g.target).data('oneclicked','yes');
	});
	
	function deldata(myid){
		achtungShowLoader();
		$.ajax({
			  url: 'c_master_terapi_obat/delete',
			  type: "post",
			  data: {kodeterapiobat:myid},
			  dataType: "json",
			  success: function(msg){
				if(msg == 'OK'){
					$("#dialogterapiobat_new").dialog("close");
					$.achtung({message: 'Proses Hapus Data Berhasil', timeout:5});
					$('#listmaster_terapiobat').trigger("reloadGrid");							
				}
				else{						
					$("#dialogterapiobat_new").dialog("close");
					$.achtung({message: 'Maaf Proses Hapus Data Gagal', timeout:5});
				}						
			  }
		  });
		achtungHideLoader();
	}
	
	$("#listmaster_terapiobat .icon-delete").live('click', function(){
		var myid= this.rel;
		$("#dialogterapiobat_new").dialog({
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
		
		$("#dialogterapiobat_new").dialog("open");
	});
	
	$('form').resize(function(g) {
		if($("#listmaster_terapiobat").getGridParam("records")>0){
		jQuery('#listmaster_terapiobat').setGridWidth(($(this).width()-28));
		}
	});
	
	function formattermou(cellvalue, options, rowObject) {
		var content = '';
		if(cellvalue){		
			content  += '<a href="tmp/c_master_terapi_obat/' + cellvalue + '" style="color:blue;cursor:pointer" title="">download</a>';
		}else{
			content  += ' - ';
		}
		return content;
	}
	
	$('#master_terapiobat_add').click(function(){
		$("#t43","#tabs").empty();
		$("#t43","#tabs").load('c_master_terapi_obat/add'+'?_=' + (new Date()).getTime());
	});
	
	$( "#sampaimaster_terapiobat" )
		.keypress(function(event) {
			var keycode =(event.keyCode?event.keyCode:event.which);	
			if(keycode ==13){
				event.preventDefault();
				$('#listmaster_terapiobat').trigger("reloadGrid");
			}			
	});
	
	$( "#kodeterapiobatmaster_terapiobat" )
		.keypress(function(event) {
			var keycode =(event.keyCode?event.keyCode:event.which);	
			if(keycode ==13){
				event.preventDefault();
				$('#listmaster_terapiobat').trigger("reloadGrid");
			}			
	});

	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	$("#resetmaster_terapiobat").live('click', function(event){
		event.preventDefault();
		$('#formmaster_terapiobat').reset();
		$('#listmaster_terapiobat').trigger("reloadGrid");
	});
	$("#carimaster_terapiobat").live('click', function(event){
		event.preventDefault();
		$('#listmaster_terapiobat').trigger("reloadGrid");
	});
})
