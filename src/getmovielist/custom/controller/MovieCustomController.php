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
use getmovielist\model\MovieFile;
use getmovielist\dao\MovieFileDAO;
use getmovielist\controller\MovieFileController;

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
	    if(!isset($_GET['id'])){
	        return;
	    }
	    $movieId = $_GET['id'];
	    $url = 'https://api.themoviedb.org/3/movie/'.$movieId.'?api_key=34a4cf2512e61f46648b95e4b7a3ec9b&language=pt-Br';
	    
	    
	    $ch = curl_init($url);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	    $filme = json_decode(curl_exec($ch));
	    
	    
	    $listGeneros = array();
	    foreach($filme->genres as $valor){
	        $listGeneros[] = $valor->name;
	    }

	    
	    echo '
	        
	        
      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
          <div class="card bg-dark text-white text-white bg-dark">
            <img class="card-img" src="https://image.tmdb.org/t/p/original/'.$filme->backdrop_path.'" alt="Card image">
            <div class="card-img-overlay">
            <div class="row">
              <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12">
                <div class="card bg-dark text-white text-white bg-dark rounded-3">
                <img class="card-img" src="https://image.tmdb.org/t/p/original'.$filme->poster_path.'" alt="Card image">
              </div>
                    
              </div>
                    
                    
              <div class="col-xl-10 col-lg-10 col-md-10 col-sm-12">
                <div class="p-5 text-white bg-dark rounded-3">';
	    
	    echo '
                  <h2>'.$filme->original_title.'</h2>
                  <p>'.$filme->overview.'</p>
                    <p>Gêneros: '.implode("/", $listGeneros).'</p>
';
	    
	    
	    
	    
	    $movie = new Movie();
	    $movie->setId($movieId);
	    $this->panelLike($movie);
	    
	    $lista = $this->dao->fetchById($movie);
	    if(count($lista) > 0){
	        $movie = $lista[0];
	        $this->panelAdmMovie($movie);
	        $movie->setPosterPath($filme->backdrop_path);
	        $this->playMovie($movie);
	    }
	    
	    echo '
	        
                </div>
              </div>
	        
            </div>
	        
          </div>
      </div>
	        
  ';
	    
	    
	}

	public function panelLike(Movie $movie){
	    $sessao = new Sessao();
	    if($sessao->getNivelAcesso() == Sessao::NIVEL_DESLOGADO)
	    {
	        return;
	    }
	        
        $favoriteList = new FavoriteList();
        $favoriteList->getAppUser()->setId($sessao->getIdUsuario());
        $favoriteList->getMovie()->setId($movie->getId());
        $favoriteDao = new FavoriteListCustomDAO($this->dao->getConnection());
        $lista = array();
        $lista = $favoriteDao->fetchByAppUserAndMovie($favoriteList);
        if(count($lista) == 0){
            echo '<button class="float-right btn ml-3 btn-outline-light btn-circle btn-lg text-danger escondido" id="botao-unlike" href="'.$movie->getId().'"><i class="fa fa-heart icone-maior"></i></button>';
            echo '<button class="float-right btn ml-3 btn-outline-light btn-circle btn-lg text-white" id="botao-like" href="'.$movie->getId().'"><i class="fa fa-heart icone-maior"></i></button>';
        }else{
            echo '<button class="float-right btn ml-3 btn-outline-light btn-circle btn-lg text-danger" id="botao-unlike" href="'.$movie->getId().'"><i class="fa fa-heart icone-maior"></i></button>';
            echo '<button class="float-right btn ml-3 btn-outline-light btn-circle btn-lg text-white escondido" id="botao-like" href="'.$movie->getId().'"><i class="fa fa-heart icone-maior"></i></button>';
        }
	        
	    
	}
	/**
	 * Adicionar legenda
	 * Adicionar torrent
	 * Adicionar arquivo de filme
	 * 
	 * @param Movie $movie
	 */
	public function panelAdmMovie(Movie $movie){
	    $sessao = new Sessao();
	    if($sessao->getNivelAcesso() != Sessao::NIVEL_ADM){
	        return;
	    }
	    $movieFileController = new MovieFileCustomController();
	    $movieFileController->addFile($movie);
	    
	    $subtitleController = new SubtitleCustomController();
	    $subtitleController->addSubtitle($movie);
	    
	    $torrentController = new TorrentMovieCustomController();
	    $torrentController->addTorrent($movie);
	    

	        
	    
	}
	public function playMovie(Movie $movie){

	    $sessao = new Sessao();
	    
	    if($sessao->getNivelAcesso() == Sessao::NIVEL_DESLOGADO){
	        return;
	    }
	    if($sessao->getNivelAcesso() == Sessao::NIVEL_COMUM){
	        return;
	    }
	     
	    
	    /*
        if($movie->getMovieFilePath() != ""){
	      
            
            if($_SERVER['HTTP_HOST'] == 'getmovielist.com'){
                echo '<a href="http://getmovielist.ddns.net:888/getmovielist/src/?id='.$movie->getId().'" 
                        class="float-right btn ml-3 btn-outline-light btn-lg text-white"><i class="fa fa-play icone-maior"></i></a>';
            }else if($_SERVER['HTTP_HOST'] == 'getmovielist.ddns.net:888' || $_SERVER['HTTP_HOST'] == 'localhost:888' || $_SERVER['HTTP_HOST'] == '192.168.0.10:888'){
                $subtitle = new Subtitle();
                $subtitle->getMovie()->setId($movie->getId());
                $subtitleDao = new SubtitleCustomDAO($this->dao->getConnection());
                $lista = $subtitleDao->fetchByMovie($subtitle);

                echo '
<div class="row m-3">
                    
                    
';
                
        
                echo '
            <video id="example" poster="https://image.tmdb.org/t/p/original'.$movie->getPosterPath().'">
  <source src="../../filmes/'.$movie->getMovieFilePath().'" type="video/mp4">';
                foreach($lista as $element){
                    echo '<track kind="captions" label="'.$element->getLabel().'" srclang="pt" src="../../filmes/subtitles/vtt/'.$element->getFilePath().'" default>';
                }
                echo '
  

  Seu navegador não é compatível com o nosso player. 
</video>
            
</div>
';
                
            }
            
        }
        */
        
	        
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
            <img class="card-img" src="'.$foto.'" alt="Card image">
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