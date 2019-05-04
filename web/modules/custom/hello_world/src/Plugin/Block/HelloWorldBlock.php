<?php

namespace Drupal\hello_world\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use \Drupal\Core\Url;

/**
 * Provides a 'Hello' Block.
 *
 * @Block(
 *   id = "hello_world_block",
 *   admin_label = @Translation("Hello World!"),
 *   category = @Translation("Hello World!"),
 * )
 */
class HelloWorldBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
  	$return = [
  		'#cache' => [
  			'max-age' => 0,
  		],
  	];
  	if(\Drupal::routeMatch()->getParameter('node')){
	  	$node_id = \Drupal::routeMatch()->getParameter('node')->Id();
	  	
	  	if(!empty($node_id)){
	  		$node = node_load($node_id);
	  		if($node->bundle() == 'hello_world_article'){

	  			$markup = 'hello_world_article';
	  			$return['#markup'] = \Drupal::service('hello_world.block_handler')->getHelloworldBlock();
	  			$return['#title'] = $this->t('<span style="font-weight:700">Hello World!</span>');

	  		}
	  	}
	  }
    return $return;
  }
}