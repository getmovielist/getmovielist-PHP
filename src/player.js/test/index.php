<?php 
define("DB_INI", "../../../getmovielist_db.ini");
define("API_INI", "../../../getmovielist_api_rest.ini");

function autoload($classe) {
    
    $prefix = 'getmovielist';
    $base_dir = '../../getmovielist';
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
use getmovielist\model\Movie;
use getmovielist\dao\MovieFileDAO;
use getmovielist\model\MovieFile;
use getmovielist\custom\dao\MovieFileCustomDAO;
use getmovielist\custom\dao\SubtitleCustomDAO;
use getmovielist\model\Subtitle;


$sessao = new Sessao();

if($sessao->getNivelAcesso() != Sessao::NIVEL_ADM && $sessao->getNivelAcesso() != Sessao::NIVEL_PRIVILEGIADO){
    return;
}
if(!isset($_GET['player'])){
    return;
}


?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <link href="//vjs.zencdn.net/4.2/video-js.css" rel="stylesheet">
</head>
<body>
  <video id="video" class="video-js vjs-default-skin"
    controls preload="auto">
    <?php 
    
    $movie = new Movie();
    $movie->setId($_GET['player']);
    $movieFileDao = new MovieFileDAO();
    $movieFile = new MovieFile();
    $movieFile->getMovie()->setId($movie->getId());
    $lista = $movieFileDao->fetchByMovie($movieFile);
    if(count($lista) == 0){
        return;
    }
    
    $movieFile = new MovieFile();
    $movieFile->getMovie()->setId($movie->getId());
    $movieFileDao = new MovieFileCustomDAO($movieFileDao->getConnection());
    $listaMovieFiles = $movieFileDao->fetchByMovie($movieFile);
    
    if(count($lista) == 0){
        return;
    }
    $subtitleDao = new SubtitleCustomDAO($movieFileDao->getConnection());
    $movieFile = null;
    foreach($listaMovieFiles as $movieFile){
        
        $subtitle = new Subtitle();
        $subtitle->getMovieFile()->setId($movieFile->getId());
        $subtitleList = $subtitleDao->fetchByMovieFile($subtitle);
        break;
    }
    
    if($_SERVER['HTTP_HOST'] == 'getmovielist.com'){
        $urlLocal = 'http://getmovielist.ddns.net:888';
    }else if($_SERVER['HTTP_HOST'] == 'getmovielist.ddns.net:888'
        || $_SERVER['HTTP_HOST'] == 'localhost:888' || $_SERVER['HTTP_HOST'] == '192.168.0.10:888')
    {
        $urlLocal = "";
    }
    echo '
<source src="'.$urlLocal.'/filmes/'.$movieFile->getFilePath().'" type=\'video/mp4\' />
<track kind="captions" label="Portugues" srclang="pt" src="'.$urlLocal.'/filmes/subtitles/vtt/The.Untouchables.1987.1080p.BluRay.DTS-ES.x264-CtrlHD.vtt">
';
    
    ?>
   
  </video>
  <script src="//vjs.zencdn.net/4.2/video.js"></script>
  <script src="/dist/player.js"></script>
  <script>
    videojs("video", {}, function(){
      var adapter = playerjs.VideoJSAdapter(this);

      adapter.ready();
    });
  </script>
</body>
</html>