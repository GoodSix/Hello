[首页](../../README.md)
[快捷键](./keymap.md)
---

```json
{
	"workbench.startupEditor": "newUntitledFile",
	"workbench.activityBar.visible": false,
	"editor.fontFamily": "Menlo, Consolas, 'Courier New', monospace",
	"editor.fontSize": 15,
	"editor.lineHeight": 22,
	"workbench.colorTheme": "Darcula - WebStorm Edition",
	"editor.tokenColorCustomizations": {
		"textMateRules": [
			{
				"name": "Comments",
				"scope": "comment, punctuation.definition.comment",
				"settings": {
					"fontStyle": ""
				}
			},
			{
				"name": "js/ts italic",
				"scope": "entity.other.attribute-name.js,entity.other.attribute-name.ts,entity.other.attribute-name.jsx,entity.other.attribute-name.tsx,variable.parameter,variable.language.super",
				"settings": {
					"fontStyle": ""
				}
			},
			{
				"name": "js ts this",
				"scope": "var.this,variable.language.this.js,variable.language.this.ts,variable.language.this.jsx,variable.language.this.tsx",
				"settings": {
					"fontStyle": ""
				}
			}
		]
	},
    "editor.detectIndentation": false,
	"editor.insertSpaces": false,
	"editor.tabCompletion": "on",
	"editor.formatOnType": true,
	"workbench.statusBar.feedback.visible": false,
	"window.menuBarVisibility": "toggle",
	"explorer.autoReveal": false,
	"workbench.iconTheme": "webstorm-icons",
	"window.zoomLevel": 0,
	"breadcrumbs.enabled": true,
	"files.associations": {
		"*.kotlin": "kotlin"
	},
	"extensions.ignoreRecommendations": true,
	"files.eol": "\n"
}
```

配合插件食用，效果更佳  
`Chinese (Simplified) Language Pack for Visual Studio Code`  中文语言包  

`Darcula Theme - WebStorm Edition`  idea 的darkula主题  

`markdownlint`  增强markdown

`Webstorm Icon Theme`  图标主题  
  
*我的PHP*  
`PHP Debug`  需要先开启php的debug插件(开启远程调试需要注意下，这个插件默认监听的是9000端口，会和php-fpm冲突，建议9001)
  
`PHP Extension Pack` php包扩展  

`PHP Intelephense` php插件  