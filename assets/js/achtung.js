var popUpWidth = 800;
var popUpHeight = 600;

var leftPos = Math.round(screen.width / 2) - Math.round(popUpWidth / 2);
var topPos =  Math.round(screen.height / 2) - Math.round(popUpHeight / 2);
var div = '#inject';

// timeout is in miliseconds
$.ajaxSetup({
	type:'GET',
	timeout:60000,
	dataType:'html',
	error: function(xhr) {
			$(div).html("Error:"+xhr.status+' '+xhr.statusText);
	}
});

function showPage(site){
	$.ajax({
		url:site,
		/*beforeSend: function(){
			$(div).hide('fast');	
		},*/
		success: function(response){
			//$(div).show('fast');
			$(div).html(response);
  		}
	});
}

function setActiveTab()
{
	$('#satu').addClass('active');
	$('#dua').removeClass('active');
	$('#tiga').removeClass('active');
}

$("#loader").ajaxStart(function(){$(this).show();}).ajaxComplete(function(){$(this).hide();});

function popup(url)
{
	window.open(url,'Win1','toolbar=0,location=0,directories=0,status=0,scrollbars=1,menubar=0,copyhistory=0,width='+popUpWidth+',height='+popUpHeight+',left='+leftPos+',top='+topPos);
}

function newCaptcha(URI,elm)
{
	var element = document.getElementById(elm);
	$.post(URI,{},function(data){
		$(element).html(data);
	});
}

function ajaxLoader(show)
{
	if (show=='show'){
		$('#loader').modal({
			overlayId:'loader-overlay',
			containerId:'loader-container',
			escClose: false
		});
	}
}

function postFunct(URL)
{
	var val = new Array();
	var i=1;
	var index=7;
	val[0] = document.frmApps1.txtMail.value;
	val[1] = document.frmApps1.txtPass1.value;
	val[2] = document.frmApps1.txtName.value;

	if (document.frmApps1.chk1.checked==true) val[3] = document.frmApps1.chk1.value; else val[3]='';
	if (document.frmApps1.chk2.checked==true) val[4] = document.frmApps1.chk2.value; else val[4]='';
	if (document.frmApps1.chk3.checked==true) val[5] = document.frmApps1.chk3.value; else val[5]='';
	if (document.frmApps1.chk4.checked==true) val[6] = document.frmApps1.chk4.value; else val[6]='';

	while (i<=document.frmApps1.counter.value){
		try {
			if ($('#txtOther'+i).val()!="other job" || $('#txtOther'+i).val()!=null)
			{
				val[index] = $('#txtOther'+i).val();
			}			
			i++;
			index++;		
		}
		catch (err) {
			break;
		}
	}
	
	val[index] = document.frmApps1.txtDesc.value;

	$.post(URL,{'fld[]':val},function (data) {
		switch (data)
		{
			case '1':
				$('#errPanel1').html('wrong mail format!!!');
				break;
			case '2':
				$('#errPanel2').html('password didn\'t match!!!');
				break;
		}
	});
}

function modalPopup(elm)
{
	$(elm).modal({
		overlayId:'ModalContent-overlay',
		containerId:'ModalContent-container',
		escClose: false
	});
}

function initVideo()
{
	$f("player", "player/flowplayer-3.2.4.swf",{
		clip: {
			autoPlay: false,
			autoBuffering: true
		},

		plugins: {
			controls: "player/flowplayer.controls-3.2.0.swf"
		}	
	});
}

function anchorPopup(url,width,height)
{
	var leftPos = Math.round(screen.width / 2) - Math.round(width / 2);
	var topPos =  Math.round(screen.height / 2) - Math.round(height / 2);
	window.open(url,'Win1','toolbar=0,location=0,directories=0,status=0,scrollbars=1,menubar=0,copyhistory=0,width='+width+',height='+height+',left='+leftPos+',top='+topPos);
}

function blockpopup(targeturl)
{
	$.ajax({
		type:"GET",
		url:targeturl,
		dataType:"html",
		cache:false,
		success:function(fr){
			$('#injectme').empty();
			$('#injectme').html(fr);
			$('#nike').modal();
		}
	});
}

jQuery.fn.ForceNumericOnly = function() {
    return this.each(function()
    {
        $(this).keydown(function(e)
        {
            var key = e.charCode || e.keyCode || 0;
            // allow backspace, tab, delete, arrows, numbers and keypad numbers ONLY
            return (
                key == 8 || 
                key == 9 ||
                key == 46 ||
                (key >= 37 && key <= 40) ||
                (key >= 48 && key <= 57) ||
                (key >= 96 && key <= 105));
        });
    });
};

function getVal(){
	var rdobj = document.forms[0].chk;
	var val='';
	for(i=0; i<rdobj.length; i++){
		if (rdobj[i].checked) {
			val = rdobj[i].value; 
		}
	}

	window.opener.GetValueFromChild(val);
	window.close();
	return false;
}