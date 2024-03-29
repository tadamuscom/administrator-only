<?php
/**
 * Holds the loader class
 *
 * @package administrator-only
 */

namespace Admon\Includes;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'Loader' ) ) {
	/**
	 * Responsible to load all the files in the plugin
	 */
	class Loader {
		/**
		 * Calls all the sub methods that require the files
		 *
		 * @since 1.0.0
		 *
		 * @return void
		 */
		public function __construct() {
			$this->require_child_files_once( ADMON_INC );
		}

		/**
		 * Requires all the PHP files in the given directory
		 *
		 * @since 1.0.0
		 *
		 * @param string $dir The path of the directory.
		 *
		 * @return void
		 */
		private function require_child_files_once( string $dir ): void {
			foreach ( $this->get_files( $dir ) as $file ) {
				require_once $file;
			}
		}

		/**
		 * Loops through a directory and returns an array of PHP files
		 *
		 * @since 1.0.0
		 *
		 * @param mixed $dir The directory.
		 *
		 * @return array
		 */
		private function get_files( mixed $dir ): array {
			$dir_object = new \DirectoryIterator( $dir );
			$returnable = array();

			foreach ( $dir_object as $file ) {
				if ( $file->isDot() ) {
					continue;
				}

				if ( $file->isDir() ) {
					$returnable = array_merge( $returnable, $this->get_files( $dir . '/' . $file ) );
				}

				if ( 'php' !== $file->getExtension() ) {
					continue;
				}

				$returnable[] = $dir . '/' . $file->getFilename();
			}

			return $returnable;
		}
	}

	new Loader();
}
