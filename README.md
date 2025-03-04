# e-campus-login

易校园的模拟登录实现。可集成至校园论坛、校园助手等应用中。

## 声明

1. 本项目仅供学习交流使用，如作他用甚至进行非法行为，其所承受的任何直接与间接法律责任均与作者与本组织无关。
2. 如果此项目侵犯了您或者您公司的权益，请联系作者删除。

## 许可协议

你应遵守协议内容，不得将本项目用于非法用途。

- [AGPL-3.0](https://www.gnu.org/licenses/agpl-3.0.html)

```
Copyright (C) 2025 FoskyM<i@fosky.top>

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU Affero General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU Affero General Public License for more details.

You should have received a copy of the GNU Affero General Public License
along with this program.  If not, see <https://www.gnu.org/licenses/>.
```

## 描述
登录后得到 `ymId`(传参时用此名，接口返回字段为 `id`) 和 `token`，即可访问易校园的其它接口。
这里因为精力有限只做了登录部分，就当是抛砖引玉一下。

## 安装

```shell
composer require foskytech/e-campus-login
```

## 示例

见 [example](/example)