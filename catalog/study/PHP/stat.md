| 数字下标 | 关联键名（自PHP4.0.6） | 说明 |
| --- | --- | --- |
| 0 | dev | device number - 设备名 |
| 1 | ino | inode number - inode 号码 |
| 2 | mode | inode protection mode - inode 保护模式 |
| 3 | nlink | number of links - 被连接数目 |
| 4 | uid | userid of owner - 所有者的用户 id |
| 5 | gid | groupid of owner- 所有者的组 id |
| 6 | rdev | device type, if inode device * - 设备类型，如果是 inode 设备的话 |
| 7 | size | size in bytes - 文件大小的字节数 |
| 8 | atime | time of last access (unix timestamp) - 上次访问时间（Unix 时间戳） |
| 9 | mtime | time of last modification (unix timestamp) - 上次修改时间（Unix 时间戳） |
| 10 | ctime | time of last change (unix timestamp) - 上次改变时间（Unix 时间戳） |
| 11 | blksize | blocksize of filesystem IO * - 文件系统 IO 的块大小 |
| 12 | blocks | number of blocks allocated - 所占据块的数目 |