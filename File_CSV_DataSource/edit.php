<?php
/*
Name: edit.php, part of the "Outlook to SeeEm Importer" Wordpress Plugin
Description: Edits existing contacts in SeeEm Contact Manager to reflect those in CSV file being uploaded.
Author: Brad Allured
*/

/**
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
 * @author    Brad Allured <Schneidley@gmail.com>
 * @copyright 2010 Brad Allured
 * @license   The MIT License
 * }}}
 */
 
function edit_tags ($tags){
	global $wpdb;
	$title = $tags['crm_p_name_first'].' '.$tags['crm_p_name_last'];
	$id = $wpdb->get_var( $wpdb->prepare("SELECT ID FROM {$wpdb->posts} WHERE post_title = %s AND post_type = 'post'", $title));
	if ($id == null ) {
		return false;
	}
	$update = get_option('SeeEm_importer_import_update');
	$del = get_option('SeeEm_importer_import_delete');
	if ($update == 1) {
		$param = $wpdb->get_var( $wpdb->prepare("SELECT meta_id FROM {$wpdb->postmeta} WHERE post_id = %s AND meta_key = 'dcm_description'", $id));
		if (!empty($tags['dcm_description'])){
			if ($param == null) {
				$wpdb->insert($wpdb->postmeta, array('post_id' => $id, 'meta_key' => 'dcm_description', 'meta_value' => $tags['dcm_description']) );
			} else {
				$wpdb->update($wpdb->postmeta, array('post_id' => $id, 'meta_key' => 'dcm_description', 'meta_value' => $tags['dcm_description']), array('meta_id' => $param) );
			}
		} elseif ($del == 1 && $param != null) {
			$ret = $wpdb->get_var( $wpdb->prepare("DELETE FROM {$wpdb->postmeta} WHERE meta_id = %s", $param));
		}
		$param = $wpdb->get_var( $wpdb->prepare("SELECT meta_id FROM {$wpdb->postmeta} WHERE post_id = %s AND meta_key = 'crm_p_name_prefix'", $id));
		if (!empty($tags['crm_p_name_prefix'])){
			if ($param == null) {
				$wpdb->insert($wpdb->postmeta, array('post_id' => $id, 'meta_key' => 'crm_p_name_prefix', 'meta_value' => $tags['crm_p_name_prefix']) );
			} else {
				$wpdb->update($wpdb->postmeta, array('post_id' => $id, 'meta_key' => 'crm_p_name_prefix', 'meta_value' => $tags['crm_p_name_prefix']), array('meta_id' => $param) );
			}
		} elseif ($del == 1 && $param != null) {
			$ret = $wpdb->get_var( $wpdb->prepare("DELETE FROM {$wpdb->postmeta} WHERE meta_id = %s", $param));
		}
		$param = $wpdb->get_var( $wpdb->prepare("SELECT meta_id FROM {$wpdb->postmeta} WHERE post_id = %s AND meta_key = 'crm_p_name_first'", $id));
		if (!empty($tags['crm_p_name_first'])){
			if ($param == null) {
				$wpdb->insert($wpdb->postmeta, array('post_id' => $id, 'meta_key' => 'crm_p_name_first', 'meta_value' => $tags['crm_p_name_first']) );
			} else {
				$wpdb->update($wpdb->postmeta, array('post_id' => $id, 'meta_key' => 'crm_p_name_first', 'meta_value' => $tags['crm_p_name_first']), array('meta_id' => $param) );
			}
		} elseif ($del == 1 && $param != null) {
			$ret = $wpdb->get_var( $wpdb->prepare("DELETE FROM {$wpdb->postmeta} WHERE meta_id = %s", $param));
		}
		$param = $wpdb->get_var( $wpdb->prepare("SELECT meta_id FROM {$wpdb->postmeta} WHERE post_id = %s AND meta_key = 'crm_p_name_middle'", $id));
		if (!empty($tags['crm_p_name_middle'])){
			if ($param == null) {
				$wpdb->insert($wpdb->postmeta, array('post_id' => $id, 'meta_key' => 'crm_p_name_middle', 'meta_value' => $tags['crm_p_name_middle']) );
			} else {
				$wpdb->update($wpdb->postmeta, array('post_id' => $id, 'meta_key' => 'crm_p_name_middle', 'meta_value' => $tags['crm_p_name_middle']), array('meta_id' => $param) );
			}
		} elseif ($del == 1 && $param != null) {
			$ret = $wpdb->get_var( $wpdb->prepare("DELETE FROM {$wpdb->postmeta} WHERE meta_id = %s", $param));
		}
		$param = $wpdb->get_var( $wpdb->prepare("SELECT meta_id FROM {$wpdb->postmeta} WHERE post_id = %s AND meta_key = 'crm_p_name_last'", $id));
		if (!empty($tags['crm_p_name_last'])){
			if ($param == null) {
				$wpdb->insert($wpdb->postmeta, array('post_id' => $id, 'meta_key' => 'crm_p_name_last', 'meta_value' => $tags['crm_p_name_last']) );
			} else {
				$wpdb->update($wpdb->postmeta, array('post_id' => $id, 'meta_key' => 'crm_p_name_last', 'meta_value' => $tags['crm_p_name_last']), array('meta_id' => $param) );
			}
		} elseif ($del == 1 && $param != null) {
			$ret = $wpdb->get_var( $wpdb->prepare("DELETE FROM {$wpdb->postmeta} WHERE meta_id = %s", $param));
		}
		$param = $wpdb->get_var( $wpdb->prepare("SELECT meta_id FROM {$wpdb->postmeta} WHERE post_id = %s AND meta_key = 'crm_p_name_suffix'", $id));
		if (!empty($tags['crm_p_name_suffix'])){
			if ($param == null) {
				$wpdb->insert($wpdb->postmeta, array('post_id' => $id, 'meta_key' => 'crm_p_name_suffix', 'meta_value' => $tags['crm_p_name_suffix']) );
			} else {
				$wpdb->update($wpdb->postmeta, array('post_id' => $id, 'meta_key' => 'crm_p_name_suffix', 'meta_value' => $tags['crm_p_name_suffix']), array('meta_id' => $param) );
			}
		} elseif ($del == 1 && $param != null) {
			$ret = $wpdb->get_var( $wpdb->prepare("DELETE FROM {$wpdb->postmeta} WHERE meta_id = %s", $param));
		}
		$param = $wpdb->get_var( $wpdb->prepare("SELECT meta_id FROM {$wpdb->postmeta} WHERE post_id = %s AND meta_key = 'crm_p_name_nick'", $id));
		if (!empty($tags['crm_p_name_nick'])){
			if ($param == null) {
				$wpdb->insert($wpdb->postmeta, array('post_id' => $id, 'meta_key' => 'crm_p_name_nick', 'meta_value' => $tags['crm_p_name_nick']) );
			} else {
				$wpdb->update($wpdb->postmeta, array('post_id' => $id, 'meta_key' => 'crm_p_name_nick', 'meta_value' => $tags['crm_p_name_nick']), array('meta_id' => $param) );
			}
		} elseif ($del == 1 && $param != null) {
			$ret = $wpdb->get_var( $wpdb->prepare("DELETE FROM {$wpdb->postmeta} WHERE meta_id = %s", $param));
		}
		$param = $wpdb->get_var( $wpdb->prepare("SELECT meta_id FROM {$wpdb->postmeta} WHERE post_id = %s AND meta_key = 'crm_p_name_title'", $id));
		if (!empty($tags['crm_p_name_title'])){
			if ($param == null) {
				$wpdb->insert($wpdb->postmeta, array('post_id' => $id, 'meta_key' => 'crm_p_name_title', 'meta_value' => $tags['crm_p_name_title']) );
			} else {
				$wpdb->update($wpdb->postmeta, array('post_id' => $id, 'meta_key' => 'crm_p_name_title', 'meta_value' => $tags['crm_p_name_title']), array('meta_id' => $param) );
			}
		} elseif ($del == 1 && $param != null) {
			$ret = $wpdb->get_var( $wpdb->prepare("DELETE FROM {$wpdb->postmeta} WHERE meta_id = %s", $param));
		}
		$param = $wpdb->get_var( $wpdb->prepare("SELECT meta_id FROM {$wpdb->postmeta} WHERE post_id = %s AND meta_key = 'crm_p_adr_1st_street'", $id));
		if (!empty($tags['crm_p_adr_1st_street'])){
			if ($param == null) {
				$wpdb->insert($wpdb->postmeta, array('post_id' => $id, 'meta_key' => 'crm_p_adr_1st_street', 'meta_value' => $tags['crm_p_adr_1st_street']) );
			} else {
				$wpdb->update($wpdb->postmeta, array('post_id' => $id, 'meta_key' => 'crm_p_adr_1st_street', 'meta_value' => $tags['crm_p_adr_1st_street']), array('meta_id' => $param) );
			}
		} elseif ($del == 1 && $param != null) {
			$ret = $wpdb->get_var( $wpdb->prepare("DELETE FROM {$wpdb->postmeta} WHERE meta_id = %s", $param));
		}
		$param = $wpdb->get_var( $wpdb->prepare("SELECT meta_id FROM {$wpdb->postmeta} WHERE post_id = %s AND meta_key = 'crm_p_adr_1st_unit'", $id));
		if (!empty($tags['crm_p_adr_1st_unit'])){
			if ($param == null) {
				$wpdb->insert($wpdb->postmeta, array('post_id' => $id, 'meta_key' => 'crm_p_adr_1st_unit', 'meta_value' => $tags['crm_p_adr_1st_unit']) );
			} else {
				$wpdb->update($wpdb->postmeta, array('post_id' => $id, 'meta_key' => 'crm_p_adr_1st_unit', 'meta_value' => $tags['crm_p_adr_1st_unit']), array('meta_id' => $param) );
			}
		} elseif ($del == 1 && $param != null) {
			$ret = $wpdb->get_var( $wpdb->prepare("DELETE FROM {$wpdb->postmeta} WHERE meta_id = %s", $param));
		}
		$param = $wpdb->get_var( $wpdb->prepare("SELECT meta_id FROM {$wpdb->postmeta} WHERE post_id = %s AND meta_key = 'crm_p_adr_1st_city'", $id));
		if (!empty($tags['crm_p_adr_1st_city'])){
			if ($param == null) {
				$wpdb->insert($wpdb->postmeta, array('post_id' => $id, 'meta_key' => 'crm_p_adr_1st_city', 'meta_value' => $tags['crm_p_adr_1st_city']) );
			} else {
				$wpdb->update($wpdb->postmeta, array('post_id' => $id, 'meta_key' => 'crm_p_adr_1st_city', 'meta_value' => $tags['crm_p_adr_1st_city']), array('meta_id' => $param) );
			}
		} elseif ($del == 1 && $param != null) {
			$ret = $wpdb->get_var( $wpdb->prepare("DELETE FROM {$wpdb->postmeta} WHERE meta_id = %s", $param));
		}
		$param = $wpdb->get_var( $wpdb->prepare("SELECT meta_id FROM {$wpdb->postmeta} WHERE post_id = %s AND meta_key = 'crm_p_adr_1st_stateprov'", $id));
		if (!empty($tags['crm_p_adr_1st_stateprov'])){
			if ($param == null) {
				$wpdb->insert($wpdb->postmeta, array('post_id' => $id, 'meta_key' => 'crm_p_adr_1st_stateprov', 'meta_value' => $tags['crm_p_adr_1st_stateprov']) );
			} else {
				$wpdb->update($wpdb->postmeta, array('post_id' => $id, 'meta_key' => 'crm_p_adr_1st_stateprov', 'meta_value' => $tags['crm_p_adr_1st_stateprov']), array('meta_id' => $param) );
			}
		} elseif ($del == 1 && $param != null) {
			$ret = $wpdb->get_var( $wpdb->prepare("DELETE FROM {$wpdb->postmeta} WHERE meta_id = %s", $param));
		}
		$param = $wpdb->get_var( $wpdb->prepare("SELECT meta_id FROM {$wpdb->postmeta} WHERE post_id = %s AND meta_key = 'crm_p_adr_1st_zip'", $id));
		if (!empty($tags['crm_p_adr_1st_zip'])){
			if ($param == null) {
				$wpdb->insert($wpdb->postmeta, array('post_id' => $id, 'meta_key' => 'crm_p_adr_1st_zip', 'meta_value' => $tags['crm_p_adr_1st_zip']) );
			} else {
				$wpdb->update($wpdb->postmeta, array('post_id' => $id, 'meta_key' => 'crm_p_adr_1st_zip', 'meta_value' => $tags['crm_p_adr_1st_zip']), array('meta_id' => $param) );
			}
		} elseif ($del == 1 && $param != null) {
			$ret = $wpdb->get_var( $wpdb->prepare("DELETE FROM {$wpdb->postmeta} WHERE meta_id = %s", $param));
		}
		$param = $wpdb->get_var( $wpdb->prepare("SELECT meta_id FROM {$wpdb->postmeta} WHERE post_id = %s AND meta_key = 'crm_p_adr_1st_country'", $id));
		if (!empty($tags['crm_p_adr_1st_country'])){
			if ($param == null) {
				$wpdb->insert($wpdb->postmeta, array('post_id' => $id, 'meta_key' => 'crm_p_adr_1st_country', 'meta_value' => $tags['crm_p_adr_1st_country']) );
			} else {
				$wpdb->update($wpdb->postmeta, array('post_id' => $id, 'meta_key' => 'crm_p_adr_1st_country', 'meta_value' => $tags['crm_p_adr_1st_country']), array('meta_id' => $param) );
			}
		} elseif ($del == 1 && $param != null) {
			$ret = $wpdb->get_var( $wpdb->prepare("DELETE FROM {$wpdb->postmeta} WHERE meta_id = %s", $param));
		}
		$param = $wpdb->get_var( $wpdb->prepare("SELECT meta_id FROM {$wpdb->postmeta} WHERE post_id = %s AND meta_key = 'crm_p_email_1'", $id));
		if (!empty($tags['crm_p_email_1'])){
			if ($param == null) {
				$wpdb->insert($wpdb->postmeta, array('post_id' => $id, 'meta_key' => 'crm_p_email_1', 'meta_value' => $tags['crm_p_email_1']) );
			} else {
				$wpdb->update($wpdb->postmeta, array('post_id' => $id, 'meta_key' => 'crm_p_email_1', 'meta_value' => $tags['crm_p_email_1']), array('meta_id' => $param) );
			}
		} elseif ($del == 1 && $param != null) {
			$ret = $wpdb->get_var( $wpdb->prepare("DELETE FROM {$wpdb->postmeta} WHERE meta_id = %s", $param));
		}
		$param = $wpdb->get_var( $wpdb->prepare("SELECT meta_id FROM {$wpdb->postmeta} WHERE post_id = %s AND meta_key = 'crm_p_email_2'", $id));
		if (!empty($tags['crm_p_email_2'])){
			if ($param == null) {
				$wpdb->insert($wpdb->postmeta, array('post_id' => $id, 'meta_key' => 'crm_p_email_2', 'meta_value' => $tags['crm_p_email_2']) );
			} else {
				$wpdb->update($wpdb->postmeta, array('post_id' => $id, 'meta_key' => 'crm_p_email_2', 'meta_value' => $tags['crm_p_email_2']), array('meta_id' => $param) );
			}
		} elseif ($del == 1 && $param != null) {
			$ret = $wpdb->get_var( $wpdb->prepare("DELETE FROM {$wpdb->postmeta} WHERE meta_id = %s", $param));
		}
		$param = $wpdb->get_var( $wpdb->prepare("SELECT meta_id FROM {$wpdb->postmeta} WHERE post_id = %s AND meta_key = 'crm_p_phone_1'", $id));
		if (!empty($tags['crm_p_phone_1'])){
			if ($param == null) {
				$wpdb->insert($wpdb->postmeta, array('post_id' => $id, 'meta_key' => 'crm_p_phone_1', 'meta_value' => $tags['crm_p_phone_1']) );
			} else {
				$wpdb->update($wpdb->postmeta, array('post_id' => $id, 'meta_key' => 'crm_p_phone_1', 'meta_value' => $tags['crm_p_phone_1']), array('meta_id' => $param) );
			}
		} elseif ($del == 1 && $param != null) {
			$ret = $wpdb->get_var( $wpdb->prepare("DELETE FROM {$wpdb->postmeta} WHERE meta_id = %s", $param));
		}
		$param = $wpdb->get_var( $wpdb->prepare("SELECT meta_id FROM {$wpdb->postmeta} WHERE post_id = %s AND meta_key = 'crm_p_phone_2'", $id));
		if (!empty($tags['crm_p_phone_2'])){
			if ($param == null) {
				$wpdb->insert($wpdb->postmeta, array('post_id' => $id, 'meta_key' => 'crm_p_phone_2', 'meta_value' => $tags['crm_p_phone_2']) );
			} else {
				$wpdb->update($wpdb->postmeta, array('post_id' => $id, 'meta_key' => 'crm_p_phone_2', 'meta_value' => $tags['crm_p_phone_2']), array('meta_id' => $param) );
			}
		} elseif ($del == 1 && $param != null) {
			$ret = $wpdb->get_var( $wpdb->prepare("DELETE FROM {$wpdb->postmeta} WHERE meta_id = %s", $param));
		}
		$param = $wpdb->get_var( $wpdb->prepare("SELECT meta_id FROM {$wpdb->postmeta} WHERE post_id = %s AND meta_key = 'crm_p_phone_3'", $id));
		if (!empty($tags['crm_p_phone_3'])){
			if ($param == null) {
				$wpdb->insert($wpdb->postmeta, array('post_id' => $id, 'meta_key' => 'crm_p_phone_3', 'meta_value' => $tags['crm_p_phone_3']) );
			} else {
				$wpdb->update($wpdb->postmeta, array('post_id' => $id, 'meta_key' => 'crm_p_phone_3', 'meta_value' => $tags['crm_p_phone_3']), array('meta_id' => $param) );
			}
		} elseif ($del == 1 && $param != null) {
			$ret = $wpdb->get_var( $wpdb->prepare("DELETE FROM {$wpdb->postmeta} WHERE meta_id = %s", $param));
		}
		$param = $wpdb->get_var( $wpdb->prepare("SELECT meta_id FROM {$wpdb->postmeta} WHERE post_id = %s AND meta_key = 'crm_p_company_url'", $id));
		if (!empty($tags['crm_p_company_url'])){
			if ($param == null) {
				$wpdb->insert($wpdb->postmeta, array('post_id' => $id, 'meta_key' => 'crm_p_company_url', 'meta_value' => $tags['crm_p_company_url']) );
			} else {
				$wpdb->update($wpdb->postmeta, array('post_id' => $id, 'meta_key' => 'crm_p_company_url', 'meta_value' => $tags['crm_p_company_url']), array('meta_id' => $param) );
			}
		} elseif ($del == 1 && $param != null) {
			$ret = $wpdb->get_var( $wpdb->prepare("DELETE FROM {$wpdb->postmeta} WHERE meta_id = %s", $param));
		}
		$date = date('Y-m-d H:i:s');
		$gmt = gmdate('Y-m-d H:i:s');
		if (!empty($tags['Note'])) {
			$wpdb->update($wpdb->posts, array('post_excerpt' => $tags['Note'], 'post_date' => $date, 'post_date_gmt' => $gmt, 'post_modified' => $date, 'post_modified_gmt' => $gmt), array('ID' => $id) );
		} else {
			$wpdb->update($wpdb->posts, array('post_date' => $date, 'post_date_gmt' => $gmt, 'post_modified' => $date, 'post_modified_gmt' => $gmt), array('ID' => $id) );
		}
	}
	return true;
}
?>