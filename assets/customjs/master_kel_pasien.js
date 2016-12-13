jQuery().ready(function (){ 
	jQuery("#listkelpasien").jqGrid({ 
		url:'c_master_kel_pasien/kelpasienxml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
			colNames:['KODE CUSTOMER/KELOMPOK','CUSTOMER/KELOMPOK','TELEPON','Action'],
		rownumbers:true,
		width: 1021,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[ 
				{name:'kd_cus',index:'kd_cus', width:80}, 
				{name:'cus',index:'cus', width:80},	
				{name:'tlp1',index:'tlp1', width:80},
				{name:'x',index:'x', width:100,align:'center',formatter:formatterAction}
			],
			rowNum:10, 
			rowList:[10,20,30], 
			pager: jQuery('#pagerkelpasien'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				dari=$('#darikelpasien').val()?$('#darikelpasien').val():'';
				sampai=$('#sampaikelpasien').val()?$('#sampaikelpasien').val():'';
				nama=$('#namakelpasien').val()?$('#namakelpasien').val():'';
				$('#listkelpasien').setGridParam({postData:{'dari':dari,'sampai':sampai,'nama':nama}})
			}
	}).navGrid('#pagerkelpasien',{edit:false,add:false,del:false,search:false});
	
	function formatterAction(cellvalue, options, rowObject) {
		var content = '';
		content  += '<a rel="' + cellvalue + '" class="icon-detail" title="View"></a> ';
		content  += '<a rel="' + cellvalue + '" class="icon-edit" title="Edit?"></a>';
		content  += '<a rel="' + cellvalue + '" class="icon-delete" title="Remove?"></a>';
		return content;
	}
	
	$("#listkelpasien .icon-detail").live('click', function(j){
		if($(j.target).data('oneclicked')!='yes')
		{
			$("#t67","#tabs").empty();
			$("#t67","#tabs").load('c_master_kel_pasien/detail'+'?kd_cus='+this.rel);
		}
		$(j.target).data('oneclicked','yes');
	});
	
	$("#listkelpasien .icon-edit").live('click', function(j){
		if($(j.target).data('oneclicked')!='yes')
		{
			$("#t67","#tabs").empty();
			$("#t67","#tabs").load('c_master_kel_pasien/edit'+'?kd_cus='+this.rel);
		}
		$(j.target).data('oneclicked','yes');
	});
	
	
	function deldata(myid){
		achtungShowLoader();
		$.ajax({
			  url: 'c_master_kel_pasien/delete',
			  type: "post",
			  data: {id:myid},
			  dataType: "json",
			  success: function(msg){
				if(msg == 'OK'){
					$("#dialogkelpasien").dialog("close");
					$.achtung({message: 'Proses Hapus Data Berhasil', timeout:5});
					$('#listkelpasien').trigger("reloadGrid");							
				}
				else{						
					$("#dialogkelpasien").dialog("close");
					$.achtung({message: 'Maaf Proses Hapus Data Gagal', timeout:5});
				}						
			  }
		  });
		achtungHideLoader();
	}
	
	$(" .icon-delete").live('click', function(){
		var myid= this.rel;
		$("#dialogkelpasien").dialog({
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
		
		$("#dialogkelpasien").dialog("open");
	});
	
	$('form').resize(function(b) {
		if($("#listkelpasien").getGridParam("records")>0){
		jQuery('#listkelpasien').setGridWidth(($(this).width()-28));
		}
	});
	
	function formattermou(cellvalue, options, rowObject) {
		var content = '';
		if(cellvalue){		
			content  += '<a href="tmp/kel_pasien/' + cellvalue + '" style="color:blue;cursor:pointer" title="">download</a>';
		}else{
			content  += ' - ';
		}
		return content;
	}
	
	$('#kelpasienadd').click(function(){
		$("#t67","#tabs").empty();
		$("#t67","#tabs").load('c_master_kel_pasien/add'+'?_=' + (new Date()).getTime());
	});
	
	$( "#sampaikelpasien" )
		.keypress(function(event) {
			var keycode =(event.keyCode?event.keyCode:event.which);	
			if(keycode ==13){
				event.preventDefault();
				$('#listkelpasien').trigger("reloadGrid");
			}
	});
	$( "#namakelpasien" )
		.keypress(function(event) {
			var keycode =(event.keyCode?event.keyCode:event.which);	
			if(keycode ==13){
				event.preventDefault();
				$('#listkelpasien').trigger("reloadGrid");
			}
	});
	$('#darikelpasien').datepicker({dateFormat: "dd-mm-yy",changeYear: true,onSelect: function(dateText, inst){$('#sampaikelpasien').datepicker('option', 'minDate', dateText);$.datepicker._clearDate('#sampaikelpasien');}});
	$('#sampaikelpasien').datepicker({dateFormat: "dd-mm-yy",changeYear: true,onClose: function(dateText, inst){$('#listkelpasien').trigger("reloadGrid");}});
	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	$("#resetkelpasien").live('click', function(event){
		event.preventDefault();
		$('#formmkelpasien').reset();
		$('#listkelpasien').trigger("reloadGrid");
	});
	$("#carikelpasien").live('click', function(event){
		event.preventDefault();
		$('#listkelpasien').trigger("reloadGrid");
	});
})