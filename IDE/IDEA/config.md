### 卡顿
    内存不够！(〃＞皿＜)
根据系统版本修改idea.vmoptions/idea64.vmoptions  
-Xms=%s 设置虚拟机最小内存

### 乱码
    烦恼了好几天，修改了好多配置，才发现是deepin下字体缺失

0. 在设置里设置下中文字体  
1. sudo su  
  -- 输入密码：  
  aptitude search uming  
  -- 如果显示了下面的内容直接重启下即可
  i   fonts-arphic-uming               - "AR PL UMing" Chinese Unicode TrueType font  
  v   fonts-arphic-uming:i386  
  -- 如果还是不行就在执行一个
  aptitude install fonts-arphic-uming
