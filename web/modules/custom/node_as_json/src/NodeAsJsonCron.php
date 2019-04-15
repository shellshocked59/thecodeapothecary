<?php

namespace Drupal\node_as_json;


class NodeAsJsonCron {
  public function cronjob(){
    $nids = \Drupal::entityQuery('node')
      ->condition('type', get_node_type_whitelist(), 'IN')
      ->execute();

    //for each node, write a JSON file
    $file_creator = \Drupal::service('node_as_json.file_manager');
    foreach($nids as $nid){
      $file_creator->createFilesForNID($nid);
    }
  }
}
