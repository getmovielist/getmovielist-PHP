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
    if($_SERVER['HTTP_HOST'] == 'getmovielist.com'){
        $urlLocal = 'http://getmovielist.ddns.net:888';
    }else if($_SERVER['HTTP_HOST'] == 'getmovielist.ddns.net:888'
        || $_SERVER['HTTP_HOST'] == 'localhost:888' || $_SERVER['HTTP_HOST'] == '192.168.0.10:888')
    {
        $urlLocal = "";
    }
    echo '
<source src="'.$urlLocal.'/filmes/The.Untouchables.1987.1080p.BrRip.x264.BOKUTOX.YIFY.mp4" type=\'video/mp4\' />
 <track kind="captions" label="Português" srclang="pt" src="'.$urlLocal.'/filmes/subtitles/vtt/The.Untouchables.1987.1080p.BluRay.DTS-ES.x264-CtrlHD.vtt">';

    
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