//achtungShowLoaderLoad();
$(document).ready(function () {
	//$('body').layout({ applyDefaultStyles: true });
	// create page layout
	
		pageLayout = $('body').layout({
			scrollToBookmarkOnLoad:		false // handled by custom code so can 'unhide' section first
		,	defaults: {
			}
		,	north: {
				size:					"auto"
			//,	spacing_closed:			7
			//,	spacing_open:			5
			,	closable:				true
			,	resizable:				false
			}
		,	south: {
				size:					"auto"
			,	closable:				false
			,	resizable:				false
			}
		,	west: {
				size:					250
			,	spacing_closed:			17
			,	togglerLength_closed:	140
			,	togglerAlign_closed:	"midle"
			,	togglerContent_closed:	"M</br>e</br>n</br>u"
			,	togglerTip_closed:		"Buka Submenu"
			,	sliderTip:				"Submenu"
			,	slideTrigger_open:		"click"
			}
		});
	$("#browser").treeview();
	var maintab =jQuery('#tabs','.ui-layout-center').tabs({
		ajaxOptions: {
        cache: false,		
        error: function (xhr, status, index, anchor) {
            /*$(anchor.hash).html(
			  "Couldn't load this tab. We'll try to fix this as soon as possible. " +
			  "If this wouldn't be a demo.");*/
			  //achtungHideLoader();
			  //$.achtung({message: xhr.responseText, timeout:5});			  
			}
		},
        add: function(e, ui) {
			//achtungShowLoaderLoad();
            // append close thingy
            $(ui.tab).parents('li:first')
                .append('<span class="ui-tabs-close ui-icon ui-icon-close" title="Close Tab"></span>')
                .find('span.ui-tabs-close')
                .click(function() {
                    $('#' + ui.panel.id,maintab).empty();
					maintab.tabs('remove', $('li', maintab).index($(this).parents('li:first')[0]));
					$("#west-grid #"+ui.panel.id.replace('t','')).find('.cell-wrapperleaf').css({'color':'#222222','font-weight':'normal'});
                });
            // select just added tab
            maintab.tabs('select', '#' + ui.panel.id);
        }
    });
    
	$("#west-grid").jqGrid({
		treeGrid: true,
		treeGridModel: 'adjacency',
		ExpandColumn: 'menu',
		ExpandColClick: true,
		url: 'dashboard/menu',
		datatype: 'xml',
		mtype: 'POST',
		height: "auto",
		autowidth: true,
		rowNum: 200,
		loadui: "disable",
		pager: "#ptreegrid",
		treeIcons: {leaf:'ui-icon-document-b'},
		colNames: ["id", "menu", "url"],
		colModel: [{ name: 'id', index: 'id', width: 120,  hidden: true, key: true }, 
					{ name: 'menu', index: 'menu', width: 120, hidden: false, sortable: false }, 
					{ name: 'url', width: 120, hidden: true }], 
		onSelectRow: function(rowid) {
			$(this).parent().find('.cell-wrapperleaf').css({'color':'#222222','font-weight':'normal'});
			$("#west-grid #"+rowid).find('.cell-wrapperleaf').css({'color':'#4682B4','font-weight':'bold'});
			var treedata = $("#west-grid").jqGrid('getRowData',rowid);
			if(treedata.isLeaf=="true") {
				//treedata.url
				var st = "#t"+treedata.id;
				if($(st).html() != null ) {
					maintab.tabs('select',st);
				} else {
					//comment this block if i want to have tabs
					var active = maintab.tabs("option", "active");
					if($("#tabs ul>li a").eq(active).attr('href') !=='#tabs-1'){
						$($("#tabs ul>li a").eq(active).attr('href'),"#tabs").empty();
					}
					maintab.tabs('remove', 1);
					// end multiple tabs
					
					//maintab.tabs( "refresh" );
					maintab.tabs('add',st, treedata.menu);
					$(st,"#tabs").empty();
					$(st,"#tabs").load(treedata.url+'?_=' + (new Date()).getTime());
				}
			}
		}
    });
	$(".ui-jqgrid-hdiv").hide();
});