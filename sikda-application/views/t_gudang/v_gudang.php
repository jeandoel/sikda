<script type="text/javascript" src="<?=base_url()?>assets/customjs/t_gudang.js"></script>

<div class="mycontent">
<div id="dialogt_gudang" class="dialog" style="color:red;font-size:.75em;display:none" title="Confirmation Required">
  Hapus Data?
</div>
<div class="formtitle">Gudang Obat</div>
	<form id="formt_gudang">
		<div class="gridtitle_t">&nbsp;<span id="t_gudangadd"><span class="tambahdata_t"></span>Obat Masuk</span><?php if($this->session->userdata('group_id')=='all' or $this->session->userdata('group_id')=='gudang_puskesmas' or $this->session->userdata('group_id')=='kabupaten' or $this->session->userdata('group_id')=='apotik'){ ?><span id="t_gudangkeluar"><span class="tambahdata_t"></span>Obat Keluar</span><?php }?></div>		
		<fieldset class="fieldsetpencarian" id="fieldset_t_gudang_pasien">
			<span>
				<label>Pencarian Berdasarkan</label>
				<select id="keywordt_gudang" name="keywordt_gudang">
					<option value="KD_OBAT">Kode Obat</option>
					<option value="NAMA_OBAT">Nama Obat</option>
					<option value="KD_GOL_OBAT">Golongan Obat</option>
				</select>
				<input type="text" name="carinamat_gudang" id="carinamat_gudang"/>
				<input type="submit" class="cari" value="&nbsp;Cari&nbsp;" id="carit_gudang" />
				<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="resett_gudang"/>
			</span>
		</fieldset>
		<?php if($this->session->userdata('level_aplikasi')!=='KABUPATEN'){?>
		<div class="topgridradio">
		<span>
			<input type="radio" name="tampilan_data_gudang" value="gudangpuskesmas" checked />Gudang Puskesmas
			<input type="radio" name="tampilan_data_gudang" value="gudangapotik" />Gudang Apotik
		</span>	</div>
		<?php }?>
		<div class="paddinggrid" id="Gudang_grid_pasien">
		<table id="listt_gudang"></table>
		<div id="pagert_gudang"></div>		
		</div >
		<?php if($this->session->userdata('level_aplikasi')!=='KABUPATEN'){?>
		<div class="paddinggrid" id="Gudang_grid_antrian" style="display:none" >
		<table id="listt_gudangapt"></table>
		<div id="pagert_gudangapt"></div>
		</div >
		<?php }?>
	</form>
</div>
<!--

<script type="text/javascript" src="<?=base_url()?>assets/js/jquery.maskedinput.js"></script>

$("#form-login").validate({
		rules: {
			username: {
				date:true,
				required: true
			},
			password:{
				required:true
			},
		},
		messages: {
			name: {
				date: "Silahkan Masukkan Tanggal Sesuai Format",
				required:"Silahkan Lengkapi Field"
			},
			password:{
				required:"Silahkan Lengkapi Field"
			},
		}
	});
$("#name").mask("99/99/9999");	


$(document).ready(function() {
$('input:text:first').focus();
    
$('input:text').bind("keydown", function(e) {
   var n = $("input:text").length;
   if (e.which == 13) 
   { //Enter key
     e.preventDefault(); //to skip default behavior of the enter key
     var nextIndex = $('input:text').index(this) + 1;
     if(nextIndex < n)
       $('input:text')[nextIndex].focus();
     else
     {
       $('input:text')[nextIndex-1].blur();
       $('#btnSubmit').click();
     }
   }
});

$('#btnSubmit').click(function() {
    alert('Form Submitted');
});
});
	-->