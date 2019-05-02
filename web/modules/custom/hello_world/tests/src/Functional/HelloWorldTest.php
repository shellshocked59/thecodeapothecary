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
	 	$this->assertEqual(1, 1);
	 	return true;
	 	/*$account = $this->drupalCreateUser(['administer rules']);
    $this->drupalLogin($account);

    $this->drupalGet('admin/config/workflow/rules');
    $this->assertSession()->statusCodeEquals(200);

    // Test that there is an empty reaction rule listing.
    $this->assertSession()->pageTextContains('There is no Reaction Rule yet.');*/
	 }
}