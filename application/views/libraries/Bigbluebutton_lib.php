<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once(APPPATH . 'third_party/bigbluebutton/vendor/autoload.php');

use BigBlueButton\BigBlueButton;
use BigBlueButton\Parameters\CreateMeetingParameters;
use BigBlueButton\Parameters\JoinMeetingParameters;

class Bigbluebutton_lib {

    public $CI;
    private $bbb_security_salt = "";
    private $bbb_server_base_url = "";

    public function __construct($api_keys = array()) {
        $this->CI = &get_instance();
        if (!empty($api_keys)) {
            $this->bbb_security_salt = $api_keys['bbb_security_salt'];
            $this->bbb_server_base_url = $api_keys['bbb_server_base_url'];
        }
    }

    private function putEnv()
    {
        putenv("BBB_SECURITY_SALT=" . $this->bbb_security_salt);
        putenv("BBB_SERVER_BASE_URL=" . $this->bbb_server_base_url);
    }

    public function createMeeting($data = array())
    {
        $this->putEnv();
        $bbb = new BigBlueButton();
        $urlLogout = base_url('live_class/bbb_callback');
        $createMeetingParams = new CreateMeetingParameters($data['meeting_id'], $data['title']);
        $createMeetingParams->setAttendeePassword($data['attendee_password']);
        $createMeetingParams->setModeratorPassword($data['moderator_password']);
        $createMeetingParams->setDuration($data['duration']);
        $createMeetingParams->setMaxParticipants($data['max_participants']);
        $createMeetingParams->setMuteOnStart($data['mute_on_start'] == 0 ? false : true);
        $createMeetingParams->setWebcamsOnlyForModerator(true);
        $createMeetingParams->setRecord($data['set_record'] == 0 ? false : true);
        $createMeetingParams->setAllowStartStopRecording($data['set_record'] == 0 ? false : true);
        $createMeetingParams->setAutoStartRecording($data['set_record'] ? true : true);
        $createMeetingParams->setLogoutUrl($urlLogout);
        $response = $bbb->createMeeting($createMeetingParams);
        if ($response->getReturnCode() == 'FAILED') {
            return false;
        } else {
            $joinMeetingParams = new JoinMeetingParameters($data['meeting_id'], $data['title'], $data['moderator_password']);
            $joinMeetingParams->setUsername($data['presen_name']);
            $joinMeetingParams->setRedirect(true);
            $url = $bbb->getJoinMeetingURL($joinMeetingParams);
            return $url;
        }
    }

    public function joinMeeting($data = array())
    {
        try {
            $this->putEnv();
            $bbb = new BigBlueButton();
            $joinMeetingParams = new JoinMeetingParameters($data['meeting_id'], $data['title'], $data['attendee_password']);
            $joinMeetingParams->setUsername($data['presen_name']);
            $joinMeetingParams->setRedirect(true);
            $url = $bbb->getJoinMeetingURL($joinMeetingParams);
            return $url;
        } catch (\Exception $e) {
            return show_error('Internal error '.$e, 500);
        }
    }
    // public function getRecordings(){
    //     $bbb = new BigBlueButton();
    //     $params =  new GetRecordingsParameters();
    //     $params->setMeetingId('0009');
    //     // $params->setRecordId('ece5bee34c23675cdef50fbea84dc8940884bb3a-1662225281849');
    //     // $params->setState('published');
    //     // print_r($params);

    //     // die();
    //    return $result = $bbb->getRecordingsUrl($params);
    //     // $bbb->assertEquals('SUCCESS', $result->getReturnCode());
    //     // $bbb->assertTrue($result->success());
    // //    print_r($result);

    //     // die();

    //     // $createMeetingParams = new GetRecordingsParameters('0007' ,'test');
    //     // die($params->getRecordId());

    // //    return $response = $bbb->getMeetingId($createMeetingParams);

    // }
}