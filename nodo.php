<?php
	
	class Nodo {

		private $info;
		private $izq;
		private $der;

		function __construct($info) {
			$this->izq = null;
			$this->der = null;
			$this->info = $info;
		}

		public function getInfo() {
			return $this->info;
		}

		public function getIzq() {
			return $this->izq;
		}

		public function getDer() {
			return $this->der;
		}

		public function setIzq($izq) {
			$this->izq = $izq;
		}

		public function setDer($der) {
			$this->der = $der;
		}
		
	}
?>