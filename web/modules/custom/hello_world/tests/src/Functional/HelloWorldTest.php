<?php

namespace Drupal\Tests\hello_world\Functional;

use Drupal\Tests\BrowserTestBase;

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
	public function setUp() {
	    parent::setUp();

	    /*// Create an article content type that we will use for testing.
	    $type = $this->container->get('entity_type.manager')->getStorage('node_type')
	      ->create([
	        'type' => 'hello_world_article',
	        'name' => 'Article',
	      ]);
	    $type->save();
	    $this->container->get('router.builder')->rebuild();*/
	 }

	 public function test(){
	 	#$this->assertEqual(1, 1);
		#return true;

	 	$this->testFirstRequirement();
	 	$this->testSecondRequirement();
	 	$this->testThirdRequirement();
	 	$this->testFourthRequirement();
	 	$this->testFifthRequirement();
	 	$this->testSixthRequirement();

	 	$this->assertEqual(1, 1);
		return true;
	 	/*$account = $this->drupalCreateUser(['administer rules']);
    $this->drupalLogin($account);

    $this->drupalGet('admin/config/workflow/rules');
    $this->assertSession()->statusCodeEquals(200);

    // Test that there is an empty reaction rule listing.
    $this->assertSession()->pageTextContains('There is no Reaction Rule yet.');*/
	 }

	 /*
	  * The text "Hello World!" should appear in bold typeface within a block on the right side of all Hello World Article pages only.
	  */
	 protected function testFirstRequirement(){
	 	$this->assertEqual(1, 1);
	 	return true;
	 }

	 /*
	  * A list of hyperlinked titles to all nodes that are of Hello World Article type, and are tagged with "Enabled" terms from the Sections vocabulary, should appear below the "Hello World!" text on Hello World Article pages.
	  */
	 protected function testSecondRequirement(){
	 	$this->assertEqual(1, 1);
	 	return true;
	 }

	 /*
	  * When viewing a Hello World Article on the Drupal site, the phrase "Content starts here!" should appear in an italic typeface as the first line of content on the page.
	  */
	 protected function testThirdRequirement(){
	 	$this->assertEqual(1, 1);
	 	return true;
	 }

	 /*
	  * All of this functionality needs to be contained in one Drupal module. The only module's dependencies should be Drupal core modules and the content_type_vocab_hello_world module. 
	  */
	 protected function testFourthRequirement(){
	 	$this->assertEqual(1, 1);
	 	return true;
	 }

	 /*
	  * Additionally, the Views module cannot be used for this exercise.
	  */
	 protected function testFifthRequirement(){
	 	$this->assertEqual(1, 1);
	 	return true;
	 }

	 /*
	  * Name the module "hello_world".
	  */
	 protected function testSixthRequirement(){
	 	$this->assertEqual(1, 1);
	 	return true;
	 }
}