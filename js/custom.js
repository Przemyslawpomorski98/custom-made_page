var czas_opoznienia;
function delay(){
	if( $(document).ready() ){
	czas_opoznienia = setTimeout(showPage, 2000);
	}
}

function showPage(){
	document.getElementById('preloader').style.display = "none";
	document.getElementById('body').style.display = "block";