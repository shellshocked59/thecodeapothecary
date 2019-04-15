var express = require('express');
var router = express.Router();
var controllers = require('../controllers/index.js');

/* GET home page. */
router.get('/', function(req, res, next) {
  controllers.home(req, res);
});

router.get('*', function(req, res, next) {
  controllers.default_route(req, res);
});

module.exports = router;
