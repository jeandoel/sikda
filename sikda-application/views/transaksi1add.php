<script>
jQuery().ready(function (){ 
		$('#form1transaksi1add').ajaxForm({
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
					$.achtung({message: 'Proses Tambah Data Berhasil', timeout:5});
					$("#t2","#tabs").empty();
					$("#t2","#tabs").load('transaksi1'+'?_=' + (new Date()).getTime());
				}
			}
		});
		
		$(function(){
		$('.viewpopuptransaksi1').click(function(){
			$("#dialogtransaksi1_cari_column").dialog({
				autoOpen: false,
				modal:true,
				width: 550,
				height: 355,
				buttons : {
					"Cancel" : function() {
					  $(this).dialog("close");
					}
				}
			});
			
			$('#dialogtransaksi1_cari_column').load('master1/master1popup?id_caller=form1transaksi1add&id_button='+$(this).attr('id'), function() {
				$("#dialogtransaksi1_cari_column").dialog("open");
			});
		});
		});
		
		var i = 2;
		$("#appendnewtransaksi1").click(function() {
			$(".clonetransaksi1:first").clone().find("input").each(function() {
				if($(this).val()=='...'){
					$(this).attr('id', function(_, id) { return id + '___'+i });
				}else{
					$(this).val('').attr('id', function(_, id) { return id=='viewpopuptransaksi1'?id:id +'___'+i });
				}
			}).end().appendTo("#myplaceholdertransaksi1");
			i++;
		});
		
})

$('#tgltransaksi1').datepicker({dateFormat: "dd-mm-yy",changeYear: true});
</script>
<script>
	$('#backlisttransaksi1').click(function(){
		$("#t2","#tabs").empty();
		$("#t2","#tabs").load('transaksi1'+'?_=' + (new Date()).getTime());
	})
</script>
<div id="dialogtransaksi1_cari_column" title="Master Satu"></div>
<div id="dialogtransaksi1_cari_column_b" title="Master Satu2"></div>
<div class="mycontent">
<div class="formtitle">Tambah Transaksi Satu</div>
<div class="backbutton"><span class="kembali" id="backlisttransaksi1">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="form1transaksi1add" method="post" action="<?=site_url('transaksi1/addprocess')?>" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Column Satu</label>
		<input type="text" name="column1" id="column1transaksi1add" value="" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Column Dua</label>
		<input type="text" name="column2" id="column2transaksi1add" value=""  />
		</span>
	</fieldset>	
	<fieldset>
		<span>
		<label>Column Tiga</label>
		<textarea name="column3" rows="3" cols="45"></textarea>
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Tanggal Transaksi Satu</label>
		<input type="text" name="tgltransaksi1" id="tgltransaksi1" value="<?=date('Y-m-d')?>" style="width:89px" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>&nbsp;</label>
		<button  type="button" id="appendnewtransaksi1">Tambah Obat Baru</button>
		</span>
	</fieldset>
	<fieldset class="clonetransaksi1">
		<span>
		<label>Obat</label>
		<input type="text" style="width:11px" name="column_master_no_1" id="column_master_no_1" value="1" readonly  />
		<input type="text" name="column_master_1" id="column_master_1" value="" readonly  />
		<input type="hidden" name="column_master_1_id" id="column_master_1_hidden" value=""  />
		<input type="button" class="viewpopuptransaksi1" id="cari_column_master_1" value="..." >
		</span>
	</fieldset>
	<div id="myplaceholdertransaksi1"></div>
	<fieldset>
		<span>
		<input type="submit" name="bt1" value="Proses Data"/>
		</span>
	</fieldset>	
</form>
</div >