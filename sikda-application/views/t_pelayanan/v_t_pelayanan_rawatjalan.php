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
#to_odontogram{
	background: url(assets/images/etc/arrow_right.gif) no-repeat scroll right center transparent;
	padding-left:5px;
	padding-right:19px;
}
</style>
<script>
	function loadContentPelayanan(){
		$("#content_pelayanan").load("t_pelayanan/getRawatJalanContent",
			"id=<?=$rawatjalan_id?>&id2=<?=$rawatjalan_id2?>&id3=<?=$rawatjalan_id3?>")
	}
	$(function(){
		loadContentPelayanan();
	})
    function PrintElem(elem)
    {
        Popup($(elem).html());
    }

    function Popup(data)
    {
        var kode_pasien = document.getElementById("get_kode_pasien").value;
        var mywindow = window.open('', 'Odontogram');
        mywindow.document.write('<html><head><title>G_'+kode_pasien+'</title>');
        /*optional stylesheet*/
        mywindow.document.write('<link rel="stylesheet" href="./../../../assets/css/layout.css" type="text/css" />');
        mywindow.document.write('<link rel="stylesheet" href="./../../../assets/css/style.css" type="text/css" />');
        mywindow.document.write('<link rel="stylesheet" href="./../../../assets/jquerytree/jquery.treeview.css" type="text/css" />');
        mywindow.document.write('<link rel="stylesheet" href="./../../../assets/jquery-ui-1.9.0.custom/css/themes/base/jquery-ui.css" type="text/css" />');
        mywindow.document.write('<link rel="stylesheet" href="./../../../assets/jqgrid/css/ui.jqgrid.css" type="text/css" />');

        mywindow.document.write('</head><body >');
        mywindow.document.write(data);
        mywindow.document.write('</body></html>');


        mywindow.document.close(); // necessary for IE >= 10
        mywindow.focus(); // necessary for IE >= 10

        mywindow.print();
        mywindow.close();

        return true;
    }


</script>
<!-- <div id="btn_to_odontogram" class="backbutton"><span id="to_odontogram">| odontogram</span></div> -->
<div class="backbutton"><span class="kembali" id="backlistt_pelayanan">kembali ke list</span></div>
<div id="print_div">
    <div class="formtitle">Pelayanan Rawat Jalan</div>
    </br>
    <span id='errormsg'></span>
    <input type="hidden" id="rawatjalan_id" value="<?=$rawatjalan_id; ?>" />
    <input type="hidden" id="rawatjalan_id2" value="<?=$rawatjalan_id2; ?>" />
    <input type="hidden" id="rawatjalan_id3" value="<?=$rawatjalan_id3; ?>" />
    <form name="frApps" id="form1t_pelayananpelayanan" method="post" onsubmit="bt1.disabled = true; return true;" action="<?=site_url('t_pelayanan/pelayananprocess')?>" enctype="multipart/form-data">
        <fieldset>
            <span>
            <label>Rekam Medis#</label>
            <input type="text" id="get_kode_pasien" name="text" value="<?=$data->KD_PASIEN?>" disabled />
            <input type="hidden" name="get_unit_pelayanan" id="textid" value="<?=$data->UNIT?>" />
            <input type="hidden" name="kd_petugas_hidden" class="get_kd_petugas" id="textid" value="<?=$this->session->userdata('nid_user')?>" />
            <input type="hidden" name="kd_pasien_hidden" class="get_kd_pasien" id="textid" value="<?=$data->KD_PASIEN?>" />
            <input type="hidden" name="kd_puskesmas_hidden" class="get_kd_puskesmas" id="textid" value="<?=$data->KD_PUSKESMAS?>" />
            <input type="hidden" name="kd_kunjungan_hidden" id="textid" value="<?=$data->ID_KUNJUNGAN?>" />
            <input type="hidden" name="kd_unit_hidden" id="textid" value="<?=$data->KD_UNIT?>" />
            <input type="hidden" name="unit_layanan_hidden" id="textid" value="<?=$data->KD_UNIT_LAYANAN?>" />
            <input type="hidden" name="kd_urutmasuk_hidden" id="textid" value="<?=$data->URUT_MASUK?>" />
            <input type="hidden" name="showhide_kunjungan" id="textid" value="rawat_jalan" />
            </span>
            <span>
            <label>NIK</label>
            <input type="text" name="text" value="<?=$data->NIK?>" disabled />
            </span>
        </fieldset>
        <fieldset>
            <span>
            <label>Nama Pasien</label>
            <input type="text" name="text" value="<?=$data->NAMA_PASIEN?>" disabled />
            </span>
            <span>
            <label>Golongan Darah</label>
            <input type="text" name="text" value="<?=$data->KD_GOL_DARAH?>" disabled />
            </span>
        </fieldset>
        <fieldset>
            <span>
            <label>Jenis Pasien</label>
            <input type="text" name="text" value="<?=$data->CUSTOMER?>" disabled />
            </span>
            <span>
            <label>Tanggal Lahir</label>
            <input type="text" name="text" value="<?=$data->TGL_LAHIR?>" disabled />
            </span>
        </fieldset>
        <div id="content_pelayanan"></div>
    </form>
</div>
