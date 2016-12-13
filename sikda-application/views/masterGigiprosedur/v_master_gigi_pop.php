<script>
jQuery().ready(function (){ 
	jQuery("#pList_gigi_p").jqGrid({ 
		url:'c_master_gigi_prosedur/masterXml/1', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['Pilih','Kode','Prosedur','Deskripsi'],
		rownumbers:true,
		width: 1021,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[ 
				{name:'kd_prosedur_gigi',index:'kd_prosedur_gigi', width:7,align:'center',hidden:false,formatter:formatterAction},
				{name:'myid',index:'myid', width:10,align:'center',hidden:false},
				{name:'prosedur',index:'prosedur', width:25,align:'center'},
				{name:'deskripsi',index:'deskripsi', width:40,align:'center'}
			],
			rowNum:5, 
			rowList:[5,10,20,30], 
			pager: jQuery('#pPager_gigi_p'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				kd_prosedur_gigi=$('#pCari_kode_gigi_p').val()?$('#pCari_kode_gigi_p').val():'';
				prosedur=$('#pCari_prosedur_gigi_p').val()?$('#pCari_prosedur_gigi_p').val():'';
				$('#pList_gigi_p').setGridParam({postData:{'kd_prosedur_gigi':kd_prosedur_gigi, 'prosedur':prosedur}})
			},
			loadComplete:function(){
				$("#chkkab.chk").bind('click', function(){	
					// $("#pList_gigi_p").find('input[type=checkbox]').each(function() {
						// $(this).change( function(){
							var colid = $(this).parents('tr:last').attr('id');
							// if( $(this).is(':checked')) {
								$("#pList_gigi_p").jqGrid('setSelection', colid );
								$(this).prop('checked',true);
								var myCellDataId = jQuery('#pList_gigi_p').jqGrid('getCell', colid, 'myid');
								var myCellDataColumn1 = jQuery('#pList_gigi_p').jqGrid('getCell', colid, 'prosedur');
								$('#<?=$id_caller?> #master_gigi_prosedur_id_hidden').val(myCellDataId);
								$('#<?=$id_caller?> #master_gigi_prosedur_id').val(myCellDataColumn1);
								$("#dialogcari_master_gigi_prosedur_id").dialog("close");
							// }
						});	
					// });
				// });

			
			$("#pCari_master_nama_gigi_p").bind('click', function(event){
				event.preventDefault();
				$('#pList_gigi_p').trigger("reloadGrid");
			});
			}
	}).navGrid('#pPager_gigi_p',{edit:false,add:false,del:false,search:false});
	
	function formatterAction(cellvalue, options, rowObject) {
		var content = '';
		return '<input type="checkbox" class="chk" name="chk[]" id="chkkab" />';
		return content;
	}	
	
	$('form').resize(function(e) {
		if($("#pList_gigi_p").getGridParam("records")>0){
		jQuery('#pList_gigi_p').setGridWidth(($(this).width()));
		}
	});
	
	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	$("#pReset_master_gigi_p").live('click', function(event){
		event.preventDefault();
		$('#pform_master_gigi_p').reset();
		$('#pList_gigi_p').trigger("reloadGrid");
	});
})
</script>

<div class="mycontent">
	<form id="pform_master_gigi_p">
	<fieldset style="margin:0 13px 0 13px ">
		<span>
		<label>Cari Kode</label>
			<input type="text" name="carikodeprosedurgigi" class="carikodeprosedurgigi" size="3" id="pCari_kode_gigi_p" autocomplete="off" />
		<label>Cari Prosedur</label>
			<input type="text" name="cariprosedurgigi" class="cariprosedurgigi" size="3" id="pCari_prosedur_gigi_p" autocomplete="off" style="margin-top:6px;" />
		<input type="submit" class="cari" value="&nbsp;Cari&nbsp;" id="pCari_master_nama_gigi_p"/>
		<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="pReset_master_gigi_p"/>
		</span>
	</fieldset>
		<table id="pList_gigi_p"></table>
		<div id="pPager_gigi_p"></div>
		</div >
	</form>
</div>