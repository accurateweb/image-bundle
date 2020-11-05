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


use Accurateweb\ImagingBundle\Crop\AutoCrop;
use Accurateweb\ImagingBundle\Crop\Crop;
use Accurateweb\ImagingBundle\Image\Image;
use Accurateweb\ImagingBundle\Primitive\Point;
use Accurateweb\ImagingBundle\Primitive\Size;
use Symfony\Component\OptionsResolver\Exception\InvalidArgumentException;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Description of CropFilterOptionsResolver
 *
 * @package Accurateweb\ImagingBundle\Filter
 */
class CropFilterOptionsResolver implements FilterOptionsResolverInterface
{
  private $resolverOptions;

  /**
   * CropFilterOptionsResolver constructor.
   *
   * @param array $resolverOptions
   */
  public function __construct(array $resolverOptions = array())
  {
    $resolver = new OptionsResolver();

    $resolver
      ->setDefaults(array(
        'auto_crop' => true,
        'auto_crop_aspect_ratio' => 1,
        'auto_crop_position' => 'center'
      ))
      ->setAllowedValues('auto_crop_position', array(
        'left-top',
        'center-top',
        'right-top',
        'left-middle',
        'right-middle',
        'left-bottom',
        'center-bottom',
        'right-bottom',
        'center-middle',
        'center'
      ))
      ->setAllowedTypes('auto_crop_aspect_ratio', array('numeric'));

    $this->resolverOptions = $resolver->resolve($resolverOptions);
  }

  public function resolve(Image $image, array $options = array())
  {
    $crop = null;

    $resolver = new OptionsResolver();

    $resolver->setRequired(array('left', 'top', 'width', 'height'));

    try
    {
      $cropOptions = $resolver->resolve($options);

      $crop = new Crop(new Point($cropOptions['left'], $cropOptions['top']), new Size($cropOptions['width'], $cropOptions['height']));
    }
    catch (InvalidArgumentException $e)
    {
      if ($this->resolverOptions['auto_crop'])
      {
        try
        {
          $crop = new AutoCrop($image,
            $this->resolverOptions['auto_crop_position'],
            $this->resolverOptions['auto_crop_aspect_ratio']);
        }
        catch (Exception $e)
        {
          //What to do?
        }
      }
    }

    if (null === $crop)
    {
      throw new \Exception('Unable to resolve crop size for given image and options');
    }

    return array(
      'left' => $crop->getLeft(),
      'top' => $crop->getTop(),
      'width' => $crop->getWidth(),
      'height' => $crop->getHeight()
    );
  }
}