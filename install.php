<title>星辰安装系统</title>
<body background="//xsot.tk/assets/img/background.png">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <meta charset="utf-8">
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/mdui/0.4.2/css/mdui.min.css">
  <script src="//cdnjs.cloudflare.com/ajax/libs/mdui/0.4.2/js/mdui.min.js"></script>
  <br />
  <center><h2>星辰网站安装系统</h2></center>
  <?php
  $lockfile = "install.lock";
  if (file_exists($lockfile)) {
    exit("<center><h3>您已经安装过了，如果需要重新安装请先删除根目录下的install.lock(如果你只需要做轻微修改请直接修改根目录下的config.php)</center></h3>");
  }
  if (!isset($_POST['submit'])) {
    ?>
    <form action="" method="post" enctype="multipart/form-data">
      <div class="mdui-textfield mdui-textfield-floating-label">
        <label class="mdui-textfield-label">数据库地址</label>
        <input name="db_host" type="text" class="mdui-textfield-input" value="localhost" />
      </div>
      <div class="mdui-textfield mdui-textfield-floating-label">
        <label class="mdui-textfield-label">数据库用户名</label>
        <input name="db_username" type="text" class="mdui-textfield-input" />
      </div>
      <div class="mdui-textfield mdui-textfield-floating-label">
        <label class="mdui-textfield-label">数据库名称</label>
        <input name="db_name" type="text" class="mdui-textfield-input" />
      </div>
      <div class="mdui-textfield mdui-textfield-floating-label">
        <label class="mdui-textfield-label">数据库密码</label>
        <input name="db_password" type="password" class="mdui-textfield-input" />
      </div>
      <br />
      <br />
      <br />
      <hr><hr>
      <br />
      <br />
      <div class="mdui-textfield mdui-textfield-floating-label">
        <label class="mdui-textfield-label">网站域名</label>
        <input name="url" type="text" class="mdui-textfield-input" value="http://<?php echo$_SERVER['HTTP_HOST'] ?>/" />
      </div>
      <div class="mdui-textfield mdui-textfield-floating-label">
        <label class="mdui-textfield-label">网站标题(网页中所显示的)</label>
        <input name="title1" type="text" class="mdui-textfield-input" value="星辰短域|密语" />
      </div>
      <div class="mdui-textfield mdui-textfield-floating-label">
        <label class="mdui-textfield-label">网站标题(网页标签所显示的)</label>
        <input name="title" type="text" class="mdui-textfield-input" value="星辰短域|密语" />
      </div>
      <div class="mdui-textfield mdui-textfield-floating-label">
        <label class="mdui-textfield-label">短网址后需要的字母或数字个数</label>
        <input name="pass" type="text" class="mdui-textfield-input" value="4" />
      </div>
      <div class="mdui-textfield mdui-textfield-floating-label">
        <label class="mdui-textfield-label">短网址包含的内容</label>
        <input name="strPol" type="text" class="mdui-textfield-input" value="XluhrIjPoNtmnbyGRFMSfwdCQWpJeBaDTVqKgYHvcALZsxUzEiOk" />
      </div>
      <div class="mdui-textfield mdui-textfield-floating-label">
        <label class="mdui-textfield-label">设置后台统计(access)是否打开on->开启/其余字符关闭</label>
        <input name="access" type="text" class="mdui-textfield-input" value="on" />
      </div>
      <div class="mdui-textfield mdui-textfield-floating-label">
        <label class="mdui-textfield-label">后台管理密码</label>
        <input name="passwd" type="text" class="mdui-textfield-input" value="admin" />
      </div>
      <br />
      <center>
        <input class="mdui-btn mdui-btn-raised mdui-ripple" type="submit" name="submit" value="安装" />
      </center·
      </form>
      <?php
    } else {
      if (!empty($_POST['db_host']) || !empty($_POST['db_username']) || !empty($_POST['db_name']) || !empty($_POST['db_password']) || !empty($_POST['url']) || !empty($_POST['title']) || !empty($_POST['title1']) || !empty($_POST['pass']) || !empty($_POST['strPol']) || !empty($_POST['access']) || !empty($_POST['passwd'])
      ) {
        $db_host = $_POST['db_host'];
        $db_username = $_POST['db_username'];
        $db_password = $_POST['db_password'];
        $db_name = $_POST['db_name'];
        $url = $_POST['url'];
        $title = $_POST['title'];
        $title1 = $_POST['title1'];
        $pass = $_POST['pass'];
        $strPol = $_POST['strPol'];
        $access = $_POST['access'];
        $passwd = $_POST['passwd'];
      } else {
        exit("<br/><center><h1>请检查您是否填写完全部内容后重试!</h1></center>");
      }
      @$conn = mysqli_connect($db_host,$db_username,$db_password,$db_name);
      if ($conn) {
        $accessx = "CREATE TABLE access (
      shorturl char(10) NOT NULL,
      domain mediumtext NOT NULL,
      type char(10)	NOT NULL,
      ip char(30) NOT NULL,
      time char(30) NOT NULL
      )";
        $banx = "CREATE TABLE ban (
      type varchar(10) NOT NULL,
      content	varchar(999) NOT NULL,
      time varchar(999) NOT NULL
      )";
        $informationx = "CREATE TABLE information(
      information	mediumtext NOT NULL,
      shorturl char(20)	NOT NULL,
      type char(20)	NOT NULL,
      time char(20)	NOT NULL,
      ip char(20)	NOT NULL
      )";
        mysqli_query($conn,$accessx);
        mysqli_query($conn,$banx);
        mysqli_query($conn,$informationx);
      } else {
        exit("<br/><center><h1>数据库连接失败!请确认数据库信息填写正确!</h1></center>");
      }
      $config_file = "config.php";
      $config_strings = "<?php\n";
      $config_strings .= "\$conn=mysqli_connect(\"".$db_host."\",\"".$db_username."\",\"".$db_password."\",\"".$db_name."\");\n//你的数据库信息\n\n";
      $config_strings .= "\$url=\"$url\";   \n//你的网站地址,不要忘记最后的'/'\n\n";
      $config_strings .= "\$title1=\"$title1\"; \n//网站标题(网页中所显示的)\n\n";
      $config_strings .= "\$title=\"$title - Powered by XCSOFT\";   \n//网站标题(网页标签所显示的）\n\n";
      $config_strings .= "\$pass=\"$pass\";  \n//短网址后需要的字母或数字个数,推荐4个以上,最长20!(请填写数字)\n\n";
      $config_strings .= "\$strPol=\"$strPol\";   \n//短网址包含的内容,即短网址后会出现的字符\n\n";
      $config_strings .= "\$access=\"$access\";   \n//设置后台统计(access)是否打开on->开启/其余字符关闭\n\n";
      $config_strings .= "\$passwd=\"$passwd\";  \n//设置后台管理密码 \n\n";
      $config_strings.= "?>";
      $fp = fopen($config_file,"wb");
      fwrite($fp,$config_strings);
      fclose($fp);
      $fp2 = fopen($lockfile,'w');
      fwrite($fp2,'安装锁文件,请勿删除!');
      fclose($fp2);
      echo "<h1>安装成功!</h1>";
      echo "接下来请手动修改网站伪静态配置(网站伪静态配置请查看README.md),3s后将为您自动跳转到首页!";
      file_get_contents("https://xsot.cn/api/detection/?type=shorturl&&domain=" . $_SERVER['HTTP_HOST']);
      header("Refresh:3;url=\"./index.php\"");
    }
    ?>
