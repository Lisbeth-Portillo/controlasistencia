<?php
	include_once 'conexion.php';

	$sentencia_select=$con->prepare('SELECT
                                        a.Id_Alumno AS alumno,
                                        a.Nombre AS nombre,
                                        a.FechaNa AS fecha,
                                        g.Nombre AS grado
                                    FROM
                                        alumno AS a
                                    INNER JOIN grado AS g
                                    ON
                                        a.Id_Grado = g.Id_Grado');
	$sentencia_select->execute();
	$resultado=$sentencia_select->fetchAll();

	// metodo buscar
	if(isset($_POST['btn_buscar'])){
		$buscar_text=$_POST['buscar'];
		$select_buscar=$con->prepare('
			SELECT *FROM alumno WHERE nombre LIKE :campo;'
		);

		$select_buscar->execute(array(
			':campo' =>"%".$buscar_text."%"
		));

		$resultado=$select_buscar->fetchAll();

	}

?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Inicio</title>
	<link rel="stylesheet" href="estilo.css">
</head>
<body>
	<div class="contenedor">
		<h2>Control de asistencia</h2>
		<div class="barra__buscador">
			<form action="" class="formulario" method="post">
				<input type="text" name="buscar" placeholder="buscar nombre o apellidos" 
				value="<?php if(isset($buscar_text)) echo $buscar_text; ?>" class="input__text">
				<input type="submit" class="btn" name="btn_buscar" value="Buscar">
				<a href="insert.php" class="btn btn__nuevo">Nuevo</a>
			</form>
		</div>
		<table>
			<tr class="head">
				<td>Id</td>
				<td>Nombre</td>
				<td>Fecha Nacimiento</td>
				<td>Grado</td>
				<td colspan="2">Acción</td>
			</tr>
			<?php foreach($resultado as $fila):?>
				<tr >
					<td><?php echo $fila['alumno']; ?></td>
					<td><?php echo $fila['nombre']; ?></td>
					<td><?php echo $fila['fecha']; ?></td>
					<td><?php echo $fila['grado']; ?></td>
					<td><a href="update.php?id=<?php echo $fila['alumno']; ?>"  class="btn__update" >Editar</a></td>
					<td><a href="delete.php?id=<?php echo $fila['alumno']; ?>" class="btn__delete">Eliminar</a></td>
				</tr>
			<?php endforeach ?>

		</table>
	</div>
</body>
</html>