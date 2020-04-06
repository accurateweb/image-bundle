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

namespace Accurateweb\ImagingBundle\Resolver;


class ExtensionMimeTypeResolver implements MimeTypeResolver
{
  /*
   * MIME type map and their associated file extension(s)
   * @var array
   */
  protected $types = array(
    'image/gif' => array('gif'),
    'image/jpeg' => array('jpg', 'jpeg'),
    'image/png' => array('png'),
    'image/svg' => array('svg'),
    'image/tiff' => array('tiff')
  );

  public function resolve($filename)
  {
    $pathinfo = pathinfo($filename);

    foreach($this->types as $mime => $extension)
    {
      if (in_array(strtolower($pathinfo['extension']), $extension))
      {
        return $mime;
      }
    }

    return false;
  }
}