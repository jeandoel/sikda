<script>
jQuery().ready(function (){ 
	jQuery("#listmasterkabupatenpopup").jqGrid({ 
		url:'c_master_kabupaten/masterkabupatenxml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['Pilih','Kode Kab','Kode Prov','Kabupaten','Action'],
		rownumbers:true,
		width: 1021,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[ 
				{name:'id1',index:'id1', width:15,align:'center',hidden:false,formatter:formatterAction},
				{name:'id',index:'id', width:25,align:'center',hidden:false},
				{name:'kode_prov',index:'kode_prov', width:25,align:'center'},
				{name:'namaKab',index:'namaKab', width:100}, 
				{name:'myid',index:'myid', width:91,align:'center',hidden:true}
			],
			rowNum:5, 
			rowList:[5,10,20,30], 
			pager: jQuery('#pagermasterkabupatenpopup'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				carinama=$('#carinamamasterkabupatenpopup').val()?$('#carinamamasterkabupatenpopup').val():'';
				idprov=$('#master_propinsi_id_hidden').val()?$('#master_propinsi_id_hidden').val():'';
				$('#listmasterkabupatenpopup').setGridParam({postData:{'dari':'','sampai':'','carinama':carinama,'idprov':idprov}})
			}
	}).navGrid('#pagermasterkabupatenpopup',{edit:false,add:false,del:false,search:false});
	
	function formatterAction(cellvalue, options, rowObject) {
		var content = '';
		return '<input type="checkbox" class="chk" name="chk[]" id="chkkab" />';
		return content;
	}	
	
	$("#chkkab.chk").live('click', function(){		
		$("#listmasterkabupatenpopup").find('input[type=checkbox]').each(function() {
			$(this).change( function(){
				var colid = $(this).parents('tr:last').attr('id');
				if( $(this).is(':checked')) {
					$("#listmasterkabupatenpopup").jqGrid('setSelection', colid );
					$(this).prop('checked',true);
					var myCellDataId = jQuery('#listmasterkabupatenpopup').jqGrid('getCell', colid, 'myid');
					var myCellDataColumn1 = jQuery('#listmasterkabupatenpopup').jqGrid('getCell', colid, 'namaKab');
					$('#<?=$id_caller?> #master_kabupaten_id_hidden').val(myCellDataId);
					$('#<?=$id_caller?> #master_kabupaten_id').val(myCellDataColumn1);
					$("#dialogcari_master_kabupaten_id").dialog("close");
				}
			});	
		});
	});
	
	$('form').resize(function(e) {
		if($("#listmasterkabupatenpopup").getGridParam("records")>0){
		jQuery('#listmasterkabupatenpopup').setGridWidth(($(this).width()));
		}
	});
	
	$("#carimasterkabupatenpopup").live('click', function(event){
		event.preventDefault();
		$('#listmasterkabupatenpopup').trigger("reloadGrid");
	});
	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	$("#resetmasterkabupatenpopup").live('click', function(event){
		event.preventDefault();
		$('#formmasterkabupatenpopup').reset();
		$('#listmasterkabupatenpopup').trigger("reloadGrid");
	});
})
</script>

<div class="mycontent">
	<form id="formmasterkabupatenpopup">
	<fieldset style="margin:0 13px 0 13px ">
		<span>
		<label>Cari Kabupaten</label>
		</span>
		<span>
		<input type="text" name="carinama" class="nama" size="3" id="carinamamasterkabupatenpopup" autocomplete="off">
		<input type="submit" class="cari" value="&nbsp;Cari&nbsp;" id="carimasterkabupatenpopup"/>
		<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="resetmasterkabupatenpopup"/>
		</span>
	</fieldset>
		<table id="listmasterkabupatenpopup"></table>
		<div id="pagermasterkabupatenpopup"></div>
		</div >
	</form>
</div>