<?php
    function lang( $phrase ){
        static $lang = array(
            
            'HOME_ADMIN'    => 'ECommerce',
            'CATEGORIES'    => 'Categories',
            'ITEMS'         => 'Items',
            'MEMBERS'       => 'Members',
            'COMMENTS'      => 'Comments',
            'STATISTICS'    => 'Statistics'

        );

        return $lang[$phrase];
    }

?>