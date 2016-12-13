<script>
jQuery().ready(function (){ 
	jQuery("#listpemeriksaansehatanak").jqGrid({ 
		url:'t_pemeriksaan_kesehatan_anak/t_pemeriksaan_kesehatan_anakxml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 					
		colNames:['id', 'id2', 'id3', 'Tanggal Kunjungan', 'Diagnosa', 'Tindakan', 'Pemeriksa', 'Petugas', 'e'],
		rownumbers:true,
		width: 1021,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[  
				{name:'id',index:'id', width:50, hidden:true}, 		
				{name:'id2',index:'id2', width:50, hidden:true},  
				{name:'id3',index:'id3', width:50, hidden:true},  
				{name:'penyakit',index:'penyakit', align:'center', width:50}, 
				{name:'tindakan',index:'tindakan', width:50}, 
				{name:'beratbadan',index:'beratbadan', width:50}, 
				{name:'pemeriksa',index:'pemeriksa', width:50}, 
				{name:'petugas',index:'petugas', width:70}, 
				{name:'keterangan',index:'keterangan', width:50, hidden:true}
			],
			rowNum:5, 
			rowList:[5,10,20,30], 
			pager: jQuery('#pagerpemeriksaansehatanak'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				// carinama=$('#carinamapemeriksaanneonatuspopup').val()?$('#carinamapemeriksaanneonatuspopup').val():'';
				get_kd_pasien=$('#get_kd_pasien_anak').val()?$('#get_kd_pasien_anak').val():'';
				$('#listpemeriksaansehatanak').setGridParam({postData:{'get_kd_pasien':get_kd_pasien}})
			}
	}).navGrid('#pagerpemeriksaansehatanak',{edit:false,add:false,del:false,search:false});
	
	function formatterAction(cellvalue, options, rowObject) {
		var content = '';
		return '<input type="checkbox" class="chk" name="chk[]" id="chkkab" />';
		return content;
	}	
	
	$('form').resize(function(e) {
		if($("#listpemeriksaansehatanak").getGridParam("records")>0){
		jQuery('#listpemeriksaansehatanak').setGridWidth(($(this).width()));
		}
	});
	
})
</script>
<div>
	<input type="hidden" name="get_kd_pasien_anak" id="get_kd_pasien_neo" value="<?php echo $get_kd_pasien?>">
</div>
<div class="mycontent">
	<form id="formpemeriksaansehatanak">
	<fieldset style="margin:0 13px 0 13px ">
		</fieldset>
		<table id="listpemeriksaansehatanak"></table>
		<div id="pagerpemeriksaansehatanak"></div>
		</div >
	</form>
</div>