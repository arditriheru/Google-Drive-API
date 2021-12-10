<?php
    require_once 'conn.php';

    // get data from db
    $query = "SELECT * FROM tb_files";
    $rs = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload File</title>
    <style>
        table, tr, td {
            border: 1px solid black;
            border-collapse: collapse;
        }
        tr, td {
            padding: 5px 15px;
        }
    </style>
</head>
<body>
    <fieldset>
        <legend>List File</legend>
        <table cellpa>
            <tr>
                <td>No.</td>
                <td style="min-width:200px">File</td>
                <td colspan="2" align="center">Aksi</td>
            </tr>
            <?php
                if ($rs) {
                    $no = 1;
                    foreach ($rs as $row) {
                        ?>
                        <tr>
                            <td><?= $no ?></td>
                            <td><?= $row['file_name'] ?></td>
                            <td><a href="http://drive.google.com/open?id=<?= $row['drive_id'] ?>">Lihat</a></td>
                            <td><a href="delete.php?id=<?= $row['id'] ?>">Hapus</a></td>
                        </tr>
                        <?php
                        $no++;
                    }
                }
            ?>
        </table>
    </fieldset>

    <form action="upload.php" method="post" enctype="multipart/form-data">
        <fieldset>
            <legend>Form</legend>
            <input type="file" name="file" id="file" accept="application/pdf" required>
            <input type="submit" value="Upload">
        </fieldset>
    </form>
</body>
</html>