<style type="text/css">
	.middle_data_show{
		vertical-align: middle !important;
	}
</style>
<script>
jQuery().ready(function (){ 
	$('.ui-jqgrid tr.ui-row-ltr td').addClass('middle_data_show');
	jQuery("#pList_gigi_master").jqGrid({ 
		url:'c_master_gigi/masterXml/1', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['Pilih','Nomor', 'Gambar','Nama'],
		rownumbers:true,
		width: 400,
		height: 'auto',
		mtype: 'POST', 
		altRows     : true,		
		colModel:[ 
				{name:'kd_gigi',index:'kd_gigi', width:7,align:'center',hidden:false,formatter:formatterAction},
				{name:'myid',index:'myid', width:10,align:'center',hidden:false},
				{name:'gambar',index:'gambar', width:10,align:'center', formatter:formatterImageGigi, hidden:true},
				{name:'nama',index:'nama', width:50,align:'left'}
			],
			rowNum:5, 
			rowList:[5,10,20,30], 
			pager: jQuery('#pPager_gigi_master'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				kd_gigi=$('#pCari_kd_gigi_master').val()?$('#pCari_kd_gigi_master').val():'';
				nama=$('#pCari_nama_gigi_master').val()?$('#pCari_nama_gigi_master').val():'';
				$('#pList_gigi_master').setGridParam({postData:{'kd_gigi':kd_gigi, 'nama':nama}})
			},
			loadComplete:function(){
				$("#chkkab.chk").bind('click', function(){	
					// $("#pList_gigi_master").find('input[type=checkbox]').each(function() {
						// $(this).change( function(){
							var colid = $(this).parents('tr:last').attr('id');
							// if( $(this).is(':checked')) {
								$("#pList_gigi_master").jqGrid('setSelection', colid );
								$(this).prop('checked',true);
								var myCellDataId = jQuery('#pList_gigi_master').jqGrid('getCell', colid, 'myid');
								var myCellDataColumn1 = jQuery('#pList_gigi_master').jqGrid('getCell', colid, 'nama');
								$('#<?=$id_caller?> #master_gigi_id_hidden').val(myCellDataId);
								$('#<?=$id_caller?> #master_gigi_id').val(myCellDataColumn1);
								$("#dialogcari_master_gigi_id").dialog("close");
							// }
						});	
					// });
				// });

			
			$("#pCari_master_gigi_master").bind('click', function(event){
				event.preventDefault();
				$('#pList_gigi_master').trigger("reloadGrid");
			});
			}
	}).navGrid('#pPager_gigi_master',{edit:false,add:false,del:false,search:false});
	
	function formatterAction(cellvalue, options, rowObject) {
		var content = '';
		return '<input type="checkbox" class="chk" name="chk[]" id="chkkab" />';
		return content;
	}	
	function formatterImageGigi(cellValue, options, rowObject){
		var content = '';
		content += '<img src="./assets/images/gigi_master/'+cellValue+'" width="30px" height="39px"/>';
		return content;
	}
	
	$('form').resize(function(e) {
		if($("#pList_gigi_master").getGridParam("records")>0){
		jQuery('#pList_gigi_master').setGridWidth(($(this).width()));
		}
	});
	
	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	$("#pReset_master_gigi_master").live('click', function(event){
		event.preventDefault();
		$('#pForm_master_gigi_master').reset();
		$('#pList_gigi_master').trigger("reloadGrid");
	});
})
</script>

<div class="mycontent">
	<form id="pForm_master_gigi_master">
	<fieldset style="margin:0 13px 0 13px ">
		<span>
		<label>Cari Nomenklatur</label>
			<input type="text" name="carikodegigi" class="carikodegigi" size="3" id="pCari_kd_gigi_master" autocomplete="off">
		<label>Cari Nama Gigi</label>
			<input type="text" name="carinamagigi" class="carinamagigi" size="3" id="pCari_nama_gigi_master" autocomplete="off" style="margin-top:6px;" >
			<input type="submit" class="cari" value="&nbsp;Cari&nbsp;" id="pCari_master_gigi_master"/>
			<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="pReset_master_gigi_master"/>
		</span>
	</fieldset>
		<table id="pList_gigi_master"></table>
		<div id="pPager_gigi_master"></div>
		</div >
	</form>
</div>