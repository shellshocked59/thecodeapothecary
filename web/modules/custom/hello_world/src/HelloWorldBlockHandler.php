<?php
namespace Drupal\hello_world;

use \Drupal\Core\Url;

Class HelloWorldBlockHandler{
  function getHelloworldBlock($debug = false){
    if($debug) $start = microtime(true);

    $markup = $this->getHelloworldBlockMarkup($this->getHelloworldBlockData());
  
    if($debug){
      $end = microtime(true);
      $markup .= 'Time took: '.($end - $start);
    }

    return $markup;
  }


  //A list of hyperlinked titles to all nodes that are of Hello World Article type, and are tagged with "Enabled" terms from the Sections vocabulary, should appear below the "Hello World!" text on Hello World Article pages.
  function getHelloworldBlockData(){
    //get all nodes in content type
    $nids = \Drupal::entityQuery('node')
      ->condition('type', 'hello_world_article', '=')
      ->sort('created', 'DESC')
      ->execute();

     //get all valid tags in taxonomy
     $valid_tags = [];
     $terms =\Drupal::entityTypeManager()->getStorage('taxonomy_term')->loadTree('sections');
     foreach($terms as $term){
      //tricky tricky. almost got me with the enabled requirement. $term->status doesn't work for it
      $full_term = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->load($term->tid);
    $enabled = $full_term->field_enabled->value;
      if($enabled){
        $valid_tags[] = $term->tid;
      }
     }


    $render_data = [];
    foreach($nids as $nid){
      $node = \Drupal\node\Entity\Node::load($nid);

      //test to see if node has a valid enabled tag in field_sections
      $valid = false;
      foreach($node->get('field_sections')->getValue() as $section_id){
        if(in_array($section_id['target_id'], $valid_tags)){
          $valid = true;
          break;
        }
      }

    //create array of valid nodes 
      if($valid){
        $render_data[] = [
          'title' => $node->getTitle(),
          'nid' => $node->id(),
          'url' => \Drupal::service('path.alias_manager')->getAliasByPath('/node/'.$node->id())
        ];
      }
    }

    return $render_data;
  }

  function getHelloworldBlockMarkup($render_data){
    //create markup html from render data
    $markup = '<ul>';
    foreach($render_data as $row){
      $markup .= '<li><a href="'.$row['url'].'">'.$row['title'].'</a></li>';
    }
    $markup .= '</ul>';

    return $markup;
  }
}