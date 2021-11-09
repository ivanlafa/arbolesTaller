<?php
include('arbol.php');
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<div>
		<h4>Ivan Lafaurie,Sebastian de la rosa</h4>
		<br>&copy Copyrigth
		</div>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Arboles binarios</title>
    <link href="https://fonts.googleapis.com/css?family=Baloo+Bhaina+2:400,500&display=swap" rel="stylesheet">
	<script type="text/javascript" src="vis/dist/vis.js"></script>
	<link rel="stylesheet" type="text/css" href="vis/dist/vis.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	<link rel="stylesheet" type="text/css" href="dist/sweetalert.css">
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
    <div class="contenedor">
        <header>
            <div class="logo-contenedor">
                <img src="/arbolesTaller/img/logo.png" alt="logo.png" class="logoinicio" id="logoinicio">
                <p id="barrita">_____________________________________________________________________________________________________________________________</p>
            </div>
        </header>
    </div>
    <div class="contenido-principal">
        <h4 id="txtPantalla"><b>Vista previa</b></h4>
        <div class="pantallaArbol" id="pantallaArbol">

        </div>
        <section class="Funciones">
            <br><br>
            <h4><b>Crear arbol</b></h4>

                <form action="index.php" method="post">
                    <input type="text" class="controls" name="nombreRaiz" id="nombreRaiz" placeholder="Nombre de la raiz">&ensp;
                    <input type="submit" class="boton" name="BtnCrearArbol" id="BtnCrearArbol" value="Crear arbol"><br><br>
                </form>

                <form action="index.php" method="post">
                    <input type="text" class="controls" name="nombrePapa" id="nombrePapa" placeholder="Nombre papa">&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;
                    <div class="opciones">
                    <label for="left_radio">Izquierda</label>
					<input type="radio" name="ubicacion" id="left_radio" class="radioInput" value="left"><br>
					<label for="right_radio">Derecha</label>
					<input type="radio" name="ubicacion" id="right_radio" class="radioInput" value="right">
                    </div>
                    <input type="text" class="controls" name="nombreHijo" id="nombreHijo" placeholder="Nombre hijo">&ensp;
                    <input type="submit" class="boton" name="BtnAgregarNodo" id="BtnAgregarNodo" value="Agregar Nodo"><br><br>
                </form>

                <form action="index.php" method="post">
                <input type="text" class="controls" name="nombreNodo" id="nombreNodo" placeholder="Nombre nodo">&ensp;
                <input type="submit" class="boton" name="BtnEliminarNodo" id="BtnEliminarNodo" value="Eliminar Nodo"><br>
                </form>

                <p>______________________________________________________________</p><br>
                <form action="index.php" method="post">
                <input type="submit" class="boton" name="BtnContarNodos" id="BtnContarNodos" value="Contar No. de nodos">&ensp;
                <input type="submit" class="boton" name="BtnCompleto" id="BtnCompleto" value="¿El arbol es completo?"><br>
                <input type="submit" class="boton" name="BtnPares" id="BtnPares" value="Contar numeros pares">&ensp;
                <input type="submit" class="boton" name="BtnPosOrden" id="BtnPosOrden" value="Recorrido Pos-Orden"><br>
                <input type="submit" class="boton" name="BtnNiveles" id="BtnNiveles" value="Recorrido por niveles">&ensp;
                <input type="submit" class="boton" name="BtnHojas" id="BtnHojas" value="Ver nodos hojas"><br>
                <input type="submit" class="boton" name="BtnPreOrden" id="BtnPreOrden" value="Recorrido Pre-Orden">&ensp;
                <input type="submit" class="boton" name="BtnAltura" id="BtnAltura" value="Calcular Altura"><br>
                <input type="submit" class="boton" name="BtnInOrden" id="BtnInOrden" value="Recorrido In-Orden"><br>
                </form>




                
            </form>
        </section>
    </div>
	

</body>

<script type="text/javascript">

    //Crear Arbol
	<?php
	if (isset($_POST['BtnCrearArbol']) && !empty($_POST['nombreRaiz'])) {
		$raiz = new Nodo($_POST['nombreRaiz']);
		$_SESSION['arbol'] = new Arbol($raiz);
	} elseif (isset($_POST['BtnCrearArbol']) && empty($_POST['nombreRaiz'])) {
		echo "alert('Escriba un valor exacto de la raiz');";
	}
	if (isset($_POST['hojas']) && ($_SESSION['arbol'] == null || $_SESSION['arbol']->getRaiz() == null)) {
		echo "alert('Árbol vacio');";
	}
	if (isset($_POST['mostrar']) && ($_SESSION['arbol'] == null || $_SESSION['arbol']->getRaiz() == null)) {
		echo "alert('Árbol vacio');";
	}
	if (isset($_POST['BtnAgregarNodo']) && !empty($_POST['nombreHijo']) && !empty($_POST['nombrePapa']) && !empty($_POST['ubicacion'])) {
		try {
			$_SESSION['arbol']->agregarNodo($_POST['nombreHijo'], $_POST['nombrePapa'], $_POST['ubicacion']);
		} catch (Exception $e) {
			$error = $e->getMessage();
			echo "alert('$error');";
		}

    //Agregar Nodo
	} elseif (isset($_POST['BtnAgregarNodo']) && (empty($_POST['nombreHijo']) || empty($_POST['nombrePapa']) || empty($_POST['ubicacion']))) {
		echo "alert('Complete todos los campos');";
	}

    //Eliminar Nodo
	if (isset($_POST['BtnEliminarNodo']) && !empty($_POST['nombreNodo'])) {
		try {
			$_SESSION['arbol']->eliminarNodo($_POST['nombreNodo']);
		} catch (Exception $e) {
			$error = $e->getMessage();
			echo "alert('$error');";
		}
	} elseif (isset($_POST['BtnEliminarNodo']) && empty($_POST['nombreNodo'])) {
		echo "alert('Escriba el nombre del nodo que desea eliminar');";
	}
	?>

    //Nodos hojas
	var nodos = new vis.DataSet(
		[
			<?php
			$hojas = array();
			if (isset($_POST['BtnHojas'])) {
				$hojas = $_SESSION['arbol']->nodoHoja();
			}
			$nodos = $_SESSION['arbol']->getNodos();
			if (sizeof($hojas) == 0) {
				foreach ($nodos as $key => $IdNodo) {
					echo "{id: '$IdNodo', label: '$IdNodo', color: '#00BFFF'}, ";
				}
			} else {
				foreach ($nodos as $key => $IdNodo) {
					if (in_array($IdNodo, $hojas)) {
						echo "{id: '$IdNodo', label: '$IdNodo', color: '#00FF7F'}, ";
					} else {
						echo "{id: '$IdNodo', label: '$IdNodo', color: '#00BFFF'}, ";
					}
				}
			}
			?>
		]
	);
	var aristas = new vis.DataSet(
		[
			<?php
			$adyacentesIzquierda = $_SESSION['arbol']->adyacentesIzquierda();
			$adyacentesDerecha = $_SESSION['arbol']->adyacentesDerecha();
			foreach ($adyacentesDerecha as $from => $adyaDer) {
				foreach ($adyaDer as $direction => $to) {
					echo "{from: '$from', to: '$to'}, ";
				}
			}
			foreach ($adyacentesIzquierda as $from => $adyaIzq) {
				foreach ($adyaIzq as $direction => $to) {
					echo "{from: '$from', to: '$to'}, ";
				}
			}
			?>
		]
	);
	var datos = {
		nodes: nodos,
		edges: aristas
	}
	var opciones = {
		layout: {
			hierarchical: {
				direction: 'UD',
				sortMethod: 'directed'
			},
			randomSeed: 2,
			physics: {
				enabled: false
			}
		}
	};
	var contenedor = document.getElementById('pantallaArbol');
	var network = new vis.Network(contenedor, datos, opciones);
</script>
<script type="text/javascript">

    //Contar No. de nodos
	<?php
	if (isset($_POST['BtnContarNodos'])) {
		if ($_SESSION['arbol'] == null || $_SESSION['arbol']->getRaiz() == null) {
			echo "alert('Árbol vacio');";
		} else {
			$cant = $_SESSION['arbol']->contarNodos($_SESSION['arbol']->getRaiz());
			$msj = "Hay " . $cant . " nodos";
			echo "alert('$msj');";
		}
	}
    
    //Verificar si el arbol es completo
	if (isset($_POST['BtnCompleto'])) {
		if ($_SESSION['arbol'] == null || $_SESSION['arbol']->getRaiz() == null) {
			echo "alert('Árbol vacio')";
		} else {
			$res = $_SESSION['arbol']->arbolCompleto($_SESSION['arbol']->getRaiz());
			$msj;
			if ($res == 0) {
				$msj = "El arbol esta lleno";
			} else {
				$msj = "Faltan" . $res . " nodos para ser completado";
			}
			echo "alert('$msj');";
		}
	}

    //Contar numeros pares
	if (isset($_POST['BtnPares'])) {
		if ($_SESSION['arbol'] == null || $_SESSION['arbol']->getRaiz() == null) {
			echo "alert('Arbol vacio');";
		} else {
			$res = $_SESSION['arbol']->contarPares($_SESSION['arbol']->getRaiz());
			$msj = "Hay" . $res . " nodos pares";
			echo "alert('$msj');";
		}
	}

    //Recorrido Pos orden
	if (isset($_POST['BtnPosOrden'])) {
		if ($_SESSION['arbol'] == null || $_SESSION['arbol']->getRaiz() == null) {
			echo "alert('Arbol Vacio');";
		} else {
			$rec = $_SESSION['arbol']->recorridoPosOrden($_SESSION['arbol']->getRaiz(), "");
			echo "alert('$rec');";
		}
	}

    //Recorrido por niveles
	if (isset($_POST['BtnNiveles'])) {
		try {
			$rec = $_SESSION['arbol']->recorridoNiveles();
			echo "alert('$rec');";
		} catch (Exception $e) {
			$error = $e->getMessage();
			echo "alert('$error');";
		}
	}

    //Recorrido Pre Orden
	if (isset($_POST['BtnPreOrden'])) {
		if ($_SESSION['arbol'] == null || $_SESSION['arbol']->getRaiz() == null) {
			echo "alert('Arbol Vacio');";
		} else {
			$rec = $_SESSION['arbol']->recorridoPreOrden($_SESSION['arbol']->getRaiz(), "");
			echo "alert('$rec');";
		}
	}

    //Calcular altura
	if (isset($_POST['BtnAltura'])) {
		if ($_SESSION['arbol'] == null || $_SESSION['arbol']->getRaiz() == null) {
			echo "alert('Arbol Vacio')";
		} else {
			$res = "La altura del árbol es :" . $_SESSION['arbol']->alturaArbol($_SESSION['arbol']->getRaiz(), 0);
			echo "alert('$res');";
		}
	}

    //Recorrido In Orden
	if (isset($_POST['BtnInOrden'])) {
		if ($_SESSION['arbol'] == null || $_SESSION['arbol']->getRaiz() == null) {
			echo "alert('Arbol Vacio');";
		} else {
			$rec = $_SESSION['arbol']->recorridoInOrden($_SESSION['arbol']->getRaiz(), "");
			echo "alert('$rec');";
		}
	}
	?>
</script>

</html>