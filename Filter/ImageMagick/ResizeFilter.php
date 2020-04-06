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


use Accurateweb\ImagingBundle\Primitive\Size;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ResizeFilter extends AbstractImagickFilter
{
  private $options;

  public function __construct(array $options = array())
  {
    $resolver = new OptionsResolver();
    /*
     * 90x60
     */
    $resolver->setRequired(array('size'));
    $resolver->setDefault('filter', \Imagick::FILTER_LANCZOS);
    $this->options = $resolver->resolve($options);
  }

  protected function transform (\Imagick $image)
  {
    $x = $image->getImageWidth();
    $y = $image->getImageHeight();

    $dst_size = Size::fromString($this->options["size"]);
    $width = $dst_size->getWidth();
    $height = $dst_size->getHeight();

    // If the width or height is not valid then enforce the aspect ratio
    if (!is_numeric($dst_size->getWidth()) || $dst_size->getWidth() < 1)
    {
      $width = round(($x / $y) * $dst_size->getHeight());
    }

    else if (!is_numeric($dst_size->getHeight()) || $dst_size->getHeight() < 1)
    {
      $height = round(($y / $x) * $dst_size->getWidth());
    }

    $image->resizeImage($width, $height, $this->options['filter'], 1, false);

    return $image;
  }

}