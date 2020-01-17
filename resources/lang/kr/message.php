<?php
/**
 * Language file for item error/success messages
 *
 */

return array(

    'exists'        => 'Item already exists!',
    '_not_found'     => 'Item [:id] does not exist.',
    '_name_required' => 'The name field is required',

    'success' => array(
        'create' => '성공적으로 추가되엿습니다.',
        'update' => '성공적으로 업데이트되엿습니다.',
        'delete' => '성공적으로 삭제되엿습니다.',
    ),

    'delete' => array(
        'create' => 'There was an issue creating the Item. Please try again.',
        'update' => 'There was an issue updating the Item. Please try again.',
        'delete' => 'There was an issue deleting the Item. Please try again.',
    ),

    'error' => array(
        'item_exists' => 'An Item already exists with that name, names must be unique for Items.',
    ),

);
