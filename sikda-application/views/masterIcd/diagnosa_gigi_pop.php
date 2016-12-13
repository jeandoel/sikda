<script>
jQuery().ready(function (){ 
	jQuery("#pList_gigi_m").jqGrid({ 
		url:'c_master_icd/icdxml/1', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['Pilih','Kode Penyakit','Kode ICD Induk', 'Penyakit', 'Deskripsi'],
		rownumbers:true,
		width: 1021,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[ 
				{name:'myid',index:'myid', width:7,align:'center',hidden:false,formatter:formatterAction},
				{name:'kd_penyakit',index:'kd_penyakit', width:11,align:'center'},
				{name:'kd_icd_induk',index:'kd_icd_induk', width:15,align:'center'},
				{name:'penyakit',index:'penyakit', width:15,align:'center'},
				{name:'deskripsi',index:'deskripsi', width:40,align:'center'}
			],
			rowNum:5, 
			rowList:[5,10,20,30], 
			pager: jQuery('#pPager_gigi_m'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				kd_penyakit=$('#pCari_kode_penyakit').val()?$('#pCari_kode_penyakit').val():'';
				kd_icd_induk=$('#pCari_kode_icd').val()?$('#pCari_kode_icd').val():'';
				penyakit=$('#pCari_penyakit').val()?$('#pCari_penyakit').val():'';
				$('#pList_gigi_m').setGridParam({postData:{'kd_penyakit':kd_penyakit,'kd_icd_induk':kd_icd_induk ,'penyakit':penyakit}})
			},
			loadComplete:function(){
				$("#chkkab.chk").bind('click', function(){	
					// $("#pList_gigi_m").find('input[type=checkbox]').each(function() {
						// $(this).change( function(){
							var colid = $(this).parents('tr:last').attr('id');
							// if( $(this).is(':checked')) {
								$("#pList_gigi_m").jqGrid('setSelection', colid );
								$(this).prop('checked',true);
								var myCellDataId = jQuery('#pList_gigi_m').jqGrid('getCell', colid, 'kd_penyakit');
								var myIcdIndukId = jQuery('#pList_gigi_m').jqGrid('getCell', colid, 'kd_icd_induk');
								var myCellDataColumn1 = jQuery('#pList_gigi_m').jqGrid('getCell', colid, 'penyakit');
								$('#<?=$id_caller?> #kd_penyakit_id').val(myCellDataId);
								$('#<?=$id_caller?> #kd_icd_induk_id').val(myIcdIndukId);
								$('#<?=$id_caller?> #nama_penyakit').val(myCellDataColumn1);
								$("#dialogcari_diagnosa_gigi").dialog("close");
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
		<label>Cari Kode Penyakit</label>
			<input type="text" name="carikodepenyakit" class="carikodepenyakit" size="3" id="pCari_kode_penyakit" autocomplete="off" />
		<label>Cari Kode ICD Induk</label>
			<input type="text" name="carikodeicdinduk" class="carikodeicdinduk" size="3" id="pCari_kode_icd" autocomplete="off" style="margin-top:5px;"/>
		<label>Cari Penyakit</label>
			<input type="text" name="caripenyakit" class="caripenyakit" size="3" id="pCari_penyakit" autocomplete="off" style="margin-top:5px;" />
		<input type="submit" class="cari" value="&nbsp;Cari&nbsp;" id="pCari_master_nama_gigi_m"/>
		<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="pReset_master_gigi_m"/>
		</span>
	</fieldset>
		<table id="pList_gigi_m"></table>
		<div id="pPager_gigi_m"></div>
		</div >
	</form>
</div>