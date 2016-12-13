jQuery().ready(function (){ 
	jQuery("#listrmrstr").jqGrid({ 
		url:'t_k_rm_restoran/rmrestoranxml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['id','Nama RM/Restoran','Karyawan','Pengunjung','No Izin Usaha','Nilai','Action'],
		rownumbers:true,
		width: 1021,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[ 
				{name:'id',index:'id', width:25,align:'center',hidden:true}, 
				{name:'namarm',index:'rm', width:100}, 
				{name:'Karyawan',index:'ky', width:25,align:'center'}, 
				{name:'Pengunjung',index:'pj', width:25,align:'center'}, 
				{name:'noijin',index:'rw', width:75,align:'center'}, 
				{name:'Nilai',index:'nilai', width:25,align:'center'}, 
				{name:'myid',index:'myid', width:91,align:'center',formatter:formatterAction}
			],
			rowNum:10, 
			rowList:[10,20,30], 
			pager: jQuery('#pagerrmrstr'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				dari=$('#darirmrstr').val()?$('#darirmrstr').val():'';
				sampai=$('#sampairmrstr').val()?$('#sampairmrstr').val():'';
				carinama=$('#carinamarmrstr').val()?$('#carinamarmrstr').val():'';
				$('#listrmrstr').setGridParam({postData:{'dari':dari,'sampai':sampai,'carinama':carinama}})
			}
	}).navGrid('#pagerrmrstr',{edit:false,add:false,del:false,search:false});
	
	function formatterAction(cellvalue, options, rowObject) {
		var content = '';
		content  += '<a rel="' + cellvalue + '" class="icon-detail"  title="View"></a> ';
		content  += '<a rel="' + cellvalue + '" class="icon-edit" title="Edit?"></a>';
		content  += '<a rel="' + cellvalue + '" class="icon-delete" title="Remove?"></a>';
		return content;
	}
	
	$("#listrmrstr .icon-detail").live('click', function(f){
		if($(f.target).data('oneclicked')!='yes')
		{
			$("#t462","#tabs").empty();
			$("#t462","#tabs").load('t_k_rm_restoran/detail'+'?id='+this.rel);
		}
		$(f.target).data('oneclicked','yes');
	});
	
	$("#listrmrstr .icon-edit").live('click', function(f){
		if($(f.target).data('oneclicked')!='yes')
		{
			$("#t462","#tabs").empty();
			$("#t462","#tabs").load('t_k_rm_restoran/edit'+'?id='+this.rel);
		}
		$(f.target).data('oneclicked','yes');		
	});
	
	function deldata(myid){
		achtungShowLoader();
		$.ajax({
			  url: 't_k_rm_restoran/delete',
			  type: "post",
			  data: {id:myid},
			  dataType: "json",
			  success: function(msg){
				if(msg == 'OK'){
					$("#dialogrmrstr").dialog("close");
					$.achtung({message: 'Proses Hapus Data Berhasil', timeout:5});
					$('#listrmrstr').trigger("reloadGrid");							
				}
				else{						
					$("#dialogrmrstr").dialog("close");
					$.achtung({message: 'Maaf Proses Hapus Data Gagal', timeout:5});
				}						
			  }
		  });
		achtungHideLoader();
	}
	
	$("#listrmrstr .icon-delete").live('click', function(){
		var myid= this.rel;
		$("#dialogrmrstr").dialog({
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
		
		$("#dialogrmrstr").dialog("open");
	});
	
	$('form').resize(function(e) {
		if($("#listrmrstr").getGridParam("records")>0){
		jQuery('#listrmrstr').setGridWidth(($(this).width()-28));
		}
	});
	
	function formattermou(cellvalue, options, rowObject) {
		var content = '';
		if(cellvalue){		
			content  += '<a href="tmp/t_k_rm_restoran/' + cellvalue + '" style="color:blue;cursor:pointer" title="">download</a>';
		}else{
			content  += ' - ';
		}
		return content;
	}
	
	$('#rmrstradd').click(function(){
		$("#t462","#tabs").empty();
		$("#t462","#tabs").load('t_k_rm_restoran/add'+'?_=' + (new Date()).getTime());
	});
	
	$( "#sampairmrstr" )
		.keypress(function(event) {
			var keycode =(event.keyCode?event.keyCode:event.which);	
			if(keycode ==13){
				event.preventDefault();
				$('#listrmrstr').trigger("reloadGrid");
			}
	});
	
	$('#darirmrstr').datepicker({dateFormat: "dd-mm-yy",changeYear: true,onSelect: function(dateText, inst){$('#sampairmrstr').datepicker('option', 'minDate', dateText);$.datepicker._clearDate('#sampairmrstr');}});
	$('#sampairmrstr').datepicker({dateFormat: "dd-mm-yy",changeYear: true,onClose: function(dateText, inst){$('#listrmrstr').trigger("reloadGrid");}});
	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	$("#resetrmrstr").live('click', function(event){
		event.preventDefault();
		$('#formrmrstr').reset();
		$('#listrmrstr').trigger("reloadGrid");
	});
	$("#carirmrstr").live('click', function(event){
		event.preventDefault();
		$('#listrmrstr').trigger("reloadGrid");
	});
})