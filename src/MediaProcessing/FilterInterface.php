<?php
/**
 * This file is part of the MediaProcessing package.
 *
 * Copyright (c) 2013-2015 Pierre Cassat <me@e-piwi.fr> and contributors
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

/**
 */
interface FilterInterface
{

    /**
     * Build the target filename
     *
     * This filename must be unique and constant for a specific source and the filter settings
     * to allow caching the result file, and retrieving it.
     *
     * @param   string  $target_filename The target filename
     * @return  string  A unique and constant filename depending on filter settings and source file with NO extension
     */
    public function getTargetFilename( $target_filename );

    /**
     * The filter processing method, must return an file resource
     *
     * @param   string      $target_filename The target filename
     * @return  resource    Returns a resource image of the filtered source, ready to be written in the target file
     */
    public function process( $target_filename );

}

// Endfile