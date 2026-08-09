# Southnight.wiki

南夜维基（Southnight.wiki）官网源码与 Laravel 动态化备份。

## 目录

- 根目录：迁移前静态 UI 回退版本（GitHub Pages 源码）
- `laravel-next/`：生产 Laravel 13 应用源码（不含 `.env`、SQLite、vendor、日志和密钥）

## 生产部署

正式站点运行于 AWS EC2，使用 Nginx、PHP-FPM、Laravel 和 SQLite。Cloudflare 负责 DNS、CDN 与 HTTPS；`dynamic.southnight.uk` 保留为旧动态中心兼容入口。
