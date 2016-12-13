<script type="text/javascript">
	
</script>
<style>
body{
	font-family:helvetica, arial;
	}
#datapasien th{
	text-align:left;
}

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

th,tr{
padding:5px 5px 10px 5px;
}
td {
background-color:#FFFFFF;
}
.formtext{
width:140px;
background-color:#E2FDFE;
border-style:none;
height:20px;
}
#prnt{
color:blue;
float:right;
margin-right:5px;
}
#prnt:hover{
cursor:pointer;
color:F1F1F1;
}
</style>
<script>
	function printDiv(divID){
		var ygdicetak = document.getElementById(divID).innerHTML;
		var asli = document.body.innerHTML;
		document.body.innerHTML = '<html><head><title></title></head><body>' + ygdicetak + '</body>';
		window.print();
		document.body.innerHTML = asli;
	}
</script>
<div><a id="prnt" onClick="printDiv('cetak')">Print</a></div></br>
<div id="cetak" style="width:600px;margin-bottom:5px">
<fieldset style="text-align:center;margin-bottom:-1px"><strong>KWITANSI PEMBAYARAN</strong></fieldset>
	<fieldset>
		<table id='datapasien' width="333px">
			<tr>
				<th>Puskesmas</th>
				<th>:</th>
				<th><?=isset($data->PUSKESMAS)?$data->PUSKESMAS:''?></th>
			</tr>
			<tr>
				<th>No. Kwitansi</th>
				<th>:</th>
				<th><?=isset($data1->KD_PEL_KASIR)?$data1->KD_PEL_KASIR:''?></th>
			</tr>
			<tr>
				<th>Rekam Medis #</th>
				<th>:</th>
				<th><?=isset($data->KD_PASIEN)?$data->KD_PASIEN:''?></th>
			</tr>
			<tr>
				<th>Nama Pasien</th>
				<th>:</th>
				<th><?=isset($data->NAMA_LENGKAP)?$data->NAMA_LENGKAP:''?></th>
			</tr>
			<!--<tr>
				<th>Umur</th>
				<th>:</th>
				<th><?=isset($data->UMUR)?$data->UMUR:''?></th>
			</tr>-->
			<tr>
				<th>Alamat</th>
				<th>:</th>
				<th><?=isset($data->ALAMAT)?$data->ALAMAT:''?></th>
			</tr>
			<tr>
				<th>Jenis Pasien</th>
				<th>:</th>
				<th><?=isset($data->CUSTOMER)?$data->CUSTOMER:''?></th>
			</tr>
			<tr>
				<th>Petugas</th>
				<th>:</th>
				<th><?=(!empty($data->NAMA))?$data->NAMA:$data->PETUGAS_2?></th>
			</tr>
			<tr>
				<th>Tgl Pelayanan</th>
				<th>:</th>
				<th><?=isset($data->TGL_PELAYANAN)?$data->TGL_PELAYANAN:''?></th>
			</tr>
		</table>
		<table width="100%" class="tablekasir">
			<tr align="center">
				<th>No</th>
				<th>Tindakan/ Produk</th>
				<th>Kode Tarif</th>
				<th>Qty</th>
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
				<td align="right"><?php echo $val['TOTAL_HARGA'];?></td>
			</tr>
			<?php 
				$no++;
				endforeach;
				}
			?>
			<tr>
				<td colspan="4" align="center" style="padding-right:45px">Jumlah Biaya</td>
				<td align="right">
				<input type="hidden" id="bayar" value="<?php echo ($jumlahbiaya)?>">
				<?php
				echo ($jumlahbiaya);
				?>
				</td>
			</tr>
	</table>
	<table style="float:right">
			<tr>
				<td align="right"> Discount :</td>
				<td><input style="text-align:right;" readonly class="formtext" id="diskon" type="text" name="" value="<?=isset($data3['datadiskon'])?$data3['datadiskon']:0?>"></td>
			</tr>
			<tr>
				<td align="right">PPN :</td>
				<td><input style="text-align:right" readonly class="formtext" id="ppn" type="text" name="" value="<?=isset($data3['datappn'])?$data3['datappn'].'%':0?>"></td>
			</tr>
			<tr>
				<td align="right">Retribusi :</td>
				<td><input style="text-align:right" readonly class="formtext" id="retri" type="text" name="" value="<?=isset($data3['dataretri'])?$data3['dataretri']:''?>"></td>
			</tr>
			<tr>
				<td align="right">Jumlah Total :</td>
				<td><input style="text-align:right" readonly class="formtext" id="totalbayar" type="text" name="" value="<?=isset($data3['datatotal'])?$data3['datatotal']:$jumlahbiaya?>" disabled></td>
			</tr>
			<tr>
				<td align="right"><b>Jumlah Total Bayar :</b></td>
				<td><input style="text-align:right" readonly class="formtext" id="bayarppn" type="text" name="" value="<?=isset($data3['databayarppn'])?$data3['databayarppn']:$jumlahbiaya?>" disabled></td>
			</tr>
	</table>
	
	        <table class="tablekasir" width="100%">
              <tr align="center">
                <th>Tanggal Bayar </th>
				<th>Jumlah Bayar </th>
                </tr>
              <tr>
                <td>
					<?=isset($data1->TGL_BAYAR)?$data1->TGL_BAYAR:''?>
					</td>
					<td><?=isset($data1->JUMLAH_BAYAR)?$data1->JUMLAH_BAYAR:''?></td>
              </tr>
            </table>
	</fieldset>
</div >
