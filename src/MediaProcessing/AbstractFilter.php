<?php
/**
 * Media Processing package of Les Ateliers Pierrot
 * Copyleft (ↄ) 2013-2015 Pierre Cassat and contributors
 * <www.ateliers-pierrot.fr> - <contact@ateliers-pierrot.fr>
 * License GPL-3.0 <http://www.opensource.org/licenses/gpl-3.0.html>
 * Sources <http://github.com/atelierspierrot/media-processing>
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
 */

namespace MediaProcessing;

use \MediaProcessing\MediaFile;

/**
 */
abstract class AbstractFilter
{

    /**
     * @var \MediaProcessing\MediaFile
     */
    protected $source_file;

    /**
     * @var resource
     */
    protected $source_handler;

    /**
     * @var string
     */
    protected $target_filename;

    /**
     * @var array
     */
    protected $options = array();

    /**
     * Construction of a filter
     *
     * @param   \MediaProcessing\MediaFile $source_file The source file to work on
     * @param   resource $source_handler A resource of temporary image created in MIME type of the source
     * @param   array $options A set of options to override default options
     * @throws  \InvalidArgumentException if the `$source_handler` is not a valid resource
     */
    public function __construct(MediaFile $source_file, $source_handler, $options = null)
    {
        $this->source_file = $source_file;
        if (!is_resource($source_handler)) {
            throw new \InvalidArgumentException(
                sprintf('The second argument of a filter constructor must be a resource (got "%s" for filter "%s")!',
                    gettype($source_handler), get_class($this))
            );
        }
        $this->source_handler = $source_handler;
        if (!is_null($options)) {
            $this->options = array_merge($this->options, $options);
        }
    }

}

// Endfile