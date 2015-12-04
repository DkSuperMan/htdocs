<?php 

    class thread {    
             
        var $hooks = array();    
        var $args = array();    
             
        function thread() {    
        }    
             
        function addthread($func)    
        {    
            $args = array_slice(func_get_args(), 1);    
            $this->hooks[] = $func;    
            $this->args[] = $args;    
            return true;    
        }    
             
        function runthread()    
        {    


            if(isset($_GET['flag']))    
            {    
                $flag = intval($_GET['flag']);    
            }    
            if($flag || $flag === 0)    
            {
                call_user_func_array($this->hooks[$flag], $this->args[$flag]);    
            }    
            else    
            {
                for($i = 0, $size = count($this->hooks); $i < $size; $i++)    
                {    
                    $fp=fsockopen($_SERVER['HTTP_HOST'],$_SERVER['SERVER_PORT']);    
                    if($fp)    
                    {    
                        $out = "GET {$_SERVER['PHP_SELF']}?flag=$i HTTP/1.1 ";    
                        $out .= "Host: {$_SERVER['HTTP_HOST']} ";    
                        $out .= "Connection: Close ";    
                        fputs($fp,$out);    
                        fclose($fp);    
                    }    
                }    
            }    
        }    
    }  

?>