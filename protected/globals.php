<?php


    function setQuoteStatus($id, $s) {

    }

    function displayMfgQuoteStatus( $status_id ) {
        //pDebug("displayMfgQuoteStatus() - getting image for status_id=[$status_id]");
        
        $s[Status::PENDING ]  = 'pending';  // 2
        $s[Status::APPROVED ] = 'approved'; // 8 
        $s[Status::REJECTED ] = 'rejected'; // 9

        $src = Yii::app()->request->baseUrl . "/images/New/".$s[$status_id].".png";

        return  "<img src='$src' width='20' height='20' style='vertical-align:middle' >";
    }




    function getMfgID( $short_name ) {
        $sql = "SELECT * FROM die_manufacturers WHERE short_name = '$short_name'";
        $results = Yii::app()->db->createCommand($sql)->queryAll();
        $id = $results[0]['id'];

        pDebug("getMfgID() - [$short_name] = [$id]");
        return $id;
    }


    function fp($n) {
        setlocale(LC_MONETARY, 'en_US');
        if ( $n ) {
            $res = money_format("%6.2n", trim($n) );
            return $res;
        }
        return 'n/a';
    }

    function fq($n) {
        return $n=='' ? '0' : $n;
    }

    function calc($model, $key) {
        $res = $model['qty_'.$key] * $model['price_'.$key];
        return $res; //=='0' ? '--' : $res;
    }

    function subTotal($model) {
        $total = 0;
        foreach( ['1_24','25_99','100_499','500_999','1000_Plus'] as $key ) {
            $total += calc($model,$key);
        }
        return $total;
    }




    // ------------------------------------------------ TODO: rename this since we're just getting a count
    function getQuotePartNumbers( $quote_id=null ) {     //        - use SELECT COUNT(*)
        if ( $quote_id === null ) {
            return 0;
        }


        
        $part_no = ''; 

        $sql = "SELECT part_no FROM stock_items WHERE quote_id = $quote_id";
        $results = Yii::app()->db->createCommand($sql)->queryAll();

        return count($results); 

        // foreach( $results as $m ) {
        //     $part_no .= $m['part_no'].'<br />';
        // }
        // return $part_no;
    }


    // ------------------------------------------------
    function truncateString($string, $num) {
        if (strlen($string) > $num) {
            $string = substr($string, 0, $num) . "...";
        }
        return $string;
    }   



    // --------------------------------------------------------
    function getQuoteNumber() {
        $today = Date('Ymd-');

        $sql = "SELECT COUNT(*) FROM quotes WHERE quote_no LIKE '$today%' ";
        $c1 = Yii::app()->db->createCommand($sql)->queryScalar();

        $sql = "SELECT COUNT(*) FROM bto WHERE quote_no LIKE '$today%' ";
        $c2 = Yii::app()->db->createCommand($sql)->queryScalar();

        $next_quote_number = $c1+$c2+1;

        pDebug("getQuoteNumber() - next=[$next_quote_number]");
        return $today . sprintf("%04d", $next_quote_number);
    }



    function getPendingItemCount( $quote_id ) {
        $pending =  Status::PENDING;
        
        $sql = "SELECT COUNT(*) FROM stock_items WHERE quote_id = $quote_id AND status_id = $pending";
       // pDebug("sql=[$sql]");

        $count = Yii::app()->db->createCommand($sql)->queryScalar();
        return $count;
    }

    function getRejectedItemCount( $quote_id ) {
        $rejected =  Status::REJECTED;
        
        $sql = "SELECT COUNT(*) FROM stock_items WHERE quote_id = $quote_id AND status_id = $rejected";
        //pDebug("sql=[$sql]");

        $count = Yii::app()->db->createCommand($sql)->queryScalar();
        return $count;
    }




   // function getQuotesAttachmentList( $id ) {
   //    $results = Attachments::model()->findAll( array("condition" => "quote_id = $id") );
   //    pDebug("getQuotesAttachmentList() - attachment list for quote no. [$id] = ", $results->attributes);
   //    return $results;
   // }

    // -----------------------------------------------------------------
    function getQuoteAttachments( $quote_id  ) {
        $quoteAttachments = array();
        $att = Attachments::model()->findAll( array( "condition" => "quote_id = $quote_id" ) );

        foreach( $att as $a ) {
            $tmp = array();
            $tmp['quote_id']      = $quote_id;
            $tmp['id']            = $a->id;
            $tmp['filename']      = $a->filename; 
            $tmp['size']          = $a->size; 
            $tmp['uploaded_date'] = $a->uploaded_date; 
            $tmp['uploaded_by']   = $a->uploaded_by; 
            $quoteAttachments[]   = $tmp;
        }
        return $quoteAttachments;
    }




    function getUploader( $user_id ) {
         $u = Users::model()->findByPk( $user_id );
         if ($u)
            return $u->fullname;
    }





    // -----------------------------------------------------------
    function addAuditRecord($rec) {
        date_default_timezone_set('America/New_York');
        $audit = new Audit;
        $audit->created_on  = Date('Y-m-d H:i:s');
        $audit->salesperson = Yii::app()->user->fullname;

        $audit->customer    = $rec['customer'];    
        $audit->contact     = $rec['contact'];     
        $audit->quote_no    = $rec['quote_no'];
        $audit->item        = $rec['item'];     
        $audit->status      = $rec['status'];    

        $audit->action      = $rec['text'];
        $audit->save();

        pDebug("addAuditRecord() - audit:", $audit->attributes);
        if ( !$audit->save() ) {
            pDebug("addAuditRecord() - ERROR: can't create audit record: ", $audit->errors());
        }
    }





    // -----------------------------------------------------------
    function quoteNeedsApproval( $model ) {
        if ( is_array($model) ) {
            foreach( $model as $item ) {
                if ( $item->price_Custom && $item->qty_Custom ) {
                    return true;
                } 
            }
        }
        else {
            if ( $model->price_Custom && $model->qty_Custom ) {
                return true;
            } 
        }
        return false;
    }






    // -----------------------------------------------------------
    function getQuoteExpirationDate() {
        // quote expiration 30 days from today
        $exp = "+30 days";
        echo Date( 'Y-m-d', strtotime($exp) );
    }



    // -----------------------------------------------------------
    function quoteIsUserModifiable( $status_id ) {  
        // if ( $status_id == Status::DRAFT || Yii::app()->user->isAdmin || Yii::app()->user->isCoordinator ) {
        //     return true;
        // }
        // else {
        //     return false;
        // }
        return true;     // allow editing at any point by user
    }

    
    // -----------------------------------------------------------
    function getMyQuoteCount( $status_id ) {
        $user_id = Yii::app()->user->id;
        return Quotes::model()->count( "status_id=$status_id AND owner_id=$user_id" );
    }


    // -----------------------------------------------------------
    function getContactInfoByCustomerID( $customer_id ) {
        $cc = CustomerContacts::model()->find( array( "condition" => "customer_id = $customer_id" ) );
        $contact = Contacts::model()->findByPk( $cc->contact_id );
        return $contact;
    }


    // -----------------------------------------------------------
    function getContactFullnameByCustomerID( $id ) {
        if ( $id ) {
            $contact = getContactInfoByCustomerID($id); 
            return $contact->fullname;
        }
        else {
            return 'n/a';
        }
    }




    // -----------------------------------------------------------------------------------
    function getDaysTilThen($then) {
        $now  = date('Y-m-d 00:00:00');
        $cycle_time = round(abs(strtotime($then) - strtotime($now)) / (60*60*24));
        return  $cycle_time > 1 ? "$cycle_time days" : "1 day"; 
    }




    // -----------------------------------------------------------------------------------
    function notifyProposalManager( $quoteModel ) {

        if ( Yii::app()->params['DEBUG'] ) {   // no emails when working from home
            pDebug("notifyProposalManager() - user notified...");
            return true;
        }

        // TODO...


    }


    // -----------------------------------------------------------------------------------
    function notifyCoordinators( $modelComments) {

        if ( Yii::app()->params['DEBUG'] ) {   // no emails when working from home
            pDebug("notifyCoordinators() - user(s) notified...");
            return true;
        }


        // TODO...


    }














    // -----------------------------------------------------------------------------------
    function notifyApprovers( $model_StockItem) {

        if ( Yii::app()->params['DEBUG'] ) {   // no emails when working from home
            return true;
        }


        $quote_id = $model_StockItem->quote_id;
        $model    = Quotes::model()->findByPk($id);
        $quote_no = $model->quote_no;

        $subject = "Sales Quote Needs Review";
        $cc      = 'LDAlberti@rocelec.com';                  

        if ( Yii::app()->params['DEBUG'] ) {
            $recipients[] = 'LDAlberti@rocelec.com';               // all to me in Debug
            $cc = null;                                            // no cc in debug mode
        }
        else {
            $recipients = Users::model()->getApproverEmails();
        }

        require_once("phpmailer/class.phpmailer.php");

        try {
            $current_user   = Yii::app()->user->fullname;
            $link = "http://" . Yii::app()->params['host'] . Yii::app()->baseUrl . '/index.php/quotes/' . $quote_id ; 
            $link = "<a href='$link' > here </a>"; 

            $mail = new PHPMailer();
            $mail->isHTML();
            $mail->IsSMTP();
            $mail->Host = Yii::app()->params['email_host'];

            $mail->FromName = "InvestaQ Admin";
            $mail->From     = "noreply@rocelec.com";

            $mail->AddCC( $cc );   
            $mail->Subject =  $subject;
            $mail->MsgHTML("Sales quote $quote_no by $current_user is ready for your approval; click $link to review it.");

            foreach( $recipients as $a ) {
                $mail->AddAddress( $a );
            }

           // $mail->AddAddress(  'ldalberti@rocelec.com'  ); // TODO: debug, handle bad emails

            if ( !$mail->Send() ) {
                pDebug( "globals::notifyApprovers() - Error sending email: ".$mail->ErrorInfo, $recipients );
                return false;
            }
            else {
                pDebug( "globals::notifyApprovers() - email successfully sent to ", $recipients );
                return true;
            }

        }
        catch( Exception $e ) {
            pDebug( "notifyApprovers() - ERROR: couldn't send email notifying coordinators - ", $e->errorInfo );
            $transaction->rollback();
            return false;
        }

       
    }


    // -----------------------------------------------------------------------------------
    function notifySalespersonStatusChange( $quoteModel, $itemModel ) {

          if ( Yii::app()->params['DEBUG'] ) {   // no emails when working from home
            return true;
        }


        $item_status  = $itemModel->status->name;
        $quote_status = $quoteModel->status->name;
        $part_no      = $ $itemModel->part_no;
        
        $subject           = "Item $item_status";
        $salesperson_name  = $model->owner->fullname;
        $salesperson_email = $model->owner->email;
        $cc                = Yii::app()->user->email;   // always CC me for now if NOT in Debug
       
        $link    = "<a href='http://www.wcvb.com'>".$model->quote_no."</a>";
       // $message = "This is to inform you the status for your quote " . $link . " has been changed to: " . $quote_status;
        $message = "One of the items on your quote $link, Part No. $part_no, has been $item_status";

        if ( Yii::app()->params['DEBUG'] ) {
            $salesperson_email = 'LDAlberti@rocelec.com';               // all to me in Debug
            $subject .= " (email meant for " . $salesperson_name . ")";                            // remove this after tesing
            $cc = null; 
        }
       
       try {
            require_once("phpmailer/class.phpmailer.php");

            $mail = new PHPMailer();
            $mail->isHTML();
            $mail->IsSMTP();
            $mail->Host = Yii::app()->params['email_host'];

            $mail->FromName = Yii::app()->user->fullname;
            $mail->From     = Yii::app()->user->email;

            $mail->AddAddress( $salesperson_email );

            if ( !Yii::app()->params['DEBUG'] ) {
                 $mail->AddCC( $cc );               
            }

            $mail->Subject = $subject; 
            $mail->MsgHTML($message);

            if ( !$mail->Send() ) {
                pDebug( "notifySalespersonStatusChange() - Error sending email to [" . $salesperson_name . "], error: [" . $mail->ErrorInfo ."]" );
                return false;
            }
            else {
                pDebug( "notifySalespersonStatusChange() - email successfully sent to " . $salesperson_name );
                return true;
            }
        }
        catch (Exception $e) {
            pDebug( "notifySalespersonStatusChange() - Exception sending email to [" . $salesperson_name . "], error: [", $e->errorInfo );
            return false;
        }
    }









    // -----------------------------------------------------------------------------------
    function notifySalesPerson( $user_id, $subject, $message ) {
        
        if ( Yii::app()->params['DEBUG'] ) {
            return true;
        }

        require_once("phpmailer/class.phpmailer.php");

        $mail = new PHPMailer();
        $mail->isHTML();
        $mail->IsSMTP();
        $mail->Host = Yii::app()->params['email_host'];
        $mail->FromName = Yii::app()->user->fullname;
        $mail->From     = Yii::app()->user->email;

        $mail->AddCC( 'ldalberti@rocelec.com' );                  // always CC me for now
        
        $u = Users::model()->findByPk($user_id);
        $mail->AddAddress( $u->email );
        pDebug("notifySalesPerson() - mail:", $u->email);


        $mail->Subject = $subject; 
        $mail->MsgHTML($message);
        
        if ( !$mail->Send() ) {
            pDebug( "notifyUser() - Error sending email to [" . $u->fullname . "], error: [" . $mail->ErrorInfo ."]" );
            return false;
        }
        else {
            pDebug( "notifyUser() - email successfully sent to " . $u->fullname );
            return true;
        }
    }








    /**
     *  quick and dirty way to dump variables contents
     */
    function pDebug_ORIG( $msg, $what='' ) {
       $msg = print_r($msg, true);
       if ( $what ) {
          $what = "\n" . print_r($what, true);
       }

       Yii::log( "\n\n$msg\n$what\n", 'info', 'MyDebug' );
       //Yii::trace( "$msg\n$what\n\n", 'MyDebug' );
    }
    
    function pDebug( $msg, $what='' ) {
        $user = "logged by: ".Yii::app()->user->fullname;
        $msg =  print_r($user . "\n" . $msg, true) ;
        if ( $what ) {
          $what = "\n" . print_r($what, true);
        }

        Yii::log( "\n\n------------------------------------------------------------------------------ \n$msg\n$what\n------------------------------------------------------------------------------ \n", 'info', 'MyDebug' );
        //Yii::trace( "$msg\n$what\n\n", 'MyDebug' );
    }

    function pTrace($where) {
        if ( Yii::app()->params['TRACE'] ) {
            $msg = '[TRACE] ' . Yii::app()->user->fullname . ": $where";
            Yii::log( "\n\n$msg\n", 'info', 'MyDebug' );
        }
    }



   /**
    *  display last commit
    */
   function getVersion() {
      $last_commit = `git log -1`;
      preg_match('/commit (.{7}).+Date:\s+(.{24})/s', $last_commit, $matches);
      return $matches[2] . ", " . $matches[1];
   }

   


    function getStatusDisplay($q) {

        if ( $q->status_id == Status::WON ) {
            return "<img src='".Yii::app()->request->baseUrl."/images/win_40x40.png' title='Quote won; order not placed yet.' />";
        }
        else if ( $q->status_id == Status::ORDER_PLACED ) {
            return "<img src='".Yii::app()->request->baseUrl."/images/order_placed_40x40.png' id='order_placed' title='Quote in order processing.'/>";
        }

        else {
            return $q->status->name;
        }


    }


    function getQuoteItemCount($quote_id) {
        return Items::model()->count( "quote_id=$quote_id") > 0 ? Items::model()->count( "quote_id=$quote_id") : '-';
    } 


    function getFormattedDate($d) {
        $tmp = explode(' ', $d); 
        
        // do some formatting?
        return $tmp[0];
    }


    function getCustomerName($id) {
        $model = Customers::model()->findByPk($id);
        if ($model)
            return $model->name;
    }


    // ---------------------------------------------
    function getQuoteOwner($id) {
        $u = Users::model()->findByPk( $id );
         if ($u)
            return $u->fullname;
    }




?>