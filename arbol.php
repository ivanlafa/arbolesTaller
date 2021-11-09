<?php
	include ('nodo.php');

	class Arbol {
		
		private $raiz;

		function __construct($raiz) {
			$this->raiz = $raiz;
		}

		public function getRaiz() {
			return $this->raiz;
		}

		public function existe($nodoActual, $info) {
			if ($nodoActual == null) {
				return false;
			} elseif ($nodoActual->getInfo() == $info) {
				return true;
			}
			return $this->existe($nodoActual->getDer(), $info) || $this->existe($nodoActual->getIzq(), $info);
		}

		public function buscar($info) {
			if ($this->raiz != null) {
				$cola = array();
				array_unshift($cola, $this->raiz);
				while (sizeof($cola) > 0) {
					$nodoActual = array_shift($cola);
					if ($nodoActual->getInfo() == $info) {
						return $nodoActual;
					} 
					if ($nodoActual->getIzq() != null) {
						array_unshift($cola, $nodoActual->getIzq());
					} 
					if ($nodoActual->getDer() != null) {
						array_unshift($cola, $nodoActual->getDer());
					}
				}
				return null;
			}
		}

		public function agregarNodo($IdNuevoNodo, $IdNodoPadre, $ubicacion) {
			if ($this->raiz != null) {
				if ($this->existe($this->raiz, $IdNuevoNodo)) {
					throw new Exception("Este nodo ya existe", 1);
				}
				$nodoPadre = $this->buscar($IdNodoPadre);
				if ($nodoPadre == null) {
					throw new Exception("No existe el nodo padre", 1);
				} else {
					$nuevoNodo = new Nodo($IdNuevoNodo);
					if (strcasecmp($ubicacion, "left")) {
						if ($nodoPadre->getIzq() == null) {
							$nodoPadre->setIzq($nuevoNodo);
						} else {
							$nuevoNodo->setIzq($nodoPadre->getIzq());
							$nodoPadre->setIzq($nuevoNodo);
						}
					} elseif (strcasecmp($ubicacion, "right")) {
						if ($nodoPadre->getDer() == null) {
							$nodoPadre->setDer($nuevoNodo);
						} else {
							$nuevoNodo->setDer($nodoPadre->getDer());
							$nodoPadre->setDer($nuevoNodo);
						}
					} else {
						throw new Exception("Dirección errada", 1);
					}
				}
			} else {
				throw new Exception("Árbol vacío", 1);
			}
		}

			public function eliminarNodo($IdNodo) {
			if ($this->raiz != null) {
				if (strcasecmp($this->raiz->getInfo(), $IdNodo) === 0) {
					throw new Exception("No se puede eliminar la raiz", 1);
				} else {
					$nodoActual = $this->buscar($IdNodo);
					if ($nodoActual == null) {
						throw new Exception("No existe el nodo", 1);
					}
					if ($nodoActual->getIzq() == null && $nodoActual->getDer() == null) {
						$nodoPadre = $this->nodoPadre($IdNodo);
						if ($nodoPadre == null) {
							throw new Exception("El nodo no tiene padre o no existe", 1);
						}
						if ($nodoPadre->getIzq() != null) {
							if (strcasecmp($nodoPadre->getIzq()->getInfo(), $IdNodo) === 0) {
								$nodoPadre->setIzq(null);
							}
						} 
						if ($nodoPadre->getDer() != null) {
							if (strcasecmp($nodoPadre->getDer()->getInfo(), $IdNodo) === 0) {
								$nodoPadre->setDer(null);
							}
						}
					} else {
						throw new Exception("Sólo se pueden eliminar los nodos hoja", 1);	
					}
				}
			} else {
				throw new Exception("Árbol vacío", 1);
			}
		}

		public function contarNodos($nodoActual) {
			if ($nodoActual == null) {
				return 0;
			}
			return 1 + $this->contarNodos($nodoActual->getIzq()) + $this->contarNodos($nodoActual->getDer());
		}


		public function contarPares($nodoActual) {
			if ($nodoActual == null) {
				return 0;
			} elseif ($nodoActual->getInfo() % 2 == 0) {
				return 1 + $this->contarPares($nodoActual->getIzq()) + $this->contarPares($nodoActual->getDer());
			} else {
				return $this->contarPares($nodoActual->getIzq()) + $this->contarPares($nodoActual->getDer());
			}
		}

		public function recorridoNiveles() {
			if ($this->raiz != null) {
				$rec = "";
				$cola = array();
				array_unshift($cola, $this->raiz);
				while (sizeof($cola) > 0) {
					$nodoActual = array_shift($cola);
					$rec .= $nodoActual->getInfo()."->";
					if ($nodoActual->getDer() != null) {
						array_push($cola, $nodoActual->getDer());
					}
					if ($nodoActual->getIzq() != null) {
						array_push($cola, $nodoActual->getIzq());
					}
				}
				return $rec;
			} else {
				throw new Exception("Árbol vacío", 1);
			}
		}


		public function recorridoPreOrden($nodoActual, $rec) {
			if ($nodoActual == null) {
				return $rec;
			} else {
				return $nodoActual->getInfo()."->".$this->recorridoPreOrden($nodoActual->getDer(), $rec)."->".$this->recorridoPreOrden($nodoActual->getIzq(), $rec);
			}
		}

		public function recorridoInOrden($nodoActual, $rec) {
			if ($nodoActual == null) {
				return $rec;
			} else {
				return $this->recorridoInOrden($nodoActual->getDer(), $rec)."->".$nodoActual->getInfo()."->".$this->recorridoInOrden($nodoActual->getIzq(), $rec);
			}
		}

		public function recorridoPosOrden($nodoActual, $rec) {
			if ($nodoActual == null) {
				return $rec;
			} else {
				return $this->recorridoPosOrden($nodoActual->getDer(), $rec)."->".$this->recorridoPosOrden($nodoActual->getIzq(), $rec)."->".$nodoActual->getInfo();
			}
		}

		public function nodoPadre($idHijo) {
			if ($this->raiz != null) {
				$cola = array();
				array_unshift($cola, $this->raiz);
				while (sizeof($cola) > 0) {
					$nodoActual = array_shift($cola);
					if ($nodoActual->getIzq() != null) {
						if (strcasecmp($nodoActual->getIzq()->getInfo(), $idHijo) === 0) {
							return $nodoActual;
						}
						array_unshift($cola, $nodoActual->getIzq());
					}
					if ($nodoActual->getDer() != null) {
						if (strcasecmp($nodoActual->getDer()->getInfo(), $idHijo) === 0) {
							return $nodoActual;
						}
						array_unshift($cola, $nodoActual->getDer());
					}
				}
				return null;
			} else {
				throw new Exception("Árbol vacío", 1);
			}
		}

	

		public function arbolCompleto($nodoActual) {
			if ($nodoActual != null) {
				if ($nodoActual->getIzq() != null && $nodoActual->getDer() != null) {
					return $this->arbolCompleto($nodoActual->getIzq()) + $this->arbolCompleto($nodoActual->getDer());
				} elseif ($nodoActual->getIzq() == null && $nodoActual->getDer() == null) {
					return 0;
				} else {
					return 1 + $this->arbolCompleto($nodoActual->getIzq()) + $this->arbolCompleto($nodoActual->getDer());
				}
			}
		}

		public function nodoHoja() {
			$hoja = array();
			if ($this->raiz != null) {
				$cola = array();
				array_unshift($cola, $this->raiz);
				while (sizeof($cola) > 0) {
					$nodoActual = array_shift($cola);
					if ($nodoActual->getIzq() == null && $nodoActual->getDer() == null && $nodoActual->getInfo() != $this->raiz->getInfo()) {
						array_unshift($hoja, $nodoActual->getInfo());
					}
					if ($nodoActual->getIzq() != null) {
						array_unshift($cola, $nodoActual->getIzq());
					}
					if ($nodoActual->getDer() != null) {
						array_unshift($cola, $nodoActual->getDer());
					}
				}
			}
			return $hoja;
		}

		

		public function getNodos() {
			$nodos = array();
			if ($this->raiz != null) {
				$cola = array();
				array_unshift($cola, $this->raiz);
				while (sizeof($cola) > 0) {
					$nodoActual = array_shift($cola);
					array_unshift($nodos, $nodoActual->getInfo());
					if ($nodoActual->getIzq() != null) {
						array_unshift($cola, $nodoActual->getIzq());
					}
					if ($nodoActual->getDer() != null) {
						array_unshift($cola, $nodoActual->getDer());
					}
				}
			}
			return $nodos;
		}

		public function adyacentesIzquierda() {
			$adyacentesIzquierda = array();
			if ($this->raiz != null) {
				$cola = array();
				array_unshift($cola, $this->raiz);
				while (sizeof($cola) > 0) {
					$nodoActual = array_shift($cola);
					$temp = array();
					if ($nodoActual->getIzq() != null) {
						$temp['left'] = $nodoActual->getIzq()->getInfo();
						array_unshift($cola, $nodoActual->getIzq());
					}
					if ($nodoActual->getDer() != null) {
						array_unshift($cola, $nodoActual->getDer());
					}
					$adyacentesIzquierda[$nodoActual->getInfo()] = $temp;
				}
			}
			return $adyacentesIzquierda;
		}

		public function adyacentesDerecha() {
			$adyacentesDerecha = array();
			if ($this->raiz != null) {
				$cola = array();
				array_unshift($cola, $this->raiz);
				while (sizeof($cola) > 0) {
					$nodoActual = array_shift($cola);
					$temp = array();
					if ($nodoActual->getIzq() != null) {
						array_unshift($cola, $nodoActual->getIzq());
					}
					if ($nodoActual->getDer() != null) {
						$temp['right'] = $nodoActual->getDer()->getInfo();
						array_unshift($cola, $nodoActual->getDer());
					}
					$adyacentesDerecha[$nodoActual->getInfo()] = $temp;
				}
			}
			return $adyacentesDerecha;
		}

		public function alturaArbol($nodoActual) {
			if ($nodoActual != null) {
				if ($nodoActual->getIzq() == null && $nodoActual->getDer() == null) {
					return 1;
				} else {
					return 1 + max($this->alturaArbol($nodoActual->getIzq()), $this->alturaArbol($nodoActual->getDer()));
				}
			} 
		}

	}
?>