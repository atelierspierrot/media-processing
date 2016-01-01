<?php
/**
 * This file is part of the MediaProcessing package.
 *
 * Copyright (c) 2013-2016 Pierre Cassat <me@e-piwi.fr> and contributors
 * 
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 * 
 *      http://www.apache.org/licenses/LICENSE-2.0
 * 
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * The source code of this package is available online at 
 * <http://github.com/atelierspierrot/media-processing>.
 */

namespace MediaProcessing;

use \MediaProcessing\MediaFile;

/**
 * @author  piwi <me@e-piwi.fr>
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
