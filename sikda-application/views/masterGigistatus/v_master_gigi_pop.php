<script>
jQuery().ready(function (){ 
	jQuery("#pList_gigi_s").jqGrid({ 
		url:'c_master_gigi_status/masterXml/1', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['Pilih','ID','Kode', 'Gambar', 'Status', 'Jumlah Gigi', 'Deskrispi'],
		rownumbers:true,
		width: 1021,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[ 
				{name:'check',index:'check', width:7,align:'center',hidden:false,formatter:formatterAction},
				{name:'id_status_gigi',index:'id_status_gigi', width:10,align:'center',hidden:true},
				{name:'myid',index:'myid', width:10,align:'center',hidden:false},
				{name:'gambar',index:'gambar', width:10,align:'center',formatter:formatterImageGigi}, 
				{name:'status',index:'status', width:20,align:'center'},
				{name:'jumlah_gigi',index:'jumlah_gigi', width:10,align:'center', hidden:true},
				{name:'deskripsi',index:'deskripsi', width:40,align:'center'}
			],
			rowNum:5, 
			rowList:[5,10,20,30], 
			pager: jQuery('#pPager_gigi_s'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				kd_status_gigi=$('#pCari_kode_gigi_s').val()?$('#pCari_kode_gigi_s').val():'';
				status=$('#pCari_status_gigi_s').val()?$('#pCari_status_gigi_s').val():'';
				$('#pList_gigi_s').setGridParam({postData:{'kd_status_gigi':kd_status_gigi, 'status':status}})
			},
			loadComplete:function(){
				$("#chkkab.chk").bind('click', function(){	
					// $("#pList_gigi_s").find('input[type=checkbox]').each(function() {
						// $(this).change( function(){
							var colid = $(this).parents('tr:last').attr('id');
							// if( $(this).is(':checked')) {
								$("#pList_gigi_s").jqGrid('setSelection', colid );
								$(this).prop('checked',true);
								var get_id_status = jQuery('#pList_gigi_s').jqGrid('getCell', colid, 'id_status_gigi');
								var myCellDataId = jQuery('#pList_gigi_s').jqGrid('getCell', colid, 'myid');
								var myCellDataColumn1 = jQuery('#pList_gigi_s').jqGrid('getCell', colid, 'status');
								$('#<?=$id_caller?> #master_id_status_gigi').val(get_id_status);
								$('#<?=$id_caller?> #master_gigi_status_id_hidden').val(myCellDataId);
								$('#<?=$id_caller?> #master_gigi_status_id').val(myCellDataColumn1);
								$("#dialogcari_master_gigi_status_id").dialog("close");
							// }
						});	
					// });
				// });

			
			$("#pCari_master_nama_gigi_s").bind('click', function(event){
				event.preventDefault();
				$('#pList_gigi_s').trigger("reloadGrid");
			});
			}
	}).navGrid('#pPager_gigi_s',{edit:false,add:false,del:false,search:false});
	
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
		if($("#pList_gigi_s").getGridParam("records")>0){
		jQuery('#pList_gigi_s').setGridWidth(($(this).width()));
		}
	});
	
	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	$("#pReset_master_gigi_s").live('click', function(event){
		event.preventDefault();
		$('#pform_master_gigi_s').reset();
		$('#pList_gigi_s').trigger("reloadGrid");
	});
})
</script>

<div class="mycontent">
	<form id="pform_master_gigi_s">
	<fieldset style="margin:0 13px 0 13px ">
		<span>
		<label>Cari Kode</label>
			<input type="text" name="carikodestatusgigi" class="carikodestatusgigi" size="3" id="pCari_kode_gigi_s" autocomplete="off" />
		<label>Cari Status</label>
			<input type="text" name="caristatusgigi" class="caristatusgigi" size="3" id="pCari_status_gigi_s" autocomplete="off" style="margin-top:6px;" />
		<input type="submit" class="cari" value="&nbsp;Cari&nbsp;" id="pCari_master_nama_gigi_s"/>
		<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="pReset_master_gigi_s"/>
		</span>
	</fieldset>
		<table id="pList_gigi_s"></table>
		<div id="pPager_gigi_s"></div>
		</div >
	</form>
</div>