<?php

namespace Drupal\client\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBundleBase;

/**
 * Defines the Client type entity.
 *
 * @ConfigEntityType(
 *   id = "client_type",
 *   label = @Translation("Client type"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\client\ClientTypeListBuilder",
 *     "form" = {
 *       "add" = "Drupal\client\Form\ClientTypeForm",
 *       "edit" = "Drupal\client\Form\ClientTypeForm",
 *       "delete" = "Drupal\client\Form\ClientTypeDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\client\ClientTypeHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "type",
 *   admin_permission = "administer site configuration",
 *   bundle_of = "client",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/client_type/{client_type}",
 *     "add-form" = "/admin/structure/client_type/add",
 *     "edit-form" = "/admin/structure/client_type/{client_type}/edit",
 *     "delete-form" = "/admin/structure/client_type/{client_type}/delete",
 *     "collection" = "/admin/structure/client_type"
 *   }
 * )
 */
class ClientType extends ConfigEntityBundleBase implements ClientTypeInterface {

  /**
   * The Client type ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The Client type label.
   *
   * @var string
   */
  protected $label;

}
