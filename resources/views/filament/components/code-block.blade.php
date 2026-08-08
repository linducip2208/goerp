<div class="bg-gray-900 text-gray-100 rounded-lg p-4 overflow-auto max-h-96">
    <pre class="text-xs font-mono whitespace-pre-wrap">{{ json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) }}</pre>
</div>
