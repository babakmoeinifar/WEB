<?php
$nameError = "";
$emailError = "";
$genderError = "";
$websiteError = "";

if (isset($_POST['submit'])) {
    //check name is inserted
    if (empty($_POST['name'])) {
        $nameError = " وارد کردن نام الزامیست ";
    } else {
        $name = testUserInput($_POST['name']);
        //checking input is correct inserted or not
        if (!preg_match('/^([\p{Arabic}]|\s)*$/u', $name)) {
            $nameError = "فقط مجاز به استفاده از حروف و فاصله هستید";
        }
    }
    //check email is inserted
    if (empty($_POST['email'])) {
        $emailError = " وارد کردن ایمیل الزامیست ";
    } else {
        $email = testUserInput($_POST['email']);
    }
    //check Gender is checked
    if (empty($_POST['gender'])) {
        $genderError = " انتخاب جنسیت الزامیست ";
    } else {
        $gender = testUserInput($_POST['gender']);
    }
    //check website is inserted
    if (empty($_POST['website'])) {
        $websiteError = " وارد کردن وبسایت الزامیست ";
    } else {
        $website = testUserInput($_POST['website']);
        //checking input is correct inserted or not
        if (!preg_match('%^((https?://)|(www\.))([a-z0-9-].?)+(:[0-9]+)?(/.*)?$%i', $website)) {
            $websiteError = "فرمت وبسایت غیرمجاز است";
        }
    }
}

if (!empty($_POST['name'])
    && !empty($_POST['email'])
    && !empty($_POST['gender'])
    && !empty($_POST['website'])) {
    if ((preg_match('%^((https?://)|(www\.))([a-z0-9-].?)+(:[0-9]+)?(/.*)?$%i', $website) == true) &&
        preg_match('/^([\p{Arabic}]|\s)*$/u', $name) == true) {
        echo "<h2>اطلاعات فرم شما</h2><br>";
        echo "نام: {$_POST['name']}<br>";
        echo "ایمیل: {$_POST['email']}<br>";
        echo "جنسیت: {$_POST['gender']}<br>";
        echo "وبسایت: {$_POST['website']}<br>";
        echo "نظرشما: {$_POST['comment']}<br>";

        //sendmail function
        $emailTo = 'babakus7@gmail.com';
        $subject = 'فرم ارتباطی';
        $message = 'نام کاربر: ' . $_POST['name'] .
            ' با ایمیل: ' . $_POST['email'] .
            ' جنسیت: ' . $_POST['gender'] .
            ' با وبسایت: ' . $_POST['website'] .
            ' پیام گذاشته:: ' . $_POST['comment'];
        $sender = 'From: babakus7@gmail.com';
        if (mail($emailTo, $subject, $message, $sender)) {
            echo "پیام با موفقیت ارسال شد";
        } else {
            echo "ارسال پیام با خطا مواجه گردید";
        }
    } //if preg_match scope
    else {
        echo "<span class = 'text-danger mt-4 ml-4 font-weight-bold'>لطفا فرم را با دقت تکمیل نمایید</span>";
    } //else scope
} //if !empty scope
function testUserInput($data)
{
    return $data;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Form Validation Project</title>
    <link rel="stylesheet" href="style/bootstrap.min.css">

    <style type="text/css">
        input[type="text"], input[type="email"], textarea {
            border: 1px solid #b3d7ff;
            background-color: rgb(242, 242, 241);
            width: 600px;
            padding: .5em;
            font-size: 1em;
        }
    </style>
</head>
<body>
<div class="container float-left mt-2">
    <h2>فرم اعتبارسنجی با پی اچ پی</h2>
    <form action="FormValidationProject.php" method="post">
        <legend>*لطفا فرم را تکمیل نمایید</legend>
        <fieldset>
            نام:<br>
            <input type="text" class="input" name="name" value=""><span
                    class="text-danger">*<?php echo $nameError; ?></span><br>
            ایمیل:<br>
            <input type="email" class="email" name="email" value=""><span
                    class="text-danger">*<?php echo $emailError; ?></span><br>
            جنسیت:<br>
            <label for="female">خانم</label>
            <input type="radio" id="female" class="radio" name="gender" value="خانم">
            <label for="male">آقا</label>
            <input type="radio" id="male" class="radio" name="gender" value="آقا">
            <span class="text-danger">*<?php echo $genderError ?></span><br>
            وبسایت:<br>
            <input type="text" class="input" name="website" value=""><span
                    class="text-danger">*<?php echo $websiteError; ?></span><br>
            نظرات:<br>
            <textarea name="comment" cols="25" rows="5"></textarea><br>
            <br>
            <input class="btn btn-dark" type="submit" name="submit" value="ارسال فرم">
        </fieldset>
    </form>

</div>
</body>
</html>