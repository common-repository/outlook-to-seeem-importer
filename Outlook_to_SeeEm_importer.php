<?php
/*
Plugin Name: Outlook to SeeEm Importer
Description: Import contacts for SeeEm Contact Manager from an Outlook CSV file.
Version: 0.1.2
Author: Brad Allured
*/

/**
 * Wordpress plugin for importing contacts for SeeEm Contact Manager from an Outlook CSV file.
 * Inspired by CSV Importer, by Denis Kobozev, and found at http://wordpress.org/extend/plugins/csv-importer/
 *
 * LICENSE: The MIT License {{{
 *
 * Copyright (c) <2010> <Brad Allured>
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * Note: Parts of the code in this plugin uses, is inspired by, and/or originated
 * in code written and copyrighted by <Denis Kobozev> in <2009> from <csv_importer>.
 * Please view those products and respect their licenses and copyrights.
 *
 * @author    Brad Allured <Schneidley@gmail.com>
 * @copyright 2010 Brad Allured
 * @license   The MIT License
 * }}}
 */

class CSVImporterPlugin {
    var $reserved_fields = array(
        'Title',
        'First Name',
        'Middle Name',
        'Last Name',
        'Suffix',
		'Company',
		'Department',
		'Job Title',
		'Business Street',
		'Business Street 2',
		'Business Street 3',
		'Business City',
		'Business State',
		'Business Postal Code',
		'Business Country/Region',
		'Home Street',
		'Home Street 2',
		'Home Street 3',
		'Home City',
		'Home State',
		'Home Postal Code',
		'Home Country/Region',
		'Other Street',
		'Other Street 2',
		'Other Street 3',
		'Other City',
		'Other State',
		'Other Postal Code',
		'Other Country/Region',
		'Assistant\'s Phone',
		'Business Fax',
		'Business Phone',
		'Business Phone 2',
		'Callback',
		'Car Phone',
		'Company Main Phone',
		'Home Fax',
		'Home Phone',
		'Home Phone 2',
		'ISDN',
		'Mobile Phone',
		'Other Fax',
		'Other Phone',
		'Pager',
		'Primary Phone',
		'Radio Phone',
		'TTY/TDD Phone',
		'Telex',
		'Account',
		'Anniversary',
		'Assistant\'s Name',
		'Billing Information',
		'Birthday',
		'Business Address PO Box',
		'Categories',
		'Children',
		'Directory Server',
		'E-mail Address',
		'E-mail Type',
		'E-mail Display Name',
		'E-mail 2 Address',
		'E-mail 2 Type',
		'E-mail 2 Display Name',
		'E-mail 3 Address',
		'E-mail 3 Type',
		'E-mail 3 Display Name',
		'Gender',
		'Govenment ID Number',
		'Hobby',
		'Home Address PO Box',
		'Initials',
		'Internet Free Busy',
		'Keywords',
		'Language',
		'Location',
		'Manager\'s Name',
		'Mileage',
		'Notes',
		'Office Location',
		'Organizational ID Number',
		'Other Address PO Box',
		'Priority',
		'Private',
		'Profession',
		'Referred By',
		'Sensitivity',
		'Spouse',
		'User 1',
		'User 2',
		'User 3',
		'User 4',		
		'Web Page',		
    );

    // option name => default value
    var $options = array(
        'SeeEm_importer_import_as_draft' => 'publish',
        'SeeEm_importer_import_update' => '0',
		'Seeem_importer_import_delete' => '0',
    );

    var $log = array();

    // A bit of abstraction above WordPress option saving mechanism to
    // make our life easier
    function save_options($request) {
        foreach ($this->options as $opt_name => $default) {
            $value = $default;
            if (array_key_exists($opt_name, $request)) {
                $value = $request[$opt_name];
            }
            if (false === get_option($opt_name)) {
                add_option($opt_name, $value);
            } else {
                update_option($opt_name, $value);
            }
        }
    }

    function get_option($opt_name) {
        if (($value = get_option($opt_name)) === false) {
            $value = $this->options[$opt_name];
        }
        return $value;
    }

    // Plugin's interface
    function form() {
        if ('POST' == $_SERVER['REQUEST_METHOD']) {
            $this->save_options($_POST);
            $this->post();
        }

        $opt_draft = $this->get_option('SeeEm_importer_import_as_draft');
        $opt_up = $this->get_option('SeeEm_importer_import_update');
		$opt_del = $this->get_option('SeeEm_importer_import_delete');

        // form HTML {{{
?>
        
<div class="wrap">
    <h2>Import CSV</h2>
    <form class="add:the-list: validate" method="post" enctype="multipart/form-data">
    <table class="form-table">
        <tr class="form-field form-required">
            <th scope="row" valign="top"><label for="SeeEm_import_as_draft">Import posts as drafts</label></th>
            <td>
                <input name="SeeEm_importer_import_as_draft" id="SeeEm_importer_import_as_draft" type="checkbox"
                    <?php if ('draft' == $opt_draft) { echo 'checked="checked"'; } ?> value="draft" />
            </td>
        </tr>
        <tr class="form-field form-required">
            <th scope="row" valign="top"><label for="SeeEm_import_as_draft">Update existing contacts from file</label></th>
            <td>
                <input name="SeeEm_importer_import_update" id="SeeEm_importer_import_update" type="checkbox"
                    <?php if ('1' == $opt_up) { echo 'checked="checked"'; } ?> value="1" />
            </td>
        </tr>
        <tr class="form-field form-required">
            <th scope="row" valign="top"><label for="SeeEm_import_as_draft">Delete contact details not in file for updated contacts</label></th>
            <td>
                <input name="SeeEm_importer_import_delete" id="SeeEm_importer_import_delete" type="checkbox"
                    <?php if ('1' == $opt_up) { echo 'checked="checked"'; } ?> value="1" />
            </td>
        </tr>
        <tr class="form-field form-required">
            <th scope="row" valign="top"><label for="SeeEm_import">Upload file</label></th>
            <td><input name="SeeEm_import" id="SeeEm_import" type="file" value="" aria-required="true" /></td>
        </tr>
    </table>
    <p class="submit"><input type="submit" class="button" name="submit" value="Import" /></p>
    </form>
</div><!-- end wrap -->

<?php
        // end form HTML }}}

    }

    function print_messages() {
        if (!empty($this->log)) {

        // messages HTML {{{
?>

<div class="wrap">
    <?php if (!empty($this->log['error'])): ?>

    <div class="error">    

        <?php foreach ($this->log['error'] as $error): ?>
            <p><?php echo $error; ?></p>
        <?php endforeach; ?>

    </div>

    <?php endif; ?>

    <?php if (!empty($this->log['notice'])): ?>

    <div class="updated fade">

        <?php foreach ($this->log['notice'] as $notice): ?>
            <p><?php echo $notice; ?></p>
        <?php endforeach; ?>

    </div>

    <?php endif; ?>
</div><!-- end wrap -->

<?php
        // end messages HTML }}}

            $this->log = array();
        }
    }
	

    // Handle POST submission
    function post() {
        if (empty($_FILES['SeeEm_import']['tmp_name'])) {
            $this->log['error'][] = 'No file uploaded, aborting.';
            $this->print_messages();
            return;
        }

        require_once 'File_CSV_DataSource/DataSource.php';

        $csv = new File_CSV_DataSource;
        $file = $_FILES['SeeEm_import']['tmp_name'];
        $this->stripBOM($file);

        if (!$csv->load($file)) {
            $this->log['error'][] = 'Failed to load file, aborting.';
            $this->print_messages();
            return;
        }
		
		require_once 'File_CSV_DataSource/edit.php';
		
		// pad shorter rows with empty values
		$csv->symmetrize();

        $skipped = 0;
        $imported = 0;
        foreach ($csv->connect() as $csv_arr) {
            $csv_data = array(
				'dcm_description' => $csv_arr['Title'].' '.$csv_arr['First Name'].' '.$csv_arr['Middle Name'].' '.$csv_arr['Last Name'].' '.$csv_arr['Suffix'],
				'crm_p_name_prefix' => $csv_arr['Title'],
				'crm_p_name_first' => $csv_arr['First Name'],
				'crm_p_name_middle' => $csv_arr['Middle Name'],
				'crm_p_name_last' => $csv_arr['Last Name'],
				'crm_p_name_suffix' => $csv_arr['Suffix'],
				'crm_p_name_nick' => '',
				'crm_p_name_title' => $csv_arr['Job Title'],
				'crm_p_adr_1st_street' => $csv_arr['Business Street'],
				'crm_p_adr_1st_unit' => $csv_arr['Business Street 2'],
				'crm_p_adr_1st_city' => $csv_arr['Business City'],
				'crm_p_adr_1st_stateprov' => $csv_arr['Business State'],
				'crm_p_adr_1st_zip' => $csv_arr['Business Postal Code'],
				'crm_p_adr_1st_country' => $csv_arr['Business Country/Region'],
				'crm_p_email_1' => $csv_arr['E-mail Address'],
				'crm_p_email_2' => $csv_arr['E-mail 2 Address'],
				'crm_p_phone_1' => $csv_arr['Business Phone'],
				'crm_p_phone_2' => $csv_arr['Mobile Phone'],
				'crm_p_phone_3' => $csv_arr['Pager'],
				'crm_p_company_url' => $csv_arr['Web Page'],
				'Note' => $csv_arr['Notes'],
			);
			$edited = edit_tags($csv_data);
			if ($edited != true) {
				if (($post_id = $this->create_post($csv_data)) !== false) {
					$imported++;

                	wp_set_post_tags($post_id, 'contact', true);
             		wp_set_post_categories($post_id, $this->create_categories($csv_data));
                	$this->create_custom_fields($post_id, $csv_data);
            	} else {
                	$skipped++;
            	}
			}
        }

        if (file_exists($file)) {
            @unlink($file);
        }

        if ($skipped) {
            $this->log['notice'][] = "<b>Skipped {$skipped} posts due to empty title and body.</b>";
        }
        $this->log['notice'][] = "<b>Imported {$imported} posts.</b>";
        $this->print_messages();
    }

    function create_post($data) {
        $status = $this->get_option('SeeEm_importer_import_as_draft');
        $new_post = array(
            'post_title' => convert_chars($data['crm_p_name_first'].' '.$data['crm_p_name_last']),
            'post_content' => wpautop(convert_chars(' ')),
            'post_status' => $status, 
            'post_type' => 'post',
            'post_date' => date('Y-m-d H:i:s'),
            'post_excerpt' => convert_chars($data['Note']),
        );

        if (empty($new_post['post_title']) and empty($new_post['post_content'])) {
            return false;
        }

        return wp_insert_post($new_post);
    }

    // Lookup existing categories or create new ones
    function create_categories($data) {
        $ids = array();
        $cat_name = 'uncatecorized';
        $cat_name = trim($cat_name);

            if (!empty($cat_name)) {
                if (is_numeric($cat_name)) {
                    // it's an id, not a name
                    if (null !== get_category($cat_name)) {
                        $ids[] = $cat_name;
                    } else {
                        $this->log['error'][] = "There is no category with id {$cat_name}.";
                    }
                } else {
                    $cat_id = get_cat_ID($cat_name);
                    if ($cat_id == 0) {
                        $category = array(
                            'cat_name' => $cat_name,
                            'category_description' => '',
                            'category_nicename' => sanitize_title($cat_name),
                            'category_parent' => 0,
                        );
                        $cat_id = wp_insert_category($category);
                    }
                    $ids[] = $cat_id;
                }
            }
        return $ids;
    }

    function create_custom_fields($post_id, $data) {
        foreach ($data as $k => $v) {
            if ((array_search($k, $this->reserved_fields) === false) && $v != '' && $k != '') {
                add_post_meta($post_id, $k, $v);
            }
        }
    }

    // Convert date in CSV file to 1999-12-31 23:52:00 format
    function parse_date($data) {
        $timestamp = strtotime($data['csv_post_date']);
        if (false === $timestamp) {
            return '';
        } else {
            return date('Y-m-d H:i:s', $timestamp);
        }
    }

    // delete BOM from UTF-8 file
    function stripBOM($fname) {
        $res = fopen($fname, 'rb');
        if (false !== $res) {
            $bytes = fread($res, 3);
            if ($bytes == pack('CCC', 0xef, 0xbb, 0xbf)) {
                $this->log['notice'][] = 'Getting rid of byte order mark...';
                fclose($res);

                $contents = file_get_contents($fname);
                if (false === $contents) {
                    trigger_error('Failed to get file contents.', E_USER_WARNING);
                }
                $contents = substr($contents, 3);
                $success = file_put_contents($fname, $contents);
                if (false === $success) {
                    trigger_error('Failed to put file contents.', E_USER_WARNING);
                }
            } else {
                fclose($res);
            }
        } else {
            $this->log['error'][] = 'Failed to open file, aborting.';
        }
    }
}


function csv_admin_menu() {
    require_once ABSPATH . '/wp-admin/includes/admin.php';
    $plugin = new CSVImporterPlugin;
    add_management_page('edit.php', 'CSV Importer', 9, __FILE__, array($plugin, 'form'));
}

add_action('admin_menu', 'csv_admin_menu');

?>
