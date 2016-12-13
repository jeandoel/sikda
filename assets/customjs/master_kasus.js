jQuery().ready(function (){ 
	jQuery("#listmasterKasus").jqGrid({ 
		url:'c_master_kasus/masterkasusxml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['VARIA_ID','KODE JENIS KASUS','VARIABEL ID','PARENT ID','VARIABEL NAME','VARIABEL DEFINISI','KETERANGAN','PILIHAN VALUE','IROW','Action'],
		rownumbers:true,
		width: 1021,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[ 
				{name:'id1',index:'id1', width:25,align:'center',hidden:true}, 
				{name:'id',index:'id', width:30}, 
				{name:'varId',index:'varId', width:30}, 
				{name:'parId',index:'parId', width:30}, 
				{name:'varNam',index:'varNam', width:35}, 
				{name:'varDef',index:'varDef', width:50}, 
				{name:'ket',index:'ket', width:75}, 
				{name:'pilVal',index:'pilVal', width:35,align:'center'}, 
				{name:'irow',index:'irow', width:15,align:'center'}, 
				{name:'myid',index:'myid', width:91,align:'center',formatter:formatterAction}
			],
			rowNum:10, 
			rowList:[10,20,30], 
			pager: jQuery('#pagermasterKasus'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				dari=$('#darimasterKasus').val()?$('#darimasterKasus').val():'';
				sampai=$('#sampaimasterKasus').val()?$('#sampaimasterKasus').val():'';
				keyword=$('#keywordmasterKasus').val()?$('#keywordmasterKasus').val():'';
				carinama=$('#carinamamasterKasus').val()?$('#carinamamasterKasus').val():'';
				$('#listmasterKasus').setGridParam({postData:{'dari':dari,'sampai':sampai,'keyword':keyword,'carinama':carinama}})
			}
	}).navGrid('#pagermasterKasus',{edit:false,add:false,del:false,search:false});
	
	function formatterAction(cellvalue, options, rowObject) {
		var content = '';
		content  += '<a rel="' + cellvalue + '" class="icon-detail"  title="View"></a> ';
		content  += '<a rel="' + cellvalue + '" class="icon-edit" title="Edit?"></a>';
		content  += '<a rel="' + cellvalue + '" class="icon-delete" title="Remove?"></a>';
		return content;
	}
	
	$("#listmasterKasus .icon-detail").live('click', function(c){
		if($(c.target).data('oneclicked')!='yes')
		{
			$("#t21","#tabs").empty();
			$("#t21","#tabs").load('c_master_kasus/detail'+'?id='+this.rel);
		}
		$(c.target).data('oneclicked','yes');
	});
	
	$("#listmasterKasus .icon-edit").live('click', function(c){
		if($(c.target).data('oneclicked')!='yes')
		{
			$("#t21","#tabs").empty();
			$("#t21","#tabs").load('c_master_kasus/edit'+'?id='+this.rel);
		}
		$(c.target).data('oneclicked','yes');		
	});
	
	function deldata(myid){
		achtungShowLoader();
		$.ajax({
			  url: 'c_master_kasus/delete',
			  type: "post",
			  data: {id:myid},
			  dataType: "json",
			  success: function(msg){
				if(msg == 'OK'){
					$("#dialogmasterKasus_new").dialog("close");
					$.achtung({message: 'Proses Hapus Data Berhasil', timeout:5});
					$('#listmasterKasus').trigger("reloadGrid");							
				}
				else{						
					$("#dialogmasterKasus_new").dialog("close");
					$.achtung({message: 'Maaf Proses Hapus Data Gagal', timeout:5});
				}						
			  }
		  });
		achtungHideLoader();
	}
	
	$("#listmasterKasus .icon-delete").live('click', function(){
		var myid= this.rel;
		$("#dialogmasterKasus_new").dialog({
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
		
		$("#dialogmasterKasus_new").dialog("open");
	});
	
	$('form').resize(function(e) {
		if($("#listmasterKasus").getGridParam("records")>0){
		jQuery('#listmasterKasus').setGridWidth(($(this).width()-28));
		}
	});
	
	function formattermou(cellvalue, options, rowObject) {
		var content = '';
		if(cellvalue){		
			content  += '<a href="tmp/c_master_kasus/' + cellvalue + '" style="color:blue;cursor:pointer" title="">download</a>';
		}else{
			content  += ' - ';
		}
		return content;
	}
	
	$('#masterKasusadd').click(function(){
		$("#t21","#tabs").empty();
		$("#t21","#tabs").load('c_master_kasus/add'+'?_=' + (new Date()).getTime());
	});
	
	$( "#sampaimasterKasus" )
		.keypress(function(event) {
			var keycode =(event.keyCode?event.keyCode:event.which);	
			if(keycode ==13){
				event.preventDefault();
				$('#listmasterKasus').trigger("reloadGrid");
			}
	});
	
	$('#darimasterKasus').datepicker({dateFormat: "dd-mm-yy",changeYear: true,onSelect: function(dateText, inst){$('#sampaimasterKasus').datepicker('option', 'minDate', dateText);$.datepicker._clearDate('#sampaimasterKasus');}});
	$('#sampaimasterKasus').datepicker({dateFormat: "dd-mm-yy",changeYear: true,onClose: function(dateText, inst){$('#listmasterKasus').trigger("reloadGrid");}});
	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	$("#resetmasterKasus").live('click', function(event){
		event.preventDefault();
		$('#formmasterKasus').reset();
		$('#listmasterKasus').trigger("reloadGrid");
	});
	$("#carimasterKasus").live('click', function(event){
		event.preventDefault();
		$('#listmasterKasus').trigger("reloadGrid");
	});
})
