<script>
jQuery().ready(function (){ 
	jQuery("#listmaster_kecamatanpopup").jqGrid({ 
		url:'c_master_kecamatan/master_kecamatanxml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['Pilih','Kode Kecamatan','Kode Kabupaten','Kecamatan','Kode Kecamatan'],
		rownumbers:true,
		width: 1021,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[ 
				{name:'id',index:'id', width:10,formatter:formatterAction}, 
				{name:'kodekecamatan',index:'kodekecamatan', width:35}, 
				{name:'kodekabupaten',index:'kodekabupaten', width:35}, 
				{name:'kecamatan',index:'kecamatan', width:50},
				{name:'myid',index:'myid', width:30,align:'center',hidden:true}
			],
			rowNum:5, 
			rowList:[5,10,20,30], 
			pager: jQuery('#pagermasterkecamatanpopup'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				kodekecamatan=$('#kodekecamatanmaster_kecamatanpopup').val()?$('#kodekecamatanmaster_kecamatanpopup').val():'';
				idkab=$('#master_kabupaten_id_hidden').val()?$('#master_kabupaten_id_hidden').val():'';
				$('#listmaster_kecamatanpopup').setGridParam({postData:{'kodekecamatan':kodekecamatan,'idkab':idkab}})
			}
	}).navGrid('#pagermasterkecamatanpopup',{edit:false,add:false,del:false,search:false});
	
	function formatterAction(cellvalue, options, rowObject) {
		var content = '';
		return '<input type="checkbox" class="chk" name="chk[]" id="chkkec" />';
		return content;
	}	
	
	$("#chkkec.chk").live('click', function(){		
		$("#listmaster_kecamatanpopup").find('input[type=checkbox]').each(function() {
			$(this).change( function(){
				var colid = $(this).parents('tr:last').attr('id');
				if( $(this).is(':checked')) {
					$("#listmaster_kecamatanpopup").jqGrid('setSelection', colid );
					$(this).prop('checked',true);
					var myCellDataId = jQuery('#listmaster_kecamatanpopup').jqGrid('getCell', colid, 'myid');
					var myCellDataColumn1 = jQuery('#listmaster_kecamatanpopup').jqGrid('getCell', colid, 'kecamatan');
					$('#<?=$id_caller?> #master_kecamatan_id_hidden').val(myCellDataId);
					$('#<?=$id_caller?> #master_kecamatan_id').val(myCellDataColumn1);
					$("#dialogcari_master_kecamatan_id").dialog("close");
				}
			});	
		});
	});
	
	$('form').resize(function(g) {
		if($("#listmaster_kecamatanpopup").getGridParam("records")>0){
		jQuery('#listmaster_kecamatanpopup').setGridWidth(($(this).width()-28));
		}
	});
	
	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	$("#resetmaster_kecamatanpopup").live('click', function(event){
		event.preventDefault();
		$('#formkecamatanpopup').reset();
		$('#listmaster_kecamatanpopup').trigger("reloadGrid");
	});
	$("#carimaster_kecamatanpopup").live('click', function(event){
		event.preventDefault();
		$('#listmaster_kecamatanpopup').trigger("reloadGrid");
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
		<input type="text" name="kodekecamatan" class="kodekecamatan" size="3" id="kodekecamatanmaster_kecamatanpopup" autocomplete="off">
		<input type="submit" class="cari" value="&nbsp;Cari&nbsp;" id="carimaster_kecamatanpopup"/>
		<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="resetmaster_kecamatanpopup"/>
		</span>
	</fieldset>
		<table id="listmaster_kecamatanpopup"></table>
		<div id="pagermasterkecamatanpopup"></div>
	</form>
</div>