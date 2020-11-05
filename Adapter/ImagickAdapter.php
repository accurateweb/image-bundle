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

namespace Accurateweb\ImagingBundle\Adapter;

use Accurateweb\ImagingBundle\Image\Image;
use Accurateweb\ImagingBundle\Image\ImagickImage;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;

class ImagickAdapter implements AdapterInterface
{
  /**
   * @param $filename
   * @param null|string $format
   * @return ImagickImage
   */
  public function loadFromFile ($filename, $format=null)
  {
    if (!is_file($filename))
    {
      throw new FileNotFoundException(null, 0, null, $filename);
    }

    $imagick = new \Imagick();

    if ($format)
    {
      $imagick->setFormat($format);
    }

    $imagick->readImage(realpath($filename));

    return new ImagickImage($imagick, $imagick->getImageWidth(), $imagick->getImageHeight(), $imagick->getImageMimeType());
  }

  public function save (Image $image, $filename, $quality = 100)
  {
    /** @var \Imagick $imagick */
    $imagick = $image->getResource();
    $currentFormat = $imagick->getImageFormat();

    if (strpos($currentFormat, 'png') !== false)
    {
      $filename = sprintf('png:%s', $filename);
    }

    $imagick->setImageCompressionQuality($quality);
    $imagick->writeImage(sprintf($filename));
    $imagick->clear();
    $imagick->destroy();
  }
}