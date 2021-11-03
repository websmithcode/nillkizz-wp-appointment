<?php
add_action('rest_api_init', function () {
  register_rest_route('nillkizz-appointment/v1', '/get-doctors', array(
    'methods'  => 'GET',
    'callback' => 'get_doctors',
  ));
  register_rest_route('nillkizz-appointment/v1', '/request-call', array(
    'methods'  => 'POST',
    'callback' => 'request_call',
  ));
  register_rest_route('nillkizz-appointment/v1', '/check-phone-confirmation-code', array(
    'methods'  => 'POST',
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
  function map_doctors($doc)
  {
    $terms = ['specialty', 'education'];
    foreach ($terms as $term) {
      $term_ids = $doc['details'][$term];
      $doc['details'][$term] = !empty($term_ids) ? array_terms_id_to_obj($term_ids) : [];
    }
    return $doc;
  }
  function filter_doctors($doc)
  {
    return !$doc['hide'];
  }

  $doctors = array_map('map_doctors', $doctors);
  $doctors = array_filter($doctors, 'filter_doctors');

  return rest_ensure_response($doctors);
}

function request_call()
{
  include_once('NewTel.php');
  $data = json_decode(file_get_contents('php://input'), true);
  $config = get_field('config', 'nillkizz-appointment-phone-confirmation');
  $new_tel = new NewTel($config);

  $response = (array) $new_tel->make_request('call-password/start-password-call', [
    'dstNumber' => $data['phone'],
    $config['call_duration']
  ]);
  switch ($response['data']->data->result) {
    case 'success':
      global $wpdb;
      $wpdb->insert(
        $wpdb->prefix . 'nillkizz_appointment_codes',
        [
          'callId' => $response['data']->data->callDetails->callId,
          'pin' => $response['data']->data->callDetails->pin,
          'created' => (new DateTime())->format('Y-m-d H:i:s')
        ]
      );
      return rest_ensure_response([
        'status' => $response['data']->status,
        'code_validity_time' => $config['code_expire_time'],
        'callId' => $response['data']->data->callDetails->callId
      ]);
    case 'error':
      return new WP_Error('400', 'Bad request', ['status' => 400, 'response' => $response]);
    default:
      return new WP_Error('500', 'Internal error', ['status' => 500, 'response' => $response]);
  }
}

function check_phone_confirmation_code()
{
  $data = json_decode(file_get_contents('php://input'), true);
  if (empty($data) | !isset($data['code'])) {
    return new WP_Error('400', 'Bad request', ['status' => 400]);
  }

  global $wpdb;
  $call = $wpdb->get_row("SELECT callId, pin, created FROM " . $wpdb->prefix . "nillkizz_appointment_codes WHERE callId=" . $data['callId']);
  $config = get_field('config', 'nillkizz-appointment-phone-confirmation');
  if (!isset($call)) {
    return new WP_Error('400', 'Code has not been generated', ['status' => 400]);
  }

  $passed_time = time() - (new DateTime($call->created))->getTimestamp();
  $is_expired_code = $passed_time > $config['code_expire_time'];
  if ($is_expired_code) {
    return new WP_Error('400', 'Code is expired', ['status' => 400, 'passed_time' => $passed_time, 'expire_time' => $config['code_expire_time']]);
  }

  $received_code = $data['code'];
  $valid_code = $call->pin;
  $is_valid_code =  $valid_code === $received_code;
  if (!$is_valid_code) {
    return new WP_Error('400', 'Code is not valid', ['status' => 400]);
  }

  session_destroy();
  return rest_ensure_response(['status' => 'success']);
}
