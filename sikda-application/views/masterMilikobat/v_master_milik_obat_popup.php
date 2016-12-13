<script>
jQuery().ready(function (){ 
	jQuery("#listmastermilikobatpopup").jqGrid({ 
		url:'c_master_milik_obat/mastermilikobatxml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['Pilih','Kode Milik Obat','Kepemilikan','Action'],
		rownumbers:true,
		width: 1021,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[ 
				{name:'id',index:'id', width:15,formatter:formatterAction}, 
				{name:'kdmilikobat',index:'kdmilikobat', width:20}, 
				{name:'kepemilikan',index:'kepemilikan', width:50}, 
				{name:'myid',index:'myid', width:30,align:'center'}
			],
			rowNum:5, 
			rowList:[5,10,20,30], 
			pager: jQuery('#pagermastermilikobatpopup'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				pemilik=$('#pemilikmasterpemilik').val()?$('#pemilikmasterpemilik').val():'';
				$('#listmastermilikobat').setGridParam({postData:{'pemilik':pemilik}})
			}
	}).navGrid('#pagermastermilikobatpopup',{edit:false,add:false,del:false,search:false});
	
	function formatterAction(cellvalue, options, rowObject) {
		var content = '';
		return '<input type="checkbox" class="chk" name="chk[]" id="chkkec" />';
		return content;
	}	
	
	$("#chkkec.chk").live('click', function(){		
		$("#listmastermilikobatpopup").find('input[type=checkbox]').each(function() {
			$(this).change( function(){
				var colid = $(this).parents('tr:last').attr('id');
				if( $(this).is(':checked')) {
					$("#listmastermilikobatpopup").jqGrid('setSelection', colid );
					$(this).prop('checked',true);
					var myCellDataId = jQuery('#listmastermilikobatpopup').jqGrid('getCell', colid, 'myid');
					var myCellDataColumn1 = jQuery('#listmastermilikobatpopup').jqGrid('getCell', colid, 'kepemilikan');
					$('#<?=$id_caller?> #master_milikobat_id_hidden').val(myCellDataId);
					$('#<?=$id_caller?> #master_milikobat_id').val(myCellDataColumn1);
					$("#dialogcari_master_milikobat_id").dialog("close");
				}
			});	
		});
	});
	
	$('form').resize(function(g) {
		if($("#listmastermilikobatpopup").getGridParam("records")>0){
		jQuery('#listmastermilikobatpopup').setGridWidth(($(this).width()-28));
		}
	});
	
	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	$("#resetmaster_milikobatpopup").live('click', function(event){
		event.preventDefault();
		$('#formmilikobatpopup').reset();
		$('#listmastermilikobatpopup').trigger("reloadGrid");
	});
	$("#carimaster_milikobatpopup").live('click', function(event){
		event.preventDefault();
		$('#listmastermilikobatpopup').trigger("reloadGrid");
	});
	
})
</script>

<div class="mycontent">
	<form id="formkecamatanpopup">
	<fieldset style="margin:0 13px 0 13px ">
		<span>
		<label>Cari Milik Obat</label>
		</span>
		<span>
		<input type="text" name="pemilik" class="pemilik" size="3" id="pemilikmasterpemilik" autocomplete="off">
		<input type="submit" class="cari" value="&nbsp;Cari&nbsp;" id="carimaster_milikobatpopup"/>
		<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="resetmaster_milikobatpopup"/>
		</span>
	</fieldset>
		<table id="listmastermilikobatpopup"></table>
		<div id="pagermastermilikobatpopup"></div>
	</form>
</div>