//Declaramos las variables que vamos a user
var lat = null;
var lng = null;
var map = null;
var geocoder = null;
var marker = null;
$(document).on("keyup", "#latitud", actualizaLatLong);
$(document).on("keyup", "#longitud", actualizaLatLong);

function actualizaLatLong () {
    lat = $('#latitud').val();
    lng = $('#longitud').val();
    initialize()
}

$(document).ready(function(){
    //obtenemos los valores en caso de tenerlos en un formulario ya guardado en la base de datos
    lat = $('#ubicacion').attr("data-lat");
    lng = $('#ubicacion').attr("data-long");
    //Inicializamos la función de google maps una vez el DOM este cargado
    initialize();

});
function initialize() {

    geocoder = new google.maps.Geocoder();

    //Si hay valores creamos un objeto Latlng
    if(lat !='' && lng != '')
    {
        var latLng = new google.maps.LatLng(lat,lng);
    }
    else
    {
        var latLng = new google.maps.LatLng(20.9673812,-89.5925853);
    }
    //Definimos algunas opciones del mapa a crear
    var myOptions = {
        center: latLng,//centro del mapa
        zoom: 15,//zoom del mapa
        mapTypeId: google.maps.MapTypeId.ROADMAP, //tipo de mapa, carretera, híbrido,etc
        scrollwheel:false,
        streetViewControl: false
    };
    //creamos el mapa con las opciones anteriores y le pasamos el elemento div
    map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);

    //creamos el marcador en el mapa
    marker = new google.maps.Marker({
        map: map,//el mapa creado en el paso anterior
        position: latLng,//objeto con latitud y longitud
        draggable: false, //que el marcador se pueda arrastrar
    });

    //función que actualiza los input del formulario con las nuevas latitudes
    //Estos campos suelen ser hidden
    //updatePosition(latLng);
}