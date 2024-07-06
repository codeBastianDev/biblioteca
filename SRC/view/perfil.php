<?php include('./layout/header.php') ?>
<div class="d-flex gap-5">
    <div class=" border rounded gap-4 w-25 d-flex align-items-center flex-column p-4">
        <img class="rounded-4" width="200" src="https://placehold.co/400" alt="">
        <div>
            <div class="text-center fs-3">Juan Martinez</div>
            <hr>
            <div class="text-center">juan@gmail.com</div>
            <hr>
            <div class="text-center">8087625312</div>
            <hr>
            <div class="text-center">Hainamosa</div>
        </div>
    </div>
    <div class="border rounded gap-4 w-75 d-flex align-items-center flex-column p-4">

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Libro</th>
                    <th scope="col">fecha de alquiler</th>
                    <th scope="col">fecha de devolución</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th scope="row">1</th>
                    <td>Pinocho</td>
                    <td>10-6-2024</td>
                    <td>10-7-2024</td>
                </tr>
                <tr>
                    <th scope="row">2</th>
                    <td>La vida despues de la muerte</td>
                    <td>6-5-2024</td>
                    <td>10-6-2024</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<?php include('./layout/foooter.php') ?>