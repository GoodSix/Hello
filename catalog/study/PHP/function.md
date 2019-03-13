[首页](../../../README.md)
[秃头之旅](../index.md)
---

| 函数 | 作用 | 说明/技巧 |
|---|---|---|
| 文本函数 |  |
| trim | 删除字符串两端的空格或其他预定义字符 | 默认去除换行符或空格等，参数2可定义该字符 |
| rtrim | 删除字符串右边的空格或其他预定义字符 | 默认去除换行符或空格等，参数2可定义该字符 |
| ltrim | 删除字符串左边的空格或其他预定义字符 | 默认去除换行符或空格等，参数2可定义该字符 |
| chop | rtrim的别名，删除字符串右边的空格或其他预定义字符 | 默认去除换行符或空格等，参数2可定义该字符 |
| str_pad | 将字符串填充为指定的长度 | 参数1为字符串；参数2为填充的长度，默认使用空格；【参数3制定填充的字符; 参数4可选STR_PAD_LEFT左边填充，STR_PAD_RIGHT右边填充，STR_PAD_BOTH左右填充，默认STR_PAD_RIGHT右边填充】 |
| str_repeat | 重复使用指定的字符串 | 无 |
| str_split | 把字符串分割到数组中 | 将字符串按照规定的长度分割为数组，【默认是一个】 |
| strrev | 反转字符串 | 例如hello反转后变为olleh |
| wordwrap | 按照指定长度对字符串进行折行处理 | 参数1为字符串；【参数2为折行处理，默认75，参数3可定义换行符，参数4指定是否强制在参数2处分割】 |
| str_shuffle | 随机地打乱字符串顺序 | 无 |
| parse_str | 将字符串解析成变量 | 对字符串进行解析，如a=5将被解析为$a="5"，该函数没有返回值，解析完成后可使用解析后的变量 |
| number_format | 通过千分位组来格式化数字 | 参数1为该数字；【参数2可选保留小数位置】 |
| strtolower | 字符串转换为小写 | 将大写字符串转换为小写的字符串 |
| strtoupper | 字符串转换为大写 | 将小写字符串转换为大写的字符串 |
| ucfirst | 字符串首字母转成大写 | 例如hello world会转为Hello world |
| ucwords | 字符串每个单词首字母转为大写 | 例如hello world会转为Hello World |
| htmlentities | 把字符转为html实体 | 本函数各方面都和 htmlspecialchars() 一样， 除了 htmlentities() 会转换所有具有 HTML 实体的字符 |
| htmlspecialchars | 预定义字符穿html编码 | 某类字符在 HTML 中有特殊用处，如需保持原意，需要用 HTML 实体来表达。 本函数会返回字符转义后的表达。 如需转换子字符串中所有关联的名称实体，使用 htmlentities() 代替本函数 |
| html_entity_decode | 将html实体转换为html标签 | 将htmlentities转换的实体反转回去 |
| nl2br | \n转义为<br>标签 | 将文本中的系统换行符转换为<br>标签 |
| strip_tags | 剥去HTML、XML、以及PHP的标签 | 无 |
| addcslashes | 在指定的字符前添加反斜线转义符 | 注意不要和addslashes搞混了，带c的是转换指定预定义，不带c的是转换特殊字符 |
| stripcslashes | 删除由addcslashes添加的转义符 | addcslashes可以在指定的预定义字符前加转义符号，此函数可以将转义符号去掉 |
| addslashes | 指定预定义字符前添加反斜线 | 这个函数长得和addcslashes有点像，注意不要搞混，此函数是在*预定义字符*前添加转移符 |
| stripslashes | 删除由addslashes添加的转义符 | 此函数于stripcslashes类似 |
| quotemeta | 在字符串中某些预定义字符前添加转义符 | 例如'&', '*'等符号前添加反斜线 |
| chr | 从指定的ASCII值返回字符串 | 解析ASCII码 |
| ord | 返回字符串第一个字符的ASCII码 | 返回该字符的ASCII值 |
| 