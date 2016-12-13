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
.declabel{width:9px}
.declabel2{width:215px}
.decinput{width:99px}
</style>

<script>
$(document).ready(function(){
		$('#form1transaksi_pemeriksaanneonatus_add').ajaxForm({
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
				$("#t341","#tabs").empty();
				$("#t341","#tabs").load('t_pemeriksaan_neonatus'+'?_=' + (new Date()).getTime());
			}
			achtungHideLoader();
		}
		});	
		
		jQuery("#listprodukibu").jqGrid({
			datatype: 'clientSide',
			rownumbers:true,
			width: 580,
			height: 'auto',
			colNames:['Kode Produk','Tindakan Ibu'],
			colModel :[ 
			{name:'kdprodukibu',index:'kdprodukibu', width:55,align:'center',hidden:true}, 
			{name:'produkibu',index:'produkibu', width:801}
			],
			rowNum:35,
			viewrecords: true
		}); 
		
		jQuery("#listprodukanak").jqGrid({
			datatype: 'clientSide',
			rownumbers:true,
			width: 580,
			height: 'auto',
			colNames:['Kode Produk','Tindakan Anak'],
			colModel :[ 
			{name:'kdprodukanak',index:'kdprodukanak', width:55,align:'center',hidden:true}, 
			{name:'produkanak',index:'produkanak', width:801}
			],
			rowNum:35,
			viewrecords: true
		}); 
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		var produkibuid = 0;
		$('#tambahprodukibuid').click(function(){
			if($('#produkibusearch_tmpval').val()){
				var myfirstrow = {kdprodukibu:$('#produkibusearch_tmpval').val(), produkibu:$('#produkibusearch_tmptext').val()};
				jQuery("#listprodukibu").addRowData(produkibuid+1, myfirstrow);
				$('#produkibusearch').val('');
				$('#produkibusearch_tmptext').val('');
				$('#produkibusearch_tmpval').val('');
				if(confirm('Tambah Data Produk Lain?')){
					$('#produkibusearch').focus();					
				}
			}else{
				alert('Silahkan Pilih Produk.');
			}
		})
		
		var produkanakid = 0;
		$('#tambahprodukanakid').click(function(){
			if($('#produkanaksearch_tmpval').val()){
				var myfirstrow = {kdprodukanak:$('#produkanaksearch_tmpval').val(), produkanak:$('#produkanaksearch_tmptext').val()};
				jQuery("#listprodukanak").addRowData(produkanakid+1, myfirstrow);
				$('#produkanaksearch').val('');
				$('#produkanaksearch_tmptext').val('');
				$('#produkanaksearch_tmpval').val('');
				if(confirm('Tambah Data Produk Lain?')){
					$('#produkanaksearch').focus();					
				}
			}else{
				alert('Silahkan Pilih Produk.');
			}
		})
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$('#hapusprodukibuid').click(function(){
			jQuery("#listprodukibu").clearGridData();
		})
		
		$('#hapusprodukanakid').click(function(){
			jQuery("#listprodukanak").clearGridData();
		})
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		
		$("#form1transaksi_pemeriksaanneonatus_add").validate({focusInvalid:true});

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


			$('#form1transaksi_pemeriksaanneonatus_add :submit').click(function(e) {
			e.preventDefault();
			if($("#form1transaksi_pemeriksaanneonatus_add").valid()) {
				if(kumpularray())$('#form1transaksi_pemeriksaanneonatus_add').submit();
			}
			return false;
		});

			$( "#produkibusearch" ).catcomplete({
			source: "t_registrasi_bayi/produkibusource",
			minLength: 1,
			select: function( event, ui ) {
			//log( ui.item ?"Selected: " + ui.item.value + " aka " + ui.item.id :"Nothing selected, input was " + this.value );
				$('#produkibusearch_tmpval').val(ui.item.id);
				$('#produkibusearch_tmptext').val(ui.item.label);
				//$('#selectjeniskasusid').focus();
			}
		});
		
		$( "#produkanaksearch" ).catcomplete({
			source: "t_registrasi_bayi/produkanaksource",
			minLength: 1,
			select: function( event, ui ) {
			//log( ui.item ?"Selected: " + ui.item.value + " aka " + ui.item.id :"Nothing selected, input was " + this.value );
				$('#produkanaksearch_tmpval').val(ui.item.id);
				$('#produkanaksearch_tmptext').val(ui.item.label);
				//$('#selectjeniskasusid').focus();
			}
		});
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		
		function kumpularray(){
		if($('#listprodukibu').getGridParam("records")>0){
			var rows= jQuery("#listprodukibu").jqGrid('getRowData');
			var paras=new Array();
			for(var i=0;i<rows.length;i++){
				var row = rows[i];
				paras.push(JSON.stringify(row));
				//paras.push($.param(row));
			}
			$("#produkibu_final").val(JSON.stringify(paras));
		}
		
	return true;
				
	}
	
		function kumpularray(){
		if($('#listprodukanak').getGridParam("records")>0){
			var rows= jQuery("#listprodukanak").jqGrid('getRowData');
			var paras=new Array();
			for(var i=0;i<rows.length;i++){
				var row = rows[i];
				paras.push(JSON.stringify(row));
				//paras.push($.param(row));
			}
			$("#produkanak_final").val(JSON.stringify(paras));
		}
		
	return true;
				
	}
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	$("#form1transaksi_pemeriksaanneonatus_add").validate({
		rules: {
			tanggal_lahir: {
				date:true,
				required: true
			},
			tanggal_daftar: {
				date:true,
				required: true
			},
			tglkunjungan: {
				date:true,
				required: true
			}
		},
		messages: {
			tanggal_lahir: {
				date: "Silahkan Masukkan Tanggal Sesuai Format",
				required:"Silahkan Lengkapi Data"
			},tanggal_daftar: {
				date: "Silahkan Masukkan Tanggal Sesuai Format",
				required:"Silahkan Lengkapi Data"
			},tglkunjungan: {
				date: "Silahkan Masukkan Tanggal Sesuai Format",
				required:"Silahkan Lengkapi Data"
			}
		}
	});
	
	$("#tglkunjungan").mask("99/99/9999");
		
		
})
</script>
<script>
	$('#backlisttransaksi_pemeriksaanneonatus').click(function(){
		$("#t341","#tabs").empty();
		$("#t341","#tabs").load('t_pemeriksaan_neonatus'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div class="formtitle">Pemeriksaan Neonatus</div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="form1transaksi_pemeriksaanneonatus_add" method="post" action="<?=site_url('t_pemeriksaan_neonatus/addprocess')?>" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Kode Pemeriksaan Neonatus</label>
		<input type="text" placeholder="Otomatis" readonly name="kodepemeriksaanneonatus" id="kodepemeriksaanneonatus" value="" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Tanggal</label>
		<input type="text" name="tglkunjungan" id="tglkunjungan" class="mydate" value="<?=date('d/m/Y')?>" required  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Kunjungan ke</label>
		<input type="text" name="kunjunganke" id="kunjunganke" value="" required />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Berat Badan (kg)</label>
		<input type="text" name="beratbadan" id="beratbadan" value="" required />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Panjang Badan (cm)</label>
		<input type="text" name="panjangbadan" id="panjangbadan" value="" required />
		</span>
	</fieldset>
	<table id="listprodukanak"></table>
	<fieldset id="fieldsdiagnosarawatjalan">
		<span>
		<label class="declabel2">Tindakan Anak</label>
		<input type="text" name="text" value="" id="produkanaksearch" />
		
		<input type="hidden" name="produkanaksearch_tmpval" id="produkanaksearch_tmpval" />
		<input type="hidden" name="produkanaksearch_tmptext" id="produkanaksearch_tmptext" />
		<input type="button" value="Tambah" id="tambahprodukanakid" />
		<input type="button" id="hapusprodukanakid" value="Hapus" />
		</span>
	</fieldset>	
	<table id="listprodukibu"></table>
	<fieldset id="fieldsdiagnosarawatjalan">
		<span>
		<label class="declabel2">Tindakan Ibu</label>
		<input type="text" name="text" value="" id="produkibusearch" />
		
		<input type="hidden" name="produkibusearch_tmpval" id="produkibusearch_tmpval" />
		<input type="hidden" name="produkibusearch_tmptext" id="produkibusearch_tmptext" />
		<input type="button" value="Tambah" id="tambahprodukibuid" />
		<input type="button" id="hapusprodukibuid" value="Hapus" />
		</span>
	</fieldset>		
	<fieldset>
		<span>
		<label>Keluhan Ibu</label>
		<textarea name="keluhan" rows="3" cols="23"> </textarea> 
		</span>
	</fieldset>
	<fieldset>
		<?=getComboDokterPemeriksa('','pemeriksa','pemeriksa','required','inline')?>
	</fieldset>
	<fieldset>
		<?=getComboDokterPetugas('','petugas','petugas','required','inline')?>
	</fieldset>
</form>
</div >