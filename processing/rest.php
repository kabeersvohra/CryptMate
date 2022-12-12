<?php
/**
 * Created by PhpStorm.
 * User: Kabeer
 * Date: 12/08/2015
 * Time: 12:27
 */

include_once $_SERVER['DOCUMENT_ROOT'] . '/database/connectdatabase.php';

$result = json_encode(array());

if (isset($_POST['username']) && isset($_POST['password']))
{
    $token = $db->verifyUser($_POST['username'], $_POST['password']);
    switch ($token)
    {
        case "username":
            $result = json_encode(array
            (
                'returntype' => 'error',
                'error' => 'Username not found'
            ));
            break;
        case "unverified":
            $result = json_encode(array
            (
                'returntype' => 'error',
                'error' => 'Email unverified'
            ));
            break;
        case "password":
            $result = json_encode(array
            (
                'returntype' => 'error',
                'error' => 'Password is not correct'
            ));
            break;
        default:
            if ($db->getSubscriptionEnded($token))
            {
                $result = json_encode(array
                (
                    'returntype' => 'subscriptionended'
                ));
            }
            else
            {
                $result = json_encode(array
                (
                    'returntype' => 'token',
                    'token' => $token
                ));
            }
            break;
    }
}
elseif (isset($_POST['token']) && isset($_POST['password']) && isset($_POST['domain']) && isset($_POST['newpassword']))
{
    if ($_POST['newpassword'] && isset($_POST['linkeddomain']))
    {
        $hash = $db->createDomainFromRest($_POST['token'], $_POST['password'], $_POST['domain']);
        switch($hash)
        {
            case "tokenerror":
                $result = json_encode(array
                (
                    'returntype' => 'error',
                    'error' => 'Token mismatch'
                ));
                break;
            case "domainused":
                $result = json_encode(array
                (
                    'returntype' => 'error',
                    'error' => 'Password save error'
                ));
                break;
            case "domaininvalid":
                $result = json_encode(array
                (
                    'returntype' => 'error',
                    'error' => 'Domain error'
                ));
                break;
            default:
                $result = json_encode(array
                (
                    'returntype' => 'password',
                    'hash' => $hash
                ));
                break;
        }
    }
    else
    {
        $hash = $db->generatePassword($_POST['domain'], $_POST['password'], $_POST['token']);
        switch($hash) {
            case "tokenerror":
                $result = json_encode(array
                (
                    'returntype' => 'error',
                    'error' => 'Token mismatch'
                ));
                break;
            default:
                $result = json_encode(array
                (
                    'returntype' => 'password',
                    'hash' => $hash
                ));
                break;
        }
    }
}
elseif (isset($_POST['token']) && isset($_POST['domain']))
{
    $iskeyeddomain = $db->isKeyedDomain($_POST['token'], $_POST['domain']);

    switch ($iskeyeddomain)
    {
        case "tokenerror":
            $result = json_encode(array
            (
                'returntype' => 'error',
                'error' => 'Token mismatch'
            ));
            break;
        case "iskeyeddomain":
            $result = json_encode(array
            (
                'returntype' => 'newpassword',
                'newpassword' => false
            ));
            break;
        case "isntkeyeddomain":
            $keyeddomains = $db->getKeyedDomains($_POST["token"]);
            $result = json_encode(array
            (
                'returntype' => 'newpassword',
                'newpassword' => true,
                'keyeddomains' => $keyeddomains
            ));
            break;
    }

}
elseif (isset($_POST['token']) && (isset($_POST['keyeddomains'])))
{
    if ($_POST['keyeddomains'])
    {
        $keyedDomains = $db->getKeyedDomains($_POST['token']);
        if ($keyedDomains == "tokenerror")
        {
            $result = json_encode(array());
        }
        else
        {
            $result = json_encode($keyedDomains);
        }
    }
}

echo $result;

