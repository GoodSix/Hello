[首页](../../../README.md)
[IDEA快捷键](./keymap.md)
---

### 卡顿
    
+ 根据系统版本修改**idea.vmoptions/idea64.vmoptions**中`-Xms=%s` 设置虚拟机最小内存情况可能会好一点n(*≧▽≦*)n


### Deepin乱码
    烦恼了好几天，修改了好多配置，才发现是deepin下字体缺失，解决方法如下
    
0. 在IDEA中设置里设置字体，选择一个中文字体
0. `sudo apt search uming`  
  查看是否安装过该补丁  
  `sudo apt install fonts-arphic-uming`  
  安装字体