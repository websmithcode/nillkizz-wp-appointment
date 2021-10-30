<?php
add_action('rest_api_init', function () {
  register_rest_route('nillkizz-appointment/v1', '/get-doctors', array(
    'methods'  => 'GET',
    'callback' => 'get_doctors',
  ));
  register_rest_route('nillkizz-appointment/v1', '/phone-confirmation', array(
    'methods'  => 'GET',
    'callback' => 'phone_confirmation',
  ));
  register_rest_route('nillkizz-appointment/v1', '/check-phone-confirmation-code', array(
    'methods'  => 'GET',
    'callback' => 'check_phone_confirmation_code',
  ));
});

function get_doctors()
{
  $doctors = get_field('doctors', 'nillkizz-appointment-doctors');

  function array_terms_id_to_obj($array)
  {
    return array_map(function ($term) {
      return get_term($term);
    }, $array);
  }

  $doctors = array_map(function ($doc) {
    $doc['details']['specialty'] = array_terms_id_to_obj($doc['details']['specialty']);
    $doc['details']['education'] = array_terms_id_to_obj($doc['details']['education']);
    return $doc;
  }, $doctors);

  return rest_ensure_response($doctors);
}

function phone_confirmation()
{
  include_once('NewTel.php');
  session_start();
  $config = get_field('config', 'nillkizz-appointment-phone-confirmation');
  $new_tel = new NewTel($config);

  $response = (array) $new_tel->make_request('call-password/start-password-call', [
    'dstNumber' => 79005741200,
    $config['call_duration']
  ]);
  $response['data']['time'] = time();
  $_SESSION['nillkizz_appointment_phone_confirmation'] =  $response['data'];
  switch ($response['data']['status']) {
    case 'success':
      return rest_ensure_response([
        'status' => $response['data']['status'],
        'code_validity_time' => $config['code_expire_time']
      ]);
    case 'error':
      return new WP_Error('400', 'Internal error', ['status' => 400, 'response' => $response]);
    default:
      return new WP_Error('500', 'Internal error', ['status' => 500, 'response' => $response]);
  }
}

function check_phone_confirmation_code()
{
  if (empty($_POST) | !isset($_POST['code'])) {
    return new WP_Error('400', 'Bad request', ['status' => 400]);
  }

  $config = get_field('config', 'nillkizz-appointment-phone-confirmation');
  session_start();
  $state = $_SESSION['nillkizz_appointment_phone_confirmation'];

  if (!isset($state)) {
    return new WP_Error('400', 'Code has not been generated', ['status' => 400]);
  }

  $code = $_POST['code'];
  $passed_time = time() - $state['time'];
  $is_expired_code = $passed_time > $config['code_expire_time'];
  if ($is_expired_code) {
    return new WP_Error('400', 'Code is expired', ['status' => 400, 'passed_time' => $passed_time, 'expire_time' => $config['code_expire_time']]);
  }

  $is_valid_code = $state['data']->callDetails->code === $code;
  if (!$is_valid_code) {
    return new WP_Error('400', 'Code is not valid', ['status' => 400]);
  }

  session_destroy();
  return rest_ensure_response(['status' => 'success']);
}
