jQuery().ready(function (){ 
	jQuery("#listinpeksipsr").jqGrid({ 
		url:'t_k_inspeksi_pasar/inspeksipasarxml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['id','Nama Pasar','Jumlah Pedagang','Jumlah Kios','Jumlah Asosiasi','Nilai','Action'],
		rownumbers:true,
		width: 1021,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[ 
				{name:'id',index:'id', width:25,align:'center',hidden:true}, 
				{name:'namapasar',index:'kk', width:75}, 
				{name:'jumlahpedagang',index:'jj', width:35,align:'center'}, 
				{name:'jumlahkios',index:'rt', width:35,align:'center'}, 
				{name:'jumlahasosiasi',index:'rw', width:35,align:'center'}, 
				{name:'Nimail',index:'desa', width:35,align:'center'}, 
				{name:'myid',index:'myid', width:91,align:'center',formatter:formatterAction}
			],
			rowNum:10, 
			rowList:[10,20,30], 
			pager: jQuery('#pagerinpeksipsr'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				dari=$('#dariinpeksipsr').val()?$('#dariinpeksipsr').val():'';
				sampai=$('#sampaiinpeksipsr').val()?$('#sampaiinpeksipsr').val():'';
				carinama=$('#carinamainpeksipsr').val()?$('#carinamainpeksipsr').val():'';
				$('#listinpeksipsr').setGridParam({postData:{'dari':dari,'sampai':sampai,'carinama':carinama}})
			}
	}).navGrid('#pagerinpeksipsr',{edit:false,add:false,del:false,search:false});
	
	function formatterAction(cellvalue, options, rowObject) {
		var content = '';
		content  += '<a rel="' + cellvalue + '" class="icon-detail"  title="View"></a> ';
		content  += '<a rel="' + cellvalue + '" class="icon-edit" title="Edit?"></a>';
		content  += '<a rel="' + cellvalue + '" class="icon-delete" title="Remove?"></a>';
		return content;
	}
	
	$("#listinpeksipsr .icon-detail").live('click', function(f){
		if($(f.target).data('oneclicked')!='yes')
		{
			$("#t463","#tabs").empty();
			$("#t463","#tabs").load('t_k_inspeksi_pasar/detail'+'?id='+this.rel);
		}
		$(f.target).data('oneclicked','yes');
	});
	
	$("#listinpeksipsr .icon-edit").live('click', function(f){
		if($(f.target).data('oneclicked')!='yes')
		{
			$("#t463","#tabs").empty();
			$("#t463","#tabs").load('t_k_inspeksi_pasar/edit'+'?id='+this.rel);
		}
		$(f.target).data('oneclicked','yes');		
	});
	
	function deldata(myid){
		achtungShowLoader();
		$.ajax({
			  url: 't_k_inspeksi_pasar/delete',
			  type: "post",
			  data: {id:myid},
			  dataType: "json",
			  success: function(msg){
				if(msg == 'OK'){
					$("#dialoginpeksipsr").dialog("close");
					$.achtung({message: 'Proses Hapus Data Berhasil', timeout:5});
					$('#listinpeksipsr').trigger("reloadGrid");							
				}
				else{						
					$("#dialoginpeksipsr").dialog("close");
					$.achtung({message: 'Maaf Proses Hapus Data Gagal', timeout:5});
				}						
			  }
		  });
		achtungHideLoader();
	}
	
	$("#listinpeksipsr .icon-delete").live('click', function(){
		var myid= this.rel;
		$("#dialoginpeksipsr").dialog({
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
		
		$("#dialoginpeksipsr").dialog("open");
	});
	
	$('form').resize(function(e) {
		if($("#listinpeksipsr").getGridParam("records")>0){
		jQuery('#listinpeksipsr').setGridWidth(($(this).width()-28));
		}
	});
	
	function formattermou(cellvalue, options, rowObject) {
		var content = '';
		if(cellvalue){		
			content  += '<a href="tmp/t_k_inspeksi_pasar/' + cellvalue + '" style="color:blue;cursor:pointer" title="">download</a>';
		}else{
			content  += ' - ';
		}
		return content;
	}
	
	$('#inpeksipsradd').click(function(){
		$("#t463","#tabs").empty();
		$("#t463","#tabs").load('t_k_inspeksi_pasar/add'+'?_=' + (new Date()).getTime());
	});
	
	$( "#sampaiinpeksipsr" )
		.keypress(function(event) {
			var keycode =(event.keyCode?event.keyCode:event.which);	
			if(keycode ==13){
				event.preventDefault();
				$('#listinpeksipsr').trigger("reloadGrid");
			}
	});
	
	$('#dariinpeksipsr').datepicker({dateFormat: "dd-mm-yy",changeYear: true,onSelect: function(dateText, inst){$('#sampaiinpeksipsr').datepicker('option', 'minDate', dateText);$.datepicker._clearDate('#sampaiinpeksipsr');}});
	$('#sampaiinpeksipsr').datepicker({dateFormat: "dd-mm-yy",changeYear: true,onClose: function(dateText, inst){$('#listinpeksipsr').trigger("reloadGrid");}});
	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	$("#resetinpeksipsr").live('click', function(event){
		event.preventDefault();
		$('#forminpeksipsr').reset();
		$('#listinpeksipsr').trigger("reloadGrid");
	});
	$("#cariinpeksipsr").live('click', function(event){
		event.preventDefault();
		$('#listinpeksipsr').trigger("reloadGrid");
	});
})