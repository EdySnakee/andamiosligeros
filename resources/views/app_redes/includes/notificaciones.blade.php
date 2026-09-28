<style>
.notificaciones {
    position: fixed;
    z-index: 11;
    bottom: 0vw;
    right: 1vw;
}
</style>
<div class="notificaciones">
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <strong>Bienvenid@ {{Auth::User()->name}}!</strong> Sesion Iniciada a las {{date('H:i:s')}}.
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
</div>