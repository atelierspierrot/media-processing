<?php
/**
 * Media Processing package of Les Ateliers Pierrot
 * Copyleft (c) 2013 Pierre Cassat and contributors
 * <www.ateliers-pierrot.fr> - <contact@ateliers-pierrot.fr>
 * License GPL-3.0 <http://www.opensource.org/licenses/gpl-3.0.html>
 * Sources <https://github.com/atelierspierrot/media-processing>
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
	 * @param string the directory path
	 * @return void
	 * @throw Throws an InvalidArgumentException if the path doesn't exist and can't be created
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
	 * @return string
	 * @throw Throws an InvalidArgumentException if the path doesn't exist and can't be created
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
	 * @param string $file_content The source file content
	 * @param string $filename The target filename (optional - automatic if not set)
	 * @return object An instance of \Lib\File class created on the result file
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