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
use Symfony\Component\OptionsResolver\OptionsResolver;

class CropFilter extends AbstractImagickFilter
{
  private $options;

  public function __construct(array $options = array())
  {
    $resolver = new OptionsResolver();
    $resolver->setRequired(array('left', 'top', 'width', 'height'));;
    $this->options = $resolver->resolve($options);
  }

  protected function transform (\Imagick $image)
  {
    $image->cropImage(
      $this->options['width'],
      $this->options['height'],
      $this->options['left'],
      $this->options['top']
    );
    $image->setImagePage($this->options['width'], $this->options['height'], 0, 0);

    return $image;
  }

  //  public function process (Image $image)
//  {
//    $resource = $image->getResource();
//    $resource->cropImage($this->getWidth(), $this->getHeight(), $this->getLeft(), $this->getTop());
//    $resource->setImagePage($this->getWidth(), $this->getHeight(), 0, 0);
//
//    return $image;
//  }
}