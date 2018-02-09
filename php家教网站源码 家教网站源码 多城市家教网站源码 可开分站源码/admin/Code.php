<?PHP
session_start();
session_register('captcha_word');
define('IN_ECS', true);
if ($_REQUEST['act'] == 'captcha')
{
    include('../inc/cls_captcha.php');
    
    $img = new captcha('Data/captcha/');
    @ob_end_clean(); //清除之前出现的多余输入
    $img->generate_image();

    exit;
}
?>