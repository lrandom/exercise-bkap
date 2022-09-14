<?php
//kết nối vào CSDL 
$conn = mysqli_connect('localhost', 'root', '', 'phpbkap');
if (!$conn) {
    echo 'kết nối CSDL đến csdl thất bại';
    echo mysqli_connect_error();
}
$rs = mysqli_query($conn, "SELECT *,sinh_vien.id as sinh_vien_id,sinh_vien.name as sinh_vien_name,lop_hoc.name as lop_hoc_name FROM sinh_vien INNER JOIN lop_hoc ON sinh_vien.lop_hoc_id=lop_hoc.id");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Lop hoc</th>
                <th>Avatar</th>
                <th>Birthday</th>
                <th>Gender</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>
            <?php while ($sinhvien = mysqli_fetch_assoc($rs)) : ?>
                <tr>
                    <td><?php echo $sinhvien['sinh_vien_id'] ?></td>
                    <td><?php echo $sinhvien['sinh_vien_name'] ?></td>
                    <td><?php echo $sinhvien['lop_hoc_name']?></td>
                    <td><img src="<?php echo $sinhvien['avatar']; ?>"/></td>
                    <td><?php echo $sinhvien['birthday'] ?></td>
                    <td><?php if ($sinhvien['gender'] == 1) {
                            echo 'Nam';
                        } else {
                            echo 'Nu';
                        } ?></td>
                    <td>
                        <a href="delete.php?id=<?php echo $sinhvien['sinh_vien_id']; ?>">Xoa</a>
                    </td>
                </tr>
            <?php endwhile ?>
        </tbody>
    </table>
</body>

</html>