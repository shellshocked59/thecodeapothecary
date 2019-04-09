<?php

namespace Drupal\node_as_json;



class NodeAsJsonFileManager {
  public function createFilesForNID($nid){
    $main = \Drupal::service('node_as_json.main');

    $published = $main->getPublishedNode($nid);
    $unpublished = $main->getUnpublishedNode($nid);

   //create unpublished file
   if(!empty($published)){
    $filename = $nid.'.json';
    $folder = 'public://nodes_as_json/published';
    $this->saveFile($filename, $published, $folder);
   }
   
   

   //create published file if published
   if(!empty($unpublished)){
    $filename = $nid.'.json';
    $folder = 'public://nodes_as_json/unpublished';
    $this->saveFile($filename, $published, $folder);
   }
  }

  public function saveFile($filename, $data, $folder){
    //create folders if they don't exist
    if (!file_exists($folder)) {
        //create parent folder too if needed
        $parent_folder = 'public://nodes_as_json';
        if (!file_exists($parent_folder)) {
          mkdir($parent_folder, 0777, true);
          file_prepare_directory($parent_folder);
        }

        mkdir($folder, 0777, true);
        file_prepare_directory($folder);
    }

    //save the data
    file_save_data(json_encode($data), $folder . '/' . $filename, FILE_EXISTS_REPLACE);
  }
}
