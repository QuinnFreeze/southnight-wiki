@props(['action', 'appearance' => 'always'])
@php($siteKey=config('services.turnstile.site_key'))
@if($siteKey)
    <div class="turnstile-slot{{ $appearance === 'interaction-only' ? ' turnstile-slot-deferred' : '' }}">
        <div class="turnstile-wrap" data-turnstile-action="{{ $action }}">
            <div class="cf-turnstile" data-sitekey="{{ $siteKey }}" data-action="{{ $action }}" data-appearance="{{ $appearance }}" data-size="flexible" data-theme="dark" data-language="auto"></div>
        </div>
    </div>
    @once
        @push('scripts')
            <script>(()=>{const compact=()=>{if(window.innerWidth>360)return;document.querySelectorAll('.cf-turnstile').forEach(widget=>widget.dataset.size='compact')};compact()})();</script>
            <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
        @endpush
    @endonce
@else
    <p class="turnstile-unavailable" role="alert" data-zh="人机验证暂不可用，请稍后再试。" data-en="Verification is temporarily unavailable. Please try again later.">人机验证暂不可用，请稍后再试。</p>
@endif
