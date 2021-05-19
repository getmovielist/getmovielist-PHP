<?php
            
/**
 * Classe de visao para FavoriteList
 * @author Jefferson Uchôa Ponte <j.pontee@gmail.com>
 *
 */

namespace getmovielist\view;
use getmovielist\model\FavoriteList;


class FavoriteListView {
    public function showInsertForm($listaAppUser, $listaMovie) {
		echo '
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary m-3" data-toggle="modal" data-target="#modalAddFavoriteList">
  Adicionar
</button>

<!-- Modal -->
<div class="modal fade" id="modalAddFavoriteList" tabindex="-1" role="dialog" aria-labelledby="labelAddFavoriteList" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="labelAddFavoriteList">Adicionar Favorite List</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <form id="insert_form_favorite_list" class="user" method="post">
            <input type="hidden" name="enviar_favorite_list" value="1">                


                                        <div class="form-group">
                                          <label for="app_user">App User</label>
                						  <select class="form-control" id="app_user" name="app_user">
                                            <option value="">Selecione o App User</option>';
                                                
        foreach( $listaAppUser as $element){
            echo '<option value="'.$element->getId().'">'.$element.'</option>';
        }
            
        echo '
                                          </select>
                						</div>
                                        <div class="form-group">
                                          <label for="movie">Movie</label>
                						  <select class="form-control" id="movie" name="movie">
                                            <option value="">Selecione o Movie</option>';
                                                
        foreach( $listaMovie as $element){
            echo '<option value="'.$element->getId().'">'.$element.'</option>';
        }
            
        echo '
                                          </select>
                						</div>

						              </form>


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        <button form="insert_form_favorite_list" type="submit" class="btn btn-primary">Cadastrar</button>
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
                  Lista Favorite List
                </div>
                <div class="card-body">
                                            
                                            
		<div class="table-responsive">
			<table class="table table-bordered" id="dataTable" width="100%"
				cellspacing="0">
				<thead>
					<tr>
						<th>Id</th>
						<th>App User</th>
						<th>Movie</th>
                        <th>Actions</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
                        <th>Id</th>
						<th>App User</th>
						<th>Movie</th>
                        <th>Actions</th>
					</tr>
				</tfoot>
				<tbody>';
            
            foreach($lista as $element){
                echo '<tr>';
                echo '<td>'.$element->getId().'</td>';
                echo '<td>'.$element->getAppUser().'</td>';
                echo '<td>'.$element->getMovie().'</td>';
                echo '<td>
                        <a href="?page=favorite_list&select='.$element->getId().'" class="btn btn-info text-white">Select</a>
                        <a href="?page=favorite_list&edit='.$element->getId().'" class="btn btn-success text-white">Edit</a>
                        <a href="?page=favorite_list&delete='.$element->getId().'" class="btn btn-danger text-white">Delete</a>
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
            

            
	public function showEditForm($listaAppUser, $listaMovie, FavoriteList $selecionado) {
		echo '
	    
	    

<div class="card o-hidden border-0 shadow-lg mb-4">
    <div class="card">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Edit Favorite List</h6>
        </div>
        <div class="card-body">
            <form class="user" method="post" id="edit_form_favorite_list">
                                        <div class="form-group">
                                          <label for="app_user">App User</label>
                						  <select class="form-control" id="app_user" name="app_user">
                                            <option value="">Selecione o App User</option>';
                                                
        foreach( $listaAppUser as $element){
            echo '<option value="'.$element->getId().'">'.$element.'</option>';
        }
            
        echo '
                                          </select>
                						</div>
                                        <div class="form-group">
                                          <label for="movie">Movie</label>
                						  <select class="form-control" id="movie" name="movie">
                                            <option value="">Selecione o Movie</option>';
                                                
        foreach( $listaMovie as $element){
            echo '<option value="'.$element->getId().'">'.$element.'</option>';
        }
            
        echo '
                                          </select>
                						</div>
                <input type="hidden" value="1" name="edit_favorite_list">
                </form>

        </div>
        <div class="modal-footer">
            <button form="edit_form_favorite_list" type="submit" class="btn btn-primary">Cadastrar</button>
        </div>
    </div>
</div>

	    

										
						              ';
	}




            
        public function showSelected(FavoriteList $favoritelist){
            echo '
            
	<div class="card o-hidden border-0 shadow-lg">
        <div class="card">
            <div class="card-header">
                  Favorite List selecionado
            </div>
            <div class="card-body">
                Id: '.$favoritelist->getId().'<br>
                App User: '.$favoritelist->getAppUser().'<br>
                Movie: '.$favoritelist->getMovie().'<br>
            
            </div>
        </div>
    </div>
            
            
';
    }


                                            
    public function confirmDelete(FavoriteList $favoriteList) {
		echo '
        
        
        
				<div class="card o-hidden border-0 shadow-lg">
					<div class="card-body p-0">
						<!-- Nested Row within Card Body -->
						<div class="row">
        
							<div class="col-lg-12">
								<div class="p-5">
									<div class="text-center">
										<h1 class="h4 text-gray-900 mb-4"> Delete Favorite List</h1>
									</div>
						              <form class="user" method="post">                    Are you sure you want to delete this object?

                                        <input type="submit" class="btn btn-primary btn-user btn-block" value="Delete" name="delete_favorite_list">
                                        <hr>
                                            
						              </form>
                                            
								</div>
							</div>
						</div>
					</div>
                                            
                                            
                                            
                                            
	</div>';
	}
                      


}