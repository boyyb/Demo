﻿<?php
header("Content-type: text/html; charset=utf-8");
session_start();
if(!$_SESSION['username']){
    header('location:login.php');
    die;
}

$dsn = 'mysql:host=mysql.sql39.eznowdata.com;dbname=sq_boyyb88';
$pdo = new PDO($dsn,'sq_boyyb88','yb19870210');
$pdo -> exec("set names utf8");

$sql = "select * from sq_boyyb88.message order by time desc";//查询审核通过的留言
$pdos = $pdo -> prepare($sql);
$pdos -> execute();
$data = $pdos -> fetchAll(PDO::FETCH_ASSOC);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>留言管理</title>
    <style>
        #check{
            color:darkblue;
            text-decoration: none;
        }
        #check:hover{
            text-decoration: underline;
            color:darkred;
            font-weight:bold;
        }
    </style>
</head>
<body>
<div style="text-align:center;color:green;"><h2>留言后台管理</h2></div>
<span>当前管理员:[<?php echo $_SESSION['username'];?>]</span>
<span style="margin-left:86%"><a href="logout.php?logout=1">注销</a></span>
<hr/>
<a href="../index.php">返回留言板</a>&nbsp;&nbsp;<span>（通过点击修改可以查看留言详情。）</span>
<table border="1" style="border:1px solid green;border-collapse: collapse;font-size:14px">
    <tr>
        <th width="40">序号</th>
        <th width="80">留言者IP</th>
        <th width="80">联系方式</th>
        <th width="220">留言内容</th>
        <th width="80">留言时间</th>
        <th width="60">审核</th>
        <th>操作</th>
    </tr>
    <?php foreach($data as $k=>$v){?>
        <tr>
            <td><?php echo $k+1;?></td>
            <td><?php echo $v['ip'];?></td>
            <td><?php echo $v['contact'];?></td>
            <td><?php echo mb_substr($v['message'],0,20,'utf-8'),'...';?></td>
            <td><?php echo date('Y-m-d H:i:s',$v['time']);?></td>
            <td>
                <?php if($v['checked']==0){?>
                <a id="check" href="action.php?action=check&id=<?php echo $v['id'];?>">审核</a>
                <?php }else{?><span style="color:green">已审核</span><?php }?>
            </td>
            <td>
                <a href="update.php?action=update&id=<?php echo $v['id'];?>">修改</a>
                <a href="action.php?action=delete&id=<?php echo $v['id'];?>">删除</a>
            </td>
        </tr>
    <?php }?>
</table>

</body>
</html>
