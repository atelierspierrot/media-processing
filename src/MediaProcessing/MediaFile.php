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

use \WebFilesystem\WebFileInfo;
use \WebFilesystem\WebFilesystem;

/**
 * @author  piwi <me@e-piwi.fr>
 */
class MediaFile
    extends WebFileInfo
{

    protected $client_file_name;

// -----------------
// Constructor
// -----------------

    /**
     * @param   string  $file_name The path of the file
     * @param   string  $client_file_name
     * @param   string  $root_dir The absolute path of the root directory
     */
    public function __construct($file_name, $client_file_name = null, $root_dir = null)
    {
        parent::__construct($file_name, $root_dir);
        if (!is_null($client_file_name)) {
            $this->setClientFilename($client_file_name);
        }
    }

// -----------------
// Getters / Setters
// -----------------

    /**
     * Set the client filename
     *
     * @param   string  $file_name The client filename for the file
     * @return  void
     * @throws  \InvalidArgumentException if the file name is not a string
     */
    public function setClientFilename($file_name)
    {
        if (is_string($file_name)) {
            $this->client_file_name = $file_name;
            $_ext = $this->guessExtension();
            if (!empty($_ext) && !strstr($file_name, $_ext)) {
                $this->client_file_name .= '.'.$_ext;
            }
        } else {
            throw new \InvalidArgumentException(
                sprintf('Client name of a file must be a string (got "%s")!', gettype($file_name))
            );
        }
    }

    /**
     * Get the client filename if so, the filename if not
     *
     * @return string The client filename
     */
    public function getClientFilename()
    {
        return !empty($this->client_file_name) ? $this->client_file_name : $this->getFilename();
    }

    /**
     * Get the filename without extension
     *
     * @return string The isolated filename
     * @see \SplFileInfo::getBasename()
     */
    public function getFilenameWithoutExtension()
    {
        return $this->getBasename('.'.$this->getExtension());
    }

    /**
     * Get the file extension or guess it from MIME type if so ...
     *
     * @return string The guessed extension
     * @see \SplFileInfo::getExtension()
     */
    public function guessExtension()
    {
        $_ext = $this->getExtension();
        if (empty($_ext) && $this->getRealPath()) {
            $finfo = new \finfo();
            $mime = $finfo->file($this->getRealPath(), FILEINFO_MIME_TYPE);
            $_ext = str_replace('image/', '', $mime);
        }
        return $_ext;
    }

    /**
     * Get the file mime string if possible
     *
     * @return string The mime type info
     */
    public function getMime()
    {
        if ($this->getRealPath()) {
            $finfo = new \finfo();
            return $finfo->file($this->getRealPath(), FILEINFO_MIME_TYPE);
        }
        return null;
    }

    /**
     * Get the file size in human readable string
     *
     * @param int $decimals The decimals number to use in calculated file size
     * @return string A human readable string describing a file size
     */
    public function getHumanSize($decimals = 2)
    {
        return WebFilesystem::getTransformedFilesize($this->getSize());
    }

    /**
     * Get the last access time on the file and return it as a DateTime object
     *
     * @return null|object The datetime object if so
     */
    public function getATimeAsDatetime()
    {
        $_date = $this->getATime();
        if (!empty($_date)) {
            return \DateTime::createFromFormat('U', $_date);
        }
        return null;
    }

    /**
     * Get the creation time on the file and return it as a DateTime object
     *
     * @return null|object The datetime object if so
     */
    public function getCTimeAsDatetime()
    {
        $_date = $this->getCTime();
        if (!empty($_date)) {
            return \DateTime::createFromFormat('U', $_date);
        }
        return null;
    }

    /**
     * Get the last modification time on the file and return it as a DateTime object
     *
     * @return null|object The datetime object if so
     */
    public function getMTimeAsDatetime()
    {
        $_date = $this->getMTime();
        if (!empty($_date)) {
            return \DateTime::createFromFormat('U', $_date);
        }
        return null;
    }

    /**
     * Check if a file seems to be an image, based on its mime type signature
     *
     * @return bool True if the file seems to be an image, false otherwise
     */
    public function isImage()
    {
        $finfo = new \finfo();
        return (0!=preg_match('#^image/(.*)$#', $finfo->file($this->getRealPath(), FILEINFO_MIME_TYPE)));
    }
}
