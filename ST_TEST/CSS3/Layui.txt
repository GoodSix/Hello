~ LayUI ~

# 布局篇

## 公共样式

    layui-main
        + (类名)
        + 设置一个宽度为1140px的水平居中块(无响应式)

    layui-inline
        + (类名)
        + 将标签设为内联块状元素

    layui-box
        + (类名)
        + 排除一些UI框架(如bootstrap)强制将全局元素设置为box-sizing: border-box所引发的尺寸偏差

    layui-clear
        + (类名)
        + 消除浮动(在layui中一般不怎么常用，因为layui几乎没用到浮动)

    layui-logo
        + (类名)
        + 专门放logo的

### 辅助

    layui-elip
        + (类名)
        + 用于单行文本你溢出省略

    layui-unselect
        + (类名)
        + 屏蔽选中

    layui-disabled
        + (类名)
        + 设置元素不可点击状态

    layui-circle
        + (类名)
        + 让元素变为圆形

    layui-show
        + (类名)
        + 显示块状元素

    layui-hide
        + (类名)
        + 隐藏元素

### 文本

    layui-text
        + (类名)
        + 定义一段文本区域(如文章), 该区域内的特殊标签(如a、li、em等)将会进行相应处理

    layui-word-aux
        + (类名)
        + 灰色标注行文字，左右会有间隔

## 栅格系统

    layui-container
        + (类名)
        + 建议div
        + 用来展示主体内容部分
        + 表示这是一个栅格容器，子元素为“栅格项”
        + 栅格项是共12格，可以使用偏移，间隙，嵌套来快速完成布局
        @ layui-row, layui-fulid

    layui-row
        + (类名)
        + 建议div
        + 在栅格容器中表示一行
        + 里面放的是栅格项

    layui-col-xs*
        + (类名)
        + 建议div
        + 栅格容器中，
        + 对于设备屏幕 <768px 的栅格项
        + 取值范围有1-12

    layui-col-sm*
        + (类名)
        + 建议div
        + 栅格容器中，
        + 对于设备屏幕 >=768px 的栅格项
        + 取值范围有1-12

    layui-col-md*
        + (类名)
        + 建议div
        + 栅格容器中，
        + 对于设备屏幕 >=992px 的栅格项
        + 取值范围有1-12

    layui-col-lg*
        + (类名)
        + 建议div
        + 栅格容器中，
        + 对于设备屏幕 >=1200px 的栅格项
        + 取值范围有1-12

    layui-fluid
        + (类名)
        + 建议div
        + 流体容器
        + 独占一行，空白间隙比较少
        + 可以用来放头部导航栏部分的内容

    layui-col-space*
        + (类名)
        + 将栅格行中的栅格项隔开
        + 可选值有1-30

    layui-col-*-offset*
        + (类名)
        + 建议div
        + 在某些设备下栅格的偏移
        + xs表示屏幕较小的设备，如手机
        + sm表示屏幕较大的设备，如平板
        + md表示普通大小的屏幕，如1920*1080的电脑屏幕
        + lg表示屏幕较大的设备
        + 偏移量取值范围在1-12

### 响应式公共类

    layui-show-*-block
        + (类名)
        + 定义在不同的设备下样式为:
        + display: block;
        + 可选值有xs,sm,md,lg

    layui-show-*-inline
        + (类名)
        + 定义在不同的设备下样式为:
        + display: inline;
        + 可选值有xs,sm,md,lg

    layui-show-*-inline-block
        + (类名)
        + 定义在不同的设备下样式为:
        + display: inline-block;
        + 可选值有xs,sm,md,lg

    layui-hide-*
        + (类名)
        + 定义在不同的设备下，样式为:
        + display: none;
        + 可选值有xs,sm,md,lg

## 背景颜色

    layui-bg-gray
        + (类名)
        + 灰色背景#eee
        + 字体颜色为#666
        + 这种颜色在layui中通常用于导航

    layui-bg-orange
        + (类名)
        + 橙色背景#FFB800
        + 字体颜色为#FFF
        + 暖色系的颜色，一般用来提示

    layui-bg-red
        + (类名)
        + 红色背景(赤色)#FF5722
        + 字体颜色为#FFF
        + 这个颜色比较引人注意的颜色，一般用于警告

    layui-bg-blue
        + (类名)
        + 蓝色背景#1E9FFF
        + 字体颜色为#FFF
        + 这个颜色看着比较舒服，一般用于提示

    layui-bg-cyan
        + (类名)
        + 藏青色背景#2F4056
        + 字体颜色为#FFF
        + 该颜色通常用于侧边栏或底部

    layui-bg-black
        + (类名)
        + 黑色背景#393D49
        + 字体颜色为#FFF

    layui-bg-green
        + (类名)
        + 墨绿色背景#009688
        + 字体颜色为#FFF

## 按钮

    layui-btn
        + (类名)
        + 声明按钮
        + 普通大小，默认样式

    layui-btn-xs
        + (类名)
        + 设置迷你大小按钮

    layui-btn-sm
        + (类名)
        + 设置小型按钮

    layui-btn-lg
        + (类名)
        + 设置大型按钮

    layui-btn-radius
        + (类名)
        + 设置圆角按钮

    layui-btn-primary
        + (类名)
        + 原始按钮
        + 背景是白色的

    layui-btn-normal
        + (类名)
        + 百搭按钮
        + 背景是蓝色的，可以用来表示一般的操作
    
    layui-btn-warm
        + (类名)
        + 提示按钮
        + 背景是橙色的，可以用来提示重要操作

    layui-btn-danger
        + (类名)
        + 警告按钮
        + 背景是赤色的，可以用来提示不可撤回操作

    layui-btn-disabled
        + (类名)
        + 禁用的按钮
        + 有了这个类名按钮是不可点击的状态

    layui-btn-fluid
        + (类名)
        + 流体按钮
        + 最大化适应宽度。在移动端使用较好

    layui-btn-group
        + (类名)
        + 声明按钮组
        + 在按钮组中的按钮自动归组，搭配图标按钮可以快速表达操作

    layui-btn-container
        + (类名)
        + 声明按钮容器
        + 尽管按钮已经有了边距，但是在按钮较多的情况下外层套一个按钮容器会更美观

## 图标

    layui-icon
        + (类名)
        + 建议i标签
        + 声明动画
        + 可以使用css的字体属性控制图标样式，如color: pink;可以让图标变为粉色
        + 详细的图标类名去官网查看

## 动画

    layui-anim
        + (类名)
        + 声明动画
        + 注意不能叠加

    layui-anim-up
        + (类名)
        + 向上滑入的动画效果

    layui-anim-upbit
        + (类名)
        + 向上微微滑入的动画效果

    layui-anim-scale
        + (类名)
        + 平滑放大的动画效果

    layui-anim-scaleSpring
        + (类名)
        + 弹簧式放大的动画效果

    layui-anim-fadein
        + (类名)
        + 渐渐显示的动画效果

    layui-anim-fadeout
        + (类名)
        + 渐渐隐藏的动画效果

    layui-anim-rotate
        + (类名)
        + 360度旋转的动画效果

    layui-anim-loop
        + (类名)
        + 让动画效果循环播放

## 表单

    layui-form
        + (类名)
        + 建议form或div
        + 声明表单
        + 需要配合表单组件样式才会起作用

    layui-form-pane
        + (类名)
        + 配合表单组件，变成方框风格

    layui-form-item
        + (类名)
        + 建议div
        + 声明表单项
        + 表示一行表单项

    layui-form-label
        + (类名)
        + 建议lebel
        + 在表单用于提示输入项作用的

    layui-input-block
        + (类名)
        + 建议div
        + 声明块状输入区
        + 子级标签放置的是输入方式, 比如输入框，单选框等(输入框需要layui-input类名)

    layui-input-inline
        + (类名)
        + 建议div
        + 声明行内输入区
        + 子级标签放置的是输入方式, 比如输入框，单选框等(输入框需要layui-input类名)

    layui-form-mid
        + (类名)
        + 建议div
        + 表单中的辅助文字，用来温馨提示的

    layui-input
        + (类名)
        + 建议input
        + 声明按钮样式

    layui-textarea
        + (类名)
        + 建议textarea
        + 声明文本域

### 扩展

    lay-ignore
        + (属性)
        + 对表单元素增加这个属性后，将不会对该标签进行梅花渲染，即保留系统风格

    lay-skin
        + (属性)
        + 更换表单组件样式
        + 如checkbox可以使用lay-skin="primary"变成小型按钮
        + radio组件可以使用lay-skin="switch"变为开关组件，使用lay-text="开|关"来表示提示文本

## 导航

    layui-nav
        + (类名)
        + 建议ul
        + 声明导航
        + 需要加载依赖模块: element

    layui-nav-img
        + (类名)
        + 建议img
        + 用来放置导航中的头像

    layui-nav-item
        + (类名)
        + 建议li
        + 声明导航项
        + 里面大多嵌套a标签，当然badge组件也很合适
        + 使用layui-this表示默认选中的