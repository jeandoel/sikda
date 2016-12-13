<script>
jQuery().ready(function (){ 
	jQuery("#listmastersatuanbesarpopup").jqGrid({ 
		url:'c_master_satuan_besar/mastersatuanbesarxml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['Pilih','Kode Satuan Besar','Satuan Besar','Action'],
		rownumbers:true,
		width: 1021,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[ 
				{name:'id',index:'id', width:10,align:'center',hidden:false,formatter:formatterAction}, 
				{name:'kdsatbesar',index:'kdsatbesar', width:80}, 
				{name:'satbesarobat',index:'satbesarobat', width:100}, 
				{name:'myid',index:'myid', width:91,align:'center',hidden:true}
			],
			rowNum:5, 
			rowList:[5,10,20,30], 
			pager: jQuery('#pagermastersatuanbesarpopup'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				kdsatbesar=$('#carinamamastersatuanbesartpopup').val()?$('#carinamamastersatuanbesartpopup').val():'';
				$('#listmastersatuanbesarpopup').setGridParam({postData:{'dari':'','sampai':'','kdsatbesar':kdsatbesar}})
			}
	}).navGrid('#pagermastersatuanbesarpopup',{edit:false,add:false,del:false,search:false});
	
	function formatterAction(cellvalue, options, rowObject) {
		var content = '';
		return '<input type="checkbox" class="chk" name="chk[]" id="chksatbes" />';
		return content;
	}	
	
	$("#chksatbes.chk").live('click', function(){		
		$("#listmastersatuanbesarpopup").find('input[type=checkbox]').each(function() {
			$(this).change( function(){
				var colid = $(this).parents('tr:last').attr('id');
				if( $(this).is(':checked')) {
					$("#listmastersatuanbesarpopup").jqGrid('setSelection', colid );
					$(this).prop('checked',true);
					var myCellDataId = jQuery('#listmastersatuanbesarpopup').jqGrid('getCell', colid, 'myid');
					var myCellDataColumn1 = jQuery('#listmastersatuanbesarpopup').jqGrid('getCell', colid, 'satbesarobat');
					$('#<?=$id_caller?> #master_satuan_besar_id_hidden').val(myCellDataId);
					$('#<?=$id_caller?> #master_satuan_besar_id').val(myCellDataColumn1);
					$("#dialogcari_master_satuan_besar_id").dialog("close");
				}
			});	
		});
	});
	
	$('form').resize(function(e) {
		if($("#listmastersatuanbesarpopup").getGridParam("records")>0){
		jQuery('#listmastersatuanbesarpopup').setGridWidth(($(this).width()));
		}
	});
	
	$("#carimastersatuanbesarpopup").live('click', function(event){
		event.preventDefault();
		$('#listmastersatuanbesarpopup').trigger("reloadGrid");
	});
	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	$("#resetmastersatuanbesarpopup").live('click', function(event){
		event.preventDefault();
		$('#formmastersatuanbesarpopup').reset();
		$('#listmastersatuanbesarpopup').trigger("reloadGrid");
	});
})
</script>

<div class="mycontent">
	<form id="formmastersatuanbesarpopup">
	<fieldset style="margin:0 13px 0 13px ">
		<span>
		<label>Cari Satuan Besar</label>
		</span>
		<span>
		<input type="text" name="kdsatbesar" class="nama" size="3" id="carinamamastersatuanbesartpopup" autocomplete="off">
		<input type="submit" class="cari" value="&nbsp;Cari&nbsp;" id="carimastersatuanbesarpopup"/>
		<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="resetmastersatuanbesarpopup"/>
		</span>
	</fieldset>
		<table id="listmastersatuanbesarpopup"></table>
		<div id="pagermastersatuanbesarpopup"></div>
		</div >
	</form>
</div>