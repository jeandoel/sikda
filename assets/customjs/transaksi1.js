jQuery().ready(function (){ 
	jQuery("#listtransaksi1").jqGrid({ 
		url:'transaksi1/transaksi1xml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['ID','Column1','Column2','Column3','Tgl. Transaksi1','Action'],
		rownumbers:true,
		width: 1021,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[ 
				{name:'id',index:'id', width:5,hidden:true}, 
				{name:'column1',index:'column1', width:100}, 
				{name:'column2',index:'column2', width:155}, 
				{name:'column3',index:'column3', width:799},
				{name:'tgl_transaksi1',index:'tgl_transaksi1', width:75,align:'center'},
				{name:'x',index:'x', width:91,align:'center',formatter:formatterAction}
			],
			rowNum:10, 
			rowList:[10,20,30], 
			pager: jQuery('#pagertransaksi1'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				dari=$('#daritransaksi1').val()?$('#daritransaksi1').val():'';
				sampai=$('#sampaitransaksi1').val()?$('#sampaitransaksi1').val():'';
				$('#listtransaksi1').setGridParam({postData:{'dari':dari,'sampai':sampai}})
			}
	}).navGrid('#pagertransaksi1',{edit:false,add:false,del:false,search:false});
	
	function formatterAction(cellvalue, options, rowObject) {
		var content = '';
		content  += '<a rel="' + cellvalue + '" class="icon-detail"  title="View"></a> ';
		content  += '<a rel="' + cellvalue + '" class="icon-edit" title="Edit?"></a>';
		content  += '<a rel="' + cellvalue + '" class="icon-delete" title="Remove?"></a>';
		return content;
	}
	
	$("#listtransaksi1 .icon-detail").live('click', function(e){
		if($(e.target).data('oneclicked')!='yes')
		{
			$("#t2","#tabs").empty();
			$("#t2","#tabs").load('transaksi1/detail'+'?id='+this.rel+ '_=' + (new Date()).getTime());
		}
		$(e.target).data('oneclicked','yes');		
	});
	
	$("#listtransaksi1 .icon-edit").live('click', function(e){
		if($(e.target).data('oneclicked')!='yes')
		{
			$("#t2","#tabs").empty();
			$("#t2","#tabs").load('transaksi1/edit'+'?id='+this.rel+ '_=' + (new Date()).getTime());
		}
		$(e.target).data('oneclicked','yes');		
	});
	
	function deldata(myid){
		achtungShowLoader();
		$.ajax({
			  url: 'transaksi1/delete',
			  type: "post",
			  data: {id:myid},
			  dataType: "json",
			  success: function(msg){
				if(msg == 'OK'){
					$("#dialogtransaksi1").dialog("close");
					$.achtung({message: 'Proses Hapus Data Berhasil', timeout:5});
					$('#listtransaksi1').trigger("reloadGrid");							
				}
				else{						
					$("#dialogtransaksi1").dialog("close");
					$.achtung({message: 'Maaf Proses Hapus Data Gagal', timeout:5});
				}						
			  }
		  });
		achtungHideLoader();
	}
	
	$("#listtransaksi1 .icon-delete").live('click', function(){
		var myid= this.rel;
		$("#dialogtransaksi1").dialog({
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
		
		$("#dialogtransaksi1").dialog("open");
	});
	
	$('form').resize(function(e) {
		if($("#listtransaksi1").getGridParam("records")>0){
		jQuery('#listtransaksi1').setGridWidth(($(this).width()-28));
		}
	});
	
	function formattermou(cellvalue, options, rowObject) {
		var content = '';
		if(cellvalue){		
			content  += '<a href="tmp/transaksi1/' + cellvalue + '" style="color:blue;cursor:pointer" title="">download</a>';
		}else{
			content  += ' - ';
		}
		return content;
	}
	
	$('#transaksi1add').click(function(){
		$("#t2","#tabs").empty();
		$("#t2","#tabs").load('transaksi1/add'+'?_=' + (new Date()).getTime());
	});	
	
	
	$( "#sampaitransaksi1" )
		.keypress(function(event) {
			var keycode =(event.keyCode?event.keyCode:event.which);	
			if(keycode ==13){
				event.preventDefault();
				$('#listtransaksi1').trigger("reloadGrid");
			}
	});
	
	$('#daritransaksi1').datepicker({dateFormat: "dd-mm-yy",changeYear: true,onSelect: function(dateText, inst){$('#sampaitransaksi1').datepicker('option', 'minDate', dateText);$.datepicker._clearDate('#sampaitransaksi1');}});
	$('#sampaitransaksi1').datepicker({dateFormat: "dd-mm-yy",changeYear: true,onClose: function(dateText, inst){$('#listtransaksi1').trigger("reloadGrid");}});
	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	$("#resettransaksi1").live('click', function(event){
		event.preventDefault();
		$('#formtransaksi1').reset();
		$('#listtransaksi1').trigger("reloadGrid");
	});
	$("#caritransaksi1").live('click', function(event){
		event.preventDefault();
		$('#listtransaksi1').trigger("reloadGrid");
	});
})