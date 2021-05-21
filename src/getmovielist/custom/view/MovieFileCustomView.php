<?php
            
/**
 * Classe de visao para MovieFile
 * @author Jefferson Uchôa Ponte <j.pontee@gmail.com>
 *
 */

namespace getmovielist\custom\view;
use getmovielist\view\MovieFileView;
use getmovielist\model\Movie;


class MovieFileCustomView extends MovieFileView {

    public function showInsertForm2(Movie $movie) {
        echo '


<button class="float-right btn ml-3 btn-outline-light btn-circle btn-lg text-white" data-bs-toggle="modal" data-bs-target="#modalAddMovieFile"><i class="fa fa-film icone-maior"></i></button>

<!-- Modal -->
<div class="modal fade text-dark" id="modalAddMovieFile" tabindex="-1" aria-labelledby="modalAddMovieFileLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalAddMovieFileLabel">Modal title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="insert_form_movie_file" class="user" method="post">
            <input type="hidden" name="enviar_movie_file" value="1">

            <div class="form-group">
                <label for="file_path">File Path</label>
                <input type="file" class="form-control"  name="file_path" id="file_path" placeholder="File Path">
            </div>
            
              
    		  <input type="hidden" name="movie" value="'.$movie->getId().'">
          </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
        <button form="insert_form_movie_file" type="submit" class="btn btn-primary">Cadastrar</button>
      </div>
    </div>
  </div>
</div>';
    }
    


}