<?php

namespace Drupal\node_as_json\Commands;

use Drush\Commands\DrushCommands;

/**
 * A Drush commandfile.
 *
 * In addition to this file, you need a drush.services.yml
 * in root of your module, and a composer.json file that provides the name
 * of the services file to use.
 */
class NodeAsJsonCommands extends DrushCommands {
  /**
   * Echos back hello with the argument provided.
   *
   *
   * @command node_as_json:cron
   * @aliases naj-cron
   * @usage node_as_json:cron
   *   Display 'Hello!' and a message.
   */
  public function cron() {
    $cron = \Drupal::service('node_as_json.cron');
    $cron->cronjob();
  }

}