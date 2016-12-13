jQuery().ready(function (){ 
	jQuery("#listpegawai").jqGrid({ 
		url:'pegawai/pegawaixml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['ID','NIK','Nama Pegawai','Jenis Kelamin','Jabatan','Tgl. Pegawai','Action'],
		rownumbers:true,
		width: 1021,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[ 
				{name:'id',index:'id', width:5,hidden:true}, 
				{name:'nik_pegawai',index:'nik_pegawai', width:100}, 
				{name:'nama_pegawai',index:'nama_pegawai', width:155}, 
				{name:'jenis_kelamin',index:'jenis_kelamin', width:99},
				{name:'jabatan',index:'jabatan', width:155}, 
				{name:'tgl_pegawai',index:'tgl_pegawai', width:75,align:'center'},
				{name:'x',index:'x', width:91,align:'center',formatter:formatterAction}
			],
			rowNum:10, 
			rowList:[10,20,30], 
			pager: jQuery('#pagerpegawai'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				dari=$('#daripegawai').val()?$('#daripegawai').val():'';
				sampai=$('#sampaipegawai').val()?$('#sampaipegawai').val():'';
				nama=$('#namapegawai').val()?$('#namapegawai').val():'';
				$('#listpegawai').setGridParam({postData:{'dari':dari,'sampai':sampai,'nama':nama}})
			}
	}).navGrid('#pagerpegawai',{edit:false,add:false,del:false,search:false});
	
	function formatterAction(cellvalue, options, rowObject) {
		var content = '';
		content  += '<a rel="' + cellvalue + '" class="icon-detail"  title="View"></a> ';
		content  += '<a rel="' + cellvalue + '" class="icon-edit" title="Edit?"></a>';
		content  += '<a rel="' + cellvalue + '" class="icon-delete" title="Remove?"></a>';
		return content;
	}
	
	$(".icon-detail").live('click', function(){
		$("#t22","#tabs").empty();
		$("#t22","#tabs").load('pegawai/detail'+'?id='+this.rel+ '_=' + (new Date()).getTime());
	});
	
	$(".icon-edit").live('click', function(){
		$("#t22","#tabs").empty();
		$("#t22","#tabs").load('pegawai/edit'+'?id='+this.rel);
	});
	
	function deldata(myid){
		achtungShowLoader();
		$.ajax({
			  url: 'pegawai/delete',
			  type: "post",
			  data: {id:myid},
			  dataType: "json",
			  success: function(msg){
				if(msg == 'OK'){
					$("#dialog").dialog("close");
					$.achtung({message: 'Proses Hapus Data Berhasil', timeout:5});
					$('#listpegawai').trigger("reloadGrid");							
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
		if($("#listpegawai").getGridParam("records")>0){
		jQuery('#listpegawai').setGridWidth(($(this).width()-28));
		}
	});
	
	function formattermou(cellvalue, options, rowObject) {
		var content = '';
		if(cellvalue){		
			content  += '<a href="tmp/pegawai/' + cellvalue + '" style="color:blue;cursor:pointer" title="">download</a>';
		}else{
			content  += ' - ';
		}
		return content;
	}
	
	$('#pegawaiadd').click(function(){
		$("#t22","#tabs").empty();
		$("#t22","#tabs").load('pegawai/add'+'?_=' + (new Date()).getTime());
	});
	
	$( "#sampaipegawai" )
		.keypress(function(event) {
			var keycode =(event.keyCode?event.keyCode:event.which);	
			if(keycode ==13){
				event.preventDefault();
				$('#listpegawai').trigger("reloadGrid");
			}
	});
	
	$( "#namapegawai" )
		.keypress(function(event) {
			var keycode =(event.keyCode?event.keyCode:event.which);	
			if(keycode ==13){
				event.preventDefault();
				$('#listpegawai').trigger("reloadGrid");
			}
	});
	
	$('#daripegawai').datepicker({dateFormat: "dd-mm-yy",changeYear: true,onSelect: function(dateText, inst){$('#sampaipegawai').datepicker('option', 'minDate', dateText);$.datepicker._clearDate('#sampaipegawai');}});
	$('#sampaipegawai').datepicker({dateFormat: "dd-mm-yy",changeYear: true,onClose: function(dateText, inst){$('#listpegawai').trigger("reloadGrid");}});
	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	$("#resetpegawai").live('click', function(event){
		event.preventDefault();
		$('#formpegawai').reset();
		$('#listpegawai').trigger("reloadGrid");
	});
	$("#caripegawai").live('click', function(event){
		event.preventDefault();
		$('#listpegawai').trigger("reloadGrid");
	});
})