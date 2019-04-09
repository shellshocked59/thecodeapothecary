<?php

namespace Drupal\node_as_json;


class NodeAsJsonCron {
  public function cronjob(){
    //get all nodes that need to be updated
    $node_type_whitelist = [
      'page',
    ];

    $nids = \Drupal::entityQuery('node')
      ->condition('type', $node_type_whitelist, 'IN')
      ->execute();

    //for each node, write a JSON file
    $file_creator = \Drupal::service('node_as_json.file_manager');
    foreach($nids as $nid){
      $file_creator->createFilesForNID($nid);
    }
  }
}
