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

namespace Accurateweb\ImagingBundle\Filter\ImageMagick;

use Accurateweb\ImagingBundle\Filter\ImageFilterInterface;
use Accurateweb\ImagingBundle\Image\Image;
use ImagickPixel;

abstract class AbstractImagickFilter implements ImageFilterInterface
{
  /**
   * @param Image $image
   * @return Image
   */
  public function process (Image $image)
  {
    /** @var \Imagick $imagick */
    $imagick = $image->getResource();
    $this->transform($imagick);
    return $image;
  }

  /**
   * @param \Imagick
   * @return \Imagick
   */
  abstract protected function transform(\Imagick $image);
}