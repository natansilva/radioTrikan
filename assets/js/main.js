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
		var allData = data.instance._model.data;
		var musics = [];

		if(allData){
			$.each(allData, function(id, obj){
				if(id.indexOf("child") == 0){
					musics.push(obj);
				}
			})
		}

		if(musics.length){
			player.setMusics(musics);
			player.init();
		}
	})
});

var player = (function(){
	var module = {
		$player: null,
		$source: null,
		musics: null,
		init: function(){
			module.$source = $('#source');
			module.$player = $('#player');
			module.play();	
		},
		setMusics: function(musics){
			module.musics = musics;
		},
		play: function(){
			//console.log(module.musics[0]['a_attr'].href);
			module.selectMusic(module.musics[0]);
		},
		selectMusic: function(element){
			console.log(element['a_attr'].href);
			module.$source.attr("src", 'rest/' + element['a_attr'].href);
        	module.$player.load();
        	console.log(module.$player);
        	//module.$player.play();
		}
	}

	return {
		init: module.init,
		setMusics: module.setMusics
	}

}());