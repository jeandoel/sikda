jQuery().ready(function (){ 
	jQuery("#listobat").jqGrid({ 
		url:'c_master_obat/obatxml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
			colNames:['NOMOR OBAT','KODE OBAT','NAMA OBAT','KD GOL OBAT','KD_JENIS_IMUNISASI','KD SAT KECIL','KD SAT BESAR','KD TERAPI OBAT','GENERIK','FRACTION','SINGKATAN','IS DEFAULT','Action'],
		rownumbers:true,
		width: 1021,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[ 
				{name:'kd_obat',index:'kd_obat', width:80,sortable:false,hidden:true}, 
				{name:'kode_obat_val',index:'kode_obat_val', width:80,sortable:false},				
				{name:'nama_obat',index:'nama_obat', width:90,sortable:false}, 
				{name:'kd_gol_obat',index:'kd_gol_obat', width:80,sortable:false},
				{name:'jenis_imunisasi',index:'jenis_imunisasi', width:80,sortable:false},
				{name:'kd_sat_kecil',index:'kd_sat_kecil', width:80,sortable:false},
				{name:'kd_sat_besar',index:'kd_sat_besar', width:80,sortable:false},
				{name:'kd_ter_obat',index:'kd_ter_obat', width:90,sortable:false},
				{name:'generik',index:'generik', width:60,sortable:false},
				{name:'fraction',index:'fraction', width:73,sortable:false},
				{name:'singkatan',index:'singkatan', width:73,sortable:false},
				{name:'default',index:'default', width:75,sortable:false},
				{name:'x',index:'x', width:100,align:'center',formatter:formatterAction}
			],
			rowNum:10, 
			rowList:[10,20,30], 
			pager: jQuery('#pagerobat'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				dari=$('#dariobat').val()?$('#dariobat').val():'';
				sampai=$('#sampaiobat').val()?$('#sampaiobat').val():'';
				nama=$('#namaobat').val()?$('#namaobat').val():'';
				$('#listobat').setGridParam({postData:{'dari':dari,'sampai':sampai,'nama':nama}})
			}
	}).navGrid('#pagerobat',{edit:false,add:false,del:false,search:false});
	
	function formatterAction(cellvalue, options, rowObject) {
		var content = '';
		content  += '<a rel="' + cellvalue + '" class="icon-detail" title="View"></a> ';
		content  += '<a rel="' + cellvalue + '" class="icon-edit" title="Edit?"></a>';
		content  += '<a rel="' + cellvalue + '" class="icon-delete" title="Remove?"></a>';
		return content;
	}
	
	$("#listobat .icon-detail").live('click', function(a){
		if($(a.target).data('oneclicked')!='yes')
		{
			var myrel=(this.rel==0)?'nol':this.rel;
			$("#t61","#tabs").empty();
			$("#t61","#tabs").load('c_master_obat/detail'+'?kd_obat='+encodeURIComponent(myrel));
		}
		$(a.target).data('oneclicked','yes');
	});
	
	$("#listobat .icon-edit").live('click', function(a){
		if($(a.target).data('oneclicked')!='yes')
		{
			var myrel=(this.rel==0)?'nol':this.rel;
			$("#t61","#tabs").empty();
			$("#t61","#tabs").load('c_master_obat/edit'+'?kd_obat='+encodeURIComponent(myrel));
		}
		$(a.target).data('oneclicked','yes');
	});
	
	
	function deldata(myid){
		achtungShowLoader();
		$.ajax({
			  url: 'c_master_obat/delete',
			  type: "post",
			  data: {id:myid},
			  dataType: "json",
			  success: function(msg){
				if(msg == 'OK'){
					$("#dialog").dialog("close");
					$.achtung({message: 'Proses Hapus Data Berhasil', timeout:5});
					$('#listobat').trigger("reloadGrid");							
				}
				else{						
					$("#dialog").dialog("close");
					$.achtung({message: 'Maaf Proses Hapus Data Gagal', timeout:5});
				}						
			  }
		  });
		achtungHideLoader();
	}
	
	$(" .icon-delete").live('click', function(){
		var myid=(this.rel==0)?'nol':this.rel;
		$("#dialog").dialog({
		autoOpen : false,
		modal :true,
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
		if($("#listobat").getGridParam("records")>0){
		jQuery('#listobat').setGridWidth(($(this).width()-28));
		}
	});
	
	function formattermou(cellvalue, options, rowObject) {
		var content = '';
		if(cellvalue){		
			content  += '<a href="tmp/obat/' + cellvalue + '" style="color:blue;cursor:pointer" title="">download</a>';
		}else{
			content  += ' - ';
		}
		return content;
	}
	
	$('#v_master_obat_add').click(function(){
		$("#t61","#tabs").empty();
		$("#t61","#tabs").load('c_master_obat/add'+'?_=' + (new Date()).getTime());
	});
	
	$( "#sampaiobat" )
		.keypress(function(event) {
			var keycode =(event.keyCode?event.keyCode:event.which);	
			if(keycode ==13){
				event.preventDefault();
				$('#listobat').trigger("reloadGrid");
			}
	});
	$( "#namaobat" )
		.keypress(function(event) {
			var keycode =(event.keyCode?event.keyCode:event.which);	
			if(keycode ==13){
				event.preventDefault();
				$('#listobat').trigger("reloadGrid");
			}
	});
	$('#dariobat').datepicker({dateFormat: "dd-mm-yy",changeYear: true,onSelect: function(dateText, inst){$('#sampaiobat').datepicker('option', 'minDate', dateText);$.datepicker._clearDate('#sampaiobat');}});
	$('#sampaiobat').datepicker({dateFormat: "dd-mm-yy",changeYear: true,onClose: function(dateText, inst){$('#listobat').trigger("reloadGrid");}});
	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	$("#resetobat").live('click', function(event){
		event.preventDefault();
		$('#formobat').reset();
		$('#listobat').trigger("reloadGrid");
	});
	$("#cariobat").live('click', function(event){
		event.preventDefault();
		$('#listobat').trigger("reloadGrid");
	});
})