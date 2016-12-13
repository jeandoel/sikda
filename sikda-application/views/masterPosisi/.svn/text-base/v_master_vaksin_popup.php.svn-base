<script>
jQuery().ready(function (){ 
	jQuery("#listmastervaksinpopup").jqGrid({ 
		url:'c_master_vaksin/mastervaksinxml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['ID','Kode','Nama','Golongan','Sumber','Satuan','Tgl. Input','Action'],
		rownumbers:true,
		width: 1021,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[ 
				{name:'id',index:'id', width:10, hidden:false, formatter:formatterAction}, 
				{name:'kolom_kode',index:'kolom_kode', hidden:true}, 
				{name:'nama_vaksin',index:'nama_vaksin', width:155, hidden:false}, 
				{name:'kolom_golongan',index:'kolom_golongan', hidden:true},
				{name:'kolom_sumber',index:'kolom_sumber', hidden:true}, 
				{name:'kolom_satuan',index:'kolom_satuan', hidden:true}, 
				{name:'tgl_mastervaksin',index:'tgl_mastervaksin', width:100,align:'center'},
				{name:'myid',index:'myid', width:91,align:'center',hidden:true},
			],
			rowNum:5, 
			rowList:[10,20,30], 
			pager: jQuery('#pagermastervaksinpopup'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				nama=$('#namamastervaksinpopup').val()?$('#namamastervaksinpopup').val():'';
				$('#listmastervaksinpopup').setGridParam({postData:{'nama':nama}})
			}
	}).navGrid('#pagermastervaksinpopup',{edit:false,add:false,del:false,search:false});
	
	function formatterAction(cellvalue, options, rowObject) {
		var content = '';
		return '<input type="checkbox" class="chk" name="chk[]" />';
		return content;
	}	
	
	$(".chk").live('click', function(){		
		$("#listmastervaksinpopup").find('input[type=checkbox]').each(function() {
			$(this).change( function(){
				var colid = $(this).parents('tr:last').attr('id');
				if( $(this).is(':checked')) {
					$("#listmastervaksinpopup").jqGrid('setSelection', colid );
					$(this).prop('checked',true);
					var myCellDataId = jQuery('#listmastervaksinpopup').jqGrid('getCell', colid, 'myid');
					var myCellDataNamavaksin = jQuery('#listmastervaksinpopup').jqGrid('getCell', colid, 'nama_vaksin');
					$('#<?=$id_caller?> #nama_vaksin_hidden').val(myCellDataId);
					$('#<?=$id_caller?> #nama_vaksin').val(myCellDataNamavaksin);
					$("#dialogmastervaksinpopup").dialog("close");
				}
			});	
		});
	});
	
	$('form').resize(function(e) {
		if($("#listmastervaksinpopup").getGridParam("records")>0){
		jQuery('#listmastervaksinpopup').setGridWidth(($(this).width()));
		}
	});
	
	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	$("#resetmastervaksinpopup").live('click', function(event){
		event.preventDefault();
		$('#formmastervaksinpopup').reset();
		$('#listmastervaksinpopup').trigger("reloadGrid");
	});
	$("#carimastervaksinpopup").live('click', function(event){
		event.preventDefault();
		$('#listmastervaksinpopup').trigger("reloadGrid");
	});
	
})
</script>

<div class="mycontent">
	<form id="formmastervaksinpopup">
		<div class="gridtitle">Daftar Master Vaksin</div>
		<fieldset style="margin:0 13px 0 13px ">
						<span>
				<label>Nama Puskesmas</label>
				<input type="text" name="nama" class="nama" id="namamastervaksinpopup"/>
				</span>
				<span>
				<input type="submit" class="cari" value="&nbsp;Cari&nbsp;" id="carimastervaksinpopup" />
				<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="resetmastervaksinpopup" />
				
		</fieldset>
		<table id="listmastervaksinpopup"></table>
		<div id="pagermastervaksinpopup"></div>
	</form>
</div>