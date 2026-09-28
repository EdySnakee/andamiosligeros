<style>
*,
*::before,
*::after {
box-sizing: border-box;
}

html {
scroll-behavior: smooth;

}

body {
margin: 0;
-webkit-text-size-adjust: 100%;
-webkit-tap-highlight-color: rgba(0, 0, 0, 0);
background: #f7f7f7;
}

h1,
h2,
h3,
h4,
h5{
font-family: 'Poppins', sans-serif;
color: #232323;
}

h1,
h2,
h3,
h4,
h5 {
margin: 0;
}

h1 {
font-size: 2.2vw
}
h2 {
font-size: 1.8vw
}

h3 {
font-size: 1.5vw;
}
header,
nav,
span,
a {
font-family: 'Poppins', sans-serif;
}
p{
font-family: 'Montserrat', sans-serif;
font-size: 1.4vw;
margin: 0.5vw 0;
color: #232323;
}

a {
text-decoration: none;
}
a:hover {
    text-decoration: none;
}
ul {
padding: 0;
list-style: none;
margin: 0;
}
@keyframes b-shadow {
  0% {
    box-shadow: 0px 0px 0px 20px rgba(59, 38, 219, 0.1), 0px 0px 0px 40px rgba(59, 38, 219, 0.1), 0px 0px 0px 60px rgba(59, 38, 219, 0.1), 0px 0px 0px 80px rgba(59, 38, 219, 0.1), 0px 0px 0px 100px rgba(59, 38, 219, 0.1);
  }
  50% {
    box-shadow: 0px 0px 0px 50px rgba(59, 38, 219, 0.1), 0px 0px 0px 75px rgba(59, 38, 219, 0.1), 0px 0px 0px 100px rgba(59, 38, 219, 0.1), 0px 0px 0px 125px rgba(59, 38, 219, 0.1), 0px 0px 0px 150px rgba(59, 38, 219, 0.1);
  }
  100% {
    box-shadow: 0px 0px 0px 20px rgba(59, 38, 219, 0.1), 0px 0px 0px 40px rgba(59, 38, 219, 0.1), 0px 0px 0px 60px rgba(59, 38, 219, 0.1), 0px 0px 0px 80px rgba(59, 38, 219, 0.1), 0px 0px 0px 100px rgba(59, 38, 219, 0.1);
  }
}
.cont-movil {
    display: flex;
    justify-content: right;
    align-items: center;
}
.cont-carrito {
    position: absolute;
    width: 1.2em;
    height: 1.2em;
    background: #ffbb01ed;
    border-radius: 50%;
    color: white;
    display: flex;
    justify-content: center;
    align-items: center;
    top: -6px;
    right: -5px;
}
.font-cart {
    font-size: 10px;
}
.contact_box {
    position: absolute;
    right: 0;
}
.form-control-cart {
    width: 100%;
    padding: 0.5em;
    margin-bottom: 10px;
    border: 1px #1d1d1d solid;
    border-radius: 5px;
}
.carrito_box {
    position: relative;
}
main.blog {
background: white;
}
.cont-menu-movil {
display: none;
}
/* Animation */
@-webkit-keyframes pulsate {
0% {
-webkit-transform: scale(1);
transform: scale(1);
opacity: 0.8;
}

45% {
-webkit-transform: scale(1.75);
transform: scale(1.75);
opacity: 0;
}
}

@keyframes pulsate {
0% {
-webkit-transform: scale(1);
transform: scale(1);
opacity: 0.8;
}

45% {
-webkit-transform: scale(1.75);
transform: scale(1.75);
opacity: 0;
}
}

@-webkit-keyframes zcwmini2 {
0% {
box-shadow: 0 0 8px 6px rgba(207, 8, 8, 0), 0 0 0 0 rgba(0, 0, 0, 0), 0 0 0 0 rgba(207, 8, 8, 0);
}

10% {
box-shadow: 0 0 8px 6px, 0 0 12px 10px rgba(0, 0, 0, 0), 0 0 12px 14px;
}

100% {
box-shadow: 0 0 8px 6px rgba(207, 8, 8, 0), 0 0 0 40px rgba(0, 0, 0, 0), 0 0 0 40px rgba(207, 8, 8, 0);
}
}
.seccion-normal {
padding: 5vw 0;
position: relative;
}
.bienvenida h1 {
text-transform: uppercase;
color: #ffbb01;
}
.bienvenida h3 {
color: #4e4e4e;
letter-spacing: 0.2vw;
}
.item-subm {
background: #ffbb01;
color: white !important;
padding: 0.5vw 1vw;
}

.sticky .item-subm {
top: 1.3vw;
}
.texto{
padding-left: 1vw;
padding-right: 1vw;
}

.bg-home {
overflow: hidden;
}
.bg-figuras{
background: url("{{url('web/img/banner/bg-figs-andamios.png')}}");
position: absolute;
background-attachment: fixed;
background-position: 50% 0px;
width: 100%;
height: 100%;
z-index: -2;
background-size: cover;
}
.bg-letras {
background: url("{{url('web/img/banner/bg-letras-andamios.png')}}");
position: absolute;
width: 100%;
height: 100%;
background-position: center;
z-index: -2;
background-size: 100%;
background-repeat: no-repeat;
}
.bg-items {
background: url("{{url('web/img/banner/bg-items-andamios.png')}}");
position: absolute;
width: 100%;
height: 100%;
background-position: center;
z-index: -1;
background-size: 100%;
}

.img-fila1 {
display: grid;
grid-template-columns: repeat(5, 1fr);
width: 95vw;
margin: 0 auto;
margin-top: 2vw;
}
.img-fila1 img {
width: 100%;
}
.img-fila2 {
display: grid;
grid-template-columns: repeat(4, 1fr);
width: 90vw;
margin: 0 auto;
}
.img-fila2 img {
width: 100%;
}
.banner {
padding: 3vw 0;
}
.grid-flex{
display: grid;
}
.grid-items-4{
grid-template-columns: repeat(4, [col-start] 1fr);
}
.wrapper{
grid-template-columns: repeat(12, [col-start] 1fr);
grid-gap: 20px;
}
.col-4 {
grid-column: col-start 9 / span 4;
}
.col-5 {
grid-column: col-start 8 / span 5;
}
.col-8 {
grid-column: col-start 1 / span 8 ;
display: flex;
align-items: center;
justify-content: center;
}
.col-12 {
grid-column: col-start 1 / span 12 ;
display: flex;
align-items: center;
justify-content: center;
}
.col-7 {
grid-column: col-start 1 / span 7 ;
display: flex;
align-items: center;
justify-content: center;
}
.col-in-6{
grid-column: col-start 1 / span 6 ;
}
.col-out-6{
grid-column: col-start 7 / span 6 ;
}

.cont-img-banner {
display: flex;
align-items: flex-end;
justify-content: left;
width: 90vw;
}
.img-banner {
width: 100%;
margin-left: -15vw;
}
.seccion-sp {
position: relative;
}
.cont-absolute {
position: absolute;
top: 0;
right: 5vw;
width: 37vw;
bottom: 0;
display: flex;
align-items: center;
}
.pb5{
padding-bottom: 5vw;
}
.contacto {
background: url("{{url('web/img/background-footer.webp')}}");
padding-top: 5vw;
background-position: center;
background-repeat: no-repeat;
background-size: cover;
}
.sub-footer {
background: black;
padding: 1vw 0;
}
.logo-coral {
width: 10vw;
}
.d-flex{
display: flex;
align-items: center;
justify-content: center;
}
.contacto p, .contacto h2, .contacto h3 {
color: white;
}
.contacto p {
font-size: 1vw;
}
.item-contact {
color: white;
font-size: 1vw;
}
.mt-30 {
margin-top: 1vw;
}
.tit-sub-footer {
margin: 0;
}
.contacto h2, .contacto h3 {
text-transform: uppercase;
}
.logo img {
width: 12vw;
padding: 0.3vw;
transition: 0.5s;
}

.menu-top {
position: absolute;
left: 0;
z-index: 5;
top: 0;
width: 100%;
transition: 0.5s;
box-shadow: 0px 15px 20px 0px rgb(0 37 93 / 15%);
    background: white;
}

.sticky {
position: fixed;
background: white;
z-index: 3;
transition: 0.5s;
box-shadow: 0px 15px 20px 0px rgb(0 37 93 / 15%);
}
.sticky .menu{
    background: white;
}

.sticky .logo img {
width: 10vw;
transition: 0.5s;
}

.sticky a {
transition: 0.5s;
}
li.padre {
    position: relative;
}
ul.sub_submenu {
    display: block !important;
}
a.titulo-sub-menu {
    text-transform: uppercase;
    font-size: 1vw !important;
    padding: 0.5vw 0vw !important;
}
.cont-submenu {
    padding: 0.5vw;
}
.sub_submenu li a {
    width: 16vw !important;
}
.sub_submenu li a {
    position: relative;
}

.sub_submenu li a i {
    position: absolute;
    top: 5px;
    color: #0848af;
}
.submenu {
    position: absolute;
    display: grid;
    grid-template-columns: repeat(6, 1fr);
    gap: 5px;
    right: -27vw;
    background: white;
    box-shadow: 0px 30px 20px 0px rgb(0 37 93 / 15%);
    overflow: hidden;
    height: 0;
    transition: 0.5s;
}

.submenu li a:hover {
background: #ffbb01;
color: white;
}
.padre:hover > ul {
height: auto;
transition: 0.5s;
}
.submenu .hijo {
margin-right: 0 !important;
margin-left: 0 !important;
display: inline-flex;
}
.submenu li a {
padding: 0.5vw 1vw;
width: 15vw;
display: block;
font-size: 0.9vw;
text-align: left;
}
.seccion {
width: 100%;
height: auto;
position: relative;
overflow: hidden;
}

.text-center {
text-align: center;
}

.text-left {
text-align: left;
}

.text-right {
text-align: right;
}

.col2 {
display: grid;
grid-template-columns: 49vw 50vw;
}

.grid6 {
display: grid;
grid-template-columns: repeat(2, 1fr);
}

.grid12 {
display: grid;
grid-template-columns: repeat(1, 1fr);
}

.disp-flex-center {
display: flex;
align-items: center;
justify-content: center;
}
.logo {
width: 20vw;
display: flex;
    align-items: center;
    justify-content: center;
}
.menu{
display: flex;
align-items: center;
justify-content: center;
margin: 0 auto;
z-index: 77;
    position: absolute;
    width: 100%;
}

.ul-nav {
width: 55vw;
text-align: right;
}

.menu ul li {
display: inline-block;
margin-left: 1vw;
margin-right: 1vw;
}

.menu-top a {
font-size: 1.1vw;
color: #04070f;
font-weight: 600;
transition: 0.5s;
}

.text-cont span {
display: block;
}

.tit1 {
font-size: 3vw;
}

.tit2 {
font-size: 4vw;
}

.tit3 {
font-size: 2vw;
}

.text-cont h1 {
line-height: 5.5vw;
}
.btn-masinfo {
margin-top: 2vw;
}
.btn-g {
padding: 0.5vw 1vw;
border-radius: 5px;
font-size: 1vw;
}

.btn-xl {
padding: 1vw 2vw;
border-radius: 5px;
font-size: 1.5vw;
}

.btn {
padding: 0.5vw 1vw;
border-radius: 0.4vw;
font-size: 0.8vw;
}

.btn-info {
color: white;
background: #0648d6;
}

.btn-models {
background: #ffbb01;
color: white;
}

.img-responsive {
width: 100%;
}

.text-info h1 {
line-height: 4vw;
margin: 0;
}

.col-item-b {
display: flex;
justify-content: center;
align-items: center;
}

.img-cont {
position: absolute;
top: 0;
left: 0;
right: 0;
bottom: 0;
margin: auto;
width: 50vw;
z-index: -1;
opacity: 0.3;
display: flex;
align-items: center;
justify-content: center;
}

.col-item6 {
position: relative;
}

.height100 {
height: 100vh;
}

.text-info {
text-align: left;
/*position: fixed;*/
}

.text-info span {
display: block;
}

.cont-midle {
width: 50vw;
margin: 0 auto;
}

.page-title h2 {
font-size: 3vw;
}

.page-title h3 {
font-size: 2vw;
}

.border-title {
position: relative;
}

.border-title-secc h1 {
font-size: 5vw;
color: transparent;
text-transform: uppercase;
-webkit-text-stroke: 1px #cdcdcd;
margin-bottom: 0;
width: 100%;
z-index: -1;
}
.border-title-secc {
font-size: 4vw;
color: transparent;
text-transform: uppercase;
-webkit-text-stroke: 1px #5c5c5c;
margin-bottom: 0;
width: 100%;
line-height: 1;
text-align: left;
margin-bottom: 1.5vw;
font-family: 'Poppins', sans-serif;
}
.border-title-secc2 {
font-size: 4vw;
color: transparent;
text-transform: uppercase;
-webkit-text-stroke: 1px white;
margin-bottom: 0;
width: 100%;
line-height: 1;
text-align: left;
margin-bottom: 2vw;
font-family: 'Poppins', sans-serif;
}
.globo-info h3, .globo-info p {
color: white;
}
.owl-img-and {
width: 100%;
}
.border-title h1 {
font-size: 5vw;
color: #f7f7f7;
text-transform: uppercase;
-webkit-text-stroke: 1px #cdcdcd;
margin-bottom: 0;
width: 100%;
z-index: -1;
}

.page-title {
line-height: 4vw;
width: 50vw;
margin: 1vw auto 0;
}

.page-title h2 {
font-size: 3vw;
color: #4e4e4e;
text-transform: uppercase;
font-weight: 900;

}

.sub-left {
position: absolute;
top: 5.2vw;
left: 1vw;
z-index: 1;
}

.sub-right {
position: absolute;
top: 5.2vw;
right: 1vw;
z-index: 1;
}

.sub-center {
margin-top: 5.2vw;
}

.cont-midle {
width: 100%;
margin: 0 auto;
height: 100vh;
display: flex;
justify-content: center;
align-items: center;
}

.img-cont-graph {
width: 30vw;
position: relative;
}

.hot-spot {
position: absolute;
width: 2vw;
height: 2vw;
text-align: center;
background-color: #0648d6;
color: #fff;
border-radius: 100%;
transition: all .3s ease;
}

.hot-spot .circle {
display: block;
position: absolute;
top: 47%;
left: 47%;
width: 2.5vw;
height: 2.5vw;
margin: -1.18vw auto auto -1.2vw;
-webkit-transform-origin: 50% 50%;
transform-origin: 50% 50%;
border-radius: 50%;
border: 2px solid #0648d6;
opacity: 0;
-webkit-animation: pulsate 2s ease-out infinite;
animation: pulsate 2s ease-out infinite;
}

div#descript-tradicionales {
top: 5vw;
left: 9vw;
}

div#materiales-tradicionales {
bottom: 14vw;
right: 5vw;
}

div#medidas-tradicionales {
bottom: 10vw;
left: 9.5vw;
}

.info-descript-trad {
position: absolute;
width: 25vw;
top: 1.2vw;
left: -24vw;
}

.and-trad .info-descript-trad {
position: absolute;
width: 22vw;
top: 3vw;
left: -9.5vw;
}

.and-trad .globo-info {
opacity: 0;
z-index: -1;
transition: all 0.5s ease;
}

.and-trad .hot-spot:hover .globo-info {
opacity: 1 !important;
z-index: 1;
transition: all 0.5s ease;
}

.and-trad .info-materiales-trad {
position: absolute;
bottom: 3vw;
right: -9vw;
width: 22vw;

}

.polygon-top::before {
content: '';
position: absolute;
width: 2.5vw;
height: 1vw;
background: #0648d6;
top: -0.9vw;
clip-path: polygon(50% 0%, 0% 100%, 100% 100%);
left: calc(42.1% / 1);
}

.globo-info {
background: #0648d6;
color: white;
padding: 1vw 3vw;
border-radius: 0.5vw;
}

.info-flow-box-lefttrad {
position: absolute;
width: 10vw;
right: -9vw;
top: 3vw;
-webkit-transform: rotate(200deg);
transform: rotate(200deg);
}

.info-flow-box-righttrad {
position: absolute;
width: 8vw;
left: -6vw;
top: 1vw;
-webkit-transform: rotate(213deg);
transform: rotate(213deg);
}

.info-flow-line {
height: 0;
border-top: 2px dashed #0648d6;
display: block;
}

.globo-info p {
margin: 0 0 0.1vw;
}

.info-materiales-trad {
position: absolute;
bottom: 1vw;
right: -25vw;
width: 25vw;
}

.info-medidas-trad {
position: absolute;
bottom: 1vw;
left: -24vw;
width: 25vw;
}

.info-flow-box-leftmedidas {
position: absolute;
width: 12vw;
right: -10vw;
top: 5.7vw;
-webkit-transform: rotate(162deg);
transform: rotate(162deg);
}

.btn-leer-mas {
background: white;
}

.cont-btn-lm {
margin: 1vw 0;
text-align: right;
}

.scroll-down-a {
position: absolute;
bottom: 4vw;
left: 50%;
z-index: 2;
display: inline-block;
-webkit-transform: translate(0, -50%);
transform: translate(0, -50%);
color: #545556;
letter-spacing: .1em;
text-decoration: none;
transition: opacity .3s;
}

.scroll-down-a span {
position: absolute;
top: 0;
left: 50%;
width: 1.7vw;
height: 2.9vw;
margin-left: -0.5vw;
border: 2px solid #545556;
border-radius: 1vw;
box-sizing: border-box;
}

.scroll-down-a span::before {
position: absolute;
top: 0.5vw;
left: 50%;
content: '';
width: 0.3vw;
height: 0.3vw;
margin-left: -0.1vw;
background-color: #545556;
border-radius: 100%;
-webkit-animation: sdb10 2s infinite;
animation: sdb10 2s infinite;
box-sizing: border-box;
}

@-webkit-keyframes sdb10 {
0% {
-webkit-transform: translate(0, 0);
opacity: 0;
}

40% {
opacity: 1;
}

80% {
-webkit-transform: translate(0, 20px);
opacity: 0;
}

100% {
opacity: 0;
}
}

@keyframes sdb10 {
0% {
transform: translate(0, 0);
opacity: 0;
}

40% {
opacity: 1;
}

80% {
transform: translate(0, 20px);
opacity: 0;
}

100% {
opacity: 0;
}
}

.cont-text-baner {

color: white;
}

.ml5vw {
margin-left: 5vw;
}

.cont-text-baner h2 {
text-transform: uppercase;
font-size: 3vw;
}

.cont-cont {
margin-top: 1.2vw;
}

.btn-cont-mas {
color: #af524f;
background: white;
font-size: 1.2vw;
}

.info-descript-banq {
position: absolute;
top: 1vw;
right: -25vw;
width: 25vw;
}

.info-flow-box-leftbanq {
position: absolute;
width: 10vw;
left: -9vw;
top: 7vw;
-webkit-transform: rotate(200deg);
transform: rotate(150deg);
}

.info-flow-box-leftbanqmedidas {
position: absolute;
width: 8vw;
right: -7vw;
top: 6.2vw;
-webkit-transform: rotate(162deg);
transform: rotate(162deg);
}

.info-flow-box-rightbanqtrad {
position: absolute;
width: 11vw;
left: -9vw;
top: 4vw;
-webkit-transform: rotate(213deg);
transform: rotate(213deg);
}

#descript-banq {
top: 9.5vw;
right: 7.5vw;
}

#medidas-banq {
bottom: 9vw;
left: 7vw;
}

#materiales-banq {
bottom: 11.5vw;
right: 7.5vw;
}

div#medidas-longit {
bottom: 10vw;
left: 8.5vw;
}

.info-flow-box-leftmedidaslong {
position: absolute;
width: 11vw;
right: -9vw;
top: 5.7vw;
-webkit-transform: rotate(162deg);
transform: rotate(162deg);
}

div#materiales-longit {
bottom: 12.5vw;
right: 6.5vw;
}

.info-flow-box-rightlong {
position: absolute;
width: 10vw;
left: -8vw;
top: 2.7vw;
-webkit-transform: rotate(213deg);
transform: rotate(213deg);
}

.img-left {
position: absolute;
bottom: 0;
left: -3vw;
width: 22vw;
}

.img-right {
position: absolute;
bottom: 0;
right: -3vw;
width: 22vw;
transform: scaleX(-1);
}
.transform{
transform: scaleX(-1);
}
.imgcont img {
width: 100%;
}

.form-midle {
width: 100%;
display: flex;
align-items: center;
justify-content: center;
}
.swal-modal {
font-family: 'Montserrat';
}
.form-control {
padding: 0.8vw 0.5vw;
width: 25vw;
background: #ffffff14;
border: 0;
border-bottom: 2px white solid;
color: white;
font-family: 'Poppins';
}
.btn-send-msj {
border: 0;
cursor: pointer;
padding: 0.5vw 1.5vw;
font-size: 1vw;
border-radius: 0;
background: #ffbb01;
color: white;
}
.form-control:focus-visible {
border-radius: 0;
outline: none;
}
.text-danger {
color: red !important;
}
.help-block {
font-size: 0.6vw !important;
}

#descript-plaf {
top: 11vw;
right: 11.5vw;
}

#medidas-plaf {
bottom: 15vw;
left: 9.7vw;
}

#materiales-plaf {
bottom: 18vw;
right: 6vw;
}

.info-flow-box-leftplafmedidas {
position: absolute;
width: 13vw;
right: -11vw;
top: 1vw;
-webkit-transform: rotate(161deg);
transform: rotate(161deg);
}

.info-flow-box-rightplaftrad {
position: absolute;
width: 11vw;
left: -9vw;
top: -2vw;
-webkit-transform: rotate(224deg);
transform: rotate(224deg);
}

.info-flow-box-leftplaf-descrip {
position: absolute;
width: 14vw;
left: -13vw;
top: 7vw;
-webkit-transform: rotate(200deg);
transform: rotate(148deg);
}

.social-whats-footer {
position: fixed;
z-index: 8;
right: 30px;
bottom: 30px;
}

#whatsapp_widget {
border: 2px #fff solid;
border-radius: 50%;
background-color: #00bc5c;
padding: 7px;
color: rgba(31, 173, 83, 0.3);
box-shadow: 2px 2px 3px rgb(0 0 0 / 66%);
-webkit-animation: zcwmini2 1.5s 0s ease-out infinite;
-moz-animation: zcwmini2 1.5s 0s ease-out infinite;
animation: zcwmini2 1.5s 0s ease-out infinite;
display: flex;
align-items: center;
justify-content: center;
}

#icon_whatsapp_widget {
width: 50px;
height: 50px;
}

.banner-titulo {
margin-top: 6vw;
background: url("{{url('web/img/banner_top.webp')}}") #ffbb01;
padding: 1.5vw 0;
background-position: bottom left;
background-size: 100%;
background-repeat: no-repeat;
}

.banner-blog {
margin-top: 6vw;
padding: 4.5vw 0;
background-position: center;
background-size: 100%;
background-repeat: no-repeat;
}

.more-info-blog li {
display: inline-block;
margin-left: 1vw;
}

.banner-titulo .text-info span {
color: white;
}

.contenido {
width: 70vw;
margin: 0 auto;
position: relative;
}

.center-blog {
display: grid;
margin: 0 auto;
grid-gap: 2vw;
grid-template-columns: repeat(3, 1fr);
margin-top: 2vw;
margin-bottom: 2vw;
}

.c-bg-img {
width: 100%;
height: 20vw;
background-position: center center;
background-size: cover;
background-repeat: no-repeat;
}

.item_blog {
position: relative;
}

.blog-button {
position: absolute;
top: 0;
left: 0;
width: 100%;
height: 100%;
text-align: center;
display: flex;
align-items: center;
justify-content: center;
background: #0648d63b;
}

.cont-url a {
background: #ffbb01;
color: white;
padding: 0.5vw 1vw;
line-height: 3vw;
}

ul.breadcrumbs-meta {
display: flex;
align-items: center;
justify-content: center;
}

.breadcrumbs-meta li {
display: inline-block;
margin-left: 1vw;
margin-right: 1vw;
}

.seccion-informacion {
display: grid;
grid-template-columns: repeat(2, 1fr);
margin-top: 2vw;
margin-bottom: 2vw;
}

.cont-text-blog {
width: 50vw;
padding-right: 5vw;
}

.blogs-relacionados {
width: 20vw;
}

.bg-blue {
background: #0648d6;
}

.text-white {
color: white;
}
.text-justify {
text-align: justify;
}
.text-white h1, .text-white h3, .text-white p {
color: white;
}

.bg-rayas {
background: url("{{url('web/img/default_pattern.png')}}");
}

.img-portada-blog {
width: 100%;
margin-top: 1vw;
margin-bottom: 1vw;
}

.mt-10vw {
margin-top: 6vw;
padding-top: 2vw;
}
.mt-4vw {
    margin-top: 4vw;
}
.tit-blog {
font-size: 2vw;
line-height: 2.2vw;
text-transform: uppercase;
border-left: 0.5vw #0648d6 solid;
padding-left: 1vw;
}

.dividetit {
width: 100%;
background: url("{{url('web/img/default_pattern.png')}}");
margin: 1.5vw 0;
}
.alert-success {
background: #00bc5c;
color: white;
font-family: 'Poppins';
}
.alert {
padding: 1vw;
margin-bottom: 0.5vw;
}
button.close {
display: none;
}
.more-info-blog {
padding: 1vw 0;
}

.cont-img-blog {
text-align: center;
}

.cont-img img {
width: 100%;
}
.cont-img{
position: relative;
}
.cont-sombra::before {
content: '';
width: 100%;
height: 100%;
position: absolute;
background: #c6221e;
top: 1vw;
right: -1vw;
z-index: -1;
}
.item-seguridad {
display: flex;
align-items: center;
justify-content: center;
}
.txt-beneficios {
margin-left: 1vw;
}
.txt-beneficios p {
font-weight: bold;
}
.icono img {
width: 4vw;
}
.beneficios, .fondo-lineas{
background: url("{{url('web/img/default_pattern.png')}}");
}
.cont-float {
background: #c6221e;
padding: 2vw;
}
.disp-flex-float {
display: flex;
align-items: center;
justify-content: left;
left: -12vw;
position: relative;
width: 38vw;
}
.cont-float h3 {
letter-spacing: 0.4vw;
}
.cont-float h1 {
font-size: 1.8vw;
line-height: 2vw;
color: #ffbb01;
}
.cont-float p {
font-size: 1.2vw;
}
.btn-cotizar {
color: #c6221e;
text-transform: uppercase;
letter-spacing: 0.1vw;
font-weight: 600;
border-radius: 0;
padding: 0.5vw 2vw;
}
.btn-white {
background: white;
}
.cont-btn {
margin-top: 2vw;
}
.bg-gradient{
background-color: rgb(255, 255, 255);
background-image: radial-gradient(circle at 50% 50%,rgb(0 0 0 / 22%) 0,#ffffff6e 85%);
}
#andamios {
display: flex;
align-items: center;
justify-content: center;
}
#carrousel-andamios {
width: 60vw;
margin: 0 auto;
text-align: center;
margin-top: 2.5vw;
margin-bottom: 2.5vw;
}
.header-owl {
position: relative;
}
.text-yellow {
color: #ffbb01;
text-shadow: 1px 1px 1px #333;
}
.p-font-s{
font-size: 1.2vw;
}
.owl-nav {
position: absolute;
top: 35%;
bottom: 50%;
width: 100%;
}
.owl-nav > button {
font-size: 5vw !important;
position: absolute;
}
.owl-prev {
left: -5vw;
}
.owl-next {
right: -5vw;
}
.botonera-c {
padding: 1vw 0;
text-align: left;
margin-top: 2vw;
}
.bg-white{
background: white;
}

.btn-slide {
padding: 0.5vw 3vw;
margin-right: 1vw;
text-transform: uppercase;
font-weight: bold;
}
.btn-vermas {
border: 2px #0648d6 solid;
color: #0648d6;
cursor: pointer;
}
.btn-cotizar-s {
background: #0648d6;
color: white;
border: 2px #0648d6 solid;
cursor: pointer;
}
.form-control.black {
color: black;
}
.cont-percent {
position: relative;
width: 39vw;
height: 10vw;
margin-top: 2vw;
z-index: 0;
}
.caja {
position: absolute;
border: 1px solid #ffffff;
box-sizing: border-box;
border-radius: 8px;
width: 18.5vw;
height: 4.3vw;
transition: all 0.5s ease;
}
.caja-btn {
position: absolute;
width: 18.5vw;
height: 4vw;
display: grid;
justify-content: center;
align-items: center;
}
.p1 {
left: 0;
top: 0;
}
.p2 {
right: 0;
top: 0;
}
.p3 {
left: 0;
bottom: 0;
}
.p4 {
right: 0;
bottom: 0;
}
.porcent {
font-family: 'Pacifico', cursive;
font-weight: bold;
font-size: 3vw;
line-height: 1em;
text-transform: uppercase;
color: #ffffff;
width: 9vw;
position: absolute;
height: 4.3vw;
display: flex;
justify-content: center;
align-items: center;
padding-bottom: 0.5vw;
}
.info-financial h2 {
text-transform: uppercase;
line-height: 1;
color: white;
font-size: 2.5vw;
}
.info-caja {
width: 9vw;
position: absolute;
right: 0;
font-style: normal;
font-weight: bold;
font-size: 1vw;
line-height: 1em;
color: #ffffff;
height: 4.3vw;
display: grid;
align-items: center;
}
.caja:hover {
background: #0648d6;
}
.btn-open-modal-financial {
font-style: normal;
font-weight: bold;
line-height: 2em;
color: #FFFFFF;
border-radius: 8px;
padding: 0.5vw 1vw;
text-align: center;
font-size: 1.2vw;
}
.btn-open-modal-financial span {
z-index: 2;
position: relative;
color: #ffbb01;
}
.btn-open-modal-financial::before, .btn-open-modal-gb::before {
content: '';
position: absolute;
top: 0;
left: 0;
width: 0;
height: 100%;
background: #0648d6;
z-index: 1;
border-radius: 8px;
transition: all 0.5s ease;
}
.btn-open-modal-financial::after, .btn-open-modal-gb::after {
content: '';
position: absolute;
top: 0;
left: 0;
width: 100%;
height: 100%;
background: #FFFFFF;
z-index: 0;
border-radius: 8px;
}
.btn-open-modal-financial:hover, .btn-open-modal-gb:hover {
color: #ffbb01;
}
.btn-open-modal-financial:hover::before, .btn-open-modal-gb:hover::before {
width: 100%;
transition: all 0.5s ease;
}
.bg-yellow {
background: #ffbb01;
}
.cont-img-financial img {
width: 25vw;
position: absolute;
bottom: -5vw;
right: 0;
z-index: 1;
}
#baner-financial:after {
content: '';
position: absolute;
top: 0;
left: 0;
width: 100%;
height: 2.5vw;
background: url("{{url('web/img/default_pattern.png')}}"), #0648d6;
}
.owl-nav > button i {
color: #b1b1b1;
}
.item-cli img {
padding: 1.2vw;
}
.cont-form-cotiza {
position: fixed;
top: 0;
right: 0;
width: 50vw;
height: 100%;
padding: 5vw;
background: url("{{url('web/img/default_pattern.png')}}"), #ffbb01;
z-index: 99999;
-webkit-transition: all 0.5s ease;
-moz-transition: all 0.5s ease;
-ms-transition: all 0.5s ease;
-o-transition: all 0.5s ease;
transition: all 0.5s ease;
box-shadow: -0.1vw 0vw 2vw #333;
display: flex;
align-items: center;
justify-content: center;
}
.cont-form-ficha {
position: fixed;
top: 0;
right: 0;
width: 100%;
height: 100%;
padding: 5vw;
background: #1c1c1c40;
z-index: 9999999;
-webkit-transition: all 0.5s ease;
-moz-transition: all 0.5s ease;
-ms-transition: all 0.5s ease;
-o-transition: all 0.5s ease;
transition: all 0.5s ease;
display: flex;
align-items: center;
justify-content: center;
}
.body-form {
background: white;
padding: 4vw;
position: relative;
}
.btn-send-coti{
border: 0;
cursor: pointer;
padding: 0.5vw 1.5vw;
font-size: 1vw;
border-radius: 0;
background: #0648d6;
color: white;
}
.cont-form-cotiza h1 {
line-height: 1;
margin-bottom: 1vw;
text-transform: uppercase;
color: white;
}
.cerrar {
position: absolute;
top: 4vw;
right: 4vw;
background: white;
padding: 0.5vw 1vw;
border-radius: 0.5vw;
color: #ffbb01;
font-weight: bold;
}
.cerrado {
right: -52vw;
-webkit-transition: all 0.5s ease;
-moz-transition: all 0.5s ease;
-ms-transition: all 0.5s ease;
-o-transition: all 0.5s ease;
transition: all 0.5s ease;
}
.cerrado2 {
top: -100vw;

}

.img-categ img {
width: 100%;
}
.bg-gray {
background: #e7e7e7;
}
.producto-center-header {
display: grid;
justify-content: center;
align-items: center;
background: url("{{url('web/img/polvo-bg.webp')}}");
background-size: 100%;
background-repeat: no-repeat;
}
.cont-img-ficha {
position: relative;
display: flex;
align-items: center;
justify-content: center;
margin-top: 2vw;
}

.cont-tit-intro {
position: absolute;
left: 5vw;
top: 7.5vw;
z-index: 2;
}
.cont-tit-intro h1 {
font-size: 5vw;
}
.cont-img-svg svg {
width: 40vw;
height: auto;
z-index: 2;
}
.cont-img-ficha img {
width: 50vw;
height: auto;
z-index: 2;
padding: 3vw;
}
.piso img {
width: 100%;
margin-top: -18vw;
}
/*RESPONSIVE*/
.cont-menu-movil {
position: absolute;
right: 2vw;
top: 3vw;
}
.piso {
position: relative;
}

.piso:after {
content: '';
position: absolute;
top: 0;
left: 0;
width: 100%;
height: 100%;
background: -moz-linear-gradient(top,  rgba(255,255,255,0) 0%, rgba(247,247,247,1) 50%); /* FF3.6-15 */
background: -webkit-linear-gradient(top,  rgba(255,255,255,0) 0%,rgba(247,247,247,1) 50%); /* Chrome10-25,Safari5.1-6 */
background: linear-gradient(to bottom,  rgba(255,255,255,0) 0%,rgba(247,247,247,1) 50%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#00ffffff', endColorstr='#f7f7f7',GradientType=0 ); /* IE6-9 */
}
.seccion-fichas{
padding: 2.5vw 0 0;
position: relative;
}
.ficha-d {
grid-column: col-start 2 / span 5;
}
.ficha-m{
grid-column: col-start 1 / span 5;
}
.ficha-mat{
grid-column: col-start 7 / span 5;
}

.tit-ficha h3 {
color: white !important;
}
.tit-ficha {
background: #232323;
padding: 0.5vw 2vw;
border-radius: 1vw 1vw 0 0;
}
.ficha-t {
background: white;
border-radius: 1vw;
box-shadow: 0px 30px 20px 0px rgb(0 37 93 / 15%);
}
.txt-ficha {
padding: 0.5vw 2vw;
}
.ficha-left {
text-align: right;
}
.contenido-fichas{
width: 80vw;
margin: 0 auto;
position: relative;
}
.menu-mat{
grid-column: col-start 2 / span 10;
text-align: center;
}
.cont-img-svg{
grid-column: col-start 2 / span 10; 
display: flex;
align-items: center;
justify-content: center;  
position: relative;
}
.infopeso{
grid-column: col-start 2 / span 10;
text-align: center;
}
.pb2{
padding-bottom: 2vw;
}
.menu-mat ul {
margin: 1vw;
padding: 0;
}
.menu-mat ul li {
list-style: none;
display: inline-block;
}
.active-med {
background: #0648d6 !important;
color: white !important;
transition: all 0.5s ease;
}
.btn-med {
font-family: Archivo Narrow;
font-style: normal;
font-weight: bold;
color: #000000;
background: #E5E5E5;
border-radius: 8px;
padding: 0.5vw 0.5vw;
text-align: center;
transition: all 0.5s ease;
}
.groups {
opacity: 0;
transition: all 0.5s ease;
}
.grupo-activo {
opacity: 1;
transition: all 0.5s ease;
}
/*
.cont-img-svg::after {
position: absolute;
content: " ";
width: 300px;
height: 300px;
background: rgba(255, 187, 1, 0.1);
top: 50%;
left: 50%;
border-radius: 50%;
transform: translate(-50%, -50%);
z-index: 1;
animation: b-shadow 2s linear infinite;
}
@keyframes b-shadow {
0% {
box-shadow: 0px 0px 0px 20px rgba(255, 187, 1, 0.1), 0px 0px 0px 40px rgba(255, 187, 1, 0.1), 0px 0px 0px 60px rgba(255, 187, 1, 0.1), 0px 0px 0px 80px rgba(255, 187, 1, 0.1), 0px 0px 0px 100px rgba(255, 187, 1, 0.1);
}
50% {
box-shadow: 0px 0px 0px 50px rgba(255, 187, 1, 0.1), 0px 0px 0px 75px rgba(255, 187, 1, 0.1), 0px 0px 0px 100px rgba(255, 187, 1, 0.1), 0px 0px 0px 125px rgba(255, 187, 1, 0.1), 0px 0px 0px 150px rgba(255, 187, 1, 0.1);
}
100% {
box-shadow: 0px 0px 0px 20px rgba(255, 187, 1, 0.1), 0px 0px 0px 40px rgba(255, 187, 1, 0.1), 0px 0px 0px 60px rgba(255, 187, 1, 0.1), 0px 0px 0px 80px rgba(255, 187, 1, 0.1), 0px 0px 0px 100px rgba(255, 187, 1, 0.1);
}
}
*/
text, tspan {
font-size: calc(40px + 6 * ((100vw - 767px) / 680)) !important;
font-family: 'Poppins', sans-serif;
font-weight: bold;
}

.btn-med {
font-size: calc(15px + 6 * ((100vw - 767px) / 680)) !important;
}
@media (max-width: 767px) {
    .datos-filtro {
    display: block;
    }
    .landing-andamio{
        display: block !important;
        padding-top: 15vw !important;
    }
    .img-andamio, .info-andamio{
        margin: 0 auto;
    }
    .info-andamio{
        width: 90vw !important;
    }
    .cont-img-andamio img {
    height: auto !important;
    }
    .item-tit img {
    width: 80vw !important;
}
.submenu {
    width: 90vw;
    left: 0vw;
    display: block;
    z-index: 2;
}
.sub_submenu li a {
    width: 77vw !important;
}
.thumb-gallery-detail .owl-item img{
    height: auto !important;
}
.submenu li a {
width: 100%;
font-size: 4vw !important;
text-align: center;
line-height: 10vw;
}
.cont-movil {
width: 100%;
margin-top: 60px;
display: inline-block;
}
.contact_box {
    position: relative;
}
.menu-mat ul li{
margin: 1vw 0 1vw;
}
.cont-tit-intro h3, .cont-tit-intro h1 {
text-align: center;
font-size: calc(32px + 6 * ((100vw - 767px) / 680));
}
.cont-tit-intro {
position: relative !important;
margin-top: 10vw;
left: 0;
text-align: center !important;
}
.ficha-t {
margin-top: 10vw;
}
.infopeso a {
line-height: 15vw;
}
.cont-materiales {
margin-top: 10vw;
}
.cont-img-svg svg {
width: 100vw;
}
.producto-center-header {
background-size: cover;
background-position: center;
}

.categorias-inicio-movil {
height: 100vh;
background: #e7e7e7 url("{{url('web/img/default_pattern.png')}}");
display: flex;
align-items: center;
justify-content: center;
}
.categorias-inicio-movil .tit2 {
font-size: 10vw;
line-height: 10vw;
}
.gmovil6 .text-info {
text-align: center;
}
.btn-g {
font-size: 5vw;
padding: 1vw 3vw;
}
.btn-masinfo {
margin-bottom: 5vw;
}
.h-movil {
height: auto !important;
background: none;
}
.h-movil .img-cont-graph {
width: 80vw;
}
.h-movil .border-title-secc2 {
-webkit-text-stroke: 1px #161616;
color: transparent !important;
}
.h-movil .text-white, .h-movil .text-info h1{
color: #161616;
}
.gmovil6 {
grid-template-columns: repeat(1, 1fr);
}
.cont-menu-movil {
display: block;
}
.grid-flex {
display: inline;
}
.icono img {
width: 10vw;
}
.item-seguridad {
justify-content: left;
margin-top: 2vw;
margin-bottom: 2vw;
}
.item-seguridad br {
display: none;
}
.ul-nav {
width: 100vw;
background: #ffffffcc;
position: absolute;
top: 0;
left: 0;
height: 0;
display: flex;
align-items: flex-start;
justify-content: center;
overflow-x: auto;
-webkit-transition: all 0.3s ease;
-moz-transition: all 0.3s ease;
-ms-transition: all 0.3s ease;
-o-transition: all 0.3s ease;
transition: all 0.3s ease;
}
.open-menu{
height: 100vh;
-webkit-transition: all 0.3s ease;
-moz-transition: all 0.3s ease;
-ms-transition: all 0.3s ease;
-o-transition: all 0.3s ease;
transition: all 0.3s ease;
}
.sticky .logo img {
width: 30vw;
}
.menu {
align-items: normal;
justify-content: left;
width: 100vw
}
.menu ul li {
display: block !important;
text-align: left;
margin-left: 5vw;
line-height: 12vw;
}
.logo {
width: 70vw;
}
.logo img {
width: 30vw;
}
.d-none-movil {
display: none;
}
.menu-top a {
font-size: 5vw !important;
}
.cont-float h1, h1 {
font-size: calc(25px + 6 * ((100vw - 767px) / 680));
}
.cont-float h1 {
line-height: 6vw;
text-align: left;
}
.bienvenida h1 {
text-align: left;
}
h2 {
font-size: calc(22.5px + 6 * ((100vw - 767px) / 680));
}
h3 {
font-size: calc(20px + 6 * ((100vw - 767px) / 680));
}

.item-contact, .contacto p, .p-font-s, .cont-float p, p {
font-size: calc(20px + 6 * ((100vw - 767px) / 680));
}

.botonera-c {
text-align: center;
margin-top: 4vw;
margin-bottom: 10vw;
}
.owl-img-and {
width: 70vw !important;
margin: 0 auto;
}
.owl-nav > button {
font-size: 10vw !important;
}
.btn {
font-size: 4vw;
}
.cont-info-blog img {
width: 90%;
}

.cont-info-blog {
text-align: justify;
}

.seccion-informacion {
grid-template-columns: repeat(1, 1fr) !important;
}
.owl-nav{
z-index: -1;
}
.contenido {
width: 90vw;
}

.cont-text-blog {
padding-right: 0;
width: 90vw;
}

.img-portada-blog {
width: 85%;
}

.blogs-relacionados {
width: 90vw;
}

.tit-blog {
font-size: 5vw;
line-height: 5vw;
border-left: 1.5vw #0648d6 solid;
padding-left: 2vw;
}

.seccion-informacion {
margin-top: 10vw;
}

.dividetit {
margin: 4.5vw 0;
}
.cont-sombra {
text-align: center;
margin-top: 2em;
}
.cont-img img {
width: 80%;
}
.cont-sombra::before{
display: none;
}
.cont-absolute {
width: 100vw;
margin: 0 auto;
right: 0;
top: 0;
display: flex;
align-items: center;
justify-content: center;
}
.cont-float {
background: #000000d4;
padding: 3vw 5vw;
width: 90vw;
}
.cont-img-banner {
width: 100%;
}
.img-banner {
margin-left: 0;
}
#carrousel-andamios {
width: 80vw;
}
.border-title-secc {
font-size: 8vw;
}
.cont-img-financial img {
display: none;
}
.info-financial {
width: 90vw;
}
.info-financial h2 {
font-size: 4vw;
text-align: center;
margin-bottom: 3vw;
}
.cont-percent {
margin: 0 auto !important;
width: 85vw !important;
height: 25vw !important;
}
.caja {
width: 41vw !important;
height: 12vw !important;
}
.porcent {
font-size: 8vw !important;
height: 12vw !important;
width: 20vw !important;
padding-bottom: 2vw !important;
}
.info-caja {
font-size: 3vw !important;
width: 21vw !important;
height: 12vw !important;
}
.btn-open-modal-financial {
font-size: 3vw !important;
padding: 1.5vw 0 !important;
}
.caja-btn {
width: 41vw !important;
height: 12vw !important;
}
.item-cli img {
padding: 4.2vw;
}
.formulario {
margin-top: 5vw;
}
.form-control {
width: 90vw;
padding: 2vw 2vw;
margin-bottom: 1vw;
}
.btn-send-coti,
.btn-send-msj {
font-size: 4vw;
margin-bottom: 4vw;
}
.logo-coral {
width: 25vw;
}
.cont-form-cotiza {
width: 100vw;
}
.cerrado {
right: -102vw;
}
.cerrado2 {
top: -100%;
}

.help-block {
font-size: 3vw !important;
}
.cerrar{
padding: 1.5vw 4vw;
border-radius: 5vw;
}
.text-info h1 {
line-height: 6vw;
}
.tit2 {
font-size: 6vw;
}
.tit1 {
font-size: 5vw;
}
.tit3 {
font-size: 4vw;
}
.btn-xl{
font-size: 2.5vw;
}
.banner-titulo {
margin-top: 20vw;
}
.center-blog {
display: block;
}
.c-bg-img {
height: 80vw;
}
.item_blog {
margin-bottom: 10vw;
margin-top: 10vw;
}
h1.blog-title {
color: white;
font-size: calc(22px + 6 * ((100vw - 767px) / 680));
}
.cont-url a {
line-height: 15vw;
padding: 2vw 5vw;
}
.banner-titulo .grid12 {
display: block;
}
.banner-titulo .grid12 .col-item-b {
display: block;
margin-left: 5vw;
}
.product-andamio{
    display: block !important;
}
.product-andamio {
    height: initial !important;
    background: url({{url('web/img/cintilla-andamios-ama.png')}}) !important;
    background-repeat: no-repeat !important;
    background-position: bottom !important;
    background-size: 370% !important;
    margin-top: 5rem;
}
.cont-tit-intro-n{
    height: initial !important;
    display: block !important;
}
.btn-land-promo {
    animation: none !important;
}
.item-tit {
    margin: 0 auto;
}
.cont-img-andamio{
    height: auto !important;
    display: block !important;
}
.cont-img-andamio img {
    width: 100%;
}
.boton-item {
    margin-top: 10vw !important;
}
.btn-land-promo{
    font-size: 4vw !important;
}
}
@media (max-width: 500px){
.cont-absolute {
position: relative;
top: -7vw;
}
.cont-float {
background: #c6221e;
padding: 3vw 5vw;
width: 90vw;
}

.img-fila1 > img:nth-child(5) {
display: none;
}
.img-fila1, .img-fila2{
grid-template-columns: repeat(2, 1fr);
}
}
.product-andamio {
    height: 100vh;
    width: 100%;
    background: url("{{url('web/img/fondo-andamio-plegable.png')}}");
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center center;
    display: grid;
    grid-template-columns: 1fr 1fr;
}
.cont-img-andamio {
    width: 100%;
    height: 100vh;
    display: flex;
    align-items: center;
    text-align: center;
    position: relative;
    justify-content: center;
}
.cont-img-andamio img {
    height: 100%;
    object-fit: contain;
}
.cintilla {
    position: absolute;
    bottom: -20px;
    left: 0;
}

.cintilla img {
    width: 100%;
}
.cont-tit-intro-n {
    z-index: 2;
    height: 100vh;
    display: flex;
    align-items: center;
    justify-content: flex-end;
}
.cont-tit-intro-n img {
    width: 100%;
}
.tit-princ-and {
    font-size: 5vw;
    line-height: 1;
    color: white;
}
.item-tit {
    width: 85%;
}
@-webkit-keyframes btnpromo {
0% {
box-shadow: 0 0 8px 6px rgba(207, 8, 8, 0), 0 0 0 0 rgba(0, 0, 0, 0), 0 0 0 0 rgba(207, 8, 8, 0);
}

10% {
box-shadow: 0 0 8px 6px, 0 0 12px 10px rgba(0, 0, 0, 0), 0 0 12px 14px;
}

100% {
box-shadow: 0 0 8px 6px rgba(207, 8, 8, 0), 0 0 0 40px rgba(0, 0, 0, 0), 0 0 0 40px rgba(207, 8, 8, 0);
}
}
.boton-item {
    margin-top: 2vw;
    margin-bottom: 6vw;
    text-align: center;
    
}
.btn-land-promo {
    background: #ffbb01;
    color: #001929;
    font-size: 2vw;
    padding: 1vw 2vw;
    border-radius: 1.5vw;
    font-weight: bold;
    box-shadow: 2px 2px 3px rgb(0 0 0 / 66%);
    -webkit-animation: btnpromo 1.5s 0s ease-out infinite;
    -moz-animation: btnpromo 1.5s 0s ease-out infinite;
    animation: btnpromo 1.5s 0s ease-out infinite;
}
.h-100vh {
    height: 100vh;
}
/***LANDING***/

.landing-andamio {
    display: flex;
    align-items: center;
    justify-content: center;
}
.info-andamio {
    width: 50vw;
}
.img-andamio {
    width: 50vw;
}
.item-tit {
    width: 100%;
    text-align: center;
}
.item-tit img {
    width: 40vw;
}
.page-landung-andamio{
    background: #024add;
    background: -moz-linear-gradient(90deg,#024add 0,#01a3f4 50%,#024add 100%);
    background: -webkit-linear-gradient(90deg,#024add 0,#01a3f4 50%,#024add 100%);
    background: linear-gradient(90deg,#024add 0,#01a3f4 50%,#024add 100%);
    height: auto;
}
.menu-top-landing{
    position: absolute;
    left: 0;
    z-index: 5;
    top: 0;
    width: 100%;
    transition: 0.5s;
}
.menu-top-landing .logo{
    justify-content: left;
}

.cont-img-andamio::after {
  position: absolute;
  content: " ";
  width: 20vw;
height: 20vw;
  background: rgba(59, 38, 219, 0.1);
  top: 50%;
  left: 50%;
  border-radius: 50%;
  transform: translate(-50%, -50%);
  z-index: 1;
  animation: b-shadow 2s linear infinite;
}

.cont-img-andamio img {
  position: relative;
  top: auto;
  left: auto;
  max-width: 100%;
  width: auto;
  animation: none;
  z-index: 2;
}
.about .box .inner-box {
    width: 100%;
    position: relative;
    padding: 27px 25px 35px;
    transition: 0.3s ease-in;
}
.about .box {
    margin-bottom: 30px;
    background: #fff;
    box-shadow: 0px 30px 20px 0px rgba(0, 37, 93, 0.15);
    border-radius: 15px;
}
.about .box .inner-box .text {
    font-size: 16px;
}
.icon img {
    width: 50px;
}
.faq .panel {
    box-shadow: 0px 30px 20px 0px rgba(0, 37, 93, 0.15);
    margin-bottom: 30px;
}
.faq .accordion .panel-title {
    display: block;
    width: 100%;
    background: #fff;
    padding: 15px 40px 15px 20px;
    font-size: 18px;
    font-weight: 600;
    margin-bottom: 0px;
    color: #242424;
    position: relative;
    border-radius: 3px;
    cursor: pointer;
}
.collapse.show {
    display: block;
}
.faq .accordion .panel .panel-body {
    padding: 4px 20px 7px;
}
.faq-img img {
    width: 100%;
}
.faq .accordion .panel {
    margin-bottom: 20px;
    background: #fff;
    border-radius: 3px;
    box-shadow: 0px 8px 25px rgba(0, 0, 0, 0.1);
    position: relative;
}
.faq .accordion .panel::after {
    position: absolute;
    content: " ";
    top: 0;
    left: 0;
    height: 100%;
    width: 4px;
    background-image: linear-gradient(55deg, #0056b3 0%, #001929 100%);
}
.espacios6 {
    padding-top: 6vw;
    padding-bottom: 6vw;
}
</style>