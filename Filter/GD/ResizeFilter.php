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

namespace Accurateweb\ImagingBundle\Filter\GD;

use Accurateweb\ImagingBundle\Filter\ImageFilterInterface;
use Accurateweb\ImagingBundle\Image\Image;
use Accurateweb\ImagingBundle\Primitive\Size;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ResizeFilter extends GdFilter
{
  private $options;

  public function __construct (array $options = array())
  {
    $resolver = new OptionsResolver();

    $resolver->setRequired(array('size'));

    $this->options = $resolver->resolve($options);
  }

  public function process (Image $image)
  {
    $resource = $image->getResource();

    $src_size = new Size($image->getWidth(), $image->getHeight());
    $dst_size = Size::fromString($this->options["size"]);
    $keepAspectRatio = $dst_size->getWidth() == 0 || $dst_size->getHeight() == 0;

    if ($keepAspectRatio)
    {
      $ratio = $src_size->getAspectRatio();

      if ($ratio !== false)
      {
        if ($dst_size->getWidth() == 0)
        {
          $dst_size->setWidth($dst_size->getHeight() * $ratio);
        }
        else if ($dst_size->getHeight() == 0)
        {
          $dst_size->setHeight($dst_size->getWidth() / $ratio);
        }
      }
    }

    $width = $dst_size->getWidth();
    $height = $dst_size->getHeight();

    $x = imagesx($resource);
    $y = imagesy($resource);

    // If the width or height is not valid then enforce the aspect ratio
    if (!is_numeric($width) || $width < 1)
    {
      $this->width = round(($x / $y) * $height);
    }

    else if (!is_numeric($height) || $height < 1)
    {
      $this->height = round(($y / $x) * $width);
    }

    $dest_resource = $this->createTransparentImage($image, $width, $height);

    // Preserving transparency for alpha PNGs
    if ($image->getMIMEType() == 'image/png')
    {
      imagealphablending($dest_resource, false);
      imagesavealpha($dest_resource, true);
    }

    // Finally do our resizing
    imagecopyresampled($dest_resource, $resource, 0, 0, 0, 0, $width, $height, $x, $y);
    imagedestroy($resource);

    $image->setResource($dest_resource);
  }
}