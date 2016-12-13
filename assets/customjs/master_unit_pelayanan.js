jQuery().ready(function (){ 
	jQuery("#listunitpelayanan").jqGrid({ 
		url:'c_master_unit_pelayanan/unitpelayananxml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['Kode Unit Pelayanan','Nama Unit','Aktif','Action'],
		rownumbers:true,
		width: 1040,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[ 
				{name:'kd',index:'kd', width:99}, 
				{name:'nama_unit',index:'nama_unit', width:99},
				{name:'aktif',index:'aktif', width:99},
				{name:'x',index:'x', width:110,align:'center',formatter:formatterAction}
			],
			rowNum:10, 
			rowList:[10,20,30], 
			pager: jQuery('#pagermasterunitpelayanan'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				keyword=$('#keywordid').val()?$('#keywordid').val():'';
				cari=$('#cariunitpelayanan').val()?$('#cariunitpelayanan').val():'';
				$('#listunitpelayanan').setGridParam({postData:{'keyword':'KD_UNIT_LAYANAN','cari':cari}})
			}
	}).navGrid('#pagermasterunitpelayanan',{edit:false,add:false,del:false,search:false});
	
	function formatterAction(cellvalue, options, rowObject) {
		var content = '';
		content  += '<a rel="' + encodeURIComponent(cellvalue) + '" class="icon-detail"  title="View"></a> ';
		content  += '<a rel="' + encodeURIComponent(cellvalue) + '" class="icon-edit" title="Edit?"></a>';
		content  += '<a rel="' + encodeURIComponent(cellvalue) + '" class="icon-delete" title="Remove?"></a>';
		return content;
	}
	
	$("#listunitpelayanan .icon-detail").live('click', function(a){
		if($(a.target).data('oneclicked')!='yes')
                {    
		$("#t35","#tabs").empty();
		$("#t35","#tabs").load('c_master_unit_pelayanan/detail'+'?kd='+this.rel);
                }
                $(a.target).data('oneclicked','yes');
	});
	
	$("#listunitpelayanan .icon-edit").live('click', function(a){
		if($(a.target).data('oneclicked')!='yes')
                {    
		$("#t35","#tabs").empty();
		$("#t35","#tabs").load('c_master_unit_pelayanan/edit'+'?kd='+this.rel);
                }
                $(a.target).data('oneclicked','yes');
                
	});
	
	function deldata(myid){
		achtungShowLoader();
		$.ajax({
			  url: 'c_master_unit_pelayanan/delete',
			  type: "post",
			  data: {kd:myid},
			  dataType: "json",
			  success: function(msg){
				if(msg == 'OK'){
					$("#dialogunitpelayanan_new").dialog("close");
					$.achtung({message: 'Proses Hapus Data Berhasil', timeout:5});
					$('#listunitpelayanan').trigger("reloadGrid");							
				}
				else{						
					$("#dialogunitpelayanan_new").dialog("close");
					$.achtung({message: 'Maaf Proses Hapus Data Gagal', timeout:5});
				}						
			  }
		  });
		achtungHideLoader();
	}
	
	$("#listunitpelayanan .icon-delete").live('click', function(){
		var myid= this.rel;
		$("#dialogunitpelayanan_new").dialog({
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
		
		$("#dialogunitpelayanan_new").dialog("open");
	});
	
	$('form').resize(function(a) {
		if($("#listunitpelayanan").getGridParam("records")>0){
		jQuery('#listunitpelayanan').setGridWidth(($(this).width()-28));
		}
	});
	
	function formattermou(cellvalue, options, rowObject) {
		var content = '';
		if(cellvalue){		
			content  += '<a href="tmp/c_master_unit_pelayanan/' + cellvalue + '" style="color:blue;cursor:pointer" title="">download</a>';
		}else{
			content  += ' - ';
		}
		return content;
	}
	
	$('#masterunitpelayanandd').click(function(){
		$("#t35","#tabs").empty();
		$("#t35","#tabs").load('c_master_unit_pelayanan/add'+'?_=' + (new Date()).getTime());
	});
	
	$( "#sampaimasterunitpelayanan" )
		.keypress(function(event) {
			var keycode =(event.keyCode?event.keyCode:event.which);	
			if(keycode ==13){
				event.preventDefault();
				$('#listunitpelayanan').trigger("reloadGrid");
			}
	});
		
		$( "#carimasterunitpelayanan" )
		.keypress(function(event) {
			var keycode =(event.keyCode?event.keyCode:event.which);	
			if(keycode ==13){
				event.preventDefault();
				$('#listunitpelayanan').trigger("reloadGrid");
			}
	});
	
	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	$("#resetmasterunitpelayanan").live('click', function(event){
		event.preventDefault();
		$('#formmasterunitpelayanan').reset();
		$('#listunitpelayanan').trigger("reloadGrid");
	});
	$("#carimasterunitpelayanan").live('click', function(event){
		event.preventDefault();
		$('#listunitpelayanan').trigger("reloadGrid");
	});
})
