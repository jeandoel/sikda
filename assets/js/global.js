function mydate(){

	var m = "am";
	var gd = new Date();
	var secs = gd.getSeconds();
	var minutes = gd.getMinutes();
	var hours = gd.getHours();
	var day = gd.getDay();
	var month = gd.getMonth();
	var date = gd.getDate();
	var year = gd.getYear();

	if(year<1000){
	year += 1900;
	}
	if(hours==0){
	hours = 12;
	}
	if(hours>12){
	hours = hours - 12;
	m = "pm";
	}
	if(secs<10){
	secs = "0"+secs;
	}
	if(minutes<10){
	minutes = "0"+minutes;
	}

	var dayarray = new Array ("Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu");
	var montharray = new Array ("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");

	var fulldate = dayarray[day]+", "+date+" "+montharray[month]+" "+year+" - "+hours+":"+minutes+":"+secs+" "+m;

	$("#date").html(fulldate);

	setTimeout("mydate()", 1000);

}
mydate();

function al(val){
	alert(val);
}
function cl(val){
	console.log(val);
}