jQuery().ready(function (){ 
	jQuery("#listmasterDokter").jqGrid({ 
		url:'c_master_dokter/masterdokterxml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['KODE','id1','Nama','NIP','Jabatan','Status','Kode Puskesmas','Action'],
		rownumbers:true,
		width: 1021,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[ 
				{name:'id',index:'id', width:25,align:'center'}, 
				{name:'id1',index:'id1', width:25,align:'center',hidden:true}, 
				{name:'nama',index:'nama', width:100}, 
				{name:'nip',index:'nip', width:100}, 
				{name:'jab',index:'jab', width:100}, 
				{name:'sts',index:'sts', width:100}, 
				{name:'kdpus',index:'kdpus', width:100}, 
				{name:'myid',index:'myid', width:91,align:'center',formatter:formatterAction}
			],
			rowNum:10, 
			rowList:[10,20,30], 
			pager: jQuery('#pagermasterDokter'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				dari=$('#darimasterDokter').val()?$('#darimasterDokter').val():'';
				sampai=$('#sampaimasterDokter').val()?$('#sampaimasterDokter').val():'';
				keyword=$('#keywordmasterDokter').val()?$('#keywordmasterDokter').val():'';
				carinama=$('#carinamamasterDokter').val()?$('#carinamamasterDokter').val():'';
				$('#listmasterDokter').setGridParam({postData:{'dari':dari,'sampai':sampai,'keyword':keyword,'carinama':carinama}})
			}
	}).navGrid('#pagermasterDokter',{edit:false,add:false,del:false,search:false});
	
	function formatterAction(cellvalue, options, rowObject) {
		var content = '';
		content  += '<a rel="' + cellvalue + '" class="icon-detail"  title="View"></a> ';
		content  += '<a rel="' + cellvalue + '" class="icon-edit" title="Edit?"></a>';
		content  += '<a rel="' + cellvalue + '" class="icon-delete" title="Remove?"></a>';
		return content;
	}
	
	$("#listmasterDokter .icon-detail").live('click', function(f){
		if($(f.target).data('oneclicked')!='yes')
		{
			$("#t27","#tabs").empty();
			$("#t27","#tabs").load('c_master_dokter/detail'+'?id='+this.rel);
		}
		$(f.target).data('oneclicked','yes');
	});
	
	$("#listmasterDokter .icon-edit").live('click', function(f){
		if($(f.target).data('oneclicked')!='yes')
		{
			$("#t27","#tabs").empty();
			$("#t27","#tabs").load('c_master_dokter/edit'+'?id='+this.rel);
		}
		$(f.target).data('oneclicked','yes');		
	});
	
	function deldata(myid){
		achtungShowLoader();
		$.ajax({
			  url: 'c_master_dokter/delete',
			  type: "post",
			  data: {id:myid},
			  dataType: "json",
			  success: function(msg){
				if(msg == 'OK'){
					$("#dialogmasterDokter").dialog("close");
					$.achtung({message: 'Proses Hapus Data Berhasil', timeout:5});
					$('#listmasterDokter').trigger("reloadGrid");							
				}
				else{						
					$("#dialogmasterDokter").dialog("close");
					$.achtung({message: 'Maaf Proses Hapus Data Gagal', timeout:5});
				}						
			  }
		  });
		achtungHideLoader();
	}
	
	$("#listmasterDokter .icon-delete").live('click', function(){
		var myid= this.rel;
		$("#dialogmasterDokter").dialog({
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
		
		$("#dialogmasterDokter").dialog("open");
	});
	
	$('form').resize(function(e) {
		if($("#listmasterDokter").getGridParam("records")>0){
		jQuery('#listmasterDokter').setGridWidth(($(this).width()-28));
		}
	});
	
	function formattermou(cellvalue, options, rowObject) {
		var content = '';
		if(cellvalue){		
			content  += '<a href="tmp/c_master_dokter/' + cellvalue + '" style="color:blue;cursor:pointer" title="">download</a>';
		}else{
			content  += ' - ';
		}
		return content;
	}
	
	$('#masterDokteradd').click(function(){
		$("#t27","#tabs").empty();
		$("#t27","#tabs").load('c_master_dokter/add'+'?_=' + (new Date()).getTime());
	});
	
	$( "#sampaimasterDokter" )
		.keypress(function(event) {
			var keycode =(event.keyCode?event.keyCode:event.which);	
			if(keycode ==13){
				event.preventDefault();
				$('#listmasterDokter').trigger("reloadGrid");
			}
	});
	
	$('#darimasterDokter').datepicker({dateFormat: "dd-mm-yy",changeYear: true,onSelect: function(dateText, inst){$('#sampaimasterDokter').datepicker('option', 'minDate', dateText);$.datepicker._clearDate('#sampaimasterDokter');}});
	$('#sampaimasterDokter').datepicker({dateFormat: "dd-mm-yy",changeYear: true,onClose: function(dateText, inst){$('#listmasterDokter').trigger("reloadGrid");}});
	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	$("#resetmasterDokter").live('click', function(event){
		event.preventDefault();
		$('#formmasterDokter').reset();
		$('#listmasterDokter').trigger("reloadGrid");
	});
	$("#carimasterDokter").live('click', function(event){
		event.preventDefault();
		$('#listmasterDokter').trigger("reloadGrid");
	});
})