<?php
if(!defined('TYPO3_MODE')) {
	die('Access denied.');
}

/**
 * Extract list of FontAwesome Icons from CSS-File
 *
 * @author Boris
 * @since 05.09.2014
 *
 * @return array
 */
if(!function_exists('TrbBasicGetFontAwesomeIcons')) {
	function TrbBasicGetFontAwesomeIcons() {
		//Prepare result
		$result		= array();

		//Get path
		$path	= \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('trb_basics_fontawesome').'/Resources/Public/FontAwesome/css/font-awesome.css';

		//Get content
		$content	= file_get_contents($path);

		//Get icons
		preg_match_all('"\.(fa-[^:].*):before"', $content, $icons);
		$icons	= $icons[1];

		//Setup result
		foreach($icons as $icon_class) {
			$icon_label				= ucwords(implode(' ', explode('-', strtolower(substr($icon_class, 3)))));
			$result[$icon_label]	= array($icon_label, $icon_class);
		}

		//Sort icons
		ksort($result);

		//Get values
		$result		= array_merge(array(array('-', '')), array_values($result));

		//Deliver
		return $result;
	}
}

/*
 * SETUP COLUMNS
 */
$columns	= array(
	'tx_trb_basics_fontawesome_icon' => array (
		'exclude' => 0,
		'label' => 'LLL:EXT:trb_basics_fontawesome/Resources/Private/Language/locallang_db.xlf:tt_content.column.tx_trb_basics_fontawesome_icon',
		'config' => array (
			'type' => 'select',
			'items' => TrbBasicGetFontAwesomeIcons(),
		)
	),
);


/*
 * REGISTER COLUMNS
*/
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('tt_content', $columns);

