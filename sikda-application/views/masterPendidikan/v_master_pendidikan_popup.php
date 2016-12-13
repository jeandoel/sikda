<script>
jQuery().ready(function (){ 
	jQuery("#listtranskecamatanpopup").jqGrid({ 
		url:'c_master_kecamatan/master_kecamatanxml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['Kode Kecamatan','Kode Kabupaten','Kecamatan','kode'],
		rownumbers:true,
		width: 1021,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[ 
				{name:'kodekecamatan',index:'kodekecamatan', width:100}, 
				{name:'kodekabupaten',index:'kodekabupaten', width:100}, 
				{name:'kecamatan',index:'kecamatan', width:100}, 
				{name:'myid',index:'myid', width:200,align:'center'}
			],
			rowNum:5, 
			rowList:[5,10,20,30], 
			pager: jQuery('#pagerkecamatanpopup'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				namakecamatan=$('#namakecamatanpopup').val()?$('#namakecamatanpopup').val():'';
				$('#listtranskecamatanpopup').setGridParam({postData:{'dari':'','sampai':'','namakecamatan':namakecamatan}})
			}
	}).navGrid('#pagerkecamatanpopup',{edit:false,add:false,del:false,search:false});
	
	function formatterAction(cellvalue, options, rowObject) {
		var content = '';
		return '<input type="checkbox" class="chk" name="chk[]" id="chkkec" />';
		return content;
	}	
	
	$("#chkkec.chk").live('click', function(){		
		$("#listtranskecamatanpopup").find('input[type=checkbox]').each(function() {
			$(this).change( function(){
				var colid = $(this).parents('tr:last').attr('id');
				if( $(this).is(':checked')) {
					$("#listtranskecamatanpopup").jqGrid('setSelection', colid );
					$(this).prop('checked',true);
					var myCellDataId = jQuery('#listtranskecamatanpopup').jqGrid('getCell', colid, 'myid');
					var myCellDataColumn1 = jQuery('#listtranskecamatanpopup').jqGrid('getCell', colid, 'namakecamatan');
					$('#<?=$id_caller?> #master_kecamatan_id_hidden').val(myCellDataId);
					$('#<?=$id_caller?> #master_kecamatan_id').val(myCellDataColumn1);
					$("#dialogcari_master_kecamatan_id").dialog("close");
				}
			});	
		});
	});
	
	$('form').resize(function(e) {
		if($("#listtranskecamatanpopup").getGridParam("records")>0){
		jQuery('#listtranskecamatanpopup').setGridWidth(($(this).width()));
		}
	});
	
	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	$("#resetkecamatanpopup").live('click', function(event){
		event.preventDefault();
		$('#formkecamatanpopup').reset();
		$('#listtranskecamatanpopup').trigger("reloadGrid");
	});
	
	$("#carikecamatanpopup").live('click', function(event){
		event.preventDefault();
		$('#listtranskecamatanpopup').trigger("reloadGrid");
	});
	
})
</script>

<div class="mycontent">
	<form id="formkecamatanpopup">
	<fieldset style="margin:0 13px 0 13px ">
		<span>
		<label>Cari Kecamatan</label>
		</span>
		<span>
		<input type="text" name="namakecamatan" class="namakecamatan" size="3" id="namakecamatanpopup" autocomplete="off">
		<input type="submit" class="cari" value="&nbsp;Cari&nbsp;" id="carikecamatanpopup"/>
		<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="resetkecamatanpopup"/>
		</span>
	</fieldset>
		<table id="listtranskecamatanpopup"></table>
		<div id="pagerkecamatanpopup"></div>
	</form>
</div>