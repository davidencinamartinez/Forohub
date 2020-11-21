
function showPassword(element) {
	if ($(element).attr('show') == 'on') {
		$(element).attr({
			src: 'storage/src/other/hide.png',
			show: 'off'
		});
		$(element).prev('input').attr('type', 'text');
	} else {
		$(element).attr({
			src: 'storage/src/other/show.png',
			show: 'on'
		});
		$(element).prev('input').attr('type', 'password');
	}
}

function formValidation() {
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});    
        event.preventDefault();
        $.ajax({
            url: 'registro',
            type: 'POST',
            data: { _token: $('input[name="_token"]').val(),
                    reg_username: $('input[name="reg_username"]').val(),
                    reg_email: $('input[name="reg_email"]').val(),
                    reg_password: $('input[name="reg_password"]').val(),
                    reg_passwordVerified: $('input[name="reg_passwordVerified"]').val(),
                    reg_captcha: grecaptcha.getResponse(),
                    reg_terms: $('input[name="reg_terms"]').is(':checked')

        },
        })
        .done(function(data) {
        	if ($.isEmptyObject(data.error)) {
        		$('#registerPanel').empty();
	        	var successPanel = $('<div></div>').attr('id', 'successPanel').css('background-color', 'value');
	            var successImg = $('<img>').attr({
	            	id: 'successImg',
	            	src: 'storage/src/other/reg_done.png'
	            });
	            var successText = 	'<b>Bienvenido a TuForo.Net</b>!'+
	            					'<br />Disfruta de tu estancia!'+
	            					'<a id="successLink" href="/"><h3>Haz click aquí para volver al inicio</h3></a>';
				successPanel.html('<img id="successImg" src="storage/src/other/reg_done.png"><br><br>'+successText);
				$('#registerPanel').append(successPanel);
        	} else {
        		$('.error').remove();
        	    $.each( data.error, function( key, value ) {
        	    	if (key == 'reg_username') {
        	    		errorDisplay($('input[name="reg_username"]'), value[0]);
        	    	}
        	    	if (key == 'reg_email') {
						errorDisplay($('input[name="reg_email"]'), value[0]);
        	    	}
        	    	if (key == 'reg_password') {
        	    		errorDisplay($('input[name="reg_password"]'), value[0]);
        	    	}
        	    	if (key == 'reg_passwordVerified') {
        	    		errorDisplay($('input[name="reg_passwordVerified"]'), value[0]);
        	    	}
        	    	if (key == 'reg_captcha') {
        	    		errorDisplay($('.g-recaptcha'), value[0]);
        	    	}
        	    	if (key == 'reg_terms') {
        	    			errorDisplay($('#PTerms'), value[0]);
        	    	}
            	});
        	}
        })
        .fail(function(e) {
        	alert('Estamos teniendo problemas con el servidor.\nInténtalo de nuevo más tarde ...');
        })
}