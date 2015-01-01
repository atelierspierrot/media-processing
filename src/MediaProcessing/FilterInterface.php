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