#!/usr/bin/env bash
wget -O sougoupinyin.deb http://cdn2.ime.sogou.com/dl/index/1524572264/sogoupinyin_2.2.0.0108_amd64.deb?st=kK9J8WWpnDZKwOW7-dc2xw&e=1553676731&fn=sogoupinyin_2.2.0.0108_amd64.deb;

if [[ -f sougoupinyin.deb ]]; then
    dpkg -i sougoupinyin.deb;
else
    echo 1;
fi;
