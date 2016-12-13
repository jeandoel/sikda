jQuery().ready(function (){ 
	jQuery("#listpsynd").jqGrid({ 
		url:'t_posyandu/posyanduxml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['id','Nama Posyandu','Jumlah Kader','RT','RW','Desa','Action'],
		rownumbers:true,
		width: 1021,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[ 
				{name:'id',index:'id', width:25,align:'center',hidden:true}, 
				{name:'NamaKK',index:'kk', width:100}, 
				{name:'Jumlahkder',index:'jj', width:25,align:'center'}, 
				{name:'RT',index:'rt', width:11,align:'center'}, 
				{name:'RW',index:'rw', width:11,align:'center'}, 
				{name:'Desa',index:'desa', width:75,align:'center'}, 
				{name:'myid',index:'myid', width:91,align:'center',formatter:formatterAction}
			],
			rowNum:10, 
			rowList:[10,20,30], 
			pager: jQuery('#pagerpsynd'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				dari=$('#daripsynd').val()?$('#daripsynd').val():'';
				sampai=$('#sampaipsynd').val()?$('#sampaipsynd').val():'';
				carinama=$('#carinamapsynd').val()?$('#carinamapsynd').val():'';
				$('#listpsynd').setGridParam({postData:{'dari':dari,'sampai':sampai,'carinama':carinama}})
			}
	}).navGrid('#pagerpsynd',{edit:false,add:false,del:false,search:false});
	
	function formatterAction(cellvalue, options, rowObject) {
		var content = '';
		content  += '<a rel="' + cellvalue + '" class="icon-detail"  title="View"></a> ';
		content  += '<a rel="' + cellvalue + '" class="icon-edit" title="Edit?"></a>';
		content  += '<a rel="' + cellvalue + '" class="icon-delete" title="Remove?"></a>';
		return content;
	}
	
	$("#listpsynd .icon-detail").live('click', function(f){
		if($(f.target).data('oneclicked')!='yes')
		{
			$("#t472","#tabs").empty();
			$("#t472","#tabs").load('t_posyandu/detail'+'?id='+this.rel);
		}
		$(f.target).data('oneclicked','yes');
	});
	
	$("#listpsynd .icon-edit").live('click', function(f){
		if($(f.target).data('oneclicked')!='yes')
		{
			$("#t472","#tabs").empty();
			$("#t472","#tabs").load('t_posyandu/edit'+'?id='+this.rel);
		}
		$(f.target).data('oneclicked','yes');		
	});
	
	function deldata(myid){
		achtungShowLoader();
		$.ajax({
			  url: 't_posyandu/delete',
			  type: "post",
			  data: {id:myid},
			  dataType: "json",
			  success: function(msg){
				if(msg == 'OK'){
					$("#dialogpsynd").dialog("close");
					$.achtung({message: 'Proses Hapus Data Berhasil', timeout:5});
					$('#listpsynd').trigger("reloadGrid");							
				}
				else{						
					$("#dialogpsynd").dialog("close");
					$.achtung({message: 'Maaf Proses Hapus Data Gagal', timeout:5});
				}						
			  }
		  });
		achtungHideLoader();
	}
	
	$("#listpsynd .icon-delete").live('click', function(){
		var myid= this.rel;
		$("#dialogpsynd").dialog({
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
		
		$("#dialogpsynd").dialog("open");
	});
	
	$('form').resize(function(e) {
		if($("#listpsynd").getGridParam("records")>0){
		jQuery('#listpsynd').setGridWidth(($(this).width()-28));
		}
	});
	
	function formattermou(cellvalue, options, rowObject) {
		var content = '';
		if(cellvalue){		
			content  += '<a href="tmp/t_posyandu/' + cellvalue + '" style="color:blue;cursor:pointer" title="">download</a>';
		}else{
			content  += ' - ';
		}
		return content;
	}
	
	$('#psyndadd').click(function(){
		$("#t472","#tabs").empty();
		$("#t472","#tabs").load('t_posyandu/add'+'?_=' + (new Date()).getTime());
	});
	
	$( "#sampaipsynd" )
		.keypress(function(event) {
			var keycode =(event.keyCode?event.keyCode:event.which);	
			if(keycode ==13){
				event.preventDefault();
				$('#listpsynd').trigger("reloadGrid");
			}
	});
	
	$('#daripsynd').datepicker({dateFormat: "dd-mm-yy",changeYear: true,onSelect: function(dateText, inst){$('#sampaipsynd').datepicker('option', 'minDate', dateText);$.datepicker._clearDate('#sampaipsynd');}});
	$('#sampaipsynd').datepicker({dateFormat: "dd-mm-yy",changeYear: true,onClose: function(dateText, inst){$('#listpsynd').trigger("reloadGrid");}});
	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	$("#resetpsynd").live('click', function(event){
		event.preventDefault();
		$('#formpsynd').reset();
		$('#listpsynd').trigger("reloadGrid");
	});
	$("#caripsynd").live('click', function(event){
		event.preventDefault();
		$('#listpsynd').trigger("reloadGrid");
	});
})