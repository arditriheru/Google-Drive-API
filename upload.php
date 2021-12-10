<?php

    require_once 'conn.php';
    require_once 'auth.php';

    if (isset($_FILES['file'])) {
        $file = $_FILES['file'];
        $file_name = $file['name'];
        $file_data = $file['tmp_name'];

        // make connection to google drive
        $client = auth();
        $client->addScope(Google\Service\Drive::DRIVE);

        // make service for drive
        $service = new Google\Service\Drive($client);

        // make an object to upload file
        $upload = new Google\Service\Drive\DriveFile();

        // set file name
        $upload->setName($file_name);
        
        // disable file copy
        $upload->setCopyRequiresWriterPermission(true);

        // upload
        $result = $service->files->create($upload, array(
            'data'          => file_get_contents($file_data),
            'mimeType'      => 'application/octet-stream',
            'uploadType'    => 'multipart'
        ));

        // set permission (public reader)
        $permission = new Google\Service\Drive\Permission();
        $permission->setType('anyone');
        $permission->setRole('reader');

        // apply permission to uploaded file
        $service->permissions->create($result->id, $permission);

        // insert into db
        if ($result->id != '') {
            $query = "INSERT INTO tb_files (drive_id, file_name) VALUES ('$result->id', '$file_name')";

            $rs = $conn->query($query);

            if ($rs == true) {
                header('location: index.php');
            } else {
                echo 'Insert Failed: Database';
            }
        } else {
            echo 'Upload Failed: Drive';
        }
    } else {
        echo 'error';
    }
?>