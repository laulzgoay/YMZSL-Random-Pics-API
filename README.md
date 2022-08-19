# YMZSL-Random-Pics-API

<p align="center">
<img src="./Screenshot.png">
</p> 

![PHP](https://img.shields.io/badge/php-%3E%3D5.6-blue)
![GitHub code size in bytes](https://img.shields.io/github/languages/code-size/laulzgoay/YMZSL-Random-Pics-API.svg)
![License](https://img.shields.io/github/license/laulzgoay/YMZSL-Random-Pics-API?color=%234c1)

## Info
### Version:1.0.0
### ForPHP:5.6+
### Origin Author:倾丞(Jochen)/瑾忆(自醉)
### Author Url:https://blog.qcmoe.com
### Secondary Development Author:小俊(LaulzGoay)
### Secondary Development Author Url:https://www.smalljun.com
### 此外感谢榆木大佬在我修改源码时提供的帮助！再次感谢！

## About

一款使用随机链接实现的随机图片API源码，支持本地与外链存储图片 🎉

## Structure
在下载中，您将找到以下目录和文件  你会看到这样的东西 👇

```
YMZSL-Random-Pics-API
│  count.txt
│  imgs.txt
│  index.html
│  list.txt
│  randpic.php
│  README.md
│  Screenhost.png
│  
└─statics
        bootstrap.min.css
        favicon.ico
        jquery.cookie.min.js
        jquery.min.js
        main.css
```

## Changelog
每个版本的详细更改记录在 [release notes](https://github.com/laulzgoay/YMZSL-Random-Pics-API/releases).

## License

The code is available under the [GPL-3.0](https://github.com/laulzgoay/YMZSL-Random-Pics-API/blob/master/LICENSE) license.

The document is licensed under a [Creative Commons Attribution-NonCommercial-NoDerivatives 4.0 International License](http://creativecommons.org/licenses/by-nc-nd/4.0/).

## Use 
### 调用地址：https://www.Your-API-Domain.com/pic/randpic.php
##### 调用参数:return = http / https / url / json / img / xml / base64Code / base64Img
###### json：返回标准json数据(图片地址)
###### url：直接返回图片链接
###### img：直接显示图片不返回图片链接
###### http: 返回HTTP图片链接
###### https: 返回HTTPS图片链接
###### xml: 返回标准XML数据(图片地址)
###### base64Code：返回标准Base64图码数据
###### base64Img：返回标准Base64图片

