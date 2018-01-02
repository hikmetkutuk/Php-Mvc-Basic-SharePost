<?php
/**
 * Created by PhpStorm.
 * User: hikmetis
 * Date: 12/30/17
 * Time: 5:50 AM
 */

 require APPROOT . '/view/inc/header.php'; ?>
    <div class="jumbotron jumbotron-flud text-center">
        <div class="container">
            <h1 class="display-3"><?php echo $data['title']; ?></h1>
            <p class="lead"><?php echo $data['description']; ?></p>
        </div>
    </div>
<?php require APPROOT . '/view/inc/footer.php'; ?>
