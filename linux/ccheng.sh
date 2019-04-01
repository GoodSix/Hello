#!/usr/bin/env bash
:<<EOF
    script by
    github:         GoodSix
    google email:   my4cheng@gmail.com
    qq email:       1434389213@qq.com
EOF

# 工具包目录
help='help';

if [[ $# -lt 1 ]]; then
    echo "您可以输入您的问题，我们会自动搜索对应的帮助。";
    echo "使用方式为${0} \"您的问题\"";
    exit;
elif ! [[ -r ${help} ]]; then
    echo "哦，我的工具包找不到了!";
    echo "帮我看看我的工具包${help}文件夹在不在我的身旁好吗(ㄒoㄒ)";
    echo "如果存在的话能给我个权限访问吗";
    echo "搞不定的话你可以联系下 my4cheng@gmail.com 或 1434389213@qq.com帮助你解决哦n(*≧▽≦*)n";
    exit;
else
    ls=`ls ${help} | grep $1`;
    if ! [[ ${ls} ]]; then
        ls=`ls ${help}`;
        echo "没有找到您需要的东西，但是我可以帮助您：";
    fi;
    i=0;
    com='';
    for l in ${ls}; do
        echo "${i}  ${l}";
        com[${i}]=${l};
        ((i++));
    done;

    read -p "请输入您需要执行操作的编号：" in ;

    com="${com[${in}]}";
    if [[ ${com} ]]; then
        com="${help}/${com[${in}]}/index.sh";
        source ${com};
    else
        echo "无法执行此操作";
        exit 1;
    fi;

    unset com;
    unset in;
    unset ls;
fi;

unset help;