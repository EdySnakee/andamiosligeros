<style>
  @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800&display=swap");

body {
    font-family: "Poppins", sans-serif;
    font-weight: 300;
}

.modern-btn {
    background-color: #007bff;
    color: white;
    border-radius: 10px;
    padding: 15px 30px;
    border: none;
    font-size: 16px;
    font-weight: bold;
    transition: background-color 0.3s ease, transform 0.2s ease;
    box-shadow: 0 8px 10px rgba(0, 123, 255, 0.461);
}

.modern-btn:hover {
    background-color: #0056b3;
    box-shadow: 0 15px 20px rgba(0, 123, 255, 0.245);
    transform: translateY(-3px);
}

.modern-btn:active {
    transform: translateY(2px);
}


.card_caracteristicas {
    border: none;
    cursor: pointer;
    box-shadow: 0 0 40px rgba(51, 51, 51, .1);
    transition: background-color 0.3s ease;
}

.card_caracteristicas:hover {
    background-color: #f5f5f5;
    transform: scale(1.05);
}

.card_caracteristicas::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    height: 100%;
    width: 5px;
    background-color: #febf01;
    transform: scaleY(0);
    transition: transform 0.3s ease;
}

.card_caracteristicas:hover::before,
.card_caracteristicas.active::before {
    transform: scaleY(1);
}

.testimonial-list {
    list-style: none;
    padding: 0;
}

.testimonial-list li {
    margin-bottom: 20px;
}

.card-body {
    font-size: 16px;
    transition: color 0.3s ease;
}

.collapse.show .card-body {
    color: #000;
}

.collapse:not(.show) .card-body {
    color: #666;
}

@media (max-width: 768px) {
    .card_caracteristicas {
        padding: 15px;
    }

    .card-body {
        font-size: 14px;
    }

    .testimonial-list li {
        margin-bottom: 15px;
    }
}

@media (max-width: 576px) {
    .card_caracteristicas {
        padding: 10px;
    }

    .card-body {
        font-size: 12px;
    }
}




</style>