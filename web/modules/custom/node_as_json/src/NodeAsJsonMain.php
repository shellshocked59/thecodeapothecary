<?php

namespace Drupal\node_as_json;



class NodeAsJsonMain {
  /**
   * returns as Drupal node object as a JSON-compatible object
   */
  public function getSimpleNodeObject($node){
    $json = $node->toArray();
    return $json;
  }

  function getPublishedNode($nid){
  	return $this->getSimpleNodeObject(node_load($nid));
  }
  function getUnpublishedNode($nid){
  	//TODO Get most unpublished version
  	return $this->getSimpleNodeObject(node_load($nid));
  }
}
