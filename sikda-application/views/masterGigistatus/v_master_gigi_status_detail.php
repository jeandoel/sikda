<script>
    $('#backlistmastergigistatus').click(function(){
        $("#t1003","#tabs").empty();
        $("#t1003","#tabs").load('c_master_gigi_status'+'?_=' + (new Date()).getTime());
    })
</script>
<div class="mycontent">
    <div class="formtitle">Detail Status Gigi</div>
    <div class="backbutton"><span class="kembali" id="backlistmastergigistatus">kembali ke list</span></div>
    </br>

    <span id='errormsg'></span>
    <form name="frApps" method="post" enctype="multipart/form-data">
        <fieldset>
		<span>
		<label>Kode</label>
		<input type="hidden" readonly name="kd" id="kd" value="<?=$data->ID_STATUS_GIGI?>" />
		<input type="text" readonly name="kd_status_gigi" id="kd_status_gigi" value="<?=$data->KD_STATUS_GIGI?>" />
		</span>
        </fieldset>
        <fieldset>
		<span>
		<label>Gambar</label>
		<img src="<?php echo site_url('assets/images/map_gigi_permukaan/'.$data->GAMBAR)?>" width="35px" height="60px">
		</span>
        </fieldset>
        <fieldset>
		<span>
		<label>Status</label>
		<input type="text" readonly name="nama" id="nama" value="<?=$data->STATUS?>"  />
		</span>
        </fieldset>
        <fieldset>
		<span>
		<label>DMF</label>
            <?php if($data->DMF == 'D'){
            $dmf_val = 'D - Decay';
        }else if($data->DMF == 'M'){
            $dmf_val = 'M - Missing';
        }else if($data->DMF == 'F'){
            $dmf_val = 'F - Filling';
        }else{
            $dmf_val = '';
        }?>
            <input type="text" readonly name="dmf" id="dmf" value="<?php echo @$dmf_val;?>"  />
		</span>
        </fieldset>
        <fieldset>
		<span>
		<label>Deskripsi</label>
		<input type="text" readonly name="deskripsi" id="deskripsi" value="<?=$data->DESKRIPSI?>" />
		</span>
        </fieldset>
    </form>
</div >