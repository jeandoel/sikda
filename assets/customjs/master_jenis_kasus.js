jQuery().ready(function (){ 
	jQuery("#listjeniskasus").jqGrid({ 
		url:'c_master_jenis_kasus/jeniskasusxml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['Kode Jenis Kasus','Kode Jenis Kasus','Jenis Kasus','Kode Jenis ','Kode ICD Induk','Action'],
		rownumbers:true,
		width: 1021,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[ 
				{name:'id',index:'id', width:90, hidden:true}, 
				{name:'kodejeniskasus',index:'kodejeniskasus', width:90},
				{name:'jeniskasus',index:'jeniskasus', width:120}, 
				{name:'kodejenis',index:'kodejenis', width:100},
				{name:'kodeicd',index:'kodeicd', width:90},
				{name:'x',index:'x', width:75,align:'center',formatter:formatterAction}
			],
			rowNum:10, 
			rowList:[10,20,30], 
			pager: jQuery('#pagerjeniskasus'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				nama=$('#namajeniskasus').val()?$('#namajeniskasus').val():'';
				$('#listjeniskasus').setGridParam({postData:{'nama':nama}})
			}
	}).navGrid('#pagerjeniskasus',{edit:false,add:false,del:false,search:false});
	
	function formatterAction(cellvalue, options, rowObject) {
		var content = '';
		content  += '<a rel="' + cellvalue + '" class="icon-detail" title="View"></a> ';
		content  += '<a rel="' + cellvalue + '" class="icon-edit" title="Edit?"></a>';
		content  += '<a rel="' + cellvalue + '" class="icon-delete" title="Remove?"></a>';
		return content;
	}
	
	$("#listjeniskasus .icon-detail").live('click', function(a){
		if($(a.target).data('oneclicked')!='yes')
		{
			$("#t52","#tabs").empty();
			$("#t52","#tabs").load('c_master_jenis_kasus/detail'+'?id='+this.rel);
		}
		$(a.target).data('oneclicked','yes');
	});
	
	$("#listjeniskasus .icon-edit").live('click', function(a){
		if($(a.target).data('oneclicked')!='yes')
		{
			$("#t52","#tabs").empty();
			$("#t52","#tabs").load('c_master_jenis_kasus/edit'+'?id='+this.rel);
		}
		$(a.target).data('oneclicked','yes');
	});
	
	function deldata(myid){
		achtungShowLoader();
		$.ajax({
			  url: 'c_master_jenis_kasus/delete',
			  type: "post",
			  data: {id:myid},
			  dataType: "json",
			  success: function(msg){
				if(msg == 'OK'){
					$("#dialogjeniskasus_new").dialog("close");
					$.achtung({message: 'Proses Hapus Data Berhasil', timeout:5});
					$('#listjeniskasus').trigger("reloadGrid");							
				}
				else{						
					$("#dialogjeniskasus_new").dialog("close");
					$.achtung({message: 'Maaf Proses Hapus Data Gagal', timeout:5});
				}						
			  }
		  });
		achtungHideLoader();
	}
	
	$("#listjeniskasus .icon-delete").live('click', function(){
		var myid= this.rel;
		$("#dialogjeniskasus_new").dialog({
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
		
		$("#dialogjeniskasus_new").dialog("open");
	});
	
	$('form').resize(function(e) {
		if($("#listjeniskasus").getGridParam("records")>0){
		jQuery('#listjeniskasus').setGridWidth(($(this).width()-28));
		}
	});
	
	function formattermou(cellvalue, options, rowObject) {
		var content = '';
		if(cellvalue){		
			content  += '<a href="tmp/jeniskasus/' + cellvalue + '" style="color:blue;cursor:pointer" title="">download</a>';
		}else{
			content  += ' - ';
		}
		return content;
	}
	
	$('#masterjeniskasusadd').click(function(){
		$("#t52","#tabs").empty();
		$("#t52","#tabs").load('c_master_jenis_kasus/add'+'?_=' + (new Date()).getTime());
	});
	
	$( "#namajeniskasus" )
		.keypress(function(event) {
			var keycode =(event.keyCode?event.keyCode:event.which);	
			if(keycode ==13){
				event.preventDefault();
				$('#listjeniskasus').trigger("reloadGrid");
			}
	});
	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	$("#resetjeniskasus").live('click', function(event){
		event.preventDefault();
		$('#formjeniskasus').reset();
		$('#listjeniskasus').trigger("reloadGrid");
	});
	$("#carijeniskasus").live('click', function(event){
		event.preventDefault();
		$('#listjeniskasus').trigger("reloadGrid");
	});
})
