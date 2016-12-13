jQuery().ready(function (){ 
	jQuery("#listcarabayar").jqGrid({ 
		url:'c_master_cara_bayar/carabayarxml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['Kode Bayar','Cara Bayar','Kode Customer','Customer','Action'],
		rownumbers:true,
		width: 1021,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[ 
				{name:'kodebayar',index:'kodebayar', width:30}, 
				{name:'carabayar',index:'carabayar', width:45}, 
				{name:'kodecustomer',index:'kodecustomer', width:30},
				{name:'customer',index:'customer', width:45},
				{name:'x',index:'x', width:30,align:'center',formatter:formatterAction}
			],
			rowNum:10, 
			rowList:[10,20,30], 
			pager: jQuery('#pagercarabayar'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				keyword=$('#namakeyword').val()?$('#namakeyword').val():'';
				cari=$('#carikategori').val()?$('#carikategori').val():'';
				$('#listcarabayar').setGridParam({postData:{'keyword':keyword,'cari':cari}})
			}
	}).navGrid('#pagercarabayar',{edit:false,add:false,del:false,search:false});
	
	function formatterAction(cellvalue, options, rowObject) {
		var content = '';
		content  += '<a rel="' + encodeURIComponent(cellvalue) + '" class="icon-detail" title="View"></a> ';
		content  += '<a rel="' + encodeURIComponent(cellvalue) + '" class="icon-edit" title="Edit?"></a>';
		content  += '<a rel="' + encodeURIComponent(cellvalue) + '" class="icon-delete" title="Remove?"></a>';
		return content;
	}
	
	$("#listcarabayar .icon-detail").live('click', function(a){
		if($(a.target).data('oneclicked')!='yes')
		{
			$("#t53","#tabs").empty();
			$("#t53","#tabs").load('c_master_cara_bayar/detail'+'?id='+ this.rel);
		}
		$(a.target).data('oneclicked','yes');
	});
	
	$("#listcarabayar .icon-edit").live('click', function(a){
		if($(a.target).data('oneclicked')!='yes')
		{
			$("#t53","#tabs").empty();
			$("#t53","#tabs").load('c_master_cara_bayar/edit'+'?id='+this.rel);
		}
		$(a.target).data('oneclicked','yes');
	});
	
	function deldata(myid){
		achtungShowLoader();
		$.ajax({
			  url: 'c_master_cara_bayar/delete',
			  type: "post",
			  data: {id:myid},
			  dataType: "json",
			  success: function(msg){
				if(msg == 'OK'){
					$("#dialogcarabayar").dialog("close");
					$.achtung({message: 'Proses Hapus Data Berhasil', timeout:5});
					$('#listcarabayar').trigger("reloadGrid");							
				}
				else{						
					$("#dialogcarabayar").dialog("close");
					$.achtung({message: 'Maaf Proses Hapus Data Gagal', timeout:5});
				}						
			  }
		  });
		achtungHideLoader();
	}
	
	$("#listcarabayar .icon-delete").live('click', function(){
		var myid= this.rel;
		$("#dialogcarabayar").dialog({
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
		
		$("#dialogcarabayar").dialog("open");
	});
	
	$('form').resize(function(e) {
		if($("#listcarabayar").getGridParam("records")>0){
		jQuery('#listcarabayar').setGridWidth(($(this).width()-28));
		}
	});
	
	function formattermou(cellvalue, options, rowObject) {
		var content = '';
		if(cellvalue){		
			content  += '<a href="tmp/carabayar/' + cellvalue + '" style="color:blue;cursor:pointer" title="">download</a>';
		}else{
			content  += ' - ';
		}
		return content;
	}
	
	$('#mastercarabayaradd').click(function(){
		$("#t53","#tabs").empty();
		$("#t53","#tabs").load('c_master_cara_bayar/add'+'?_=' + (new Date()).getTime());
	});
	
	$( "#namacarabayar" )
		.keypress(function(event) {
			var keycode =(event.keyCode?event.keyCode:event.which);	
			if(keycode ==13){
				event.preventDefault();
				$('#listcarabayar').trigger("reloadGrid");
			}
	});
	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	$("#resetcarabayar").live('click', function(event){
		event.preventDefault();
		$('#formcarabayar').reset();
		$('#listcarabayar').trigger("reloadGrid");
	});
	$("#caricarabayar").live('click', function(event){
		event.preventDefault();
		$('#listcarabayar').trigger("reloadGrid");
	});
})