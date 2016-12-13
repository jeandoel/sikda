jQuery().ready(function (){ 
	jQuery("#listmaster_kategori_imunisasi").jqGrid({ 
		url:'c_master_kategori_imunisasi/kategoriimunisasixml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['KD Kategori Imunisasi','Kode Kategori Imunisasi','Kategori Imunisasi','Action'],
		rownumbers:true,
		width: 1021,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[  
				{name:'id',index:'id', width:50, hidden:true}, 		
				{name:'kodekategoriimunisasi',index:'kodekategoriimunisasi', width:30}, 
				{name:'kategoriimunisasi',index:'kategoriimunisasi', width:50}, 
				{name:'myid',index:'myid', width:15,align:'center',formatter:formatterAction}
			],
			rowNum:10, 
			rowList:[10,20,30], 
			pager: jQuery('#pagermaster_kategori_imunisasi'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				carikategori=$('#kategoriimunisasi').val()?$('#kategoriimunisasi').val():'';
				$('#listmaster_kategori_imunisasi').setGridParam({postData:{'carikategori':carikategori}})
			}
	}).navGrid('#pagermaster_kategori_imunisasi',{edit:false,add:false,del:false,search:false});
	
	function formatterAction(cellvalue, options, rowObject) {
		var content = '';
		content  += '<a rel="' + cellvalue + '" class="icon-detail" title="View"></a> ';
		content  += '<a rel="' + cellvalue + '" class="icon-edit" title="Edit?"></a>';
		content  += '<a rel="' + cellvalue + '" class="icon-delete" title="Remove?"></a>';
		return content;
	}
	
	$("#listmaster_kategori_imunisasi .icon-detail").live('click', function(g){
		if($(g.target).data('oneclicked')!='yes')
		{
			$("#t58","#tabs").empty();
			$("#t58","#tabs").load('c_master_kategori_imunisasi/detail'+'?id='+this.rel);
		}
		$(g.target).data('oneclicked','yes');
	});
	
	$("#listmaster_kategori_imunisasi .icon-edit").live('click', function(g){
		if($(g.target).data('oneclicked')!='yes')
		{
			$("#t58","#tabs").empty();
			$("#t58","#tabs").load('c_master_kategori_imunisasi/edit'+'?id='+this.rel);
		}
		$(g.target).data('oneclicked','yes');
	});
	
	function deldata(myid){
		achtungShowLoader();
		$.ajax({
			  url: 'c_master_kategori_imunisasi/delete',
			  type: "post",
			  data: {id:myid},
			  dataType: "json",
			  success: function(msg){
				if(msg == 'OK'){
					$("#dialogkategoriimunisasi_new").dialog("close");
					$.achtung({message: 'Proses Hapus Data Berhasil', timeout:5});
					$('#listmaster_kategori_imunisasi').trigger("reloadGrid");							
				}
				else{						
					$("#dialogkategoriimunisasi_new").dialog("close");
					$.achtung({message: 'Maaf Proses Hapus Data Gagal', timeout:5});
				}						
			  }
		  });
		achtungHideLoader();
	}
	
	$("#listmaster_kategori_imunisasi .icon-delete").live('click', function(){
		var myid= this.rel;
		$("#dialogkategoriimunisasi_new").dialog({
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
		
		$("#dialogkategoriimunisasi_new").dialog("open");
	});
	
	$('form').resize(function(g) {
		if($("#listmaster_kategori_imunisasi").getGridParam("records")>0){
		jQuery('#listmaster_kategori_imunisasi').setGridWidth(($(this).width()-28));
		}
	});
	
	function formattermou(cellvalue, options, rowObject) {
		var content = '';
		if(cellvalue){		
			content  += '<a href="tmp/c_master_kategori_imunisasi/' + cellvalue + '" style="color:blue;cursor:pointer" title="">download</a>';
		}else{
			content  += ' - ';
		}
		return content;
	}
	
	$('#master_kategori_imunisasi_add').click(function(){
		$("#t58","#tabs").empty();
		$("#t58","#tabs").load('c_master_kategori_imunisasi/add'+'?_=' + (new Date()).getTime());
	});

	$( "#kategoriimunisasi" )
		.keypress(function(event) {
			var keycode =(event.keyCode?event.keyCode:event.which);	
			if(keycode ==13){
				event.preventDefault();
				$('#listmaster_kategori_imunisasi').trigger("reloadGrid");
			}			
	});

	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	$("#resetmaster_kategori_imunisasi").live('click', function(event){
		event.preventDefault();
		$('#formmaster_kategori_imunisasi').reset();
		$('#listmaster_kategori_imunisasi').trigger("reloadGrid");
	});
	$("#carimaster_kategori_imunisasi").live('click', function(event){
		event.preventDefault();
		$('#listmaster_kategori_imunisasi').trigger("reloadGrid");
	});
})
