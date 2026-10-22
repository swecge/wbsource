<div id="header">    	
        
    <div id="logo">
    	Rental
    </div> <!-- End of logo Div -->
    
    <div id="fer-logo">
        <img src="images/flex-e-rent-logo.jpg" alt="Logo" title="Logo" />
    </div> <!-- End of btg-logo Div -->
    
    <div id="last-updated">
        <?php
            date_default_timezone_set('Europe/London');
            $currentTime = new DateTime();
            echo "Last updated: " .  $currentTime->format('h:i A'); "<br />"
        ?>
    </div> <!-- End of last-updated Div -->
    
    <div class="clear">
    </div> <!-- End of clear Div -->
    
</div> <!-- End of header Div -->