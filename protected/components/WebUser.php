<?php

   // this file must be stored in:
   // protected/components/WebUser.php

   class WebUser extends CWebUser {

      private $_user;


      function getIsApprover() {
          return ( $this->user && ($this->user->role_id == Roles::APPROVER || $this->user->role_id == Roles::ADMIN ) ); 
      }


       /**
       * @return  true if user is logged in;
       *          false otherwise
       */
      function getIsLoggedIn() {
        return ( isset($this->user) );
      }


       /**
       * @return  true if user has Admin role;
       *          false otherwise
       */
      function getIsAdmin() {
        return ( $this->user && $this->user->role_id == Roles::ADMIN );  // Yii::app()->user->isAdmin
      }

       /**
       * @return  true if user has Manager role;
       *          false otherwise
       */
      function getIsOperationsMgr(){
        return ( $this->user && $this->user->role_id == Roles::MGR && $this->user->group_id == Groups::OPERATIONS  );
      }

      function getIsTestFloorLead(){
        return ( $this->user && $this->user->role_id == Roles::LEAD && $this->user->group_id == Groups::TESTFLOOR  );
      }

      function getIsTestFloorSupervisor(){
        return ( $this->user && $this->user->role_id == Roles::SUPER && $this->user->group_id == Groups::TESTFLOOR  );
      }

      function getCanHaveOwnQueue() {
          if ( ($this->user->role_id == Roles::USER && $this->user->group_id == Groups::TESTFLOOR) ||
               ($this->user->role_id == Roles::USER && $this->user->group_id == Groups::RELLAB )        )     {
              return false;
          }
          return true;
      }

      function getIsNotManagement() {
         if ( $this->user && $this->user->role_id == Roles::MGR ) {
            return false;
         }
         return true;
      }

      function getIsManagement() {
        return !self::getIsNotManagement();
      }

      function getCanEvaluate() {
         if ( $this->user && $this->user->role_id == Roles::USER && $this->user->group_id == Groups::TESTFLOOR ) {
            return false;
         }
         return true;
      }


      function getIsQuality() {
        return ( $this->user && $this->user->group_id == Groups::QUALITY);
      }

      function getIsTestEng() {
        return ( $this->user && $this->user->group_id == Groups::TEST_ENG);
      }

      function getIsTestEngMgr() {
        return ( $this->user && $this->user->group_id == Groups::TEST_ENG && $this->user->role_id == Roles::MGR);
      }

      function getIsEngineeringMgr() {
         return ( $this->user &&    $this->user->role_id == Roles::MGR
                              && ( $this->user->group_id == Groups::ASSY_ENG  ||
                                   $this->user->group_id == Groups::TEST_ENG  ||
                                   $this->user->group_id == Groups::TECH_ENG )
               );
      }

      function getIsProductionControlMgr(){
        return ( $this->user && $this->user->role_id == Roles::MGR && $this->user->group_id == Groups::PROD);
      }



      /**
       * @return   logged in user
       */
      function getUser() {
         if ( $this->isGuest ) {
            return;
         }

         if ( $this->_user === null ) {
            $this->_user = Users::model()->findByPk( $this->id );
         }

         return $this->_user;
      }


        public function getAttributes() {
            $att = array();
            if ( $this->user ) {
                $att[] = array( 'id'=>$this->user->id,
                                'username'=>$this->user->username,
                                'first_name'=>$this->user->first_name,
                                'last_name'=>$this->user->last_name,
                                'email'=>$this->user->email,
                                'title'=>$this->user->title,
                                'phone'=>$this->user->phone,
                                'fax'=>$this->user->fax );
            }
            return $att;
        }

        /**
         * @return   user's fullname
         */
        public function getFullname() {
            if ( $this->user ) {
                $fullname = $this->user->first_name . ' ' . $this->user->last_name;
                return $fullname;
            }
        }

        /**
         * @return   user's email
         */
        public function getEmail() {
            if ( $this->user ) {
                $email = $this->user->email;
                return $email;
            }
        }

        /**
         * @return   user's phone #
         */
        public function getPhone() {
            if ( $this->user ) {
                $phone = $this->user->phone;
                return $phone;
            }
        }

        /**
         * @return   user's Fax #
         */
        public function getFax() {
            if ( $this->user ) {
                $fax = $this->user->fax;
                return $fax;
            }
        }

        /**
         * @return   user's title
         */
        public function getTitle() {
            if ( $this->user ) {
                $title = $this->user->title;
                return $title;
            }
        }

        /**
         * @return   user's username
         */
        public function getUsername() {
            if ( $this->user ) {
                $username = $this->user->username;
                return $username;
            }
        }

        /**
        * @return   user's role as int
        */
        public function getRoleId() {
            if ( $this->user ) {
                $role = Roles::model()->findByPk( $this->user->role_id );
                return $role->id;
            }
        }

        /**
        * @return   user's group id
        */
        public function getGroupId() {
            if ( $this->user ) {
                $group = Groups::model()->findByPk( $this->user->group_id );
                return $group->id;
            }
        }

        /**
        * @return   user's group name
        */
        public function getGroupName() {
            if ( $this->user ) {
                return $this->user->group->name;
            }
        }

}
?>