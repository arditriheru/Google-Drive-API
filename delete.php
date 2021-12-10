<?php
    require_once 'conn.php';
    require_once 'auth.php';

    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        $query = "SELECT * FROM tb_files WHERE id = $id";
        $rs = $conn->query($query);
        
        if ($rs == true) {
            $data = mysqli_fetch_array($rs);
            $drive_id = $data['drive_id'];
            echo $drive_id;

            // delete from google drive
            $client = auth();
            $client->addScope(Google\Service\Drive::DRIVE);

            $service = new Google\Service\Drive($client);

            $del = $service->files->delete($drive_id);

            if ($del) {
                // delete from db
                $query = "DELETE FROM tb_files WHERE id = $id";
                $rs = $conn->query($query);

                if ($rs == true) {
                    header('Location: index.php');
                } else {
                    echo 'Delete Failed: Database';
                }
            } else {
                echo 'Delete Failed: Drive';
            }
        } else {
            echo 'File Not Found';
        }
    }
?>