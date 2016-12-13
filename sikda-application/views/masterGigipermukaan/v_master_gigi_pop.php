<style type="text/css">
	.middle_data_show{
		vertical-align: middle !important;
	}
</style>
<script>
jQuery().ready(function (){ 
	$('.ui-jqgrid tr.ui-row-ltr td').addClass('middle_data_show');
	jQuery("#pList_gigi_master_permukaan").jqGrid({ 
		url:'c_master_gigi_permukaan/masterXml/1', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['Pilih','ID', 'Kode','Nama'],
		rownumbers:true,
		width: 400,
		height: 'auto',
		mtype: 'POST', 
		altRows     : true,		
		colModel:[ 
				{name:'myid',index:'myid', width:7,align:'center',hidden:false,formatter:formatterAction},
				{name:'kd_gigi_permukaan',index:'kd_gigi_permukaan', width:10,align:'center', hidden:true},
				{name:'kode',index:'kode', width:10,align:'center'},
				{name:'nama',index:'nama', width:50,align:'left'}
			],
			rowNum:5, 
			rowList:[5,10,20,30], 
			pager: jQuery('#pPager_gigi_master_permukaan'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				kode=$('#pCari_kd_gigi_master_permukaan').val()?$('#pCari_kd_gigi_master_permukaan').val():'';
				nama=$('#pCari_nama_gigi_master_permukaan').val()?$('#pCari_nama_gigi_master_permukaan').val():'';
				$('#pList_gigi_master_permukaan').setGridParam({postData:{'kode':kode, 'nama':nama}})
			},
			loadComplete:function(){
				$("#chkkab.chk").bind('click', function(){	
					// $("#pList_gigi_master_permukaan").find('input[type=checkbox]').each(function() {
						// $(this).change( function(){
							var colid = $(this).parents('tr:last').attr('id');
							// if( $(this).is(':checked')) {
								$("#pList_gigi_master_permukaan").jqGrid('setSelection', colid );
								$(this).prop('checked',true);
								var mymainID = jQuery('#pList_gigi_master_permukaan').jqGrid('getCell', colid, 'kd_gigi_permukaan');
								var myCellDataId = jQuery('#pList_gigi_master_permukaan').jqGrid('getCell', colid, 'kode');
								var myCellDataColumn1 = jQuery('#pList_gigi_master_permukaan').jqGrid('getCell', colid, 'nama');
								$('#<?=$id_caller?> #kd_gigi_permukaan_id').val(mymainID);								
								$('#<?=$id_caller?> #kode_id').val(myCellDataId);
								$('#<?=$id_caller?> #nama_id').val(myCellDataColumn1);
								$("#dialogcari_gigi_permukaan").dialog("close");
							// }
						});	
					// });
				// });
			$("#pCari_master_gigi_master_permukaan").bind('click', function(event){
				event.preventDefault();
				$('#pList_gigi_master_permukaan').trigger("reloadGrid");
			});
			}
	}).navGrid('#pPager_gigi_master_permukaan',{edit:false,add:false,del:false,search:false});
	
	function formatterAction(cellvalue, options, rowObject) {
		var content = '';
		return '<input type="checkbox" class="chk" name="chk[]" id="chkkab" />';
		return content;
	}	
	function formatterImageGigi(cellValue, options, rowObject){
		var content = '';
		content += '<img src="./assets/images/gigi_master_permukaan/'+cellValue+'" width="30px" height="39px"/>';
		return content;
	}
	
	$('form').resize(function(e) {
		if($("#pList_gigi_master_permukaan").getGridParam("records")>0){
		jQuery('#pList_gigi_master_permukaan').setGridWidth(($(this).width()));
		}
	});
	
	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	$("#pReset_master_gigi_master_permukaan").live('click', function(event){
		event.preventDefault();
		$('#pForm_master_gigi_master_permukaan').reset();
		$('#pList_gigi_master_permukaan').trigger("reloadGrid");
	});
})
</script>

<div class="mycontent">
	<form id="pForm_master_gigi_master_permukaan">
	<fieldset style="margin:0 13px 0 13px ">
		<span>
		<label>Cari Kode</label>
			<input type="text" name="carikodegigi" class="carikodegigi" size="3" id="pCari_kd_gigi_master_permukaan" autocomplete="off">
		<label>Cari Nama</label>
			<input type="text" name="carinamagigi" class="carinamagigi" size="3" id="pCari_nama_gigi_master_permukaan" autocomplete="off" style="margin-top:6px;" >
			<input type="submit" class="cari" value="&nbsp;Cari&nbsp;" id="pCari_master_gigi_master_permukaan"/>
			<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="pReset_master_gigi_master_permukaan"/>
		</span>
	</fieldset>
		<table id="pList_gigi_master_permukaan"></table>
		<div id="pPager_gigi_master_permukaan"></div>
		</div >
	</form>
</div>