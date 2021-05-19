<?php
            
/**
 * Customize o controller do objeto Movie aqui 
 * @author Jefferson Uchôa Ponte <jefponte@gmail.com>
 */

namespace popcornjef\custom\controller;
use popcornjef\controller\MovieController;
use popcornjef\custom\dao\MovieCustomDAO;
use popcornjef\custom\view\MovieCustomView;
use popcornjef\dao\MovieDAO;
use popcornjef\model\Movie;
use popcornjef\util\Sessao;
use popcornjef\dao\FavoriteListDAO;
use popcornjef\custom\dao\FavoriteListCustomDAO;
use popcornjef\model\FavoriteList;
use popcornjef\model\AppUser;
use popcornjef\custom\dao\AppUserCustomDAO;

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
	        $lista = $favoriteDao->fetchByAppUserAndMovie($favoriteList);
	        if(count($lista) == 0){
	            echo '<button class="float-right btn ml-3 btn-outline-light btn-circle btn-lg text-danger escondido" id="botao-unlike" href="'.$filme->id.'"><i class="fa fa-heart icone-maior"></i></button>';
	            echo '<button class="float-right btn ml-3 btn-outline-light btn-circle btn-lg text-white" id="botao-like" href="'.$filme->id.'"><i class="fa fa-heart icone-maior"></i></button>';
	        }else{
	            echo '<button class="float-right btn ml-3 btn-outline-light btn-circle btn-lg text-danger" id="botao-unlike" href="'.$filme->id.'"><i class="fa fa-heart icone-maior"></i></button>';
	            echo '<button class="float-right btn ml-3 btn-outline-light btn-circle btn-lg text-white escondido" id="botao-like" href="'.$filme->id.'"><i class="fa fa-heart icone-maior"></i></button>';
	        }
	        
	    }
	    if($sessao->getNivelAcesso() == Sessao::NIVEL_ADM){
	        echo '<button class="float-right btn ml-3 btn-outline-light btn-circle btn-lg text-white" id="botao-editar" data-bs-toggle="modal" data-bs-target="#modalEditar"><i class="fa fa-pencil icone-maior"></i></button>';
	        
	    }
	    
	    var_dump($filme);
	    $movie = new Movie();
	    $movie->setId($movieId);
	    $lista = $this->dao->fetchById($movie);
	    if(count($lista) > 0){
	        $movie = $lista[0];
	        
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
                echo '<a href="http://jefponte.ddns.net:888/popcornjef/src/?id='.$movie->getId().'" class="float-right btn ml-3 btn-outline-light btn-lg text-white" id="botao-like"><i class="fa fa-play icone-maior"></i></button>';
            }else{
                
                echo '
<div class="row m-3">
                    
                    
    <video  controls>
        <source  src="../../filmes/'.$movie->getMovieFilePath().'"   type="video/mp4">
        <track label="Portugues" kind="subtitles" srclang="pt"  src="../../filmes/web_subtitle/'.$movie->getSubtitleBrPath().'"   default>
        <track label="Español" kind="subtitles" srclang="es"  src="../../filmes/web_subtitle/'.$movie->getSubtitleBrPath().'"  >
    </video>
            
            
</div>
';
                
            }
            
        }
        if($movie->getTorrentLink() != ""){
            
            echo '
              <a href="" class="btn btn-outline-light" type="button">Torrent</a>';
        }
        
        if($movie->getSubtitleBrPath() != ""){
            
            echo '
              <a href="../..//filmes/web_subtitle/'.$movie->getSubtitleBrPath().'" class="btn btn-outline-light" type="button">Legenda</a>';
        }
	        
	}
	
	
	public function editar(Movie $movie){
	   
	    $this->dao->fillById($movie);

	    
	    if (! ( isset ( $_POST ['movie_file_path'] ) && isset ( $_POST ['torrent_link'] ) && isset ( $_POST ['subtitle_br_path'] ))) {
	        return;
	    }
	    
	    $movie->setMovieFilePath ( $_POST ['movie_file_path'] );
	    $movie->setTorrentLink ( $_POST ['torrent_link'] );
	    $movie->setSubtitleBrPath ( $_POST ['subtitle_br_path'] );
	    
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
	public function showMovies($filmes){
	    
	    echo '<div class="row d-flex justify-content-center">';
	    
	    foreach($filmes as $filme){
	        
	        $movieId = $filme->getId();
	        $url = 'https://api.themoviedb.org/3/movie/'.$movieId.'?api_key=34a4cf2512e61f46648b95e4b7a3ec9b&language=pt-Br';
	        
	        $ch = curl_init($url);
	        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	        $filme = json_decode(curl_exec($ch));
	        
	        
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