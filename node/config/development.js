exports.get_settings = function(){
	var settings = {};
	settings.PORT = '3000';
	settings.ENDPOINT = 'http://www.thecodeapothecary.com:8080/';
	settings.ENDPOINT_PORT = '80';
	settings.SITE_KEY = 'tca';

	return settings;
}