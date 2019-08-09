<?php

namespace Drupal\client\Entity;

use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityPublishedTrait;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Field\FieldStorageDefinitionInterface;

/**
 * Defines the Client entity.
 *
 * @ingroup client
 *
 * @ContentEntityType(
 *   id = "client",
 *   label = @Translation("Client"),
 *   label_collection = @Translation("Client"),
 *   bundle_label = @Translation("Client type"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\client\ClientListBuilder",
 *     "views_data" = "Drupal\client\Entity\ClientViewsData",
 *
 *     "form" = {
 *       "default" = "Drupal\client\Form\ClientForm",
 *       "add" = "Drupal\client\Form\ClientForm",
 *       "edit" = "Drupal\client\Form\ClientForm",
 *       "delete" = "Drupal\client\Form\ClientDeleteForm",
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\client\ClientHtmlRouteProvider",
 *     },
 *     "access" = "Drupal\client\ClientAccessControlHandler",
 *   },
 *   base_table = "client",
 *   translatable = FALSE,
 *   admin_permission = "administer client",
 *   entity_keys = {
 *     "id" = "id",
 *     "bundle" = "type",
 *     "label" = "name",
 *     "uuid" = "uuid",
 *     "langcode" = "langcode",
 *     "published" = "status",
 *   },
 *   links = {
 *     "canonical" = "/client/{client}",
 *     "add-page" = "/client/add",
 *     "add-form" = "/client/add/{client_type}",
 *     "edit-form" = "/client/{client}/edit",
 *     "delete-form" = "/client/{client}/delete",
 *     "collection" = "/client",
 *   },
 *   bundle_entity_type = "client_type",
 *   field_ui_base_route = "entity.client_type.edit_form"
 * )
 */
class Client extends ContentEntityBase implements ClientInterface {

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

    // The wechat name
    $fields['name'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Name'))
      ->setDescription(t('The name of the Client entity.'))
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

    $fields['consultant'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Consultant', ['context' => 'My consultant']))
      ->setSetting('target_type', 'consultant')
      ->setCardinality(FieldStorageDefinitionInterface::CARDINALITY_UNLIMITED)
      ->setDisplayOptions('view', [
        'type' => 'entity_reference_label',
        'weight' => 6,
      ])
      ->setDisplayOptions('form', [
        'type' => 'entity_reference_autocomplete',
        'weight' => 6,
        'settings' => [
          'match_operator' => 'CONTAINS',
          'size' => '60',
          'placeholder' => '',
        ],
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);
    
    $fields['status']->setDescription(t('A boolean indicating whether the Client is published.'))
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

  /**
   * {@inheritdoc}
   */
  public function preSave(EntityStorageInterface $storage) {
    parent::preSave($storage);
    $client_settings = \Drupal::configFactory()->getEditable('client.settings');
    $cid = $client_settings->get('cid');
    $max_cid = $client_settings->get('max_cid');
    $consultant_storage = \Drupal::entityTypeManager()->getStorage('consultant');
    if (empty($consultant_storage->loadMultiple())) {
      return;
    }

    do {
      if (($cid += 1) > $max_cid) {
        $cid = 1;
      }
    }
    while (empty($consultant = $consultant_storage->load($cid)));

    $this->get('consultant')->appendItem($consultant);
    $client_settings->set('cid', $cid)
      ->save();
  }

  /**
   * {@inheritdoc}
   */
  public function postSave(EntityStorageInterface $storage, $update = TRUE) {
    parent::postSave($storage, $update);

    // compare original entity consultants with this entity.
    /** @var \Drupal\consultant\Entity\ConsultantInterface[] $consultants */
    $consultants = $this->getDifferentConsultants();
    foreach ($consultants as $consultant) {
      $found = FALSE;
      foreach ($clients = $consultant->get('client')->referencedEntities() as $client) {
        /** @var \Drupal\client\Entity\ClientInterface $client */
        if ($client->id() == $this->id()) {
          $found = TRUE;
          break;
        }
      }
      if (!$found) {
        $consultant->get('client')->appendItem($this);
        $consultant->save();
      }
    }
  }

  /**
   * {@inheritdoc}
   */
  public static function postDelete(EntityStorageInterface $storage, array $entities) {
    parent::postDelete($storage, $entities);
    // TODO
  }

  /**
   * {@inheritdoc}
   */
  public function getConsultants() {
    return $this->get('consultant')->referencedEntities();
  }

  /**
   * {@inheritdoc}
   */
  public function getDifferentConsultants() {
    $difference_consultants = [];

    if ($this->original) {
      $original_consultants = $this->original->getConsultants();
      $this_consultants = $this->getConsultants();

      $difference_consultants = array_diff($this_consultants, $original_consultants);
    }
    else {
      $difference_consultants = $this->getConsultants();
    }

    return $difference_consultants;
  }

}
