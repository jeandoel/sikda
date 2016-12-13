<script>
jQuery().ready(function (){ 
	jQuery("#listsaranaposyandupopup").jqGrid({ 
		url:'c_master_sarana_posyandu/saranaposyanduxml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['ID','Kode Sarana','Nama Sarana','Keterangan','Tanggal','Action'],
		rownumbers:true,
		width: 1021,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[ 
				{name:'id',index:'id', width:10,formatter:formatterAction}, 
				{name:'kodesaranaposyandu',index:'kodesaranaposyandu', width:50,hidden:true}, 
				{name:'namasaranaposyandu',index:'namasaranaposyandu', width:90}, 
				{name:'keterangan',index:'keterangan', width:120,hidden:true},
				{name:'tgl_sarana_posyandu',index:'tgl_sarana_posyandu', width:70,align:'center'},
				{name:'myid',index:'myid', width:90,align:'center',hidden:true}
			],
			rowNum:10, 
			rowList:[10,20,30], 
			pager: jQuery('#pagersaranaposyandupopup'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				nama=$('#namasaranaposyandupopup').val()?$('#namasaranaposyandupopup').val():'';
				$('#listsaranaposyandupopup').setGridParam({postData:{'dari':'','sampai':'','nama':nama}})
			}
	}).navGrid('#pagersaranaposyandupopup',{edit:false,add:false,del:false,search:false});
	
	function formatterAction(cellvalue, options, rowObject) {
		var content = '';
		return '<input type="checkbox" class="chk" name="chk[]" />';
		return content;
	}	
	
	$(".chk").live('click', function(){		
		$("#listsaranaposyandupopup").find('input[type=checkbox]').each(function() {
			$(this).change( function(){
				var colid = $(this).parents('tr:last').attr('id');
				if( $(this).is(':checked')) {
					$("#listsaranaposyandupopup").jqGrid('setSelection', colid );
					$(this).prop('checked',true);
					var myCellDataId = jQuery('#listsaranaposyandupopup').jqGrid('getCell', colid, 'myid');
					var myCellDataNamasaranaposyandu = jQuery('#listsaranaposyandupopup').jqGrid('getCell', colid, 'namasaranaposyandu');
					$('#<?=$id_caller?> #nama_sarana_posyandu_hidden').val(myCellDataId);
					$('#<?=$id_caller?> #nama_sarana_posyandu').val(myCellDataNamasaranaposyandu);
					$("#dialogtransaksisaranaposyandumasuk_cari_namasaranaposyandu").dialog("close");
				}
			});	
		});
	});
	
	$('form').resize(function(e) {
		if($("#listsaranaposyandupopup").getGridParam("records")>0){
		jQuery('#listsaranaposyandupopup').setGridWidth(($(this).width()));
		}
	});
	
	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	$("#resetsaranaposyandupopup").live('click', function(event){
		event.preventDefault();
		$('#formsaranaposyandupopup').reset();
		$('#listsaranaposyandupopup').trigger("reloadGrid");
	});
	$("#carisaranaposyandupopup").live('click', function(event){
		event.preventDefault();
		$('#listsaranaposyandupopup').trigger("reloadGrid");
	});
	
})
</script>

<div class="mycontent">
	<form id="formsaranaposyandupopup">
		<div class="gridtitle">Daftar Sarana Posyandu</div>
		<fieldset style="margin:0 13px 0 13px ">
			<span>
				<label>Nama Sarana Posyandu</label>
				<input type="text" name="nama" class="nama" id="namasaranaposyandupopup"/>
			</span>
			<span>
				<input type="submit" class="cari" value="&nbsp;Cari&nbsp;" id="carisaranaposyandupopup" />
				<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="resetsaranaposyandupopup" />
			</span>
		</fieldset>
		<table id="listsaranaposyandupopup"></table>
		<div id="pagersaranaposyandupopup"></div>
	</form>
</div>