<?php
/**
 * Created by PhpStorm.
 * User: smith
 * Date: 11/2/17
 * Time: 3:04 PM
 */

namespace App\Filters;


use Intervention\Image\Filters\FilterInterface;


class DropZoneFilter implements FilterInterface
{

    /**
     * Applies filter effects to given image
     *
     * @param  Intervention\Image\Image $image
     * @return Intervention\Image\Image
     */
    public function applyFilter(\Intervention\Image\Image $image)
    {
       return $image->fit(120, 120);
    }
}