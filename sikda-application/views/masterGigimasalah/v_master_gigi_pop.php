<script>
jQuery().ready(function (){ 
	jQuery("#pList_gigi_m").jqGrid({ 
		url:'c_master_gigi_masalah/masterXml/1', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['Pilih','Kode','Masalah','Deskripsi'],
		rownumbers:true,
		width: 1021,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[ 
				{name:'kd_masalah_gigi',index:'kd_masalah_gigi', width:7,align:'center',hidden:false,formatter:formatterAction},
				{name:'myid',index:'myid', width:10,align:'center',hidden:false},
				{name:'masalah',index:'masalah', width:35,align:'center'},
				{name:'deskripsi',index:'deskripsi', width:45,align:'center'}
			],
			rowNum:5, 
			rowList:[5,10,20,30], 
			pager: jQuery('#pPager_gigi_m'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				kode=$('#pCari_kode_gigi_m').val()?$('#pCari_kode_gigi_m').val():'';
				masalah=$('#pCari_masalah_gigi_m').val()?$('#pCari_masalah_gigi_m').val():'';
				$('#pList_gigi_m').setGridParam({postData:{'kd_masalah_gigi':kode, 'masalah':masalah}})
			},
			loadComplete:function(){
				$("#chkkab.chk").bind('click', function(){	
					// $("#pList_gigi_m").find('input[type=checkbox]').each(function() {
						// $(this).change( function(){
							var colid = $(this).parents('tr:last').attr('id');
							// if( $(this).is(':checked')) {
								$("#pList_gigi_m").jqGrid('setSelection', colid );
								$(this).prop('checked',true);
								var myCellDataId = jQuery('#pList_gigi_m').jqGrid('getCell', colid, 'myid');
								var myCellDataColumn1 = jQuery('#pList_gigi_m').jqGrid('getCell', colid, 'masalah');
								$('#<?=$id_caller?> #master_gigi_masalah_id_hidden').val(myCellDataId);
								$('#<?=$id_caller?> #master_gigi_masalah_id').val(myCellDataColumn1);
								$("#dialogcari_master_gigi_masalah_id").dialog("close");
							// }
						});	
					// });
				// });

			
			$("#pCari_master_nama_gigi_m").bind('click', function(event){
				event.preventDefault();
				$('#pList_gigi_m').trigger("reloadGrid");
			});
			}
	}).navGrid('#pPager_gigi_m',{edit:false,add:false,del:false,search:false});
	
	function formatterAction(cellvalue, options, rowObject) {
		var content = '';
		return '<input type="checkbox" class="chk" name="chk[]" id="chkkab" />';
		return content;
	}	
	
	$('form').resize(function(e) {
		if($("#pList_gigi_m").getGridParam("records")>0){
		jQuery('#pList_gigi_m').setGridWidth(($(this).width()));
		}
	});
	
	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	$("#pReset_master_gigi_m").live('click', function(event){
		event.preventDefault();
		$('#pform_master_gigi_m').reset();
		$('#pList_gigi_m').trigger("reloadGrid");
	});
})
</script>

<div class="mycontent">
	<form id="pform_master_gigi_m">
	<fieldset style="margin:0 13px 0 13px ">
		<span>
		<label>Cari Kode</label>
			<input type="text" name="carikodemasalahgigi" class="carikodemasalahgigi" size="3" id="pCari_kode_gigi_m" autocomplete="off" />
		<label>Cari Masalah</label>
			<input type="text" name="carimasalahgigi" class="carimasalahgigi" size="3" id="pCari_masalah_gigi_m" autocomplete="off" style="margin-top:6px;" />
		<input type="submit" class="cari" value="&nbsp;Cari&nbsp;" id="pCari_master_nama_gigi_m"/>
		<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="pReset_master_gigi_m"/>
		</span>
	</fieldset>
		<table id="pList_gigi_m"></table>
		<div id="pPager_gigi_m"></div>
		</div >
	</form>
</div>