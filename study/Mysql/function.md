# Mysql操作 #
| 操作 | 作用 | 说明 |
|---|---|---|
| 角色管理 |  |  |
| set password for 'root'@'127.0.0.1' = password('root'); | 将IP为127.0.0.1的root管理员没密码设置为root(注意空格和分号) | 设置/修改密码 |
| set password = password('123123'); | 把当前管理员的密码修改为123123(注意空格和分号) | 修改当前管理员可以省略管理员名字和IP |
| create user 'demo'@'127.0.0.1' identified by 'demo'; | 创建一个名字为'demo',限制IP为'127.0.0.1'的管理员，密码为'demo'。(注意空格和分号) | 创建一个管理员，%为IP通配符 |
| grant all privileges on test.* to 'demo'@'%' identified by 'demo' with grant option; | 创建一个可以管理test数据库下所有表的demo用户，不限制IP，密码为'demo'的管理员 | 远程连接 |
| grant delete on test.* to 'demo'@'127.0.0.1' | 为127.0.0.1下的demo管理员增加对test库下所有表的删除权限 | 增加权限 |
| revoke delete on test.* to 'demo'@'127.0.0.1' | 删除127.0.0.1下的demo管理员对test库下所有表的删除权限 | 删除权限 |
| drop user 'demo'@'127.0.0.1' | 删除127.0.0.1下的demo管理员 | 删除管理员 |
| 备份和还原 |  |  |
| mysqldump -uroot -proot --all-databases > all.sql | 备份所有数据库到all.sql(账号密码为root) | 备份所有数据库 |
| mysqldump -uroot -proot demo > demo.sql | 备份demo数据库到demo.sql | 备份单个数据库 |
| mysqldump -uroot -proot demo test > dtest.sql | 备份demo数据库下的test表到dtest.sql | 备份指定数据库下的指定表 |
| mysql -uroot -proot demo < demo.sql | 在命令行将demo.sql导入到demo库 | 注意：导入的库必须是空的 |
| source all.sql | 在mysql中执行all.sql脚本 | 执行sql脚本 |
| truncate demo | 重置demo数据表。删除所有数据，包括主键等都会被重置 | 重置数据表 |
| select * from demo into outfile '/home/demo.excel' fields terminated by ',' optionnally enclosed by '\' lines terminated by '\r\n'; | 选择demo表下所有内容导出到'/home/demo.excel'，每个字段使用','隔开，特殊符号使用'\'转义，换行符使用'\r\n'; | 注意导出的路径必须在mysql配置文件`show variables like %secure_file_priv%`下 |
| load data infile '/home/demo.excel' into table demo professions fields terminated by ',' optionally enclosed by '\' lines terminated by '\r\n'; | 将/home/demo.excel导入到demo表中，分隔符为',',特殊符号转义符为'\',换行符为'\r\n' | 将excel数据导入到数据库中 |
