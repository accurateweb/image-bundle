<?php
/**
 *  (c) 2019 ИП Рагозин Денис Николаевич. Все права защищены.
 *
 *  Настоящий файл является частью программного продукта, разработанного ИП Рагозиным Денисом Николаевичем
 *  (ОГРНИП 315668300000095, ИНН 660902635476).
 *
 *  Алгоритм и исходные коды программного кода программного продукта являются коммерческой тайной
 *  ИП Рагозина Денис Николаевича. Любое их использование без согласия ИП Рагозина Денис Николаевича рассматривается,
 *  как нарушение его авторских прав.
 *   Ответственность за нарушение авторских прав наступает в соответствии с действующим законодательством РФ.
 */

namespace Accurateweb\ImagingBundle\Primitive;

class Shape
{
  /**
   * @var Point
   */
  private $location;

  public function __construct(Point $location)
  {
    $this->setLocation($location);
  }

  public function getX()
  {
    return $this->location->getX();
  }

  public function getY()
  {
    return $this->location->getY();
  }

  public function getLocation()
  {
    return clone $this->location;
  }

  public function setLocation(Point $location)
  {
    $this->location = clone $location;
  }
}