<?php
            

define("DB_INI", "../getmovielist_db.ini");
define("API_INI", "../getmovielist_api_rest.ini");

function autoload($classe) {
    
    $prefix = 'getmovielist';
    $base_dir = 'getmovielist';
    $len = strlen($prefix);
    if (strncmp($prefix, $classe, $len) !== 0) {
        return;
    }
    $relative_class = substr($classe, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
    if (file_exists($file)) {
        require $file;
    }
    
}
spl_autoload_register('autoload');


use getmovielist\util\Sessao;
use getmovielist\custom\controller\AppUserCustomController;
use getmovielist\custom\view\AppUserCustomView;
use getmovielist\custom\controller\MainContent;
use getmovielist\custom\controller\MovieCustomController;
use getmovielist\dao\DAO;

$sessao = new Sessao();

if(isset($_GET['ajax'])){

    switch ($_GET['ajax']){

        case 'app_user':
            $controller = new AppUserCustomController();
            $controller->mainAjax();
            break;
        case 'click_like':
            $controller = new MovieCustomController();
            $controller->clickLike();
            break;
        case 'click_unlike':
            $controller = new MovieCustomController();
            $controller->clickUnLike();
            break;
        default:
            echo '<p>Página solicitada não encontrada.</p>';
            break;
    }
    
    exit(0);
}


if (isset($_GET["sair"])) {
    $sessao->mataSessao();
    echo '<META HTTP-EQUIV="REFRESH" CONTENT="0; URL=index.php">';
    
}

?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="plugins/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="css/style.css?a=123" />
    <title>GetMovieList</title>

  </head>
  <body>

  <header class="p-3 bg-dark text-white">
    <div class="">
      <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
        <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
          <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap"><use xlink:href="#bootstrap"></use></svg>
        </a>

        <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
          <li><a href="./" class="nav-link px-2 text-secondary">Início</a></li>
          <?php 
          
          
          echo '<li><a href="./'.$sessao->getLoginUsuario().'" class="nav-link px-2 text-white">My List</a></li>';
          
          ?>

          
        </ul>

        <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3" action=".">
          <input type="search" name="pesquisa" class="form-control form-control-dark" placeholder="Pesquisar..." aria-label="Pesquisar">
        </form>

		<div class="text-end">
		
		
		<?php 
		
		$sessao = new Sessao();
		if($sessao->getNivelAcesso() != Sessao::NIVEL_DESLOGADO){
		    echo '<a href="?sair=1" class="btn btn-warning">Sign-out</a>';
		    
		}else{

		    
		    echo '<div class="text-end">
  <a href="?page=login" class="btn btn-outline-light me-2">Login</a>
  <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalAddUsuario">Sign-up</button>
</div>            
';
		}
		
		?>
		
          
        </div>

      </div>
    </div>
  </header>


<?php

$mainContent = new MainContent();
$mainContent->main();

    


?>


<!-- Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="loginModalLabel">Modal title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Faça seu login
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>



<!-- Modal -->
<div class="modal fade" id="sigUpModal" tabindex="-1" aria-labelledby="sigUpModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="sigUpModalLabel">Modal title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Faça seu login
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
<?php 

$sessao = new Sessao();
if($sessao->getNivelAcesso() == Sessao::NIVEL_DESLOGADO){
    $usuarioView = new AppUserCustomView();
    $usuarioView->mostraFormInserir();

}


?>

<!-- Modal -->
<div class="modal fade" id="modalResposta" tabindex="-1" aria-labelledby="labelModalResposta" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="labelModalResposta">Resposta</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
         <span id="textoModalResposta"></span>
      </div>
      <div class="modal-footer">        
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Ok</button>
      </div>
    </div>
  </div>
</div>



    <!-- Optional JavaScript; choose one of the two! -->
<script
  src="https://code.jquery.com/jquery-3.6.0.min.js"
  integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
  crossorigin="anonymous"></script>
  	
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous"></script>
    -->

        <script src="js/comment.js" ></script>
        <script src="js/favorite_list.js" ></script>
        <script src="js/app_user.js" ></script>
        <script src="js/movie.js" ></script>
	</body>
</html>