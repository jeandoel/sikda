<script>
jQuery().ready(function (){ 
	jQuery("#listmasterstatuskeluargapopup").jqGrid({ 
		url:'c_master_status_keluarga/statuskeluargaxml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['ID','Status Keluarga','Keterangan','Tgl Master','Action'],
		rownumbers:true,
		width: 1021,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[ 
				{name:'id',index:'id', width:15,align:'center',hidden:false,formatter:formatterAction}, 
				{name:'status_keluarga',index:'status_keluarga', width:100}, 
				{name:'keterangan',index:'keterangan', width:155},
				{name:'tgl_masterstatuskeluarga',index:'tgl_masterstatuskeluarga', width:75,align:'center'},
				{name:'myid',index:'myid', width:91,align:'center',hidden:true}
			],
			rowNum:10, 
			rowList:[10,20,30], 
			pager: jQuery('#pagermasterstatuskeluargapopup'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				dari=$('#darimasterstatuskeluargapopup').val()?$('#darimasterstatuskeluargapopup').val():'';
				sampai=$('#sampaimasterstatuskeluargapopup').val()?$('#sampaimasterstatuskeluargapopup').val():'';
				$('#listmasterstatuskeluargapopup').setGridParam({postData:{'dari':dari,'sampai':sampai}})
			}
	}).navGrid('#pagermasterstatuskeluargapopup',{edit:false,add:false,del:false,search:false});
	
	function formatterAction(cellvalue, options, rowObject) {
		var content = '';
		return '<input type="checkbox" class="chk" name="chk[]" />';
		return content;
	}	
	
	$(".chk").live('click', function(){		
		$("#listmasterstatuskeluargapopup").find('input[type=checkbox]').each(function() {
			$(this).change( function(){
				var colid = $(this).parents('tr:last').attr('id');
				if( $(this).is(':checked')) {
					$("#listmasterstatuskeluargapopup").jqGrid('setSelection', colid );
					$(this).prop('checked',true);
					var myCellDataId = jQuery('#listmasterstatuskeluargapopup').jqGrid('getCell', colid, 'myid');
					var myCellDatastatuskeluarga = jQuery('#listmasterstatuskeluargapopup').jqGrid('getCell', colid, 'status_keluarga');
					$('#<?=$id_caller?> #column_master_status_keluarga_hidden').val(myCellDataId);
					$('#<?=$id_caller?> #column_master_status_keluarga').val(myCellDatastatuskeluarga);
					$("#dialogmasterstatuskeluarga_cari_column").dialog("close");
				}
			});	
		});
	});
	
	$('form').resize(function(e) {
		if($("#listmasterstatuskeluargapopup").getGridParam("records")>0){
		jQuery('#listmasterstatuskeluargapopup').setGridWidth(($(this).width()));
		}
	});
	
})
</script>

<div class="mycontent">
	<form id="formmasterstatuskeluargapopup">
		<table id="listmasterstatuskeluargapopup"></table>
		<div id="pagermasterstatuskeluargapopup"></div>
		</div >
	</form>
</div>