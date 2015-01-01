<?php
/**
 * This file is part of the MediaProcessing package.
 *
 * Copyleft (ↄ) 2013-2015 Pierre Cassat <me@e-piwi.fr> and contributors
 * 
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 *
 * The source code of this package is available online at 
 * <http://github.com/atelierspierrot/media-processing>.
 */

namespace MediaProcessing\ImageFilter\Filter;

use MediaProcessing\AbstractFilter;
use MediaProcessing\FilterInterface;
use MediaProcessing\ImageFilter\ImageFilter;

/**
 */
class Resize
    extends AbstractFilter
    implements FilterInterface
{

    /**
     * @var array
     */
    protected $options = array(
        'width'=>200,
        'height'=>200,
        'max_width'=>200,
        'max_height'=>200
    );

    /**
     * @var int
     */
    protected $source_width;

    /**
     * @var int
     */
    protected $source_height;

    /**
     * @var int
     */
    protected $target_width;

    /**
     * @var int
     */
    protected $target_height;

// ----------------
// Getters / Setters
// ----------------

    /**
     * Build the target filename
     *
     * This filename must be unique and constant for a specific source and the filter settings
     * to allow caching the result image, and retrieving it.
     *
     * @param   string  $target_filename The target filename
     * @return  string  A unique and constant filename depending on filter settings and source file with NO extension
     */
    public function getTargetFilename( $target_filename )
    {
        $this->calculateTargetSizes();
        $_tf = $this->source_file->getBasename( '.'.$this->source_file->getExtension() )
            .'_resize_'
            .$this->target_width.'x'.$this->target_height
            .'.'.$this->source_file->getExtension();
        return $_tf;
    }

    /**
     * Calculate the source image width & height from the resource
     *
     * @return self
     */
    public function calculateSourceHandlerSizes()
    {
        if (empty($this->source_width)) {
            $this->source_width = imagesx($this->source_handler);
        }
        if (empty($this->source_height)) {
            $this->source_height = imagesy($this->source_handler);
        }
        return $this;
    }

    /**
     * Calculate the target image width & height from the source sizes and set options
     *
     * @return self
     */
    public function calculateTargetSizes()
    {
        if (empty($this->target_width) && empty($this->target_height)) {
            $this->calculateSourceHandlerSizes();

            if (!empty($this->options['max_width']) || !empty($this->options['max_height'])) {
                list($this->target_width, $this->target_height) =
                    ImageFilter::resizeWidthHeight(
                        $this->source_width, $this->source_height,
                        !empty($this->options['max_width']) ? $this->options['max_width'] : $this->source_width,
                        !empty($this->options['max_height']) ? $this->options['max_height'] : $this->source_height
                    );
            } elseif (!empty($this->options['width']) || !empty($this->options['height'])) {
                $this->target_width = !empty($this->options['width']) ? $this->options['width'] : $this->source_width;
                $this->target_height = !empty($this->options['height']) ? $this->options['height'] : $this->source_height;
            } else {
                $this->target_width = $this->source_width;
                $this->target_height = $this->source_height;
            }
        }
        return $this;
    }

// ----------------
// Process
// ----------------

    /**
     * The filter processing method, must return an image resource
     *
     * @param   string      $target_filename The target filename
     * @return  resource    Returns a resource image of the filtered source, ready to be written in the target file
     * @throws  \RuntimeException if the image can't be created or resized
     */
    public function process( $target_filename )
    {
        $this
            ->calculateSourceHandlerSizes()
            ->calculateTargetSizes();

        $tmp_target = imagecreatetruecolor($this->target_width, $this->target_height);
        if (is_null($tmp_target) || false===$tmp_target) {
            throw new \RuntimeException('Image can not be created!');
        }

        if (
            !imagecopyresized($tmp_target, $this->source_handler, 0, 0, 0, 0,
                $this->target_width, $this->target_height, $this->source_width, $this->source_height)
        ) {
            throw new \RuntimeException('Image can not be resized!');
        }

        return $tmp_target;
    }

}

// Endfile