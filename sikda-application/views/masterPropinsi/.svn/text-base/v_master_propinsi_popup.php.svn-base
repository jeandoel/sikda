<script>
jQuery().ready(function (){ 
	jQuery("#listmasterpropinsipopup").jqGrid({ 
		url:'c_master_propinsi/masterpropinsixml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['Kode','Kode Prov','Provinsi','Kode'],
		rownumbers:true,
		width: 1021,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[ 
				{name:'id1',index:'id1', width:15,align:'center',hidden:false,formatter:formatterAction},
				{name:'id',index:'id', width:25,align:'center',hidden:false},
				{name:'namaProp',index:'namaProp', width:100}, 
				{name:'myid',index:'myid', width:91,align:'center',hidden:true}
			],
			rowNum:5, 
			rowList:[5,10,20,30], 
			pager: jQuery('#pagermasterpropinsipopup'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				carinama=$('#namamasterpropinsipopup').val()?$('#namamasterpropinsipopup').val():'';
				$('#listmasterpropinsipopup').setGridParam({postData:{'dari':'','sampai':'','carinama':carinama}})
			}
	}).navGrid('#pagermasterpropinsipopup',{edit:false,add:false,del:false,search:false});
	
	function formatterAction(cellvalue, options, rowObject) {
		var content = '';
		return '<input type="checkbox" class="chk" name="chk[]" id="chkprop" />';
		return content;
	}	
	
	$("#chkprop.chk").live('click', function(){		
		$("#listmasterpropinsipopup").find('input[type=checkbox]').each(function() {
			$(this).change( function(){
				var colid = $(this).parents('tr:last').attr('id');
				if( $(this).is(':checked')) {
					$("#listmasterpropinsipopup").jqGrid('setSelection', colid );
					$(this).prop('checked',true);
					var myCellDataId = jQuery('#listmasterpropinsipopup').jqGrid('getCell', colid, 'myid');
					var myCellDataColumn1 = jQuery('#listmasterpropinsipopup').jqGrid('getCell', colid, 'namaProp');
					$('#<?=$id_caller?> #master_propinsi_id_hidden').val(myCellDataId);
					$('#<?=$id_caller?> #master_propinsi_id').val(myCellDataColumn1);
					$("#dialogcari_master_propinsi_id").dialog("close");
				}
			});	
		});
	});
	
	$('form').resize(function(e) {
		if($("#listmasterpropinsipopup").getGridParam("records")>0){
		jQuery('#listmasterpropinsipopup').setGridWidth(($(this).width()));
		}
	});
	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	$("#resetmasterpropinsipopup").live('click', function(event){
		event.preventDefault();
		$('#formmasterpropinsipopup').reset();
		$('#listmasterpropinsipopup').trigger("reloadGrid");
	});
	$("#carimasterpropinsipopup").live('click', function(event){
		event.preventDefault();
		$('#listmasterpropinsipopup').trigger("reloadGrid");
	});
	
})
</script>

<div class="mycontent">
	<form id="formmasterpropinsipopup">
	<fieldset style="margin:0 13px 0 13px ">
		<span>
		<label>Cari Provinsi</label>
		</span>
		<span>
		<input type="text" name="carinama" class="nama" size="3" id="namamasterpropinsipopup" autocomplete="off">
		<input type="submit" class="cari" value="&nbsp;Cari&nbsp;" id="carimasterpropinsipopup"/>
		<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="resetmasterpropinsipopup"/>
		</span>
	</fieldset>
		<table id="listmasterpropinsipopup"></table>
		<div id="pagermasterpropinsipopup"></div>
		</div >
	</form>
</div>