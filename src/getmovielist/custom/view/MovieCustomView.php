<?php
            
/**
 * Classe de visao para Movie
 * @author Jefferson Uchôa Ponte <j.pontee@gmail.com>
 *
 */

namespace getmovielist\custom\view;
use getmovielist\view\MovieView;
use getmovielist\model\Movie;


class MovieCustomView extends MovieView {

    ////////Digite seu código customizado aqui.

    public function showEditForm(Movie $movie)
    {
        echo '

                 
      <!-- Modal -->
      <div class="modal fade" id="modalEditar" tabindex="-1" aria-labelledby="modalEditarLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="modalEditarLabel">Selecionar URL do Filme</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              

                <form id="insert_form_movie_id" class="user" method="post">
                            <input type="hidden" name="edit_movie" value="1">                
                    <input type="hidden" name="id" value="'.$movie->getId().'">
                       
                    <div class="form-group">
                        <label for="movie_file_path">Movie File Path</label>
                        <input type="file" class="form-control pegarAnexo"  name="movie_file_path" id="movie_file_path" placeholder="Movie File Path" value="'.$movie->getMovieFilePath().'">
                    </div>

                
	              </form>

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
               
              <button form="insert_form_movie_id" type="submit" class="btn btn-primary">Confirmar</button>
            </div>
          </div>
        </div>
      </div>
               

';
    }

}