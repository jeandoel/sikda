jQuery().ready(function (){ 
	jQuery("#listrumahsht").jqGrid({ 
		url:'t_k_rumah_sehat/rumahsehatxml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['id','Nama KK','Jumlah Jiwa','RT','RW','Desa','Nilai','Action'],
		rownumbers:true,
		width: 1021,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[ 
				{name:'id',index:'id', width:25,align:'center',hidden:true}, 
				{name:'NamaKK',index:'kk', width:100}, 
				{name:'JumlahJiwa',index:'jj', width:25,align:'center'}, 
				{name:'RT',index:'rt', width:11,align:'center'}, 
				{name:'RW',index:'rw', width:11,align:'center'}, 
				{name:'Desa',index:'desa', width:75,align:'center'}, 
				{name:'Nilai',index:'nilai', width:35,align:'center'}, 
				{name:'myid',index:'myid', width:91,align:'center',formatter:formatterAction}
			],
			rowNum:10, 
			rowList:[10,20,30], 
			pager: jQuery('#pagerrumahsht'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				dari=$('#darirumahsht').val()?$('#darirumahsht').val():'';
				sampai=$('#sampairumahsht').val()?$('#sampairumahsht').val():'';
				carinama=$('#carinamarumahsht').val()?$('#carinamarumahsht').val():'';
				$('#listrumahsht').setGridParam({postData:{'dari':dari,'sampai':sampai,'carinama':carinama}})
			}
	}).navGrid('#pagerrumahsht',{edit:false,add:false,del:false,search:false});
	
	function formatterAction(cellvalue, options, rowObject) {
		var content = '';
		content  += '<a rel="' + cellvalue + '" class="icon-detail"  title="View"></a> ';
		content  += '<a rel="' + cellvalue + '" class="icon-edit" title="Edit?"></a>';
		content  += '<a rel="' + cellvalue + '" class="icon-delete" title="Remove?"></a>';
		return content;
	}
	
	$("#listrumahsht .icon-detail").live('click', function(f){
		if($(f.target).data('oneclicked')!='yes')
		{
			$("#t461","#tabs").empty();
			$("#t461","#tabs").load('t_k_rumah_sehat/detail'+'?id='+this.rel);
		}
		$(f.target).data('oneclicked','yes');
	});
	
	$("#listrumahsht .icon-edit").live('click', function(f){
		if($(f.target).data('oneclicked')!='yes')
		{
			$("#t461","#tabs").empty();
			$("#t461","#tabs").load('t_k_rumah_sehat/edit'+'?id='+this.rel);
		}
		$(f.target).data('oneclicked','yes');		
	});
	
	function deldata(myid){
		achtungShowLoader();
		$.ajax({
			  url: 't_k_rumah_sehat/delete',
			  type: "post",
			  data: {id:myid},
			  dataType: "json",
			  success: function(msg){
				if(msg == 'OK'){
					$("#dialogrumahsht").dialog("close");
					$.achtung({message: 'Proses Hapus Data Berhasil', timeout:5});
					$('#listrumahsht').trigger("reloadGrid");							
				}
				else{						
					$("#dialogrumahsht").dialog("close");
					$.achtung({message: 'Maaf Proses Hapus Data Gagal', timeout:5});
				}						
			  }
		  });
		achtungHideLoader();
	}
	
	$("#listrumahsht .icon-delete").live('click', function(){
		var myid= this.rel;
		$("#dialogrumahsht").dialog({
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
		
		$("#dialogrumahsht").dialog("open");
	});
	
	$('form').resize(function(e) {
		if($("#listrumahsht").getGridParam("records")>0){
		jQuery('#listrumahsht').setGridWidth(($(this).width()-28));
		}
	});
	
	function formattermou(cellvalue, options, rowObject) {
		var content = '';
		if(cellvalue){		
			content  += '<a href="tmp/t_k_rumah_sehat/' + cellvalue + '" style="color:blue;cursor:pointer" title="">download</a>';
		}else{
			content  += ' - ';
		}
		return content;
	}
	
	$('#rumahshtadd').click(function(){
		$("#t461","#tabs").empty();
		$("#t461","#tabs").load('t_k_rumah_sehat/add'+'?_=' + (new Date()).getTime());
	});
	
	$( "#sampairumahsht" )
		.keypress(function(event) {
			var keycode =(event.keyCode?event.keyCode:event.which);	
			if(keycode ==13){
				event.preventDefault();
				$('#listrumahsht').trigger("reloadGrid");
			}
	});
	
	$('#darirumahsht').datepicker({dateFormat: "dd-mm-yy",changeYear: true,onSelect: function(dateText, inst){$('#sampairumahsht').datepicker('option', 'minDate', dateText);$.datepicker._clearDate('#sampairumahsht');}});
	$('#sampairumahsht').datepicker({dateFormat: "dd-mm-yy",changeYear: true,onClose: function(dateText, inst){$('#listrumahsht').trigger("reloadGrid");}});
	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	$("#resetrumahsht").live('click', function(event){
		event.preventDefault();
		$('#formrumahsht').reset();
		$('#listrumahsht').trigger("reloadGrid");
	});
	$("#carirumahsht").live('click', function(event){
		event.preventDefault();
		$('#listrumahsht').trigger("reloadGrid");
	});
})