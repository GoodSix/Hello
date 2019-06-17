~ LayUI ~

# 基础说明

    layui.define
        [modes] array> 本模块所依赖的其他模块，如果为数组可以引入多个。可以为字符串，但是这样只能引入一个模块
        callback callback> 它返回一个exports函数，用于输出该模块的接口
        + 用来定义一个模块
        + 可以保存在一个文件中，使用layui.use来引入它
        + 定义这个模块时可以依赖其他模块
        @ layui.use

    tips
        + layui默认模块依赖jQuery(如layer), 但是你并不用去额外加载jQuery
        + Layui已经将jQuery最稳定的版本改为Layui的内部模块
        + 当你使用layer之类的模块时，它会先判断你的页面是否引入了jQuery
        + 如果没有则加载内部的jQuery模块，如果有的话则不会加载
        + 另外，图标取材于阿里巴巴矢量图标库(iconfont)， 构建工具采用gulp。除此之外，不依赖于任何第三方工具
        + （如果你现在在ST中， 选择tips即可进入下一题）
    