<?php
            
/**
 * Classe de visao para Subtitle
 * @author Jefferson Uchôa Ponte <j.pontee@gmail.com>
 *
 */

namespace getmovielist\custom\view;
use getmovielist\view\SubtitleView;
use getmovielist\model\Movie;


class SubtitleCustomView extends SubtitleView {

    public function showInsertForm2(Movie $movie) {
        echo '


<!-- Modal -->
<div class="modal fade" id="modalAddSubtitle" tabindex="-1" aria-labelledby="modalAddSubtitleLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-dark" id="modalAddSubtitleLabel">Add Subtitle</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
         <form id="insert_form_subtitle" class="user" method="post">
            <input type="hidden" name="enviar_subtitle" value="1">
            
            
            
            <div class="form-group">
                <label for="label">Label</label>
                <input type="text" class="form-control"  name="label" id="label" placeholder="Label">
            </div>

            <div class="form-group">
                <label for="file_path">File Path</label>
                <input type="file" class="form-control pegarAnexo" name="file_path" id="file_path" placeholder="File Path" value="">
            </div>
            
		  <input id="movie" type="hidden"name="movie" value="'.$movie->getId().'">            
          </form>



      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
        <button form="insert_form_subtitle" type="submit" class="btn btn-primary">Cadastrar</button>         
      </div>
    </div>
  </div>
</div>


         
       
            
            
';
    }
}