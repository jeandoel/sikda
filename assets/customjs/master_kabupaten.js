jQuery().ready(function (){ 
	jQuery("#listmasterKab").jqGrid({ 
		url:'c_master_kabupaten/masterkabupatenxml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['Kode Kabupaten','Kode Kabupaten','Kode Provinsi','Kabupaten','Action'],
		rownumbers:true,
		width: 1021,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[ 
				{name:'id1',index:'id1', width:25,align:'center',hidden:true}, 
				{name:'id',index:'id', width:25,align:'center'}, 
				{name:'kode_prov',index:'kode_prov', width:25,align:'center'}, 
				{name:'namaKab',index:'namaKab', width:100}, 
				{name:'myid',index:'myid', width:91,align:'center',formatter:formatterAction}
			],
			rowNum:10, 
			rowList:[10,20,30], 
			pager: jQuery('#pagermasterKab'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				dari=$('#darimasterKab').val()?$('#darimasterKab').val():'';
				sampai=$('#sampaimasterKab').val()?$('#sampaimasterKab').val():'';
				carinama=$('#carinamamasterKab').val()?$('#carinamamasterKab').val():'';
				$('#listmasterKab').setGridParam({postData:{'dari':dari,'sampai':sampai,'carinama':carinama}})
			}
	}).navGrid('#pagermasterKab',{edit:false,add:false,del:false,search:false});
	
	function formatterAction(cellvalue, options, rowObject) {
		var content = '';
		content  += '<a rel="' + cellvalue + '" class="icon-detail"  title="View"></a> ';
		content  += '<a rel="' + cellvalue + '" class="icon-edit" title="Edit?"></a>';
		content  += '<a rel="' + cellvalue + '" class="icon-delete" title="Remove?"></a>';
		return content;
	}
	
	$("#listmasterKab .icon-detail").live('click', function(c){
		if($(c.target).data('oneclicked')!='yes')
		{
			$("#t26","#tabs").empty();
			$("#t26","#tabs").load('c_master_kabupaten/detail'+'?id='+this.rel);
		}
		$(c.target).data('oneclicked','yes');
	});
	
	$("#listmasterKab .icon-edit").live('click', function(c){
		if($(c.target).data('oneclicked')!='yes')
		{
			$("#t26","#tabs").empty();
			$("#t26","#tabs").load('c_master_kabupaten/edit'+'?id='+this.rel);
		}
		$(c.target).data('oneclicked','yes');		
	});
	
	function deldata(myid){
		achtungShowLoader();
		$.ajax({
			  url: 'c_master_kabupaten/delete',
			  type: "post",
			  data: {id:myid},
			  dataType: "json",
			  success: function(msg){
				if(msg == 'OK'){
					$("#dialogmasterKab").dialog("close");
					$.achtung({message: 'Proses Hapus Data Berhasil', timeout:5});
					$('#listmasterKab').trigger("reloadGrid");							
				}
				else{						
					$("#dialogmasterKab").dialog("close");
					$.achtung({message: 'Maaf Proses Hapus Data Gagal', timeout:5});
				}						
			  }
		  });
		achtungHideLoader();
	}
	
	$("#listmasterKab .icon-delete").live('click', function(){
		var myid= this.rel;
		$("#dialogmasterKab").dialog({
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
		
		$("#dialogmasterKab").dialog("open");
	});
	
	$('form').resize(function(e) {
		if($("#listmasterKab").getGridParam("records")>0){
		jQuery('#listmasterKab').setGridWidth(($(this).width()-28));
		}
	});
	
	function formattermou(cellvalue, options, rowObject) {
		var content = '';
		if(cellvalue){		
			content  += '<a href="tmp/c_master_kabupaten/' + cellvalue + '" style="color:blue;cursor:pointer" title="">download</a>';
		}else{
			content  += ' - ';
		}
		return content;
	}
	
	$('#masterKabadd').click(function(){
		$("#t26","#tabs").empty();
		$("#t26","#tabs").load('c_master_kabupaten/add'+'?_=' + (new Date()).getTime());
	});
	
	$( "#sampaimasterKab" )
		.keypress(function(event) {
			var keycode =(event.keyCode?event.keyCode:event.which);	
			if(keycode ==13){
				event.preventDefault();
				$('#listmasterKab').trigger("reloadGrid");
			}
	});
	
	$('#darimasterKab').datepicker({dateFormat: "dd-mm-yy",changeYear: true,onSelect: function(dateText, inst){$('#sampaimasterKab').datepicker('option', 'minDate', dateText);$.datepicker._clearDate('#sampaimasterKab');}});
	$('#sampaimasterKab').datepicker({dateFormat: "dd-mm-yy",changeYear: true,onClose: function(dateText, inst){$('#listmasterKab').trigger("reloadGrid");}});
	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	$("#resetmasterKab").live('click', function(event){
		event.preventDefault();
		$('#formmasterKab').reset();
		$('#listmasterKab').trigger("reloadGrid");
	});
	$("#carimasterKab").live('click', function(event){
		event.preventDefault();
		$('#listmasterKab').trigger("reloadGrid");
	});
})