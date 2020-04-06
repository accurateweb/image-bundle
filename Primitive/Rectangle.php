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

class Rectangle extends Shape
{
  /**
   * @var Size
   */
  private $size = null;

  public function __construct(Point $location = null, Size $size = null)
  {
    if ($location == null)
    {
      $location = new Point( );
    }
    parent::__construct($location);

    $this->setSize($size ? $size : new Size( ) );
  }

  public function getAspectRatio()
  {
    return $this->size->getAspectRatio();
  }

  public function getWidth()
  {
    return $this->size->getWidth();
  }

  public function getHeight()
  {
    return $this->size->getHeight();
  }

  public function setHeight($height)
  {
    $this->size->setHeight($height);
  }

  public function setWidth($width)
  {
    $this->size->setWidth($width);
  }

  public function getBottomRight()
  {
    return new Point($this->getRight(), $this->getBottom());
  }

  public function getSize()
  {
    return clone $this->size;
  }

  public function setSize(Size $size)
  {
    $this->size = clone $size;
  }

  public function getLeft()
  {
    return $this->getX();
  }

  public function getRight()
  {
    return $this->getX() + $this->getWidth();
  }

  public function getTop()
  {
    return $this->getY();
  }

  public function getBottom()
  {
    return $this->getY() + $this->getHeight();
  }

}
