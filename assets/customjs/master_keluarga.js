jQuery().ready(function (){ 
	jQuery("#listmaster_keluarga").jqGrid({ 
		url:'master_keluarga/master_keluargaxml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['ID','Nomor KK','Alamat','Kecamatan','Kelurahan','Puskesmas','Nomor Telepon','Istri','Anak','Jenis Kelamin','Tanggal Lahir','Anak ke','Tgl. Master Keluarga','Action'],
		rownumbers:true,
		width: 1021,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[ 
				{name:'id',index:'id', width:5,hidden:true}, 
				{name:'nomorkk',index:'nomorkk', width:100}, 
				{name:'alamat',index:'alamat', width:155}, 
				{name:'kecamatan',index:'kecamatan', width:150},
				{name:'kelurahan',index:'kelurahan', width:150}, 
				{name:'puskesmas',index:'puskesmas', width:150}, 
				{name:'notelepon',index:'notelepon', width:160},
				{name:'istri',index:'istri', width:100}, 
				{name:'anak',index:'anak', width:155}, 
				{name:'jeniskelamin',index:'jeniskelamin', width:150, align:'center'},
				{name:'tanggallahir',index:'tanggallahir', width:150, align:'center'}, 
				{name:'anakke',index:'anakke', width:100, align:'center'}, 
				{name:'tgl_master_keluarga',index:'tgl_master_keluarga', width:250,align:'center'},
				{name:'x',index:'x', width:200,align:'center',formatter:formatterAction}
			],
			rowNum:10, 
			rowList:[10,20,30], 
			pager: jQuery('#pagermaster_keluarga'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				dari=$('#darimaster_keluarga').val()?$('#darimaster_keluarga').val():'';
				sampai=$('#sampaimaster_keluarga').val()?$('#sampaimaster_keluarga').val():'';
				nomorkk=$('#nomorkkmaster_keluarga').val()?$('#nomorkkmaster_keluarga').val():'';
				$('#listmaster_keluarga').setGridParam({postData:{'dari':dari,'sampai':sampai, 'nomorkk':nomorkk}})
			}
	}).navGrid('#pagermaster_keluarga',{edit:false,add:false,del:false,search:false});
	
	function formatterAction(cellvalue, options, rowObject) {
		var content = '';
		content  += '<a rel="' + cellvalue + '" class="icon-detail"  title="View"></a> ';
		content  += '<a rel="' + cellvalue + '" class="icon-edit" title="Edit?"></a>';
		content  += '<a rel="' + cellvalue + '" class="icon-delete" title="Remove?"></a>';
		return content;
	}
	
	$(".icon-detail").live('click', function(){
		$("#t9","#tabs").empty();
		$("#t9","#tabs").load('master_keluarga/detail'+'?id='+this.rel+ '_=' + (new Date()).getTime());
	});
	
	$(".icon-edit").live('click', function(){
		$("#t9","#tabs").empty();
		$("#t9","#tabs").load('master_keluarga/edit'+'?id='+this.rel);
	});
	
	function deldata(myid){
		achtungShowLoader();
		$.ajax({
			  url: 'master_keluarga/delete',
			  type: "post",
			  data: {id:myid},
			  dataType: "json",
			  success: function(msg){
				if(msg == 'OK'){
					$("#dialog").dialog("close");
					$.achtung({message: 'Proses Hapus Data Berhasil', timeout:5});
					$('#listmaster_keluarga').trigger("reloadGrid");							
				}
				else{						
					$("#dialog").dialog("close");
					$.achtung({message: 'Maaf Proses Hapus Data Gagal', timeout:5});
				}						
			  }
		  });
		achtungHideLoader();
	}
	
	$(".icon-delete").live('click', function(){
		var myid= this.rel;
		$("#dialog").dialog({
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
	
	$('form').resize(function(e) {
		if($("#listmaster_keluarga").getGridParam("records")>0){
		jQuery('#listmaster_keluarga').setGridWidth(($(this).width()-28));
		}
	});
	
	function formattermou(cellvalue, options, rowObject) {
		var content = '';
		if(cellvalue){		
			content  += '<a href="tmp/master_keluarga/' + cellvalue + '" style="color:blue;cursor:pointer" title="">download</a>';
		}else{
			content  += ' - ';
		}
		return content;
	}
	
	$('#master_keluarga_add').click(function(){
		$("#t9","#tabs").empty();
		$("#t9","#tabs").load('master_keluarga/add'+'?_=' + (new Date()).getTime());
	});
	
	$( "#sampaimaster_keluarga" )
		.keypress(function(event) {
			var keycode =(event.keyCode?event.keyCode:event.which);	
			if(keycode ==13){
				event.preventDefault();
				$('#listmaster_keluarga').trigger("reloadGrid");
			}			
	});
	
	$( "#nomorkkmaster_keluarga" )
		.keypress(function(event) {
			var keycode =(event.keyCode?event.keyCode:event.which);	
			if(keycode ==13){
				event.preventDefault();
				$('#listmaster_keluarga').trigger("reloadGrid");
			}			
	});
	
	
	
	
	$('#darimaster_keluarga').datepicker({dateFormat: "dd-mm-yy",changeYear: true,onSelect: function(dateText, inst){$('#sampaimaster_keluarga').datepicker('option', 'minDate', dateText);$.datepicker._clearDate('#sampaimaster_keluarga');}});
	$('#sampaimaster_keluarga').datepicker({dateFormat: "dd-mm-yy",changeYear: true,onClose: function(dateText, inst){$('#listmaster_keluarga').trigger("reloadGrid");}});	
	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	$("#resetmaster_keluarga").live('click', function(event){
		event.preventDefault();
		$('#formmaster_keluarga').reset();
		$('#listmaster_keluarga').trigger("reloadGrid");
	});
	$("#carimaster_keluarga").live('click', function(event){
		event.preventDefault();
		$('#listmaster_keluarga').trigger("reloadGrid");
	});
})