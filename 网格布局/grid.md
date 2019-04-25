# 概念
Grid Contaner (网格容器)  
    元素应用display: grid; 它就是所有网格项的父元素

Grid Item (网格项)  
    网格容器的子元素都是网格项

Grid Line (网格线)  
    组成网格项的分界线

Grid Track (网格轨道)  
    两个相邻网格线之间的块为网格轨道

Grid Cell (网格单元)  
    两个相邻的列网格线和两个相邻的行网格线组成的是网格单元

Grid Area (网格区域)  
    四条网格线包围的总空间

fr单位  
    剩余空间分配数。用于在一系列长度值中分配剩余空间，如果多个已指定了多个部分，则剩下的空间根据各自的数字按比例分配

display  
    当元素设置了网格布局，clear、float、column、vertical-align等属性会无效
    
grid  
    块级网格
    
inline-grid  
    行内网格
    
subgrid
    如果网格容器本身是网格项，可以继承父容器的属性
    目前所有的浏览器都不兼容

# 属性
grid-template-columns  
    定义网格行，一个值表示一个网格项
    
grid-template-rows  
    定义网格列，一个值表示一个网格项
    
grid-template-areas  
    网格区域
    
grid-area  
    定义网格区域名称
    
grid-column-gap  
    设置网格行的间隙
    
grid-row-gap  
    设置网格列的间隙
    
grid-gap  
    设置网格间隙，第一个参数是行，第二个是列，目前已经被gap取代