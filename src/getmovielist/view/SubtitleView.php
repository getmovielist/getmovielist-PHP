<?php
            
/**
 * Classe de visao para Subtitle
 * @author Jefferson Uchôa Ponte <j.pontee@gmail.com>
 *
 */

namespace getmovielist\view;
use getmovielist\model\Subtitle;


class SubtitleView {
    public function showInsertForm($listaMovieFile) {
		echo '
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary m-3" data-toggle="modal" data-target="#modalAddSubtitle">
  Adicionar
</button>

<!-- Modal -->
<div class="modal fade" id="modalAddSubtitle" tabindex="-1" role="dialog" aria-labelledby="labelAddSubtitle" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="labelAddSubtitle">Adicionar Subtitle</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
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
                                            <input type="text" class="form-control"  name="file_path" id="file_path" placeholder="File Path">
                                        </div>

                                        <div class="form-group">
                                            <label for="lang">Lang</label>
                                            <input type="text" class="form-control"  name="lang" id="lang" placeholder="Lang">
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
        <button form="insert_form_subtitle" type="submit" class="btn btn-primary">Cadastrar</button>
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
                  Lista Subtitle
                </div>
                <div class="card-body">
                                            
                                            
		<div class="table-responsive">
			<table class="table table-bordered" id="dataTable" width="100%"
				cellspacing="0">
				<thead>
					<tr>
						<th>Id</th>
						<th>Label</th>
						<th>File Path</th>
						<th>Lang</th>
						<th>Movie File</th>
                        <th>Actions</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
                        <th>Id</th>
                        <th>Label</th>
                        <th>File Path</th>
                        <th>Lang</th>
						<th>Movie File</th>
                        <th>Actions</th>
					</tr>
				</tfoot>
				<tbody>';
            
            foreach($lista as $element){
                echo '<tr>';
                echo '<td>'.$element->getId().'</td>';
                echo '<td>'.$element->getLabel().'</td>';
                echo '<td>'.$element->getFilePath().'</td>';
                echo '<td>'.$element->getLang().'</td>';
                echo '<td>'.$element->getMovieFile().'</td>';
                echo '<td>
                        <a href="?page=subtitle&select='.$element->getId().'" class="btn btn-info text-white">Select</a>
                        <a href="?page=subtitle&edit='.$element->getId().'" class="btn btn-success text-white">Edit</a>
                        <a href="?page=subtitle&delete='.$element->getId().'" class="btn btn-danger text-white">Delete</a>
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
            

            
	public function showEditForm($listaMovieFile, Subtitle $selecionado) {
		echo '
	    
	    

<div class="card o-hidden border-0 shadow-lg mb-4">
    <div class="card">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Edit Subtitle</h6>
        </div>
        <div class="card-body">
            <form class="user" method="post" id="edit_form_subtitle">
                                        <div class="form-group">
                                            <label for="label">Label</label>
                                            <input type="text" class="form-control" value="'.$selecionado->getLabel().'"  name="label" id="label" placeholder="Label">
                						</div>
                                        <div class="form-group">
                                            <label for="file_path">File Path</label>
                                            <input type="text" class="form-control" value="'.$selecionado->getFilePath().'"  name="file_path" id="file_path" placeholder="File Path">
                						</div>
                                        <div class="form-group">
                                            <label for="lang">Lang</label>
                                            <input type="text" class="form-control" value="'.$selecionado->getLang().'"  name="lang" id="lang" placeholder="Lang">
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
                <input type="hidden" value="1" name="edit_subtitle">
                </form>

        </div>
        <div class="modal-footer">
            <button form="edit_form_subtitle" type="submit" class="btn btn-primary">Cadastrar</button>
        </div>
    </div>
</div>

	    

										
						              ';
	}




            
        public function showSelected(Subtitle $subtitle){
            echo '
            
	<div class="card o-hidden border-0 shadow-lg">
        <div class="card">
            <div class="card-header">
                  Subtitle selecionado
            </div>
            <div class="card-body">
                Id: '.$subtitle->getId().'<br>
                Label: '.$subtitle->getLabel().'<br>
                File Path: '.$subtitle->getFilePath().'<br>
                Lang: '.$subtitle->getLang().'<br>
                Movie File: '.$subtitle->getMovieFile().'<br>
            
            </div>
        </div>
    </div>
            
            
';
    }


                                            
    public function confirmDelete(Subtitle $subtitle) {
		echo '
        
        
        
				<div class="card o-hidden border-0 shadow-lg">
					<div class="card-body p-0">
						<!-- Nested Row within Card Body -->
						<div class="row">
        
							<div class="col-lg-12">
								<div class="p-5">
									<div class="text-center">
										<h1 class="h4 text-gray-900 mb-4"> Delete Subtitle</h1>
									</div>
						              <form class="user" method="post">                    Are you sure you want to delete this object?

                                        <input type="submit" class="btn btn-primary btn-user btn-block" value="Delete" name="delete_subtitle">
                                        <hr>
                                            
						              </form>
                                            
								</div>
							</div>
						</div>
					</div>
                                            
                                            
                                            
                                            
	</div>';
	}
                      


}