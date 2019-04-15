<?php

namespace Drupal\node_as_json;



class NodeAsJsonMain {
  /**
   * returns as Drupal node object as a JSON-compatible object
   */
  public function getSimpleNodeObject($node){
    $json = $node->toArray();

    //TODO should really do this another way
    if(!empty($json['field_paragraphs'])){
      $data = [];
      foreach($json['field_paragraphs'] as $key=>$value){
        $paragraph = \Drupal\paragraphs\Entity\Paragraph::load($value['target_id'], $value['target_revision_id']);
        $data[$key] = $paragraph->toArray();
      }
      
      $json['field_paragraphs'] = $data;
    }

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
