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

  public function publishedList(){
    $folder = 'public://nodes_as_json/published';
    $files = array_diff(scandir($folder), array('.', '..'));
    
    $data = [];
    //data.published_nodes
    foreach($files as $file){
      $json = json_decode(file_get_contents($folder .'/'. $file), true);
      if(!empty($json['path'][0]['alias'])){
        $data['published_nodes'][$json['path'][0]['alias']] = '/sites/default/files/nodes_as_json/published/'.$file;
      }      
    }

    //data.header
    $menu_name = 'main';
    $tree = $this->render_menu_navigation($menu_name);
    $data['header'] = $tree;

    //data.footer
    $menu_name = 'footer';
    $tree = $this->render_menu_navigation($menu_name);
    $data['footer'] = $tree;


    return new JsonResponse($data);
  }

  private function render_menu_navigation($menu_name){
    $tree = \Drupal::menuTree()->load($menu_name, new \Drupal\Core\Menu\MenuTreeParameters());
    $data = [];
    foreach ($tree as $item) {
      if($item->link->isEnabled()){
        $title = $item->link->getTitle();
        $url_obj = $item->link->getUrlObject();
        $url = $url_obj->toString();
        $has_children = $item->hasChildren;

        $data[] = [
          'title' => $title,
          'url' => $url,
        ];
      }
    }

    return $data;
  }
  
}
