jQuery().ready(function (){ 
		jQuery("#listtranswilayah").jqGrid({ 
		url:'c_transaksi_wilayah/transaksiwilayahxml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['ID','Kode Transaksi','Nama Propinsi','Nama Kabupaten','Nama Kota','Nama Kecamatan','Nama Desa','No RT','No RW','Tgl. Transaksi','Action'],
		rownumbers:true,
		width: 1021,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[ 
				{name:'id',index:'id',hidden:true}, 
				{name:'kode_transaksi',index:'kode_transaksi'}, 
				{name:'master_propinsi_id',index:'master_propinsi_id'}, 
				{name:'master_kabupaten_id',index:'master_kabupaten_id'}, 
				{name:'master_kota_id',index:'master_kota_id'}, 
				{name:'master_kecamatan',index:'master_kecamatan_id'},
				{name:'master_desa_id',index:'master_desa_id'},
				{name:'noRT',index:'noRT',align:'right'},
				{name:'noRW',index:'noRW',align:'right'},
				{name:'tgl_transaksi',index:'tgl_transaksi',align:'center'},
				{name:'x',index:'x', width:145,align:'center',formatter:formatterAction}
			],
			rowNum:10, 
			rowList:[10,20,30], 
			pager: jQuery('#pagertranswilayah'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				dari=$('#daritranswilayah').val()?$('#daritranswilayah').val():'';
				sampai=$('#sampaitranswilayah').val()?$('#sampaitranswilayah').val():'';
				keyword=$('#wilayahkeyword').val()?$('#wilayahkeyword').val():'';
				carinama=$('#carinamatranswilayah').val()?$('#carinamatranswilayah').val():'';
				$('#listtranswilayah').setGridParam({postData:{'dari':dari,'sampai':sampai,'keyword':keyword,'carinama':carinama}})
			}
	}).navGrid('#pagertranswilayah',{edit:false,add:false,del:false,search:false});
	
	function formatterAction(cellvalue, options, rowObject) {
		var content = '';
		content  += '<a rel="' + cellvalue + '" class="icon-detail"  title="View"></a> ';
		content  += '<a rel="' + cellvalue + '" class="icon-edit" title="Edit?"></a>';
		content  += '<a rel="' + cellvalue + '" class="icon-delete" title="Remove?"></a>';
		return content;
	}
	
	$("#listtranswilayah .icon-detail").live('click', function(e){
		if($(e.target).data('oneclicked')!='yes')
		{
			$("#t3","#tabs").empty();
			$("#t3","#tabs").load('c_transaksi_wilayah/detail'+'?id='+this.rel+ '_=' + (new Date()).getTime());
		}
		$(e.target).data('oneclicked','yes');
	});
	
	$("#listtranswilayah .icon-edit").live('click', function(e){
		if($(e.target).data('oneclicked')!='yes')
		{
			$("#t3","#tabs").empty();
			$("#t3","#tabs").load('c_transaksi_wilayah/edit'+'?id='+this.rel+ '_=' + (new Date()).getTime());
		}
		$(e.target).data('oneclicked','yes');		
	});
	
	function deldata(myid){
		achtungShowLoader();
		$.ajax({
			  url: 'c_transaksi_wilayah/delete',
			  type: "post",
			  data: {id:myid},
			  dataType: "json",
			  success: function(msg){
				if(msg == 'OK'){
					$("#dialogtranswilayah").dialog("close");
					$.achtung({message: 'Proses Hapus Data Berhasil', timeout:5});
					$('#listtranswilayah').trigger("reloadGrid");							
				}
				else{						
					$("#dialogtranswilayah").dialog("close");
					$.achtung({message: 'Maaf Proses Hapus Data Gagal', timeout:5});
				}						
			  }
		  });
		achtungHideLoader();
	}
	
	$("#listtranswilayah .icon-delete").live('click', function(){
		var myid= this.rel;
		$("#dialogtranswilayah").dialog({
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
		
		$("#dialogtranswilayah").dialog("open");
	});
	
	$('form').resize(function(e) {
		if($("#listtranswilayah").getGridParam("records")>0){
		jQuery('#listtranswilayah').setGridWidth(($(this).width()-28));
		}
	});
	
	function formattermou(cellvalue, options, rowObject) {
		var content = '';
		if(cellvalue){		
			content  += '<a href="tmp/c_transaksi_wilayah/' + cellvalue + '" style="color:blue;cursor:pointer" title="">download</a>';
		}else{
			content  += ' - ';
		}
		return content;
	}
	
	$('#transwilayahadd').click(function(){
		$("#t3","#tabs").empty();
		$("#t3","#tabs").load('c_transaksi_wilayah/add'+'?_=' + (new Date()).getTime());
	});
	
	$( "#sampaitranswilayah" )
		.keypress(function(event) {
			var keycode =(event.keyCode?event.keyCode:event.which);	
			if(keycode ==13){
				event.preventDefault();
				$('#listtranswilayah').trigger("reloadGrid");
			}
	});
	
	$('#daritranswilayah').datepicker({dateFormat: "dd-mm-yy",changeYear: true,onSelect: function(dateText, inst){$('#sampaitranswilayah').datepicker('option', 'minDate', dateText);$.datepicker._clearDate('#sampaitranswilayah');}});
	$('#sampaitranswilayah').datepicker({dateFormat: "dd-mm-yy",changeYear: true,onClose: function(dateText, inst){$('#listtranswilayah').trigger("reloadGrid");}});
	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	$("#resettranswilayah").live('click', function(event){
		event.preventDefault();
		$('#formtranswilayah').reset();
		$('#listtranswilayah').trigger("reloadGrid");
	});
	$("#caritranswilayah").live('click', function(event){
		event.preventDefault();
		$('#listtranswilayah').trigger("reloadGrid");
	});
})