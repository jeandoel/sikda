jQuery().ready(function (){ 
	jQuery("#listmasterjk").jqGrid({ 
		url:'c_master_jenis_kelamin/jeniskelaminxml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['Kode Jenis Kelamin','Jenis Kelamin','Action'],
		rownumbers:true,
		width: 1040,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[ 
				{name:'kd',index:'kd', width:99}, 
				{name:'jenis_kelmain',index:'jenis_kelmain', width:99},
				{name:'x',index:'x', width:110,align:'center',formatter:formatterAction}
			],
			rowNum:10, 
			rowList:[10,20,30], 
			pager: jQuery('#pagermasterjk'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				keyword=$('#keywordid').val()?$('#keywordid').val():'';
				cari=$('#carijk').val()?$('#carijk').val():'';
				$('#listmasterjk').setGridParam({postData:{'keyword':'KD_JENIS_KELAMIN','cari':cari}})
			}
	}).navGrid('#pagermasterjk',{edit:false,add:false,del:false,search:false});
	
	function formatterAction(cellvalue, options, rowObject) {
		var content = '';
		content  += '<a rel="' + cellvalue + '" class="icon-detail"  title="View"></a> ';
		content  += '<a rel="' + cellvalue + '" class="icon-edit" title="Edit?"></a>';
		content  += '<a rel="' + cellvalue + '" class="icon-delete" title="Remove?"></a>';
		return content;
	}
	
	$("#listmasterjk .icon-detail").live('click', function(a){
		if($(a.target).data('oneclicked')!='yes')
                {    
		$("#t31","#tabs").empty();
		$("#t31","#tabs").load('c_master_jenis_kelamin/detail'+'?kd='+this.rel);
                }
                $(a.target).data('oneclicked','yes');
	});
	
	$("#listmasterjk .icon-edit").live('click', function(a){
		if($(a.target).data('oneclicked')!='yes')
                {    
		$("#t31","#tabs").empty();
		$("#t31","#tabs").load('c_master_jenis_kelamin/edit'+'?kd='+this.rel);
                }
                $(a.target).data('oneclicked','yes');
                
	});
	
	function deldata(myid){
		achtungShowLoader();
		$.ajax({
			  url: 'c_master_jenis_kelamin/delete',
			  type: "post",
			  data: {kd:myid},
			  dataType: "json",
			  success: function(msg){
				if(msg == 'OK'){
					$("#dialog").dialog("close");
					$.achtung({message: 'Proses Hapus Data Berhasil', timeout:5});
					$('#listmasterjk').trigger("reloadGrid");							
				}
				else{						
					$("#dialog").dialog("close");
					$.achtung({message: 'Maaf Proses Hapus Data Gagal', timeout:5});
				}						
			  }
		  });
		achtungHideLoader();
	}
	
	$("#listmasterjk .icon-delete").live('click', function(){
		var myid= this.rel;
		$("#dialog").dialog({
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
		
		$("#dialog").dialog("open");
	});
	
	$('form').resize(function(a) {
		if($("#listmasterjk").getGridParam("records")>0){
		jQuery('#listmasterjk').setGridWidth(($(this).width()-28));
		}
	});
	
	function formattermou(cellvalue, options, rowObject) {
		var content = '';
		if(cellvalue){		
			content  += '<a href="tmp/c_master_jenis_kelamin/' + cellvalue + '" style="color:blue;cursor:pointer" title="">download</a>';
		}else{
			content  += ' - ';
		}
		return content;
	}
	
	$('#masterjkadd').click(function(){
		$("#t31","#tabs").empty();
		$("#t31","#tabs").load('c_master_jenis_kelamin/add'+'?_=' + (new Date()).getTime());
	});
	
	$( "#sampaimasterjk" )
		.keypress(function(event) {
			var keycode =(event.keyCode?event.keyCode:event.which);	
			if(keycode ==13){
				event.preventDefault();
				$('#listmasterjk').trigger("reloadGrid");
			}
	});
		
		$( "#carimasterjk" )
		.keypress(function(event) {
			var keycode =(event.keyCode?event.keyCode:event.which);	
			if(keycode ==13){
				event.preventDefault();
				$('#listmasterjk').trigger("reloadGrid");
			}
	});
	
	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	$("#resetmasterjk").live('click', function(event){
		event.preventDefault();
		$('#formmasterjk').reset();
		$('#listmasterjk').trigger("reloadGrid");
	});
	$("#carimasterjk").live('click', function(event){
		event.preventDefault();
		$('#listmasterjk').trigger("reloadGrid");
	});
})