var redis_model = require('../models/redis');

exports.home = function(req, res) {
	let header_footer_data = this.get_header_footer_data();
	let json_data = redis_model.get_json_node('/home');
	let metadata = this.getMetadata(json_data, header_footer_data);
    res.render('index', { 
    	header_footer: header_footer_data, 
    	title: json_data['title'][0]['value'], 
    	description: json_data['field_meta_description'][0]['value'],
    	json_data: json_data,
    	metadata: metadata
    });
}

exports.default_route = function(req, res) {
	let header_footer_data = this.get_header_footer_data();
	let json_data = redis_model.get_json_node(req.path);
	let metadata = this.getMetadata(json_data, header_footer_data);
	if(json_data != undefined){
		res.render('index', { 
			header_footer: header_footer_data, 
			title: json_data['title'][0]['value'], 
			description: json_data['field_meta_description'][0]['value'],
			json_data: json_data,
			metadata: metadata
		});
	}else{
		res.send(404);
	}
}

exports.sitemap = function(req, res) {
	let json_data = redis_model.get_json_listing_var();

	//global site data
	let site_data = {};
	site_data.name = json_data.title[0]['value'];//title
	site_data.base_url = 'http://'+json_data.field_primary_domain[0]['value'];

	//build our URLs
	let sitemap_data = new Array();
	for (let path in json_data.published_nodes){
		let node = json_data.published_nodes[path];
		let priority = '0.9';

		//home
		if(path == '/home'){
			path = '/';
			priority = '1.0';
		}

		//dont include test
		if(path == '/test'){
			continue;
		}

		let sitemap_row = {};
		sitemap_row.changefreq = 'always';
		sitemap_row.loc = site_data.base_url + path;
		sitemap_row.priority = priority;
		
		sitemap_data.push(sitemap_row);
	}


    res.render('sitemap', { 
    	json_data: json_data,
    	sitemap_data: sitemap_data,
    	site_data: site_data
    });
}

exports.robots = function(req, res) {
	let json_data = redis_model.get_json_listing_var();

	//global site data
	let site_data = {};
	site_data.name = json_data.title[0]['value'];//title
	site_data.base_url = 'http://'+json_data.field_primary_domain[0]['value'];

	//TODO make dynamic
	let prod = true;

	res.type('text/plain');
    res.render('robots', { 
    	json_data: json_data,
    	site_data: site_data,
    	prod: prod
    });
}

exports.get_header_footer_data = function(req, res) {
	let header = redis_model.get_json_key('field_header_links');
	let footer = redis_model.get_json_key('field_footer_links');

	return {
		'header': header, 
		'footer': footer,
		'site_title': redis_model.get_json_key('title')[0]['value'],
		'site_subtitle':redis_model.get_json_key('field_tagline')[0]['value'],
		'site_copyright':redis_model.get_json_key('field_copyright')[0]['value'],
		'site_domain': redis_model.get_json_key('field_primary_domain')[0]['value'],
	};
}

exports.getMetadata = function(json_data, header_footer_data) {
	let site_domain = 'http://' + header_footer_data.site_domain;
	let path = json_data.path[0]['alias'];
	if(path == '/home'){
		path = '';
	}
	return {
		'robots': 'follow, index',
		'url': site_domain + path, 
		'title': json_data.title[0]['value'],
		'description': json_data.field_meta_description[0]['value'],
		'site_title': header_footer_data.site_title,
		'site_domain': site_domain,
		'site_copyright': header_footer_data.site_copyright,
	};
}