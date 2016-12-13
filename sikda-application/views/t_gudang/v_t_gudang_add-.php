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
<script type="text/javascript" src="<?=base_url()?>assets/js/date.format.js"></script>
<script>
$('document').ready(function() {		
	$('#form1t_gudangadd').ajaxForm({
		beforeSend: function() {
			achtungShowLoader();
		},
		uploadProgress: function(event, position, total, percentComplete) {
		},
		complete: function(xhr) {			
			if(xhr.responseText!=='OK'){
				$.achtung({message: xhr.responseText, timeout:5});
			}else{
				$.achtung({message: 'Proses Berhasil', timeout:5});
				$("#t304","#tabs").empty();
				$("#t304","#tabs").load('t_gudang'+'?_=' + (new Date()).getTime());
			}
			achtungHideLoader();
		}
	});
	
	$("#form1t_gudangadd").validate({
		rules: {
			tanggal: {
				date:true,
				required: true
			},
			duedate: {
				date:true,
				required: true
			}
		},
		messages: {
			tanggalt_gudangadd: {
				date: "Silahkan Masukkan Tanggal Sesuai Format",
				required:"Silahkan Lengkapi Data"
			},duedatet_gudangadd: {
				date: "Silahkan Masukkan Tanggal Sesuai Format",
				required:"Silahkan Lengkapi Data"
			}
		}
	});
	
	jQuery("#listobatrawatjalan").jqGrid({
			datatype: 'clientSide',
			rownumbers:true,
			width: 1049,
			height: 'auto',
			colNames:['Kode Obat','Obat','Batch','Kadaluarsa','Harga Beli','Jumlah','Diskon','PPN'],
			colModel :[ 
			{name:'kd_obat',index:'kd_obat', width:55,align:'center'}, 
			{name:'obat',index:'obat', width:300}, 
			{name:'batch',index:'batch', width:81}, 
			{name:'kadaluarsa',index:'kadaluarsa', width:81}, 
			{name:'harga',index:'harga', width:81}, 
			{name:'jumlah',index:'jumlah', width:51,align:'center'},
			{name:'diskon',index:'diskon', width:51,align:'center'},
			{name:'ppn',index:'ppn', width:51,align:'center'}
			],
			rowNum:35,
			viewrecords: true
	});	
})

$('#tanggalt_gudangadd').datepicker({dateFormat: "dd/mm/yy",changeYear: true});
$('#duedatet_gudangadd').datepicker({dateFormat: "dd/mm/yy",changeYear: true});
$('#expired_datet_gudangadd').datepicker({dateFormat: "dd/mm/yy",changeYear: true});
$("#tanggalt_gudangadd").mask("99/99/9999");
$("#duedatet_gudangadd").mask("99/99/9999");
$("#expired_datet_gudangadd").mask("99/99/9999");

$("#form1t_gudangadd").validate({focusInvalid:true});

var obatid = 0;
$('#tambahobatid').click(function(){
			if($('#obat_tmpval').val()){
				var myfirstrow = {kd_obat:$('#obat_tmpval').val(), obat:$('#obat_tmptext').val(), jumlah:$('#kuantitasobatid').val(), batch:$('#no_batcht_gudangadd').val(), kadaluarsa:$('#expired_datet_gudangadd').val(), harga:$('#harga_belit_gudangadd').val(), diskon:$('#diskont_gudangadd').val(), ppn:$('#ppnt_gudangadd').val()};
				jQuery("#listobatrawatjalan").addRowData(obatid+1, myfirstrow);
				$('#obatsearch').val('');
				$('#kuantitasobatid').val('');
				$('#satuan_obatid').val('');
				$('#kuantitasobatid').val('');
				$('#obat_tmptext').val('');
				$('#obat_tmpval').val('');
				$('#no_batcht_gudangadd').val('');
				$('#expired_datet_gudangadd').val('');
				$('#harga_belit_gudangadd').val('');
				$('#diskont_gudangadd').val('');
				$('#ppnt_gudangadd').val('');
				if(confirm('Tambah Obat Lain?')){
					$('#obatsearch').focus();					
				}else{
					$('#statuskeluarid').focus();
				}
			}else{
				alert('Silahkan Pilih Obat.');
			}
});

$('#hapusobatid').click(function(){
			jQuery("#listobatrawatjalan").clearGridData();
});

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

$( "#obatsearch" ).catcomplete({
	source: "t_gudang/obatsource",
	minLength: 1,
	select: function( event, ui ) {
		$('#obat_tmpval').val(ui.item.id);
		$('#obat_tmptext').val(ui.item.label);
	}
});

//$("#form1t_gudangadd input:text").first().focus();
$("#nama_lengkapt_gudangadd").focus();
</script>
<script>
	$("#form1t_gudangadd input[name = 'batal'], #backlistt_gudang").click(function(){
		$("#t304","#tabs").empty();
		$("#t304","#tabs").load('t_gudang'+'?_=' + (new Date()).getTime());
	});
	
	$('#form1t_gudangadd :submit').click(function(e) {
	e.preventDefault();
	if($("#form1t_gudangadd").valid()) {
		if(kumpularray())$('#form1t_gudangadd').submit();
	}
	return false;
	});
</script>
<script>
	function kumpularray(){
		if($('#listobatrawatjalan').getGridParam("records")>0){
			var rows= jQuery("#listobatrawatjalan").jqGrid('getRowData');
			var paras=new Array();
			for(var i=0;i<rows.length;i++){
				var row = rows[i];
				paras.push(JSON.stringify(row));
			}
			$("#obat_final").val(JSON.stringify(paras));
		}
		
		return true;
				
	}
</script>
<script>
	$("#kd_terimat_gudangadd").focus();
</script>
<div class="mycontent">
<div class="formtitle">Stock Obat Baru</div>
<div class="backbutton"><span class="kembali" id="backlistt_gudang">kembali ke list</span></div>
</br>
<span id='errormsg'></span>
<div id="form_obat_masuk">
<form name="frApps" id="form1t_gudangadd" method="post" action="<?=site_url('t_gudang/addprocess')?>" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Kode Penerimaan</label>
		<input type="text" name="kd_terima" id="kd_terimat_gudangadd" value="" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Nomor Faktur*</label>
		<input type="text" name="no_faktur" id="no_fakturt_gudangadd" value="" required  />
		</span>
		<span>
		<label>Tanggal* (dd/mm/yyyy)</label>
		<input type="text" name="tanggal_terima" id="tanggalt_gudangadd" class="mydate" value="<?=date('d/m/Y')?>" required  />
		</span>
	</fieldset>	
	<fieldset>
		<?=getComboVendor('','from','fromt_gudang','required','inline')?>
		<span>
		<label>DueDate* (dd/mm/yyyy)</label>
		<input type="text" name="duedate" id="duedatet_gudangadd" class="mydate" value="" required  />
		</span>
	</fieldset>
	<fieldset>
		<!--<?=getComboPemilikobat('','kd_milik_obat','kd_milik_obatt_gudangadd','required','inline')?>-->
		<?=getComboPenerima('','nama_unit','nama_unitt_gudang','required','inline')?><br/>
		<span>
		<label>Catatan</label>
		<textarea name="catatan" id="catatant_gudangadd" value="" style="width:197px"></textarea>
		</span>
	</fieldset>
	<div class="subformtitle">Data Obat</div>
	<table id="listobatrawatjalan"></table>
	<fieldset id="fieldstindakanrawatjalan">
		<span>
		<label>Cari Obat</label>
		<input type="text" name="text" value="" id="obatsearch" style="width:255px;" />
		</span>	
	</fieldset>
	<fieldset>
		<span>
		<label>No. Batch*</label>
		<input type="text" name="no_batch" id="no_batcht_gudangadd" value="" />
		</span>
		<span>
		<label>Kadaluarsa* (dd/mm/yyyy)</label>
		<input type="text" name="expired" id="expired_datet_gudangadd" class="mydate" value="<?=date('d/m/Y')?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Harga*</label>
		<input type="text" name="harga_beli" id="harga_belit_gudangadd" value="" />
		</span>
		<span>
		<label>Diskon</label>
		<input type="text" name="diskon" id="diskont_gudangadd" value="" style="width:50px" />%
		</span>
		<span>
	</fieldset>
	<fieldset>
		<span>
		<label>PPN</label>
		<input type="text" name="ppn" id="ppnt_gudangadd" value="10" style="width:50px" />%
		</span>
		<span>
		<label style="width:37px">Qty</label>
			<input type="text" name="kuantitastindakan" id="kuantitasobatid"  style="width:39px" />
			<input type="hidden" name="obat_tmpval" id="obat_tmpval" />
			<input type="hidden" name="obat_tmptext" id="obat_tmptext" />
			<input type="hidden" name="obat_final" id="obat_final" />
		</span>
		<span>
		<input type="button" value="Tambah" id="tambahobatid" />
		<input type="button" value="Hapus" id="hapusobatid" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<input type="button" name="batal" value="Batal" />
		&nbsp; - &nbsp;
		<input type="submit" name="bt1" value="Proses Data"/>
		</span>
	</fieldset>	
</form>
</div>
<div id="form_obat_keluar"></div>
</div >