<script>
jQuery().ready(function (){ 
	jQuery("#listicdindukpopup").jqGrid({ 
		url:'c_master_icd_induk/icdindukxml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['Pilih','Kode ICD Induk','ICD Induk'],
		rownumbers:true,
		width: 1021,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[  
				{name:'id',index:'id', width:5, hidden:false, align:'center', formatter:formatterAction}, 		
				{name:'kodeicdinduk',index:'kodeicdinduk', width:50}, 
				{name:'icdinduk',index:'icdinduk', width:50} 
			],
			rowNum:5, 
			rowList:[5,20,30], 
			pager: jQuery('#pagericdindukpopup'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				nama=$('#namaicdindukpopup').val()?$('#namaicdindukpopup').val():'';
				$('#listicdindukpopup').setGridParam({postData:{'nama':nama}})
			}
	}).navGrid('#pagericdindukpopup',{edit:false,add:false,del:false,search:false});
	
	function formatterAction(cellvalue, options, rowObject) {
		var content = '';
		return '<input type="checkbox" class="chk" name="chk[]" id="chkpus" />';
		return content;
	}	
	
	$("#chkpus.chk").live('click', function(){		
		$("#listicdindukpopup").find('input[type=checkbox]').each(function() {
			$(this).change( function(){
				var colid = $(this).parents('tr:last').attr('id');
				if( $(this).is(':checked')) {
					$("#listicdindukpopup").jqGrid('setSelection', colid );
					$(this).prop('checked',true);
					var myCellDataId = jQuery('#listicdindukpopup').jqGrid('getCell', colid, 'kodeicdinduk');
					var myCellDataIcdinduk = jQuery('#listicdindukpopup').jqGrid('getCell', colid, 'icdinduk');
					$('#<?=$id_caller?> #nama_icdinduk_hidden').val(myCellDataId);
					$('#<?=$id_caller?> #nama_icdinduk').val(myCellDataIcdinduk);
					$("#dialog_cari_namaicdinduk").dialog("close");
				}
			});	
		});
	});
	
	$('form').resize(function(e) {
		if($("#listicdindukpopup").getGridParam("records")>0){
		jQuery('#listicdindukpopup').setGridWidth(($(this).width()));
		}
	});
	
	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	$("#reseticdindukpopup").live('click', function(event){
		event.preventDefault();
		$('#formicdindukpopup').reset();
		$('#listicdindukpopup').trigger("reloadGrid");
	});
	$("#cariicdindukpopup").live('click', function(event){
		event.preventDefault();
		$('#listicdindukpopup').trigger("reloadGrid");
	});
	
})
</script>

<div class="mycontent">
	<form id="formicdindukpopup">
		<div class="gridtitle">Daftar ICD Induk</div>
		<fieldset style="margin:0 13px 0 13px ">
			<span>
				<label>Cari ICD Induk</label>
				<input type="text" name="nama" class="nama" id="namaicdindukpopup"/>
			</span>
			<span>
				<input type="submit" class="cari" value="&nbsp;Cari&nbsp;" id="cariicdindukpopup" />
				<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="reseticdindukpopup" />
			</span>
		</fieldset>
		<table id="listicdindukpopup"></table>
		<div id="pagericdindukpopup"></div>
	</form>
</div>