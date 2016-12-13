<script>
	$('#backlistt_grid').click(function(){
		$("#t205","#tabs").empty();
		$("#t205","#tabs").load('t_kasir'+'?_=' + (new Date()).getTime());
	})
		$("#form1t_pelayanan_kb_add input[name = 'batal'], #backlistt_grid").click(function(){
		$("#t205","#tabs").empty();
		$("#t205","#tabs").load('t_kasir'+'?_=' + (new Date()).getTime());
	});
	function hasilPenambahan(){
			diskon=document.getElementById("diskon").value;
			diskon=diskon?diskon:0;
			bayar=document.getElementById("bayar").value;
			bayar=bayar?bayar:0;
			retri=document.getElementById("retri").value;
			retri=retri?retri:0;
			var valf = isNaN((parseInt(bayar)-parseInt(diskon))+parseInt(retri))?document.getElementById("bayar").value:((parseInt(bayar)-parseInt(diskon))+parseInt(retri));
			document.getElementById("totalbayar").value = valf;
			hasilPerkalian();
		}
	function hasilPerkalian(){
			totalbayar=document.getElementById("totalbayar").value;
			ppn=document.getElementById("ppn").value;
			ppn=ppn?ppn:0;
			bayar=document.getElementById("bayar").value;
			if(ppn>0){
				document.getElementById("bayarppn").value = parseInt(totalbayar)+(totalbayar * (ppn/100));
			}else{
				document.getElementById("bayarppn").value = parseInt(totalbayar);
			}
		}
		
	$( "#bayar-form" ).dialog({
		autoOpen: false,
		height: 215,
		width: 315,
		modal: true,
		buttons: {
			"Bayar": function() {
				myId=$("#idvtranskasir").val();
				jumlahbayar=$("#jumlahbayarkasirid").val();
				kdbayar=$("#kdbayarkasirid").val();
				disc=$("#diskon").val();
				ppn=$("#ppn").val();
				ttl=$("#totalbayar").val();
				
				$.ajax({
				  url: 't_kasir/bayar',
				  type: "post",
				  data: {id:myId,kdbayar:kdbayar,jumlahbayar:jumlahbayar,disc:disc,ppn:ppn,ttl:ttl},
				  dataType: "json",
				  success: function(msg){
					if(msg == 'OK'){
						$.achtung({message: 'Proses Posting Data Berhasil', timeout:2});												
						$("#t205","#tabs").empty();
						$("#t205","#tabs").load('t_kasir/listtransaksikasir'+'?id='+decodeURIComponent(myId));
						$("#bayar-form").dialog( "close" );
					}
					else{						
						$.achtung({message: 'Maaf Proses Bayar Gagal', timeout:2});
						$("#bayar-form").dialog( "close" );
					}						
				  }
     			});				
			},
			Cancel: function() {
				$(this).dialog( "close" );
			}
		},
		close: function() {
			//allFields.val( "" ).removeClass( "ui-state-error" );
		}
	});
	$( "#bayar-form-btn" )
		.click(function(event) {
			event.preventDefault();
			$( "#bayar-form" ).dialog( "open" );
			$( "#form-bayar" ).find("input[type=text], textarea").val($("#bayarppn").val());
	});
	
	$("#cetakkasirid")
		.on('click',function(event) {
		event.preventDefault();
		window.open('<?=site_url().'t_kasir/cetakkasir?diskon='?>'+decodeURIComponent($('#diskon').val())+'&retri='+decodeURIComponent($('#retri').val())+'&total='+decodeURIComponent($('#totalbayar').val())+'&bayarppn='+decodeURIComponent($('#bayarppn').val())+'&pel_kasir='+decodeURIComponent($('#pel_kasir').val())+'&ppn='+decodeURIComponent($('#ppn').val()),'','width=630,height=850,scrollbars=yes');
	});
	
	/*$("#cetakkasirid")
		.live('click',function(a) {
		$("#dialogt_kasir_cetak").dialog({
			autoOpen: false,
			modal:true,
			width: 650,
			height:500
		});	
		$('#dialogt_kasir_cetak').load('t_kasir/cetakkasir?diskon='+decodeURIComponent($('#diskon').val())+'&retri='+decodeURIComponent($('#retri').val())+'&total='+decodeURIComponent($('#totalbayar').val())+'&bayarppn='+decodeURIComponent($('#bayarppn').val())+'&pel_kasir='+decodeURIComponent($('#pel_kasir').val())+'&ppn='+decodeURIComponent($('#ppn').val()), function() {
		$("#dialogt_kasir_cetak").dialog("open");
		});
	});
	*/
	$( "#tutupkasirid" )
		.click(function(event) {
			event.preventDefault();
			myId=$("#idvtranskasir").val();
				
			$.ajax({
			  url: 't_kasir/tutuptransaksi',
			  type: "post",
			  data: {id:myId},
			  dataType: "json",
			  success: function(msg){
				if(msg == 'OK'){
					$.achtung({message: 'Proses Tutup Transaksi Berhasil', timeout:2});												
					$("#t205","#tabs").empty();
					$("#t205","#tabs").load('t_kasir'+'?_=' + (new Date()).getTime());
				}
				else{						
					$.achtung({message: 'Maaf Proses Tutup Transaksi Gagal', timeout:2});
				}						
			  }
			});
	});
	
</script>
<style>
.tablekasir{
	border-style:none;
    border-left: 0 none;
    border-right: 0 none;
    overflow: hidden;
    text-align: center;
    white-space:nowrap;
	background-position:left;
	background-color:#AFEEEE;
	color:#0B77B7;
	cursor:pointer;	
}
.tablediskon{
    text-align: center;
    white-space:nowrap;
	color:#0B77B7;
	cursor:pointer;
	margin-left:600px;
	width:433px;
}
th,tr{
padding:5px 5px 10px 5px;
}
td {
background-color:#FFFFFF;
}
.formtext{
width:188px;
background-color:#E2FDFE;
border-style:none;
height:20px;
}

#bayar-form{display:none}
#bayar-form label, input {margin:7px 0 0 3px!important;padding:0 0 0 0!important; }
#bayar-form label {width:29%!important;text-align:left}
#bayar-form input.text { margin-bottom:3px; width:65%; padding: 3px; }
#bayar-form fieldset { padding:0; border:0; margin-top:1px; }

.button{
	background-image:-moz-linear-gradient(center top , #FFFFFF, #DBDBDB);
	border-radius:3px 3px 3px 3px!important;
	display:inline-block;
	color:#597390;
	box-shadow:0 0 4px rgba(0, 0, 0, 0.4);
	cursor:pointer;
	padding:10px 10px!important;
}
</style>
<!--<div id="dialogt_kasir_cetak" class="dialog" title="Cetak Transaksi">-->
<div class="mycontent">
<div id="bayar-form" title="Bayar"> 
    <form id="form-bayar" action="#" method="post">
    <fieldset>
        <label for="carabayar">Cara Bayar</label>
        <select name="carabayar" id="kdbayarkasirid">
			<option value="GR">Gratis</option>
			<option value="TU">Tunai</option>
		</select>
        <label for="harga">Harga</label>
        <input type="text" id="jumlahbayarkasirid" name="harga" class="text ui-widget-content ui-corner-all" />
    </fieldset>
    </form>
</div>
<div class="formtitle">Transaksi Kasir</div>
<div class="backbutton"><span class="kembali" id="backlistt_grid">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="form1t_pendaftaranpelayanan" method="post" action="<?=site_url('t_pendaftaran/daftarkunjunganprocess')?>" enctype="multipart/form-data">
	<fieldset style="margin:0 13px 0 13px ">
						<span>
						<label>Rekam Medis</label>
						<input type="text" name="text" value="<?=$data->KD_PASIEN?>" disabled />
						</span>	
						<span>
						<label>Kode Transaksi</label>
						<input type="text" name="text" id="pel_kasir" value="<?=$data->KD_PEL_KASIR?>" disabled />
						</span>
						<span>
					</fieldset>
		<fieldset style="margin:0 13px 0 13px ">
						<span>
						<label>Nama Pasien</label>
						<input type="text" name="text" value="<?=$data->NAMA_LENGKAP?>" disabled />
						</span>
						<span>
						<label>Kelompok Pasien</label>
						<input type="text" name="text" value="<?=$data->KD_CUSTOMER?>" disabled />
						</span>
					</fieldset>
		<fieldset style="margin:0 13px 0 13px ">
						<span>
						<label>Cara Bayar</label>
						<input type="text" name="text" value="<?=$data->CARA_BAYAR?>" disabled />
						</span>
					</fieldset>
	<br/>
	
	<fieldset>
		<table width="1033px" class="tablekasir">
			<tr align="center">
				<th>No</th>
				<th>Tindakan/ Produk</th>
				<th>Kode Tarif</th>
				<th>Qty</th>
				<th>Harga Satuan</th>
				<th>Jumlah Total</th>
			</tr>
			<!--contoh datanya--->
			<?php 
			$no = 1;
			$jumlahbiaya = 0;
			if($data2){foreach ($data2 as $val)://print_r($data);die;
				$totalharga = $val['TOTAL_HARGA'];
				$jumlahbiaya = $jumlahbiaya +$totalharga;				
			?>
					
			<tr>
				<td><?php echo $no;?></td>
				<td align="left"><?php echo $val['PRODUK'];?></td>
				<td><?php echo $val['KD_TARIF'];?></td>
				<td><?php echo $val['QTY'];?></td>
				<td align="right"><?php echo $val['HARGA_PRODUK'];?></td>
				<td align="right"><?php echo $val['TOTAL_HARGA'];?></td>
			</tr>
			<?php 
				$no++;
				endforeach;
				}
			?>
			<tr>
				<td colspan="4">&nbsp;</td>
				<td align="right" style="padding-right:45px">Jumlah Biaya</td>
				<td align="right">
				<input type="hidden" id="bayar" value="<?php echo ($jumlahbiaya)?>">
				<input type="hidden" id="idvtranskasir" value="<?php echo ($id)?>">
				<?php
				echo ($jumlahbiaya);
				?>
				</td>
			</tr>
	</table>
	</fieldset>
	<fieldset>
			<table class="tablediskon">
			
			<tr>
				<td width="185" align="right"> Discount :</td>
			  <td style="padding-left:50px" align="right"><input class="formtext" placeholder="--Isi Diskon(Rp)--" onKeyUp="hasilPenambahan()" id="diskon" type="text" name="" value="<?=isset($data3->JUMLAH_DISC)?$data3->JUMLAH_DISC:''?>"></td>
			</tr>
			<tr>
				<td align="right">Retribusi :</td>
				<td style="padding-left:50px" align="right"><input class="formtext"  placeholder="--Isi Retribusi(Rp)--" onKeyUp="hasilPenambahan()" id="retri" type="text" name="" value="<?=isset($data4->NILAI_RETRIBUSI)?$data4->NILAI_RETRIBUSI:0?>"></td>
			</tr>
			<tr>
				<td align="right">PPN :</td>
				<td style="padding-left:50px" align="right"><input class="formtext" placeholder="--Isi PPN(%)--" onKeyUp="hasilPerkalian()" id="ppn" type="text" name="" value="<?=isset($data3->JUMLAH_PPN)?$data3->JUMLAH_PPN:''?>"></td>
			</tr>
			<tr>
				<td align="right">Jumlah Total :</td>
				<td style="padding-left:50px"><input class="formtext" id="totalbayar" type="text" name="" value="<?=isset($data3->JUMLAH_TTL)?$data3->JUMLAH_TTL:$jumlahbiaya+(isset($data4->NILAI_RETRIBUSI)?$data4->NILAI_RETRIBUSI:0)?>" disabled></td>
			</tr>
			<tr>
				<td align="right"><b>Jumlah Total Bayar :</b></td>
				<td style="padding-left:50px"><input class="formtext" id="bayarppn" type="text" name="" value="<?=isset($data3->JUMLAH_BAYAR)?$data3->JUMLAH_BAYAR:$jumlahbiaya+(isset($data4->NILAI_RETRIBUSI)?$data4->NILAI_RETRIBUSI:0)?>" disabled></td>
			</tr>
			
	</table>
	</fieldset>
	
	<fieldset >
	
	        <table width="40%" class="tablekasir" style="margin-top:20px">
              <tr align="center">
                <th>Cara Bayar </th>
                <th>Jumlah Bayar </th>
                <th>Tanggal Bayar </th>
              </tr>
              <tr>
                <td><?=isset($data3->CARA_BAYAR)?$data3->CARA_BAYAR:''?></td>
                <td><?=isset($data3->JUMLAH_BAYAR)?$data3->JUMLAH_BAYAR:''?></td>
                <td>
					<?=isset($data3->TGL_BAYAR)?$data3->TGL_BAYAR:''?>
					<input type="hidden" id="idvtranskasir" value="<?php echo ($id)?>">
				</td>
              </tr>
            </table>
	</fieldset>	
		
	<fieldset style="padding-left:600px; padding-top:20px">
		<input type="button" class="button" name="bayar" id="bayar-form-btn" value="Bayar" />
		<!--<input type="button" class="button" name="batal" value="Transfer Manual" />-->
		<input type="button" class="button" name="tutup" id="tutupkasirid" value="Tutup Transaksi" />
		<input <?=isset($data3->TGL_BAYAR)?"":"style='display:none'"?> type="button" class="button" name="cetak" id="cetakkasirid" value="Cetak"/>
	</fieldset>	
</form>
</div >
