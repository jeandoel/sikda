<script>
jQuery().ready(function (){ 
	jQuery("#listsysSettingdefpopup").jqGrid({ 
		url:'c_sys_setting_def/syssettingdefxml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['KODE','id1','Kode Provinsi','Kode Kabupaten/Kota','Kode Kecamatan','Kode Desa','Kode Puskesmas','Action'],
		rownumbers:true,
		width: 1021,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[ 
				{name:'id',index:'id', width:25,align:'center',formatter:formatterAction}, 
				{name:'id1',index:'id1', width:25,align:'center',hidden:false}, 
				{name:'prov',index:'prov', width:100}, 
				{name:'kabkot',index:'kabkot', width:100}, 
				{name:'kec',index:'kec', width:100}, 
				{name:'desa',index:'desa', width:100}, 
				{name:'kdpus',index:'kdpus', width:100}, 
				{name:'myid',index:'myid', width:91,align:'center',hidden:true}
			],
			rowNum:5, 
			rowList:[5,10,20,30], 
			pager: jQuery('#pagersysSettingdefpopup'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				carinama=$('#namasysSettingdefpopup').val()?$('#namasysSettingdefpopup').val():'';
				$('#listsysSettingdefpopup').setGridParam({postData:{'dari':'','sampai':'','carinama':carinama}})
			}
	}).navGrid('#pagersysSettingdefpopup',{edit:false,add:false,del:false,search:false});
	
	function formatterAction(cellvalue, options, rowObject) {
		var content = '';
		return '<input type="checkbox" class="chk" name="chk[]" id="chksysSettingdef" />';
		return content;
	}	
	
	$("#chksysSettingdef.chk").live('click', function(){		
		$("#listsysSettingdefpopup").find('input[type=checkbox]').each(function() {
			$(this).change( function(){
				var colid = $(this).parents('tr:last').attr('id');
				if( $(this).is(':checked')) {
					$("#listsysSettingdefpopup").jqGrid('setSelection', colid );
					$(this).prop('checked',true);
					var myCellDataId = jQuery('#listsysSettingdefpopup').jqGrid('getCell', colid, 'myid');
					var myCellDataColumn1 = jQuery('#listsysSettingdefpopup').jqGrid('getCell', colid, 'nama');
					$('#<?=$id_caller?> #sys_setting_def_id_hidden').val(myCellDataId);
					$('#<?=$id_caller?> #sys_setting_def_id').val(myCellDataColumn1);
					$("#dialogcari_sys_setting_def_id").dialog("close");
				}
			});	
		});
	});
	
	$('form').resize(function(e) {
		if($("#listsysSettingdefpopup").getGridParam("records")>0){
		jQuery('#listsysSettingdefpopup').setGridWidth(($(this).width()));
		}
	});
	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	$("#resetsysSettingdefpopup").live('click', function(event){
		event.preventDefault();
		$('#formsysSettingdefpopup').reset();
		$('#listsysSettingdefpopup').trigger("reloadGrid");
	});
	$("#carisysSettingdefpopup").live('click', function(event){
		event.preventDefault();
		$('#listsysSettingdefpopup').trigger("reloadGrid");
	});
	
})
</script>

<div class="mycontent">
	<form id="formsysSettingdefpopup">
	<fieldset style="margin:0 13px 0 13px ">
		<span>
		<label>Cari Profil Aplikasi</label>
		</span>
		<span>
		<input type="text" name="carinama" class="nama" size="3" id="namasysSettingdefpopup" autocomplete="off">
		<input type="submit" class="cari" value="&nbsp;Cari&nbsp;" id="carisysSettingdefpopup"/>
		<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="resetsysSettingdefpopup"/>
		</span>
	</fieldset>
		<table id="listsysSettingdefpopup"></table>
		<div id="pagersysSettingdefpopup"></div>
		</div >
	</form>
</div>