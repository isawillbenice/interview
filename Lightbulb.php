class Switcher
{
	public function __construct($switcherName) {
		$this->switcherName = $switcherName;
		$this->state = 'Выкл';
    	}
	
	public function turnOnOff() {
		if($this->state == 'Выкл'){
			$this->state = 'Вкл';
		} else {
			$this->state = 'Выкл';
		}
	}
}

class Lightbulb
{
	const VOLT_ALLOW = 220;
	const HERTZ_ALLOW = 50;
	
	public function __construct($lightbulbName) {
		$this->lightbulbName = $lightbulbName;
		$this->wiringName = null;
		$this->switcher = null;
    }
	
	public function addSwitcher(Switcher $switcher) {
		if(!$this->switcher) {
			$this->switcher	= $switcher;
		} else {
			throw new Exception('Лампочка "' . $this->lightbulbName . '" уже имеет выключатель!');
		}	
	}
	
	public function removeSwitcher() {
		if($this->switcher) {
			return $this->switcher = null;
		} else {
			throw new Exception('Лампочка "' . $this->lightbulbName . '" не имеет выключателя!');
		}
	}
	
	public function getSwitcherName() {
		if($this->switcher) {
			return $this->switcher->switcherName;
		} else {
			throw new Exception('Лампочка "' . $this->lightbulbName . '" не имеет выключателя!');
		}
	}
	
	public function getState() {
		if($this->switcher) {
			return $this->switcher->state;
		} else {
			throw new Exception('Лампочка "' . $this->lightbulbName . '" не имеет выключателя!');
		}
	}
}

class Wiring
{
	const COUNT_LIGHTBULBS_DEFAULT = 5;
	const VOLT_DEFAULT = 220;
	const HERTZ_DEFAULT = 50;
	
	public function __construct($wiringName, $volt = self::VOLT_DEFAULT, $hertz = self::HERTZ_DEFAULT, $maxCountLightbulbs = self::COUNT_LIGHTBULBS_DEFAULT) {
		$this->wiringName = $wiringName;
        $this->arrayLightbulbs = array();
		$this->maxCountLightbulbs = $maxCountLightbulbs;
		$this->volt = $volt;
		$this->hertz = $hertz;
    }
	
	public function addLightbulb(Lightbulb $lightbulb) {
		if($this->countLightbulbs() > $this->maxCountLightbulbs) {
			throw new Exception('Проводка заполнена!');	
        }
		
		if($this->volt !== Lightbulb::VOLT_ALLOW || $this->hertz !== Lightbulb::HERTZ_ALLOW) {
			throw new Exception('Параметры проводники не подходят для лампочки "' . $lightbulb->lightbulbName . '"!');	
        }
		
		if($lightbulb->wiringName) {
			throw new Exception('Лампочка "' . $lightbulb->lightbulbName . '" уже подключена к сети "' . $lightbulb->wiringName . '"!');
		}
		
		$this->arrayLightbulbs[$lightbulb->lightbulbName] = $lightbulb;
		$lightbulb->wiringName = $this->wiringName;
    }
	
	public function removeLightbulb(Lightbulb $lightbulb) {
		if(!empty($this->arrayLightbulbs[$lightbulb->lightbulbName])) {
			unset($this->arrayLightbulbs[$lightbulb->lightbulbName]);
			$lightbulb->wiringName = null;
		} else {
			throw new Exception('На данной проводке лампочка "' . $lightbulb->lightbulbName . '" отсутствует!');	
		}
	}

	public function countLightbulbs() {
		return count($this->arrayLightbulbs);
	}
}
