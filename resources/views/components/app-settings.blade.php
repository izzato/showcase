<script>
window.app = window.app || {};
app.auth = app.auth || {};
app.auth.user = app.auth.user || {};
app.auth.user.settings = app.auth.user.settings || {};
app.settings = {"locale":"{{ session('locale') }}","theme":"{{ session('theme') }}","timezone":"{{ session('timezone') }}"};
</script>