<div class="w-custom-1 m-auto py-4">
  <form id="personal" name="personal" action="" method="post" enctype="multipart/form-data" class="mx-5">
    <div class="form-row">
      <!-- Familia profesional. Campo obligatorio, valores definidos en la bbdd -->
      <div class="form-group col-md-6">
        <label for="fam_prof" class="font-weight-bold">Familia profesional</label>
          <select class="form-control" id="fam_prof" name="fam_prof">
          <option selected hidden disabled value>Seleccione una familia profesional</option>
          <?php foreach ($res_c as $cat) { ?>
            <option value="<?php echo $cat['ID']?>" <?php if ((isset($_SESSION['id'])) && ($cat['ID'] === $dato['ID_cat'])) echo "selected";?>><?php echo $cat['nombre']; ?></option>
          <?php } ?>             
        </select>
      </div>
      <!-- Diseño. Campo obligatorio, valores definidos en la bbdd -->
      <div class="form-group col-md-6">
        <label for="diseño" class="font-weight-bold">Diseño</label>
        <select class="form-control" id="diseño" name="diseño">
        <option selected hidden disabled value>Seleccione un diseño</option>
          <?php foreach ($res_s as $style) { ?>
            <option class="bg-<?php echo $style['ID']?> text-<?php echo $style['fuente']?>" value="<?php echo $style['ID']?>" <?php if ((isset($_SESSION['id'])) && ($style['ID'] === $dato['ID_cv'])) echo "selected";?>><?php echo $style['ID']; ?></option>
          <?php } ?>           
        </select>
      </div>
    </div>
    <div class="form-row">
      <!-- Nombre personal. Campo obligatorio de máximo 25 caracteres, únicamente letras -->
      <div class="form-group col-md-5">
        <label for="nombre" class="font-weight-bold">Nombre</label>
        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre" value="<?php if(isset($_SESSION['id'])) echo $dato['nombre'];?>" maxlength="25">
      </div>
      <!-- Apellidos. Campo obligatorio de máximo 50 caracteres, únicamente letras -->
      <div class="form-group col-md-7">
        <label for="apellidos" class="font-weight-bold">Apellidos</label>
        <input type="text" class="form-control" id="apellidos" name="apellidos" placeholder="Apellidos" value="<?php if(isset($_SESSION['id'])) echo $dato['apellidos'];?>" maxlength="50">
      </div>
    </div>
    <!-- Dirección postal. Campo obligatorio de máximo 180 caracteres -->
    <div class="form-group">
      <label for="direccion" class="font-weight-bold">Dirección</label>
      <input type="text" class="form-control" id="direccion" name="direccion" placeholder="Dirección" value="<?php if(isset($_SESSION['id'])) echo $dato['direccion'];?>" maxlength="180">
    </div>
    <div class="form-row">
      <!-- Localidad. Campo obligatorio de máximo 30 caracteres, únicamente letras -->
      <div class="form-group col-md-5">
        <label for="localidad" class="font-weight-bold">Localidad</label>
        <input type="text" class="form-control" id="localidad" name="localidad" placeholder="Localidad" value="<?php if(isset($_SESSION['id'])) echo $dato['localidad'];?>">
      </div>
      <!-- País. Campo obligatorio, valores definidos en la bbdd -->
      <div class="form-group col-md-4">
        <label for="cod_pais" class="font-weight-bold">País</label>
        <select class="form-control" id="cod_pais" name="cod_pais">
          <option selected hidden disabled value>Seleccione país</option>
          <?php foreach ($res_p as $pais) { ?>
            <option value="<?php echo $pais['ID']?>" <?php if (isset($_SESSION['id']) && ($pais['ID'] === $dato['ID_pais'])) {echo "selected";}?>><?php echo $pais['nombre']; ?></option>
          <?php } ?>
        </select> 
      </div>
      <!-- Código postal. Campo obligatorio de 5 carácteres. Solo números -->
      <div class="form-group col-md-3">
        <label for="cod_postal" class="font-weight-bold">Código postal</label>
        <input type="text" class="form-control" id="cod_postal" name="cod_postal" placeholder="Código postal" value="<?php if (isset($_SESSION['id'])) echo $dato['cod_postal'];?>">
      </div>
    </div>
    <!-- Imagen de usuario. Campo obligatorio, no superior a 1MB, imagen gif, png, jpg o jpeg y de max 200px x 200px -->
    <div class="form-row">
      <div class="form-group col-md-12">
        <label for="archivo_img" class="font-weight-bold">Imagen de perfil</label>
        <input type="file" class="form-control-file" id="archivo_img" name="archivo_img" <?php if(!isset($_SESSION['id'])) echo "required";?>>
        <small id="archivo_img" class="form-text text-muted">No se admiten archivos superiores a 1MB. Imagen formato png o jpg.</small>
      </div>
    </div>
    <div class="d-flex justify-content-end">
      <input type="submit" id="submit_personal" name="submit_personal" class="btn btn-secondary mb-5" value="Guardar cambios">
    </div>
  </form>
</div>