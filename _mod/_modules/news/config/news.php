<?php defined('SYSPATH') or die('No direct script access.');

// Module name initialize
$config['module_name']		= 'news';

// Model List
$config['models']		= array('News','NewsContent','NewsFile','NewsFilesFile');

// Module Menu List
$config['module_menu']	= array(
							'news/index'          => 'News & Event Listings',
						);

// Module Function
$config['module_function']	= array(
                                        'news/add'	=> 'Add New News',
                                        'news/view'	=> 'View News Details',
                                        'news/edit'	=> 'Edit News Details',
                                        'news/delete' => 'Delete News',
										'news/change' => 'Update News Status',
										'news/fileupload' => 'Upload Files',
										'news/filedelete' => 'Delete Files',
										'news/filechange' => 'Change Files'
                                    );

$config['upload_path'] = DOCROOT.'uploads/news/';
$config['upload_url']  = 'uploads/news/';

$config['files_upload_path'] = DOCROOT.'uploads/news/files/';
$config['files_upload_url']  = 'uploads/news/files/';

// Readable mime Properties
$config['readable_mime'] = array(
    'image/gif',
    'image/jpg',
    'image/jpeg',
    'image/png',
    'video/x-flv',
    'video/flv',
    'audio/mpeg'
);
$config['mime_icon'] = array(
    'image/gif' => 'picture.png',
    'image/jpg' => 'picture.png',
    'image/jpeg' => 'picture.png',
    'image/png' => 'picture.png',
    'video/x-flv' => 'film.png',
    'video/flv' => 'film.png',
    'audio/mpeg' => 'sound.png'
);

// Image Thumbs and Crop Properties
$config['image'] = array(
			'ratio' => 'auto',
			'thumbnails' => array(
				'80x80',
				'248x158',
				'632x384'
			),
			'crop'	=> array(
					array(
							'80x80',
							'248x158',
							'632x384'
						),
					'center',
					)
		);

// News Field in form
$config['news_fields'] = array(
			'show_synopsis' => TRUE,
			'show_upload' => TRUE,
			'uploads' => array(
				'image_1' => array(
					'label' => 'Cover Thumbnail',
					'caption' => FALSE,
					'optional' => TRUE,
					'file_type' => 'gif,jpg,png',
					'max_file_size' => '1M',
					'note' => 'Allowed file types are gif, jpg ,png. Best Resolution is up to '.$config['image']['thumbnails'][0].'px',
					'image_manipulation' =>$config['image'],
				),
			)
		);

// Translate field schema
$config['translate'] = array(
	'subject'	=> array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 124),
	//'name'		=> array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 124),
	'synopsis'	=> array('type' => 'text', 'null' => false, 'default' => NULL, 'length' => NULL),
	'text'		=> array('type' => 'text', 'null' => false, 'default' => NULL, 'length' => NULL),
	);
/**
 * Generate the code for a table. Takes a table name and $fields array
 * Returns a completed variable declaration to be used in schema classes
 *
 * @param string $table Table name you want returned.
 * @param array $fields Array of field information to generate the table with.
 * @return string Variable declaration for a schema class
 */

/* function generateTable($table, $fields) {
		$out = "\tvar \${$table} = array(\n";
		if (is_array($fields)) {
			$cols = array();
			foreach ($fields as $field => $value) {
				if ($field != 'indexes' && $field != 'tableParameters') {
					if (is_string($value)) {
						$type = $value;
						$value = array('type'=> $type);
					}
					$col = "\t\t'{$field}' => array('type' => '" . $value['type'] . "', ";
					unset($value['type']);
					$col .= join(', ',  $this->__values($value));
				} elseif ($field == 'indexes') {
					$col = "\t\t'indexes' => array(";
					$props = array();
					foreach ((array)$value as $key => $index) {
						$props[] = "'{$key}' => array(" . join(', ',  $this->__values($index)) . ")";
					}
					$col .= join(', ', $props);
				} elseif ($field == 'tableParameters') {
					//@todo add charset, collate and engine here
					$col = "\t\t'tableParameters' => array(";
					$props = array();
					foreach ((array)$value as $key => $param) {
						$props[] = "'{$key}' => '$param'";
					}
					$col .= join(', ', $props);
				}
				$col .= ")";
				$cols[] = $col;
			}
			$out .= join(",\n", $cols);
		}
		$out .= "\n\t);\n";
		return $out;
	}
 */
// Default Views
$config['default'] = array (
            'view'=> 'news/default',
        );

return array_merge_recursive (
	$config
);