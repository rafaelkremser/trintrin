$(document).ready(function(){
    $('.btn-menu').on('click', function(){
        toggleMenu($('nav'));
    });
    $('nav').before().on('click', function(){
        toggleMenu($('nav'));
    });
    
    function toggleMenu(menu) {
        menu.toggleClass('active');
    }


    $('nav ul li a').on('click', function(e) {
        e.preventDefault();
        var id = $(this).attr('href'),
        targetOffset = $('.'+id).offset().top;

        $('html, body').animate({
            scrollTop: targetOffset - 100
        }, 500);
    });


    $('body.admin header .container .left .bx-menu').on('click', function(){
        toggleMenuAdmin($('aside'));
        toggleBodyAdmin($('body.admin'));
    });
    
    function toggleMenuAdmin(menuAdmin) {
        menuAdmin.toggleClass('active');
    }
    function toggleBodyAdmin(bodyAdmin) {
        bodyAdmin.toggleClass('active');
    }
    $('body.admin header aside .aside-content .admin-logo .bx').on('click', function(){
        toggleMenuAdmin($('aside'));
    });
    $('.admin-shadow').on('click', function(){
        toggleMenuAdmin($('aside'));
    });
    
    function toggleMenuAdmin(menuAdmin) {
        menuAdmin.toggleClass('active');
    }

    
    // Função excluir imagem - admin
    $('input[name="excluir_imagem_principal"]').on('click', function() {
        if ($(this).is(':checked')) {
            $('input[name="imagem_principal"]').attr('required', 'required');
        } else {
            $('input[name="imagem_principal"]').attr('required', false);
        }
    });

    // Função excluir imagem - usuário
    $('input[name="excluir_foto_usuario"]').on('click', function() {
        if ($(this).is(':checked')) {
            $('input[name="foto_usuario"]').attr('required', 'required');
        } else {
            $('input[name="foto_usuario"]').attr('required', false);
        }
    });

    // Form ajax - usuário

    if ($('form.form_ajax').length) {
	    if (!jQuery().ajaxForm)
	    	return;
	    $('form.form_ajax').on("submit", function(e) {
	    	e.preventDefault();
	    	var form = $(this);
	    	var alerta = form.children('.alerta');
	    	form.ajaxSubmit({
	    		dataType:'json'
	    		,success: function(response) {
	    			if (response.msg){
	    				alerta.html(response.msg);
	    			}
	    			if (response.status != '0') {
	    				alerta.addClass('sucesso');
	    			} else {
	    				alerta.addClass('erro');
	    			}
	    			if (response.redirecionar_pagina){
	    				window.location = response.redirecionar_pagina;
	    			}
	    			if (response.resetar_form){
	    				form[0].reset();
	    			}
	    			setTimeout(
	    				function(){ 
	    					alerta.html("");
	    					alerta.removeClass('sucesso');
	    					alerta.removeClass('erro');
	    				}, 
	    			8000);
	    		}
	    	});
	    	return false;
	    });
    }

});




// modo escuro no dashboard
function lightmode() {
    var bgLight = document.body;
    bgLight.classList.toggle("body-light");
}

const handlePhone = (event) => {
    let input = event.target
    input.value = phoneMask(input.value)
  }
  
  const phoneMask = (value) => {
    if (!value) return ""
    value = value.replace(/\D/g,'')
    value = value.replace(/(\d{2})(\d)/,"($1) $2")
    value = value.replace(/(\d)(\d{4})$/,"$1-$2")
    return value
}