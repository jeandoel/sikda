jQuery().ready(function (){ 
	jQuery("#listmastersaranaposyandu").jqGrid({ 
		url:'c_master_sarana_posyandu/mastersaranaposyanduxml', 
		emptyrecords: 'Tidak ada ada',
		datatype: "xml", 
		colNames:['Kode Sarana','Sarana Poyandu','Action'],
		rownumbers:true,
		width: 1021,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[ 
				{name:'kodesarana',index:'kodesarana', width:30}, 
				{name:'saranaposyandu',index:'saranaposyandu', width:50}, 
				{name:'x',index:'x', width:15,align:'center',formatter:formatterAction}
			],
			rowNum:10, 
			rowList:[10,20,30], 
			pager: jQuery('#pagermastersaranaposyandu'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				nama=$('#namasarana').val()?$('#namasarana').val():'';
				$('#listmastersaranaposyandu').setGridParam({postData:{'nama':nama}})
			}
	}).navGrid('#pagermastersaranaposyandu',{edit:false,add:false,del:false,search:false});
	
	function formatterAction(cellvalue, options, rowObject) {
		var content = '';
		content  += '<a rel="' + cellvalue + '" class="icon-detail" title="View"></a> ';
		content  += '<a rel="' + cellvalue + '" class="icon-edit" title="Edit?"></a>';
		content  += '<a rel="' + cellvalue + '" class="icon-delete" title="Remove?"></a>';
		return content;
	}
	
	$("#listmastersaranaposyandu .icon-detail").live('click', function(p){
		if($(p.target).data('oneclicked')!='yes')
		{
		$("#t15","#tabs").empty();
		$("#t15","#tabs").load('c_master_sarana_posyandu/detail'+'?id='+this.rel);
		}
		$(p.target).data('oneclicked','yes');
	});
	
	$("#listmastersaranaposyandu .icon-edit").live('click', function(p){
		if($(p.target).data('oneclicked')!='yes')
		{
		$("#t15","#tabs").empty();
		$("#t15","#tabs").load('c_master_sarana_posyandu/edit'+'?id	='+this.rel);
		}
		$(p.target).data('oneclicked','yes');
	});
	
	function deldata(myid){
		achtungShowLoader();
		$.ajax({
			  url: 'c_master_sarana_posyandu/delete',
			  type: "post",
			  data: {id:myid},
			  dataType: "json",
			  success: function(msg){
				if(msg == 'OK'){
					$("#dialogsaranaposyandu").dialog("close");
					$.achtung({message: 'Proses Hapus Data Berhasil', timeout:5});
					$('#listmastersaranaposyandu').trigger("reloadGrid");							
				}
				else{						
					$("#dialogsaranaposyandu").dialog("close");
					$.achtung({message: 'Maaf Proses Hapus Data Gagal', timeout:5});
				}						
			  }
		  });
		achtungHideLoader();
	}
	
	$("#listmastersaranaposyandu .icon-delete").live('click', function(){
		var myid= this.rel;
		$("#dialogsaranaposyandu").dialog({
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
		
		$("#dialogsaranaposyandu").dialog("open");
	});
	
	$('form').resize(function(e) {
		if($("#listmastersaranaposyandu").getGridParam("records")>0){
		jQuery('#listmastersaranaposyandu').setGridWidth(($(this).width()-28));
		}
	});
	
	function formattermou(cellvalue, options, rowObject) {
		var content = '';
		if(cellvalue){		
			content  += '<a href="tmp/mastersaranaposyandu/' + cellvalue + '" style="color:blue;cursor:pointer" title="">download</a>';
		}else{
			content  += ' - ';
		}
		return content;
	}
	
	$('#saranaposyanduadd').click(function(){
		$("#t15","#tabs").empty();
		$("#t15","#tabs").load('c_master_sarana_posyandu/add'+'?_=' + (new Date()).getTime());
	});
	
	$( "#namasarana" )
		.keypress(function(event) {
			var keycode =(event.keyCode?event.keyCode:event.which);	
			if(keycode ==13){
				event.preventDefault();
				$('#listmastersaranaposyandu').trigger("reloadGrid");
			}
	});
	
	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	$("#resetmastersaranaposyandu").live('click', function(event){
		event.preventDefault();
		$('#formmastersaranaposyandu').reset();
		$('#listmastersaranaposyandu').trigger("reloadGrid");
	});
	$("#carimastersaranaposyandu").live('click', function(event){
		event.preventDefault();
		$('#listmastersaranaposyandu').trigger("reloadGrid");
	});
})