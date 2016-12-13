<script>
jQuery().ready(function (){ 
	jQuery("#liststatusmaritalpopup").jqGrid({ 
		url:'c_master_ras/rasxml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['KODE STATUS','STATUS','Action'],
		rownumbers:true,
		width: 1021,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[ 
				{name:'kd_status_marital',index:'kd_status_marital', width:80}, 
				{name:'status_marital',index:'status_marital', width:80},			
				{name:'myid',index:'myid', width:90,align:'center',hidden:true}
			],
			rowNum:5, 
			rowList:[10,20,30], 
			pager: jQuery('#pagerstatusmaritalpopup'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				dari=$('#daristatusmaritalpopup').val()?$('#daristatusmaritalpopup').val():'';
				sampai=$('#sampaistatusmaritalpopup').val()?$('#sampaistatusmaritalpopup').val():'';
				nama=$('#namastatusmaritalpopup').val()?$('#namastatusmaritalpopup').val():'';
				$('#liststatusmaritalpopup').setGridParam({postData:{'dari':'','sampai':'','nama':nama}})
			}
	}).navGrid('#pagerstatusmaritalpopup',{edit:false,add:false,del:false,search:false});
	
	function formatterAction(cellvalue, options, rowObject) {
		var content = '';
		return '<input type="checkbox" class="chk" name="chk[]" />';
		return content;
	}
	
	$(".chk").live('click', function(){		
		$("#liststatusmaritalpopup").find('input[type=checkbox]').each(function() {
			$(this).change( function(){
				var colid = $(this).parents('tr:last').attr('id');
				if( $(this).is(':checked')) {
					$("#liststatusmaritalpopup").jqGrid('setSelection', colid );
					$(this).prop('checked',true);
					var myCellDataId = jQuery('#liststatusmaritalpopup').jqGrid('getCell', colid, 'myid');
					var myCellDataNamaposyandu = jQuery('#liststatusmaritalpopup').jqGrid('getCell', colid, 'nama_satuan');
					$('#<?=$id_caller?> #nama_satuan_marital_hidden').val(myCellDataId);
					$('#<?=$id_caller?> #nama_satuan').val(myCellDataNamaposyandu);
					$("#dialogtransaksi_cari_namasatuanmarital").dialog("close");
				}
			});	
		});
	});
	
	$('form').resize(function(g) {
		if($("#liststatusmaritalpopup").getGridParam("records")>0){
		jQuery('#liststatusmaritalpopup').setGridWidth(($(this).width()));
		}
	});
	
	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	$("#resetsatuanmaritalpopup").live('click', function(event){
		event.preventDefault();
		$('#formsatuanmaritalpopup').reset();
		$('#liststatusmaritalpopup').trigger("reloadGrid");
	});
	$("#carisatuanmaritalpopup").live('click', function(event){
		event.preventDefault();
		$('#liststatusmaritalpopup').trigger("reloadGrid");
	});
})
</script>

<div class="mycontent">
	<form id="formsatuanmaritalpopup">
	<div class="gridtitle">Daftar Satuan Marital</div>
		<fieldset style="margin:0 13px 0 13px ">
			<span>
				<label>Nama Satuan</label>
				<input type="text" name="status_marital" class="ras" id="namastatusmaritalpopup"/>
			</span>
			<span>
				<input type="submit" class="cari" value="&nbsp;Cari&nbsp;" id="carisatuanmaritalpopup" />
				<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="resetsatuanmaritalpopup" />
			</span>
		</fieldset>
		<table id="liststatusmaritalpopup"></table>
		<div id="pagerstatusmaritalpopup"></div>
		</div >
	</form>
</div>