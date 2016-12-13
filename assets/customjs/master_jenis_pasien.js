jQuery().ready(function (){ 
	jQuery("#listmaster_jenis_pasien").jqGrid({ 
		url:'c_master_jenis_pasien/jenispasienxml', 
		emptyrecords: 'Tidak ada data',
		datatype: "xml", 
		colNames:['KD Jenis Pasien','Kode Jenis Pasien','Jenis Pasien','Action'],
		rownumbers:true,
		width: 1021,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[  
				{name:'id',index:'id', width:50, hidden:true}, 		
				{name:'kodejenispasien',index:'kodejenispasien', width:30}, 
				{name:'jenispasien',index:'jenispasien', width:50}, 
				{name:'myid',index:'myid', width:15,align:'center',formatter:formatterAction}
			],
			rowNum:10, 
			rowList:[10,20,30], 
			pager: jQuery('#pagermaster_jenis_pasien'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				carijenispasien=$('#caripasien').val()?$('#caripasien').val():'';
				$('#listmaster_jenis_pasien').setGridParam({postData:{'carijenispasien':carijenispasien}})
			}
	}).navGrid('#pagermaster_jenis_pasien',{edit:false,add:false,del:false,search:false});
	
	function formatterAction(cellvalue, options, rowObject) {
		var content = '';
		content  += '<a rel="' + cellvalue + '" class="icon-detail" title="View"></a> ';
		content  += '<a rel="' + cellvalue + '" class="icon-edit" title="Edit?"></a>';
		content  += '<a rel="' + cellvalue + '" class="icon-delete" title="Remove?"></a>';
		return content;
	}
	
	$("#listmaster_jenis_pasien .icon-detail").live('click', function(g){
		if($(g.target).data('oneclicked')!='yes')
		{
			$("#t59","#tabs").empty();
			$("#t59","#tabs").load('c_master_jenis_pasien/detail'+'?id='+this.rel);
		}
		$(g.target).data('oneclicked','yes');
	});
	
	$("#listmaster_jenis_pasien .icon-edit").live('click', function(g){
		if($(g.target).data('oneclicked')!='yes')
		{
			$("#t59","#tabs").empty();
			$("#t59","#tabs").load('c_master_jenis_pasien/edit'+'?id='+this.rel);
		}
		$(g.target).data('oneclicked','yes');
	});
	
	function deldata(myid){
		achtungShowLoader();
		$.ajax({
			  url: 'c_master_jenis_pasien/delete',
			  type: "post",
			  data: {id:myid},
			  dataType: "json",
			  success: function(msg){
				if(msg == 'OK'){
					$("#dialogjenispasien_new").dialog("close");
					$.achtung({message: 'Proses Hapus Data Berhasil', timeout:5});
					$('#listmaster_jenis_pasien').trigger("reloadGrid");							
				}
				else{						
					$("#dialogjenispasien_new").dialog("close");
					$.achtung({message: 'Maaf Proses Hapus Data Gagal', timeout:5});
				}						
			  }
		  });
		achtungHideLoader();
	}
	
	$("#listmaster_jenis_pasien .icon-delete").live('click', function(){
		var myid= this.rel;
		$("#dialogjenispasien_new").dialog({
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
		
		$("#dialogjenispasien_new").dialog("open");
	});
	
	$('form').resize(function(g) {
		if($("#listmaster_jenis_pasien").getGridParam("records")>0){
		jQuery('#listmaster_jenis_pasien').setGridWidth(($(this).width()-28));
		}
	});
	
	function formattermou(cellvalue, options, rowObject) {
		var content = '';
		if(cellvalue){		
			content  += '<a href="tmp/c_master_jenis_pasien/' + cellvalue + '" style="color:blue;cursor:pointer" title="">download</a>';
		}else{
			content  += ' - ';
		}
		return content;
	}
	
	$('#master_jenis_pasien_add').click(function(){
		$("#t59","#tabs").empty();
		$("#t59","#tabs").load('c_master_jenis_pasien/add'+'?_=' + (new Date()).getTime());
	});

	$("#caripasien")
		.keypress(function(event) {
			var keycode =(event.keyCode?event.keyCode:event.which);	
			if(keycode ==13){
				event.preventDefault();
				$('#listmaster_jenis_pasien').trigger("reloadGrid");
			}			
	});

	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	$("#resetmaster_jenis_pasien").live('click', function(event){
		event.preventDefault();
		$('#formmaster_jenis_pasien').reset();
		$('#listmaster_jenis_pasien').trigger("reloadGrid");
	});
	$("#carimaster_jenis_pasien").live('click', function(event){
		event.preventDefault();
		$('#listmaster_jenis_pasien').trigger("reloadGrid");
	});
})
