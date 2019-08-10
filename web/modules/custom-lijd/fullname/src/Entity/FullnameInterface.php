<?php

namespace Drupal\fullname\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\Core\Entity\EntityPublishedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Fullname entities.
 *
 * @ingroup fullname
 */
interface FullnameInterface extends ContentEntityInterface, EntityChangedInterface, EntityPublishedInterface, EntityOwnerInterface {

  /**
   * Add get/set methods for your configuration properties here.
   */

  /**
   * Gets the Fullname name.
   *
   * @return string
   *   Name of the Fullname.
   */
  public function getName();

  /**
   * Sets the Fullname name.
   *
   * @param string $name
   *   The Fullname name.
   *
   * @return \Drupal\fullname\Entity\FullnameInterface
   *   The called Fullname entity.
   */
  public function setName($name);

  /**
   * Gets the Fullname creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Fullname.
   */
  public function getCreatedTime();

  /**
   * Sets the Fullname creation timestamp.
   *
   * @param int $timestamp
   *   The Fullname creation timestamp.
   *
   * @return \Drupal\fullname\Entity\FullnameInterface
   *   The called Fullname entity.
   */
  public function setCreatedTime($timestamp);

}
