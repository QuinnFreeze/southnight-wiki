# Cloudflare Turnstile 安全规范

SouthNight 的人机验证采用 Cloudflare Turnstile，并且**必须在服务端**调用 Siteverify 校验；仅显示前端组件不构成保护。

## 现有基础设施

- Blade 组件：`<x-turnstile action="..." />`
- 路由中间件：`turnstile:<action>`
- 服务端校验：`App\Support\TurnstileVerifier`
- 验证规则：`App\Rules\TurnstileToken`
- 配置：`config/services.php` 的 `turnstile` 段

## 新增重要写操作时的要求

对登录、注册、修改资料、修改密码、权限变更、发布/编辑/删除内容，以及任何会改变账户、权限、公开内容或敏感配置的路由：

1. 在对应表单中加入与路由相同 action 的组件：

   ```blade
   <x-turnstile action="account-password" appearance="interaction-only" />
   ```

   登录和注册建议保持默认 `appearance="always"`；后台和已登录敏感操作可用 `interaction-only`，只有需要交互挑战时才显示组件。

2. 在对应的**非 GET**路由上启用中间件：

   ```php
   Route::put('/account/password', [AuthController::class, 'updatePassword'])
       ->middleware('turnstile:account-password');
   ```

3. action 名称必须前后完全一致。服务端会检查 Turnstile 响应中的 action 与 hostname。
4. 不要把 `TURNSTILE_SECRET_KEY` 写入代码、Git、前端或日志。只保存在生产 `.env`。
5. 新增受保护表单时，至少测试：缺失 token 被拒绝、有效 token 可通过、action 不匹配被拒绝。

## 环境变量

```dotenv
TURNSTILE_SITE_KEY=
TURNSTILE_SECRET_KEY=
TURNSTILE_ALLOWED_HOSTNAMES=southnight.uk,www.southnight.uk
```

Token 仅可使用一次，5 分钟后过期。服务端出现网络错误或 Cloudflare 返回失败时，应默认拒绝请求（fail closed）。
