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

use \Library\Helper\Directory as DirectoryHelper;

/**
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