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

/**
 * @author Denis N. Ragozin <dragozin@accurateweb.ru>
 */

namespace Accurateweb\ImagingBundle\Image;


use Accurateweb\ImagingBundle\Primitive\Size;

abstract class Image
{
  protected $resource;

  protected $width;

  protected $height;

  protected $mimeType;

  public function __construct($resource, $width, $height, $mimeType)
  {
    $this->resource = $resource;
    $this->width = $width;
    $this->height = $height;
    $this->mimeType = $mimeType;
  }

  public function getResource()
  {
    return $this->resource;
  }

  public function setResource($resource)
  {
    $this->resource = $resource;
  }

  /**
   * @return mixed
   */
  public function getWidth()
  {
    return $this->width;
  }

  /**
   * @return mixed
   */
  public function getHeight()
  {
    return $this->height;
  }

  public function getSize()
  {
    return new Size($this->width, $this->height);
  }

  /**
   * @return mixed
   */
  public function getMimeType()
  {
    return $this->mimeType;
  }


}