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


use Accurateweb\ImagingBundle\Image\Image;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CropFilter extends GdFilter
{
  private $options;

  /**
   * Constructor.
   *
   * @param array $options
   */
  public function __construct(array $options = array())
  {
    $resolver = new OptionsResolver();

    $resolver
      ->setRequired(array('left', 'top', 'width', 'height'))
//      ->setAllowedTypes('left', array('numeric'))
//      ->setAllowedTypes('top', array('numeric'))
//      ->setAllowedTypes('width', array('numeric'))
//      ->setAllowedTypes('height', array('numeric'));
    ;

    $this->options = $resolver->resolve($options);
  }

  /**
   * Apply the transform to the sfImage object.
   *
   * @access protected
   * @param sfImage
   * @return sfImage
   */
  public function process(Image $image)
  {
    $resource = $image->getResource();

    if ($this->options['width'] == 0)
    {
      $this->options['width'] = $image->getWidth();
    }

    if ($this->options['height'] == 0)
    {
      $this->options['height'] = $image->getHeight();
    }

    $dest_resource = $this->createTransparentImage($image, $this->options['width'], $this->options['height']);

    // Preserving transparency for alpha PNGs
    imagealphablending($dest_resource, false);
    imagesavealpha($dest_resource, true);

    imagecopy($dest_resource, $resource, 0, 0, $this->options['left'],
      $this->options['top'], $this->options['width'], $this->options['height']);

    // Tidy up
    imagedestroy($resource);

    // Replace old image with flipped version
    $image->setResource($dest_resource);

    return $image;
  }

}