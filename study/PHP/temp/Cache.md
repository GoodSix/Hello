## 常用方法
Cache::
- 添加
    - `put('key', 'value', 'expire')`       添加一个缓存
    - `add('key', 'value', 'expire')`       如果该key已存在不会重复添加
    - `forever('key', 'value')`             在手动删除之前，长期存在
- 删除
    - `forget('key')`                       获取该缓存
    - `pull('key')`                         获取并删除该缓存
- 检测
    - `has('key')`                          检测该缓存是否