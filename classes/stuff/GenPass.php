<?php
class GenPass
{
    public function __construct()
    {
        
    }
    public function makePass($max)
    {
        $chars="qazxswedcvfrtgbnhyujmkp23456789QAZXSWEDCVFRTGBNHYUJMKLP"; 
        $size=StrLen($chars)-1; 
        $password=null; 
        while ($max--) { 
            $password.=$chars[rand(0, $size)];
        } 
        return $password;
    }
}
