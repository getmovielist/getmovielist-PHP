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
use getmovielist\custom\dao\MovieFileCustomDAO;
use getmovielist\model\TorrentMovie;
use getmovielist\custom\dao\TorrentMovieCustomDAO;

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
	public function getCredits(Movie $movie){

	    $id = $movie->getId();
	    $url = 'https://api.themoviedb.org/3/movie/'.$id.'/credits?api_key=34a4cf2512e61f46648b95e4b7a3ec9b&language=pt-Br';
	    $ch = curl_init($url);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	    return json_decode(curl_exec($ch));
	}
	public function getVideos(Movie $movie){
	    $id = $movie->getId();
	    $url = 'https://api.themoviedb.org/3/movie/'.$id.'/videos?api_key=34a4cf2512e61f46648b95e4b7a3ec9b&language=pt-Br';
	    $ch = curl_init($url);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	    return json_decode(curl_exec($ch));
	    
	    
	}
	public function getImages(Movie $movie){
	    $id = $movie->getId();
	    $url = 'https://api.themoviedb.org/3/movie/'.$id.'/images?api_key=34a4cf2512e61f46648b95e4b7a3ec9b';
	    
	    
	    $ch = curl_init($url);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	    return json_decode(curl_exec($ch));
	    
	}
	public function getProviders(Movie $movie){
	    $id = $movie->getId();
	    $url = 'https://api.themoviedb.org/3/movie/'.$id.'/watch/providers?api_key=34a4cf2512e61f46648b95e4b7a3ec9b';
	    
	    
	    $ch = curl_init($url);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	    return json_decode(curl_exec($ch));
	    
	}
	public function getDetails(Movie $movie){
	    $id = $movie->getId();
	    $url = 'https://api.themoviedb.org/3/movie/'.$id.'?api_key=34a4cf2512e61f46648b95e4b7a3ec9b&language=pt-Br';
	    
	    
	    $ch = curl_init($url);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	    return json_decode(curl_exec($ch));
	}
	
	public function select(){
	    if(!isset($_GET['id'])){
	        return;
	    }
	    $movieId = $_GET['id'];
	    $movie = new Movie();
	    $movie->setId($movieId);
	    
	    $filme = $this->getDetails($movie);
	    
	    $listGeneros = array();
	    foreach($filme->genres as $valor){
	        $listGeneros[] = $valor->name;
	    }

	    $imagens = $this->getImages($movie);
	    echo '
	        
	        
      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
          <div class="card bg-dark text-white text-white bg-dark">
            <img class="card-img" src="https://image.tmdb.org/t/p/original/'.$filme->backdrop_path.'" alt="Card image">
            <div class="card-img-overlay">
            <div class="row">      
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                    <div class="p-5 text-white ">

                        <div class="row">
<div class="col-xl-2 col-lg-2 col-md-2 col-sm-12">
                    

        <div id="carouselPosters" class="carousel slide carousel-fade" data-bs-ride="carousel">
          <div class="carousel-inner">';
        $act = "active";
        foreach($imagens->posters as $imagem){
            echo '
            <div class="carousel-item '.$act.'">
              <img src="https://www.themoviedb.org/t/p/w300_and_h450_bestv2/'.$imagem->file_path.'" class="d-block w-100" alt="...">
            </div>
';
            $act = "";
        }
        echo '

          </div>
          <button class="carousel-control-prev" type="button" data-bs-target="#carouselPosters" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
          </button>
          <button class="carousel-control-next" type="button" data-bs-target="#carouselPosters" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
          </button>
        </div>

                ';

        echo '
                

                </div>                    





<div class="col-xl-10 col-lg-10 col-md-10 col-sm-12  bg-dark rounded-3">

                        <h2>'.$filme->title.' ('.$filme->original_title.')</h2>
                        <p>'.$filme->overview.'</p>
                        <p>Gêneros: '.implode("/", $listGeneros).' 
';
        echo ' - Lançamento: '.date("Y", strtotime($filme->release_date));
        
        $credits = $this->getCredits($movie);
        $diretor = array();
        $screenplay = array();
        foreach($credits->crew as $line){
            if($line->job == "Director"){
                $diretor[] = $line->name;
            }
            if($line->job == "Screenplay"){
                $screenplay[] = $line->name;
            }
            
        }
        echo ' - Diretor: '.implode(", ", $diretor);
        echo ' - Roteiro: '.implode(", ", $screenplay).'</p>';
        
        $this->panelLike($movie);
        
        $providers = $this->getProviders($movie);
        if(isset($providers->results->BR)){
            if(isset($providers->results->BR->flatrate)){
                foreach($providers->results->BR->flatrate as $line){
                    echo '<img height="40" class="m-3" src="https://image.tmdb.org/t/p/original/'.$line->logo_path.'">';
                }
            }
        }
        echo '<div class="row">';
        $i = 0;
        foreach($credits->cast as $line){
            $i++;
            if($i == 13){
                break;
            }
            if(!isset($line->profile_path)){
                continue;
            }
            echo '
<div class="col-xl-1 col-lg-1 col-md-2 col-sm-4 mt-4">
<div class="card">
    <img class="card-img-top" src="https://www.themoviedb.org/t/p/w300_and_h450_bestv2/'.$line->profile_path.'">
</div>
<p><b>'.$line->name.'</b><br>'.$line->character.'</p> 
</div>
';
            
        }
        echo '</div>';
        echo '                    </div>                    </div>';

        echo '<br><br>';
        echo '
<div class="row">
<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">

<div id="carouselImageBackdrops" class="carousel slide carousel-fade" data-bs-ride="carousel">
  <div class="carousel-inner">';
        $act = "active";
        foreach($imagens->backdrops as $imagem){
            
            
            echo '
    <div class="carousel-item '.$act.'">
      <img src="https://image.tmdb.org/t/p/original/'.$imagem->file_path.'" class="d-block w-100" alt="...">
    </div>
                
';
            $act = "";
        }
        
        echo '
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselImageBackdrops" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselImageBackdrops" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>

</div>';
        $listVideos = $this->getVideos($movie);

        echo '
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">

';
        foreach($listVideos->results as $line){
            echo '
                
<div class="ratio ratio-21x9">
  <iframe src="https://www.youtube.com/embed/'.$line->key.'" title="YouTube video" allowfullscreen></iframe>
</div>
';
            break;
            
        }
        $lista = $this->dao->fetchById($movie);
        if(count($lista) > 0){
            $movie = $lista[0];
            $this->panelAdmMovie($movie);
            $movie->setPosterPath($filme->backdrop_path);
            $this->painelPrivilegios($movie);
        }
    echo '
    
    </div>
</div>
';
       
        
//         print_r($imagens);
        

        
        echo '<br>';

	   
	    echo '
	        
                    </div>
                </div>


            </div><!-- row -->
            
	        
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
	    echo '<br><hr><p>Painel Adm</p>';
	    $movieFileController = new MovieFileCustomController();
	    $movieFileController->addFile($movie);
	    
	    $subtitleController = new SubtitleCustomController();
	    $subtitleController->addSubtitle($movie);
	    
	    $torrentController = new TorrentMovieCustomController();
	    $torrentController->addTorrent($movie);
	    

	        
	    
	}
	public function painelPrivilegios(Movie $movie){

	    $sessao = new Sessao();
	    
	    if($sessao->getNivelAcesso() == Sessao::NIVEL_DESLOGADO){
	        return;
	    }
	    if($sessao->getNivelAcesso() == Sessao::NIVEL_COMUM){
	        return;
	    }
	     
	    $movieFileDao = new MovieFileDAO($this->dao->getConnection());
	    $movieFile = new MovieFile();
	    $movieFile->getMovie()->setId($movie->getId());
	    $lista = $movieFileDao->fetchByMovie($movieFile);
	    if(count($lista) == 0){
	        return;
	    }
	    
	    echo '
            <hr>Painel de Privilegios</hr><br><br>';
	    $movieFile = new MovieFile();
	    $movieFile->getMovie()->setId($movie->getId());
	    $movieFileDao = new MovieFileCustomDAO();
	    $listaMovieFiles = $movieFileDao->fetchByMovie($movieFile);
	    
	    if(count($lista) == 0){
	        return;
	    }

	    
	    
	    $subtitleDao = new SubtitleCustomDAO($this->dao->getConnection());
	    $torrentDao = new TorrentMovieCustomDAO($this->dao->getConnection());
	    
	    foreach($listaMovieFiles as $movieFile){

	        $torrent = new TorrentMovie();
	        $torrent->getMovieFile()->setId($movieFile->getId());
	        $torrentList = $torrentDao->fetchByMovieFile($torrent);
	        
	        $subtitle = new Subtitle();
	        $subtitle->getMovieFile()->setId($movieFile->getId());
	        $subtitleList = $subtitleDao->fetchByMovieFile($subtitle);
	        
	        foreach($torrentList as $torrent){
	            echo '<a href="'.$torrent->getLink().'" class="float-right btn m-1 btn-outline-light btn-circle btn-lg text-white"><i class="fa fa-magnet icone-maior"></i></a>';
	        }
	        foreach($subtitleList as $subtitle2)
	        {
	            echo '<a href="'.$subtitle2->getFilePath().'" class="float-right btn m-1 btn-outline-light btn-circle btn-lg text-white"><i class="fa fa-font icone-maior"></i></a>';
	        }
	        
            echo '<a href="'.$movieFile->getFilePath().'" class="float-right btn m-1 btn-outline-light btn-circle btn-lg text-white"><i class="fa fa-film icone-maior"></i></a>';
	        

            echo '<a href="?player='.$movie->getId().'"
                        class="float-right btn ml-3 btn-outline-light btn-lg text-white"><i class="fa fa-play icone-maior"></i></a>';
                
            

	        break;

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

	
	public function player(){
	    
	    $sessao = new Sessao();
	    if(!isset($_GET['player'])){
	        return;
	    }
	    if($sessao->getNivelAcesso() == Sessao::NIVEL_DESLOGADO){
	        return;
	    }

	    if($sessao->getNivelAcesso() == Sessao::NIVEL_COMUM){
	        return;
	    }
	    echo '

<div class="container">

<div class="ratio ratio-16x9 p-3">';
	    echo '<iframe class="tscplayer_inline" height="800"   src="player.js/test/index.php?player='.$_GET['player'].'" scrolling="no" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>';
  echo '
</div></div>';
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
	    if(isset($_GET['player'])){
	        $this->player();
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
	        $foto = 'https://www.themoviedb.org/t/p/w300_and_h450_bestv2/'.$filme->getPosterPath();
	        if($filme->getPosterPath() == ""){
	            $foto = 'sem.png';
	        }

	        
	        echo '
    <div class="col-xl-1 col-lg-1 col-md-1 col-sm-12 m-1">
      <div class="card">

            <img class="card-img-top" src="'.$foto.'" alt="Card image">
            
      </div>
      <p><a href="./?id='.$filme->getId().'">'.$filme->getTitle().'</a> ('.date("Y", strtotime($filme->getReleaseDate())).')</p>
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