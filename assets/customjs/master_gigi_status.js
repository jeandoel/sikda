jQuery().ready(function (){
    jQuery("#listmastergigistatus").jqGrid({
        url:'c_master_gigi_status/masterXml',
        emptyrecords: 'Nothing to display',
        datatype: "xml",
        colNames:['Kode','Gambar', 'Status','Deskripsi','DMF','Jumlah Gigi', 'Action'],
        rownumbers:true,
        width: 1021,
        height: 'auto',
        mtype: 'POST',
        altRows     : true,
        colModel:[
            {name:'kd_status_gigi',index:'kd_status_gigi', width:7, align:'center'},
            {name:'gambar',index:'gambar', width:7, align:'center', formatter:formatterImageGigi},
            {name:'status',index:'status', width:25},
            {name:'deskripsi',index:'deskripsi', width:35},
            {name:'dmf',index:'dmf', width:5, align:'center'},
            {name:'jumlah_gigi',index:'jumlah_gigi', width:5, align:'center'},
            {name:'x',index:'x', width:10,align:'center',formatter:formatterAction}
        ],
        rowNum:10,
        rowList:[10,20,30],
        pager: jQuery('#pagermastergigistatus'),
        viewrecords: true,
        sortorder: "desc",
        beforeRequest:function(){
            kd_status_gigi=$('#kodemastergigistatus').val()?$('#kodemastergigistatus').val():'';
            status=$('#statusmastergigistatus').val()?$('#statusmastergigistatus').val():'';
            $('#listmastergigistatus').setGridParam({postData:{'kd_status_gigi':kd_status_gigi, 'status':status}})
        }
    }).navGrid('#pagermastergigistatus',{edit:false,add:false,del:false,search:false});

    function formatterAction(cellvalue, options, rowObject) {
        var content = '';
        content  += '<a rel="' + cellvalue + '" class="icon-detail" title="View"></a> ';
        content  += '<a rel="' + cellvalue + '" class="icon-edit" title="Edit?"></a>';
        content  += '<a rel="' + cellvalue + '" class="icon-delete" title="Remove?"></a>';
        return content;
    }
    function formatterImageGigi(cellValue, options, rowObject){
        var content = '';
        content += '<img src="./assets/images/map_gigi_permukaan/'+cellValue+'" width="35" height="60"/>';
        return content;
    }

    $("#listmastergigistatus .icon-detail").live('click', function(p){
        if($(p.target).data('oneclicked')!='yes')
        {
            $("#t1003","#tabs").empty();
            $("#t1003","#tabs").load('c_master_gigi_status/detail'+'?kd_status_gigi='+this.rel);
        }
        $(p.target).data('oneclicked','yes');
    });

    $("#listmastergigistatus .icon-edit").live('click', function(p){

        if($(p.target).data('oneclicked')!='yes')
        {
            $("#t1003","#tabs").empty();
            $("#t1003","#tabs").load('c_master_gigi_status/edit'+'?kd_status_gigi='+this.rel);
        }
        $(p.target).data('oneclicked','yes');
    });

    function deldata(myid){
        achtungShowLoader();
        $.ajax({
            url: 'c_master_gigi_status/delete',
            type: "post",
            data: {kd_status_gigi:myid},
            dataType: "json",
            success: function(msg){
                if(msg == 'OK'){
                    $("#dialogmastergigistatus").dialog("close");
                    $.achtung({message: 'Proses Hapus Data Berhasil', timeout:5});
                    $('#listmastergigistatus').trigger("reloadGrid");
                }
                else{
                    $("#dialogmastergigistatus").dialog("close");
                    $.achtung({message: 'Maaf Proses Hapus Data Gagal', timeout:5});
                }
            }
        });
        achtungHideLoader();
    }

    $("#listmastergigistatus .icon-delete").live('click', function(){
        var myid= this.rel;
        $("#dialogmastergigistatus").dialog({
            autoOpen: false,
            modal:true,
            buttons : {
                "Confirm" : function() {
                    deldata(myid);

                },
                "Cancel" : function() {
                    $(this).dialog("close");
                }
            }
        });

        $("#dialogmastergigistatus").dialog("open");
    });

    $('form').resize(function(e) {
        if($("#listmastergigistatus").getGridParam("records")>0){
            jQuery('#listmastergigistatus').setGridWidth(($(this).width()-28));
        }
    });

    function formattermou(cellvalue, options, rowObject) {
        var content = '';
        if(cellvalue){
            content  += '<a href="tmp/mastergigistatus/' + cellvalue + '" style="color:blue;cursor:pointer" title="">download</a>';
        }else{
            content  += ' - ';
        }
        return content;
    }

    $('#mastergigistatusadd').click(function(){
        $("#t1003","#tabs").empty();
        $("#t1003","#tabs").load('c_master_gigi_status/add'+'?_=' + (new Date()).getTime());
    });

    $( "#namamastergigistatus" )
        .keypress(function(event) {
            var keycode =(event.keyCode?event.keyCode:event.which);
            if(keycode ==13){
                event.preventDefault();
                $('#listmastergigistatus').trigger("reloadGrid");
            }
        });

    jQuery.fn.reset = function (){
        $(this).each (function() { this.reset(); });
    }
    $("#resetmastergigistatus").live('click', function(event){
        event.preventDefault();
        $('#formmastergigistatus').reset();
        $('#listmastergigistatus').trigger("reloadGrid");
    });
    $("#carimastergigistatus").live('click', function(event){
        event.preventDefault();
        $('#listmastergigistatus').trigger("reloadGrid");
    });
})
