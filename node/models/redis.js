//initialize redis
var redis = require("redis");
var client = redis.createClient();
client.on("error", function (err) {
    console.log("Error " + err);
});

//make redis asynch using bluebird
var bluebird = require("bluebird");
bluebird.promisifyAll(redis.RedisClient.prototype);
bluebird.promisifyAll(redis.Multi.prototype);
//also make promise and request use bluebird
var Promise = require("bluebird");
var request = Promise.promisify(require("request"));


//get json_data from redis and store as a variable
var json_listing = {};
var json_nodes = {};
var is_json_ready = 0;

//drupal configuration
var drupal_base_url = 'http://ericcms:80/';
var drupal_options = {
    port: '80',
    method: 'GET',
}

exports.get_json_listing = function(){
	return json_listing;
}
exports.get_json_key = function(key){
	return json_listing[key];
}
exports.get_json_node = function(key){
	return json_nodes[key];
}
exports.get_ready = function(){
	return is_json_ready;
}


/*exports.set_json_data_from_redis = function(){
	client.get('all_json', function (err, reply) {
		if(reply){
	    	json_data = reply.toString();
	    }else{
	    	console.log('reply from redis could not be read');
	    }
	});
}*/

exports.initialize = function(){
	this.get_json_listing();
	//this.set_json_data_to_redis();
}

exports.get_json_listing = function(){
	var options = drupal_options;
	options.uri = drupal_base_url + 'nodes_as_json/published';
	let set_json_files = this.set_json_files;

	request(options, function(error, response, body){
	    if(error){
	    	console.log(error);
		}else{
			json_listing = JSON.parse(body);
			set_json_files();
	    }
	});
}

exports.set_json_files = function(){
	var options = drupal_options;

	for (let key in json_listing.published_nodes){
		options.uri = drupal_base_url + json_listing.published_nodes[key];

		request(options, function(error, response, body){
		    if(error){
		    	console.log(error);
			}else{
				json_nodes[key] = JSON.parse(body);
		    }
		});

		//TODO this might not be fully asynch
		//could rewrite as a test of listing vs loaded files instead
		is_json_ready = 1;
	}	
}