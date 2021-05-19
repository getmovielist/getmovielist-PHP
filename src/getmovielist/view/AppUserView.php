<?php
            
/**
 * Classe de visao para AppUser
 * @author Jefferson Uchôa Ponte <j.pontee@gmail.com>
 *
 */

namespace getmovielist\view;
use getmovielist\model\AppUser;


class AppUserView {
    public function showInsertForm() {
		echo '
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary m-3" data-toggle="modal" data-target="#modalAddAppUser">
  Adicionar
</button>

<!-- Modal -->
<div class="modal fade" id="modalAddAppUser" tabindex="-1" role="dialog" aria-labelledby="labelAddAppUser" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="labelAddAppUser">Adicionar App User</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <form id="insert_form_app_user" class="user" method="post">
            <input type="hidden" name="enviar_app_user" value="1">                



                                        <div class="form-group">
                                            <label for="name">Name</label>
                                            <input type="text" class="form-control"  name="name" id="name" placeholder="Name">
                                        </div>

                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="text" class="form-control"  name="email" id="email" placeholder="Email">
                                        </div>

                                        <div class="form-group">
                                            <label for="login">Login</label>
                                            <input type="text" class="form-control"  name="login" id="login" placeholder="Login">
                                        </div>

                                        <div class="form-group">
                                            <label for="password">Password</label>
                                            <input type="text" class="form-control"  name="password" id="password" placeholder="Password">
                                        </div>

                                        <div class="form-group">
                                            <label for="level">Level</label>
                                            <input type="number" class="form-control"  name="level" id="level" placeholder="Level">
                                        </div>

						              </form>


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        <button form="insert_form_app_user" type="submit" class="btn btn-primary">Cadastrar</button>
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
                  Lista App User
                </div>
                <div class="card-body">
                                            
                                            
		<div class="table-responsive">
			<table class="table table-bordered" id="dataTable" width="100%"
				cellspacing="0">
				<thead>
					<tr>
						<th>Id</th>
						<th>Name</th>
						<th>Email</th>
						<th>Login</th>
                        <th>Actions</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Login</th>
                        <th>Actions</th>
					</tr>
				</tfoot>
				<tbody>';
            
            foreach($lista as $element){
                echo '<tr>';
                echo '<td>'.$element->getId().'</td>';
                echo '<td>'.$element->getName().'</td>';
                echo '<td>'.$element->getEmail().'</td>';
                echo '<td>'.$element->getLogin().'</td>';
                echo '<td>
                        <a href="?page=app_user&select='.$element->getId().'" class="btn btn-info text-white">Select</a>
                        <a href="?page=app_user&edit='.$element->getId().'" class="btn btn-success text-white">Edit</a>
                        <a href="?page=app_user&delete='.$element->getId().'" class="btn btn-danger text-white">Delete</a>
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
            

            
	public function showEditForm(AppUser $selecionado) {
		echo '
	    
	    

<div class="card o-hidden border-0 shadow-lg mb-4">
    <div class="card">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Edit App User</h6>
        </div>
        <div class="card-body">
            <form class="user" method="post" id="edit_form_app_user">
                                        <div class="form-group">
                                            <label for="name">Name</label>
                                            <input type="text" class="form-control" value="'.$selecionado->getName().'"  name="name" id="name" placeholder="Name">
                						</div>
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="text" class="form-control" value="'.$selecionado->getEmail().'"  name="email" id="email" placeholder="Email">
                						</div>
                                        <div class="form-group">
                                            <label for="login">Login</label>
                                            <input type="text" class="form-control" value="'.$selecionado->getLogin().'"  name="login" id="login" placeholder="Login">
                						</div>
                                        <div class="form-group">
                                            <label for="password">Password</label>
                                            <input type="text" class="form-control" value="'.$selecionado->getPassword().'"  name="password" id="password" placeholder="Password">
                						</div>
                                        <div class="form-group">
                                            <label for="level">Level</label>
                                            <input type="number" class="form-control" value="'.$selecionado->getLevel().'"  name="level" id="level" placeholder="Level">
                						</div>
                <input type="hidden" value="1" name="edit_app_user">
                </form>

        </div>
        <div class="modal-footer">
            <button form="edit_form_app_user" type="submit" class="btn btn-primary">Cadastrar</button>
        </div>
    </div>
</div>

	    

										
						              ';
	}




            
        public function showSelected(AppUser $appuser){
            echo '
            
	<div class="card o-hidden border-0 shadow-lg">
        <div class="card">
            <div class="card-header">
                  App User selecionado
            </div>
            <div class="card-body">
                Id: '.$appuser->getId().'<br>
                Name: '.$appuser->getName().'<br>
                Email: '.$appuser->getEmail().'<br>
                Login: '.$appuser->getLogin().'<br>
                Password: '.$appuser->getPassword().'<br>
                Level: '.$appuser->getLevel().'<br>
            
            </div>
        </div>
    </div>
            
            
';
    }


                                            
    public function confirmDelete(AppUser $appUser) {
		echo '
        
        
        
				<div class="card o-hidden border-0 shadow-lg">
					<div class="card-body p-0">
						<!-- Nested Row within Card Body -->
						<div class="row">
        
							<div class="col-lg-12">
								<div class="p-5">
									<div class="text-center">
										<h1 class="h4 text-gray-900 mb-4"> Delete App User</h1>
									</div>
						              <form class="user" method="post">                    Are you sure you want to delete this object?

                                        <input type="submit" class="btn btn-primary btn-user btn-block" value="Delete" name="delete_app_user">
                                        <hr>
                                            
						              </form>
                                            
								</div>
							</div>
						</div>
					</div>
                                            
                                            
                                            
                                            
	</div>';
	}
                      


}