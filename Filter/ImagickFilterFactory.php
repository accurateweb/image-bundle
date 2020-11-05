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

namespace Accurateweb\ImagingBundle\Filter;


use Accurateweb\ImagingBundle\Filter\ImageMagick\ConvertFilter;
use Accurateweb\ImagingBundle\Filter\ImageMagick\CropFilter;
use Accurateweb\ImagingBundle\Filter\ImageMagick\ResizeFilter;
use Accurateweb\ImagingBundle\Filter\ImageMagick\ScaleFilter;

class ImagickFilterFactory implements FilterFactoryInterface
{
  private $classMap;

  public function __construct()
  {
    $this->classMap = array(
      'crop' => 'Accurateweb\ImagingBundle\Filter\ImageMagick\CropFilter',
      'resize' => 'Accurateweb\ImagingBundle\Filter\ImageMagick\ResizeFilter',
      'convert' => 'Accurateweb\ImagingBundle\Filter\ImageMagick\ConvertFilter',
      'scale' => 'Accurateweb\ImagingBundle\Filter\ImageMagick\ScaleFilter',
    );
  }

  /**
   * @param $id
   * @param array $options
   * @return ImageFilterInterface|mixed
   * @throws \Exception
   */
  public function create ($id, array $options = array())
  {
    if (!isset($this->classMap[$id]))
    {
      throw new \Exception(sprintf('Not found Filter for %s', $id));
    }

    $filterClassName = $this->classMap[$id];

    return new $filterClassName($options);
  }

}