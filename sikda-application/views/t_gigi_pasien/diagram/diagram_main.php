<style type="text/css">
	#main_diagram{
		margin-top: 10px;
	}
	#main_diagram_gigi{
		margin-bottom: 25px;
		overflow: hidden;
	}
	#set_label_dokter{
		font-size: 17px;	
	}
</style>
<script type="text/javascript">
	$(function(){
		var kd_pasien = $(".get_kd_pasien").attr("value");
		var kd_puskesmas = $(".get_kd_puskesmas").attr("value");
		$('#main_diagram_table').load('t_gigi_diagram_pasien/views/diagram_table',{},function(data){

		})
		$('#main_diagram_gigi').load('t_gigi_diagram_pasien/views/diagram_gigi',{
			'kd_pasien':kd_pasien,
			'kd_puskesmas':kd_puskesmas
		},function(data){

		})

		$("#backlistt_pelayanan").html("kembali ke pelayanan").unbind("click").bind("click",function(){
			loadContentPelayanan();
		})
		$("#btn_to_odontogram").hide();
	});

$(function(){
	//=============================================================================
	//POP UP ON FOCUS FUNCTION SHOW DIALOG
	$('#master_gigi_id_hidden').focus(function(){
			$("#dialogcari_master_gigi_id").dialog({
				autoOpen: false,
				modal:true,
				width: 700,
				height: 405,
				buttons : {
					"Cancel" : function() {
					  $(this).dialog("close");
					}
				}
			});
			$('#dialogcari_master_gigi_id').load('c_master_gigi/masterPopup?id_caller=gigi_pop', function() {
				$("#dialogcari_master_gigi_id").dialog("open");
			});
		});

		$('#kd_penyakit_id').focus(function(){
			$("#dialogcari_diagnosa_gigi").dialog({
				autoOpen: false,
				modal:true,
				width: 700,
				height: 405,
				buttons : {
					"Cancel" : function() {
					  $(this).dialog("close");
					}
				}
			});
			$('#dialogcari_diagnosa_gigi').load('c_master_icd/diagnosa_gigi_pop?id_caller=gigi_diagnosa_pop', function() {
				$("#dialogcari_diagnosa_gigi").dialog("open");
			});
		});

		$('#master_gigi_tindakan_id').focus(function(){
			$("#dialogcari_tindakan_gigi").dialog({
				autoOpen: false,
				modal:true,
				width: 700,
				height: 405,
				buttons : {
					"Cancel" : function() {
					  $(this).dialog("close");
					}
				}
			});
			$('#dialogcari_tindakan_gigi').load('c_master_tindakan/masterPopup?id_caller=gigi_tindakan_pop', function() {
				$("#dialogcari_tindakan_gigi").dialog("open");
			});
		});
		$('#master_output_status').focus(function(){
			$("#dialogcari_master_gigi_status_id").dialog({
				autoOpen: false,
				modal:true,
				width: 700,
				height: 405,
				buttons : {
					"Cancel" : function() {
					  $(this).dialog("close");
					}
				}
			});
			$('#dialogcari_master_gigi_status_id').load('c_map_gigi_permukaan/masterPopup?id_caller=gigi_status_pop', function() {
				$("#dialogcari_master_gigi_status_id").dialog("open");
			});
		});
	//END - POP UP DIALOG FUNCtiON
	//=============================================================================
	})
</script>
<div id="main_diagram">
	<div id="main_diagram_gigi"></div>
	<div id="main_diagram_table"></div>

<div id="dialogmastergigi" style="color:red;font-size:.75em;display:none" title="Data Gigi Pasien">
	<p class="no_record">
		Belum ada histori untuk gigi ini. Silahkan masukkan data terlebih dahulu.
	</p>
	<div class="has_record">
		<form class="form">
			<!-- Hold dialog window, to prevent first input text as focus -->
			<span class="ui-helper-hidden-accessible"><input type="text"/></span>
			<!-- end -->
			<input type="hidden" name="main_transaksi_id" id="main_transaksi_id" value="" >
			<div id="gigi_pop">
				<div id="dialogcari_master_gigi_id" title="Nomenklatur"></div>
				<fieldset>
					<span>
						<label class="w-dialog-label">Nomenklatur</label>
						<input type="text" name="kd_gigi" id="master_gigi_id_hidden" style="width:84px;font-size:12px;" value="" tabindex="1" />
						<input type="text" placeholder="Nomenklatur" name="master_gigi_id" id="master_gigi_id" style="font-size:12px;" readonly value="" />
					</span>
				</fieldset>
			</div>
			<fieldset>
				<span>
					<label class="w-dialog-label">Tanggal</label>
					<input type="text" name="tanggal" id="tanggal" class="input-datepicker mydate" value="<?=date('d/m/Y')?>" style="font-size:12px;" tabindex="2">
				</span>
			</fieldset>	
			<div id="gigi_status_pop">
				<div id="dialogcari_master_gigi_status_id" title="Status Gigi"></div>
				<fieldset>
					<span>
						<label class="w-dialog-label">Status Gigi</label>
						<input type="hidden" name="kd_map_id" id="kd_map_id" style="width:84px;font-size:12px;" value="" tabindex="3" />
						<input type="hidden" name="kd_status_gigi" id="master_gigi_status_id_hidden" style="width:84px;font-size:12px;" value="" tabindex="3" />
						<input type="text" name="kd_output_status" id="master_output_status" style="width:84px;font-size:12px;" value="" tabindex="3" />
						<input type="text" placeholder="Status" name="master_gigi_status_id" id="master_gigi_status_id" style="font-size:12px;" readonly value="" tabindex="3" />
					</span>
				</fieldset>
			</div>
			<div id="gigi_diagnosa_pop">
				<div id="dialogcari_diagnosa_gigi" title="Diagnosa Gigi"></div>
				<fieldset>
					<span>
						<label class="w-dialog-label">Diagnosa</label>
						<input type="hidden" name="kd_icd_induk" id="kd_icd_induk_id" style="width:84px;font-size:12px;" value="" tabindex="4"  />
						<input type="text" name="kd_penyakit" id="kd_penyakit_id" style="width:84px;font-size:12px;" value="" tabindex="4"  />
						<input type="text" placeholder="Nama penyakit" name="nama_penyakit" id="nama_penyakit" style="font-size:12px;" readonly value="" tabindex="4" />
					</span>
				</fieldset>
			</div>
			<div id="gigi_tindakan_pop">
				<div id="dialogcari_tindakan_gigi" title="Tindakan Gigi"></div>
				<fieldset>
					<span>
						<label class="w-dialog-label">Tindakan</label>
						<input type="text" name="kd_tindakan" id="master_gigi_tindakan_id" style="width:84px;font-size:12px;" value="" tabindex="5" />
						<input type="text" placeholder="Nama Tindakan gigi" name="tindakan_gigi" id="tindakan_gigi" style="font-size:12px;" readonly value="" tabindex="5"/>
					</span>
				</fieldset>
			</div>
			<fieldset>
				<span>
					<label class="w-dialog-label">Akar Gigi</label>
						<input type="radio" id="akar_gigi_ya" name="akar_gigi" value="1" />Ya
						<input type="radio" id="akar_gigi_tidak" name="akar_gigi" value="0" checked="checked"/>Tidak
				</span>
			</fieldset>
			<fieldset>
				<span>
					<label class="w-dialog-label">Catatan</label>
					<textarea name="note" cols="50" rows="5" id="note_text_area" tabindex="6"></textarea>
				</span>
			</fieldset>	
			<fieldset>
				<span>
					<label class="w-dialog-label">Petugas</label>
					<input type="text" name="kd_petugas_gigi" readonly="readonly" id="master_kd_petugas" value="" style="font-size:12px;">		
				</span>
			</fieldset>
			<div id="set_label_dokter">
				<?php  $this->load->helper('beries_helper'); ?>
				<?=getComboDokterdanPetugas('','kd_dokter_gigi','kd_dokter_gigi_id','disabled','')?>
			</div>

		</form>
	</div>
</div>
</div>

