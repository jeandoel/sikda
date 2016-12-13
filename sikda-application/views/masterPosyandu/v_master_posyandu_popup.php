<script>
jQuery().ready(function (){ 
	jQuery("#listposyandupopup").jqGrid({ 
		url:'c_master_posyandu/posyanduxml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['ID','Kode Posyandu','Nama Posyandu','Alamat', 'Jumlah Kader','Tanggal','Action'],
		rownumbers:true,
		width: 1021,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[ 
				{name:'id',index:'id', width:10,align:'center',hidden:false,formatter:formatterAction}, 
				{name:'kodeposyandu',index:'kodeposyandu', width:50}, 
				{name:'namaposyandu',index:'namaposyandu', width:90}, 
				{name:'alamatposyandu',index:'alamatposyandu', width:120},
				{name:'jumlahkader',index:'jumlahkader', width:50},
				{name:'tgl_posyandupopup',index:'tgl_posyandupopup', width:70,align:'center'},
				{name:'myid',index:'myid', width:90,align:'center',hidden:true}
			],
			rowNum:10, 
			rowList:[10,20,30], 
			pager: jQuery('#pagerposyandupopup'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				dari=$('#dariposyandupopup').val()?$('#dariposyandupopup').val():'';
				sampai=$('#sampaiposyandupopup').val()?$('#sampaiposyandupopup').val():'';
				
				$('#listposyandupopup').setGridParam({postData:{'dari':dari,'sampai':sampai}})
			}
	}).navGrid('#pagerposyandupopup',{edit:false,add:false,del:false,search:false});
	
	function formatterAction(cellvalue, options, rowObject) {
		var content = '';
		return '<input type="checkbox" class="chk" name="chk[]" />';
		return content;
	}
	
	$(".chk").live('click', function(){		
		$("#listposyandupopup").find('input[type=checkbox]').each(function() {
			$(this).change( function(){
				var colid = $(this).parents('tr:last').attr('id');
				if( $(this).is(':checked')) {
					$("#listposyandupopup").jqGrid('setSelection', colid );
					$(this).prop('checked',true);
					var myCellDataId = jQuery('#listposyandupopup').jqGrid('getCell', colid, 'myid');
					var myCellDataNamaposyandu = jQuery('#listposyandupopup').jqGrid('getCell', colid, 'namaposyandu');
					$('#<?=$id_caller?> #nama_posyandu_hidden').val(myCellDataId);
					$('#<?=$id_caller?> #nama_posyandu').val(myCellDataNamaposyandu);
					$("#dialogtransaksiposyandu_cari_namaposyandu").dialog("close");
				}
			});	
		});
	});
	
	$('form').resize(function(e) {
		if($("#listposyandupopup").getGridParam("records")>0){
		jQuery('#listposyandupopup').setGridWidth(($(this).width()));
		}
	});
	
})
</script>

<div class="mycontent">
	<form id="formposyandupopup">
		<table id="listposyandupopup"></table>
		<div id="pagerposyandupopup"></div>
		</div >
	</form>
</div>