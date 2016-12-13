<script>
jQuery().ready(function (){ 
	jQuery("#pList_map_gigi").jqGrid({ 
		url:'c_map_gigi_permukaan/masterXml/1', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['Pilih','ID','Gambar','Kode Permukaan Gigi','Kode Status Gigi', 'Jumlah Gigi', 'Status'],
		rownumbers:true,
		width: 400,
		height: 'auto',
		mtype: 'POST', 
		altRows     : true,		
		colModel:[ 
				{name:'id',index:'id', width:7,align:'center',hidden:false,formatter:formatterAction},
				{name:'map_gigi_id',index:'map_gigi_id', width:7,align:'center',hidden:true},
				{name:'gambar',index:'gambar', width:5,align:'center', formatter:formatterImageGigi},
				{name:'kd_permukaan_gigi',index:'kd_permukaan_gigi', width:10,align:'center'},
				{name:'kd_status_gigi',index:'kd_status_gigi', width:10,align:'center',hidden:false},
				{name:'jumlah_gigi',index:'jumlah_gigi', width:5,align:'center',hidden:true},
				{name:'status',index:'status', width:10,align:'center'}
			],
			rowNum:5, 
			rowList:[5,10,20,30], 
			pager: jQuery('#pPager_map_gigi'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				kd_status_gigi=$('#pCari_kode_map_gigi').val()?$('#pCari_kode_map_gigi').val():'';
				status=$('#pCari_status_map_gigi').val()?$('#pCari_status_map_gigi').val():'';
				kd_permukaan_gigi=$('#pCari_kd_permukaan_map_gigi').val()?$('#pCari_kd_permukaan_map_gigi').val():'';
				$('#pList_map_gigi').setGridParam({postData:{'kd_status_gigi':kd_status_gigi, 'status':status, 'kode':kd_permukaan_gigi}})
			},
			loadComplete:function(){
				$("#chkkab.chk").bind('click', function(){	
					// $("#pList_map_gigi").find('input[type=checkbox]').each(function() {
						// $(this).change( function(){
							var colid = $(this).parents('tr:last').attr('id');
							// if( $(this).is(':checked')) {
								$("#pList_map_gigi").jqGrid('setSelection', colid );
								$(this).prop('checked',true);
								var myCellId = jQuery('#pList_map_gigi').jqGrid('getCell', colid, 'map_gigi_id');
								var myCellDataId = jQuery('#pList_map_gigi').jqGrid('getCell', colid, 'kd_status_gigi');
								var myKodepermukaan = jQuery('#pList_map_gigi').jqGrid('getCell', colid, 'kd_permukaan_gigi');
								var myCellDataColumn1 = jQuery('#pList_map_gigi').jqGrid('getCell', colid, 'status');

								var tmp_str = myKodepermukaan+'-';
								if(!myKodepermukaan){
									tmp_str = myCellDataId;
								}else{
									tmp_str += myCellDataId;
								}
								$('#<?=$id_caller?> #kd_map_id').val(myCellId);
								$('#<?=$id_caller?> #master_gigi_status_id_hidden').val(myCellDataId);
								$('#<?=$id_caller?> #master_output_status').val(tmp_str);
								$('#<?=$id_caller?> #master_gigi_status_id').val(myCellDataColumn1);
								$("#dialogcari_master_gigi_status_id").dialog("close");
							// }
						});	
					// });
				// });

			
			$("#pCari_master_nama_map_gigi").bind('click', function(event){
				event.preventDefault();
				$('#pList_map_gigi').trigger("reloadGrid");
			});
			}
	}).navGrid('#pPager_map_gigi',{edit:false,add:false,del:false,search:false});
	
	function formatterAction(cellvalue, options, rowObject) {
		var content = '';
		return '<input type="checkbox" class="chk" name="chk[]" id="chkkab" />';
		return content;
	}	
	function formatterImageGigi(cellValue, options, rowObject){
		var content = '';
		content += '<img src="./assets/images/map_gigi_permukaan/'+cellValue+'" width="30px" height="39px"/>';
		return content;
	}
	$('form').resize(function(e) {
		if($("#pList_map_gigi").getGridParam("records")>0){
		jQuery('#pList_map_gigi').setGridWidth(($(this).width()));
		}
	});
	
	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	$("#pReset_master_map_gigi").live('click', function(event){
		event.preventDefault();
		$('#pform_master_map_gigi').reset();
		$('#pList_map_gigi').trigger("reloadGrid");
	});
})
</script>

<div class="mycontent">
	<form id="pform_master_map_gigi">
	<fieldset style="margin:0 13px 0 13px ">
		<span>
		<label>Cari Kode Status</label>
			<input type="text" name="carikodestatusgigi" class="carikodestatusgigi" size="3" id="pCari_kode_map_gigi" autocomplete="off" />
		<label>Cari Status</label>
			<input type="text" name="caristatusgigi" class="caristatusgigi" size="3" id="pCari_status_map_gigi" autocomplete="off" style="margin-top:5px;" />
		<label>Cari Kode Permukaan</label>
			<input type="text" name="pCari_kd_permukaan_map_gigi" class="pCari_kd_permukaan_map_gigi" size="3" id="pCari_kd_permukaan_map_gigi" autocomplete="off" style="margin-top:5px;" />
		<input type="submit" class="cari" value="&nbsp;Cari&nbsp;" id="pCari_master_nama_map_gigi"/>
		<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="pReset_master_map_gigi"/>
		</span>
	</fieldset>
		<table id="pList_map_gigi"></table>
		<div id="pPager_map_gigi"></div>
		</div >
	</form>
</div>