<?php
            
/**
 * Classe de visao para Movie
 * @author Jefferson Uchôa Ponte <j.pontee@gmail.com>
 *
 */

namespace getmovielist\view;
use getmovielist\model\Movie;


class MovieView {
    public function showInsertForm() {
		echo '
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary m-3" data-toggle="modal" data-target="#modalAddMovie">
  Adicionar
</button>

<!-- Modal -->
<div class="modal fade" id="modalAddMovie" tabindex="-1" role="dialog" aria-labelledby="labelAddMovie" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="labelAddMovie">Adicionar Movie</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <form id="insert_form_movie" class="user" method="post">
            <input type="hidden" name="enviar_movie" value="1">                



                                        <div class="form-group">
                                            <label for="original_title">Original Title</label>
                                            <input type="text" class="form-control"  name="original_title" id="original_title" placeholder="Original Title">
                                        </div>

                                        <div class="form-group">
                                            <label for="title">Title</label>
                                            <input type="text" class="form-control"  name="title" id="title" placeholder="Title">
                                        </div>

                                        <div class="form-group">
                                            <label for="release_date">Release Date</label>
                                            <input type="date" class="form-control"  name="release_date" id="release_date" placeholder="Release Date">
                                        </div>

                                        <div class="form-group">
                                            <label for="poster_path">Poster Path</label>
                                            <input type="text" class="form-control"  name="poster_path" id="poster_path" placeholder="Poster Path">
                                        </div>

						              </form>


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        <button form="insert_form_movie" type="submit" class="btn btn-primary">Cadastrar</button>
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
                  Lista Movie
                </div>
                <div class="card-body">
                                            
                                            
		<div class="table-responsive">
			<table class="table table-bordered" id="dataTable" width="100%"
				cellspacing="0">
				<thead>
					<tr>
						<th>Id</th>
						<th>Original Title</th>
						<th>Title</th>
						<th>Release Date</th>
                        <th>Actions</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
                        <th>Id</th>
                        <th>Original Title</th>
                        <th>Title</th>
                        <th>Release Date</th>
                        <th>Actions</th>
					</tr>
				</tfoot>
				<tbody>';
            
            foreach($lista as $element){
                echo '<tr>';
                echo '<td>'.$element->getId().'</td>';
                echo '<td>'.$element->getOriginalTitle().'</td>';
                echo '<td>'.$element->getTitle().'</td>';
                echo '<td>'.$element->getReleaseDate().'</td>';
                echo '<td>
                        <a href="?page=movie&select='.$element->getId().'" class="btn btn-info text-white">Select</a>
                        <a href="?page=movie&edit='.$element->getId().'" class="btn btn-success text-white">Edit</a>
                        <a href="?page=movie&delete='.$element->getId().'" class="btn btn-danger text-white">Delete</a>
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
            

            
	public function showEditForm(Movie $selecionado) {
		echo '
	    
	    

<div class="card o-hidden border-0 shadow-lg mb-4">
    <div class="card">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Edit Movie</h6>
        </div>
        <div class="card-body">
            <form class="user" method="post" id="edit_form_movie">
                                        <div class="form-group">
                                            <label for="original_title">Original Title</label>
                                            <input type="text" class="form-control" value="'.$selecionado->getOriginalTitle().'"  name="original_title" id="original_title" placeholder="Original Title">
                						</div>
                                        <div class="form-group">
                                            <label for="title">Title</label>
                                            <input type="text" class="form-control" value="'.$selecionado->getTitle().'"  name="title" id="title" placeholder="Title">
                						</div>
                                        <div class="form-group">
                                            <label for="release_date">Release Date</label>
                                            <input type="date" class="form-control" value="'.$selecionado->getReleaseDate().'"  name="release_date" id="release_date" placeholder="Release Date">
                						</div>
                                        <div class="form-group">
                                            <label for="poster_path">Poster Path</label>
                                            <input type="text" class="form-control" value="'.$selecionado->getPosterPath().'"  name="poster_path" id="poster_path" placeholder="Poster Path">
                						</div>
                <input type="hidden" value="1" name="edit_movie">
                </form>

        </div>
        <div class="modal-footer">
            <button form="edit_form_movie" type="submit" class="btn btn-primary">Cadastrar</button>
        </div>
    </div>
</div>

	    

										
						              ';
	}




            
        public function showSelected(Movie $movie){
            echo '
            
	<div class="card o-hidden border-0 shadow-lg">
        <div class="card">
            <div class="card-header">
                  Movie selecionado
            </div>
            <div class="card-body">
                Id: '.$movie->getId().'<br>
                Original Title: '.$movie->getOriginalTitle().'<br>
                Title: '.$movie->getTitle().'<br>
                Release Date: '.$movie->getReleaseDate().'<br>
                Poster Path: '.$movie->getPosterPath().'<br>
            
            </div>
        </div>
    </div>
            
            
';
    }


                                            
    public function confirmDelete(Movie $movie) {
		echo '
        
        
        
				<div class="card o-hidden border-0 shadow-lg">
					<div class="card-body p-0">
						<!-- Nested Row within Card Body -->
						<div class="row">
        
							<div class="col-lg-12">
								<div class="p-5">
									<div class="text-center">
										<h1 class="h4 text-gray-900 mb-4"> Delete Movie</h1>
									</div>
						              <form class="user" method="post">                    Are you sure you want to delete this object?

                                        <input type="submit" class="btn btn-primary btn-user btn-block" value="Delete" name="delete_movie">
                                        <hr>
                                            
						              </form>
                                            
								</div>
							</div>
						</div>
					</div>
                                            
                                            
                                            
                                            
	</div>';
	}
                      


}