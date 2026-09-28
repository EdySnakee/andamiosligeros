<div class="col-md-4">
	<div class="form-group">
	    <label for="nombre_empresa">Nombre Empresa:</label>
	    <input type="text" class="form-control" id="nombre_empresa" name="nombre_empresa" placeholder="Nombre empresa" autocomplete="nope" value="{{(!empty($objEmpresa->nombre_empresa))?$objEmpresa->nombre_empresa : ''}}">
	</div>
</div>
<div class="col-md-4">
	<div class="form-group">
		<label for="r_social">Razón Social:</label>
		<input type="text" class="form-control" id="r_social" name="r_social" placeholder="Razón Social" autocomplete="nope" value="{{(!empty($objEmpresa->razon_social))?$objEmpresa->razon_social : ''}}">
	</div>
</div>
<div class="col-md-4">
	<div class="form-group">
		<label for="rfc_empresa">RFC:</label>
		<input type="text" class="form-control" id="rfc_empresa" name="rfc_empresa" placeholder="RFC" autocomplete="nope" value="{{(!empty($objEmpresa->rfc))?$objEmpresa->rfc : ''}}">
	</div>
</div>