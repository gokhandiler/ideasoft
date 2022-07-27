<?php
    class Discount{
        public function gettotal($total=0){
            $discountId=0;
            $discar=array();
            //10PERCENTOVER1000
            if ($total>=1000)
            {
                $discar[$discountId]['discountReason']="10_PERCENT_OVER_1000";
                $discar[$discountId]['discountAmount']=number_format(($total*0.1), 2, '.', '');
                $discar[$discountId]['subtotal']=number_format(($total-($total*0.1)), 2, '.', '');
                $discountId++;
            }            
            return $discar;
        }
        
        public function getBUY5GET1($total=0,$productId=0,$category=0,$quantity=0,$price=0){
            $discountId=0;
            $discar=array();
            
            if ($category==2 && $quantity%6==0)
            {
                $discar[$discountId]['discountReason']="BUY_5_GET_1";
                $discar[$discountId]['discountAmount']=number_format((($quantity/6)*$price), 2, '.', '');
                $discar[$discountId]['subtotal']=number_format(($total-(($quantity/6)*$price)), 2, '.', '');
                $discountId++;
            }            
            return $discar;
        }
        
        public function getOVER2PER20($total=0,$price=0,$quantity=0){
            $discountId=0;
            $discar=array();
            
            $discar[$discountId]['discountReason']="OVER_2_PER_20";
            $discar[$discountId]['discountAmount']=number_format(($quantity*$price*0.2), 2, '.', '');
            $discar[$discountId]['subtotal']=number_format($total-($quantity*$price*0.2), 2, '.', '');
            $discountId++;
            return $discar;
        }                
    }
?>

