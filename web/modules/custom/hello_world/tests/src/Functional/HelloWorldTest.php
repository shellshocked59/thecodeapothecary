<?php

namespace Drupal\Tests\hello_world\Functional;

use Drupal\Tests\BrowserTestBase;
use Drupal\taxonomy\Entity\Term;
use Drupal\taxonomy\Entity\Vocabulary;

/**
 * Tests Mediacurrent Hello World
 * https://www.drupal.org/docs/8/phpunit/phpunit-browser-test-tutorial
 * php core/scripts/run-tests.sh hello_world
 * https://www.lullabot.com/articles/an-overview-of-testing-in-drupal-8
 *
 * @group hello_world
 */
class HelloWorldTest extends BrowserTestBase {
	protected static $modules = ['hello_world', 'node', 'path', 'menu_ui', 'content_type_vocab_hello_world'];

	protected $test_url = '';

	public function setUp() {
	    parent::setUp();

	    $this->createTestContent();
	 }

	 /** 
	  * Create test content as per requirements to run tests against it
	  */
	 protected function createTestContent(){
	 	$this->hello_world_block_class = \Drupal::service('hello_world.block_handler');

	 	//set default theme to bartik
	 	\Drupal::service('theme_installer')->install(['bartik']);
		$theme_config = \Drupal::configFactory()->getEditable('system.theme');
		$theme_config->set('default', 'bartik');
		$theme_config->save();


	 	$vid = 'sections';

	    $terms = [];
	    $term = Term::create([
	      'name' => 'About Us',
	      'vid' => 'sections',
	    ]);
	    $term->save();
	    $terms['about'] = $term->id();
	    
	    $term = Term::create([
	      'name' => 'Disabled',
	      'vid' => 'sections',
	      'field_enabled' => 0,
	      'status' => 0,
	    ]);
	    $term->save();
	    $terms['disabled'] = $term->id();

	    $term = Term::create([
	      'name' => 'Misc',
	      'vid' => 'sections',
	    ]);
	    $term->save();
	    $terms['misc'] = $term->id();

	    $term = Term::create([
	      'name' => 'News',
	      'vid' => 'sections',
	    ]);
	    $term->save();
	    $terms['news'] = $term->id();
	    $this->terms = $terms;

	    // Create test content
	    $this->test_nodes = [];

	    //no_tags
	    $node = $this->drupalCreateNode([
	        'type' => 'hello_world_article',
	        'name' => 'No Tags Test',
	     ]);
	    $node->save();
	    $this->test_nodes['no_tags'] = $node->id();

	    //disabled
	    $node = $this->drupalCreateNode([
	        'type' => 'hello_world_article',
	        'name' => 'Disabled Tag Test',
	        'field_sections' => [$this->terms['disabled']],
	     ]);
	    $node->save();
	    $this->test_nodes['disabled'] = $node->id();

	    //about
	    $node = $this->drupalCreateNode([
	        'type' => 'hello_world_article',
	        'name' => 'About Us',
	        'field_sections' => [$this->terms['about']],
	     ]);
	    $node->save();
	    $this->test_nodes['about'] = $node->id();

	    //news
	    $node = $this->drupalCreateNode([
	        'type' => 'hello_world_article',
	        'name' => 'News 1',
	        'field_sections' => [$this->terms['news']],
	     ]);
	    $node->save();
	    $this->test_nodes['news'] = $node->id();

	    //misc
	    $node = $this->drupalCreateNode([
	        'type' => 'hello_world_article',
	        'name' => 'Misc',
	        'field_sections' => [$this->terms['misc']],
	     ]);
	    $node->save();
	    $this->test_nodes['misc'] = $node->id();

	    //misc
	    $node = $this->drupalCreateNode([
	        'type' => 'page',
	        'name' => 'Page',
	     ]);
	    $node->save();
	    $this->test_nodes['page'] = $node->id();

	    $this->container->get('router.builder')->rebuild();
	    node_access_rebuild();
	 }

	 public function test(){
		$this->assertNotEqual($this->terms, null);
		$this->assertNotEqual($this->test_nodes, null);

	 	$this->testFirstRequirement();
	 	$this->testSecondRequirement();
	 	$this->testThirdRequirement();
	 	$this->testFourthRequirement();
	 	$this->testFifthRequirement();
	 	$this->testSixthRequirement();

	 	$this->assertEqual(1, 1);
	 }

	 /*
	  * The text "Hello World!" should appear in bold typeface within a block on the right side of all Hello World Article pages only.
	  */
	 protected function testFirstRequirement(){
	 	//TODO, could get the page's html and test that the content exists
	 	//$alias = 'node/'.$this->test_nodes['news'];
		//$this->drupalGet($alias);
		//$this->assertSession()->statusCodeEquals('200');
		//$this->assertSession()->pageTextContains('Hello World!', 'Sidebar Exists');	 	
	 }

	 /*
	  * A list of hyperlinked titles to all nodes that are of Hello World Article type, and are tagged with "Enabled" terms from the Sections vocabulary, should appear below the "Hello World!" text on Hello World Article pages.
	  */
	 protected function testSecondRequirement(){
	 	$data = $this->hello_world_block_class->getHelloworldBlockData();

	 	$whitelist = [$this->test_nodes['about'], $this->test_nodes['news'], $this->test_nodes['misc']];
	 	$blacklist = [$this->test_nodes['disabled'], $this->test_nodes['no_tags']];
	 	foreach($data as $row){
	 		$this->assertFalse((in_array($row['nid'], $blacklist)), 'Blacklisted item appears in hello world block');
	 		$this->assertTrue((in_array($row['nid'], $whitelist)), 'Whitelisted item appears in hello world block');
	 	}
	 	
	 }

	 /*
	  * When viewing a Hello World Article on the Drupal site, the phrase "Content starts here!" should appear in an italic typeface as the first line of content on the page.
	  */
	 protected function testThirdRequirement(){
	 	//verify that hello_world_preprocess_node gives back the hello_world field when given an appropriate node
	 	$variables = [];
	 	$variables['node'] = \Drupal\node\Entity\Node::load($this->test_nodes['about']);
	 	hello_world_preprocess_node($variables);
	 	$this->assertEqual($variables['content']['hello_world'][0]['#text'], '<span style="italic">Content starts here!</span>');

	 	//now check for inappropriate node
	 	$variables = [];
	 	$variables['node'] = \Drupal\node\Entity\Node::load($this->test_nodes['page']);
	 	hello_world_preprocess_node($variables);
	 	$this->assertTrue(empty($variables['content']['hello_world']));


	 	//TODO, could get the page's html and test that the content exists
	 	//$alias = 'node/'.$this->test_nodes['news'];
		//$this->drupalGet($alias);
		//$this->assertSession()->statusCodeEquals('200');
		//$this->assertSession()->pageTextContains('Content starts here!', 'Content starts here! exists');
	 }

	 /*
	  * All of this functionality needs to be contained in one Drupal module. The only module's dependencies should be Drupal core modules and the content_type_vocab_hello_world module. 
	  */
	 protected function testFourthRequirement(){
	 	//TODO, could get the module's requirements from the info.yml file and see what it requires
	 }

	 /*
	  * Additionally, the Views module cannot be used for this exercise.
	  */
	 protected function testFifthRequirement(){
	 	//TODO, could search the entire hello_world module for instances of "views", though it'd likely return false positives
	 }

	 /*
	  * Name the module "hello_world" and use bartik
	  */
	 protected function testSixthRequirement(){
	 	//check if bartik is being used
	 	$theme = \Drupal::service('theme_handler')->getDefault();
	 	$this->assertEqual($theme, 'bartik', 'Bartik is the default theme');

	 	$test = \Drupal::moduleHandler()->moduleExists('hello_world');
	 	$this->assertTrue($test, 'Hello world module is enabled');
	 }
}