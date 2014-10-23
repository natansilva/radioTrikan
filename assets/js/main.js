$(function(){

	var $playlist = $("#playlist");
	var $search = $('#query_search');

	$playlist.jstree({ 'core' : 
		{
	    	'data' : {
	    		'url' : function (node) {
			        return node.id === '#' ?
			          'rest/index.php/musics' : false;
			      },
				'data' : function (node) {
					return { 'id' : node.id };
				}
			}
		},
		"plugins" : [ "search" ]
	});

	var to = false;
	$('#query_search').keyup(function () {
		if(to) { clearTimeout(to); }
		to = setTimeout(function () {
			var v = $search.val();
			$playlist.jstree(true).search(v);
		}, 250);
	});

	$playlist.on("select_node.jstree", function (e, data) {
		$(this).jstree('toggle_node', data.selected[0]);
	});

	$playlist.on('ready.jstree', function (e, data) {
		//console.log(data.instance._model);
		//data.instance.redraw(true);
	})

	setTimeout(function(){
		//player.init();
	}, 5000);
});

// var player = (function(){
// 	var module = {
// 		player: null,
// 		$source: null,
// 		musics: null,
// 		init: function(){
// 			//module.play();	
// 		},
// 		play: function(){
// 			module.selectMusic(module.musics[0]);
// 		},
// 		selectMusic: function(element){
// 			//console.log('trocou: ' + element.attr("href"));
// 			//module.$source.attr("src", element.attr("href"));
//         	//module.player.load();
// 		}
// 	}

// 	return {
// 		init: module.init

// 	}

// }());