<?php
//kết nối vào CSDL 
if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
   header('Location:list.php') ; 
}
$id=$_GET['id'];
$conn = mysqli_connect('localhost', 'root', '', 'phpbkap');
if (!$conn) {
    echo 'kết nối CSDL đến csdl thất bại';
    echo mysqli_connect_error();
}
$lopHocRS = mysqli_query($conn, "SELECT * FROM lop_hoc");
if (isset($_FILES['avatar']) && $_FILES['avatar']['name']) {
    //xoas anrh trong thu muc uploads

    if(file_exists($_POST['old_avatar'])){
        unlink($_POST['old_avatar']);
    }
    //tiến hành up ảnh 
    $duongDanAnh = 'uploads/' . time() . $_FILES['avatar']['name'];
    move_uploaded_file($_FILES['avatar']['tmp_name'], $duongDanAnh);
    $name = $_POST['name'];
    $lop_hoc_id = $_POST['lop_hoc_id'];
    $birthday = $_POST['birthday'];
    //12/01/1992
    $birthday = explode("/",$birthday);//[12,01,1992]
    $birthday = $birthday[2]."-".$birthday[1]."-".$birthday[0];//1992-01-12
    $about = $_POST['about'];
    $gender = $_POST['gender'];
    mysqli_query($conn,"UPDATE sinh_vien SET name='$name',lop_hoc_id=$lop_hoc_id,about='$about',gender=$gender,birthday='$birthday',avatar='$duongDanAnh' WHERE id=$id");
    echo mysqli_error($conn);
}

$rs = mysqli_query($conn,"SELECT * FROM sinh_vien WHERE id=$id");
$obj = mysqli_fetch_assoc($rs);
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
    <form method="POST" enctype="multipart/form-data">
        <table>
            <tbody>
                <tr>
                    <td>
                        <label>Tên SV </label>
                        <input type="text" name="name" placeholder="Nhập tên SV" value="<?php echo $obj['name'] ?>" />
                    </td>
                    <td>
                        <label>Chọn lớp học </label>
                        <select name="lop_hoc_id">
                            <?php while ($lopHoc = mysqli_fetch_assoc($lopHocRS)) : ?>
                                <option <?php if($obj['lop_hoc_id']==$lopHoc['id']){echo 'selected="selected"';} ?> value="<?php echo $lopHoc['id']; ?>"><?php echo $lopHoc['name']; ?></option>        
                            <?php endwhile ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Ngày sinh </label>
                        <input type="text" name="birthday" placeholder="Nhập ngày sinh" value="<?php echo $obj['birthday'] ?>"/>
                    </td>
                    <td>
                        <label>Giới tính</label>
                        <input type="radio" name="gender" value="1" <?php if($obj['gender']==1){echo 'checked="checked"';} ?>/>Nam
                        <input type="radio" name="gender" value="0" <?php if($obj['gender']==0){echo 'checked="checked"';} ?>/>Nữ
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <img src="<?php echo $obj['avatar']; ?>"/>
                        <input type="hidden" value="<?php echo $obj['avatar']; ?>" name="old_avatar"/>
                        <input type="file" name="avatar" />
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <label>Giới thiệu về bản thân</label>
                        <textarea name="about"><?php echo $obj['about']; ?></textarea>
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <button>Edit</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </form>

</body>

</html>