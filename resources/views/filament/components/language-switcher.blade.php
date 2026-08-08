<div class="flex items-center gap-1 px-2">
    <a href="{{ route('locale.switch', 'id') }}" class="px-2 py-1 text-xs rounded {{ app()->getLocale() === 'id' ? 'bg-indigo-100 text-indigo-700 font-semibold' : 'text-gray-500 hover:text-gray-700' }}">ID</a>
    <a href="{{ route('locale.switch', 'en') }}" class="px-2 py-1 text-xs rounded {{ app()->getLocale() === 'en' ? 'bg-indigo-100 text-indigo-700 font-semibold' : 'text-gray-500 hover:text-gray-700' }}">EN</a>
</div>
