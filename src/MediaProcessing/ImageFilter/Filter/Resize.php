<?php
/**
 * Media Processing package of Les Ateliers Pierrot
 * Copyleft (c) 2013 Pierre Cassat and contributors
 * <www.ateliers-pierrot.fr> - <contact@ateliers-pierrot.fr>
 * License GPL-3.0 <http://www.opensource.org/licenses/gpl-3.0.html>
 * Sources <https://github.com/atelierspierrot/media-processing>
 */

namespace MediaProcessing\ImageFilter\Filter;

use MediaProcessing\AbstractFilter,
    MediaProcessing\FilterInterface,
    MediaProcessing\ImageFilter\ImageFilter;

/**
 */
class Resize extends AbstractFilter implements FilterInterface
{

	protected $options = array(
		'width'=>200,
		'height'=>200,
		'max_width'=>200,
		'max_height'=>200
	);
	
	protected $source_width;
	protected $source_height;
	protected $target_width;
	protected $target_height;

// ----------------
// Getters / Setters
// ----------------

	/**
	 * Build the target filename
	 *
	 * This filename must be unique and constant for a specific source and the filter settings
	 * to allow caching the result image, and retrieving it.
	 * @param string $target_filename The target filename
	 * @return string A unique and constant filename depending on filter settings and source file with NO extension
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
	 * @return void
	 */
	public function calculateSourceHandlerSizes()
	{
		if (!empty($this->source_width) && !empty($this->source_height)) return;

		$this->source_width = imagesx($this->source_handler);
		$this->source_height = imagesy($this->source_handler);
	}

	/**
	 * Calculate the target image width & height from the source sizes and setted options
	 * @return void
	 */
	public function calculateTargetSizes()
	{
		if (!empty($this->target_width) && !empty($this->target_height)) return;
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

// ----------------
// Process
// ----------------

	/**
	 * The filter processing method, must return an image resource
	 * @param string $target_filename The target filename
	 * @return resource Returns a resource image of the filtered source, ready to be written in the target file
	 */
	public function process( $target_filename )
	{
		$this->calculateSourceHandlerSizes();
		$this->calculateTargetSizes();

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