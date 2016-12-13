<script>
jQuery().ready(function (){ 
	jQuery("#listmasterKeadaankesehatanpopup").jqGrid({ 
		url:'c_master_keadaan_kesehatan/masterkeadaankesehatanxml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['Kode','Kode','Keadaan Kesehatan','Kode'],
		rownumbers:true,
		width: 1021,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[ 
				{name:'id1',index:'id1', width:15,align:'center',hidden:false,formatter:formatterAction},
				{name:'id',index:'id', width:25,align:'center',hidden:false},
				{name:'kedkes',index:'kedkes', width:100}, 
				{name:'myid',index:'myid', width:91,align:'center',hidden:true}
			],
			rowNum:5, 
			rowList:[5,10,20,30], 
			pager: jQuery('#pagermasterKeadaankesehatanpopup'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				carinama=$('#namamasterKeadaankesehatanpopup').val()?$('#namamasterKeadaankesehatanpopup').val():'';
				$('#listmasterKeadaankesehatanpopup').setGridParam({postData:{'dari':'','sampai':'','carinama':carinama}})
			}
	}).navGrid('#pagermasterKeadaankesehatanpopup',{edit:false,add:false,del:false,search:false});
	
	function formatterAction(cellvalue, options, rowObject) {
		var content = '';
		return '<input type="checkbox" class="chk" name="chk[]" id="chkprop" />';
		return content;
	}	
	
	$("#chkprop.chk").live('click', function(){		
		$("#listmasterKeadaankesehatanpopup").find('input[type=checkbox]').each(function() {
			$(this).change( function(){
				var colid = $(this).parents('tr:last').attr('id');
				if( $(this).is(':checked')) {
					$("#listmasterKeadaankesehatanpopup").jqGrid('setSelection', colid );
					$(this).prop('checked',true);
					var myCellDataId = jQuery('#listmasterKeadaankesehatanpopup').jqGrid('getCell', colid, 'myid');
					var myCellDataColumn1 = jQuery('#listmasterKeadaankesehatanpopup').jqGrid('getCell', colid, 'kedkes');
					$('#<?=$id_caller?> #master_keadaan_kesehatan_id_hidden').val(myCellDataId);
					$('#<?=$id_caller?> #master_keadaan_kesehatan_id').val(myCellDataColumn1);
					$("#dialogcari_master_keadaan_kesehatan_id").dialog("close");
				}
			});	
		});
	});
	
	$('form').resize(function(e) {
		if($("#listmasterKeadaankesehatanpopup").getGridParam("records")>0){
		jQuery('#listmasterKeadaankesehatanpopup').setGridWidth(($(this).width()));
		}
	});
	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	$("#resetmasterKeadaankesehatanpopup").live('click', function(event){
		event.preventDefault();
		$('#formmasterKeadaankesehatanpopup').reset();
		$('#listmasterKeadaankesehatanpopup').trigger("reloadGrid");
	});
	$("#carimasterKeadaankesehatanpopup").live('click', function(event){
		event.preventDefault();
		$('#listmasterKeadaankesehatanpopup').trigger("reloadGrid");
	});
	
})
</script>

<div class="mycontent">
	<form id="formmasterKeadaankesehatanpopup">
	<fieldset style="margin:0 13px 0 13px ">
		<span>
		<label>Cari Keadaan Kesehatan</label>
		</span>
		<span>
		<input type="text" name="carinama" class="nama" size="3" id="namamasterKeadaankesehatanpopup" autocomplete="off">
		<input type="submit" class="cari" value="&nbsp;Cari&nbsp;" id="carimasterKeadaankesehatanpopup"/>
		<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="resetmasterKeadaankesehatanpopup"/>
		</span>
	</fieldset>
		<table id="listmasterKeadaankesehatanpopup"></table>
		<div id="pagermasterKeadaankesehatanpopup"></div>
		</div >
	</form>
</div>