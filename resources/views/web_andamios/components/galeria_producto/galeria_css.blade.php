<style>
.gallery__main {
    width: 100%;
    max-width: 600px;
    margin-bottom: 5px;
    height: 400px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.gallery__img {
    width: 100%;
    max-height: 100%;
    border-radius: 8px;
    object-fit: contain;
    transition: transform 0.3s ease, opacity 0.3s ease;
}

.gallery__thumbs {
    display: flex;
    justify-content: space-between;
    width: 100%;
    max-width: 600px;
    margin-top: 10px;
}

.gallery__thumb {
    cursor: pointer;
    box-shadow: none;
}

.gallery__thumb img {
    width: 70px;
    height: 70px;
    border-radius: 4px;
    transition: box-shadow 0.3s ease, transform 0.3s ease;
}

.gallery__thumb img:hover {
    box-shadow: 0 0 5px 2px #febf01;
    transform: scale(1.1);
}

.gallery__thumb img.selected {
    border: 2px solid #febf01; /* Resalta la miniatura seleccionada */
    transform: scale(1.1);
}

.gallery__thumb input[type="radio"] {
    display: none;
}
</style>


