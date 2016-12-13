<script>
jQuery().ready(function (){ 
	jQuery("#listicdpopup").jqGrid({ 
		url:'c_master_icd/icdxml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['Kode Penyakit','Kode ICD Induk','Penyakit','Description','Action'],
		rownumbers:true,
		width: 1021,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[ 
				{name:'kd',index:'kd', width:99}, 
				{name:'kd_icd_induk',index:'kd_icd_induk', width:99},
				{name:'penyakit',index:'penyakit', width:99},
				{name:'description',index:'description', width:99},
				{name:'x',index:'x', width:110,align:'center',formatter:formatterAction}
			],
			rowNum:10, 
			rowList:[10,20,30], 
			pager: jQuery('#pagermastericd'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				dari=$('#darimasterstatuskeluargapopup').val()?$('#darimasterstatuskeluargapopup').val():'';
				sampai=$('#sampaimasterstatuskeluargapopup').val()?$('#sampaimasterstatuskeluargapopup').val():'';
				$('#listicdpopup').setGridParam({postData:{'dari':dari,'sampai':sampai}})
			}
	}).navGrid('#pagermastericd',{edit:false,add:false,del:false,search:false});
	
	function formatterAction(cellvalue, options, rowObject) {
		var content = '';
		return '<input type="checkbox" class="chk" name="chk[]" />';
		return content;
	}	
	
	$(".chk").live('click', function(){		
		$("#listicdpopup").find('input[type=checkbox]').each(function() {
			$(this).change( function(){
				var colid = $(this).parents('tr:last').attr('id');
				if( $(this).is(':checked')) {
					$("#listicdpopup").jqGrid('setSelection', colid );
					$(this).prop('checked',true);
					var myCellDataId = jQuery('#listicdpopup').jqGrid('getCell', colid, 'myid');
					var myCellDatastatuskeluarga = jQuery('#listicdpopup').jqGrid('getCell', colid, 'status_keluarga');
					$('#<?=$id_caller?> #id_master_icd_hidden').val(myCellDataId);
					$('#<?=$id_caller?> #master_icd').val(myCellDatastatuskeluarga);
					$("#dialaog_master_icd").dialog("close");
				}
			});	
		});
	});
	
	$('form').resize(function(e) {
		if($("#listicdpopup").getGridParam("records")>0){
		jQuery('#listicdpopup').setGridWidth(($(this).width()));
		}
	});
	
})
</script>

<div class="mycontent">
	<form id="formmastericd">
		<table id="listicdpopup"></table>
		<div id="pagermastericd"></div>
		</div >
	</form>
</div>