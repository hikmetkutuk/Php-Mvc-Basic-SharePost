<?php
/**
 * Created by PhpStorm.
 * User: hikmetis
 * Date: 12/30/17
 * Time: 5:50 AM
 */

require APPROOT . '/view/inc/header.php'; ?>
    <h1><?php echo $data['title']; ?></h1>
    <p><?php echo $data['description']; ?></p>
    <p><?php echo APPVERSION; ?></p>
<?php require APPROOT . '/view/inc/footer.php'; ?>