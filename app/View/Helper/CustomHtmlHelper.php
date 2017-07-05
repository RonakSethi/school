<?php

/**
 * Application level View Helper
 *
 * This file is application-wide helper file. You can put all
 * application-wide helper-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Helper
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
App::uses('Helper', 'View');

/**
 * Application helper
 *
 * Add your application-wide methods in the class below, your helpers
 * will inherit them.
 *
 * @package       app.View.Helper
 */
class CustomHtmlHelper extends AppHelper {
    /* Custom Seletbox */

    public function createSelectBoxWithCustomOptions($name, $options, $selected = NULL, $label = NULL, $id = NULL, $class = NULL, $style = NULL) {
        $html = '';
        $otherAttrHtml = '';
        
        $opt = "<option value=''>$label</option>";
        foreach ($options as $key => $child) {
            if (sizeof($child) > 2) {
                $otherAttrHtml = '';
                foreach ($child as $othrKey => $othrValue) {
                    if ($othrKey != 'value' && $othrKey != 'label') {
                        $otherAttrHtml .="$othrKey='$othrValue'";
                    }
                }
            }
            $opt .= '<option class="optionChild" '
                    . $otherAttrHtml . ' value="' . $child['value'] . '" '
                    . (($selected == $child['value']) ? "selected=selected" : "") . '>'
                    . $child['label']
                    . '</option>';
        }
        $html = "<select name='$name' id='$id' class='$class' " . (($style != null) ? "style='$style'" : "") . ">$opt</select>";
        return $html;
    }
function CategorySelectBox($array,$model) {
        echo '<select id="' . $model . 'CategoryId" name="data[' . $model . '][category_id]" style="width:100%;">';
        echo '<option value="">Select Category</option>';
        if (!empty($array)) {
            foreach ($array as $value) {
                if (count($value['children'])) {
                    echo '<option value="' . $value['Category']['id'] . '" disabled>' . $value['Category']['name'] . '</option>';
                    foreach ($value['children'] as $val) {
                        if (count($val['children'])) {
                            echo '<option value="' . $val['Category']['id'] . '" disabled>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $val['Category']['name'] . '</option>';
                            foreach ($val['children'] as $val1) {
                                if (count($val1['children'])) {
                                    echo '<option value="' . $val1['Category']['id'] . '"  disabled>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $val1['Category']['name'] . '</option>';
                                    foreach ($val1['children'] as $val2) {
                                        if (count($val2['children'])) {
                                            echo '<option value="' . $val2['Category']['id'] . '" disabled>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $val2['Category']['name'] . '</option>';
                                        } else {
                                            echo '<option value="' . $val2['Category']['id'] . '" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $val2['Category']['name'] . '</option>';
                                        }
                                    }
                                } else {
                                    echo '<option value="' . $val1['Category']['id'] . '" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $val1['Category']['name'] . '</option>';
                                }
                            }
                        } else {
                            echo '<option value="' . $val['Category']['id'] . '"  style="font-weight: bold;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $val['Category']['name'] . '</option>';
                        }
                    }
                }
            }
        }
        echo '</select>';
    }

}
