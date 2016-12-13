<style type="text/css">
    .diagram_gigi_base{
        width: 50%;
        float: left;
    }
    .diagram_gigi_dewasa div,
    .diagram_gigi_anak div{
        display: inline-block;
        margin-top: 5px;
    }
    .text-align-right{
        text-align: right;
        margin-right: 10px;
    }
    .text-align-left{
        text-align: left;
        margin-left: 10px;
    }
    .line-top{
        border-top: 1px solid black;
    }
    .line-right{
        border-right: 1px solid black;
        padding-right: 5px;
    }
    .line-left{
        border-left: 1px solid black;
        padding-left: 5px;
    }
    .line-bottom{
        border-bottom: 1px solid black;
        padding-bottom: 5px;
    }
    .highlighted{
        background: yellow;
    }
    .d-none{
        display: none;
    }
    .diagram_gigi_dewasa .d-block,
    .diagram_gigi_anak .d-block,
    .d-block{
        display: block;
    }
    .ta-center{
        text-align: center;
    }
    .nomor-gigi{
        font-size:12px;
    }
    .t-gigi-anak-padding{
        padding-left: 12px;
        padding-right: 10px;
    }
    .t-gigi-anak-mtop{
        margin-top: 27px;
    }
    .t-gigi-anak-mbot{
        margin-bottom: 27px;
    }

    .w-dialog-label{
        width: 90px;
        font-size: 12px;
    }
    .ui-jqgrid tr.ui-row-ltr td{
        vertical-align: middle !important;
    }
    .note_text_area{
        background: #eee;
    }
    .akar-gigi-css{
        position: absolute;
        bottom: 22px;
        left: 15px;
    }
    .item-gigi{
        position: relative;
    }
    .diagram_gigi_dewasa,
    .diagram_gigi_anak{
        overflow:hidden;
    }
    .line-right.line-bottom .item-gigi,
    .line-right.line-top .item-gigi{
        float:right;
    }
    .line-left.line-bottom .item-gigi,
    .line-left.line-top .item-gigi{
        float:left;
    }
    #dmf_info{
        text-align: right;
        margin-bottom:15px;
        font-size:0.75em;
    }
</style>

<!-- INI BAGIAN DARI JAVASCRIPT 

---------------------------------------------------------------------------
-->
<script type="text/javascript" src="<?=base_url()?>assets/js/date.format.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/js/ajax-load-global.js"></script>
<script type="text/javascript">
    var pasien = $("#get_pasien_id").attr("value");
    var petugas = $("#get_petugas_id").attr("value");
    var puskesmas = $("#get_puskesmas_id").attr("value");
    var get_transaksi_id = $("#main_transaksi_id").attr("value");

    $(function(){

        $(".gigi .item-gigi").bind("click",function(){
            $(".gigi div").removeClass("highlighted");
            $(this).addClass("highlighted");
            var id_gigi = $(this).attr("id");

            $("#nomor_gigi_hid").val(id_gigi);
            // console.log("asd");
            $("#listt_diagram").trigger("reloadGrid");
        });

        $("#master_kd_petugas").val(petugas);
        $("#set_label_dokter label").addClass('w-dialog-label');
    });
</script>
<script type="text/javascript">

    function showDialogForm(){
        $("#dialogmastergigi .has_record").show();
        $("#dialogmastergigi .no_record").hide();
        $("#dialogmastergigi").siblings(".ui-dialog-buttonpane.ui-widget-content.ui-helper-clearfix").show();
    }

    function showButtonEdit(){

    }
    function enableDialogForm(){
        $(".dialog-btn-confirm").show();
        $(".dialog-btn-edit").hide();
    }

    $(function(){

        $(".diagram_gigi_dewasa .item-gigi, .diagram_gigi_anak .item-gigi").bind('dblclick', function(){
            $(".ui-dialog.ui-widget.ui-widget-content.ui-corner-all.ui-draggable.ui-resizable.ui-dialog-buttons").remove();
            $('.has_record input').prop("disabled", true);
            $('.has_record textarea').prop("disabled", true);
            $('#kd_dokter_gigi_id').prop("disabled", true);
            $('#note_text_area').addClass('note_text_area');
            var myid= $(".gigi div.highlighted").attr("id");
            $.ajax({
                url:"t_gigi_diagram_pasien/data_gigi",
                type:"POST",
                cache:false,
                data:"nomor_gigi="+myid+"&kd_pasien="+pasien+"&kd_puskesmas="+puskesmas,
                success:function(msg){
                    msg = $.parseJSON(msg);
                    if(!$.isEmptyObject(msg)){
                        showDialogForm();

                        $("#main_transaksi_id").val(msg.main_transaksi_id);
                        $("#tanggal").val(msg.tanggal);

                        $("#master_gigi_id_hidden").val(msg.kode_gigi);
                        $("#master_gigi_id").val(msg.kode_n_gigi);

                        $("#kd_map_id").val(msg.kode_map_id);
                        $("#master_gigi_status_id_hidden").val(msg.kode_status);
                        $("#master_output_status").val(msg.kode_output_status)
                        $("#master_gigi_status_id").val(msg.kode_n_status);

                        $("#kd_penyakit_id").val(msg.kode_penyakit);
                        $("#kd_icd_induk_id").val(msg.kode_icd_induk);
                        $("#nama_penyakit").val(msg.kode_n_penyakit);

                        $("#master_gigi_tindakan_id").val(msg.kode_produk);
                        $("#tindakan_gigi").val(msg.kode_n_produk);

                        $("#kd_dokter_gigi_id").val(msg.kode_dokter);
                        $("#note_text_area").val(msg.note);

                        if(msg.akar_gigi == 1){
                            $("#akar_gigi_ya").prop("checked",true);
                            $("#akar_gigi_tidak").prop("checked",false);
                        }else{
                            $("#akar_gigi_ya").prop("checked",false);
                            $("#akar_gigi_tidak").prop("checked",true);
                        }
                    }else{
                        $("#dialogmastergigi").siblings(".ui-dialog-buttonpane.ui-widget-content.ui-helper-clearfix").hide();
                        $("#dialogmastergigi .has_record").hide();
                        $("#dialogmastergigi .no_record").show();
                    }
                }
            })
            $("#dialogmastergigi").dialog({
                autoOpen: false,
                width:450,
                modal:true,
                buttons : [
                    //TO MAKE EDIT WHEN DOUBLE CLICK GIGI DIAGRAM
                    //  	{
                    //  		'text' : 'Confirm',
                    //  		'class' : 'dialog-btn-confirm d-none',
                    // 	'click' : function() {
                    // 	  edit_data(myid);
                    // 	}
                    // },
                    //  	{
                    //  		'text' : 'Edit',
                    //  		'class' : 'dialog-btn-edit',
                    // 	'click' : function() {
                    // 		$('.has_record input').prop("disabled", false);
                    // 		$('.has_record textarea').prop("disabled", false);
                    // 		$('#kd_dokter_gigi_id').prop("disabled", false);
                    // 		$('#note_text_area').removeClass();
                    // 		enableDialogForm();
                    // 	}
                    // },
                    {
                        'text' : 'Cancel',
                        'click' : function() {
                            $(this).dialog("close");
                        }
                    },
                ]
            });

            $("#dialogmastergigi").dialog("open");
        });


        $("#toggle_diagram_gigi_anak").click(function(){

                $(".diagram_gigi_base4 img").toggle();
                $(".toggle-gigi-anak").toggleClass('t-gigi-anak-padding');
                $(".diagram_gigi_base5").toggleClass('t-gigi-anak-mtop');
                $(".diagram_gigi_base6").toggleClass('t-gigi-anak-mbot');

            }
        );
    })

    function edit_data(myid){

        var data_terkirim = $("#dialogmastergigi .form").serialize();
        achtungShowLoader();
        $.ajax({
            url: 't_gigi_diagram_pasien/addprocess',
            type: "post",
            data: data_terkirim,
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
                        $('#main_diagram_gigi').load('t_gigi_diagram_pasien/views/diagram_gigi',{
                            'kd_pasien':kd_pasien,
                            'kd_puskesmas':kd_puskesmas
                        },function(data){
                        })
                        $('#listt_diagram').trigger( 'reloadGrid' );
                    }

                }
                achtungCreate(warning);
            }
        })
        achtungHideLoader();
    }
</script>
<!-- VIEW 

INI BAGIAN DARI VIEW
-->

<!-- <div> BUTTON UNTUK SHOW HIDE & ANAK
	<input type="button" id="toggle_diagram_gigi_anak" value="Show Diagram Anak">
</div> -->
<div id="form"></div>
<?php
$order = array(
    array(
        'section'=>'line-right line-bottom',
        'data'=>array(
            array(
                'vertical'=>'diagram_gigi_dewasa gigi text-align-right',
                'gigi_nomor'=>'d-block ta-center nomor-gigi',
                'gigi'=>array(11, 12, 13, 14, 15, 16, 17, 18)
            ),
            array(
                'vertical'=>'diagram_gigi_anak gigi text-align-right diagram_gigi_base4 diagram_gigi_base5',
                'gigi_nomor'=>'d-block ta-center nomor-gigi toggle-gigi-anak',
                'gigi'=>array(51, 52, 53, 54, 55)
            )
        )
    ),
    array(
        'section'=>'line-left line-bottom',
        'data'=>array(
            array(
                'vertical'=>'diagram_gigi_dewasa gigi text-align-left',
                'gigi_nomor'=>'d-block ta-center nomor-gigi',
                'gigi'=>array(21, 22, 23, 24, 25, 26, 27, 28)
            ),
            array(
                'vertical'=>'diagram_gigi_anak gigi text-align-left diagram_gigi_base4 diagram_gigi_base5',
                'gigi_nomor'=>'d-block ta-center nomor-gigi toggle-gigi-anak',
                'gigi'=>array(61, 62, 63, 64, 65)
            )
        )
    ),
    array(
        'section'=>'line-right line-top',
        'data'=>array(
            array(
                'vertical'=>'diagram_gigi_dewasa gigi text-align-right diagram_gigi_base4 diagram_gigi_base6',
                'gigi_nomor'=>'d-block ta-center nomor-gigi toggle-gigi-anak ',
                'gigi'=>array(81, 82, 83, 84, 85)

            ),
            array(
                'vertical'=>'diagram_gigi_anak gigi text-align-right',
                'gigi_nomor'=>'d-block ta-center nomor-gigi',
                'gigi'=>array(41, 42, 43, 44, 45, 46, 47, 48)
            )
        )
    ),
    array(
        'section'=>'line-left line-top',
        'data'=>array(
            array(
                'vertical'=>'diagram_gigi_dewasa gigi text-align-left diagram_gigi_base4 diagram_gigi_base6',
                'gigi_nomor'=>'d-block ta-center nomor-gigi toggle-gigi-anak',
                'gigi'=>array(71, 72, 73, 74, 75)

            ),
            array(
                'vertical'=>'diagram_gigi_anak gigi text-align-left',
                'gigi_nomor'=>'d-block ta-center nomor-gigi',
                'gigi'=>array(31, 32, 33, 34, 35, 36, 37, 38)
            )
        )
    )
);
?>

<div id="dmf_info">D (Decay) = <?php echo $data_dmf['D']?> | M (Missing) = <?php echo $data_dmf['M']?> | F (Filling) = <?php echo $data_dmf['F']?> | T (Total) = <?php echo $data_dmf['D']+$data_dmf['M']+$data_dmf['F']; ?></div>
<?php foreach($order as $bagan){ ?>
<div class="diagram_gigi_base">
    <div class="<?php echo $bagan['section']; ?>">
        <?php foreach($bagan['data'] as $section){ ?>
        <div class="<?php echo $section['vertical']; ?>">

            <?php foreach($section['gigi'] as $kd_gigi){ ?>
            <div id="<?=$kd_gigi?>" class="item-gigi">
                <div class="d-block ta-center">
                    <?php
                    if(!empty($data_gigi[$kd_gigi])){ ?>
                        <img src="./assets/images/map_gigi_permukaan/<?php echo $data_gigi[$kd_gigi]['GAMBAR_MAP'];?>" width="45px" height="75px">
                        <?php }else{
                        if(!empty($m_data_gigi[$kd_gigi]['GAMBAR'])){?>
                            <img src="./assets/images/gigi_master/<?php echo $m_data_gigi[$kd_gigi]['GAMBAR'];?>" width="45px" height="75px">
                            <?php }else{?>
                            <img src="./assets/images/gigi_master/default.png" width="45px" height="75px">
                            <?php }?>
                        <?php }?>

                </div>
                <?php if(!empty($data_gigi[$kd_gigi]) && $data_gigi[$kd_gigi]['AKAR_GIGI'] == '1'){ ?>
                <div class="akar-gigi-css">
                    <img src="./assets/images/map_gigi_permukaan/akar_gigi.png" width="16px" height="13px">
                </div>
                <?php }else{ ?>
                <?php } ?>
                <div class="<?php echo $section['gigi_nomor'];?>">#<?php echo $kd_gigi; ?></div>
            </div>
            <?php } ?>
        </div>
        <?php } ?>

    </div>
</div>
<?php } ?>
