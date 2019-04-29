<?php

namespace Drupal\node_as_json;

use Drupal\Core\Url;



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
      //blacklist some types we dont care about
      if(!in_array($key, ['type', 'revision_uid', 'uid'])){
        //field is a reference field
        if(!empty($values[0]['target_id'])){
          if($key == 'field_paragraphs'){
            $data = $this->getReferencedFieldData($values, 'paragraph');
          }elseif(isset($values[0]['alt'])){
            //is image
            $data = $this->getReferencedFieldData($values, 'image');
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
    $is_drupal_object = true;
    if(!empty($values)){
      
      foreach($values as $key=>$value){
        if($type == 'paragraph'){
          $reference = \Drupal\paragraphs\Entity\Paragraph::load($value['target_id'], $value['target_revision_id']);
        }elseif($type == 'image'){
          $file = \Drupal\file\Entity\File::load($value['target_id']);
          //$values['uri'] = $file->getUri();
          $file_uri = $file->getFileUri();
          $url = file_create_url($file_uri);
          $values[$key]['url'] = $url;
          $values[$key]['uri'] = $file_uri;
          unset($values[$key]['target_id']);
          $reference = (object) $values;
          $reference = $reference->{0};
          $is_drupal_object = false;
        }else{
          $reference = node_load($value['target_id'], $value['target_revision_id']);
        }

        if(!empty($reference)){
          if($is_drupal_object){
            $reference = $this->filterNodeToArray($reference->toArray());
          }
          $data[$key] = $reference;
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
