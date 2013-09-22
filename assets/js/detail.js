function ajaxModal(name, type) {
	xx = true;
        $('.modal-body').load("detail/"+type+".php?name="+name);
	$('.modal-title').html(name);
	$('.modal-body').scrollTop(0);
	$('.modal-body').focus();
	setTimeout(function() {
		xx=false;
	}, 1000);
}