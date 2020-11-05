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

namespace Accurateweb\ImagingBundle\Primitive;

use Accurateweb\ImagingBundle\Image\Image;

class Size
{
  private $width;
  private $height;

  public function __construct ($width = 0, $height = 0)
  {
    $this->setWidth($width);
    $this->setHeight($height);
  }

  /**
   * Создает размер из строки/числа, означающего высоту.
   * Ширина вычисляется так, чтобы были сохранены пропорции.
   *
   * @param string|integer $height высота
   * @param Size $initialSize - изначальный размер изображения
   * @return $this - Размер
   * @throws \InvalidArgumentException
   */
  static public function fromHeight ($height, $initialSize)
  {
    if (!is_string($height) && !is_int($height))
    {
      throw new \InvalidArgumentException(sprintf('Invalid parameter height, expected string or int, received "%s"', gettype($height)));
    }

    if (!$initialSize instanceof Size)
    {
      throw new \InvalidArgumentException(sprintf('Invalid parameter initialSize, expected Size, received "%s"', gettype($initialSize)));
    }

    $newWidth = $initialSize->getWidth() / ($initialSize->getHeight() / $height);

    return new Size((int)$newWidth, $height);
  }

  /**
   * Создает размер из строки/числа, означающего ширину.
   * Высота вычисляется так, чтобы были сохранены пропорции.
   *
   * @param string|integer $width высота
   * @param array $initialSize - изначальный размер изображения
   * @return $this - Размер
   * @throws \InvalidArgumentException
   */
  static public function fromWidth ($width, $initialSize)
  {
    if (!is_string($width) && !is_int($width))
    {
      throw new \InvalidArgumentException(sprintf('Invalid parameter width, expected string or int, received "%s"', gettype($width)));
    }

    if (!$initialSize instanceof Size)
    {
      throw new \InvalidArgumentException(sprintf('Invalid parameter initialSize, expected Size, received "%s"', gettype($initialSize)));
    }

    $newHeight = $initialSize->getHeight() / ($initialSize->getWidth() / (int)$width);

    return new Size($width, (int)$newHeight);
  }

  /**
   * Создает размер из строки вида %ширина%<разделитель>%высота%.
   *
   * По умолчанию в качестве разделителя используется "x". Если в строке в качестве
   * разделителя используется другой символ, передайте его вторым параметром
   *
   * Примеры:
   *
   * $size = Size::fromString('90x60');<br/>
   * $size = Size::fromString('90:60', ':');
   *
   * @param String $v Строковое представление размера
   * @param String $delimiter Разделитель
   * @return Size             Размер
   * @throws \InvalidArgumentException
   */
  static public function fromString ($v, $delimiter = 'x')
  {
    $parts = explode($delimiter, $v);

    if (count($parts) != 2)
    {
      throw new \InvalidArgumentException(sprintf('Invalid size string "%s"', $v));
    }

    if (!is_numeric($parts[0]) && !is_numeric($parts[1]))
    {
      throw new \InvalidArgumentException(sprintf('Size components must be valid numbers'));
    }

    return new Size($parts[0], $parts[1]);
  }

  /**
   * Создает размер из экзепляра класса sfImage
   *
   * @param Image $image Изображение
   * @return Size Размер указанного изображения
   */
  static public function fromImage (Image $image)
  {
    return new Size($image->getWidth(), $image->getHeight());
  }

  /**
   * Если ширина или длина текущего размера равны нулю, дополняет их соответствующими значениями передаваемого размера
   *
   * @param Size $size
   * @return Size Возвращает себя для замыкания
   */
  public function extend (Size $size)
  {
    if ($this->width == 0)
    {
      $this->width = $size->getWidth();
    }

    if ($this->height == 0)
    {
      $this->height = $size->getHeight();
    }

    return $this;
  }

  public function getWidth ()
  {
    return $this->width;
  }

  public function setWidth ($v)
  {
    $this->width = (int)$v;
  }

  public function getHeight ()
  {
    return $this->height;
  }

  public function setHeight ($v)
  {
    $this->height = (int)$v;
  }

  /**
   * Возвращает соотношение длин в
   *
   * @return float|boolean
   */
  public function getAspectRatio ()
  {
    if ($this->height == 0 || $this->width == 0)
    {
      return false;
    }

    return $this->width / $this->height;
  }
}
