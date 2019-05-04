~ grid布局 ~
# 概念(名词)
    Grid Contaner (网格容器)
        + 元素应用display: grid; 它就是所有网格项的父元素

    Grid Item (网格项)
        + 网格容器的子元素都是网格项

    Grid Line (网格线)
        + 组成网格项的分界线

    Grid Track (网格轨道)
        + 两个相邻网格线之间的块为网格轨道

    Grid Cell (网格单元)
        + 两个相邻的列网格线和两个相邻的行网格线组成的是网格单元

    Grid Area (网格区域)
        + 四条网格线包围的总空间

    fr单位
        + 剩余空间分配数。用于在一系列长度值中分配剩余空间，如果多个已指定了多个部分，则剩下的空间根据各自的数字按比例分配

    display
        + 当元素设置了网格布局，clear、float、column、vertical-align等属性会无效

    grid
        + 块级网格

    inline-grid
        + 行内网格

    subgrid
        + 如果网格容器本身是网格项，可以继承父容器的属性
        + 目前所有的浏览器都不兼容

# 属性
    display
        grid > 开启grid布局
        inline-grid > 行内grid布局
        + 在css3中设置display为grid以启用grid布局

    grid-template-columns
        repeat int> 重复多少次，每个多大
        + 每个参数表示一个列
        @ grid-template, grid-tempalte-rows, grid-template-area

    grid-template-rows
        repeat int> 重复多少次，每个多大
        + 每个参数表示一个列
        @ grid-template, grid-tempalte-columns, grid-template-area

    grid-tempalte
        + grid-template-columns和grid-template-rows的缩写, 使用 / 作为分隔
        @ grid-template-rows, grid-tempalte-columns, grid-template-area

    grid-template-gap
        + 单元格间隔大小

    justify-content
        center > 居中对齐
        start > 靠左对齐
        end > 靠右对齐
        space-evenly > 中间使用空白隔开
        + 调整整个网格的对齐方式

    justify-items
        center > 居中对齐
        start > 靠左对齐
        end > 靠右对齐
        + 调整网格项内容的左右对其方式