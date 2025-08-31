@props([
'sender' => 'Netflix',
'time' => 'Just now',
'title' => 'Confirm your email address',
'statusDotColor' => 'bg-green-500',
'human_date' => ''
])

<div {{ $attributes->merge(['class' => 'bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700
  rounded-md p-4 mb-2 transition-colors duration-150 hover:bg-white dark:hover:bg-gray-700']) }}>
  <div class="flex items-start sm:items-center gap-2 mb-1 flex-wrap sm:flex-nowrap min-w-0">
    <span class="inline-block w-2 h-2 rounded-full {{ $statusDotColor }} mt-1 sm:mt-0"></span>
    <span class="font-medium text-gray-700 dark:text-gray-200 block truncate max-w-[65%] sm:max-w-[50%]" title="{{ strip_tags($sender) }}">{!! $sender !!}</span>
    <span class="ml-auto text-xs text-gray-400 dark:text-gray-400">{{ $human_date }}</span>
  </div>
  <div class="text-gray-800 dark:text-gray-100 text-sm font-semibold break-words">{{ $title }}</div>
  <div class="text-gray-600 dark:text-gray-300 text-xs mt-1 break-words">
    {{ $slot ?? "We’ve sent a confirmation link to your email address. Please check your inbox and click the link to
    continue." }}
  </div>
</div>