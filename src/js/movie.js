

$(document).ready(function(e) {
	$( "#botao-like" ).click(function() {
        $('#botao-like').attr('disabled', true);	
		var idMovie = $(this).attr('href');
		var dados = {
  			'id': idMovie
		};
		jQuery.ajax({
            type: "POST",
            url: "index.php?ajax=click_like",
            data: dados,
            success: function( data )
            {
				if(data == 'sucess'){
					$("#botao-like").addClass("escondido");
					$("#botao-unlike").removeClass("escondido");
				}
				
				
            }
        });
        $('#botao-like').attr('disabled', false);
		
	});
	$( "#botao-unlike" ).click(function() {
        $('#botao-unlike').attr('disabled', true);	
		var idMovie = $(this).attr('href');
		var dados = {
  			'id': idMovie
		};
		jQuery.ajax({
            type: "POST",
            url: "index.php?ajax=click_unlike",
            data: dados,
            success: function( data )
            {
				if(data == 'sucess'){
					$("#botao-like").removeClass("escondido");
					$("#botao-unlike").addClass("escondido");
				}
				
            }
        });
        $('#botao-unlike').attr('disabled', false);	
		
	});

	$("#insert_form_movie").on('submit', function(e) {
		e.preventDefault();
        $('#modalAddMovie').modal('hide');
        
		var dados = jQuery( this ).serialize();
        
		jQuery.ajax({
            type: "POST",
            url: "index.php?ajax=movie",
            data: dados,
            success: function( data )
            {
            

            	if(data.split(":")[1] == 'sucesso'){
            		
            		$("#botao-modal-resposta").click(function(){
            			window.location.href='?page=movie';
            		});
            		$("#textoModalResposta").text("Movie enviado com sucesso! ");                	
            		$("#modalResposta").modal("show");
            		
            	}
            	else
            	{
            		
                	$("#textoModalResposta").text("Falha ao inserir Movie, fale com o suporte. ");                	
            		$("#modalResposta").modal("show");
            	}

            }
        });
		
		
	});
	
	
});
   
