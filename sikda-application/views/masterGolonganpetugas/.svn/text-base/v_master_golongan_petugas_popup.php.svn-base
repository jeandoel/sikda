<script>
jQuery().ready(function (){ 
	jQuery("#listgolonganpopup").jqGrid({ 
		url:'c_master_ras/rasxml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['KODE GOLONGAN','NAMA GOLONGAN','Action'],
		rownumbers:true,
		width: 1021,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[ 
				{name:'kd_golongan',index:'kd_golongan', width:80,formatter:formatterAction}, 
				{name:'nama_golongan',index:'nama_golongan', width:80},				
				{name:'myid',index:'myid', width:90,align:'center',hidden:true}
			],
			rowNum:5, 
			rowList:[10,20,30], 
			pager: jQuery('#pagergolonganpopup'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				dari=$('#darigolonganpopup').val()?$('#darigolonganpopup').val():'';
				sampai=$('#sampaigpolonganpopup').val()?$('#sampaigpolonganpopup').val():'';
				nama=$('#namagolonganpopup').val()?$('#namagolonganpopup').val():'';
				$('#listgolonganpopup').setGridParam({postData:{'dari':'','sampai':'','nama':nama}})
			}
	}).navGrid('#pagergolonganpopup',{edit:false,add:false,del:false,search:false});
	
	function formatterAction(cellvalue, options, rowObject) {
		var content = '';
		return '<input type="checkbox" class="chk" name="chk[]" />';
		return content;
	}
	
	$(".chk").live('click', function(){		
		$("#listgolonganpopup").find('input[type=checkbox]').each(function() {
			$(this).change( function(){
				var colid = $(this).parents('tr:last').attr('id');
				if( $(this).is(':checked')) {
					$("#listgolonganpopup").jqGrid('setSelection', colid );
					$(this).prop('checked',true);
					var myCellDataId = jQuery('#listgolonganpopup').jqGrid('getCell', colid, 'myid');
					var myCellDataNamaposyandu = jQuery('#listgolonganpopup').jqGrid('getCell', colid, 'nama_golongan');
					$('#<?=$id_caller?> #nama_golongan_hidden').val(myCellDataId);
					$('#<?=$id_caller?> #nama_golongan').val(myCellDataNamaposyandu);
					$("#dialogtransaksi_cari_namaras").dialog("close");
				}
			});	
		});
	});
	
	$('form').resize(function(g) {
		if($("#listgolonganpopup").getGridParam("records")>0){
		jQuery('#listgolonganpopup').setGridWidth(($(this).width()));
		}
	});
	
	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	$("#resetgolonganpopup").live('click', function(event){
		event.preventDefault();
		$('#formgolonganpopup').reset();
		$('#listgolonganpopup').trigger("reloadGrid");
	});
	$("#carigolonganpopup").live('click', function(event){
		event.preventDefault();
		$('#listgolonganpopup').trigger("reloadGrid");
	});
})
</script>

<div class="mycontent">
	<form id="formgolonganpopup">
	<div class="gridtitle">Daftar Golongan</div>
		<fieldset style="margin:0 13px 0 13px ">
			<span>
				<label>Nama Golongan</label>
				<input type="text" name="ras" class="ras" id="namagolonganpopup"/>
			</span>
			<span>
				<input type="submit" class="cari" value="&nbsp;Cari&nbsp;" id="carigolonganpopup" />
				<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="resetgolonganpopup" />
			</span>
		</fieldset>
		<table id="listgolonganpopup"></table>
		<div id="pagergolonganpopup"></div>
		</div >
	</form>
</div>