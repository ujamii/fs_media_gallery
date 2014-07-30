<?php
namespace MiniFranske\FsMediaGallery\Utility;

/*                                                                        *
 * Inspired by Tx_News_Utility_TypoScript                                 *
 *                                                                        *
 * This script is part of the TYPO3 project.                              *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU Lesser General Public License, either version 3   *
 * of the License, or (at your option) any later version.                 *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */

/**
 * TypoScript Utility class
 */
class TypoScriptUtility implements \TYPO3\CMS\Core\SingletonInterface {

	/**
	 * @param array $base
	 * @param array $overload
	 * @return array
	 */
	public function override(array $base, array $overload) {
		$validFields = \TYPO3\CMS\Core\Utility\GeneralUtility::trimExplode(',', $overload['settings']['overrideFlexformSettingsIfEmpty'], TRUE);
		foreach ($validFields as $fieldName) {

			// Multilevel field
			if (strpos($fieldName, '.') !== FALSE) {
				$keyAsArray = explode('.', $fieldName);

				$foundInCurrentTs = self::getValue($base, $keyAsArray);

				if (is_string($foundInCurrentTs) && strlen($foundInCurrentTs) === 0) {
					$foundInOriginal = self::getValue($overload['settings'], $keyAsArray);
					if ($foundInOriginal) {
						$base = self::setValue($base, $keyAsArray, $foundInOriginal);
					}
				}
			} else {
				// if flexform setting is empty and value is available in TS
				if ((!isset($base[$fieldName]) || (strlen($base[$fieldName]) === 0))
					&& isset($overload['settings'][$fieldName])
				) {
					$base[$fieldName] = $overload['settings'][$fieldName];
				}
			}
		}
		return $base;
	}

	/**
	 * Get value from array by path
	 *
	 * @param array $data
	 * @param array $path
	 * @return array|null
	 */
	protected function getValue(array $data, array $path) {
		$found = TRUE;

		for ($x = 0; ($x < count($path) && $found); $x++) {
			$key = $path[$x];

			if (isset($data[$key])) {
				$data = $data[$key];
			} else {
				$found = FALSE;
			}
		}

		if ($found) {
			return $data;
		}
		return NULL;
	}

	/**
	 * Set value in array by path
	 *
	 * @param array $array
	 * @param $path
	 * @param $value
	 * @return array
	 */
	protected function setValue(array $array, $path, $value) {
		self::setValueByReference($array, $path, $value);

		$final = array_merge_recursive(array(), $array);
		return $final;
	}

	/**
	 * Set value by reference
	 *
	 * @param array $array
	 * @param array $path
	 * @param $value
	 */
	private function setValueByReference(array &$array, array $path, $value) {
		while (count($path) > 1) {
			$key = array_shift($path);
			if (!isset($array[$key])) {
				$array[$key] = array();
			}
			$array = & $array[$key];
		}

		$key = reset($path);
		$array[$key] = $value;
	}

}
