jQuery().ready(function (){ 
	jQuery("#listtindakan").jqGrid({ 
		url:'c_master_tindakan/tindakanxml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['Kode Produk','Kode Puskesmas','Golongan Produk','Produk','Harga','Singkatan','Is Default','Action'],
		rownumbers:true,
		width: 1040,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[  
				{name:'kd',index:'kd', width:99},
				{name:'kd_produk',index:'kd_produk', width:99},
				{name:'gol_produk',index:'gol_produk', width:99},
				{name:'produk',index:'produk', width:99},
				{name:'harga',index:'harga', width:99},
				{name:'singkatan',index:'harga', width:99, hidden:true},
				{name:'is_default',index:'is_default', width:99, hidden:true},
				{name:'x',index:'x', width:110,align:'center',formatter:formatterAction}
			],
			rowNum:10, 
			rowList:[10,20,30], 
			pager: jQuery('#pagermastertindakan'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				keyword=$('#keywordid').val()?$('#keywordid').val():'';
				cari=$('#carinamamastertindakan').val()?$('#carinamamastertindakan').val():'';
				$('#listtindakan').setGridParam({postData:{'keyword':keyword,'cari':cari}})
			}
	}).navGrid('#pagermastertindakan',{edit:false,add:false,del:false,search:false});
	
	function formatterAction(cellvalue, options, rowObject) {
		var content = '';
		content  += '<a rel="' + encodeURIComponent(cellvalue) + '" class="icon-detail"  title="View"></a> ';
		content  += '<a rel="' + encodeURIComponent(cellvalue) + '" class="icon-edit" title="Edit?"></a>';
		content  += '<a rel="' + encodeURIComponent(cellvalue) + '" class="icon-delete" title="Remove?"></a>';
		return content;
	}
	
	$("#listtindakan .icon-detail").live('click', function(a){
		if($(a.target).data('oneclicked')!='yes')
                {    
		$("#t70","#tabs").empty();
		$("#t70","#tabs").load('c_master_tindakan/detail'+'?kd='+this.rel);
                }
                $(a.target).data('oneclicked','yes');
	});
	
	$("#listtindakan .icon-edit").live('click', function(a){
		if($(a.target).data('oneclicked')!='yes')
                {    
		$("#t70","#tabs").empty();
		$("#t70","#tabs").load('c_master_tindakan/edit'+'?kd='+this.rel);
                }
                $(a.target).data('oneclicked','yes');
                
	});
	
	function deldata(myid){
		achtungShowLoader();
		$.ajax({
			  url: 'c_master_tindakan/delete',
			  type: "post",
			  data: {kd:myid},
			  dataType: "json",
			  success: function(msg){
				if(msg == 'OK'){
					$("#dialogtindakan").dialog("close");
					$.achtung({message: 'Proses Hapus Data Berhasil', timeout:5});
					$('#listtindakan').trigger("reloadGrid");							
				}
				else{						
					$("#dialogtindakan").dialog("close");
					$.achtung({message: 'Maaf Proses Hapus Data Gagal', timeout:5});
				}						
			  }
		  });
		achtungHideLoader();
	}
	
	$(".icon-delete").live('click', function(){
		var myid= this.rel;
		$("#dialogtindakan").dialog({
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
		
		$("#dialogtindakan").dialog("open");
	});
	
	$('form').resize(function(a) {
		if($("#listtindakan").getGridParam("records")>0){
		jQuery('#listtindakan').setGridWidth(($(this).width()-28));
		}
	});
	
	function formattermou(cellvalue, options, rowObject) {
		var content = '';
		if(cellvalue){		
			content  += '<a href="tmp/c_master_tindakan/' + cellvalue + '" style="color:blue;cursor:pointer" title="">download</a>';
		}else{
			content  += ' - ';
		}
		return content;
	}
	
	$('#mastertindakanadd').click(function(){
		$("#t70","#tabs").empty();
		$("#t70","#tabs").load('c_master_tindakan/add'+'?_=' + (new Date()).getTime());
	});
	
	$( "#sampaimastertindakan" )
		.keypress(function(event) {
			var keycode =(event.keyCode?event.keyCode:event.which);	
			if(keycode ==13){
				event.preventDefault();
				$('#listtindakan').trigger("reloadGrid");
			}
	});
		
		$( "#carimastertindakan" )
		.keypress(function(event) {
			var keycode =(event.keyCode?event.keyCode:event.which);	
			if(keycode ==13){
				event.preventDefault();
				$('#listtindakan').trigger("reloadGrid");
			}
	});
	
	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	$("#resetmastertindakan").live('click', function(event){
		event.preventDefault();
		$('#formmastertindakan').reset();
		$('#listtindakan').trigger("reloadGrid");
	});
	$("#carimastertindakan").live('click', function(event){
		event.preventDefault();
		$('#listtindakan').trigger("reloadGrid");
	});
})