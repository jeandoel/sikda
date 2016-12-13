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
		$('#form1t_pelayanan_kb_add').ajaxForm({
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
					$("#t381","#tabs").empty();
					$("#t381","#tabs").load('t_pelayanan_kb'+'?_=' + (new Date()).getTime());
				}
			}
		});
		
			jQuery("#listtindakan").jqGrid({
			datatype: 'clientSide',
			rownumbers:true,
			width: 578,
			height: 'auto',
			colNames:['Kode Produk','Tindakan'],
			colModel :[ 
			{name:'kdproduk',index:'kdproduk', width:55,align:'center',hidden:true}, 
			{name:'produk',index:'produk', width:801}
			],
			rowNum:35,
			viewrecords: true
		}); 
		
		
		var tindakanid = 0;
		$('#tambahtindakanid').click(function(){
			if($('#tindakansearch_tmpval').val()){
				var myfirstrow = {kdproduk:$('#tindakansearch_tmpval').val(), produk:$('#tindakansearch_tmptext').val()};
				jQuery("#listtindakan").addRowData(tindakanid+1, myfirstrow);
				$('#tindakansearch').val('');
				$('#tindakansearch_tmptext').val('');
				$('#tindakansearch_tmpval').val('');
				if(confirm('Tambah Data Tindakan Lain?')){
					$('#tindakansearch').focus();					
				}
			}else{
				alert('Silahkan Pilih Tindakan.');
			}
		})
		
		
		$('#hapustindakanid').click(function(){
			jQuery("#listtindakan").clearGridData();
		})
		
	
		
		$("#form1t_pelayanan_kb_add").validate({
		rules: {

				tanggalpemeriksaan: {
				date:true,
				required:true
			}
		},
		messages: {
				tanggalpemeriksaan: {
				date: "Silahkan Masukkan Tanggal Sesuai Format",
				required:"Silahkan Lengkapi Data"
			}
		}
	});
	
	$("#tanggalpemeriksaan").mask("99/99/9999");
	
	
})


$("#form1t_pelayanan_kb_add").validate({focusInvalid:true});

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

$('#form1t_pelayanan_kb_add :submit').click(function(e) {
	e.preventDefault();
	if($("#form1t_pelayanan_kb_add").valid()) {
		if(kumpularray())$('#form1t_pelayanan_kb_add').submit();
	}
	return false;
});

$( "#tindakansearch" ).catcomplete({
	source: "t_pelayanan_kb/tindakansource",
	minLength: 1,
	select: function( event, ui ) {
	//log( ui.item ?"Selected: " + ui.item.value + " aka " + ui.item.id :"Nothing selected, input was " + this.value );
		$('#tindakansearch_tmpval').val(ui.item.id);
		$('#tindakansearch_tmptext').val(ui.item.label);
		//$('#selectjeniskasusid').focus();
	}
});

function kumpularray(){
		if($('#listtindakan').getGridParam("records")>0){
			var rows= jQuery("#listtindakan").jqGrid('getRowData');
			var paras=new Array();
			for(var i=0;i<rows.length;i++){
				var row = rows[i];
				paras.push(JSON.stringify(row));
				//paras.push($.param(row));
			}
			$("#tindakan_final").val(JSON.stringify(paras));
		}
		
	return true;
				
	}


</script>
<script>
	$('#backlistt_pelayanan_kb').click(function(){
		$("#t381","#tabs").empty();
		$("#t381","#tabs").load('t_pelayanan_kb'+'?_=' + (new Date()).getTime());
	})
		$("#form1t_pelayanan_kb_add input[name = 'batal'], #backlistt_pelayanan_kb").click(function(){
		$("#t381","#tabs").empty();
		$("#t381","#tabs").load('t_pelayanan_kb'+'?_=' + (new Date()).getTime());
	});
</script>
<div class="mycontent">
<div class="formtitle">Tambah Transaksi Pelayanan KB</div>
<div class="backbutton"><span class="kembali" id="backlistt_pelayanan_kb">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="form1t_pelayanan_kb_add" method="post" action="<?=site_url('t_pelayanan_kb/addprocess')?>" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Tanggal</label>
		<input type="text" name="tanggalpemeriksaan" id="tanggalpemeriksaan" class="mydate" value="<?=date('d/m/Y')?>" required  />
		</span>
	</fieldset>
	
	<fieldset>
		<?=getComboJeniskb('','kdjeniskb','jeniskbt_pelayanan_kb_add','required','inline')?>	
	</fieldset>
	<fieldset>
		<span>
		<label>Keluhan</label>
		<input type="text" name="keluhan" id="text2" value="" required />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Anamnese</label>
		<textarea name="anamnese" id="text3" cols="30" rows="5" value="" required />
		</span>
	</fieldset>
	<table id="listtindakan"></table>
	<fieldset id="fieldsdiagnosarawatjalan">
		<span>
		<label>Tindakan</label>
		<input type="text" name="text" value="" id="tindakansearch" />
		
		<input type="hidden" name="tindakansearch_tmpval" id="tindakansearch_tmpval" />
		<input type="hidden" name="tindakansearch_tmptext" id="tindakansearch_tmptext" />
		<input type="button" value="Tambah" id="tambahtindakanid" />
		<input type="hidden" name="tindakan_final" id="tindakan_final" />
		<input type="button" id="hapustindakanid" value="Hapus" />
		</span>
	</fieldset>
		<fieldset>
		<?=getComboDokterPemeriksa('','pemeriksa','pemeriksa','required','inline')?>
	</fieldset>
	<fieldset>
		<?=getComboDokterPetugas('','petugas','petugas','required','inline')?>
	</fieldset>
	<fieldset>
		<span>
		<input type="button" name="batal" value="Batal" />
		&nbsp; - &nbsp;
		<input type="submit" name="bt1" value="Simpan"/>
		</span>
	</fieldset>	
</form>
</div >