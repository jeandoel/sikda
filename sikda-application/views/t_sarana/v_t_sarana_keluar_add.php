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
	$('#form1t_sarana_keluar_add').ajaxForm({
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
				$("#t305","#tabs").empty();
				$("#t305","#tabs").load('t_sarana'+'?_=' + (new Date()).getTime());
			}
			achtungHideLoader();
		}
	});
	
	$("#sub_level_sarana").remoteChained("#level_sarana", "<?=site_url('t_masters/getSubLevelBySaranaPuskesmas')?>");

    /**
     * Custom validation function to be added to jqueryvalidation
     * @see http://jqueryvalidation.org/documentation/
     * @see http://jqueryvalidation.org/jQuery.validator.addMethod
     */
    $.validator.addMethod("local_date",function(value, element){
        return value.match(/^(0?[1-9]|[12][0-9]|3[01])[\/](0?[1-9]|1[012])[\/]\d{4}$/);
    },"Silahkan masukkan tanggal yang benar");
    //------------------------------------------------------------

	$("#form1t_sarana_keluar_add").validate({
		rules: {
			tanggal_sarana_keluar: {
				local_date:true,
				required: true
			}
		},
		messages: {
			tanggalt_sarana_keluar_add: {
				local_date: "Silahkan Masukkan Tanggal Sesuai Format",
				required:"Silahkan Lengkapi Data"
			}
		}
	});
	
	jQuery("#listjenissaranakeluar").jqGrid({
			datatype: 'clientSide',
			rownumbers:true,
			width: 585,
			height: 'auto',
			colNames:['Kode Jenis Sarana','Jenis Sarana','Kode Satuan','Satuan','Kode Sarana'],
			colModel :[ 
			{name:'kode_jenis_sarana_keluar',index:'kode_jenis_sarana_keluar', width:75,hidden:true}, 
			{name:'jenis_sarana_keluar',index:'jenis_sarana_keluar', width:75}, 
			{name:'kode_satuan_keluar',index:'kode_satuan_keluar', width:81,hidden:true}, 
			{name:'satuan_keluar',index:'satuan_keluar', width:75}, 
			{name:'kode_barang_sarana_keluar',index:'kode_barang_sarana_keluar', width:81}
			],
			rowNum:35,
			viewrecords: true
	});	
})

$('#tanggalt_sarana_keluar_add').datepicker({dateFormat: "dd/mm/yy",changeYear: true});
$("#tanggalt_sarana_keluar_add").mask("99/99/9999");

$("#form1t_sarana_keluar_add").validate({focusInvalid:true});

var saranaid = 0;
$('#tambahsaranakeluarid').click(function(){
			if($('#jenist_sarana_keluar_add').val() && $('#satuant_sarana_keluar_add').val()){
				var myfirstrow = {kode_jenis_sarana_keluar:$('#jenist_sarana_keluar_add option:selected').val(),jenis_sarana_keluar:$('#jenist_sarana_keluar_add option:selected').text(), kode_satuan_keluar:$('#satuant_sarana_keluar_add option:selected').val(),satuan_keluar:$('#satuant_sarana_keluar_add option:selected').text(), kode_barang_sarana_keluar:$('#kode_barangt_sarana_keluar_add').val()};
				jQuery("#listjenissaranakeluar").addRowData(saranaid+1, myfirstrow);
				$('#jenist_sarana_keluar_add').val('');
				$('#satuant_sarana_keluar_add').val('');
				$('#kode_barangt_sarana_keluar_add').val('');
				if(confirm('Tambah Sarana Lain?')){
					$('#jenist_sarana_keluar_add').focus();					
				}
			}else{
				alert('Silahkan Pilih Sarana.');
			}
});

$('#hapussaranakeluarid').click(function(){
			jQuery("#listjenissaranakeluar").clearGridData();
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

$('#form1t_sarana_keluar_add :submit').click(function(e) {
	e.preventDefault();
	if($("#form1t_sarana_keluar_add").valid()) {
		if(kumpularray())$('#form1t_sarana_keluar_add').submit();
	}
	return false;
});

$(':text,:radio,:checkbox,select,textarea').bind("keydown", function(e) {
	   var n = $(":text,:radio,:checkbox,select,textarea").length;
	   if (e.which == 13) 
	   {
			e.preventDefault();
			var nextIndex = $(':text,:radio,:checkbox,select,textarea').index(this) + 1;
			var thisIndex = $(':text,:radio,:checkbox,select,textarea').index(this);
			if(nextIndex < n && $(this).valid()){
				if($(this).attr('id')=='imunisasivaksinid'){
					if($('#jenist_sarana_keluar_add').val()){
						$('#tambahsaranakeluarid').focus();return false;
					}else{
						$('#jenist_sarana_keluar_add').focus();
					}
				}
				$(':text,:radio,:checkbox,select,textarea')[nextIndex].focus();
			}else{			
				if($("#form1t_sarana_keluar_add").valid()) {
					if(kumpularray())$('#form1t_sarana_keluar_add').submit();
				}
				return false;
			}
	   }
});
</script>

<script>
	$("#form1t_sarana_keluar_add input[name = 'batal'], #backlistt_sarana").click(function(){
		$("#t305","#tabs").empty();
		$("#t305","#tabs").load('t_sarana'+'?_=' + (new Date()).getTime());
	});
</script>

<script>
	function kumpularray(){
		if($('#listjenissaranakeluar').getGridParam("records")>0){
			var rows= jQuery("#listjenissaranakeluar").jqGrid('getRowData');
			var paras=new Array();
			for(var i=0;i<rows.length;i++){
				var row = rows[i];
				paras.push(JSON.stringify(row));
			}
			$("#jenis_sarana_keluar_final").val(JSON.stringify(paras));
		}
		return true;		
	}
</script>
<?php if($this->session->userdata('group_id')=='all'){?>
<script>
	$("#level_sarana").text(function(){
		if($(this).val() =="Puskesmas"){
			$("#sub_level_sarana").hide();
			$("#sub_level_sarana1").show();
		}else{
			$("#sub_level_sarana1").hide();
			$("#sub_level_sarana").show();
		}
	});
</script>
<?php }?>
<div class="mycontent">
<div class="formtitle">Tambah Sarana keluar</div>
<div class="backbutton"><span class="kembali" id="backlistt_sarana">kembali ke list</span></div>
</br>
<span id='errormsg'></span>
<div id="form_sarana_keluar">
<form name="frApps" id="form1t_sarana_keluar_add" onsubmit="bt1.disabled = true; return true;" method="post" action="<?=site_url('t_sarana/saranakeluarprocess')?>" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Tanggal* (dd/mm/yyyy)</label>
		<input type="text" name="tanggal_sarana_keluar" id="tanggalt_sarana_keluar_add" class="mydate" value="<?=date('d/m/Y')?>" required  />
		</span>
	</fieldset>	
	<fieldset>
		<span>
		<label>Nomor Faktur</label>
		<input type="text" name="no_faktur_sarana_keluar" id="no_fakturt_sarana_keluar_add" value="" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Asal Sarana</label>
		<?php if($this->session->userdata('group_id')=='kabupaten' or $this->session->userdata('level_aplikasi')=='KABUPATEN'){?>
		<input type="text" name="from_level" id="from_level" value="KABUPATEN" readonly />
		<?php }else{?>
		<input type="text" name="from_level" id="from_level" value="PUSKESMAS" />
		<input type="hidden" name="kd_puskesmas_hidden" id="kd_puskesmas" value="<?=$this->session->userdata('kd_puskesmas')?>" />
		<?php }?>		
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Nama Asal Sarana</label>
		<?php if($this->session->userdata('group_id')=='all' or $this->session->userdata('level_aplikasi')=='PUSKESMAS'){?>
		<input type="text" name="nama_asal_sarana_keluarx" id="nama_asal_sarana_keluar1" value="<?=$this->session->userdata('puskesmas')?>" />
		<input type="hidden" name="nama_asal_sarana_keluar" id="nama_asal_sarana_keluar1" value="<?=$this->session->userdata('kd_puskesmas')?>" />
		<?php }elseif($this->session->userdata('group_id')=='kabupaten' or $this->session->userdata('level_aplikasi')=='KABUPATEN'){?>
		<input type="text" name="nama_asal_sarana_keluarx" id="nama_asal_sarana_keluarx" value="<?=$this->session->userdata('nama_kabupaten')?>" />
		<input type="hidden" name="nama_asal_sarana_keluar" id="nama_asal_sarana_keluar" value="<?=$this->session->userdata('kd_kabupaten')?>" />
		<?php }else{?>
		<input type="text" name="nama_asal_sarana_keluarx" id="nama_asal_sarana_keluarx" value="<?=$this->session->userdata('puskesmas')?>" />
		<input type="hidden" name="nama_asal_sarana_keluar" id="nama_asal_sarana_keluar" value="<?=$this->session->userdata('kd_puskesmas')?>" />
		<?php }?>
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Tujuan Sarana</label>
			<?php if($this->session->userdata('group_id')=='kabupaten' or $this->session->userdata('level_aplikasi')=='KABUPATEN'){?>
			<input type="text" name="level_sarana" value="PUSKESMAS" readonly />
			<?php }elseif($this->session->userdata('group_id')=='puskesmas' or $this->session->userdata('group_id')=='all' or $this->session->userdata('level_aplikasi')=='PUSKESMAS'){?>
			<?=getComboUnitlayanandsbpks('','level_sarana','level_saranaid','','inline')?>
			<?php }else{?>
			<input type="hidden" name="level_sarana" value="<?=$this->session->userdata('kd_puskesmas')?>" />
			<input type="text" name="level_saranax" value="<?=$this->session->userdata('puskesmas')?>" />
			<?php }?>
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Nama Tujuan Sarana</label>
			<?php if($this->session->userdata('group_id')=='kabupaten' or $this->session->userdata('level_aplikasi')=='KABUPATEN'){?>
			<?=getComboPuskesmasByKabb('','sub_level_sarana','level_saranaid','','inline')?>
			<?php }elseif($this->session->userdata('group_id')=='puskesmas' or $this->session->userdata('group_id')=='all' or $this->session->userdata('level_aplikasi')=='PUSKESMAS'){?>
			<input type="text" name="sub_level_sarana" />
			<?php }else{?>
			<input type="text" name="sub_level_sarana" />
			<?php }?>
		</span>
	</fieldset>
	<div class="subformtitle">Data Jenis Sarana</div>
	<table id="listjenissaranakeluar"></table>
	<fieldset id="fieldsjenissaranakeluar">
		<span>
		<?=getComboJenissarana('','jenis_sarana_keluar','jenist_sarana_keluar_add','','inline')?>
		</span>	
	</fieldset>
	<fieldset>
		<span>
		<?=getComboSatuanbarang('','satuan_keluar','satuant_sarana_keluar_add','','inline')?>
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Kode Sarana</label>
		<input type="text" name="kode_barang_sarana_keluar" id="kode_barangt_sarana_keluar_add" value="" />
		</span>
		<span>
			<input type="hidden" name="jenis_sarana_keluar_final" id="jenis_sarana_keluar_final" />
			<input type="button" value="Tambah" id="tambahsaranakeluarid" />
			<input type="button" value="Hapus" id="hapussaranakeluarid" />
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
</div >