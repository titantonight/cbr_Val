<?php
class Curs
{
    protected $list = array();
 	protected $last_list = array();
    public function parse()
    {
    	$date_tod = date('d-m-Y');
    	$date_yes = date('d-m-Y', strtotime($stop_date . ' -1 day'));

        $xml = new DOMDocument();
        $xml1 = new DOMDocument();

        $url = 'http://www.cbr.ru/scripts/XML_daily.asp?date_req=' . $date_tod;
 		$url1 = 'http://www.cbr.ru/scripts/XML_daily.asp?date_req=' . $date_yes;
        @$xml->load($url);
		
		@$xml1->load($url1);
        $this->list = array(); 
 	    $this->last_list = array(); 

        $root = $xml->documentElement;
        $root1 = $xml1->documentElement;

        $items = $root->getElementsByTagName('Valute');
 		$items1 = $root1->getElementsByTagName('Valute');

            foreach ($items as $item)
            {
                $code = $item->getElementsByTagName('CharCode')->item(0)->nodeValue;
                $curs = $item->getElementsByTagName('Value')->item(0)->nodeValue;
                $this->list[$code] = floatval(str_replace(',', '.', $curs));
            }

			foreach ($items1 as $item)
            {
                $code1 = $item->getElementsByTagName('CharCode')->item(0)->nodeValue;
                $curs1 = $item->getElementsByTagName('Value')->item(0)->nodeValue;
                $this->last_list[$code1] = floatval(str_replace(',', '.', $curs1));
            }
            return true;

    }
 
    public function get_some_val($cur)
    {
    	$two_znach = array();
    	$cur_last = $this->last_list[$cur];
    	$cur_now = $this->list[$cur];
    	
    	array_push($two_znach,$cur_last,$cur_now,$grow);
        echo "Курс ".$cur." для вчера и курс для сегодня ";  ?></br><?php
    	echo $cur_last." ".$cur_now." ";
		$cur_last <= $cur_now ? $grow = 1 : $grow = 0;//Определение упал ли курс со вчера или же поднялся 
		if ($grow==1)
		{ 
			echo("↑");
		}
		else
		{
			echo("↓");
		} ?> </br> <?php
       
    	return $two_znach;
    }
}
$cbr = new Curs();
if ($cbr->parse()){    
    $usd_curs = $cbr->get_some_val('USD');    
    $euro_curs = $cbr->get_some_val('EUR');
}