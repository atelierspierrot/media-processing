<?php
/**
 * Media Processing package of Les Ateliers Pierrot
 * Copyleft (c) 2013 Pierre Cassat and contributors
 * <www.ateliers-pierrot.fr> - <contact@ateliers-pierrot.fr>
 * License GPL-3.0 <http://www.opensource.org/licenses/gpl-3.0.html>
 * Sources <https://github.com/atelierspierrot/media-processing>
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
     * @param string $target_filename The target filename
     * @return string A unique and constant filename depending on filter settings and source file with NO extension
     */
    public function getTargetFilename( $target_filename );

    /**
     * The filter processing method, must return an file resource
     *
     * @param string $target_filename The target filename
     * @return resource Returns a resource image of the filtered source, ready to be written in the target file
     */
    public function process( $target_filename );
}

// Endfile