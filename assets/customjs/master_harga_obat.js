jQuery().ready(function (){ 
	jQuery("#listmasterhargaobat").jqGrid({ 
		url:'c_master_harga_obat/masterhargaobatxml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['Kode Obat','Kode Tarif','Kode Obat','Nama Obat','Harga Beli','Harga Jual','Kode Milik Obat','Action'],
		rownumbers:true,
		width: 1021,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[ 
				{name:'id',index:'id', width:5,hidden:true}, 
				{name:'kdtarif',index:'kdtarif', width:100,align:'center'}, 
				{name:'kdobat',index:'kdobat', width:100,align:'center'}, 
				{name:'nmobat',index:'nmobat', width:100,align:'center'}, 
				{name:'hrgbeli',index:'hrgbeli', width:100,align:'right'}, 
				{name:'hrgjual',index:'hrgjual', width:100,align:'right'}, 
				{name:'milik',index:'milik', width:100,align:'center'}, 
				{name:'myid',index:'myid', width:91,align:'center',formatter:formatterAction}
			],
			rowNum:10, 
			rowList:[10,20,30], 
			pager: jQuery('#pagermasterhargaobat'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				dari=$('#darimasterhargaobat').val()?$('#darimasterhargaobat').val():'';
				sampai=$('#sampaimasterhargaobat').val()?$('#sampaimasterhargaobat').val():'';
				keyword=$('#keywordmasterhargaobat').val()?$('#keywordmasterhargaobat').val():'';
				carinama=$('#carinamamasterhargaobat').val()?$('#carinamamasterhargaobat').val():'';
				$('#listmasterhargaobat').setGridParam({postData:{'dari':dari,'sampai':sampai,'keyword':keyword,'carinama':carinama}})
			}
	}).navGrid('#pagermasterhargaobat',{edit:false,add:false,del:false,search:false});
	
	function formatterAction(cellvalue, options, rowObject) {
		var content = '';
		content  += '<a rel="' + cellvalue + '" class="icon-detail"  title="View"></a> ';
		content  += '<a rel="' + cellvalue + '" class="icon-edit" title="Edit?"></a>';
		content  += '<a rel="' + cellvalue + '" class="icon-delete" title="Remove?"></a>';
		return content;
	}
	
	$("#listmasterhargaobat .icon-detail").live('click', function(h){
		if($(h.target).data('oneclicked')!='yes')
		{
			$("#t23","#tabs").empty();
			$("#t23","#tabs").load('c_master_harga_obat/detail'+'?id='+this.rel);
		}
		$(h.target).data('oneclicked','yes');
	});
	
	$("#listmasterhargaobat .icon-edit").live('click', function(h){
		if($(h.target).data('oneclicked')!='yes')
		{
			$("#t23","#tabs").empty();
			$("#t23","#tabs").load('c_master_harga_obat/edit'+'?id='+this.rel);
		}
		$(h.target).data('oneclicked','yes');		
	});
	
	function deldata(myid){
		achtungShowLoader();
		$.ajax({
			  url: 'c_master_harga_obat/delete',
			  type: "post",
			  data: {id:myid},
			  dataType: "json",
			  success: function(msg){
				if(msg == 'OK'){
					$("#dialogmasterhargaobat").dialog("close");
					$.achtung({message: 'Proses Hapus Data Berhasil', timeout:5});
					$('#listmasterhargaobat').trigger("reloadGrid");							
				}
				else{						
					$("#dialogmasterhargaobat").dialog("close");
					$.achtung({message: 'Maaf Proses Hapus Data Gagal', timeout:5});
				}						
			  }
		  });
		achtungHideLoader();
	}
	
	$("#listmasterhargaobat .icon-delete").live('click', function(){
		var myid= this.rel;
		$("#dialogmasterhargaobat").dialog({
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
		
		$("#dialogmasterhargaobat").dialog("open");
	});
	
	$('form').resize(function(e) {
		if($("#listmasterhargaobat").getGridParam("records")>0){
		jQuery('#listmasterhargaobat').setGridWidth(($(this).width()-28));
		}
	});
	
	function formattermou(cellvalue, options, rowObject) {
		var content = '';
		if(cellvalue){		
			content  += '<a href="tmp/c_master_harga_obat/' + cellvalue + '" style="color:blue;cursor:pointer" title="">download</a>';
		}else{
			content  += ' - ';
		}
		return content;
	}
	
	$('#masterhargaobatadd').click(function(){
		$("#t23","#tabs").empty();
		$("#t23","#tabs").load('c_master_harga_obat/add'+'?_=' + (new Date()).getTime());
	});
	
	$( "#sampaimasterhargaobat" )
		.keypress(function(event) {
			var keycode =(event.keyCode?event.keyCode:event.which);	
			if(keycode ==13){
				event.preventDefault();
				$('#listmasterhargaobat').trigger("reloadGrid");
			}
	});
	
	$('#darimasterhargaobat').datepicker({dateFormat: "dd-mm-yy",changeYear: true,onSelect: function(dateText, inst){$('#sampaimasterhargaobat').datepicker('option', 'minDate', dateText);$.datepicker._clearDate('#sampaimasterhargaobat');}});
	$('#sampaimasterhargaobat').datepicker({dateFormat: "dd-mm-yy",changeYear: true,onClose: function(dateText, inst){$('#listmasterhargaobat').trigger("reloadGrid");}});
	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	$("#resetmasterhargaobat").live('click', function(event){
		event.preventDefault();
		$('#formmasterhargaobat').reset();
		$('#listmasterhargaobat').trigger("reloadGrid");
	});
	$("#carimasterhargaobat").live('click', function(event){
		event.preventDefault();
		$('#listmasterhargaobat').trigger("reloadGrid");
	});
})
