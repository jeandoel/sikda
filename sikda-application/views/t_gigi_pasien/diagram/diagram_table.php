<script type="text/javascript" src="<?=base_url()?>assets/customjs/t_gigi_diagram_pasien.js"></script>

<script>
	$(function(){
	// TO RESIZE JQGRIB BASED ON WINDOW BROWSER RESIZE
	$(window).bind('resize', function() {
	    $("#listt_diagram").setGridWidth($(window).width()-330);
	}).trigger('resize');

	$("#t_diagramadd").bind('click', function(){
		$(".ui-dialog.ui-widget.ui-widget-content.ui-corner-all.ui-draggable.ui-resizable.ui-dialog-buttons").remove();
		$('.has_record input').prop("disabled", false);
		$('.has_record textarea').prop("disabled", false);
		$('#kd_dokter_gigi_id').prop("disabled", false);
		$('#note_text_area').removeClass();

		$("#main_transaksi_id").val("");
		$("#tanggal").val("");
		
		$("#master_gigi_id_hidden").val("");
		$("#master_gigi_id").val("");
		
		$("#kd_map_id").val("");
		$("#master_gigi_status_id_hidden").val("");
		$("#master_output_status").val("")		
		$("#master_gigi_status_id").val("");		
		
		$("#kd_penyakit_id").val("");
		$("#kd_icd_induk_id").val("");
		$("#nama_penyakit").val("");
		
		$("#master_gigi_tindakan_id").val("");	
		$("#tindakan_gigi").val("");

		$("#note_text_area").val("");
		$('#kd_dokter_gigi_id').val("");

		$("#akar_gigi_ya").prop("checked",false);
		$("#akar_gigi_tidak").prop("checked",true);


		showDialogForm();	
		$(".ui-dialog.ui-widget.ui-widget-content.ui-corner-all.ui-draggable.ui-resizable.ui-dialog-buttons").remove();
		var myid= $(".gigi div.highlighted").attr("id");
		$("#dialogmastergigi").dialog({
		  autoOpen: false,
		  width:450,
          modal:true,
		  buttons : {
			"Confirm" : function() {
			  add_data(myid);
			},
			"Cancel" : function() {
			  $(this).dialog("close");
			}
		  }
		});
		
		$("#dialogmastergigi").dialog("open");
	});
	})

	function refreshDiagramGigi(){
		var sebelum_tanggal = $("#cari_sebelum_tanggal").val();
		// alert(sebelum_tanggal);
	 	$('#main_diagram_gigi').load('t_gigi_diagram_pasien/views/diagram_gigi',{
			'kd_pasien':pasien,
			'kd_puskesmas':puskesmas,
			'sebelum_tanggal':sebelum_tanggal
		},function(data){
			// alert(data);
		})
	}

	function add_data(myid){
		achtungShowLoader();
		var data_terkirim = $("#dialogmastergigi .form").serialize();
		$.ajax({
			  url: 't_gigi_diagram_pasien/addprocess',
			  type: "post",
			  data: data_terkirim+"&kd_pasien="+pasien+"&kd_puskesmas="+puskesmas,
			  success: function(data, status, xhr){
				achtungHideLoader();
				var errorcode = xhr.getResponseHeader("error_code");
				var warning = xhr.getResponseHeader("warning");

				if(errorcode=="0"){
					$("#dialogmastergigi").dialog("close");
					if(confirm('Kembali ke Pelayanan dan tutup Odontogram ?')){
						//CONFIRM STATES
						$('#backlistt_pelayanan').trigger('click');
					}else{
						refreshDiagramGigi();

						$('#listt_diagram').trigger( 'reloadGrid' );
					} 
				}
				achtungCreate(warning);					
			  }
		  })
		achtungHideLoader();
	}
</script>
<div class="mycontent">
<div id="dialog_del_t_gigi" style="color:red;font-size:.75em;display:none" title="Confirmation Required">
	Hapus Data?
</div>
	<form id="formt_diagram">
		<div class="gridtitle">Daftar Simbol Odontogram<span class="tambahdata" id="t_diagramadd">Input Simbol Odontogram</span></div>		
		<fieldset style="margin:0 13px 0 13px ">
						<span>
						<label>Cari Nomenklatur</label>
						<input type="text" id="nomor_gigi_hid" value=""/>
						<!-- <label>Cari Waktu</label>
						<input type="text" name="kode" class="input-datepicker kode" id="kodet_diagram" style="margin-top:6px;" />
						 -->
						 <label>Cari Sebelum Tanggal</label>
						<input type="text" name="cari_sebelum_tanggal" class="input-datepicker mydate kode" id="cari_sebelum_tanggal" style="margin-top:6px;" />
						<input type="submit" class="cari" value="&nbsp;Cari&nbsp;" id="carit_diagram"/>
						<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="resett_diagram"/>
						</span>
					</fieldset>
		<div class="paddinggrid">
		<table id="listt_diagram"></table>
		<div id="pagert_diagram"></div>
		</div >
	</form>
</div>