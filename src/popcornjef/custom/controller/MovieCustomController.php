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

class MovieCustomController  extends MovieController {
    

	public function __construct(){
		$this->dao = new MovieCustomDAO();
		$this->view = new MovieCustomView();
	}


	public function main(){
	    
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
            <p><a href="?id='.$filme->id.'">'.$filme->original_title.'</a> ('.date("Y", strtotime($filme->release_date)).')</p>
            </div>
        </div>
            ';
	            
	            
	        }
	        echo '</div>';
	    }else if(isset($_GET['id'])){
	        
	        $movieId = $_GET['id'];
	        $url = 'https://api.themoviedb.org/3/movie/'.$movieId.'?api_key=34a4cf2512e61f46648b95e4b7a3ec9b&language=pt-Br';
	        
	        $ch = curl_init($url);
	        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	        $filme = json_decode(curl_exec($ch));
	        //print_r($filme);
	        
	        
	        
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
                <div class="transparente p-5 text-white bg-dark rounded-3">';
// 	        $this->add();
	        echo '
                  <h2>'.$filme->original_title.'</h2>
                  <p>'.$filme->overview.'</p>
                  <button class="btn btn-outline-light" type="button" data-bs-toggle="modal" data-bs-target="#modalFavoritar">Favoritar</button>';
	        $movie = new Movie();
	        $movie->setId($movieId);
	        $lista = $this->dao->fetchById($movie);
	        if(count($lista) > 0){
	            $movie = $lista[0];
	            
	            if($movie->getMovieFilePath() != ""){
	                echo '
                  <button class="btn btn-outline-light" type="button"  data-bs-toggle="modal" data-bs-target="#modalAssistir">Assistir</button>



';
	            }
	            if($movie->getTorrentLink() != ""){
	                echo '
                  <a href="" class="btn btn-outline-light" type="button">Torrent</a>';
	            }
	            
	        }
	        
	        echo '
                      
                </div>
              </div>
                      
            </div>
                      
          </div>
      </div>
                      
                      
                      
      


<!-- Modal -->
<div class="modal fade" id="modalAssistir" tabindex="-1" aria-labelledby="modalAssistirLabel" aria-hidden="true">
  <div class="modal-dialog modal-fullscreen">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalAssistirLabel">Modal title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <video id="video" controls preload="metadata">
           <source src="../../filmes/'.$movie->getMovieFilePath().'" type="video/mp4">
           <source src="video/sintel-short.webm" type="video/webm">
           <track label="English" kind="subtitles" srclang="pt" src="captions/vtt/sintel-en.vtt" default>
           <track label="Deutsch" kind="subtitles" srclang="de" src="captions/vtt/sintel-de.vtt">
           <track label="Español" kind="subtitles" srclang="es" src="captions/vtt/sintel-es.vtt">
        </video>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
      
                      
  ';
	        
// 	        $this->view->showInsertForm2($movie);

	        
	    }else{
	        
	        
	        echo '<div class="row d-flex justify-content-center">';
	        
	        
	        $movieDao = new MovieDAO();
	        $filmes = $movieDao->fetch();
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
          <p><a href="?id='.$filme->id.'">'.$filme->original_title.'</a> ('.date("Y", strtotime($filme->release_date)).')</p>
          </div>
      </div>
          ';
	            
	            
	        }
	        echo '</div>';
	        
	    }
	    
	    
	    
	}
	public function add(){
	    if(!isset($_POST['enviar_movie'])){
	        return;
	    }
	    if (! isset ( $_POST ['id'] )) {
	        echo '
                <div class="alert alert-danger" role="alert">
                    Failed to register. Some field must be missing.
                </div>
	            
                ';
	        return;
	    }
	    
	    $movie = new Movie ();
	    $movie->setId($_POST['id']);
	    $lista = $this->dao->fetchById($movie);
	    
	    $movie->setId($_POST['id']);
	    $movie->setMovieFilePath ( $_POST ['movie_file_path'] );
	    $movie->setTorrentLink ( $_POST ['torrent_link'] );
	    $movie->setSubtitleBrPath ( $_POST ['subtitle_br_path'] );
	    
	    if(count($lista) != 0){
	        
	        if ($this->dao->update($movie ))
	        {
	            echo '
	                
<div class="alert alert-success" role="alert">
  Sucesso ao inserir Movie
</div>
	                
';
	        } else {
	            echo '
	                
<div class="alert alert-danger" role="alert">
  Falha ao tentar Inserir Movie
</div>
	                
';
	        }
	    }else{
	        
	        if ($this->dao->insertWithPK($movie ))
	        {
	            echo '
	                
<div class="alert alert-success" role="alert">
  Sucesso ao inserir Movie
</div>
	                
';
	        } else {
	            echo '
	                
<div class="alert alert-danger" role="alert">
  Falha ao tentar Inserir Movie
</div>
	                
';
	        }
	    }
	    
	    echo '<META HTTP-EQUIV="REFRESH" CONTENT="3; URL=index.php?page=movie">';
	}
	        
}
?>