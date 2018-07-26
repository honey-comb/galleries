<?php
/**
 * @copyright 2018 innovationbase
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 *
 * Contact InnovationBase:
 * E-mail: hello@innovationbase.eu
 * https://innovationbase.eu
 */

declare(strict_types = 1);

namespace HoneyComb\Galleries\Enum;

use HoneyComb\Starter\Enum\Enumerable;

/**
 * Class HCGalleryStartPositionEnum
 * @package HoneyComb\Starter\Enum
 */
class HCGalleryStartPositionEnum extends Enumerable
{
    /**
     * @return HCGalleryStartPositionEnum
     * @throws \ReflectionException
     */
    final public static function topLeft(): HCGalleryStartPositionEnum
    {
        return self::make('top_left', trans('HCGalleries::gallery.positions.top_left'));
    }

    /**
     * @return HCGalleryStartPositionEnum
     * @throws \ReflectionException
     */
    final public static function top(): HCGalleryStartPositionEnum
    {
        return self::make('top', trans('HCGalleries::gallery.positions.top'));
    }

    /**
     * @return HCGalleryStartPositionEnum
     * @throws \ReflectionException
     */
    final public static function topRight(): HCGalleryStartPositionEnum
    {
        return self::make('top_right', trans('HCGalleries::gallery.positions.top_right'));
    }

    /**
     * @return HCGalleryStartPositionEnum
     * @throws \ReflectionException
     */
    final public static function centerLeft(): HCGalleryStartPositionEnum
    {
        return self::make('center_left', trans('HCGalleries::gallery.positions.center_left'));
    }

    /**
     * @return HCGalleryStartPositionEnum
     * @throws \ReflectionException
     */
    final public static function center(): HCGalleryStartPositionEnum
    {
        return self::make('center', trans('HCGalleries::gallery.positions.center'));
    }

    /**
     * @return HCGalleryStartPositionEnum
     * @throws \ReflectionException
     */
    final public static function centerRight(): HCGalleryStartPositionEnum
    {
        return self::make('center_right', trans('HCGalleries::gallery.positions.center_right'));
    }

    /**
     * @return HCGalleryStartPositionEnum
     * @throws \ReflectionException
     */
    final public static function bottomLeft(): HCGalleryStartPositionEnum
    {
        return self::make('bottom_left', trans('HCGalleries::gallery.positions.bottom_left'));
    }

    /**
     * @return HCGalleryStartPositionEnum
     * @throws \ReflectionException
     */
    final public static function bottom(): HCGalleryStartPositionEnum
    {
        return self::make('bottom', trans('HCGalleries::gallery.positions.bottom'));
    }

    /**
     * @return HCGalleryStartPositionEnum
     * @throws \ReflectionException
     */
    final public static function bottomRight(): HCGalleryStartPositionEnum
    {
        return self::make('bottom_right', trans('HCGalleries::gallery.positions.bottom_right'));
    }

}
