<?php
/**
 * Language file for auth error messages
 *
 */

return array(

    'account_already_exists' => 'An account with this email already exists.',
    'account_not_found' => '로그인정보가 틀립니다.',
    'account_email_not_found' =>'Email is incorrect.',
    'account_deleted'  => '이 고객 계정은 삭제되엿습니다.',
    'account_not_active'  => '이 고객 계정은 차단되엿습니다.',
    'account_not_activated'  => '이 고객 계정은 활성화되어 있지 않습니다.',
    'account_suspended'      => '당신의 계정이 의심스럽습니다. [:delay]초 후에 다시 시도하십시오.',
    'account_banned'         => 'This user account is banned.',

    'signin' => array(
        'error'   => '로그인에 문제가 발생했습니다.',
        'success' => '로그인이 성공했습니다.',
    ),

    'login' => array(
        'error'   => '로그인에 문제가 발생했습니다. 후에 다시 시도하십시오',
        'success' => '로그인이 성공했습니다.',
        'incorrect' => '아이디와 비밀번호가 정확하지 않습니다.'
    ),

    'logout' => array(
        'error'   => '로그인에 문제가 발생했습니다. 후에 다시 시도하십시오',
        'success' => '성공적으로 탈퇴하엿습니다.',
    ),

    'signup' => array(
        'error'   => '회원가입에 문제가 발생했습니다. 후에 다시 시도하십시오',
        'success' => '계정이 성공적으로 생성되었습니다. 귀하의 이메일 똔는 폰을 확인하여 계정을 활성화하십시오.',
        'incorrect' =>'아이디와 비밀번호가 정확하지 않습니다.'
    ),

    'forgot-password' => array(
        'error'   => 'There was a problem while trying to get a reset password code, please try again.',
        'success' => 'Password recovery email successfully sent.',
    ),

    'forgot-password-confirm' => array(
        'error'   => 'There was a problem while trying to reset your password, please try again.',
        'success' => 'Your password has been successfully reset.',
    ),

    'activate' => array(
        'error'   => '계정을 활성화하는 동안 문제가 발생했습니다. 다시 시도하십시오.',
        'success' => '귀하의 계정이 성공적으로 활성화되었습니다.',
    ),

    'contact' => array(
        'error'   => 'There was a problem while trying to submit the contact form, please try again.',
        'success' => 'Your contact details has been successfully sent. ',
    ),
);
