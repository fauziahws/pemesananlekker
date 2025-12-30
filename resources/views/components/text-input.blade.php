@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-gray-300 focus:border-[#7B542F] focus:ring-[#7B542F] rounded-md shadow-sm']) }}>
