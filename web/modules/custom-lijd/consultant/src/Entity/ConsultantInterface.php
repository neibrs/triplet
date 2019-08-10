<?php

namespace Drupal\consultant\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\Core\Entity\EntityPublishedInterface;

/**
 * Provides an interface for defining Consultant entities.
 *
 * @ingroup consultant
 */
interface ConsultantInterface extends ContentEntityInterface, EntityChangedInterface, EntityPublishedInterface {

  /**
   * Add get/set methods for your configuration properties here.
   */

  /**
   * Gets the Consultant name.
   *
   * @return string
   *   Name of the Consultant.
   */
  public function getName();

  /**
   * Sets the Consultant name.
   *
   * @param string $name
   *   The Consultant name.
   *
   * @return \Drupal\consultant\Entity\ConsultantInterface
   *   The called Consultant entity.
   */
  public function setName($name);

  /**
   * Gets the Consultant creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Consultant.
   */
  public function getCreatedTime();

  /**
   * Sets the Consultant creation timestamp.
   *
   * @param int $timestamp
   *   The Consultant creation timestamp.
   *
   * @return \Drupal\consultant\Entity\ConsultantInterface
   *   The called Consultant entity.
   */
  public function setCreatedTime($timestamp);

}
