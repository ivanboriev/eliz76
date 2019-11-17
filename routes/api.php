<?php

use Illuminate\Http\Request;


Route::post('saveCustomer', 'CustomerController@store');
Route::post('deleteCustomer', 'CustomerController@destroy');
Route::post('customers', 'CustomerController@index');
Route::post('customer', 'CustomerController@show');
Route::post('updateCustomer', 'CustomerController@update');

Route::post('subjects', 'SubjectController@index');
Route::post('saveSubject', 'SubjectController@store');
Route::post('deleteSubject', 'SubjectController@destroy');
Route::post('subject', 'SubjectController@show');
Route::post('updateSubject', 'SubjectController@update');
Route::post('generate_doc', 'SubjectController@generate');
Route::post('copySubject', 'SubjectController@copySubject');


Route::post('saveClusters', 'ClusterController@store');
Route::post('deleteCluster', 'ClusterController@destroy');
Route::post('clusters', 'ClusterController@index');
Route::post('updateClusterName', 'ClusterController@update');


Route::post('deleteShield', 'ShieldController@destroy');
Route::post('groups', 'ShieldController@groups');
Route::post('addGroups', 'ShieldController@addGroups');
Route::post('delete_group', 'ShieldController@deleteGroup');
Route::post('saveGroups', 'ShieldController@saveGroups');
Route::post('generate', 'ShieldController@generate');
Route::post('updateShieldsInCluster', 'ShieldController@updateShieldsInCluster');
Route::post('get_editor_data', 'ShieldController@getEditorData');
Route::post('add_shield', 'ShieldController@addShield');
Route::post('get_shields', 'ShieldController@getShields');
Route::post('copyShield', 'ShieldController@copyShield');
Route::post('moveShield', 'ShieldController@moveShield');

Route::post('saveCable', 'CableController@store');
Route::post('cables', 'CableController@index');
Route::post('cable', 'CableController@show');
Route::post('deleteCable', 'CableController@destroy');
Route::post('updateCable', 'CableController@update');



Route::post('get_isolate_data','ShieldController@getIsolateData');
Route::post('save_isolate_data','ShieldController@saveIsolateData');
Route::post('change_isolate_block','ShieldController@isolateBlock');

Route::post('get_phase_data','ShieldController@getPhaseData');
Route::post('save_phase_data','ShieldController@savePhaseData');
Route::post('change_phase_block','ShieldController@phaseBlock');

Route::post('get_uzo_data','ShieldController@getUzoData');
Route::post('save_uzo_data','ShieldController@saveUzoData');
Route::post('change_uzo_block','ShieldController@uzoBlock');


Route::post('get_automate_data','ShieldController@getAutomateData');
Route::post('save_automate_data','ShieldController@saveAutomateData');
Route::post('change_automate_block','ShieldController@automateBlock');
Route::post('get_automate_names','ShieldController@automateNames');


Route::post('add_template','TemplatesController@store');
Route::post('get_templates','TemplatesController@index');
Route::post('doc_delete','TemplatesController@destroy');

Route::post('equips', 'EquipController@index');
Route::post('equip_add', 'EquipController@store');




