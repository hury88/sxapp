<?php
/**
 * class Timer
 * [DEMO]
 * +$timer = new Timer();
 * +$timer->start();
 * +for($i=1;$i<=100;$i++)
 * +{
 * +    usleep(15);
 * +}
 * +$timer->end();
 * +$timer->printTime();
 *
 */
    class Timer{
        //初始化变量
        private $start = 0;
        private $end = 0;
        private function now()
        {
            list($usec,$sec) = explode(" ",microtime());
            return ((float)$usec + (float)$sec);
        }
        public function start()
        {
            $this->start = $this->now();
        }
        public function end()
        {
            $this->end = $this->now();
        }
        public function getTime()
        {
            return (float)($this->end - $this->start);
        }
        public function printTime()
        {
            printf("program run use time:%fs\n",$this->getTime());
        }
    }
 ?>