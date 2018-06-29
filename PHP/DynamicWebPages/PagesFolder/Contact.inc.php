<h1 id="request">Movie Premier Booking Form</h1>
<p class="req">Interested in Movie Premier at NY Cinema? Please complete and submit the following form to the Booking Office. One of our representatives will send you an information package tailored to the field(s) of Premier that interest you. Please indicate whether you would like additional information or not</p>


<style type="text/css">
    input[type="text"],input[type="email"],textarea{
        border:  1px solid dashed;
        background-color: rgb(221,216,212);
        width: 480px;
        padding: .5em;
        font-size: 1.0em;
    }
    .Error{
        color: red;
        font-size: 1.2em;
        font-family: Bitter,Georgia,Times,"Times New Roman",serif;}
    input[type="submit"]{
        color: white;
        float: right;
        font-size: 1.3em;
        font-family: Bitter,Georgia,Times,"Times New Roman",serif;
        width: 170px;
        height: 40px;
        background-color:  #5D0580;
        border: 5px solid ;
        border-bottom-left-radius: 35px;
        border-bottom-right-radius: 35px;
        border-top-left-radius: 35px;
        border-top-right-radius: 35px;
        border-color: rgb(221,216,212);
        font-weight: bold;
    }
    .FieldInfo{
        color: rgb(251, 174, 44);
        font-family: Bitter,Georgia,"Times New Roman",Times,serif;
        font-size: 1.3em;


    }
    .MF{
        color: black;
        font-size: 1.2em;
        font-family: Bitter,Georgia,Times,"Times New Roman",serif;}

</style>

<?php
$NameError = "";
$EmailError = "";
$GenderError = "";
$WebsiteError = "";

if (isset($_POST['submit'])) {
    //check name is inserted
    if (empty($_POST['name'])) {
        $NameError = " وارد کردن نام الزامیست ";
    } else {
        $name = testUserInput($_POST['name']);
        //checking input is correct inserted or not
        if (!preg_match('/^([\p{Arabic}]|\s)*$/u', $name)){
            $NameError = "فقط مجاز به استفاده از حروف و فاصله هستید";
        }
    }
    //check email is inserted
    if (empty($_POST['email'])) {
        $EmailError = " وارد کردن ایمیل الزامیست ";
    } else {
        $email = testUserInput($_POST['email']);
    }
    //check Gender is checked
    if (empty($_POST['gender'])) {
        $GenderError = " انتخاب جنسیت الزامیست ";
    } else {
        $gender = testUserInput($_POST['gender']);
    }
    //check website is inserted
    if (empty($_POST['website'])) {
        $WebsiteError = " وارد کردن وبسایت الزامیست ";
    } else {
        $website = testUserInput($_POST['website']);
        //checking input is correct inserted or not
        if (!preg_match('%^((https?://)|(www\.))([a-z0-9-].?)+(:[0-9]+)?(/.*)?$%i', $website)) {
            $WebsiteError = "فرمت وبسایت غیرمجاز است";
        }
    }
}

if (!empty($_POST['name'])
    && !empty($_POST['email'])
    && !empty($_POST['gender'])
    && !empty($_POST['website'])) {
    if ((preg_match('%^((https?://)|(www\.))([a-z0-9-].?)+(:[0-9]+)?(/.*)?$%i', $website)==true)&&
        preg_match('/^([\p{Arabic}]|\s)*$/u', $name)==true) {
        echo "<h2>اطلاعات فرم شما</h2><br>";
        echo "نام: {$_POST['name']}<br>";
        echo "ایمیل: {$_POST['email']}<br>";
        echo "جنسیت: {$_POST['gender']}<br>";
        echo "وبسایت: {$_POST['website']}<br>";
        echo "نظرشما: {$_POST['comment']}<br>";

        //sendmail function
        $emailTo = 'babakus7@gmail.com';
        $subject = 'فرم ارتباطی';
        $message = 'نام کاربر: '.$_POST['name'].
            ' با ایمیل: '.$_POST['email'].
            ' جنسیت: '.$_POST['gender'].
            ' با وبسایت: '.$_POST['website'].
            ' پیام گذاشته:: '.$_POST['comment'];
        $sender = 'From: babakus7@gmail.com';
        if (mail($emailTo, $subject, $message, $sender)) {
            echo "پیام با موفقیت ارسال شد";
        } else {
            echo "ارسال پیام با خطا مواجه گردید";
        }
    } //if preg_match scope
    else{
        echo "<span class = 'text-danger mt-4 ml-4 font-weight-bold'>لطفا فرم را با دقت تکمیل نمایید</span>";
    } //else scope
} //if !empty scope
function testUserInput($data)
{
    return $data;
}

?>

<form  action="" method="post">
    <legend>* Please Fill Out the following Fields.</legend>
    <fieldset>
 <span class="FieldInfo">
Name:</span><br>
        <input class="input" type="text" Name="name" value="">
        <span class="Error">*<?php echo $NameError;  ?></span><br>
        <span class="FieldInfo">
E-mail:</span><br>
        <input class="input" type="email" Name="email" value="">
        <span class="Error">*<?php echo $EmailError; ?></span><br>
        <span class="FieldInfo">
Gender:</span><br>
        <input class="radio" type="radio" Name="gender" value="Female"><span class="MF">Female</span>
        <input class="radio" type="radio" Name="gender" value="Male"><span class="MF">Male</span>
        <span class="Error">*<?php echo $GenderError; ?></span><br>
        <span class="FieldInfo">
Website:</span><br>
        <input class="input" type="text" Name="website" value="">
        <span class="Error">*<?php echo $WebsiteError; ?></span><br>
        <span class="FieldInfo">
Comment:</span><br>
        <textarea Name="comment" rows="5" cols="25"></textarea>
        <br>
        <br>
        <input type="Submit" Name="submit" value="Submit">
    </fieldset>
</form>
