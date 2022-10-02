<?php
//Add a layer to protect against snooping
defined('ABSPATH') or die("No Bueno Amigo."); //Beat it!
/*
Plugin Name: DK Design's Woocommerce Average Order Value
Plugin URI:  https://dkdesignhawaii.com
Description: Uses javascript to get average order total based on current report screen (legacy reports)
Version:     1.0
Author:      Dan Morrone
Author URI:  https://dkdesignhawaii.com
*/

add_action('admin_footer','dkAvgOrderVal');
function dkAvgOrderVal(){

        //Make sure we on the right page?
        $screen = get_current_screen();
        if($screen->id =='woocommerce_page_wc-reports'){

          //are we on correct tab?
          if( !isset($_GET['tab']) || $_GET['tab'] == 'orders'){ 

              //are we are on correct report?
              if( !isset($_GET['report']) || $_GET['report'] == 'sales_by_date'){ 

                  echo '<script>

                            //Gross sales this period
                            var ordertotal    = jQuery(".chart-sidebar").find("li:eq(0) .amount").text();

                            //Qty orders this Period
                            var numberorders  = jQuery(".chart-sidebar").find("li:eq(4)").text();

                                //trim findings of dollar signs and commas
                                var cleantotal  = ordertotal.substr(1);
                                var cleanorders = numberorders.substr(1);

                                //Lose commas and other text
                                cleantotal  = cleantotal.replace(",","");
                                cleanorders = cleanorders.replace(",","");
                                cleanorders = cleanorders.replace(" orders placed","");

                                //our clean vars
                                finaltotal = cleantotal.trim();
                                finalorders = cleanorders.trim();

                                //calc our average order value
                                var avgordervalis = (finaltotal / finalorders).toFixed(2);

                                //Output result
                                jQuery(".chart-sidebar").find("li:eq(0)").after("<li style=\"border-color: #b1d4ea\" class=\"highlight_series \" data-series=\"\" data-tip=\"\"><strong><span class=\"woocommerce-Price-amount amount\"><span class=\"woocommerce-Price-currencySymbol\">$</span>" + avgordervalis + "</span></strong> average order value</li>");

                        </script>';

              
              } //if correct report

          } // if correct tab

        } //if screen

} //function