<script>
    $(document).ready(function(){
        $('#formgigimastergigistatusedit').ajaxForm({
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
                    $.achtung({message: 'Proses Ubah Data Berhasil', timeout:5});
                    $("#t1003","#tabs").empty();
                    $("#t1003","#tabs").load('c_master_gigi_status'+'?_=' + (new Date()).getTime());
                }
            }
        });
    })
</script>
<script>
    $('#backlistmastergigistatus').click(function(){
        $("#t1003","#tabs").empty();
        $("#t1003","#tabs").load('c_master_gigi_status'+'?_=' + (new Date()).getTime());
    })
</script>
<div class="mycontent">
    <div class="formtitle">Edit Status Gigi</div>
    <div class="backbutton"><span class="kembali" id="backlistmastergigistatus">kembali ke list</span></div>
    </br>

    <span id='errormsg'></span>
    <form name="frApps" id="formgigimastergigistatusedit" method="post" action="<?=site_url('c_master_gigi_status/editprocess')?>" enctype="multipart/form-data">
        <fieldset>
		<span>
		<label>Kode</label>
		<input type="text" name="kd_status_gigi" id="kd_status_gigi" value="<?=$data->KD_STATUS_GIGI?>" />
		<input type="hidden" name="kd" id="kd" value="<?=$data->ID_STATUS_GIGI?>" />
		</span>
        </fieldset>
        <fieldset>
		<span>
		<label>Jumlah Gigi</label>
		<input type="text" name="jml_gigi_status" id="jml_gigi_status" value="<?=$data->JUMLAH_GIGI?>" />
		</span>
        </fieldset>
        <fieldset>
		<span>
		<label>Gambar</label>
		<input type="file" name="gambar"/>
		</span>
        </fieldset>
        <fieldset>
		<span>
		<label>Status</label>
		<input type="text" name="status" id="status" value="<?=$data->STATUS?>" />
		</span>
        </fieldset>

        <fieldset>
		<span>
		<label>DMF</label>
		<select name="dmf" id="dmf">
            <?php
            $data_kd = array('','D','M','F');
            $data_txt = array("-Select-", "D - Decay", "M - Missing", "F - Filling");
            for($i=0; $i<4;$i++){
                ?>
                <option value="<?php echo $data_kd[$i];?>"
                    <?php if($data_kd[$i]==$data->DMF){echo "selected='selected'";}?>
                    ><?php echo $data_txt[$i];?></option><?php }?>
        </select>
		</span>
        </fieldset>
        <fieldset>
		<span>
		<label>Deskripsi</label>
		<input type="text" name="deskripsi" id="deskripsi" value="<?=$data->DESKRIPSI?>"  />
		</span>
        </fieldset>
        <fieldset>
		<span>
		<input type="submit" name="bt1" value="Proses Data"/>
		</span>
        </fieldset>
    </form>
</div >