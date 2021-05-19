

$(document).ready(function(e) {
	$("#insert_form_subtitle").on('submit', function(e) {
		e.preventDefault();
        $('#modalAddSubtitle').modal('hide');
        
		var dados = jQuery( this ).serialize();
        
		jQuery.ajax({
            type: "POST",
            url: "index.php?ajax=subtitle",
            data: dados,
            success: function( data )
            {
            


            	if(data.split(":")[1] == 'sucesso'){
            		
            		$("#botao-modal-resposta").click(function(){
            			window.location.href='?page=subtitle';
            		});
            		$("#textoModalResposta").text("Subtitle enviado com sucesso! ");                	
            		$("#modalResposta").modal("show");
            		
            	}
            	else
            	{
            		
                	$("#textoModalResposta").text("Falha ao inserir Subtitle, fale com o suporte. ");                	
            		$("#modalResposta").modal("show");
            	}

            }
        });
		
		
	});
	
	
});
   
