<?php
// here
session_start();
// here
include $_SERVER["DOCUMENT_ROOT"] . "/inc/header.php";

if (!$_SESSION['UID']) {
    echo "<script>alert('회원 전용 게시판입니다.');history.back();</script>";
    exit;
}

// here
if (isset($_GET["bid"])) { //bid가 있다는건 수정이라는 의미다.
    $bid = $_GET["bid"]; //get으로 넘겼으니 get으로 받는다.
// here

    $result = $mysqli->query("select * from board where bid=" . $bid) or die("query error => " . $mysqli->error);
    $rs = $result->fetch_object();

    if ($rs->userid != $_SESSION['UID']) {
        echo "<script>alert('본인 글이 아니면 수정할 수 없습니다.');history.back();</script>";
        exit;
    }

}

// here
if (isset($_GET["parent_id"])) { //parent_id가 있다는건 답글이라는 의미다.
    $parent_id = $_GET["parent_id"];
// here

    $result = $mysqli->query("select * from board where bid=" . $parent_id) or die("query error => " . $mysqli->error);
    $rs = $result->fetch_object();
    $rs->subject = "[RE]" . $rs->subject;
}

?>
<form method="post" action="write_ok.php">
    <!-- here -->
    <?php if (isset($bid)): ?>
    <!-- here -->
    <input type="hidden" name="bid" value="<?php echo $bid; ?>">
    <!-- here -->
    <?php endif;?>
    <!-- here -->
    <!-- here -->
    <?php if (isset($parent_id)): ?>
    <!-- here -->
    <input type="hidden" name="parent_id" value="<?php echo $parent_id; ?>">
    <!-- here -->
    <?php endif;?>
    <!-- here -->
    <div class="mb-3">
        <label for="exampleFormControlInput1" class="form-label">제목</label>
        <input type="text" name="subject" class="form-control" id="exampleFormControlInput1" placeholder="제목을 입력하세요."
            value="<?php
// here
if (isset($rs)) {
    echo $rs->subject;
}
// here
?>">
    </div>
    <div class="mb-3">
        <label for="exampleFormControlTextarea1" class="form-label">내용</label>
        <textarea class="form-control" id="exampleFormControlTextarea1" name="content" rows="3">
          <?php
// here
if (isset($rs)) {
    echo $rs->subject;
}
// here
?>
        </textarea>
    </div>
    <button type="submit" class="btn btn-primary">등록</button>
</form>
<?php
include $_SERVER["DOCUMENT_ROOT"] . "/inc/footer.php";
?>