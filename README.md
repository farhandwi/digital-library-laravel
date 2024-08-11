# MANAJEMEN DIGITAL LIBRARY FOR BACKEND TEST AT DETIK COM

<h3> Konfigurasi Project </h3>
<ol>
    <li>Copy file <b>.env.example</b> rename menjadi <b>.env</b></li>
    <li>Buat nama database pada file <b>.env</b> <code> DB_DATABASE=digital_library </code></li>
    <li>Setelah membuat database, Buka terminal lalu masuk ke folder project digital library</li>
    <li>Lalu masukan <code> FILESYSTEM_DRIVER=public </code> ke <b> .env </b> </li>
    <li>Lalu ketikan <code> php artisan migrate --seed </code> enter, setelah berhasil ketikan <code>php artisan storage:link</code> enter</li>
    <li>Lalu buat key app nya dengan cara <code> php artisan key:generate </code> </li>
    <li>Setelah itu download semua package dengan cara <code> composer install </code> </li>

<h1>Data Login 🔐</h1>

</ul>
<table border="1px" cellspacing="0" cellpadding="5px">
    <tr>
        <th>Email</th>
        <th>Password</th>
        <th>Level</th>
    </tr>
    <tr>
        <td>admin@gmail.com</td>
        <td>password</td>
        <td>Admin</td>
    </tr>
    <tr>
        <td>user@gmail.com</td>
        <td>password</td>
        <td>User</td>
    </tr>
</table>
