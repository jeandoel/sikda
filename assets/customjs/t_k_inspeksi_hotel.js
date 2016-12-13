jQuery().ready(function (){ 
	jQuery("#listinspekhtel").jqGrid({ 
		url:'t_k_inspeksi_hotel/inspeksihotelxml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['id','Nama Hotel','No. Telepon','Karyawan','Nilai','Action'],
		rownumbers:true,
		width: 1021,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[ 
				{name:'id',index:'id', width:25,align:'center',hidden:true}, 
				{name:'Namahtl',index:'kk', width:100}, 
				{name:'notelp',index:'jj', width:35,align:'center'}, 
				{name:'kr',index:'rt', width:21,align:'center'}, 
				{name:'nilai',index:'desa', width:35,align:'center'}, 
				{name:'myid',index:'myid', width:91,align:'center',formatter:formatterAction}
			],
			rowNum:10, 
			rowList:[10,20,30], 
			pager: jQuery('#pagerinspekhtel'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				dari=$('#dariinspekhtel').val()?$('#dariinspekhtel').val():'';
				sampai=$('#sampaiinspekhtel').val()?$('#sampaiinspekhtel').val():'';
				carinama=$('#carinamainspekhtel').val()?$('#carinamainspekhtel').val():'';
				$('#listinspekhtel').setGridParam({postData:{'dari':dari,'sampai':sampai,'carinama':carinama}})
			}
	}).navGrid('#pagerinspekhtel',{edit:false,add:false,del:false,search:false});
	
	function formatterAction(cellvalue, options, rowObject) {
		var content = '';
		content  += '<a rel="' + cellvalue + '" class="icon-detail"  title="View"></a> ';
		content  += '<a rel="' + cellvalue + '" class="icon-edit" title="Edit?"></a>';
		content  += '<a rel="' + cellvalue + '" class="icon-delete" title="Remove?"></a>';
		return content;
	}
	
	$("#listinspekhtel .icon-detail").live('click', function(f){
		if($(f.target).data('oneclicked')!='yes')
		{
			$("#t464","#tabs").empty();
			$("#t464","#tabs").load('t_k_inspeksi_hotel/detail'+'?id='+this.rel);
		}
		$(f.target).data('oneclicked','yes');
	});
	
	$("#listinspekhtel .icon-edit").live('click', function(f){
		if($(f.target).data('oneclicked')!='yes')
		{
			$("#t464","#tabs").empty();
			$("#t464","#tabs").load('t_k_inspeksi_hotel/edit'+'?id='+this.rel);
		}
		$(f.target).data('oneclicked','yes');		
	});
	
	function deldata(myid){
		achtungShowLoader();
		$.ajax({
			  url: 't_k_inspeksi_hotel/delete',
			  type: "post",
			  data: {id:myid},
			  dataType: "json",
			  success: function(msg){
				if(msg == 'OK'){
					$("#dialoginspekhtel").dialog("close");
					$.achtung({message: 'Proses Hapus Data Berhasil', timeout:5});
					$('#listinspekhtel').trigger("reloadGrid");							
				}
				else{						
					$("#dialoginspekhtel").dialog("close");
					$.achtung({message: 'Maaf Proses Hapus Data Gagal', timeout:5});
				}						
			  }
		  });
		achtungHideLoader();
	}
	
	$("#listinspekhtel .icon-delete").live('click', function(){
		var myid= this.rel;
		$("#dialoginspekhtel").dialog({
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
		
		$("#dialoginspekhtel").dialog("open");
	});
	
	$('form').resize(function(e) {
		if($("#listinspekhtel").getGridParam("records")>0){
		jQuery('#listinspekhtel').setGridWidth(($(this).width()-28));
		}
	});
	
	function formattermou(cellvalue, options, rowObject) {
		var content = '';
		if(cellvalue){		
			content  += '<a href="tmp/t_k_inspeksi_hotel/' + cellvalue + '" style="color:blue;cursor:pointer" title="">download</a>';
		}else{
			content  += ' - ';
		}
		return content;
	}
	
	$('#inspekhteladd').click(function(){
		$("#t464","#tabs").empty();
		$("#t464","#tabs").load('t_k_inspeksi_hotel/add'+'?_=' + (new Date()).getTime());
	});
	
	$( "#sampaiinspekhtel" )
		.keypress(function(event) {
			var keycode =(event.keyCode?event.keyCode:event.which);	
			if(keycode ==13){
				event.preventDefault();
				$('#listinspekhtel').trigger("reloadGrid");
			}
	});
	
	$('#dariinspekhtel').datepicker({dateFormat: "dd-mm-yy",changeYear: true,onSelect: function(dateText, inst){$('#sampaiinspekhtel').datepicker('option', 'minDate', dateText);$.datepicker._clearDate('#sampaiinspekhtel');}});
	$('#sampaiinspekhtel').datepicker({dateFormat: "dd-mm-yy",changeYear: true,onClose: function(dateText, inst){$('#listinspekhtel').trigger("reloadGrid");}});
	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	$("#resetinspekhtel").live('click', function(event){
		event.preventDefault();
		$('#forminspekhtel').reset();
		$('#listinspekhtel').trigger("reloadGrid");
	});
	$("#cariinspekhtel").live('click', function(event){
		event.preventDefault();
		$('#listinspekhtel').trigger("reloadGrid");
	});
})