<script>
jQuery().ready(function (){ 
	jQuery("#listmaster1popup2").jqGrid({ 
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
				{name:'tgl_master1popup2',index:'tgl_master1popup2', width:75,align:'center'},
				{name:'myid',index:'myid', width:91,align:'center',hidden:true}
			],
			rowNum:10, 
			rowList:[10,20,30], 
			pager: jQuery('#pagermaster1popup2'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				dari=$('#darimaster1popup2').val()?$('#darimaster1popup2').val():'';
				sampai=$('#sampaimaster1popup2').val()?$('#sampaimaster1popup2').val():'';
				$('#listmaster1popup2').setGridParam({postData:{'dari':dari,'sampai':sampai}})
			}
	}).navGrid('#pagermaster1popup2',{edit:false,add:false,del:false,search:false});
	
	function formatterAction(cellvalue, options, rowObject) {
		var content = '';
		return '<input type="checkbox" class="chk" name="chk[]" />';
		return content;
	}	
	
	$(".chk").live('click', function(){		
		$("#listmaster1popup2").find('input[type=checkbox]').each(function() {
			$(this).change( function(){
				var colid = $(this).parents('tr:last').attr('id');
				if( $(this).is(':checked')) {
					$("#listmaster1popup2").jqGrid('setSelection', colid );
					$(this).prop('checked',true);
					var myCellDataId = jQuery('#listmaster1popup2').jqGrid('getCell', colid, 'myid');
					var myCellDataColumn1 = jQuery('#listmaster1popup2').jqGrid('getCell', colid, 'column1');
					$('#<?=$id_caller?> #column_master_1_hidden_b').val(myCellDataId);
					$('#<?=$id_caller?> #column_master_1b').val(myCellDataColumn1);
					$("#dialogtransaksi1_cari_column_b").dialog("close");
				}
			});	
		});
	});
	
	$('form').resize(function(e) {
		if($("#listmaster1popup2").getGridParam("records")>0){
		jQuery('#listmaster1popup2').setGridWidth(($(this).width()));
		}
	});
	
})
</script>

<div class="mycontent">
	<form id="formmaster1popup2">
		<table id="listmaster1popup2"></table>
		<div id="pagermaster1popup2"></div>
		</div >
	</form>
</div>