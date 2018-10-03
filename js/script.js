function delay(){
	window_size = $(window).height();
	$('section.head').css("height",window_size);
}

function showPage(){
	document.getElementById('body').style.display = "block";
	window.dispatchEvent(new Event('resize'));
}


var header = document.getElementById('header');
var position_header_before = 30;

function sticky_head(){
	if (window.pageYOffset >= position_header_before){
		header.classList.add('fixed-top');
	}

	else{
		header.classList.remove('fixed-top');
	}
}

$('.s5_tabs > #pills-tab > li.nav-item').click(function(){
	$('#pills-tab > li').removeClass('active_tab');
	$(this).addClass('active_tab');
});

