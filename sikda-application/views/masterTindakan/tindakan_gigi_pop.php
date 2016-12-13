<script>
jQuery().ready(function (){ 
	jQuery("#pList_gigi_p").jqGrid({ 
		url:'c_master_tindakan/tindakanxml/1', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['Pilih','Kode Tindakan', 'Gol Tindakan', 'Tindakan','Harga','Singkatan'],
		rownumbers:true,
		width: 1021,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[ 
				{name:'myid',index:'myid', width:5,align:'center',hidden:false,formatter:formatterAction},
				{name:'kd_produk',index:'kd_produk', width:6,align:'center'},
				{name:'gol_produk',index:'gol_produk', width:10,align:'center'},
				{name:'produk',index:'produk', width:10,align:'center'},
				{name:'harga_produk',index:'harga_produk', width:10,align:'center'},
				{name:'singkatan',index:'singkatan', width:10,align:'center'}

			],
			rowNum:5, 
			rowList:[5,10,20,30], 
			pager: jQuery('#pPager_gigi_p'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				kd_produk=$('#pCari_kode_produk').val()?$('#pCari_kode_produk').val():'';
				gol_produk=$('#pCari_gol_produk').val()?$('#pCari_gol_produk').val():'';
				produk=$('#pCari_produk').val()?$('#pCari_produk').val():'';
				$('#pList_gigi_p').setGridParam({postData:{'kd_produk':kd_produk, 'gol_produk':gol_produk, 'produk':produk}})
			},
			loadComplete:function(){
				$("#chkkab.chk").bind('click', function(){	
					// $("#pList_gigi_p").find('input[type=checkbox]').each(function() {
						// $(this).change( function(){
							var colid = $(this).parents('tr:last').attr('id');
							// if( $(this).is(':checked')) {
								$("#pList_gigi_p").jqGrid('setSelection', colid );
								$(this).prop('checked',true);
								var myCellDataId = jQuery('#pList_gigi_p').jqGrid('getCell', colid, 'kd_produk');
								var myCellDataColumn1 = jQuery('#pList_gigi_p').jqGrid('getCell', colid, 'produk');
								$('#<?=$id_caller?> #master_gigi_tindakan_id').val(myCellDataId);
								$('#<?=$id_caller?> #tindakan_gigi').val(myCellDataColumn1);
								$("#dialogcari_tindakan_gigi").dialog("close");
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
		<label>Cari Kode Tindakan</label>
			<input type="text" name="carikodeproduk" class="carikodeproduk" size="3" id="pCari_kode_produk" autocomplete="off" />
		<label>Cari Gol Tindakan</label>
			<input type="text" name="carigolproduk" class="carigolproduk" size="3" id="pCari_gol_produk" autocomplete="off" style="margin-top:5px;"/>
		<label>Cari Tindakan</label>
			<input type="text" name="cariproduk" class="cariproduk" size="3" id="pCari_produk" autocomplete="off" style="margin-top:5px;" />
		<input type="submit" class="cari" value="&nbsp;Cari&nbsp;" id="pCari_master_nama_gigi_p"/>
		<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="pReset_master_gigi_p"/>
		</span>
	</fieldset>
		<table id="pList_gigi_p"></table>
		<div id="pPager_gigi_p"></div>
		</div >
	</form>
</div>