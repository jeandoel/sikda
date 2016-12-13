var achtungloader = '';

function achtungCreate(message, sticky) {
    var timeout = (true == sticky) ? 0 : 5;
    achtungBox = $.achtung({message: message, timeout: timeout});
    return achtungBox;
}

function achtungClose(achtungBox) {
    achtungbox.achtung('close');
}

function achtungShowLoader() {
    var loader = '<img src="assets/achtung/ajax-loader.gif" /><p style="color:#FFF!important">Data sedang di Proses, Silahkan tunggu.</p>';
    achtungLoader = achtungCreate(loader, true);
}

function achtungShowLoaderLoad() {
    var loader = '<img src="assets/achtung/ajax-loader.gif" /><p style="color:#FFF!important">Loading Halaman</p>';
    achtungLoader = achtungCreate(loader, true);
}

function achtungHideLoader() {
    achtungLoader.achtung('close');
}

function achtungDestroy(){
	if( $("#achtung-overlay").size() != 0 ) $("#achtung-overlay").remove();  
}
