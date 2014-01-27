<?php

class AuthState {

    const notAuth = 0;
    const failAuth = 1;
    const successAuth = 2;
}

//---------------------------------------------------------------------

class TLdapUser {

    public $name;
    public $fio;
    public $authState;
    private $memberOf;

    function TLdapUser($authState, $name = null, $fio = null, $memberOf = null){
        $this->name = $name;
        $this->fio = $fio;
        $this->authState = $authState;
        $this->memberOf = $memberOf;
    }

    function isMemberOf( $groupeName ){
        if ( $this->authState === AuthState::successAuth )
            return in_array($groupeName, $this->memberOf);
        else
            return false;
    }

    function isRole( $roleName ){
        $webApp = TWebApp::getWebApp();
        $conf = $webApp->config;

        $roleGroupes = $conf->getParam( "role" . $roleName );
        foreach( $roleGroupes as $groupe )
            if ( $this->isMemberOf($groupe) )
                return true;
        return false;
    }

    function saveToSession(){
        session_start();
        $_SESSION['userName'] = $this->name;
        $_SESSION['userFIO'] = $this->fio;
        $_SESSION['userMember'] = $this->memberOf;
        $_SESSION['authState'] = $this->authState;
        session_write_close();
    }

    static function loadFromSession(){

        $ldapUser = new TLdapUser( AuthState::notAuth );

        session_start();
        if ( isset($_SESSION['authState']) ){
            $authState = $_SESSION['authState'];
            $ldapUser->authState = $authState;

            if($authState == AuthState::successAuth){
                $ldapUser->name = $_SESSION['userName'];
                $ldapUser->fio = $_SESSION['userFIO'];
                $ldapUser->memberOf = $_SESSION['userMember'];
            }
        }
        else
            $_SESSION['authState'] = AuthState::notAuth;
        session_write_close();

        return $ldapUser;
    }

}

//---------------------------------------------------------------------

class ModelLdapAuth extends Model{

    private function extructGroupNames( $arr ){
        $conf = $this->webApp->config;
        $groups = array();
        foreach($arr as $fqdn){
            if ( mb_strstr($fqdn, "CN=") === false  )
                continue;

            $parts = explode(',', $fqdn);
            $group = mb_substr($parts[0], 3);
            if($conf->authCaseInsens)
                $group = mb_strtolower($group);
            $groups[] = $group;
        }
        return $groups;
    }


    function auth( $userName, $userPasswd ){

        $conf = $this->webApp->config;

        if($conf->authCaseInsens)
            $userName = mb_strtolower($userName);

        $ds=ldap_connect("ldap://" . $conf->ldapServer );
        ldap_set_option($ds,LDAP_OPT_PROTOCOL_VERSION,3);
        ldap_set_option($ds,LDAP_OPT_REFERRALS,0);

        if ( $ds === false || $userPasswd === "" ){
            $this->failAuth();
            return;
        }

        $ldapbind=ldap_bind($ds, $userName."@".$conf->ldapDomain, $userPasswd);
        if ( $ldapbind === false ){
            $this->failAuth();
            return;
        }

        $result=ldap_search($ds, 
                            $conf->ldapScope, 
                            "(&(objectCategory=user)(sAMAccountName=$userName))", 
                            array("cn", "memberOf") );
        if ( $result === false ){
            $this->failAuth();
            return;
        }

        $result_entries=ldap_get_entries($ds,$result);
        if ( $result_entries === false ){
            $this->failAuth();
            return;
        }
        ldap_unbind($ds);

        $this->successsAuth($userName,
                            $result_entries[0]['cn'][0],
                            $this->extructGroupNames($result_entries[0]['memberof']) );
    }

    private function successsAuth( $userName, $fio, $member){

        $ldapUser = new TLdapUser( AuthState::successAuth, 
                                $userName,
                                $fio,
                                $member);
        $ldapUser->saveToSession();
        $this->webApp->register->ldapUser = $ldapUser;
    }

    private function failAuth(){

        $ldapUser = new TLdapUser( AuthState::failAuth );
        $ldapUser->saveToSession();
        $this->webApp->register->ldapUser = $ldapUser;
    }

    function checkSession(){

        $ldapUser = TLdapUser::loadFromSession();
        $this->webApp->register->ldapUser = $ldapUser;
    }

    function getAllUsers(){
        $conf = $this->webApp->config;

        $ds=ldap_connect("ldap://" . $conf->ldapServer );
        ldap_set_option($ds,LDAP_OPT_PROTOCOL_VERSION,3);
        ldap_set_option($ds,LDAP_OPT_REFERRALS,0);
        $ldapbind=ldap_bind($ds, $conf->ldapUser."@".$conf->ldapDomain, $conf->ldapPass);
        $result=ldap_search($ds, 
                            $conf->ldapScope, 
                            "(&(objectCategory=user)(sAMAccountName=*))", 
                            array("sAMAccountName", "cn") );
        $result_entries=ldap_get_entries($ds,$result);
        ldap_unbind($ds);

        $users = array();
        foreach($result_entries as $entry){
            $userName = $entry["samaccountname"][0];
            $userFio = $entry["cn"][0];
            if($conf->authCaseInsens)
                $userName = mb_strtolower($userName);
            if( mb_strlen($userName) > 0 )
                $users[] = new TLdapUser(AuthState::successAuth, $userName, $userFio);
        }
        return $users;
    }

}

?>