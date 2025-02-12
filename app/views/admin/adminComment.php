<?php include_once "includes/header.php" ?>
<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4 main-content">
    <h1>Đây là trang quản lý bình luận</h1>
    <p>Chào mừng đến trang quản trị!</p>
    <table class="table table-bordered">
        <thead>
            <tr class="bg-primary text-white">
                <th>#</th>
                <th>Người bình luận</th>
                <th>Bình luận</th>
                <th>Thời gian</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php
            function formatDate($date)
            {
                return date('d/m/Y', strtotime($date));
            }
            function daysSinceComment($commentDate)
            {
                $currentDate = new DateTime();
                $commentDate = new DateTime($commentDate);
                $interval = $currentDate->diff($commentDate);
                return $interval->days;
            }

            $comment = $comments;
            foreach ($comment as $key => $value) {
            ?>
                <tr>
                    <td><?= $key + 1 ?></td>
                    <td><?= $value['username'] ?></td>
                    <td><?= $value['text'] ?></td>
                    <td><?= formatDate($value['date']) . ' (' . daysSinceComment($value['date']) . ' ngày)' ?></td>
                    <td>
                        <a href="/admin/comment/delete?id=<?= $value['id'] ?>" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i> Xóa</a>
                    </td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</main>
<?php include_once "includes/footer.php" ?>