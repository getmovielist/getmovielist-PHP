<?php
            
/**
 * Customize o controller do objeto Movie aqui 
 * @author Jefferson Uchôa Ponte <jefponte@gmail.com>
 */

namespace getmovielist\custom\controller;
use getmovielist\controller\MovieController;
use getmovielist\custom\dao\MovieCustomDAO;
use getmovielist\custom\view\MovieCustomView;
use getmovielist\dao\MovieDAO;
use getmovielist\model\Movie;
use getmovielist\util\Sessao;
use getmovielist\custom\dao\FavoriteListCustomDAO;
use getmovielist\model\FavoriteList;
use getmovielist\model\AppUser;
use getmovielist\custom\dao\AppUserCustomDAO;
use getmovielist\custom\dao\SubtitleCustomDAO;
use getmovielist\model\Subtitle;

class MovieCustomController  extends MovieController {
    

	public function __construct(){
		$this->dao = new MovieCustomDAO();
		$this->view = new MovieCustomView();
	}

	public function perfil(){
	    if(!isset($_REQUEST['api'])){
	        return;
	    }
	    $appUser = new AppUser();
	    $appUser->setLogin($_REQUEST['api']);
	    $appUserDao = new AppUserCustomDAO($this->dao->getConnection());
	    $appUserDao->fillByLogin($appUser);
	    if($appUser->getId() == null){
	        return;
	    }
	    $favoriteList = new FavoriteList();
	    $favoriteList->getAppUser()->setId($appUser->getId());
	    $favoritListDao = new FavoriteListCustomDAO($this->dao->getConnection());
	    $listaFilmes = $favoritListDao->fetchByAppUser($favoriteList);
	    $lista = array();
	    foreach($listaFilmes as $elemento){
	        $lista[] = $elemento->getMovie();
	    }
	    $this->showMovies($lista);
	    
	    
	}
	public function select(){
	    $sessao = new Sessao();
	    if(!isset($_GET['id'])){
	        return;
	    }
	    $movieId = $_GET['id'];
	    $url = 'https://api.themoviedb.org/3/movie/'.$movieId.'?api_key=34a4cf2512e61f46648b95e4b7a3ec9b&language=pt-Br';
	    
	    $ch = curl_init($url);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	    $filme = json_decode(curl_exec($ch));
	    
	    
	    
	    echo '
	        
	        
      <div class="col-md-12">
          <div class="card bg-dark text-white text-white bg-dark">
            <img class="card-img" src="https://image.tmdb.org/t/p/original/'.$filme->backdrop_path.'" alt="Card image">
            <div class="card-img-overlay">
            <div class="row">
              <div class="col-md-2">
                <div class="card bg-dark text-white text-white bg-dark rounded-3">
                <img class="card-img" src="https://image.tmdb.org/t/p/original'.$filme->poster_path.'" alt="Card image">
              </div>
                    
              </div>
                    
                    
              <div class="col-md-10">
                <div class="p-5 text-white bg-dark rounded-3">';
	    
	    echo '
                  <h2>'.$filme->original_title.'</h2>
                  <p>'.$filme->overview.'</p>';
	    
	    
	    if($sessao->getNivelAcesso() != Sessao::NIVEL_DESLOGADO)
	    {
	        
	        $favoriteList = new FavoriteList();
	        $favoriteList->getAppUser()->setId($sessao->getIdUsuario());
	        $favoriteList->getMovie()->setId($filme->id);
	        $favoriteDao = new FavoriteListCustomDAO($this->dao->getConnection());
	        $lista = array();
	        $lista = $favoriteDao->fetchByAppUserAndMovie($favoriteList);
	        if(count($lista) == 0){
	            echo '<button class="float-right btn ml-3 btn-outline-light btn-circle btn-lg text-danger escondido" id="botao-unlike" href="'.$filme->id.'"><i class="fa fa-heart icone-maior"></i></button>';
	            echo '<button class="float-right btn ml-3 btn-outline-light btn-circle btn-lg text-white" id="botao-like" href="'.$filme->id.'"><i class="fa fa-heart icone-maior"></i></button>';
	        }else{
	            echo '<button class="float-right btn ml-3 btn-outline-light btn-circle btn-lg text-danger" id="botao-unlike" href="'.$filme->id.'"><i class="fa fa-heart icone-maior"></i></button>';
	            echo '<button class="float-right btn ml-3 btn-outline-light btn-circle btn-lg text-white escondido" id="botao-like" href="'.$filme->id.'"><i class="fa fa-heart icone-maior"></i></button>';
	        }
	        
	    }
	    $movie = new Movie();
	    $movie->setId($movieId);
	    $lista = $this->dao->fetchById($movie);
	    if(count($lista) > 0){
	        $movie = $lista[0];
	        if($sessao->getNivelAcesso() == Sessao::NIVEL_ADM){
	            echo '<button class="float-right btn ml-3 btn-outline-light btn-circle btn-lg text-white" id="botao-editar" data-bs-toggle="modal" data-bs-target="#modalEditar"><i class="fa fa-pencil icone-maior"></i></button>';
	            $subtitleController = new SubtitleCustomController();
	            $subtitleController->mainAdm($movie);
	        }
	        $this->playMovie($movie);
	    }
	    
	    echo '
	        
                </div>
              </div>
	        
            </div>
	        
          </div>
      </div>
	        
  ';
	    $this->editar($movie);
	    $this->view->showEditForm($movie);
	    
	}

	public function playMovie(Movie $movie){

	    $sessao = new Sessao();
	    if($sessao->getNivelAcesso() == Sessao::NIVEL_DESLOGADO){
	        return;
	    }
	    if($sessao->getNivelAcesso() == Sessao::NIVEL_COMUM){
	        return;
	    }
	    
        if($movie->getMovieFilePath() != ""){
	      
            
            if($_SERVER['HTTP_HOST'] == 'getmovielist.com'){
                echo '<a href="http://jefponte.ddns.net:888/getmovielist/src/?id='.$movie->getId().'" 
                        class="float-right btn ml-3 btn-outline-light btn-lg text-white"><i class="fa fa-play icone-maior"></i></a>';
            }else if($_SERVER['HTTP_HOST'] == 'jefponte.ddns.net:888' || $_SERVER['HTTP_HOST'] == 'localhost:888'){
                $subtitle = new Subtitle();
                $subtitle->getMovie()->setId($movie->getId());
                $subtitleDao = new SubtitleCustomDAO($this->dao->getConnection());
                $lista = $subtitleDao->fetchByMovie($subtitle);
                
                /*
                 * 
                    
   <track label="Deutsch" kind="subtitles" srclang="de" src="captions/vtt/sintel-de.vtt">
   <track label="Español" kind="subtitles" srclang="es" src="captions/vtt/sintel-es.vtt">
                 */
                echo '
<div class="row m-3">
                    
                    
    <video  controls>
        <source  src="../../filmes/'.$movie->getMovieFilePath().'"   type="video/mp4">';
                foreach($lista as $element){
                    echo '<track label="'.$element->getLabel().'" kind="subtitles" srclang="en" src="../../filmes/subtitles/vtt/'.$element->getFilePath().'" default>';
                }
                echo '
        
    </video>
            
            
</div>
';
                
            }
            
        }
        
        
	        
	}
	
	
	public function editar(Movie $movie){
	   
	    $this->dao->fillById($movie);

	    
	    if (! ( isset ( $_POST ['movie_file_path'] ))) {
	        return;
	    }
	    
	    $movie->setMovieFilePath ( $_POST ['movie_file_path'] );
	    
	    
	    if ($this->dao->update ($movie ))
	    {
	        echo '
	            
<div class="alert alert-success" role="alert">
  Sucesso
</div>
	            
';
	    } else {
	        echo '
	            
<div class="alert alert-danger" role="alert">
  Falha
</div>
	            
';
	    }
	    echo '<META HTTP-EQUIV="REFRESH" CONTENT="3; URL=.">';
	    
	}
	
	
	public function main(){
        
        if(isset($_REQUEST['api'])){
            $this->perfil();
            return;
        }
	    if(isset($_GET['id'])){
	        $this->select();
	        return;
	    }
	    if(isset($_GET['pesquisa'])){
	        echo '<div class="row d-flex justify-content-center">';
	        $pesquisa = $_GET['pesquisa'];
	        $pesquisa = str_replace(" ", "+", $pesquisa);
	        
	        
	        $url = "https://api.themoviedb.org/3/search/movie?api_key=34a4cf2512e61f46648b95e4b7a3ec9b&query=$pesquisa";
	        $ch = curl_init($url);
	        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	        $filmes = json_decode(curl_exec($ch));
	        foreach($filmes->results as $filme){
	            $foto = 'https://image.tmdb.org/t/p/original'.$filme->poster_path;
	            if($filme->poster_path == ""){
	                $foto = 'sem.png';
	                
	            }
	            if(!isset($filme->release_date)){
	                continue;
	            }
	            
	            echo '


	                
        <div class="card m-1" style="width: 10rem;">
            <img class="card-img-top" src="'.$foto.'" alt="Card image cap">
            <div class="card-body">
                <p><a href="./?id='.$filme->id.'">'.$filme->original_title.'</a> ('.date("Y", strtotime($filme->release_date)).')</p>
            </div>
        </div>
            ';
	            
	            
	        }
	        echo '</div>';
	    }else{
	        $movieDao = new MovieDAO();
	        $filmes = $movieDao->fetch();
	        $this->showMovies($filmes);
	    }
	    
	    
	    
	}
	/**
	 * Entrada tem que ser um array de objeto Movie. 
	 * @param array:Movie $filmes
	 */
	public function showMovies($filmes){
	    
	    echo '<div class="row d-flex justify-content-center">';
	    
	    foreach($filmes as $filme){
	        $foto = 'https://image.tmdb.org/t/p/original'.$filme->getPosterPath();
	        if($filme->getPosterPath() == ""){
	            $foto = 'sem.png';
	        }

	        
	        echo '
	            
      <div class="card m-1" style="width: 10rem;">
          <img class="card-img-top" src="'.$foto.'" alt="Card image cap">
          <div class="card-body">
          <p><a href="./?id='.$filme->getId().'">'.$filme->getOriginalTitle().'</a> ('.date("Y", strtotime($filme->getReleaseDate())).')</p>
          </div>
      </div>
          ';
	        
	        
	    }
	    echo '</div>';
	}
	
	public function clickLike(){
	    if(!isset($_POST['id'])){
	        return;
	    }
	    $sessao = new Sessao();
	    if($sessao->getNivelAcesso() == Sessao::NIVEL_DESLOGADO){
	        return;
	    }
	    $movie = new Movie ();
	    $movie->setId($_POST['id']);
	    $lista = $this->dao->fetchById($movie);
	    
	    
	    
	    if(count($lista) == 0){
	        $movieId = $_POST['id'];
	        $url = 'https://api.themoviedb.org/3/movie/'.$movieId.'?api_key=34a4cf2512e61f46648b95e4b7a3ec9b&language=pt-Br';
	        
	        $ch = curl_init($url);
	        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	        $filme = json_decode(curl_exec($ch));
	        $movie->setId($movieId);
	        $movie->setTitle($filme->title);
	        $movie->setOriginalTitle($filme->original_title);
	        $movie->setPosterPath($filme->poster_path);
	        $movie->setReleaseDate($filme->release_date);
	        
	        $this->dao->insertWithPK($movie);
	    }
	    $favoriteListDao = new FavoriteListCustomDAO($this->dao->getConnection());
	    $favoriteList = new FavoriteList();
	    
	    $favoriteList->getAppUser()->setId($sessao->getIdUsuario());
	    $favoriteList->getMovie()->setId($movie->getId());
	    
	    $list = $favoriteListDao->fetchByAppUserAndMovie($favoriteList);
	    if(count($list) == 0){
	        if($favoriteListDao->insert($favoriteList)){
	            echo "sucess";
	        }else{
	            echo 'fail';
	        }
	        return;
	    }else{
	        echo 'sucess';
	    }
	   
	    
	}
	public function clickUnLike(){
	    if(!isset($_POST['id'])){
	        return;
	    }
	    $sessao = new Sessao();
	    if($sessao->getNivelAcesso() == Sessao::NIVEL_DESLOGADO){
	        return;
	    }
	    $movie = new Movie ();
	    $movie->setId($_POST['id']);
	    $lista = $this->dao->fetchById($movie);
	    
	    
	    
	    if(count($lista) == 0){
	        $this->dao->insertWithPK($movie);
	    }
	    $favoriteListDao = new FavoriteListCustomDAO($this->dao->getConnection());
	    $favoriteList = new FavoriteList();
	    
	    $favoriteList->getAppUser()->setId($sessao->getIdUsuario());
	    $favoriteList->getMovie()->setId($movie->getId());
	    
	    $list = $favoriteListDao->fetchByAppUserAndMovie($favoriteList);
	    if(count($list) == 0){
	        echo 'sucess';
	        return;
	    }else{
	        $favoriteList = $list[0];
	        if($favoriteListDao->delete($favoriteList)){
	            echo 'sucess';
	        }else{
	            echo 'fail';
	        }
	        
	    }
	    
	    
	}
	        
}
?>