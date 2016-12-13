jQuery().ready(function (){ 
	jQuery("#listmastervaksin").jqGrid({ 
		url:'mastervaksin/mastervaksinxml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['ID','Kode','Nama','Golongan','Sumber','Satuan','Tgl. Master Vaksin','Action'],
		rownumbers:true,
		width: 1021,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[ 
				{name:'id',index:'id', width:5,hidden:true}, 
				{name:'kolom_kode',index:'kolom_kode', width:100}, 
				{name:'kolom_nama',index:'kolom_nama', width:155}, 
				{name:'kolom_golongan',index:'kolom_golongan', width:99},
				{name:'kolom_sumber',index:'kolom_sumber', width:100}, 
				{name:'kolom_satuan',index:'kolom_satuan', width:155}, 
				{name:'tgl_mastervaksin',index:'tgl_mastervaksin', width:100,align:'center'},
				{name:'x',index:'x', width:91,align:'center',formatter:formatterAction}
			],
			rowNum:10, 
			rowList:[10,20,30], 
			pager: jQuery('#pagermastervaksin'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				dari=$('#darimastervaksin').val()?$('#darimastervaksin').val():'';
				sampai=$('#sampaimastervaksin').val()?$('#sampaimastervaksin').val():'';
				nama=$('#namamastervaksin').val()?$('#namamastervaksin').val():'';
				$('#listmastervaksin').setGridParam({postData:{'dari':dari,'sampai':sampai,'nama':nama}})
			}
	}).navGrid('#pagermastervaksin',{edit:false,add:false,del:false,search:false});
	
	function formatterAction(cellvalue, options, rowObject) {
		var content = '';
		content  += '<a rel="' + cellvalue + '" class="icon-detail"  title="View"></a> ';
		content  += '<a rel="' + cellvalue + '" class="icon-edit" title="Edit?"></a>';
		content  += '<a rel="' + cellvalue + '" class="icon-delete" title="Remove?"></a>';
		return content;
	}
	
	$(".icon-detail").live('click', function(){
		$("#t10","#tabs").empty();
		$("#t10","#tabs").load('mastervaksin/detail'+'?id='+this.rel+ '_=' + (new Date()).getTime());
	});
	
	$(".icon-edit").live('click', function(){
		$("#t10","#tabs").empty();
		$("#t10","#tabs").load('mastervaksin/edit'+'?id='+this.rel);
	});
	
	function deldata(myid){
		achtungShowLoader();
		$.ajax({
			  url: 'mastervaksin/delete',
			  type: "post",
			  data: {id:myid},
			  dataType: "json",
			  success: function(msg){
				if(msg == 'OK'){
					$("#dialog").dialog("close");
					$.achtung({message: 'Proses Hapus Data Berhasil', timeout:5});
					$('#listmastervaksin').trigger("reloadGrid");							
				}
				else{						
					$("#dialog").dialog("close");
					$.achtung({message: 'Maaf Proses Hapus Data Gagal', timeout:5});
				}						
			  }
		  });
		achtungHideLoader();
	}
	
	$(".icon-delete").live('click', function(){
		var myid= this.rel;
		$("#dialog").dialog({
		  buttons : {
			"Confirm" : function() {
				deldata(myid);
				
			},
			"Cancel" : function() {
			  $(this).dialog("close");
			}
		  }
		});
		
		$("#dialog").dialog("open");
	});
	
	$('form').resize(function(e) {
		if($("#listmastervaksin").getGridParam("records")>0){
		jQuery('#listmastervaksin').setGridWidth(($(this).width()-28));
		}
	});
	
	function formattermou(cellvalue, options, rowObject) {
		var content = '';
		if(cellvalue){		
			content  += '<a href="tmp/mastervaksin/' + cellvalue + '" style="color:blue;cursor:pointer" title="">download</a>';
		}else{
			content  += ' - ';
		}
		return content;
	}
	
	$('#mastervaksinadd').click(function(){
		$("#t10","#tabs").empty();
		$("#t10","#tabs").load('mastervaksin/add'+'?_=' + (new Date()).getTime());
	});
	
	$( "#sampaimastervaksin" )
		.keypress(function(event) {
			var keycode =(event.keyCode?event.keyCode:event.which);	
			if(keycode ==13){
				event.preventDefault();
				$('#listmastervaksin').trigger("reloadGrid");
			}
	});
	
	$( "#namamastervaksin" )
		.keypress(function(event) {
			var keycode =(event.keyCode?event.keyCode:event.which);	
			if(keycode ==13){
				event.preventDefault();
				$('#listmastervaksin').trigger("reloadGrid");
			}
	});
	
	$('#darimastervaksin').datepicker({dateFormat: "dd-mm-yy",changeYear: true,onSelect: function(dateText, inst){$('#sampaimastervaksin').datepicker('option', 'minDate', dateText);$.datepicker._clearDate('#sampaimastervaksin');}});
	$('#sampaimastervaksin').datepicker({dateFormat: "dd-mm-yy",changeYear: true,onClose: function(dateText, inst){$('#listmastervaksin').trigger("reloadGrid");}});
	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	$("#resetmastervaksin").live('click', function(event){
		event.preventDefault();
		$('#formmastervaksin').reset();
		$('#listmastervaksin').trigger("reloadGrid");
	});
	$("#carimastervaksin").live('click', function(event){
		event.preventDefault();
		$('#listmastervaksin').trigger("reloadGrid");
	});
})