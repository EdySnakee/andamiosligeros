
<style>
    .continer {
    /* padding: 30px 20px 10px 20px; */
    /* border-radius: 8px; */
    color: #fff;
    width: 45vw;
    margin: auto;
    
    /* box-shadow:  0 5px 50px rgba(0, 0, 0, 0.2);*/
        }
        .continer .project-name {
    color: #0648d6;
    font-size: 1.8rem;
}
.continer .counter {
    width: 70%;
    margin: 0 auto;
}
        .continer label {
        display: block;
        }
        .continer .project-title {
        font-size: 9pt;
        opacity: 0.5;
        }
        .continer .project-name {
        margin: 5px 0;
        }
        .continer .counter {
        padding: 0;
        background-color: #ffbb01;
        font-weight: 700;
        border-radius: 8px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.5);
        min-height: 80px;
        }
        .continer .counter div {
        display: inline-block;
        }
        .continer .counter .days,
        .continer .counter .hours,
        .continer .counter .minutes,
        .continer .counter .seconds {
        width: 25%;
        float: left;
        text-align: center;
        }
        .continer .counter .days .value,
        .continer .counter .hours .value,
        .continer .counter .minutes .value,
        .continer .counter .seconds .value {
        display: block;
        font-size: 36pt;
        width: 100%;
        display: block;
        }
        .continer .counter .days span,
        .continer .counter .hours span,
        .continer .counter .minutes span,
        .continer .counter .seconds span {
        font-size: 8pt;
        opacity: 0.8;
        width: 100%;
        display: block;
        }
        .continer .counter .hours::before,
        .continer .counter .minutes::before,
        .continer .counter .seconds::before {
        content: ":";
        float: left;
        font-size: 20pt;
        position: relative;
        margin-top: 10px;
        opacity: 0.7;
        -webkit-animation: pink 1s ease-in-out infinite;
                animation: pink 1s ease-in-out infinite;
        }

        .centerIt {
            position: absolute;
            top: 11.5rem;
            left: 50%;
            transform: translateX(0%) translateY(-50%);
            z-index: 1;
        }

        @-webkit-keyframes pink {
        0% {
            opacity: 1;
        }
        50% {
            opacity: 0.5;
        }
        100% {
            opacity: 1;
        }
        }

        @keyframes pink {
        0% {
            opacity: 1;
        }
        50% {
            opacity: 0.5;
        }
        100% {
            opacity: 1;
        }
        }
        .value {
    font-family: 'Montserrat', sans-serif;
}
@media (max-width: 767px) {
    .continer {
        position: relative;
        transform: initial;
        left: 0;
        /* margin-top: 10rem; */
        margin-top: 0;
        width: 100%;
    }
    .centerIt{
        top: 9.5rem !important;
    }
    .continer .project-name {
        font-size: 1.2rem !important;
    }
    .promo{
        height: auto;
    }
    .continer .counter .days, .continer .counter .hours, .continer .counter .minutes, .continer .counter .seconds {
        width: 24%;
    }
    .continer .counter {
    padding: 0;
    margin: 0px 0 0px 0;
    }
    .continer .counter .days .value, .continer .counter .hours .value, .continer .counter .minutes .value, .continer .counter .seconds .value{
        font-size: 27pt;
    }
    .continer .counter{
        min-height: 70px;
        margin: 0 auto;
    }
    
}
</style>
<div class="continer centerIt text-center">
    <div>
        <p class="project-name"><b>¡Aprovecha,  <br> {{$nombre_product}}!</b></p>
        {{--
        <ul class="equipos">
            <li>
                <div>
                    <img class="imso_btl__mh-logo" alt="" height="48px" id="spotl_isR_Y9niBsKlqtsPw5SR6AU_3" src="//ssl.gstatic.com/onebox/media/sports/logos/yJF9xqmUGenD8108FJbg9A_96x96.png" width="48px">
                    <p>
                        México
                    </p>
                </div>
            </li>
            <li><p>VS</p></li>
            <li>
                <div>
                    <img class="imso_btl__mh-logo" alt="" height="48px" id="spotl_isR_Y9niBsKlqtsPw5SR6AU_1" src="//ssl.gstatic.com/onebox/media/sports/logos/QoAJxO46fHid3_T-7nRZ0Q_96x96.png" width="48px">
                    <p>
                        Arabia Saudita
                    </p>
                </div>
            </li>
        </ul>    
        --}}
        
    </div>
    <div class="counter">
        <div class="days">
            <div class="value">00</div>
            <span>Días</span>
        </div>
        <div class="hours">
            <div class="value">00</div>
            <span>Horas</span>
        </div>
        <div class="minutes">
            <div class="value">00</div>
            <span>Minutos</span>
        </div>
        <div class="seconds">
            <div class="value">00</div>
            <span>Segundos</span>
        </div>
    </div>
</div>
<script>
    //var fecha_limit = "2022/11/22";
     (function init() {
        function getTimeRemaining(fecha_limit) {
            var t = Date.parse(fecha_limit) - Date.parse(new Date());
            var seconds = Math.floor((t / 1000) % 60);
            var minutes = Math.floor((t / 1000 / 60) % 60);
            var hours = Math.floor((t / (1000 * 60 * 60)) % 24);
            var days = Math.floor(t / (1000 * 60 * 60 * 24));
            return {
                'total': t,
                'days': days,
                'hours': hours,
                'minutes': minutes,
                'seconds': seconds
            };
        }

        function initializeClock(fecha_limit) {
            //console.log(fecha_limit+" 13:00:00")
            var timeinterval = setInterval(function() {
                var t = getTimeRemaining(fecha_limit);
                document.querySelector(".days > .value").innerText = t.days;
                document.querySelector(".hours > .value").innerText = t.hours;
                document.querySelector(".minutes > .value").innerText = t.minutes;
                document.querySelector(".seconds > .value").innerText = t.seconds;
                if (t.total <= 0) {
                    clearInterval(timeinterval);
                }
            }, 1000);
        }
        //initializeClock(((new Date()).getFullYear()) + "/01/01"+" 13:00:00")
        initializeClock("2023/02/01")
    })()
</script>