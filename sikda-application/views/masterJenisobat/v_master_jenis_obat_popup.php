<script>
jQuery().ready(function (){ 
	jQuery("#listjenisobatpopup").jqGrid({ 
		url:'c_master_jenis_obat/masterjenisobatxml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['Pilih','Kode Jenis Obat','Jenis Obat','Action'],
		rownumbers:true,
		width: 1021,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[ 
				{name:'id',index:'id', width:15,formatter:formatterAction},
				{name:'kdjnsobat',index:'kdjnsobat', width:15},
				{name:'jenisobat',index:'jenisobat', width:75},	
				{name:'myid',index:'myid', width:91,align:'center',hidden:true}
			],
			rowNum:5, 
			rowList:[5,20,30], 
			pager: jQuery('#pagerjenisobatpopup'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				kdjnsobat=$('#jenisobat_masterjenispopup').val()?$('#jenisobat_masterjenispopup').val():'';
				$('#listjenisobatpopup').setGridParam({postData:{'kdjnsobat':kdjnsobat}})
			}
	}).navGrid('#pagerjenisobatpopup',{edit:false,add:false,del:false,search:false});
	
	function formatterAction(cellvalue, options, rowObject) {
		var content = '';
		return '<input type="checkbox" class="chk" name="chk[]" id="chkkec" />';
		return content;
	}	
	
	$("#chkkec.chk").live('click', function(){		
		$("#listjenisobatpopup").find('input[type=checkbox]').each(function() {
			$(this).change( function(){
				var colid = $(this).parents('tr:last').attr('id');
				if( $(this).is(':checked')) {
					$("#listjenisobatpopup").jqGrid('setSelection', colid );
					$(this).prop('checked',true);
					var myCellDataId = jQuery('#listjenisobatpopup').jqGrid('getCell', colid, 'kdjnsobat');
					var myCellDatajenisobat = jQuery('#listjenisobatpopup').jqGrid('getCell', colid, 'jenisobat');
					$('#<?=$id_caller?> #master_jenis_obat_hidden').val(myCellDataId);
					$('#<?=$id_caller?> #master_jenis_obat').val(myCellDatajenisobat);
					$("#dialogcari_master_jenis_obat_id").dialog("close");
				}
			});	
		});
	});
	
	$('form').resize(function(y) {
		if($("#listjenisobatpopup").getGridParam("records")>0){
		jQuery('#listjenisobatpopup').setGridWidth(($(this).width()));
		}
	});
	
	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	$("#resetjenisobatpopup").live('click', function(event){
		event.preventDefault();
		$('#formjenisobatpopup').reset();
		$('#listjenisobatpopup').trigger("reloadGrid");
	});
	$("#carijenisobatpopup").live('click', function(event){
		event.preventDefault();
		$('#listjenisobatpopup').trigger("reloadGrid");
	});
	
})
</script>

<div class="mycontent">
	<form id="formjenisobatpopup">
		<div class="gridtitle">Daftar Jenis obat</div>
		<fieldset style="margin:0 13px 0 13px ">
			<span>
				<label>Cari Puskesmas</label>
				<input type="text" name="kdsatkclobat" class="kdsatkclobat" id="jenisobat_masterjenispopup"/>
			</span>
			<span>
				<input type="submit" class="cari" value="&nbsp;Cari&nbsp;" id="carijenisobatpopup" />
				<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="resetjenisobatpopup" />
			</span>
		</fieldset>
		<table id="listjenisobatpopup"></table>
		<div id="pagerjenisobatpopup"></div>
	</form>
</div>