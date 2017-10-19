<?php

/**
 *[js]
 *+ function setMouth(m){
 *+     $('#mouth').val(m);
 *+     $('#calendar_mouth').html(m+'月');
 *+		y = $('#year').val();
 *+		dateInit(y,m);
 *+ }
 *+ function setYear(y){
 *+     $('#year').val(y);
 *+     $('#calendar_year').html(y+'年');
 *+		m = $('#mouth').val();
 *+		dateInit(y,m)
 *+ }
 * $date = new MyDate;
 * $days = $date->index(2012,2,1);
 * print_r($days);
 */
class MyDate
{


	private $year = 0;
	private $month = 0;
	private $day = 0;
	private $isRun = 0;//是否为闰年

	public $days = array();//该月的天数列表



	public function index($year=0,$month=0,$day=0){
		$year  = (int)$year;
		$month = (int)$month;
		$day   = (int)$day;
		return $this->setYear($year)->setMonth($month)->setDay($day)->getDays();
	}


	private function setDay($day){
		$day or $day = 1;
		$this->day = $day;
		return $this;
	}
	private function  getDays(){
		return range(1,$this->days);
	}

	private function setYear($year){
		$year or $year = date('Y');
		$this->year = $year;
		$this->isRun = date('L',strtotime("$year-01-01"));
		return $this;
	}

	private function setMonth($month){
		$month or $month = 1;
		$this->month = $month;
		if($month == 2){
		    //如果是闰年
		    $this->days = $this->isRun ? 29 : 28;
			//如果是第4、6、9、11月
		}else if($month == 4 || $month == 6 ||$month == 9 ||$month == 11){
		    $this->days = 30;
		}else{
		    $this->days = 31;
		}
		return $this;
	}



	public function optionsYear($range = 50)
	{
		$list='';
		$currentYear = $this->year;
		$data = range($currentYear - $range, $currentYear + $range);
		foreach ($data as $value) {
			// $on = $value == $currentYear ? 'selected' : '';
			$list .= '<option value="'.$value.'">'.$value.'</option>';
		}
		return '<option value="'.$currentYear.'">Year</option>' . $list;
	}
	public function optionsMonth()
	{
		$list='';
		$current = $this->month;
		$data = range(1,12);
		foreach ($data as $value) {
			// $on = $value == $current ? 'selected' : '';
			$list .= '<option value="'.$value.'">'.$value.'</option>';
		}
		return '<option value="'.$current.'">Month</option>' . $list;
	}
	public function optionsDays()
	{
		$list='';
		$current = $this->day;
		$data = range(1, $this->days);
		foreach ($data as $value) {
			// $on = $value == $current ? 'selected' : '';
			$list .= '<option value="'.$value.'">'.$value.'</option>';
		}
		return '<option value="'.$current.'">Day</option>' . $list;
	}

}

