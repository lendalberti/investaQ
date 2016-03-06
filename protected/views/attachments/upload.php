<?php

Yii::app()->clientScript->registerScript('search', "

    // --------------------------------------------------------
    $('#quote_attachment').on('click', function() {
        if ( $(this).val() ) {
            $('#spanAttachFile').hide();
            return false;
        }
        else {
            $('#spanAttachFile').show();
            return true;
        }
    });


    // --------------------------------------------------------
    $('span#upload').click( function() {
      $('span#upload_msg').html('');
    });


    // --------------------------------------------------------
    $('#attach_form').submit( function() {
        // if ( $.trim( $('#attachment_title').val() ) == '' ) {
        //   alert('Enter title for attachment');
        //   return false;
        // }
        return true;
    });

    $('#currentlyAttached > li').on('click', function() {
        if ( confirm('Removing attachment - are you sure?') ) {
            var item = $(this);
            var tmp =  $(this).attr('id');
            var thisId = /selectedAttachment_(.+)$/i.exec( tmp );
            var itemID = RegExp.$1;
            console.log('removing attachment: ' + itemID);

            $.ajax({
                  url: '../delete/' + itemID,
                  type: 'POST',
                  success: function(data, textStatus, jqXHR) {
                    item.remove();
                    $('#upload_msg').html('Attachment removed - click \'Done\' when finished.');
                  },
                  error: function (jqXHR, textStatus, errorThrown)  {
                    alert('Could not remove attachment ' + itemID + ' from this quote; error=' + errorThrown);
                  }
            });
        }
        return false;
      
    })

");

?>

<h1 style='margin-bottom: 10px'>File Attachments for Quote No. <?php echo $quote_no; ?></h1>

<span id='upload_msg' style='color: #06c;'><?php echo $uploadMessage . 
                          ($uploadMessage ? " choose another file or click 'Done' when finished." : ''); ?></span>

<div id='upload_div'>
        <form id='attach_form' action="<?php echo CController::createUrl('Attachments/upload/'. $quote_id); ?>" method="post" enctype="multipart/form-data" >
         <span id='upload'>
            <input name="quote_attachment" id="quote_attachment" type="file" />  
                
                <div style='margin-top: 10px;'>
                    <span id='spanAttachFile' > <input type="submit"  name="submit" value='Attach this file' style='font-size: 1.4em; '/> 
                        <a class='cancel_link' href='<?php echo CController::createUrl('quotes/'. $quote_id);?>'><span style="margin-left:10px;">Done</span></a>
                    </span>
                </div>

            <div  style='margin-top: 50px;'></div>
         </span>

          <div class="row">
            <ul id='currentlyAttached'><span>Currently Attached</span><span id='remove_selected_contact'> (click on filename to remove)</span> 
                <?php
                    foreach( $attachment_list as $qa ) {
                        echo "<li id='selectedAttachment_".$qa['id']."'>" . $qa['filename'] . ", " . $qa['uploaded_date'] . ", " . getUploader($qa['uploaded_by']) . "</li>";
                    }
                ?>
            </ul> 
        </div>

      </form>
</div>