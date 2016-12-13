<script>
jQuery().ready(function (){ 
	jQuery("#listmasterhargaobatpopup").jqGrid({ 
		url:'c_master_harga_obat/masterhargaobatxml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['Kode Obat','Kode Tarif','Kode Obat','Harga Beli','Harga Jual','Kode Milik Obat','Action'],
		rownumbers:true,
		width: 1021,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[ 
				{name:'id',index:'id', width:5,hidden:false,formatter:formatterAction}, 
				{name:'kdtarif',index:'kdtarif', width:100,align:'center'}, 
				{name:'kdobat',index:'kdobat', width:100,align:'center'}, 
				{name:'hrgbeli',index:'hrgbeli', width:100,align:'right'}, 
				{name:'hrgjual',index:'hrgjual', width:100,align:'right'}, 
				{name:'milik',index:'milik', width:100,align:'center'}, 
				{name:'myid',index:'myid', width:91,align:'center',hidden:true}
			],
			rowNum:5, 
			rowList:[5,10,20,30], 
			pager: jQuery('#pagermasterhargaobatpopup'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				carinama=$('#carinamamasterhargaobatpopup').val()?$('#carinamamasterhargaobatpopup').val():'';
				$('#listmasterhargaobatpopup').setGridParam({postData:{'dari':'','sampai':'','carinama':carinama}})
			}
	}).navGrid('#pagermasterhargaobatpopup',{edit:false,add:false,del:false,search:false});
	
	function formatterAction(cellvalue, options, rowObject) {
		var content = '';
		return '<input type="checkbox" class="chk" name="chk[]" id="chkhargaobat" />';
		return content;
	}	
	
	$("#chkhargaobat.chk").live('click', function(){		
		$("#listmasterhargaobatpopup").find('input[type=checkbox]').each(function() {
			$(this).change( function(){
				var colid = $(this).parents('tr:last').attr('id');
				if( $(this).is(':checked')) {
					$("#listmasterhargaobatpopup").jqGrid('setSelection', colid );
					$(this).prop('checked',true);
					var myCellDataId = jQuery('#listmasterhargaobatpopup').jqGrid('getCell', colid, 'myid');
					var myCellDataColumn1 = jQuery('#listmasterhargaobatpopup').jqGrid('getCell', colid, 'namaKota');
					$('#<?=$id_caller?> #master_harga_obat_id_hidden').val(myCellDataId);
					$('#<?=$id_caller?> #master_harga_obat_id').val(myCellDataColumn1);
					$("#dialogcari_master_harga_obat_id").dialog("close");
				}
			});	
		});
	});
	
	$('form').resize(function(e) {
		if($("#listmasterhargaobatpopup").getGridParam("records")>0){
		jQuery('#listmasterhargaobatpopup').setGridWidth(($(this).width()));
		}
	});
	
	$("#carimasterhargaobatpopup").live('click', function(event){
		event.preventDefault();
		$('#listmasterhargaobatpopup').trigger("reloadGrid");
	});
	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	$("#resetmasterhargaobatpopup").live('click', function(event){
		event.preventDefault();
		$('#formmasterhargaobatpopup').reset();
		$('#listmasterhargaobatpopup').trigger("reloadGrid");
	});
})
</script>

<div class="mycontent">
	<form id="formmasterhargaobatpopup">
	<fieldset style="margin:0 13px 0 13px ">
		<span>
		<label>Cari Harga Obat</label>
		</span>
		<span>
		<input type="text" name="carinama" class="nama" size="3" id="carinamamasterhargaobatpopup" autocomplete="off">
		<input type="submit" class="cari" value="&nbsp;Cari&nbsp;" id="carimasterhargaobatpopup"/>
		<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="resetmasterhargaobatpopup"/>
		</span>
	</fieldset>
		<table id="listmasterhargaobatpopup"></table>
		<div id="pagermasterhargaobatpopup"></div>
		</div >
	</form>
</div>