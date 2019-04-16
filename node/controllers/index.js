var redis_model = require('../models/redis');

exports.home = function(req, res) {
	let header_footer_data = this.get_header_footer_data();
	let json_data = redis_model.get_json_node('/home');
    res.render('index', { 
    	header_footer: header_footer_data, 
    	title: json_data['title'][0]['value'], 
    	json_data: json_data 
    });
}

exports.default_route = function(req, res) {
	let header_footer_data = this.get_header_footer_data();
	let json_data = redis_model.get_json_node(req.path);
	if(json_data != undefined){
		res.render('index', { 
			header_footer: header_footer_data, 
			title: json_data['title'][0]['value'], 
			json_data: json_data 
		});
	}else{
		res.send(404);
	}
}


exports.get_header_footer_data = function(req, res) {
	let header = redis_model.get_json_key('header');
	let footer = redis_model.get_json_key('footer');

	return {'header': header, 'footer': footer};
}