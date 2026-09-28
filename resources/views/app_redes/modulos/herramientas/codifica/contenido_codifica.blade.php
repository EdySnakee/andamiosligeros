<div class="container-fluid">
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h3 class="m-0 font-weight-bold text-primary">Codifica base64</h3>
      </div>
      <div class="card-body">
        <div class="toolBoxContainer">
            <div class="toolBox">
                <h3 id="encodingBase64">Codificar</h3>
                <div>
                    <p><strong>Descripción:</strong> Codifica un mensaje en base64.</p>

                    <label for="mensaje">Mensaje a codificar:</label>
                    <input class="form-control " type="text" id="cadena" autocomplete="off" name="toEncode"><br>
                    <input type="submit" id="codifica" class="btn btn-info" value="Codificar">
                    <br>
                    <div class="mt-10"><strong id="resultBase64" style="color: rgb(67, 133, 148);">Resultado:</strong></div>
                    <textarea class="form-control " id="result64" readonly="readonly" rows="3" cols="75"></textarea>
                </div>
            </div>
        </div>
      </div>
    </div>
  
  </div>