<html>
    <div class="text-lg font-semibold mb-3">Chọn Theme</div>
    <select id="themeSelect" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:border-purple-600" onchange="changeTheme()">
        <option value="theme-default" {{ session('theme') == 'theme-default' ? 'selected' : '' }}>Default Theme</option>
        <option value="theme-dark" {{ session('theme') == 'theme-dark' ? 'selected' : '' }}>Dark Theme</option>
        <option value="theme-light" {{ session('theme') == 'theme-light' ? 'selected' : '' }}>Light Theme</option>
        <option value="theme-colorful" {{ session('theme') == 'theme-colorful' ? 'selected' : '' }}>Colorful Theme</option>
    </select>
    <div class="mt-4">
        <a href="{{ route('showpricing') }}" class="text-lg no-underline font-semibold mb-3 hover:text-indigo-500">Thành Viên</a>
    </div>
</html>
