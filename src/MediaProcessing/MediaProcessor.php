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

use \Library\Helper\Directory as DirectoryHelper;

/**
 * @author  piwi <me@e-piwi.fr>
 */
class MediaProcessor
{

    /**
     * @var string
     */
    public static $tmp_directory = 'tmp';

    /**
     * Sets the temporary directory
     * @param   string $path the directory path
     * @return  void
     * @throws  \InvalidArgumentException if the path doesn't exist and can't be created
     */
    public static function setTemporaryDirectory($path)
    {
        $exists = DirectoryHelper::ensureExists($path);
        if (@file_exists($path)) {
            self::$tmp_directory = $path;
        } else {
            throw new \InvalidArgumentException(
                sprintf('Directory "%s" can not be found and can not be created!', $path)
            );
        }
    }

    /**
     * Gets the temporary directory
     *
     * @return  string
     * @throws  \InvalidArgumentException if the path doesn't exist and can't be created
     */
    public static function getTemporaryDirectory()
    {
        $exists = DirectoryHelper::ensureExists(self::$tmp_directory);
        if (@file_exists(self::$tmp_directory)) {
            return self::$tmp_directory;
        } else {
            throw new \InvalidArgumentException(
                sprintf('Directory "%s" can not be found and can not be created!', self::$tmp_directory)
            );
        }
    }

// ---------------------
// Create a file from a content string
// ---------------------

    /**
     * Create a file with a content string and returns the created filename
     *
     * @param   string $file_content The source file content
     * @param   string $filename The target filename (optional - automatic if not set)
     * @param   string  $client_file_name
     * @param   string  $return Name of the class to return
     * @return  \MediaProcessing\MediaFile
     */
    public static function createFromContent($file_content, $filename = null, $client_file_name = null, $return = '\MediaProcessing\MediaFile')
    {
        $finfo = new \finfo();
        $mime = $finfo->buffer($file_content, FILEINFO_MIME_TYPE);
        $extension = end(explode('/', $mime));
        if (is_null($filename)) {
            $_tmp_filename = md5( $file_content ).'.'.$extension;
            $filename = self::getTemporaryDirectory().$_tmp_filename;
            if (file_exists($filename)) {
                return new $return($filename, $client_file_name);
            }
        } elseif (end(explode('.', $filename))!=$extension) {
            $filename .= '.'.$extension;
        }

        $_tf = fopen($filename, 'a+');
        if ($_tf) {
            fwrite($_tf, $file_content);
            fclose($_tf);
            return new $return($filename, $client_file_name);
        }
        return null;
    }

}

// Endfile