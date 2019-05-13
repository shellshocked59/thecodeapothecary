var express = require('express');
var router = express.Router();
var controllers = require('../controllers/index.js');

/* GET home page. */
router.get('/', function(req, res, next) {
  controllers.home(req, res);
});

/* sitemap.xml */
router.get('/sitemap', function(req, res, next) {
  res.redirect('/sitemap.xml');
});
router.get('/sitemap.xml', function(req, res, next) {
  controllers.sitemap(req, res);
});

/* robots.txt */
router.get('/robots', function(req, res, next) {
  res.redirect('/robots.txt');
});
router.get('/robots.txt', function(req, res, next) {
  controllers.robots(req, res);
});

/* default pages from json */
router.get('*', function(req, res, next) {
  controllers.default_route(req, res);
});

module.exports = router;
