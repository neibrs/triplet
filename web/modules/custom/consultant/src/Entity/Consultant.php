<?php

namespace Drupal\consultant\Entity;

use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityPublishedTrait;
use Drupal\Core\Entity\EntityTypeInterface;

/**
 * Defines the Consultant entity.
 *
 * @ingroup consultant
 *
 * @ContentEntityType(
 *   id = "consultant",
 *   label = @Translation("Consultant"),
 *   label_collection = @Translation("Consultant"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\consultant\ConsultantListBuilder",
 *     "views_data" = "Drupal\consultant\Entity\ConsultantViewsData",
 *
 *     "form" = {
 *       "default" = "Drupal\consultant\Form\ConsultantForm",
 *       "add" = "Drupal\consultant\Form\ConsultantForm",
 *       "edit" = "Drupal\consultant\Form\ConsultantForm",
 *       "delete" = "Drupal\consultant\Form\ConsultantDeleteForm",
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\consultant\ConsultantHtmlRouteProvider",
 *     },
 *     "access" = "Drupal\consultant\ConsultantAccessControlHandler",
 *   },
 *   base_table = "consultant",
 *   translatable = FALSE,
 *   admin_permission = "administer consultant entities",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "name",
 *     "uuid" = "uuid",
 *     "langcode" = "langcode",
 *     "published" = "status",
 *   },
 *   links = {
 *     "canonical" = "/consultant/{consultant}",
 *     "add-form" = "/consultant/add",
 *     "edit-form" = "/consultant/{consultant}/edit",
 *     "delete-form" = "/consultant/{consultant}/delete",
 *     "collection" = "/consultant",
 *   },
 *   field_ui_base_route = "consultant.settings"
 * )
 */
class Consultant extends ContentEntityBase implements ConsultantInterface {

  use EntityChangedTrait;
  use EntityPublishedTrait;

  /**
   * {@inheritdoc}
   */
  public function getName() {
    return $this->get('name')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setName($name) {
    $this->set('name', $name);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getCreatedTime() {
    return $this->get('created')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setCreatedTime($timestamp) {
    $this->set('created', $timestamp);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    $fields = parent::baseFieldDefinitions($entity_type);

    // Add the published field.
    $fields += static::publishedBaseFieldDefinitions($entity_type);

    $fields['name'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Name'))
      ->setDescription(t('The name of the Consultant entity.'))
      ->setSettings([
        'max_length' => 50,
        'text_processing' => 0,
      ])
      ->setDefaultValue('')
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'string',
        'weight' => -4,
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => -4,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE)
      ->setRequired(TRUE);

    $fields['status']->setDescription(t('A boolean indicating whether the Consultant is published.'))
      ->setDisplayOptions('form', [
        'type' => 'boolean_checkbox',
        'weight' => -3,
      ]);

    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Created'))
      ->setDescription(t('The time that the entity was created.'));

    $fields['changed'] = BaseFieldDefinition::create('changed')
      ->setLabel(t('Changed'))
      ->setDescription(t('The time that the entity was last edited.'));

    return $fields;
  }

}
