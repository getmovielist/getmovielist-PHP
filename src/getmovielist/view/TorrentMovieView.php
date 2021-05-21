<?php
            
/**
 * Classe de visao para TorrentMovie
 * @author Jefferson Uchôa Ponte <j.pontee@gmail.com>
 *
 */

namespace getmovielist\view;
use getmovielist\model\TorrentMovie;


class TorrentMovieView {
    public function showInsertForm($listaMovieFile) {
        
        //echo '<a href="./?teste" class="float-right btn ml-3 btn-outline-light btn-circle btn-lg text-white"><i class="fa fa-magnet icone-maior"></i></a>';
		echo '
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary m-3" data-toggle="modal" data-target="#modalAddTorrentMovie">
  Adicionar
</button>

<!-- Modal -->
<div class="modal fade" id="modalAddTorrentMovie" tabindex="-1" role="dialog" aria-labelledby="labelAddTorrentMovie" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="labelAddTorrentMovie">Adicionar Torrent Movie</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
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
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        <button form="insert_form_torrent_movie" type="submit" class="btn btn-primary">Cadastrar</button>
      </div>
    </div>
  </div>
</div>
            
            
			
';
	}



                                            
                                            
    public function showList($lista){
           echo '
                                            
                                            
                                            

          <div class="card">
                <div class="card-header">
                  Lista Torrent Movie
                </div>
                <div class="card-body">
                                            
                                            
		<div class="table-responsive">
			<table class="table table-bordered" id="dataTable" width="100%"
				cellspacing="0">
				<thead>
					<tr>
						<th>Id</th>
						<th>Link</th>
						<th>Movie File</th>
                        <th>Actions</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
                        <th>Id</th>
                        <th>Link</th>
						<th>Movie File</th>
                        <th>Actions</th>
					</tr>
				</tfoot>
				<tbody>';
            
            foreach($lista as $element){
                echo '<tr>';
                echo '<td>'.$element->getId().'</td>';
                echo '<td>'.$element->getLink().'</td>';
                echo '<td>'.$element->getMovieFile().'</td>';
                echo '<td>
                        <a href="?page=torrent_movie&select='.$element->getId().'" class="btn btn-info text-white">Select</a>
                        <a href="?page=torrent_movie&edit='.$element->getId().'" class="btn btn-success text-white">Edit</a>
                        <a href="?page=torrent_movie&delete='.$element->getId().'" class="btn btn-danger text-white">Delete</a>
                      </td>';
                echo '</tr>';
            }
            
        echo '
				</tbody>
			</table>
		</div>
            
            
            
            
  </div>
</div>
            
';
    }
            

            
	public function showEditForm($listaMovieFile, TorrentMovie $selecionado) {
		echo '
	    
	    

<div class="card o-hidden border-0 shadow-lg mb-4">
    <div class="card">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Edit Torrent Movie</h6>
        </div>
        <div class="card-body">
            <form class="user" method="post" id="edit_form_torrent_movie">
                                        <div class="form-group">
                                            <label for="link">Link</label>
                                            <input type="text" class="form-control" value="'.$selecionado->getLink().'"  name="link" id="link" placeholder="Link">
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
                <input type="hidden" value="1" name="edit_torrent_movie">
                </form>

        </div>
        <div class="modal-footer">
            <button form="edit_form_torrent_movie" type="submit" class="btn btn-primary">Cadastrar</button>
        </div>
    </div>
</div>

	    

										
						              ';
	}




            
        public function showSelected(TorrentMovie $torrentmovie){
            echo '
            
	<div class="card o-hidden border-0 shadow-lg">
        <div class="card">
            <div class="card-header">
                  Torrent Movie selecionado
            </div>
            <div class="card-body">
                Id: '.$torrentmovie->getId().'<br>
                Link: '.$torrentmovie->getLink().'<br>
                Movie File: '.$torrentmovie->getMovieFile().'<br>
            
            </div>
        </div>
    </div>
            
            
';
    }


                                            
    public function confirmDelete(TorrentMovie $torrentMovie) {
		echo '
        
        
        
				<div class="card o-hidden border-0 shadow-lg">
					<div class="card-body p-0">
						<!-- Nested Row within Card Body -->
						<div class="row">
        
							<div class="col-lg-12">
								<div class="p-5">
									<div class="text-center">
										<h1 class="h4 text-gray-900 mb-4"> Delete Torrent Movie</h1>
									</div>
						              <form class="user" method="post">                    Are you sure you want to delete this object?

                                        <input type="submit" class="btn btn-primary btn-user btn-block" value="Delete" name="delete_torrent_movie">
                                        <hr>
                                            
						              </form>
                                            
								</div>
							</div>
						</div>
					</div>
                                            
                                            
                                            
                                            
	</div>';
	}
                      


}