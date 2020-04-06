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

class ScaleFilter extends AbstractImagickFilter
{
  private $options;

  public function __construct ($options)
  {
    $resolver = new OptionsResolver();
    $resolver->setRequired('size');
    $resolver->setDefault('bestfit', false);
    $this->options = $resolver->resolve($options);
  }

  protected function transform (\Imagick $image)
  {
    $size = Size::fromString($this->options['size']);

    $image->scaleImage($size->getWidth(), $size->getHeight(), $this->options['bestfit']);
    return $image;
  }
}