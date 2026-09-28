<script>
$('.btn-med').on('click', function(e) {
    e.preventDefault();
    var $this = $(this);

    if ($this.hasClass('active-med')) {
        return false;
    }
    var $optionSet = $this.parents();

    $optionSet.find('.active-med').removeClass('active-med');
    $this.addClass('active-med');

    var val_ubi = $(this).attr("attr-med");
    muestraMedidas(val_ubi);
    return false;
});

function muestraMedidas(val_ubi) {
    var $grupo_ubis = $("#" + val_ubi);
    if ($(".groups").hasClass('grupo-activo')) {
        //alert("Entro a quitar clase")
        $(".groups").removeClass('grupo-activo')
    }
    $($grupo_ubis["0"]).addClass('grupo-activo')
    /*

    //$("." + val_ubi + " > .item-graph").attr("class", "item-graph animate__animated animate__bounceIn_Slow");
    //$("." + val_ubi + " > .item-texto").attr("class", "item-texto animate__animated animate__fadeIn animate__delay-1-1s");
    */
}
</script>