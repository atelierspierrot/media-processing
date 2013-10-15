<?php
/**
 * Media Processing package of Les Ateliers Pierrot
 * Copyleft (c) 2013 Pierre Cassat and contributors
 * <www.ateliers-pierrot.fr> - <contact@ateliers-pierrot.fr>
 * License GPL-3.0 <http://www.opensource.org/licenses/gpl-3.0.html>
 * Sources <https://github.com/atelierspierrot/media-processing>
 */

namespace MediaProcessing;

use \MediaProcessing\MediaFile;

/**
 */
abstract class AbstractFilter
{

	protected $source_file;
	protected $source_handler;
	protected $target_filename;

	protected $options = array();

    /**
     * Construction of a filter
     *
     * @param object $source_file The source file to work on, as a "\MediaProcessing\MediaFile" object
     * @param resource $source_handler A resource of temporary image created in MIME type of the source
     * @param array $options A set of options to override default options
     *
     * @throws InvalidArgumentException if the `$source_handler` is not a valid resource
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