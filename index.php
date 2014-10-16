<html>
    <head>
        <meta charset="UTF-8">
        <title>Teste</title>
        <script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
        <style>
            #playlist,audio{background:#CCC;width:400px;padding:10px;}
            .active a{color:#6c4397;text-decoration:none;}
            ol{padding-left: 15px;}
            a{color:#eeeedd;background:#000;padding:5px;display:block;text-decoration:none;}
            ul li{list-style: none}
            a:hover{text-decoration:none;}
        </style>

        <script>
            var audio;
            var playlist;
            var tracks;
            var current;
            
            function init() {
                current = 0;
                audio = $('#audio');
                playlist = $('#playlist');
                tracks = playlist.find('li a');
                len = tracks.length - 1;
                audio[0].volume = .10;
                audio[0].play();
                playlist.find('a').click(function(e) {
                    e.preventDefault();
                    link = $(this);
                    current = link.parent().index();
                    run(link, audio[0]);
                });
                audio[0].addEventListener('ended', function(e) {
                    current++;
                    if (current == len) {
                        current = 0;
                        link = playlist.find('a')[0];
                    } else {
                        link = playlist.find('a')[current];
                    }
                    run($(link), audio[0]);
                });
            }
            function run(link, player) {
                player.src = link.attr('href');
                
                par = link.parent();
                par.addClass('active').siblings().removeClass('active');
                audio[0].load();
                audio[0].play();
            }

            $("#audio").bind('ended', function() {
                // done playing
                alert("Player stopped");
            });
            
           $(document).ready(function(){              
                  $(".active2").each(function(){
                      $(this).next().toggle();     
                  });
              });
        </script>
    </head>

    <body>
        <audio id="audio" preload="auto" tabindex="0" controls="" >
            <source src="mus/felguk - looney tunes (original mix).mp3">
        </audio>
        <ul id="playlist">
            <?php
            $cont = 0;
            $diretorio = getcwd();
            $ponteiro = opendir($diretorio . "/mus/");
            while ($nome_itens = readdir($ponteiro)) {
                $itens[] = $nome_itens;
            }

            sort($itens);

            foreach ($itens as $listar) {
                if ($listar != "." && $listar != "..") {
                    if (is_dir($listar)) {
                        $pastas[] = $listar;
                    } else {
                        $arquivos[] = $listar;
                    }
                }
            }

            if ($arquivos != "") {
                foreach ($arquivos as $listar) {
                    $ex = explode(".", $listar);
                    if (count($ex) == 1) {
                        ?>
            <span style="float:left;">+</span><li class="active2" style="margin-left: 25px;" onclick='$(this).next().toggle(); if($(this).prev().text() == "-"){ $(this).prev().text("+"); }else{$(this).prev().text("-"); } '><?=$listar; ?></li>
            <ol>
                        <?php
                        $diretorio2 = getcwd();
                        $ponteiro2 = opendir($diretorio2 . "/mus/" . $listar);
                        $itens2 = '';
                        $nome_itens2 ='';
                        $listar2 = '';
                        $arquivos2 = '';
                        while ($nome_itens2 = readdir($ponteiro2)) {
                            $itens2[] = $nome_itens2;
                        }

                        sort($itens2);
                        
                        foreach ($itens2 as $listar2) {
                            if ($listar2 != "." && $listar2 != "..") {
                                if (is_dir($listar2)) {
                                    $pastas2[] = $listar2;
                                    echo $listar2;
                                } else {
                                    $arquivos2[] = $listar2;
                                }
                            }
                        }

                        foreach ($arquivos2 as $listar2) {
                            $ex2 = explode(".mp3", $listar2);
                            if (count($ex2) == 2) {
                                $cont++;
                                ?>
                                <li class="active" id="mus<?=$cont; ?>">
                                    <a href="mus/<?=$listar; ?>/<?=$listar2; ?>"><?=$listar2; ?></a>
                                </li>
                                <?php
                            } 
                        }
                    }?></ol><?php
                }
                ?><li class="active2"> ---------- </li><?php
                foreach ($arquivos as $listar) {
                    $ex = explode(".mp3", $listar);
                    if (count($ex) == 2) {
                        $cont++;
                        ?>
                        <li class="active" id="mus<?=$cont; ?>">
                            <a href="mus/<?=$listar; ?>"><?=$listar; ?></a>
                        </li>
                        <?php
                    } 
                }
            }
            ?>



        </ul>
    </body>
    <script>
        init();
    </script>

</html>