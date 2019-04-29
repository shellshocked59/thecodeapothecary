//initialize redis
exports.get_settings = function(){
	var env = (process.env.NODE_ENV || 'development');
	var env_config = require('../config/'+env);
	return env_config.get_settings();
}
