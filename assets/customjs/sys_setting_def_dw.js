jQuery().ready(function (){ 
	jQuery("#list_sys_setting_def_dw").jqGrid({ 
		url:'c_sys_setting_def_dw/sys_setting_def_dw_xml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['Kode DW','Puskesmas','Kelurahan/Desa','Kecamatan','Kabupaten/Kota','Propinsi','Action'],
		rownumbers:true,
		width: 1021,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[ 
				{name:'kodedalamwilayah',index:'kodedalamwilayah', width:25,hidden:true}, 
				{name:'kodepuskesmas',index:'kodepuskesmas', width:75}, 
				{name:'kodekelurahan',index:'kodekelurahan', width:75},
				{name:'kodekecamatan',index:'kodekecamatan', width:75},
				{name:'kodekabupaten',index:'kodekabupaten', width:75},
				{name:'kodeprovinsi',index:'kodeprovinsi', width:75},
				{name:'x',index:'x', width:60,align:'center',formatter:formatterAction}
			],
			rowNum:10, 
			rowList:[10,20,30], 
			pager: jQuery('#pager_sys_setting_def_dw'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				keyword=$('#carikeyword').val()?$('#carikeyword').val():'';
				carinama=$('#carikategori').val()?$('#carikategori').val():'';
				$('#list_sys_setting_def_dw').setGridParam({postData:{'keyword':keyword,'carinama':carinama}})
			}
	}).navGrid('#pager_sys_setting_def_dw',{edit:false,add:false,del:false,search:false});
	
	function formatterAction(cellvalue, options, rowObject) {
		var content = '';
		content  += '<a rel="' + cellvalue + '" class="icon-detail"  title="View"></a> ';
		//content  += '<a rel="' + cellvalue + '" class="icon-edit" title="Edit?"></a>';
		content  += '<a rel="' + cellvalue + '" class="icon-delete" title="Remove?"></a>';
		return content;
	}
	
	$("#list_sys_setting_def_dw .icon-detail").live('click', function(g){
		if($(g.target).data('oneclicked')!='yes')
		{
			$("#t56","#tabs").empty();
			$("#t56","#tabs").load('c_sys_setting_def_dw/detail'+'?id='+encodeURIComponent(this.rel));
		}
		$(g.target).data('oneclicked','yes');		
	});
	
	/*$("#list_sys_setting_def_dw .icon-edit").live('click', function(g){
		if($(g.target).data('oneclicked')!='yes')
		{
			$("#t56","#tabs").empty();
			$("#t56","#tabs").load('c_sys_setting_def_dw/edit'+'?id='+encodeURIComponent(this.rel));
		}
		$(g.target).data('oneclicked','yes');		
	});*/
	
	function deldata(myid){
		achtungShowLoader();
		$.ajax({
			  url: 'c_sys_setting_def_dw/delete',
			  type: "post",
			  data: {id:myid},
			  dataType: "json",
			  success: function(msg){
				if(msg == 'OK'){
					$("#dialog_sys_setting_def_dw").dialog("close");
					$.achtung({message: 'Proses Hapus Data Berhasil', timeout:5});
					$('#list_sys_setting_def_dw').trigger("reloadGrid");							
				}
				else{						
					$("#dialog_sys_setting_def_dw").dialog("close");
					$.achtung({message: 'Maaf Proses Hapus Data Gagal', timeout:5});
				}						
			  }
		  });
		achtungHideLoader();
	}
	
	$("#list_sys_setting_def_dw .icon-delete").live('click', function(){
		var myid= this.rel;
		$("#dialog_sys_setting_def_dw").dialog({
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
		
		$("#dialog_sys_setting_def_dw").dialog("open");
	});
	
	$('form').resize(function(g) {
		if($("#list_sys_setting_def_dw").getGridParam("records")>0){
		jQuery('#list_sys_setting_def_dw').setGridWidth(($(this).width()-28));
		}
	});
	
	function formattermou(cellvalue, options, rowObject) {
		var content = '';
		if(cellvalue){		
			content  += '<a href="tmp/sys_setting_def_dw/' + cellvalue + '" style="color:blue;cursor:pointer" title="">download</a>';
		}else{
			content  += ' - ';
		}
		return content;
	}
	
	$('#sys_setting_def_dw_add').click(function(){
		$("#t56","#tabs").empty();
		$("#t56","#tabs").load('c_sys_setting_def_dw/add'+'?_=' + (new Date()).getTime());
	});	
	
	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	
	$("#reset_sys_setting_def_dw").live('click', function(event){
		event.preventDefault();
		$('#form_sys_setting_def_dw').reset();
		$('#list_sys_setting_def_dw').trigger("reloadGrid");
	});
	$("#cari_sys_setting_def_dw").live('click', function(event){
		event.preventDefault();
		$('#list_sys_setting_def_dw').trigger("reloadGrid");
	});
	
})