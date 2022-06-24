<footer class="content-footer {{ session('theme') === 'dark' ? 'bg-dark' : '' }}">
    <div class="footer">
        <div class="copyright">
            <span>{{ __('Copyright') }} &copy; {{ date('Y') }} <strong class="text-dark">{{ config('app.name') }}</strong>.</span>
            <span class="go-right">
                <a href="#" class="text-gray px-1">{{ __('Terms') }} &amp; {{ __('Conditions') }}</a>
                <a href="#" class="text-gray px-1">{{ __('Privacy Policy') }}</a>
                <a href="#" class="text-gray px-1">{{ __('Version') }} {{ config('app.version') }}</a>
            </span>
        </div>
    </div>
</footer>