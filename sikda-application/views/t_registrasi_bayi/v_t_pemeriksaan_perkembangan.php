<style>
.ui-menu-item{
	font-size:.59em;
	color:blue!important;
}
.ui-autocomplete-category {
	font-weight: bold;
	padding: .1em .1.5em;
	margin: .8em 0 .2em;
	line-height: 1.5;
	font-size:.71em;
}
.ui-autocomplete{
	width:355px!important;
}
.inputaction1{
	width:255px;font-weight:bold;
}
.inputaction2{
	width:255px;font-weight:bold;color:#0B77B7
}
.labelaction{
	font-weight:bold;font-size:1.05em;color:#0B77B7;width:175px;
}
.declabel{width:91px}
.declabel2{width:175px}
.decinput{width:99px}
</style>
<script>
$(document).ready(function(){
		$('#form1t_pemeriksaan_kesehatan_anakadd').ajaxForm({
			beforeSend: function() {
				achtungShowLoader();	
			},
			uploadProgress: function(event, position, total, percentComplete) {
			},
			complete: function(xhr) {
				achtungHideLoader();
				if(xhr.responseText!=='OK'){
					$.achtung({message: xhr.responseText, timeout:5});
				}else{
					$.achtung({message: 'Proses Tambah Data Berhasil', timeout:5});
					$("#t321","#tabs").empty();
					$("#t321","#tabs").load('t_pemeriksaan_kesehatan_anak'+'?_=' + (new Date()).getTime());
				}
			}
		});
		
		jQuery("#listpenyakit").jqGrid({
			datatype: 'clientSide',
			rownumbers:true,
			width: 580,
			height: 'auto',
			colNames:['Kode Penyakit','Penyakit'],
			colModel :[ 
			{name:'kd_penyakit',index:'kd_penyakit', width:55,align:'center',hidden:true}, 
			{name:'penyakit',index:'penyakit', width:81}
			],
			rowNum:35,
			viewrecords: true
		}); 
		
		jQuery("#listtindakan").jqGrid({
			datatype: 'clientSide',
			rownumbers:true,
			width: 580,
			height: 'auto',
			colNames:['Kode Tindakan','Tindakan'],
			colModel :[ 
			{name:'kd_tindakan',index:'kd_tindakan', width:55,align:'center',hidden:true}, 
			{name:'tindakan',index:'tindakan', width:81}
			],
			rowNum:35,
			viewrecords: true
		});
		
			var penyakitid = 0;
		$('#tambahpenyakitid').click(function(){
			if($('#penyakitsearch_tmpval').val()){
				var myfirstrow = {kd_penyakit:$('#penyakitsearch_tmpval').val(),penyakit:$('#penyakitsearch_tmptext').val()};
				jQuery("#listpenyakit").addRowData(penyakitid+1, myfirstrow);
				$('#penyakitsearch').val('');
				$('#penyakitsearch_tmpval').val('');
				$('#penyakitsearch_tmptext').val('');
				if(confirm('Tambah Data Diagnosa Penyakit?')){
					$('#penyakitsearch').focus();					
				}
			}else{
				alert('Silahkan Pilih Diagnosa.');
			}
		})	
		
			var tindakanid = 0;
		$('#tambahtindakanid').click(function(){
			if($('#tindakansearch_tmpval').val()){
				var myfirstrow = {kd_tindakan:$('#tindakansearch_tmpval').val(),tindakan:$('#tindakansearch_tmptext').val()};
				jQuery("#listtindakan").addRowData(tindakanid+1, myfirstrow);
				$('#tindakansearch').val('');
				$('#tindakansearch_tmpval').val('');
				$('#tindakansearch_tmptext').val('');
				if(confirm('Tambah Data Diagnosa Tindakan?')){
					$('#tindakansearch').focus();					
				}
			}else{
				alert('Silahkan Pilih Diagnosa.');
			}
		})	
		
	$('#hapuspenyakitid').click(function(){
			jQuery("#listpenyakit").clearGridData();
		})
		
	$('#hapustindakanid').click(function(){
			jQuery("#listtindakan").clearGridData();
		})
		
		$("#form1t_pemeriksaan_kesehatan_anakadd").validate({
		rules: {
				tgl_periksa: {
				date:true,
				required: true
			}
		},
		messages: {
				tgl_periksa: {
				date: "Silahkan Masukkan Tanggal Sesuai Format",
				required:"Silahkan Lengkapi Data"
			}
		}
	});

})	

$("#form1t_pemeriksaan_kesehatan_anak_add").validate({focusInvalid:true});

$.widget( "custom.catcomplete", $.ui.autocomplete, {
	_renderMenu: function( ul, items ) {
		var that = this,
		currentCategory = "";
		$.each( items, function( index, item ) {
		if ( item.category != currentCategory ) {
			ul.append( "<li class='ui-autocomplete-category'>" + item.category + "</li>" );
			currentCategory = item.category;
		}
			that._renderItemData( ul, item );
		});
	}
});

$('#form1t_pemeriksaan_kesehatan_anak_add :submit').click(function(e) {
	e.preventDefault();
	if($("#form1t_pemeriksaan_kesehatan_anak_add").valid()) {
		if(kumpularray())$('#form1t_pemeriksaan_kesehatan_anak_add').submit();
	}
	return false;
});

$( "#penyakitsearch" ).catcomplete({
		source: "t_registrasi_bayi/icdsource",
		minLength: 1,
		select: function( event, ui ) {
			$('#penyakitsearch_tmpval').val(ui.item.id);
			$('#penyakitsearch_tmptext').val(ui.item.label);
		}
});

$( "#tindakansearch" ).catcomplete({
		source: "t_registrasi_bayi/produksource",
		minLength: 1,
		select: function( event, ui ) {
			$('#tindakansearch_tmpval').val(ui.item.id);
			$('#tindakansearch_tmptext').val(ui.item.label);
		}
});
	
$("#tgl_periksa").mask("99/99/9999");

</script>
<script>
	function kumpularray(){
		if($('#listpenyakit').getGridParam("records")>0){
			var rows= jQuery("#listpenyakit").jqGrid('getRowData');
			var paras=new Array();
			for(var i=0;i<rows.length;i++){
				var row = rows[i];
				paras.push(JSON.stringify(row));
				//paras.push($.param(row));
			}
			$("#penyakit_final").val(JSON.stringify(paras));
		}
		if($('#listtindakan').getGridParam("records")>0){
			var rows= jQuery("#listtindakan").jqGrid('getRowData');
			var paras=new Array();
			for(var i=0;i<rows.length;i++){
				var row = rows[i];
				paras.push(JSON.stringify(row));
			}
			$("#tindakan_final").val(JSON.stringify(paras));
		}

		return true;
				
	}
</script>
<script>
	$('#backlistt_pemeriksaan_kesehatan_anak').click(function(){
		$("#t321","#tabs").empty();
		$("#t321","#tabs").load('t_pemeriksaan_kesehatan_anak'+'?_=' + (new Date()).getTime());
	})
	$("#form1t_pemeriksaan_kesehatan_anak_add input[name = 'batal'], #backlistt_pemeriksaan_kesehatan_anak").click(function(){
		$("#t321","#tabs").empty();
		$("#t321","#tabs").load('t_pemeriksaan_kesehatan_anak'+'?_=' + (new Date()).getTime());
	});
</script>
<div class="mycontent">
<div class="formtitle">Pemeriksaan Kesehatan Anak</div>
<br/>
<span id='errormsg'></span>
<form name="frApps" id="form1t_pemeriksaan_kesehatan_anakadd" method="post" action="<?=site_url('t_pemeriksaan_kesehatan_anak/addprocess')?>" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Tanggal Periksa</label>
		<input id="tgl_periksa" class="mydate" type="text" name="tgl_periksa" value="<?=date('d/m/Y')?>" required>
		</span>
	</fieldset>
	<table id="listpenyakit"></table>
	<fieldset id="fieldspenyakit">
		<span>
		<label>Cari Jenis  Masalah / Penyakit</label>
		<input type="text" name="text" value="" id="penyakitsearch" />
		</span>
		<span>
		<input type="hidden" name="penyakitsearch_tmpval" id="penyakitsearch_tmpval" />
		<input type="hidden" name="penyakitsearch_tmptext" id="penyakitsearch_tmptext" />
		<input type="button" value="Tambah" id="tambahpenyakitid" />
		<input type="button" id="hapuspenyakitid" value="Hapus" />
		</span>
	</fieldset>
	<table id="listtindakan"></table>
	<fieldset id="fieldstindakan">
		<span>
		<label>Cari Tindakan</label>
		<input type="text" name="text" value="" id="tindakansearch" />
		</span>
		<span>
		<input type="hidden" name="tindakansearch_tmpval" id="tindakansearch_tmpval" />
		<input type="hidden" name="tindakansearch_tmptext" id="tindakansearch_tmptext" />
		<input type="button" value="Tambah" id="tambahtindakanid" />
		<input type="button" id="hapustindakanid" value="Hapus" />
		</span>
	</fieldset>
	<fieldset>
		<?=getComboPemeriksa('','kolom_nama_pemeriksa','kolom_nama_pemeriksa','required','inline')?>
	</fieldset>
</form>
</div >