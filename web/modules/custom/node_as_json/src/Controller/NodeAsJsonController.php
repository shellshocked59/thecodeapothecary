<?php

namespace Drupal\node_as_json\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;


/**
 * Returns responses for BigPipe module routes.
 */
class NodeAsJsonController {
  public function publishedShow(int $nid){
    //load the node
    $node = node_load($nid);

    //does node exist?
    if(empty($node)){
      return new JsonResponse(['status_code' => '403', 'message' => 'Provided node is not available']);
    }
    //is node published?
    elseif(!$node->isPublished()){
      return new JsonResponse(['status_code' => '403', 'message' => 'Provided node is not published']);
    }else{
      //get the node, render it as JSON
      $main = \Drupal::service('node_as_json.main');
      $json = $main->getSimpleNodeObject($node);
      $json['status_code'] = '200';

      return new JsonResponse($json);
    }
  }

  
}
