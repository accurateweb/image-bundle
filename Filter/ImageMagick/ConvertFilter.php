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

use Symfony\Component\OptionsResolver\OptionsResolver;

class ConvertFilter extends AbstractImagickFilter
{
  private $options;

  public function __construct ($options)
  {
    $resolver = new OptionsResolver();
    $resolver->setRequired('to');
    $resolver->setAllowedValues('to', [
      'png32', 'jpeg'
    ]);
    $this->options = $resolver->resolve($options);
  }

  protected function transform (\Imagick $image)
  {
//    $image->setBackgroundColor(new \ImagickPixel('transparent'));
//    $image->setBackgroundColor(new \ImagickPixel("rgba(255, 0, 0, 1.0)"));
    $image->setImageFormat($this->options['to']);
    return $image;
  }
}