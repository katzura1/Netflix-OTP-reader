@props([
'sender' => 'Netflix',
'time' => 'Just now',
'title' => 'Confirm your email address',
'statusDotColor' => 'bg-green-500',
'human_date' => ''
])

<div {{ $attributes->merge(['class' => 'bg-gray-50 border border-gray-200 rounded-md p-4 mb-2']) }}>
  <div class="flex items-center gap-2 mb-1">
    <span class="inline-block w-2 h-2 rounded-full {{ $statusDotColor }}"></span>
    <span class="font-medium text-gray-700">{!! $sender !!}</span>
    <span class="ml-auto text-xs text-gray-400">{{ $human_date }}</span>
  </div>
  <div class="text-gray-800 text-sm font-semibold">{{ $title }}</div>
  <div class="text-gray-600 text-xs mt-1">
    {{ $slot ?? "We’ve sent a confirmation link to your email address. Please check your inbox and click the link to
    continue." }}
  </div>
</div>