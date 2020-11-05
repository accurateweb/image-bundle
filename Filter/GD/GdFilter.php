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

abstract class GdFilter implements ImageFilterInterface
{
  protected function createTransparentImage(Image $image, $width, $height)
  {
    $resource = $image->getResource();

    $dest_resource = imagecreatetruecolor((int)$width, (int)$height);

    // Preserve alpha transparency
    if (in_array($image->getMimeType(), array('image/gif','image/png')))
    {
      $index = imagecolortransparent($resource);

      // Handle transparency
      if ($index >= 0)
      {

        // Grab the current images transparent color
        $index_color = imagecolorsforindex($resource, $index);

        // Set the transparent color for the resized version of the image
        $index = imagecolorallocate($dest_resource, $index_color['red'], $index_color['green'], $index_color['blue']);

        // Fill the entire image with our transparent color
        imagefill($dest_resource, 0, 0, $index);

        // Set the filled background color to be transparent
        imagecolortransparent($dest_resource, $index);
      }
      else if ($image->getMimeType() == 'image/png') // Always make a transparent background color for PNGs that don't have one allocated already
      {

        // Disabled blending
        imagealphablending($dest_resource, false);

        // Grab our alpha tranparency color
        $color = imagecolorallocatealpha($dest_resource, 0, 0, 0, 127);

        // Fill the entire image with our transparent color
        imagefill($dest_resource, 0, 0, $color);

        // Re-enable transparency blending
        imagesavealpha($dest_resource, true);
      }
    }

    return $dest_resource;
  }
}