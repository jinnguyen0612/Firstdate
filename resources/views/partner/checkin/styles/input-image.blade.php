<style>
    .bill-image {
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 15px 30% 15px 30%;
    }

    #picture__input {
        display: none;
    }

    .bill-image .picture {
        aspect-ratio: 2 / 3;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px dashed currentcolor;
        cursor: pointer;
        font-family: sans-serif;
        transition: color 300ms ease-in-out, background 300ms ease-in-out;
        outline: none;
        overflow: hidden;
    }

    .bill-image .picture:focus {
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
    }

    .picture__img {
        max-width: 100%;
    }

    @media (max-width: 500px) {
        .bill-image {
            margin: 15px 10% 15px 10%;
        }
    }
</style>
