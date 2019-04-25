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

  public function sitePublishedList($site_name){
    $main = \Drupal::service('node_as_json.main');
    $data = [];
    /*$folder = 'public://nodes_as_json/published';
    $files = array_diff(scandir($folder), array('.', '..'));
    
    //data.published_nodes
    foreach($files as $file){
      $json = json_decode(file_get_contents($folder .'/'. $file), true);
      if(!empty($json['path'][0]['alias'])){
        $data['published_nodes'][$json['path'][0]['alias']] = '/sites/default/files/nodes_as_json/published/'.$file;
      }      
    }*/
    $result = \Drupal::entityQuery('node')
    ->condition('type', 'sites')
    ->condition('field_site_key', $site_name)
    ->range(0, 1)
    ->execute();
    $nid = array_shift(array_values($result));

    if(!empty($nid)){
      $site_node = node_load($nid);
      $data = $main->getSimpleNodeObject($site_node);
      $data['published_nodes'] = [];
      $nids = \Drupal::entityQuery('node')
        ->condition('type', ['page'], 'IN')
        ->condition('field_site', $nid)
        ->execute();
      foreach($nids as $nid){
        $node_json = $main->getSimpleNodeObject(node_load($nid));
        $node_url = $node_json['path'][0]['alias'];
        if(!empty($node_url)){
          $data['published_nodes'][$node_url] = $node_json;
        }
      }

    }else{
      $data['error'] = 'Site does not exist';
    }


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
