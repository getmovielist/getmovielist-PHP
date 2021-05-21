<?php
            
/**
 * Classe de visao para TorrentMovie
 * @author Jefferson Uchôa Ponte <j.pontee@gmail.com>
 *
 */

namespace getmovielist\custom\view;
use getmovielist\view\TorrentMovieView;


class TorrentMovieCustomView extends TorrentMovieView {

    ////////Digite seu código customizado aqui.
    public function showInsertForm($listaMovieFile) {
        
        
        echo '

<button  class="float-right btn ml-3 btn-outline-light btn-circle btn-lg text-white" data-bs-toggle="modal" data-bs-target="#modalAddTorrentMovie"><i class="fa fa-magnet icone-maior"></i></button>


<!-- Modal -->
<div class="modal fade text-dark" id="modalAddTorrentMovie" tabindex="-1" aria-labelledby="modalAddTorrentMovieLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalAddTorrentMovieLabel">Modal title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
  




          <form id="insert_form_torrent_movie" class="user" method="post">
            <input type="hidden" name="enviar_torrent_movie" value="1">
            
            
            
                                        <div class="form-group">
                                            <label for="link">Link</label>
                                            <input type="text" class="form-control"  name="link" id="link" placeholder="Link">
                                        </div>
                                        <div class="form-group">
                                          <label for="movie_file">Movie File</label>
                						  <select class="form-control" id="movie_file" name="movie_file">
                                            <option value="">Selecione o Movie File</option>';
        
        foreach( $listaMovieFile as $element){
            echo '<option value="'.$element->getId().'">'.$element.'</option>';
        }
        
        echo '
                                          </select>
                						</div>
            
						              </form>



      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
        <button form="insert_form_torrent_movie" type="submit" class="btn btn-primary">Cadastrar</button>
      </div>
    </div>
  </div>
</div>
            
            
';
    }

}