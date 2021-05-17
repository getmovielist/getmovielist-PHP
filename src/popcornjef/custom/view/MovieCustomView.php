<?php
            
/**
 * Classe de visao para Movie
 * @author Jefferson Uchôa Ponte <j.pontee@gmail.com>
 *
 */

namespace popcornjef\custom\view;
use popcornjef\view\MovieView;
use popcornjef\model\Movie;


class MovieCustomView extends MovieView {

    ////////Digite seu código customizado aqui.

    public function showInsertForm2(Movie $movie)
    {
        echo '

                 
      <!-- Modal -->
      <div class="modal fade" id="modalFavoritar" tabindex="-1" aria-labelledby="modalFavoritarLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="modalFavoritarLabel">Adicionar Favorito</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              Adicionar este filme aos favoritos?

                <form id="insert_form_movie_id" class="user" method="post">
                            <input type="hidden" name="enviar_movie" value="1">                
                    <input type="hidden" name="id" value="'.$movie->getId().'">
                       
                    <div class="form-group">
                        <label for="movie_file_path">Movie File Path</label>
                        <input type="file" class="form-control pegarAnexo"  name="movie_file_path" id="movie_file_path" placeholder="Movie File Path">
                    </div>

                    <div class="form-group">
                        <label for="torrent_link">Torrent Link</label>
                        <input type="text" class="form-control"  name="torrent_link" id="torrent_link" placeholder="Torrent Link">
                    </div>

                    <div class="form-group">
                        <label for="subtitle_br_path">Subtitle Br Path</label>
                        <input type="file" class="form-control pegarAnexo"  name="subtitle_br_path" id="subtitle_br_path" placeholder="Subtitle Br Path">
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