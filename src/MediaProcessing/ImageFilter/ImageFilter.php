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

namespace MediaProcessing\ImageFilter;

use \MediaProcessing\MediaProcessor;
use \MediaProcessing\MediaFile;
use \Library\Helper\Directory as DirectoryHelper;

/**
 */
class ImageFilter
{

    /**
     * @var string
     */
    protected $source_file;

    /**
     * @var array
     */
    protected $filters_stack;

    /**
     * @var array
     */
    protected $filters_options_stack;

    /**
     * @var string
     */
    protected $target_directory;

    /**
     * @var string
     */
    protected $target_filename;

    /**
     * @var string
     */
    protected $target_filename_tmp;

    /**
     * @var string
     */
    public static $tmp_directory;

    /**
     * @param   string      $source The source image path
     * @param   string      $source_content The source image content (only used if no path is set)
     * @param   string|array $filter A filter name or a list of filters
     * @param   array       $filter_options An array of filter options (if the $filter arg is an array, the options must be ordered as $filters)
     * @param   string      $target_filename
     */
    public function __construct(
        $source = null, $source_content = null, $filter = null, $filter_options = null, $target_filename = null
    ) {
        self::$tmp_directory = DirectoryHelper::slashDirname(MediaProcessor::getTemporaryDirectory());
        $this->target_directory = DirectoryHelper::slashDirname(realpath(self::$tmp_directory));
        DirectoryHelper::ensureExists($this->target_directory);
        $this->resetFilters();

        if (!is_null($source)) $this->setSourceFile( $source );
        elseif (!is_null($source_content)) $this->buildSourceFileFromContent( $source_content );

        if (!is_null($target_filename)) $this->setTargetFilename( $target_filename );

        if (!is_null($filter)) {
            if (is_string($filter))
                $this->addFilter( $filter, $filter_options );
            else
                $this->setFilters( $filter, $filter_options );
        }
    }

// ----------------
// Getters / Setters / Resets
// ----------------

    /**
     * Creates and stores a "\MediaProcessing\MediaFile" object of the source file
     *
     * @param   string  $source     the source image file path
     * @return  self
     * @throws  \InvalidArgumentException if the file doesn't exist or is not an image
     */
    public function setSourceFile($source)
    {
        if (@file_exists($source)) {
            $_src = new MediaFile( $source );
            if ($_src->isImage()) {
                $this->source_file = $_src;
            } else {
                throw new \InvalidArgumentException(
                    sprintf('Source file "%s" is not an image!', $source)
                );
            }
        } else {
            throw new \InvalidArgumentException(
                sprintf('Source file not found "%s"!', $source)
            );
        }
        return $this;
    }

    /**
     * Get the source object
     *
     * @return object The SplFileInfo source object
     */
    public function getSourceFile()
    {
        return $this->source_file;
    }

    /**
     * Set the target filename
     *
     * @param   string  $filename
     * @return  self
     */
    public function setTargetFilename($filename)
    {
        $this->target_filename = $filename;
        return $this;
    }

    /**
     * Get the target file name
     *
     * @return string The target filename
     */
    public function getTargetFilename()
    {
        return $this->target_filename;
    }

    /**
     * Get the target file path (web accessible)
     *
     * @return string The target filepath
     */
    public function getTargetWebPath()
    {
        return str_replace($this->target_directory, self::$tmp_directory, $this->target_filename);
    }

    /**
     * Add a filter in the filter stack
     *
     * @param   string  $filter The filter class name
     * @param   array   $filter_options An array of options for the filter
     * @return  self
     */
    public function addFilter($filter, $filter_options = null)
    {
        $_filter_id = uniqid();
        $this->filters_stack[$_filter_id] = $filter;
        $this->filters_options_stack[$_filter_id] = $filter_options;
        return $this;
    }

    /**
     * Add a filter in the filter stack
     *
     * @param   array $filters An array of filter class names
     * @param   array $filters_options An array of options for the all filters, indexed the same way as the filters array
     * @return  self
     * @see     self::addFilter()
     */
    public function setFilters(array $filters, $filters_options = null)
    {
        foreach ($filters as $i=>$_filter) {
            $this->addFilter( $_filter, is_array($filters_options) && isset($filters_options[$i]) ? $filters_options[$i] : null );
        }
        return $this;
    }

    /**
     * Reset the source file object
     *
     * @return self
     */
    public function reset()
    {
        unset($this->source_file);
        return $this;
    }

    /**
     * Reset the filters stack and associated options
     *
     * @return self
     */
    public function resetFilters()
    {
        $this->filters_stack = array();
        $this->filters_options_stack = array();
        return $this;
    }

    /**
     * Get the cached file path if found
     *
     * @param string $filename The filename to search in cache
     * @return bool|string The filename in cache if found, false otherwise
     */
    public function getCache($filename)
    {
        if (file_exists($this->target_directory.$filename))
            return $this->target_directory.$filename;
        return false;
    }

// ----------------
// Process
// ----------------

    /**
     * Process the filters stack on the source
     *
     * @return self $this for method chaining
     * @throws \RuntimeException if the "process" method does not return a resource
     * @throws \RuntimeException if the filter can't be found
     * @throws \RuntimeException if the filter is empty
     */
    public function process()
    {
        $target_filename = $this->source_file->getRealPath();
        $target_extension = $this->source_file->getExtension();

        if (count($this->filters_stack)) {
            foreach ($this->filters_stack as $_id=>$_filter) {
                $_filter_cls = '\\MediaProcessing\\ImageFilter\\Filter\\'.ucfirst($_filter);
                if (class_exists($_filter_cls)) {
                    $_fltr = new $_filter_cls(
                        $this->source_file,
                        $this->buildSourceFileHandler(),
                        is_array($this->filters_options_stack) && isset($this->filters_options_stack[$_id]) ?
                            $this->filters_options_stack[$_id] : null
                    );

                    $_target_tmp_fn = $_fltr->getTargetFilename( $this->getTargetFilename() );
                    $_target_tmp_fn = md5($_target_tmp_fn);

                    if ($_cached = $this->getCache( $_target_tmp_fn.'.'.$target_extension )) {
                        $this->setTargetFilename( $_cached );
                    } else {
                        $_target_tmp = $_fltr->process( $this->target_directory.$_target_tmp_fn );
                        if (!is_resource($_target_tmp)) {
                            throw new \RuntimeException(
                                sprintf('The "%s" image filter "process()" method must return a resource (got "%s")!',
                                $_filter, gettype($_target_tmp))
                            );
                        }
                        $this->setTargetFilename(
                            $this->writeTargetFileHandler( $_target_tmp, $_target_tmp_fn.'.'.$target_extension )
                        );
                    }
                } else {
                    throw new \RuntimeException(
                        sprintf('Image filter "%s" not found!', $_filter)
                    );
                }
            }
        } else {
            throw new \RuntimeException('No filter to process!');
        }

        if (!empty($this->target_filename_tmp)) {
            @unlink($this->target_filename_tmp);
            unset($this->target_filename_tmp);
        }
        return $this;
    }

    /**
     * Build a resource to handle source file with the same MIME type as source
     *
     * @return resource An image resource
     * @throws \RuntimeException if the extension is not standard
     */
    public function buildSourceFileHandler()
    {
        $_ext = $this->source_file->getExtension();
        if (strtolower($_ext)==='jpg') $_ext = 'jpeg';
        $_fct = 'imagecreatefrom'.strtolower($_ext);
        if (function_exists($_fct)) {
            return $_fct( $this->source_file->getRealPath() );
        } else {
            throw new \RuntimeException(
                sprintf('Unknown image extension "%s" for resource creation!', $_ext)
            );
        }
    }

    /**
     * Write the target handler in a real file
     *
     * @param resource $_handler The resource image handler to write in the target file
     * @param string $filename The filename to write in
     * @return bool True if the file had been created and written
     * @throws \RuntimeException if the extension is not standard
     */
    public function writeTargetFileHandler($_handler, $filename)
    {
        $_ext = $this->source_file->getExtension();
        if (strtolower($_ext)==='jpg') $_ext = 'jpeg';
        $_fct = 'image'.$_ext;
        if (function_exists($_fct)) {
            $_fct( $_handler, $this->target_directory.$filename );
            return $this->target_directory.$filename;
        } else {
            throw new \RuntimeException(
                sprintf('Unknown image extension "%s" for file creation!', $_ext)
            );
        }
        return false;
    }

// ----------------
// Utilities
// ----------------

    /**
     * Create a file with the image content to work on and returns the created filename
     *
     * If the process was ok, the result is loaded in the object $source_file property
     * @param string $source_content The source image content
     * @return void
     * @see self::setSourceFile()
     */
    public function buildSourceFileFromContent($source_content)
    {
        $finfo = new \finfo();
        $mime = $finfo->buffer( $source_content, FILEINFO_MIME_TYPE );
        $extension = str_replace('image/', '', $mime);
        $_tmp_filename = 'tmp_'.time().'.'.$extension;
        $_tmp_filepath = $this->target_directory.$_tmp_filename;
        $_tf = fopen($_tmp_filepath, 'a+');
        if ($_tf) {
            fwrite($_tf, $source_content);
            fclose($_tf);
            $this->target_filename_tmp = $_tmp_filepath;
            return $this->setSourceFile( $_tmp_filepath );
        }
        return null;
    }

    /**
     * Recalculate width & height conserving the original ratio
     *
     * @param int $original_width The original width value, in pixels
     * @param int $original_height The original height value, in pixels
     * @param int $max_width The maximum width value, in pixels
     * @param int $max_height The maximum height value, in pixels
     * @param bool $associative If true, the method will return an associative array : array( 'width'=>XX, 'height'=>YY )
     * @return array An simple width and height list if $associative is false : array( XX, YY )
     */
    public static function resizeWidthHeight(
        $original_width = 0, $original_height = 0, $max_width = 0, $max_height = 0, $associative = false
    ) {
        if (
            $original_width<$max_width &&
            $original_height<$max_height
        ) {
            $width_new = $original_width;
            $height_new = $original_height;
        } elseif ($original_width>$original_height) {
            $width_new = $max_width;
            $height_new = round( ($max_width/$original_width)*$original_height );
        } else {
            $height_new = $max_height;
            $width_new = round( ($max_height/$original_height)*$original_width );
        }
        return true===$associative ? array('width'=>$width_new, 'height'=>$height_new) : array($width_new, $height_new);
    }

}

// Endfile