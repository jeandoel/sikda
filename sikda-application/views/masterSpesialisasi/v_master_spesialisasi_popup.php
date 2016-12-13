<script>
jQuery().ready(function (){ 
	jQuery("#listmaster1popup").jqGrid({ 
		url:'master1/master1xml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['ID','Column1','Column2','Column3','Tgl. Master1','Action'],
		rownumbers:true,
		width: 1021,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[ 
				{name:'id',index:'id', width:15,align:'center',hidden:false,formatter:formatterAction}, 
				{name:'column1',index:'column1', width:100}, 
				{name:'column2',index:'column2', width:155,hidden:true}, 
				{name:'column3',index:'column3', width:99,hidden:true},
				{name:'tgl_master1popup',index:'tgl_master1popup', width:75,align:'center'},
				{name:'myid',index:'myid', width:91,align:'center',hidden:true}
			],
			rowNum:10, 
			rowList:[10,20,30], 
			pager: jQuery('#pagermaster1popup'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				dari=$('#darimaster1popup').val()?$('#darimaster1popup').val():'';
				sampai=$('#sampaimaster1popup').val()?$('#sampaimaster1popup').val():'';
				$('#listmaster1popup').setGridParam({postData:{'dari':dari,'sampai':sampai}})
			}
	}).navGrid('#pagermaster1popup',{edit:false,add:false,del:false,search:false});
	
	function formatterAction(cellvalue, options, rowObject) {
		var content = '';
		return '<input type="checkbox" class="chk" name="chk[]" />';
		return content;
	}	
	
	$(".chk").live('click', function(){		
		$("#listmaster1popup").find('input[type=checkbox]').each(function() {
			$(this).change( function(){
				var colid = $(this).parents('tr:last').attr('id');
				if( $(this).is(':checked')) {
					$("#listmaster1popup").jqGrid('setSelection', colid );
					$(this).prop('checked',true);
					var myCellDataId = jQuery('#listmaster1popup').jqGrid('getCell', colid, 'myid');
					var myCellDataColumn1 = jQuery('#listmaster1popup').jqGrid('getCell', colid, 'column1');
					$('#<?=$id_caller?> #column_master_1_hidden').val(myCellDataId);
					$('#<?=$id_caller?> #column_master_1').val(myCellDataColumn1);
					$("#dialogtransaksi1_cari_column").dialog("close");
				}
			});	
		});
	});
	
	$('form').resize(function(e) {
		if($("#listmaster1popup").getGridParam("records")>0){
		jQuery('#listmaster1popup').setGridWidth(($(this).width()));
		}
	});
	
})
</script>

<div class="mycontent">
	<form id="formmaster1popup">
		<table id="listmaster1popup"></table>
		<div id="pagermaster1popup"></div>
		</div >
	</form>
</div>