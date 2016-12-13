jQuery().ready(function (){
    jQuery("#listt_pelayananantrian").jqGrid({
        url:'t_pelayanan/t_pelayananantrianxml',
        emptyrecords: 'Tidak ada data',
        datatype: "xml",
        colNames:['ID_KUNJUNGAN','a','KD_PASIEN','KD_PUSKESMAS','Urut<br/>Masuk','Rekam<br/> Medis','Nama Pasien','Umur','KK','Alamat','Unit','Petugas','Status','Aksi','SK'],
        rownumbers:true,
        width: 1049,
        height: 'auto',
        mtype: 'POST',
        altRows     : false,
        colModel:[
            {name:'id_kunjungan',index:'id_kunjungan', width:5,hidden:true},
            // {name:'id_kunjungan',index:'id_kunjungan', width:105},
            {name:'kd_pelayanan',index:'kd_pelayanan', width:5,hidden:true},
            {name:'kd_puskesmas',index:'kd_puskesmas', width:5,hidden:true},
            {name:'idb',index:'idb', width:5,hidden:true},
            {name:'column1b',index:'column1b', width:35,sortable:false,align:'center'},
            {name:'column2b',index:'column2b', width:55,sortable:false},
            {name:'column3b',index:'column3b', width:115,sortable:false},
            {name:'column3b',index:'column3b', width:55,sortable:false,align:'center'},
            {name:'column4b',index:'column4b', width:115,sortable:false},
            {name:'column5b',index:'column5b', width:155,sortable:false},
            {name:'column6b',index:'column6b', width:95,sortable:false,align:'center'},
            {name:'column7b',index:'column7b', width:75,sortable:false,align:'center'},
            {name:'column8b',index:'column8b', width:85,sortable:false,align:'center',formatter:formatterStatus},
            {name:'aksib',index:'aksib', width:80,align:'center',formatter:formatterPelayanan},
            {name:'aksic',index:'aksic', width:40,align:'center',formatter:formatterCetak}
        ],
        rowNum:5,
        rowList:[5,10,25],
        pager: jQuery('#pagert_pelayanananantrian'),
        viewrecords: true,
        sortorder: "desc",
        beforeRequest:function(){
            dari=$('#tanggalt_pelayananantrian').val()?$('#tanggalt_pelayananantrian').val():'';
            unit=$('#poliklinikt_pelayananantrian').val()?$('#poliklinikt_pelayananantrian').val():'';
            mystatus=$('#status_pelayanant_pelayananantrian').val()?$('#status_pelayanant_pelayananantrian').val():'';
            myjenis=$('#jenis_pelayanant_pelayananantrian').val()?$('#jenis_pelayanant_pelayananantrian').val():'';
            get_key=$('#get_key_pendaftaran').val()?$('#get_key_pendaftaran').val():'';
            get_cari=$('#get_cari_pendaftaran').val()?$('#get_cari_pendaftaran').val():'';
            $('#listt_pelayananantrian').setGridParam({postData:{'dari':dari,'unit':unit,'status':mystatus,'jenis':myjenis,'get_key':get_key,'get_cari':get_cari}})
        },
        loadComplete:function(data){
            console.log(data);
        },
        multiselect: false,
        subGrid: true,
        subGridRowExpanded: function(subgrid_id, row_id) {
            achtungHideLoader();
            var subgrid_table_id_riwayat, pager_id_riwayat;
            subgrid_table_id_riwayat = subgrid_id+"_t_riwayat2b";
            pager_id_riwayat = 'p2b_'+subgrid_table_id_riwayat;
            var rowval = $('#listt_pelayananantrian').jqGrid('getRowData', row_id);
            var kd_puskesmas = rowval.kd_puskesmas;
            var kd_pasien = rowval.idb;
            var id_kunjungan = rowval.id_kunjungan;
            var kd_pelayanan = rowval.kd_pelayanan;

            var htm='';
            htm += '<div class="subgridtitle">Riwayat Pasien</div>';
            htm +="<table id='"+subgrid_table_id_riwayat+"' class='scroll'></table><div id='"+pager_id_riwayat+"' class='scroll'></div>";
            $("#"+subgrid_id).append(htm);

            jQuery("#"+subgrid_table_id_riwayat).jqGrid({
                url:'t_pelayanan/t_subgridpelayanankia',
                rownumbers:true,
                mtype: 'POST',
                width: 750,
                height: 'auto',
                datatype: "xml", colNames: ['A','B','C','D','Tanggal Kunjungan','Unit','Pemeriksa','Petugas','Aksi'],
                colModel: [ {name:'id_kunjungan',index:'id_kunjungan', width:5,hidden:true},
                    {name:'kd_pelayanan',index:'kd_pelayanan', width:5,hidden:true},
                    {name:'kd_puskesmas',index:'kd_puskesmas', width:5,hidden:true},
                    {name:'idb',index:'idb', width:5,hidden:true},
                    {name:"tgl_kunjungan",index:"tgl_kunjungan",width:80,align:'center',sortable:false},
                    {name:"unit",index:"unit",width:50,align:"center",sortable:false},
                    {name:"pemeriksa",index:"pemeriksa",width:50,align:"center",sortable:false},
                    {name:"petugas",index:"petugas",width:50,align:"center",sortable:false},
                    {name:'aksib',index:'aksib', width:61,align:'center',formatter:formatterAction}
                ],
                rowNum:5,
                pager: pager_id_riwayat,

                beforeRequest:function(){
                    $('#'+subgrid_table_id_riwayat).setGridParam({postData:{'kd_pelayanan':kd_pelayanan,'kd_pasien':kd_pasien,'kd_puskesmas':kd_puskesmas,'id_kunjungan':id_kunjungan}})
                }
            });
            $("#"+subgrid_table_id_riwayat+" .icon-detail").live('click', function(h){
                if($(h.target).data('oneclicked')!='yes')
                {
                    var colid1 = $(this).closest('tr');
                    var colid = colid1[0].id;
                    $("#"+subgrid_table_id_riwayat).jqGrid('setSelection', colid );
                    var myIdKunjungan = jQuery('#'+subgrid_table_id_riwayat).jqGrid('getCell', colid, 'id_kunjungan');
                    var myCellDataId = jQuery('#'+subgrid_table_id_riwayat).jqGrid('getCell', colid, 'kd_pelayanan');
                    var myCellDataPuskesmas = jQuery("#"+subgrid_table_id_riwayat).jqGrid("getCell", colid, "kd_puskesmas");
                    $("#t203","#tabs").empty();
                    $("#t203","#tabs").load('t_pelayanan/detailkunjunganpasien'+'?id_kunjungan='+myIdKunjungan+'&kd_pelayanan='+myCellDataId+'&kd_puskesmas='+myCellDataPuskesmas);
                }
                $(h.target).data('oneclicked','yes');
            });
        },subGridBeforeExpand:function(subgrid_id,row_id){
            achtungShowLoader();
        }
    }).navGrid('#pagert_pelayanananantrian',{edit:false,add:false,del:false,search:false});

    function formatterAction(cellvalue, options, rowObject) {
        var content = '';
        content  += '<a rel="' + cellvalue + '" class="icon-detail"  title="View"></a> ';
        return content;
    }

    function formatterPelayanan(cellvalue, options, rowObject) {
        var content = '';
        if(cellvalue=='SUDAH'){
            content += '-';
        }else if(cellvalue=='CHECK'){
            content  += '<a rel="'+cellvalue+'" class="lab-red">Check</a>';
        }else{
            content  += '<a rel="'+cellvalue+'" class="lab-blue">Pelayanan</a>';
        }
        return content;
    }

    function formatterCetak(cellvalue, options, rowObject) {
        content = '<a rel="' + cellvalue + '" class="icon-print" title="Cetak Surat Keterangan"></a> ';

        return content;
    }

    function formatterStatus(cellvalue, options, rowObject) {
        var content = '';
        if(cellvalue=='BELUM DILAYANI'){
            content  += '<span style="color:green">'+cellvalue+'<span>';
        }else if(cellvalue=='CHECK ULANG'){
            content  += '<span style="color:red">'+cellvalue+'<span>';
        }else{
            content  += '<span style="color:blue">'+cellvalue+'<span>';
        }
        return content;
    }
    // -------------------------------------------------------------------------- //


    $("#listt_pelayananantrian .lab-blue").live('click', function(e){
        if($(e.target).data('oneclicked')!='yes')
        {
            $("#listt_pelayananantrian").find('.lab-blue').each(function() {
                $(this).click( function(){
                    var colid = $(this).parents('tr:last').attr('id');
                    $("#listt_pelayananantrian").jqGrid('setSelection', colid );
                    var myCellDataId = jQuery('#listt_pelayananantrian').jqGrid('getCell', colid, 'idb');
                    var myCellDataId2 = jQuery('#listt_pelayananantrian').jqGrid('getCell', colid, 'kd_puskesmas');
                    var myCellDataId3 = jQuery('#listt_pelayananantrian').jqGrid('getCell', colid, 'id_kunjungan');
                    $("#t203","#tabs").empty();
                    $("#t203","#tabs").load('t_pelayanan/layanan'+'?id='+decodeURIComponent(myCellDataId)+'&id2='+decodeURIComponent(myCellDataId2)+'&id3='+decodeURIComponent(myCellDataId3));
                });
            });
        }
        $(e.target).data('oneclicked','yes');
    });

    //-------------------------------------------------------------------------------//

    $("#listt_pelayananantrian .lab-red").live('click', function(e){
        if($(e.target).data('oneclicked')!='yes')
        {
            $("#listt_pelayananantrian").find('.lab-red').each(function() {
                $(this).click( function(){
                    var colid = $(this).parents('tr:last').attr('id');
                    $("#listt_pelayananantrian").jqGrid('setSelection', colid );
                    var myCellDataId = jQuery('#listt_pelayananantrian').jqGrid('getCell', colid, 'idb');
                    var myCellDataId2 = jQuery('#listt_pelayananantrian').jqGrid('getCell', colid, 'kd_puskesmas');
                    var myCellDataId3 = jQuery('#listt_pelayananantrian').jqGrid('getCell', colid, 'id_kunjungan');
                    $("#t203","#tabs").empty();
                    $("#t203","#tabs").load('t_pelayanan/check'+'?id='+decodeURIComponent(myCellDataId)+'&id2='+decodeURIComponent(myCellDataId2)+'&id3='+decodeURIComponent(myCellDataId3));
                });
            });
        }
        $(e.target).data('oneclicked','yes');
    });


    //------------------------------------------------------------------------------------//
    $("#listt_pelayananantrian .icon-print").live('click', function(e){
        if($(e.target).data('oneclicked')!='yes')
        {
            $("#listt_pelayananantrian").find('.icon-print').each(function() {
                $(this).click( function(){
                    var colid = $(this).parents('tr:last').attr('id');
                    $("#listt_pelayananantrian").jqGrid('setSelection', colid );
                    var myCellDataId = jQuery('#listt_pelayananantrian').jqGrid('getCell', colid, 'idb');
                    var myCellDataId2 = jQuery('#listt_pelayananantrian').jqGrid('getCell', colid, 'kd_puskesmas');
                    var myCellDataId3 = jQuery('#listt_pelayananantrian').jqGrid('getCell', colid, 'id_kunjungan');

                    $("#dialogt_pelayanancetaksk").dialog({
                        autoOpen: false,
                        modal:true,
                        width: 500,
                        height: 405,
                        buttons : {

                        }
                    });
                    $('#dialogt_pelayanancetaksk').load('surat_keterangan?kdpasien='+decodeURIComponent(myCellDataId), function() {
                        $("#dialogt_pelayanancetaksk").dialog("open");
                    });
                    /*NewWin = window.open('surat_keterangan/cetak_sk?kdpasien='+decodeURIComponent(myCellDataId)+'&kdpuskesmas='+decodeURIComponent(myCellDataId2)+'&kdkunjungan='+decodeURIComponent(myCellDataId3));*/
                });
            });
        }
        $(e.target).data('oneclicked','yes');
    });


    //------------------------------------------------------------------------------------//

    $('form').resize(function(e) {
        if($("#listt_pelayanan").getGridParam("records")>0){
            jQuery('#listt_pelayanan').setGridWidth(($(this).width()-28));
        }
        if($("#listt_pelayananantrian").getGridParam("records")>0){
            jQuery('#listt_pelayananantrian').setGridWidth(($(this).width()-28));
        }
    });

    //$('#darit_pelayanan').datepicker({dateFormat: "dd/mm/yy",changeYear: true,onSelect: function(dateText, inst){$('#sampait_pelayanan').datepicker('option', 'minDate', dateText);$.datepicker._clearDate('#sampait_pelayanan');$('#listt_pelayanan').trigger("reloadGrid");}});
    $('#tanggalt_pelayananantrian').datepicker({dateFormat: "dd/mm/yy",changeYear: true,onClose: function(dateText, inst){$('#listt_pelayananantrian').trigger("reloadGrid");}});
    //$("#darit_pelayanan").mask("99/99/9999");
    $("#tanggalt_pelayananantrian").mask("99/99/9999");
    jQuery.fn.reset = function (){
        $(this).each (function() { this.reset(); });
    }
    $("#resett_pelayanan").live('click', function(event){
        event.preventDefault();
        $('#formt_pelayanan').reset();
        $('#listt_pelayananantrian').trigger("reloadGrid");
    });
    $("#carit_pelayanan").live('click', function(event){
        event.preventDefault();
        $('#listt_pelayananantrian').trigger("reloadGrid");
    });

})