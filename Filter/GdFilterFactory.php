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

namespace Accurateweb\ImagingBundle\Filter;

use Accurateweb\ImagingBundle\Filter\GD\CropFilter;
use Accurateweb\ImagingBundle\Filter\GD\ResizeFilter;

class GdFilterFactory implements FilterFactoryInterface
{
  private $classMap;

  public function __construct()
  {
    $this->classMap = array(
      'resize' => ResizeFilter::class,
      'crop' => CropFilter::class
    );
  }

  /**
   * @param $id
   * @param $options
   * @return ImageFilterInterface
   * @throws \Exception
   */
  public function create($id, array $options = array())
  {
    if (!isset($this->classMap[$id]))
    {
      throw new \Exception();
    }

    $filterClassName = $this->classMap[$id];

    return new $filterClassName($options);
  }
}