<?php

namespace Drupal\client\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\Core\Entity\EntityPublishedInterface;

/**
 * Provides an interface for defining Client entities.
 *
 * @ingroup client
 */
interface ClientInterface extends ContentEntityInterface, EntityChangedInterface, EntityPublishedInterface {

  /**
   * Add get/set methods for your configuration properties here.
   */

  /**
   * Gets the Client name.
   *
   * @return string
   *   Name of the Client.
   */
  public function getName();

  /**
   * Sets the Client name.
   *
   * @param string $name
   *   The Client name.
   *
   * @return \Drupal\client\Entity\ClientInterface
   *   The called Client entity.
   */
  public function setName($name);

  /**
   * Gets the Client creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Client.
   */
  public function getCreatedTime();

  /**
   * Sets the Client creation timestamp.
   *
   * @param int $timestamp
   *   The Client creation timestamp.
   *
   * @return \Drupal\client\Entity\ClientInterface
   *   The called Client entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * @return \Drupal\consultant\Entity\ConsultantInterface[]
   */
  public function getDifferentConsultants();

  /**
   * @return \Drupal\consultant\Entity\ConsultantInterface[]
   */
  public function getConsultants();
}
