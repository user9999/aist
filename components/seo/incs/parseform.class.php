<?php
class ParseForm{
	private $html='';
	private $url='';
	private $forms=array();
	private $inputs=array();
	private $forms_data=array();
	private $OrderForm=array();
 	function __construct($html,$url){
		if(is_string($html)){
			$this->html=$html;
		}
		if(is_string($url)){
			if(substr_count($url,"/")>2){
				$this->url=preg_replace("'([^/]+)$'is","",$url);
			} else {
				$this->url=$url."/";
			}
		} else {
			return false;
		}
		
		$this->getforms();
		$this->parseAction();
		$this->parseInputTypes();
		$this->parseSelect();
		$this->parseTextarea();
		$this->Order();
	}
	private function getForms(){
		preg_match_all('!(<form).*?(</form>)!is',$this->html,$matches);
		$this->forms=$matches[0]; 
	}
	private function parseAction(){
		$i=0;
		foreach($this->forms as $form){
			preg_match_all('!(<form)(.*?)(action=)([\"\'\s]?)([\./]{0,2})([^\'^\"^\s^\>]*)!is',$form,$matches);//'!(action=)([\"\'\s]*)([^\"^\'^\s^>]+)!is'
			$this->forms_data[$i]['url']=($matches[6][0]==null)?'':$matches[6][0];
			$i++;
		}
		$this->correctAction();
		$this->parseMethod();
	}
	private function parseMethod(){
		$i=0;
		foreach($this->forms as $form){
			preg_match_all('!(<form)(.*?)(method=)([\"\'\s]?)([\./]{0,2})([^\'^\"^\s^\>]*)!is',$form,$matches);//'!(action=)([\"\'\s]*)([^\"^\'^\s^>]+)!is'
			$this->forms_data[$i]['method']=($matches[6][0]==null)?'post':$matches[6][0];
			$i++;
		}
	}
	private function correctAction(){
		for($i=0;$i<count($this->forms_data);$i++){
			if(!eregi("http://",$this->forms_data[$i]['url'])){
				$this->forms_data[$i]['url']=$this->url.$this->forms_data[$i]['url'];
			}
		}
	}
	public function parseInputTypes(){
		for($i=0;$i<count($this->forms);$i++){
			preg_match_all('!(<input)([^>]+)!is',$this->forms[$i],$matches);
			$data=$this->getInputType($matches[2]);
			//var_dump($matches[2]);
			$k=0;
			for($a=0;$a<count($data['types']);$a++){
				if(eregi('radio',$data['types'][$a][0])){
					if($data['types'][$a-1][0]==$data['types'][$a][0] && $data['names'][$a-1][0]!=$data['names'][$a][0]){
						$k++;
					}
					$this->forms_data[$i]['inputs']['types']['radio'][$k]=($data['types'][$a][0]==null)?'':$data['types'][$a][0];
					$this->forms_data[$i]['inputs']['names']['radio'][$k][]=($data['names'][$a][0]==null)?'':$data['names'][$a][0];
					$this->forms_data[$i]['inputs']['values']['radio'][$k][]=($data['values'][$a][0]==null)?'':$data['values'][$a][0];
					$this->forms_data[$i]['inputs']['line']['radio'][$k][]=$data['line'][$a];										
				} else {
					$this->forms_data[$i]['inputs']['types'][]=($data['types'][$a][0]==null)?'':$data['types'][$a][0];
					$this->forms_data[$i]['inputs']['names'][]=($data['names'][$a][0]==null)?'':$data['names'][$a][0];
					$this->forms_data[$i]['inputs']['values'][]=($data['values'][$a][0]==null)?'':$data['values'][$a][0];
					$this->forms_data[$i]['inputs']['sizes'][]=($data['sizes'][$a][0]==null)?'':$data['sizes'][$a][0];
					$this->forms_data[$i]['inputs']['max'][]=($data['max'][$a][0]==null)?'':$data['max'][$a][0];
					$this->forms_data[$i]['inputs']['line'][]=$data['line'][$a];
				}
				
			}

		}
	}
	private function getInputType($inputs){
		foreach($inputs as $input){
			preg_match_all('!(name=)([\"\']?)([^\"^\s\>^\']+)!is',$input,$match);
			$data['names'][]=$match[3];
			preg_match_all('!(type=)([\"\']?)([^\"^\s\>^\']+)!is',$input,$matches);
			$data['types'][]=$matches[3];
			preg_match_all('!(value=)([\"\']?)([^\"^\s\>^\']+)!is',$input,$matches);
			$data['values'][]=$matches[3];
			preg_match_all('!(size=)([\"\']?)([^\"^\s\>^\']+)!is',$input,$matches);
			$data['sizes'][]=$matches[3];
			preg_match_all('!(maxlength=)([\"\']?)([^\"^\s\>^\']+)!is',$input,$matches);
			$data['max'][]=$matches[3];
			$data['line'][]=$input;
		}
		return $data;
	}
	private function parseSelect(){
		for($i=0;$i<count($this->forms);$i++){
			preg_match_all('!(<select)(.*?)(name=)([\"\'\s]?)([^\'\"^\s^>]+)(.*?)(</select>)!is',$this->forms[$i],$matches);
			$options=$this->parseOptions($matches[6]);
			for($a=0;$a<count($matches[5]);$a++){
				$this->forms_data[$i]['select'][$a]['names']=($matches[5][$a]==null)?'':$matches[5][$a];
				$this->forms_data[$i]['select'][$a]['value']=$options[$a]['value'];
				$this->forms_data[$i]['select'][$a]['text']=$options[$a]['text'];
			}
		}
	}
	private function parseOptions($selects){
		$i=0;
		foreach($selects as $select){
			preg_match_all('!(<option)(.*?)(value=)([\"\'\s]?)([^\'\"^\s^>]+)(.*?)(>)([^<]+)(</option>)!is',$select,$matches);
			$options[$i]['value']=$matches[5];
			$options[$i]['text']=$matches[8];
			$i++;
		}
		return $options;
	}
	private function parseTextarea(){
		for($i=0;$i<count($this->forms);$i++){
			preg_match_all('!(<textarea)(.*?)(name=)([\"\'\s]?)([^\'\"^\s^>]+)(.*?)(</textarea>)!is',$this->forms[$i],$matches);
			$this->forms_data[$i]['textarea']=$matches[5];
			$this->forms_data[$i]['textarea']['line']=$matches[0];
		}
	}
	private function Order(){
		for($i=0;$i<count($this->forms);$i++){
			$this->OrderForm[$i]['url']=$this->forms_data[$i]['url'];
			$this->OrderForm[$i]['textarea']=$this->forms_data[$i]['textarea'];
			$this->OrderForm[$i]['radio']['values']=$this->forms_data[$i]['inputs']['values']['radio'];
			$this->OrderForm[$i]['radio']['names']=$this->forms_data[$i]['inputs']['names']['radio'];

			unset($this->forms_data[$i]['inputs']['types']['radio']);
			unset($this->forms_data[$i]['inputs']['names']['radio']);
			unset($this->forms_data[$i]['inputs']['values']['radio']);
			unset($this->forms_data[$i]['inputs']['line']['radio']);
			//var_dump($this->forms_data[$i]['inputs']['types']);


			$this->OrderForm[$i]['inputs']=$this->forms_data[$i]['inputs'];
			$this->OrderForm[$i]['method']=$this->forms_data[$i]['method'];
			$this->OrderForm[$i]['select']=$this->forms_data[$i]['select'];
		}
	}
	public function Action($num=0){
		return $this->OrderForm[$num]['url'];
	}
	public function Method($num=0){
		return $this->OrderForm[$num]['method'];
	}
	public function Radio($num=0){
		return $this->OrderForm[$num]['radio'];
	}
	public function Textarea($num=0){
		return $this->OrderForm[$num]['textarea'];
	}
	public function Inputs($num=0){
		return $this->OrderForm[$num]['inputs'];
	}
	public function Select($num=0){
		return $this->OrderForm[$num]['select'];
	}
	

}
?>
