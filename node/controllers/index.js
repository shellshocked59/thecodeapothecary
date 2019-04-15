var redis_model = require('../models/redis');

exports.home = function(req, res) {
	let json_data = redis_model.get_json_key('/home');
    res.render('index', { title: json_data['title'][0]['value'] });
}

exports.default_route = function(req, res) {
	let json_data = redis_model.get_json_key(req.path);
	if(json_data != undefined){
		res.render('index', { title: json_data['title'][0]['value'] });
	}else{
		res.send(404);
	}
}