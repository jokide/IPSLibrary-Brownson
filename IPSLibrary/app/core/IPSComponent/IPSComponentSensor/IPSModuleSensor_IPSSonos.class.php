<?
	/**@addtogroup ipscomponent
	 * @{
	 *
 	 *
	 * @file          IPSModuleSensor_IPSSonos.class.php
	 * @author        joki
	 *
	 *
	 */

	/**
	 * @class IPSModuleSensor_IPSSonos
	 *
	 * Definiert ein IPSModuleSensor Object, das als Wrapper f�r Sensoren in der IPSLibrary
	 * verwendet werden kann.
	 *
	 * @author        joki
	 * @version
	 * Version 1.0.0, 01.09.2014<br/>
	 */

	IPSUtils_Include ("IPSSonos.inc.php", 									"IPSLibrary::app::modules::IPSSonos");
	IPSUtils_Include ('IPSModuleSensor.class.php',                         'IPSLibrary::app::core::IPSComponent::IPSComponentSensor');

	class IPSModuleSensor_IPSSonos extends IPSModuleSensor {

		private $functionToCall;
		private $param1;
		private $param2;
		private $param3;

		/**
		 * @public
		 *
		 * Initialisierung eines IPSModuleSensor_IPSSonos Objektes
		 *
		 * @param integer $functionToCall Funktion, die aufgerufen werden soll
		 * @param boolean $param1 Parameter 1
		 * @param boolean $param2 Parameter 2
		 * @param boolean $param3 Parameter 3
		 */
		public function __construct($functionToCall, $param1='', $param2='', $param3='') {
			$this->functionToCall = $functionToCall;
			$this->param1   = $param1;
			$this->param2   = $param2;
			$this->param3   = $param3;
		}
		
		private function GetParam($param) {
			if (is_numeric($param)) {
				return (int)$param;
			} elseif ($param=='true') {
				return true;
			} elseif ($param=='false') {
				return false;
			} else {
				return $param;
			}
		}
		
		private function GetParamArray() {
			$parameters = array();
			if ($this->param3<>'') {
				$parameters[] = $this->GetParam($this->param1);
				$parameters[] = $this->GetParam($this->param2);
				$parameters[] = $this->GetParam($this->param3);
			} elseif ($this->param2<>'') {
				$parameters[] = $this->GetParam($this->param1);
				$parameters[] = $this->GetParam($this->param2);
			} elseif ($this->param1<>'') {
				$parameters[] = $this->GetParam($this->param1);
			} else {
			}
			return $parameters;
		}
	
		/**
		 * @public
		 *
		 * Erm�glicht die Synchronisation von Sensorwerten mit Modulen
		 *
		 * @param string $value Sensorwert
		 * @param IPSComponentSensor $component Sensor Komponente
		 */
		public function SyncButton($value, IPSComponentSensor $component) {
			$this->ExecuteButton();
		}

		/**
		 * @public
		 *
		 * Erm�glicht das Verarbeiten eines Taster Signals
		 *
		 */
		public function ExecuteButton () {
			if (function_exists($this->functionToCall)) {
				call_user_func_array($this->functionToCall, $this->GetParamArray());
			} else {
//				Entertainment_IPSComponentSensor_ReceiveData($this->functionToCall, $this->param1, $this->param2, $this->param3);
				IPSLogger_Err(__file__, 'IPSModuleSensor_IPSSonos - Function nicht gefunden: '.$this->functionToCall );
			}
		}

	}

	/** @}*/
?>