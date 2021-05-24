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
	<meta charset="UTF-8">
  <style>
  html,body {
    padding:0;
    margin:0;
    width:100%;
    height:100%;
  }
  </style>
</head>
<body>
	
  <div id="video"></div>
  <script src="http://jwpsrv.com/library/v71rLsS8EeOxRSIACi0I_Q.js"></script>
  <script src="/dist/player.js"></script>
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
    $urlLocal = 'http://'. $_SERVER['HTTP_HOST'];
}


echo '
  <script type="text/javascript">
      jwplayer("video").setup({
        file: "'.$urlLocal.'/filmes/'.$movieFile->getFilePath().'",
        height: \'100%\',
        width: \'100%\'';
$arrCode = array();
foreach($subtitleList as $subtitle){
    $arrCode[] = '
        {
            "kind": "captions",
            "file": "'.$urlLocal.'/filmes/'.$subtitle->getFilePath().'",
            "label": "'.utf8_encode($subtitle->getLabel()).'"
        }
'; 
}

if(count($arrCode) > 0){
    echo ', "tracks": ['.implode(",", $arrCode).']';
}


echo '
      }

);

      var adapter = new playerjs.JWPlayerAdapter(jwplayer());

      jwplayer().onReady(function(){
        adapter.ready();
      });
  </script>';
?>

</body>
</html>