<?php 
  require_once 'conexion.php';
  //consultar por id
  if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql ="SELECT * FROM `productos` where id=$id";
    $datos = $con->query($sql);
    $campo=$datos->fetch_object();
    
    $nombre=$campo->nombre;
    $precio=$campo->precio;
    $activo=$campo->activo;

  }

  //Guardar los productos
  if (isset($_POST['accion'])) {
    if ($_POST['accion'] == "Guardar") {
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $activo = 0;
    if(isset($_POST['activo'])){
      $activo = 1;
    }
    $sql="INSERT INTO `productos`(`id`, `nombre`, `precio`, `activo`) VALUES (DEFAULT,'$nombre','$precio','$activo')";
    $datos = $con->query($sql);
    header("location:index.php");

    }else if($_POST['accion'] == "Editar"){
    $id = $_POST['id'];      
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $activo = 0;
    if(isset($_POST['activo'])){
      $activo = 1;
    }

    $sql="UPDATE `productos` SET `nombre`='$nombre',`precio`='$precio',`activo`='$activo' WHERE id = $id";
    $datos = $con->query($sql);
    header("location:index.php");

    }  
  }
  $sql ="SELECT * FROM `productos`";
  $datos = $con->query($sql);
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>Lista de productos</title>
  </head>
  <body>
    <div class="container py-4">
      <div class=card>
        <div class="card-body">
          <h4 class="card-tittle">Registrar producto</h4>
          <form action="" method="post">
            <input type="hidden" name="id" value="<?php echo @$id ?>">
            <div class=row>
              <div class=col-md-5>
                <label for="nombre" class="form-label">Nombre del producto</label>
                <input type="text" class="form-control" name="nombre" value="<?php echo @$nombre;?>">   

              </div>
               <div class=col-md-5>
                <label for="precio" class="form-label">Precio del producto</label>
                <input type="number" class="form-control" name="precio" value="<?php echo @$precio;?>">                             
              </div>             
            </div>
            <div class="row py-4">
              <div class="col-md-2">
                <label for="activo" class="form-label">¿Activo?</label>
                <input type="checkbox" <?php echo(@$activo==1)?"checked":""?>  name="activo">               
              </div>             
            </div>
            <div class="row justify-content-end">
              <div class="col-md-4">
                <div class="btn-group" role="group" aria-label="Basic mixed styles example">

                <input type="reset" class="btn btn-danger" name="accion" value="Limpiar">
                <?php 
                if (isset($_GET['id'])) {
                  ?>
                  <input type="submit" class="btn btn-warning" name="accion" value="Editar">
                  <?php                  
                }else{
                  ?>
                  <input type="submit" class="btn btn-success" name="accion" value="Guardar">
                  <?php 

                }
                ?>
               </div>                
              </div>            
            </div>
          </form>
        </div>
      </div>
      <table class="table table-striped">
  <thead>
    <tr>
      <th scope="col">#ID</th>
      <th scope="col">Nombre</th>
      <th scope="col">Precio</th>
      <th scope="col">Activo</th>
      <th scope="col">Acciones</th>
    </tr>
  </thead>
  <tbody>
    <?php 
      while($fila=$datos->fetch_object()){
      ?>
      <tr>
       <td scope="row">
        <?php echo $fila->id;?>
       </td>
       <td>
        <?php echo $fila->nombre;?>
       </td>
       <td>
        <?php echo number_format($fila->precio,0,",",".");?>
       </td>
       <td>
        <?php echo ($fila->activo==1?"Activo":"Inactivo");?>
       </td>
       <td>
        <div class="btn-group" role="group" aria-label="Basic mixed styles example">
        <a href="?id=<?php echo $fila->id;?>" class="btn btn-primary">Editar</a>
        <a href="eliminar.php?id=<?php echo base64_encode($fila->id);?>" class="btn btn-danger">Eliminar</a>
        <button class="btn btn-warning">Cambiar estado</button>
        </div>
        
       </td>
      </tr> 
    <?php 
      }
    ?>



    
  </tbody>
  </table>

  </div>
    
  </body>
</html>