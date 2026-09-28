<style>
    .bondades {
        padding: 10px 0;
    }

    .bondades .box {
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease-in-out;
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        padding: 20px;
        text-align: center;
        height: 100%;
    }

    .bondades .box .icon img {
        width: 70px;
        height: 70px;
        margin-bottom: 20px;
        transition: transform 0.3s ease-in-out;
    }

    .bondades .box h4 {
        font-size: 1.5rem;
        margin-bottom: 15px;
        font-weight: 600;
        color: #333;
    }

    .bondades .box p {
        color: #777;
        font-size: 1rem;
        line-height: 1.6;
    }


    .bondades .box:hover {
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
        transform: translateY(-10px);
    }


    .bondades .box:hover .icon img {
        transform: scale(1.1);
    }

    /* Responsivo para pantallas pequeñas */
    @media (max-width: 767px) {
        .bondades .box {
            margin-bottom: 30px;
        }
    }
</style>
