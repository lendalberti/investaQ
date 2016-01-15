<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity {

	private $_id;

   public function getId() {
      return $this->_id;
   }


	/**
    *** -- 
    *** -- use 'ldap' to authenticate user
    *** --
	**/
    public function authenticate() {
		$debugON = Yii::app()->params['DEBUG']; 
		$username = strtolower($this->username);
		$password = $this->password;
		$userRecord = array();

		if ( $username == 'admin' ) {
		    $username = 'ldalberti';
		}

        if ( $debugON ) {						// if in Debug, then user must be in database already
            if ( $username == $password ) {
                $userRecord = Users::model()->findByUsername($username);
            }
        }
        else {
            $userRecord  = $this->ldap_lookup($username, $password);
        }       

        
        if ( $userRecord ) {
            $id = Users::model()->registerUser( $userRecord );
            if ( $id ) {
                $this->_id       = $id;
                $this->username  = $username;
                $this->errorCode = self::ERROR_NONE;
            }
            else {
                $this->errorCode = self::ERROR_USERNAME_INVALID;    // couldn't register user - need different error here
                pDebug("authenticate() - can't register user=[$username]");
            }
        }
        else {
            $this->errorCode = self::ERROR_USERNAME_INVALID;    // user not authenticated by ldap
            pDebug("UserIdentity::authenticate() - failed login from ".$_SERVER['REMOTE_ADDR'] ." ( user=[$username], pwd=[$password] )" );

        }

        return $this->errorCode == self::ERROR_NONE;  // returns true or false
    }


	/**
    *** -- 
    *** -- lookup user in 'ldap'
    *** --
	**/
   private function ldap_lookup($username, $password) {
      $domainUsername    = Yii::app()->params['ldap_domain'] . "\\$username";
      $port              = Yii::app()->params['ldap_port'];
      $server            = Yii::app()->params['ldap_server'];
      $userAuthenticated = false;
      $userRecord        = array();

      if ($ldapconn = ldap_connect( $server, $port ) ) {
         if($ldapbind = @ldap_bind($ldapconn, $domainUsername, $password) ) {
            $ldapDn = "CN=Users,DC=rocelec,DC=com";
            $ldapFilter = "samaccountname=$username";
            $ldapAttribs = array("mail", 'sn', 'givenname','memberof');
            $ldapResult = @ldap_search($ldapconn, $ldapDn, $ldapFilter, $ldapAttribs);
            if ( $ldapResponse = @ldap_get_entries($ldapconn, $ldapResult) ) {
               if ( $ldapResponse['count'] == 1 ) {
                  $record = $ldapResponse[0];
                  for($index = 0; $index < $record['memberof']['count']; $index++) {
                     $groupParts = explode(',', $record['memberof'][$index]);
                     $groupNameParts = preg_split('/=/', $groupParts[0]);
                     $groupTypeParts = preg_split('/=/', $groupParts[1]);
                     $memberof[$groupTypeParts[1]][] = $groupNameParts[1];
                  }
                  $first_name = trim($record['givenname'][0]);
                  $last_name  = trim($record['sn'][0]);
                  $userRecord['username']   = $username;
                  $userRecord['email']      = trim($ldapResponse[0]['mail'][0]);
                  $userRecord['first_name'] = $first_name;
                  $userRecord['last_name']  = $last_name;
                  $userRecord['fullname']   = "$first_name $last_name";
               }
            }
         }
      }

      return $userRecord;
   }

}
  
