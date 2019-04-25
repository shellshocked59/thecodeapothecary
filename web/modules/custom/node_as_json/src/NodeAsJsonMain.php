<?php

namespace Drupal\node_as_json;



class NodeAsJsonMain {
  /**
   * returns as Drupal node object as a JSON-compatible object
   */
  public function getSimpleNodeObject($node){
    $json = $node->toArray();
    $json = $this->filterNodeToArray($json);

    return $json;
  }

  private function filterNodeToArray($json){
    foreach($json as $key=>$values){
      //blacklist some types ew dont care about
      if(!in_array($key, ['type', 'revision_uid', 'uid'])){
        //field is a reference field
        if(!empty($values[0]['target_id'])){
          if($key == 'field_paragraphs'){
            $data = $this->getReferencedFieldData($values, 'paragraph');
          }else{
            $data = $this->getReferencedFieldData($values, 'node');
          }
          $json[$key] = $data;
        }

        //remove internal/ from links
        if(!empty($values[0]['uri'])){
          foreach($values as $key2=>$value){
            $json[$key][$key2]['uri'] = str_replace('internal:', '', $value['uri']);
          }
        }
      }
    } 

    return $json;
  }

  private function getReferencedFieldData($values, $type){
    $data = [];
    if(!empty($values)){
      
      foreach($values as $key=>$value){
        if($type == 'paragraph'){
          $reference = \Drupal\paragraphs\Entity\Paragraph::load($value['target_id'], $value['target_revision_id']);
        }else{
          $reference = node_load($value['target_id'], $value['target_revision_id']);
        }

        if(!empty($reference)){
          $data[$key] = $this->filterNodeToArray($reference->toArray());
        }
      }
      
    }

    return $data;
  }

  function getPublishedNode($nid){
  	return $this->getSimpleNodeObject(node_load($nid));
  }
  function getUnpublishedNode($nid){
  	//TODO Get most unpublished version
  	return $this->getSimpleNodeObject(node_load($nid));
  }
}
