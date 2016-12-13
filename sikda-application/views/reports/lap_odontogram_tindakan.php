<script>
    $('document').ready(function(){
        $('#dari_tgl_report').datepicker({dateFormat: "yy-mm-dd"});
        $('#sampai_tgl_report').datepicker({dateFormat: "yy-mm-dd"});
        jQuery.fn.reset = function (){
            $(this).each (function() { this.reset(); });
        }

        $("#resethrj").click(function(event){
            event.preventDefault();
            $('#formmasterhrj').reset();
        });
//        PDF ACTION
        $("#pdf_report_odontogram").click(function(event){
            event.preventDefault();
            var from = $('#dari_tgl_report').val();
            var to = $('#sampai_tgl_report').val();
            var pid = $('#idsessgroup').val();
            var jenis_report_odontogram = $('#jenis_report_odontogram').val();
            window.open('<?=site_url().'sikda_reports/report.php?from='?>'+decodeURIComponent(from)+'&to='+decodeURIComponent(to)+'&pid='+decodeURIComponent(pid)+'&jenis='+decodeURIComponent(jenis_report_odontogram));
        });
//        EXCEL ACTION
        $("#excel_report_odontogram").click(function(event){
            event.preventDefault();
            var from = $('#dari_tgl_report').val();
            var to = $('#sampai_tgl_report').val();
            var pid = $('#idsessgroup').val();
            var jenis_report_odontogram = $('#jenis_report_odontogram').val();
            window.open('<?=base_url().'report_bulanan/odontogram_tindakan_excel?from='?>'+decodeURIComponent(from)+'&to='+decodeURIComponent(to)+'&pid='+decodeURIComponent(pid)+'&jenis='+decodeURIComponent(jenis_report_odontogram));
        });
    })
</script>
<style>
        /*.ui-datepicker-calendar {
        display: none;
        }*/
</style>
<div class="mycontent">
    <div class="formtitle">Laporan Tindakan Odontogram</div>
    <form id="formmasterhrj">
        <div class="gridtitle">&nbsp;</div>
        <fieldset style="margin:0 13px 0 13px ">
						<span>
						<label>Dari</label>
						<input type="text" name="dari" class="dari" id="dari_tgl_report" value="<?=date('Y-m-01');?>" /> Sampai
						<input type="text" name="sampai" class="sampai" id="sampai_tgl_report" value="<?=date('Y-m-t');?>" />
						</span>
						<span>
						<input type="submit" class="cari" value="&nbsp;Cetak PDF&nbsp;" id="pdf_report_odontogram"/>
						<input type="submit" class="cari" value="&nbsp;Cetak Excel&nbsp;" id="excel_report_odontogram"/>
						<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="resethrj"/>
						<input type="hidden" name="idsessgroup" id="idsessgroup" value="<?=$this->session->userdata('group_id')=='kabupaten'?$this->session->userdata('kd_kabupaten'):$this->session->userdata('kd_puskesmas')?>" />
						<input type="hidden" name="jenis_report_odontogram" id="jenis_report_odontogram" value="<?=$this->session->userdata('group_id')=='kabupaten'?'rpt_tindakan_odontogram_kb':'rpt_tindakan_odontogram'?>" />
						</span>
        </fieldset>
    </form>
</div>