jQuery().ready(function (){ 
	jQuery("#listtransaksisaranaposyandumasuk").jqGrid({ 
		url:'c_transaksi_sarana_posyandu_masuk/transaksisaranaposyandumasukxml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['ID','Asal Sarana Posyandu','Tujuan Sarana','Id Pegawai','Nama Sarana Posyandu','Keterangan','Kode Transaksi','Tanggal','Jumlah Sarana','Action'],
		rownumbers:true,
		width: 1021,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[ 
				{name:'id',index:'id', width:5,hidden:true}, 
				{name:'asalsaranaposyandu',index:'asalsaranaposyandu', width:100}, 
				{name:'idpuskesmas',index:'idpuskesmas', width:155}, 
				{name:'idpegawai',index:'idpegawai', width:99},
				{name:'idsaranaposyandu',index:'idsaranaposyandu', width:99},
				{name:'keterangansarana',index:'keterangansarana', width:99},
				{name:'kodetransaksi',index:'kodetransaksi', width:99},
				{name:'tgl_transaksi',index:'tgl_transaksi', width:75,align:'center'},
				{name:'jumlahsarana',index:'jumlahsarana', width:99},
				{name:'x',index:'x', width:91,align:'center',formatter:formatterAction}
			],
			rowNum:10, 
			rowList:[10,20,30], 
			pager: jQuery('#pagertransaksisaranaposyandumasuk'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				dari=$('#daritransaksisaranaposyandumasuk').val()?$('#daritransaksisaranaposyandumasuk').val():'';
				sampai=$('#sampaitransaksisaranaposyandumasuk').val()?$('#sampaitransaksisaranaposyandumasuk').val():'';
				$('#listtransaksisaranaposyandumasuk').setGridParam({postData:{'dari':dari,'sampai':sampai}})
			}
	}).navGrid('#pagertransaksisaranaposyandumasuk',{edit:false,add:false,del:false,search:false});
	
	function formatterAction(cellvalue, options, rowObject) {
		var content = '';
		content  += '<a rel="' + cellvalue + '" class="icon-detail"  title="View"></a> ';
		content  += '<a rel="' + cellvalue + '" class="icon-edit" title="Edit?"></a>';
		content  += '<a rel="' + cellvalue + '" class="icon-delete" title="Remove?"></a>';
		return content;
	}
	
	$("#listtransaksisaranaposyandumasuk .icon-detail").live('click', function(f){
		if($(f.target).data('oneclicked')!='yes')
		{
			$("#t4","#tabs").empty();
			$("#t4","#tabs").load('c_transaksi_sarana_posyandu_masuk/detail'+'?id='+this.rel+ '_=' + (new Date()).getTime());
		}
		$(f.target).data('oneclicked','yes');		
	});
	
	$("#listtransaksisaranaposyandumasuk .icon-edit").live('click', function(f){
		if($(f.target).data('oneclicked')!='yes')
		{
			$("#t4","#tabs").empty();
			$("#t4","#tabs").load('c_transaksi_sarana_posyandu_masuk/edit'+'?id='+this.rel+ '_=' + (new Date()).getTime());
		}
		$(f.target).data('oneclicked','yes');		
	});
	
	function deldata(myid){
		achtungShowLoader();
		$.ajax({
			  url: 'c_transaksi_sarana_posyandu_masuk/delete',
			  type: "post",
			  data: {id:myid},
			  dataType: "json",
			  success: function(msg){
				if(msg == 'OK'){
					$("#dialogtransaksisaranaposyandumasuk").dialog("close");
					$.achtung({message: 'Proses Hapus Data Berhasil', timeout:5});
					$('#listtransaksisaranaposyandumasuk').trigger("reloadGrid");							
				}
				else{						
					$("#dialogtransaksisaranaposyandumasuk").dialog("close");
					$.achtung({message: 'Maaf Proses Hapus Data Gagal', timeout:5});
				}						
			  }
		  });
		achtungHideLoader();
	}
	
	$("#listtransaksisaranaposyandumasuk .icon-delete").live('click', function(){
		var myid= this.rel;
		$("#dialogtransaksisaranaposyandumasuk").dialog({
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
		
		$("#dialogtransaksisaranaposyandumasuk").dialog("open");
	});
	
	$('form').resize(function(e) {
		if($("#listtransaksisaranaposyandumasuk").getGridParam("records")>0){
		jQuery('#listtransaksisaranaposyandumasuk').setGridWidth(($(this).width()-28));
		}
	});
	
	function formattermou(cellvalue, options, rowObject) {
		var content = '';
		if(cellvalue){		
			content  += '<a href="tmp/transaksisaranaposyandumasuk/' + cellvalue + '" style="color:blue;cursor:pointer" title="">download</a>';
		}else{
			content  += ' - ';
		}
		return content;
	}
	
	$('#v_transaksi_sarana_posyandu_masuk_add').click(function(){
		$("#t4","#tabs").empty();
		$("#t4","#tabs").load('c_transaksi_sarana_posyandu_masuk/add'+'?_=' + (new Date()).getTime());
	});	
	
	
	$( "#sampaitransaksisaranaposyandumasuk" )
		.keypress(function(event) {
			var keycode =(event.keyCode?event.keyCode:event.which);	
			if(keycode ==13){
				event.preventDefault();
				$('#listtransaksisaranaposyandumasuk').trigger("reloadGrid");
			}
	});
	
	$('#daritransaksisaranaposyandumasuk').datepicker({dateFormat: "dd-mm-yy",changeYear: true,onSelect: function(dateText, inst){$('#sampaitransaksisaranaposyandumasuk').datepicker('option', 'minDate', dateText);$.datepicker._clearDate('#sampaitransaksisaranaposyandumasuk');}});
	$('#sampaitransaksisaranaposyandumasuk').datepicker({dateFormat: "dd-mm-yy",changeYear: true,onClose: function(dateText, inst){$('#listtransaksisaranaposyandumasuk').trigger("reloadGrid");}});
	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	$("#resettransaksisaranaposyandumasuk").live('click', function(event){
		event.preventDefault();
		$('#formtransaksisaranaposyandumasuk').reset();
		$('#listtransaksisaranaposyandumasuk').trigger("reloadGrid");
	});
	$("#caritransaksisaranaposyandumasuk").live('click', function(event){
		event.preventDefault();
		$('#listtransaksisaranaposyandumasuk').trigger("reloadGrid");
	});
	
})